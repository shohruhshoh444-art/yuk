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

        // FAQAT to'g'ri rasm linklarini ishlating (id/ raqami har xil bo'lsin)
        $items = [
            ['title' => 'iPhone 15 Pro', 'slug' => 'iphone-15-pro', 'img' => 'https://picsum.photos'],
            ['title' => 'MacBook Air M3', 'slug' => 'macbook-air-m3', 'img' => 'https://picsum.photos'],
            ['title' => 'AirPods Pro 2', 'slug' => 'airpods-pro-2', 'img' => 'https://picsum.photos'],
            ['title' => 'Apple Watch 9', 'slug' => 'apple-watch-9', 'img' => 'https://picsum.photos'],
        ];

        foreach ($items as $item) {
            $db->createCommand()->insert('{{%product}}', [
                'category_id'    => 1,
                'title'          => $item['title'],
                'slug'           => $item['slug'],
                'description'    => 'Professional mahsulot tavsifi.',
                'price'          => 1200,
                'discount_price' => 1100,
                'stock'          => 10,
                'image'          => $item['img'], // BU YERDA GOOGLE LINKI BO'LMASLIGI KERAK!
                'status'         => 1,
                'created_at'     => time(),
                'updated_at'     => time(),
            ])->execute();
        }

        $db->createCommand("SET FOREIGN_KEY_CHECKS = 1")->execute();
        echo "Product: 4 ta mahsulot to'g'ri rasm linklari bilan yaratildi.\n";
    }



    private function seedBlog()
    {
        Yii::$app->db->createCommand("DELETE FROM blog")->execute();
        Yii::$app->db->createCommand()->batchInsert(
            '{{%blog}}',
            ['title', 'content', 'status', 'created_at', 'updated_at'],
            [
                ['Xush kelibsiz!', 'Bu bizning yangi do\'konimiz.', 1, time(), time()],
                ['Aksiya!', 'Barcha iPhone-lar uchun 10% chegirma.', 1, time(), time()],
            ]
        )->execute();
        echo "Blog: 2 ta maqola yaratildi.\n";
    }
}
