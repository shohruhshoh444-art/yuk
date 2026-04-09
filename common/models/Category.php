<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string $name_uz
 * @property string $name_ru
 * @property string|null $slug
 * @property int|null $status
 * @property int|null $sort
 */

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class Category extends \yii\db\ActiveRecord
{



    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'value' => new Expression('NOW()'), 
            ],
        ];
    }




    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'status', 'sort'], 'integer'],
            [['name_uz', 'slug'], 'required'],
            [['name_uz', 'slug'], 'string', 'max' => 255],
            [['slug'], 'unique'],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'name_uz' => 'Name Uz',
            'name_ru' => 'Name Ru',
            'slug' => 'Slug',
            'status' => 'Status',
            'sort' => 'Sort',
        ];
    }
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if ($this->hasAttribute('name')) {
                $this->name = $this->name_uz;
            }
            return true;
        }
        return false;
    }
    public function getChilds()
{
    return $this->hasMany(Category::class, ['parent_id' => 'id']);
}

}
