<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user}}`.
 */
class m260326_084440_add_role_column_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
public function safeUp()
{
    $this->addColumn('{{%user}}', 'role', $this->smallInteger()->notNull()->defaultValue(10));
}

public function safeDown()
{
    $this->dropColumn('{{%user}}', 'role');
}


}