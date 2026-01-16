<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $cartData
 * @property int $status
 * @property string $date
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
            [['name', 'surname', 'email', 'phone', 'address', 'cartData', 'status'], 'required'],
            [['address', 'cartData'], 'string'],
            [['status'], 'integer'],
            [['date'], 'safe'],
            [['name', 'surname', 'email', 'phone'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('frontend', 'ID'),
            'name' => Yii::t('frontend', 'Name'),
            'surname' => Yii::t('frontend', 'Surname'),
            'email' => Yii::t('frontend', 'Email'),
            'phone' => Yii::t('frontend', 'Phone'),
            'address' => Yii::t('frontend', 'Address'),
            'cartData' => Yii::t('frontend', 'Cart Data'),
            'status' => Yii::t('frontend', 'Status'),
            'date' => Yii::t('frontend', 'Date'),
        ];
    }
}
