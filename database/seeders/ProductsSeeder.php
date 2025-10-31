<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Рамен
            [
                'name' => 'Тонкоцу Рамен',
                'description' => 'Классический рамен на свином бульоне с свиной грудинкой, яйцом и зеленым луком',
                'price' => 450.00,
                'category' => 'Рамен',
                'is_active' => true,
            ],
            [
                'name' => 'Мисо Рамен',
                'description' => 'Пикантный рамен с пастой мисо, курицей, кукурузой и ростками сои',
                'price' => 480.00,
                'category' => 'Рамен',
                'is_active' => true,
            ],
            [
                'name' => 'Шою Рамен',
                'description' => 'Легкий рамен на соевом соусе с ростками бамбука и нори',
                'price' => 420.00,
                'category' => 'Рамен',
                'is_active' => true,
            ],
            [
                'name' => 'Спайси Тантанмен',
                'description' => 'Острый рамен с фаршем, арахисом и кунжутным соусом',
                'price' => 490.00,
                'category' => 'Рамен',
                'is_active' => true,
            ],

            // Напитки
            [
                'name' => 'Пилк',
                'description' => 'Легендарный напиток - смесь Пепси и Молока',
                'price' => 150.00,
                'category' => 'Напитки',
                'is_active' => true,
            ],
            [
                'name' => 'Матча Латте',
                'description' => 'Традиционный японский зеленый чай с молоком',
                'price' => 280.00,
                'category' => 'Напитки',
                'is_active' => true,
            ],
            [
                'name' => 'Сакура Лимонад',
                'description' => 'Освежающий лимонад с сиропом сакуры',
                'price' => 220.00,
                'category' => 'Напитки',
                'is_active' => true,
            ],
            [
                'name' => 'Ягодный Мохито',
                'description' => 'Безалкогольный мохито с сезонными ягодами',
                'price' => 250.00,
                'category' => 'Напитки',
                'is_active' => true,
            ],

            // Мясо
            [
                'name' => 'Гюдан',
                'description' => 'Нежные кусочки говядины в соусе терияки',
                'price' => 520.00,
                'category' => 'Мясо',
                'is_active' => true,
            ],
            [
                'name' => 'Караагэ',
                'description' => 'Хрустящие кусочки курицы во фритюре',
                'price' => 380.00,
                'category' => 'Мясо',
                'is_active' => true,
            ],
            [
                'name' => 'Якитори',
                'description' => 'Куриные шашлычки на гриле с соусом',
                'price' => 320.00,
                'category' => 'Мясо',
                'is_active' => true,
            ],

            // Салаты
            [
                'name' => 'Салат с авокадо и моцареллой',
                'description' => 'Свежий салат с авокадо, моцареллой и томатами',
                'price' => 350.00,
                'category' => 'Салаты',
                'is_active' => true,
            ],
            [
                'name' => 'Морской салат',
                'description' => 'Салат с морепродуктами и овощами',
                'price' => 420.00,
                'category' => 'Салаты',
                'is_active' => true,
            ],
            [
                'name' => 'Салат Чука',
                'description' => 'Традиционный японский салат из морских водорослей',
                'price' => 280.00,
                'category' => 'Салаты',
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        $this->command->info('Создано ' . count($products) . ' продуктов!');
    }
}
