<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%category}}`.
 */
class m260323_092927_create_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->json()->notNull(),
            'parent_id' => $this->integer()->null(),
            'slug' => $this->string()->unique()->notNull(),
            'status' => $this->smallInteger()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        $this->addForeignKey('fk-category-parent', '{{%category}}', 'parent_id', '{{%category}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%category}}');
    }
}
