<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\User;
use Faker\Factory;

use common\models\Product;

class SeedController extends Controller
{
    public function actionIndex()
    {
        $this->seedCategory();
        $this->seedUser();
        $this->seedProduct();
        $this->seedBlog();
        echo "\n--- TABRIKLAYMAN! Loyiha fake ma'lumotlar bilan to'ldirildi ---\n";
    }

    private function seedCategory()
    {
        Yii::$app->db->createCommand("SET FOREIGN_KEY_CHECKS = 0")->execute();
        Yii::$app->db->createCommand("TRUNCATE TABLE category")->execute();

        $columns = Yii::$app->db->getTableSchema('category')->columnNames;

        $data = [
            'id' => 1,
            'status' => 1,
            'name_uz' => 'Test Kategoriya',
            'slug' => 'test',
            'created_at' => time(),
            'updated_at' => time(),
        ];

        if (in_array('name_uz', $columns)) {
            $data['name_uz'] = 'Elektronika';
            if (in_array('slug', $columns)) {
                $data['slug'] = 'elektronika';
            }
        } elseif (in_array('title', $columns)) {
            $data['title'] = 'Elektronika';
        }

        Yii::$app->db->createCommand()->insert('{{%category}}', $data)->execute();
        Yii::$app->db->createCommand("SET FOREIGN_KEY_CHECKS = 1")->execute();
        echo "Category: Default kategoriya yaratildi.\n";
    }

    private function seedUser()
    {
        $user = User::findByUsername('admin');
        if ($user) {
            $user->delete();
        }

        $user = new User();
        $user->username = 'admin';
        $user->email = 'admin@example.com';
        $user->setPassword('admin123');
        $user->generateAuthKey();
        $user->status = 10;
        $user->role = 30;

        if ($user->save(false)) {
            echo "User: Admin yaratildi (Role: 30, Parol: admin123).\n";
        }
    }

    private function seedProduct()
    {
        $db = Yii::$app->db;
        $db->createCommand("SET FOREIGN_KEY_CHECKS = 0")->execute();
        $db->createCommand()->truncateTable('{{%product}}')->execute();

        $items = [
            ['title' => 'iPhone 15 Pro', 'slug' => 'iphone-15-pro'],
            ['title' => 'MacBook Air M3', 'slug' => 'macbook-air-m3'],
            ['title' => 'AirPods Pro 2', 'slug' => 'airpods-pro-2'],
            ['title' => 'Apple Watch 9', 'slug' => 'apple-watch-9'],
        ];

        $availableImages = [
            'img/product-5.jpg',
            'img/product-4.jpg',
            'img/product-6.jpg',
            'img/product-4.jpg',
            'img/product-5.jpg',
            'img/product-6.jpg',
            'img/product-7.jpg',
            'img/product-8.jpg',
            'img/product-9.jpg',
            'img/product-10.jpg'
        ];

        foreach ($items as $item) {
            $randomKeys = array_rand($availableImages, 3);
            $productImages = [
                $availableImages[$randomKeys[0]],
                $availableImages[$randomKeys[1]],
                $availableImages[$randomKeys[2]]
            ];

            $db->createCommand()->insert('{{%product}}', [
                'category_id'    => 1,
                'title'          => $item['title'],
                'slug'           => $item['slug'],
                'description'    => 'Professional mahsulot tavsifi. Bu yerda mahsulot haqida batafsil ma\'lumot keltirilgan.',
                'price'          => rand(500, 1500),
                'discount_price' => rand(400, 450),
                'stock'          => rand(5, 20),

                'image'          => implode(',', $productImages),
                'status'         => 1,
                'created_at'     => time(),
                'updated_at'     => time(),
            ])->execute();
        }

        $db->createCommand("SET FOREIGN_KEY_CHECKS = 1")->execute();
        echo "Product: 4 ta mahsulot (har biri min 3 tadan rasm bilan) yaratildi.\n";
    }



    private function seedBlog()
    {
        Yii::$app->db->createCommand("DELETE FROM blog")->execute();
        $fakeImage = 'img/category-5.jpg';
        $now = time();
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime('+1 month'));

        Yii::$app->db->createCommand()->batchInsert(
            '{{%blog}}',
            [
                'title',
                'content',
                'image',
                'status',
                'start_date',
                'end_date',
                'created_at',
                'updated_at'
            ],
            [
                [
                    'Xush kelibsiz!',
                    'Bu bizning yangi do\'konimiz.',
                    $fakeImage,
                    1,
                    $startDate,
                    $endDate,
                    $now,
                    $now
                ],
                [
                    'Aksiya!',
                    'Barcha iPhone-lar uchun 10% chegirma.',
                    $fakeImage,
                    1,
                    $startDate,
                    $endDate,
                    $now,
                    $now
                ],
            ]
        )->execute();

        echo "Blog: 2 ta FAOL aksiya yaratildi.\n";
    }
}
