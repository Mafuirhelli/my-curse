<?php

namespace Database\Seeders;

use App\Models\Discount;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DiscountsSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();

        $discounts = [
            [
                'product_id' => $products->where('name', 'Тонкоцу Рамен')->first()->id,
                'discount_percent' => 15.00,
                'start_date' => Carbon::now()->subDays(2),
                'end_date' => Carbon::now()->addDays(7),
                'is_active' => true,
            ],
            [
                'product_id' => $products->where('name', 'Пилк')->first()->id,
                'discount_percent' => 20.00,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDays(14),
                'is_active' => true,
            ],
            [
                'product_id' => $products->where('name', 'Гюдан')->first()->id,
                'discount_percent' => 10.00,
                'start_date' => Carbon::now()->subDays(1),
                'end_date' => Carbon::now()->addDays(5),
                'is_active' => true,
            ],
        ];

        foreach ($discounts as $discount) {
            Discount::create($discount);
        }

        $this->command->info('Создано ' . count($discounts) . ' акционных предложений!');
    }
}
