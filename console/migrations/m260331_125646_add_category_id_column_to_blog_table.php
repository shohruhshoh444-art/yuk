<?php

use yii\db\Migration;

class m260331_125646_add_category_id_column_to_blog_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%blog}}', 'category_id', $this->integer());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%blog}}', 'category_id');
    }
}
