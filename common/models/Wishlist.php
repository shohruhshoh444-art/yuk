<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "wishlist".
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property string|null $created_at
 */
class Wishlist extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wishlist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at'], 'default', 'value' => null],
            [['user_id', 'product_id'], 'required'],
            [['user_id', 'product_id'], 'integer'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'product_id' => 'Product ID',
            'created_at' => 'Created At',
        ];
    }
    /**
     * Mahsulot bilan bog'lanish
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        // Bu yerda Product::class - mahsulot modelining nomi
        // 'id' - mahsulot jadvalidagi birlamchi kalit
        // 'product_id' - wishlist jadvalidagi tashqi kalit
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
}
