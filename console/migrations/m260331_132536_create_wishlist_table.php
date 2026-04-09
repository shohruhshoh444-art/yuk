<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%wishlist}}`.
 */
class m260331_132536_create_wishlist_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%wishlist}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'created_at' => $this->nullable(),
        ]);

        $this->createIndex('idx-wishlist-user_id', '{{%wishlist}}', 'user_id');
        $this->createIndex('idx-wishlist-product_id', '{{%wishlist}}', 'product_id');

        $this->addForeignKey('fk-wishlist-user', '{{%wishlist}}', 'user_id', '{{%user}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-wishlist-product', '{{%wishlist}}', 'product_id', '{{%product}}', 'id', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('{{%wishlist}}');
    }
}
