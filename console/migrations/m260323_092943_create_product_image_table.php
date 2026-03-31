<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_image}}`.
 */
class m260323_092943_create_product_image_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_image}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product_image}}');
    }
}
