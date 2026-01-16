<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $name
 */
class Category extends \yii\db\ActiveRecord
{
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
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
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
        ];
    }

    public function formName()
    {
        return '';
    }

    public function howManyInCategory() {
        $row = (new \yii\db\Query())
            ->from('service')
            ->where(['category_id' => $this->id])
            ->count();
        return $row;
    }

    public static function getAll() {
        $dbcategories = new Category();
        $categories = $dbcategories->find()->all();
        return $categories;
    }
}
