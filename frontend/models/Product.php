<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property float $price
 * @property string|null $path_to_image
 * @property int $is_new
 * @property int $is_discount
 * @property float|null $old_price
 * @property int $category_id
 *
 * @property Category $category
 */
class Product extends \yii\db\ActiveRecord implements CartItemInterface
{
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
            [['name', 'description', 'price', 'is_new', 'is_discount', 'category_id'], 'required'],
            [['description'], 'string'],
            [['price', 'old_price'], 'number'],
            [['is_new', 'is_discount', 'category_id'], 'integer'],
            [['name', 'path_to_image'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'price' => Yii::t('app', 'Price'),
            'path_to_image' => Yii::t('app', 'Path To Image'),
            'is_new' => Yii::t('app', 'Is New'),
            'is_discount' => Yii::t('app', 'Is Discount'),
            'old_price' => Yii::t('app', 'Old Price'),
            'category_id' => Yii::t('app', 'Category ID'),
        ];
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
}
