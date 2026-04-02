<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\User;
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
            'created_at' => time(),
            'updated_at' => time(),
        ];

        if (in_array('name', $columns)) {
            $data['name'] = 'Elektronika';
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
        Yii::$app->db->createCommand("SET FOREIGN_KEY_CHECKS = 0")->execute();
        Yii::$app->db->createCommand("TRUNCATE TABLE product")->execute();

        $items = [
            ['iPhone 15 Pro', 'Titan korpus', 1200, 1100, 15, 'iphone.jpg'],
            ['MacBook Air M3', 'Apple Silicon', 1400, 1300, 10, 'macbook.jpg'],
            ['AirPods Pro 2', 'Noise canceling', 250, 220, 50, 'airpods.jpg'],
            ['Apple Watch 9', 'Smart watch', 450, 420, 30, 'watch.jpg'],
        ];

        foreach ($items as $item) {
            $model = new Product();
            $model->category_id = 1;
            $model->title = $item[0];
            $model->description = $item[1];
            $model->price = $item[2];
            $model->discount_price = $item[3];
            $model->stock = $item[4];
            $model->image = $item[5];
            $model->status = 1;
            $model->created_at = time();
            $model->updated_at = time();
            $model->save(false);
        }
        Yii::$app->db->createCommand("SET FOREIGN_KEY_CHECKS = 1")->execute();
        echo "Product: 4 ta mahsulot yaratildi.\n";
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
