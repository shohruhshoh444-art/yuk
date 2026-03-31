<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class Blog extends ActiveRecord
{
    public $imageFile; // Для загрузки фото

    public static function tableName()
    {
        return 'blog';
    }

    public function rules()
    {
        return [
            [['title', 'content', 'start_date', 'end_date'], 'required'],
            [['content'], 'string'],
            [['status', 'created_at', 'category_id'], 'integer'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }
}
