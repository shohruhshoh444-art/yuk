<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $full_name
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $delivery_type
 * @property string|null $payment_method
 * @property float|null $total_price
 * @property int|null $status
 * @property int|null $created_at
 */
class Order extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['full_name', 'phone', 'address', 'payment_method'], 'required'],
            [['full_name', 'phone', 'address', 'payment_method'], 'string', 'max' => 255],
            [['user_id', 'created_at'], 'integer'],
            [['total_price'], 'number'],
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
            'full_name' => 'Full Name',
            'phone' => 'Phone',
            'address' => 'Address',
            'delivery_type' => 'Delivery Type',
            'payment_method' => 'Payment Method',
            'total_price' => 'Total Price',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }
}
