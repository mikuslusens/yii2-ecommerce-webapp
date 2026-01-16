<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "image".
 *
 * @property int $id
 * @property int $entityId
 * @property string $path
 */
class Image extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['entityId', 'path'], 'required'],
            [['entityId'], 'integer'],
            [['path'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('frontend', 'ID'),
            'entityId' => Yii::t('frontend', 'Entity ID'),
            'path' => Yii::t('frontend', 'Path'),
        ];
    }
}
