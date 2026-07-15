<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class ProductRecommender
{
    protected array $stopWords = [
        'the', 'a', 'an', 'and', 'or', 'but', 'in', 'on', 'at', 'to', 'for',
        'of', 'with', 'by', 'from', 'as', 'is', 'was', 'are', 'were', 'be',
        'been', 'being', 'have', 'has', 'had', 'do', 'does', 'did', 'will',
        'would', 'could', 'should', 'may', 'might', 'shall', 'can', 'need',
        'dare', 'ought', 'used', 'just', 'very', 'too', 'so', 'also',
    ];

    public function recommend(Product $product, int $limit = 4): Collection
    {
        $cacheKey = "product_recommendations_{$product->id}";

        return Cache::remember($cacheKey, 3600, function () use ($product, $limit) {
            $candidates = Product::with('category')
                ->where('id', '!=', $product->id)
                ->where('is_active', true)
                ->get();

            if ($candidates->isEmpty()) {
                return collect();
            }

            $targetVector = $this->buildTextVector($product);
            $corpus = $candidates->map(fn ($p) => $this->buildTextVector($p));

            $tfidf = $this->computeTfIdf($targetVector, $corpus);

            $scores = [];
            foreach ($candidates as $i => $candidate) {
                $similarity = $this->cosineSimilarity($tfidf['target'], $tfidf['candidates'][$i]);
                $scores[] = ['product' => $candidate, 'score' => $similarity];
            }

            usort($scores, fn ($a, $b) => $b['score'] <=> $a['score']);

            return collect(array_slice($scores, 0, $limit))->pluck('product');
        });
    }

    protected function buildTextVector(Product $product): string
    {
        $parts = [
            $product->name,
            $product->description,
            $product->ingredients ?? '',
            $product->brand ?? '',
            $product->category?->name ?? '',
        ];

        $text = mb_strtolower(implode(' ', $parts));
        $text = preg_replace('/[^a-z0-9\s]/', ' ', $text);
        $text = preg_replace('/\s+/', ' ', $text);

        return trim($text);
    }

    protected function tokenize(string $text): array
    {
        $tokens = explode(' ', trim($text));
        $tokens = array_filter($tokens, fn ($t) => mb_strlen($t) > 2);
        $tokens = array_diff($tokens, $this->stopWords);

        return array_values($tokens);
    }

    protected function computeTermFrequency(array $tokens): array
    {
        $total = count($tokens);
        $freq = array_count_values($tokens);

        return array_map(fn ($count) => $count / $total, $freq);
    }

    protected function computeTfIdf(string $targetText, Collection $corpusTexts): array
    {
        $targetTokens = $this->tokenize($targetText);
        $corpusTokens = $corpusTexts->map(fn ($t) => $this->tokenize($t))->toArray();

        $allTerms = array_unique(array_merge(
            $targetTokens,
            ...$corpusTokens
        ));

        $docCount = count($corpusTokens) + 1;
        $targetTf = $this->computeTermFrequency($targetTokens);

        $targetVector = [];
        foreach ($allTerms as $term) {
            $tf = $targetTf[$term] ?? 0;
            $df = 1;
            foreach ($corpusTokens as $tokens) {
                if (in_array($term, $tokens)) {
                    $df++;
                }
            }
            $idf = log($docCount / $df) + 1;
            $targetVector[$term] = $tf * $idf;
        }

        $corpusVectors = [];
        foreach ($corpusTokens as $tokens) {
            $tf = $this->computeTermFrequency($tokens);
            $vector = [];
            foreach ($allTerms as $term) {
                $t = $tf[$term] ?? 0;
                $df = 1;
                foreach ($corpusTokens as $ct) {
                    if (in_array($term, $ct)) {
                        $df++;
                    }
                }
                $idf = log($docCount / $df) + 1;
                $vector[$term] = $t * $idf;
            }
            $corpusVectors[] = $vector;
        }

        return [
            'target' => $targetVector,
            'candidates' => $corpusVectors,
        ];
    }

    protected function cosineSimilarity(array $a, array $b): float
    {
        $dotProduct = 0;
        $normA = 0;
        $normB = 0;

        foreach ($a as $key => $value) {
            $dotProduct += $value * ($b[$key] ?? 0);
            $normA += $value * $value;
        }

        foreach ($b as $value) {
            $normB += $value * $value;
        }

        $denominator = sqrt($normA) * sqrt($normB);

        if ($denominator === 0.0) {
            return 0.0;
        }

        return $dotProduct / $denominator;
    }
}
