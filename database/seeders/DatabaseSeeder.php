<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role' => User::ROLE_ADMIN,
        ]);

        User::factory()->create([
            'name' => 'Staff',
            'email' => 'staff@example.com',
            'role' => User::ROLE_STAFF,
        ]);

        User::factory()->create([
            'name' => 'Customer',
            'email' => 'customer@example.com',
            'role' => User::ROLE_CUSTOMER,
        ]);

        $skincare = Category::create(['name' => 'Skincare', 'slug' => 'skincare', 'description' => 'Nourish and protect your skin with our natural formulations.']);
        $makeup = Category::create(['name' => 'Makeup', 'slug' => 'makeup', 'description' => 'Enhance your natural beauty with our premium collection.']);
        $fragrance = Category::create(['name' => 'Fragrance', 'slug' => 'fragrance', 'description' => 'Captivating scents that leave a lasting impression.']);
        $bodycare = Category::create(['name' => 'Body Care', 'slug' => 'body-care', 'description' => 'Pamper your body with luxurious, natural care products.']);

        Product::create([
            'category_id' => $skincare->id,
            'name' => 'Rose Petal Elixir',
            'slug' => 'rose-petal-elixir',
            'description' => 'A luxurious lightweight serum infused with Damascus rose extract and hyaluronic acid. Unveil a complexion that radiates youth and vitality.',
            'ingredients' => 'Damascus rose extract, hyaluronic acid, vitamin C, squalane, aloe vera.',
            'price' => 85000,
            'sale_price' => 68000,
            'stock' => 50,
            'is_featured' => true,
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $makeup->id,
            'name' => 'Velvet Matte Lipstick',
            'slug' => 'velvet-matte-lipstick',
            'description' => 'Weightless matte lipstick with a velvety finish. Long-lasting formula enriched with shea butter for comfort.',
            'ingredients' => 'Shea butter, jojoba oil, vitamin E, natural pigments.',
            'price' => 45000,
            'stock' => 100,
            'is_featured' => true,
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $fragrance->id,
            'name' => 'Midnight Bloom',
            'slug' => 'midnight-bloom',
            'description' => 'An enchanting blend of night-blooming jasmine, vanilla orchid, and sandalwood. A fragrance that lingers beautifully.',
            'ingredients' => 'Jasmine absolute, vanilla orchid, sandalwood, amber, musk.',
            'price' => 120000,
            'stock' => 30,
            'is_featured' => true,
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $bodycare->id,
            'name' => 'Botanical Body Mist',
            'slug' => 'botanical-body-mist',
            'description' => 'A refreshing body mist with cucumber, green tea, and aloe. Lightweight hydration that leaves your skin feeling dewy and refreshed.',
            'ingredients' => 'Cucumber extract, green tea, aloe vera, glycerin, essential oils.',
            'price' => 55000,
            'stock' => 75,
            'is_featured' => true,
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $skincare->id,
            'name' => 'Radiance Face Cream',
            'slug' => 'radiance-face-cream',
            'description' => 'Rich yet lightweight moisturizer with vitamin B3 and peptides. Brightens, firms, and smooths for a youthful glow.',
            'ingredients' => 'Niacinamide, peptides, ceramides, squalane, rosehip oil.',
            'price' => 95000,
            'stock' => 40,
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $makeup->id,
            'name' => 'Luminous Foundation',
            'slug' => 'luminous-foundation',
            'description' => 'Buildable, medium-coverage foundation with a natural luminous finish. Infused with light-reflecting minerals.',
            'ingredients' => 'Mica, titanium dioxide, jojoba oil, vitamin E, silica.',
            'price' => 75000,
            'stock' => 60,
            'is_active' => true,
        ]);

        Coupon::create(['code' => 'WELCOME10', 'type' => 'percent', 'value' => 10, 'min_order' => 50000, 'max_uses' => 100, 'is_active' => true]);
        Coupon::create(['code' => 'FLAT25000', 'type' => 'fixed', 'value' => 25000, 'min_order' => 100000, 'max_uses' => 50, 'is_active' => true]);
        Coupon::create(['code' => 'FREESHIP', 'type' => 'fixed', 'value' => 0, 'min_order' => 0, 'max_uses' => null, 'is_active' => false]);
    }
}
