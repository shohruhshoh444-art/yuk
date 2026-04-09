<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blog}}`.
 */
// Klass nomi fayl nomi bilan bir xil bo'lishi shart!
class m260323_093009_create_blog_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%blog}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'content' => $this->text(),
            'image' => $this->string(),
            'status' => $this->integer()->defaultValue(1),
            'category_id' => $this->integer(),
            'created_at' => $this->integer()->null(),
            'updated_at' => $this->integer()->null(),
        ]);

        $this->createIndex('idx-blog-slug', '{{%blog}}', 'slug');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%blog}}');
    }
}
