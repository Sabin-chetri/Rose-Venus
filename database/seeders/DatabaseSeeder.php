<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Coupon;
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

        Category::create(['name' => 'Skincare', 'slug' => 'skincare', 'description' => 'Nourish and protect your skin with our natural formulations.']);
        Category::create(['name' => 'Makeup', 'slug' => 'makeup', 'description' => 'Enhance your natural beauty with our premium collection.']);
        Category::create(['name' => 'Fragrance', 'slug' => 'fragrance', 'description' => 'Captivating scents that leave a lasting impression.']);
        Category::create(['name' => 'Body Care', 'slug' => 'body-care', 'description' => 'Pamper your body with luxurious, natural care products.']);

        $this->call(ProductSeeder::class);

        Coupon::create(['code' => 'WELCOME10', 'type' => 'percent', 'value' => 10, 'min_order' => 50000, 'max_uses' => 100, 'is_active' => true]);
        Coupon::create(['code' => 'FLAT25000', 'type' => 'fixed', 'value' => 25000, 'min_order' => 100000, 'max_uses' => 50, 'is_active' => true]);
        Coupon::create(['code' => 'FREESHIP', 'type' => 'fixed', 'value' => 0, 'min_order' => 0, 'max_uses' => null, 'is_active' => false]);
    }
}
