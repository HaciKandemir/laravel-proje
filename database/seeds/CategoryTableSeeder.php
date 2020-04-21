<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'category_name' => 'Eğitim - Gelişim',
                'children' => [
                    [
                        'category_name' => 'Dil',
                        'children' => [
                            ['category_name' => 'İşaret Dili'],
                            ['category_name' => 'İngilizce (Online)'],
                            ['category_name' => 'Diğer Diller'],
                        ],
                    ],
                    [
                        'category_name' => 'Kişisel Gelişim',
                        'children' => [
                            ['category_name' => 'İletişim - İlişki Yönetimi'],
                            ['category_name' => 'Stres Yönetimi - Mindfulness'],
                            ['category_name' => 'Kişisel Üretkenlik'],
                        ],
                    ],
                ],
            ],

        ];
        foreach($categories as $category)
        {
            App\Category::create($category);
        }
    }
}
