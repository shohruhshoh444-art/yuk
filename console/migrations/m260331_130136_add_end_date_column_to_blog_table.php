<?php

use yii\db\Migration;

class m260331_130136_add_end_date_column_to_blog_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%blog}}', 'end_date', $this->date());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%blog}}', 'end_date');
    }
}
