<?php

use yii\db\Migration;

class m260331_130002_add_start_date_column_to_blog_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%blog}}', 'start_date', $this->date());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%blog}}', 'start_date');
    }
}
