<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class GenerateApiDocs extends Command
{
    protected $signature = 'docs:generate-api';
    protected $description = 'Generate API documentation as .docx';

    public function handle(): void
    {
        $phpWord = new PhpWord();
        $phpWord->setDefaultFontName('Calibri');
        $phpWord->setDefaultFontSize(11);

        $section = $phpWord->addSection([
            'marginTop' => 1440,
            'marginLeft' => 1440,
            'marginRight' => 1440,
            'marginBottom' => 1440,
        ]);

        // Title
        $section->addTitle('Rose Venus API Documentation', 1);
        $section->addText('Base URL: http://localhost:8000/api', ['size' => 11, 'color' => '666666']);
        $section->addTextBreak(1);

        // Authentication
        $section->addTitle('Authentication', 2);
        $this->addEndpoint($section, 'POST', '/api/register', 'Register a new user account', [
            ['name', 'required|string|max:255'],
            ['email', 'required|email|unique:users'],
            ['password', 'required|string|min:8'],
            ['password_confirmation', 'required|string|same:password'],
        ], ['user', 'token']);

        $this->addEndpoint($section, 'POST', '/api/login', 'Login and receive an API token', [
            ['email', 'required|email'],
            ['password', 'required|string'],
        ], ['user', 'token']);

        $this->addEndpoint($section, 'POST', '/api/logout', 'Logout and revoke current token', [], ['message'], 'auth:sanctum');

        $this->addEndpoint($section, 'GET', '/api/user', 'Get authenticated user profile', [], ['id', 'name', 'email', 'role'], 'auth:sanctum');

        // Categories
        $section->addTitle('Categories', 2);
        $this->addEndpoint($section, 'GET', '/api/categories', 'List all active categories with product count', [], ['id', 'name', 'slug', 'description', 'image', 'active_products_count']);

        // Products
        $section->addTitle('Products', 2);
        $this->addEndpoint($section, 'GET', '/api/products', 'List active products with filtering and sorting', [
            ['search', 'optional|string|Search by name/description'],
            ['category_id', 'optional|integer|Filter by category'],
            ['min_price', 'optional|numeric|Minimum price filter'],
            ['max_price', 'optional|numeric|Maximum price filter'],
            ['sort', 'optional|string|Sort: latest, price_asc, price_desc, name'],
            ['per_page', 'optional|integer|Items per page (default: 12)'],
        ], ['data', 'meta']);

        $this->addEndpoint($section, 'GET', '/api/products/{product}', 'Get single product with related products and reviews', [], ['product', 'related']);

        // Cart
        $section->addTitle('Cart', 2);
        $section->addText('All cart endpoints require authentication (Bearer token).', ['italic' => true, 'color' => '666666']);
        $section->addTextBreak(1);

        $this->addEndpoint($section, 'GET', '/api/cart', 'Get current user cart items and total', [], ['items', 'total'], 'auth:sanctum');

        $this->addEndpoint($section, 'POST', '/api/cart', 'Add item to cart', [
            ['product_id', 'required|integer|exists:products,id'],
            ['quantity', 'required|integer|min:1|max:99'],
        ], ['message', 'item'], 'auth:sanctum');

        $this->addEndpoint($section, 'PATCH', '/api/cart/{cart}', 'Update cart item quantity', [
            ['quantity', 'required|integer|min:1|max:99'],
        ], ['message', 'item'], 'auth:sanctum', 'The cart ID from the cart index endpoint.');

        $this->addEndpoint($section, 'DELETE', '/api/cart/{cart}', 'Remove item from cart', [], ['message'], 'auth:sanctum');

        // Orders
        $section->addTitle('Orders', 2);
        $section->addText('All order endpoints require authentication (Bearer token).', ['italic' => true, 'color' => '666666']);
        $section->addTextBreak(1);

        $this->addEndpoint($section, 'GET', '/api/orders', 'List authenticated user orders with pagination', [], ['data', 'meta'], 'auth:sanctum');

        $this->addEndpoint($section, 'POST', '/api/orders', 'Place a new order from cart', [
            ['shipping_address', 'required|string|max:500'],
            ['phone', 'required|string|max:20'],
            ['notes', 'optional|string|max:1000'],
            ['coupon_code', 'optional|string|Apply coupon code'],
        ], ['message', 'order'], 'auth:sanctum');

        $this->addEndpoint($section, 'GET', '/api/orders/{order}', 'Get order detail with items', [], ['id', 'status', 'total', 'items'], 'auth:sanctum', 'Only the order owner can view.');

        $section->addTextBreak(2);

        // Authentication Info
        $section->addTitle('Authentication', 2);
        $section->addText('To authenticate, include the token in the Authorization header:');
        $section->addText('Authorization: Bearer {your-token}', ['bold' => true]);
        $section->addTextBreak(1);
        $section->addText('Tokens are obtained via POST /api/login or POST /api/register endpoints.');
        $section->addTextBreak(1);

        // Error Responses
        $section->addTitle('Error Responses', 2);
        $section->addText('All endpoints return standard HTTP status codes:');
        $section->addText('- 200: Success');
        $section->addText('- 201: Created');
        $section->addText('- 401: Unauthenticated');
        $section->addText('- 403: Forbidden');
        $section->addText('- 404: Not Found');
        $section->addText('- 422: Validation Error');
        $section->addText('- 500: Server Error');

        $filename = storage_path('app/api-documentation.docx');
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($filename);

        $this->info("API documentation generated: {$filename}");
    }

    private function addEndpoint($section, string $method, string $uri, string $description, array $params, array $responses, ?string $auth = null, ?string $notes = null): void
    {
        $section->addTitle("{$method} {$uri}", 3);

        if ($auth) {
            $section->addText("🔒 {$auth}", ['size' => 10, 'color' => 'CC0000']);
        }

        $section->addText($description, ['size' => 11]);
        $section->addTextBreak(1);

        if (!empty($params)) {
            $section->addText('Parameters:', ['bold' => true, 'size' => 11]);
            $table = $section->addTable(['borderSize' => 6, 'borderColor' => 'CCCCCC', 'cellMargin' => 80]);
            $table->addRow();
            $table->addCell(2500)->addText('Parameter', ['bold' => true]);
            $table->addCell(6000)->addText('Description', ['bold' => true]);

            foreach ($params as $param) {
                $table->addRow();
                $table->addCell()->addText($param[0], ['size' => 10]);
                $table->addCell()->addText($param[1], ['size' => 10]);
            }
            $section->addTextBreak(1);
        }

        if (!empty($responses)) {
            $section->addText('Response fields:', ['bold' => true, 'size' => 11]);
            $section->addText(implode(', ', $responses), ['size' => 10, 'color' => '444444']);
        }

        if ($notes) {
            $section->addText($notes, ['size' => 10, 'italic' => true, 'color' => '666666']);
        }

        $section->addTextBreak(1);
    }
}
