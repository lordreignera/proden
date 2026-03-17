<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminPassword = env('ADMIN_SEED_PASSWORD', '@dmin2@@2');

        // Create admin user
        User::updateOrCreate(
            ['email' => 'admin@pruden.com'],
            [
                'name' => 'Admin Pruden',
                'password' => Hash::make($adminPassword),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Create product categories for Proden's current range
        $categories = [
            [
                'name' => 'Ready to Drink',
                'slug' => 'ready-to-drink',
                'description' => 'Ready-to-drink Hibiscus beverages',
            ],
            [
                'name' => 'Concentrates',
                'slug' => 'concentrates',
                'description' => 'Hibiscus and Passion concentrates (dilute before drinking)',
            ],
            [
                'name' => 'Herbal Tea',
                'slug' => 'herbal-tea',
                'description' => 'Dried Hibiscus petals for herbal tea',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }

        $categoryIds = Category::whereIn('slug', array_column($categories, 'slug'))
            ->pluck('id', 'slug');

        // Create Proden product catalogue with UGX pricing
        $products = [
            [
                'category_slug' => 'ready-to-drink',
                'name' => 'Hibiscus Drink 300ml',
                'slug' => 'hibiscus-drink-300ml',
                'description' => 'Non-carbonated Hibiscus drink. Carton of 12 bottles (300ml each).',
                'price' => 24000,
                'unit' => 'carton',
                'image' => '300.jpeg',
                'stock' => 120,
                'is_active' => true,
            ],
            [
                'category_slug' => 'ready-to-drink',
                'name' => 'Hibiscus Drink 500ml',
                'slug' => 'hibiscus-drink-500ml',
                'description' => 'Non-carbonated Hibiscus drink. Carton of 12 bottles (500ml each).',
                'price' => 30000,
                'unit' => 'carton',
                'image' => '300.jpeg',
                'stock' => 100,
                'is_active' => true,
            ],
            [
                'category_slug' => 'ready-to-drink',
                'name' => 'Sugar-Free Hibiscus 5L',
                'slug' => 'sugar-free-hibiscus-5l',
                'description' => 'Sugar-free ready-to-drink Hibiscus beverage in 5L container.',
                'price' => 25000,
                'unit' => 'jerry_can',
                'image' => '5liters.jpeg',
                'stock' => 60,
                'is_active' => true,
            ],
            [
                'category_slug' => 'concentrates',
                'name' => 'Hibiscus Concentrate 1L',
                'slug' => 'hibiscus-concentrate-1l',
                'description' => 'Hibiscus concentrate in 1L jerrycan. Dilute 1:2 to make 3L.',
                'price' => 10000,
                'unit' => 'liter',
                'image' => 'concetrate.jpeg',
                'stock' => 80,
                'is_active' => true,
            ],
            [
                'category_slug' => 'concentrates',
                'name' => 'Hibiscus Concentrate 5L',
                'slug' => 'hibiscus-concentrate-5l',
                'description' => 'Hibiscus concentrate in 5L jerrycan. Dilute 1:2 to make 15L.',
                'price' => 50000,
                'unit' => 'jerry_can',
                'image' => '5liters.jpeg',
                'stock' => 55,
                'is_active' => true,
            ],
            [
                'category_slug' => 'concentrates',
                'name' => 'Passion Concentrate 1L',
                'slug' => 'passion-concentrate-1l',
                'description' => 'Passion fruit concentrate in 1L jerrycan. Dilute 1:2 to make 3L.',
                'price' => 20000,
                'unit' => 'liter',
                'image' => 'concetrate.jpeg',
                'stock' => 40,
                'is_active' => true,
            ],
            [
                'category_slug' => 'herbal-tea',
                'name' => 'Hibiscus Petal Tea 200g',
                'slug' => 'hibiscus-petal-tea-200g',
                'description' => 'Whole dried Hibiscus petals for antioxidant-rich herbal tea.',
                'price' => 5000,
                'unit' => 'carton',
                'image' => 'product1.jpeg',
                'stock' => 70,
                'is_active' => true,
            ],
        ];

        $activeSlugs = [];
        foreach ($products as $product) {
            $categorySlug = $product['category_slug'];
            unset($product['category_slug']);
            $product['category_id'] = $categoryIds[$categorySlug];
            $activeSlugs[] = $product['slug'];

            Product::updateOrCreate(['slug' => $product['slug']], $product);
        }

        // Hide legacy sample items so shop matches the current catalogue.
        Product::whereNotIn('slug', $activeSlugs)->update(['is_active' => false]);

        $this->command->info('Admin seeder completed successfully!');
        $this->command->info('Admin Email: admin@pruden.com');
        $this->command->info('Admin Password: ' . $adminPassword);
        $this->command->warn('Please change the admin password after first login!');
    }
}
