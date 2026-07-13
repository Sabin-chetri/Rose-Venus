<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'description', 'ingredients',
        'price', 'sale_price', 'image', 'images', 'stock',
        'is_featured', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'images' => 'array',
            'price' => 'decimal:2',
            'sale_price' => 'decimal:2',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    public function wishlistedBy()
    {
        return $this->belongsToMany(User::class, Wishlist::class);
    }

    public function displayPrice(): string
    {
        if ($this->sale_price) {
            return 'Rp ' . number_format($this->sale_price, 0, ',', '.');
        }
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function hasSale(): bool
    {
        return !is_null($this->sale_price) && $this->sale_price < $this->price;
    }

    public function getImageUrlAttribute(): string
    {
        if (!$this->image) {
            return '';
        }
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        return Storage::url($this->image);
    }

    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }
}
