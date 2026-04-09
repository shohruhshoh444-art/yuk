<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order}}`.
 */
class m260323_092950_create_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'full_name' => $this->string(),
            'phone' => $this->string(),
            'address' => $this->text(),
            'delivery_type' => $this->string(), 
            'payment_method' => $this->string(),
            'total_price' => $this->decimal(15, 2),
            'status' => $this->integer()->defaultValue(0),
            'created_at' => $this->nullable(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order}}');
    }
}
