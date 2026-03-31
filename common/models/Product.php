<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property float $price
 * @property float|null $discount_price
 * @property int|null $status
 * @property string|null $description
 * @property string|null $specifications
 * @property int|null $created_at
 *
 * @property BlogProduct[] $blogProducts
 * @property Blog[] $blogs
 * @property Category $category
 * @property ProductImage[] $productImages
 * @property ProductRelation[] $productRelations
 * @property ProductRelation[] $productRelations0
 */
class Product extends \yii\db\ActiveRecord
{

    public $imageFile;

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['discount_price', 'description', 'specifications', 'created_at'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['category_id', 'title', 'price'], 'required'],
            [['category_id', 'status', 'created_at'], 'integer'],
            [['price', 'discount_price'], 'number'],
            [['description'], 'string'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxSize' => 1024 * 1024 * 2],
            [['specifications'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'title' => 'Name',
            'price' => 'Price',
            'discount_price' => 'Discount Price',
            'status' => 'Status',
            'description' => 'Description',
            'specifications' => 'Specifications',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[BlogProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBlogProducts()
    {
        return $this->hasMany(BlogProduct::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Blogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBlogs()
    {
        return $this->hasMany(Blog::class, ['id' => 'blog_id'])->viaTable('blog_product', ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[ProductImages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductImages()
    {
        return $this->hasMany(ProductImage::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[ProductRelations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductRelations()
    {
        return $this->hasMany(ProductRelation::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[ProductRelations0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductRelations0()
    {
        return $this->hasMany(ProductRelation::class, ['related_id' => 'id']);
    }
}
