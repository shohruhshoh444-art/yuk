<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m260323_092936_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'title' => $this->json()->notNull(),
            'description' => $this->json(),
            'price' => $this->decimal(15, 2)->notNull(),
            'discount_price' => $this->decimal(15, 2),
            'stock' => $this->integer()->defaultValue(0),
            'image' => $this->string(),
            'status' => $this->smallInteger()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk-product-category', '{{%product}}', 'category_id', '{{%category}}', 'id', 'CASCADE');
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product}}');
    }
}
