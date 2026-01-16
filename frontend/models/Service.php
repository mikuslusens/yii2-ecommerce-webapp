<?php

namespace frontend\models;

use Yii;
use yii2mod\cart\models\CartItemInterface;
use yii\helpers\Url;
use kartik\filesystem\Folder;
use frontend\models\Image;

/**
 * This is the model class for table "service".
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
 */
class Service extends \yii\db\ActiveRecord implements CartItemInterface, \JsonSerializable
{
    
    private $quantity;
    public $eventImage;
    public $extra_images;

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getLabel()
    {
        return $this->name;
    }

    public function getUniqueId()
    {
        return $this->id;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'service';
    }

    public function jsonSerialize():mixed {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'path_to_image' => $this->path_to_image,
            'is_new' => $this->is_new,
            'is_discount' => $this->is_discount,
            'old_price' => $this->old_price,
            'category_id' => $this->category_id,
            'quantity' => $this->quantity,
        ];
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
            [['eventImage'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['extra_images'], 'file', 'extensions' => 'jpg, png', 'maxFiles' => 10, 'skipOnEmpty' => true],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('frontend', 'serviceName'),
            'description' => Yii::t('app', 'Description'),
            'price' => Yii::t('frontend', 'servicePrice'),
            'path_to_image' => Yii::t('app', 'Path To Image'),
            'is_new' => Yii::t('app', 'Is New'),
            'is_discount' => Yii::t('app', 'Is Discount'),
            'old_price' => Yii::t('app', 'Old Price'),
            'category_id' => Yii::t('app', 'Category ID'),
            'quantity' => Yii::t('frontend', 'serviceQuantity'),
        ];
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    public static function getAttributeTotal($attribute, $variable, $itemType = null): float
    {
        
        $sum = 0;
        foreach ($variable as $model) {
            if ($model->getQuantity() != null) {
                $value = $model->getQuantity() * $model->{$attribute};
                $sum += $value;
            }
            else
            {
                $sum += $model->{$attribute};
            }
        }

        return floatval($sum);
    }

    public function upload() {

        if ($this->eventImage) {
            $image = $this->eventImage;
            $random = random_int(1, 99999);
            $relativePath = 'images/' . $random . '.' . $this->eventImage->extension;
            $absolutePath = \Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . $relativePath;
            $image->saveAs($absolutePath);
            //$this->image = $this->id . "." .$this->eventImage->extension;
            //$dbImage = new Image();
            //$dbImage->entityId = $this->id;
            //$dbImage->path = $path;
            //$dbImage->save();
            $this->path_to_image = $relativePath;
            $this->save(false, null);
            return true;
        }
        
        return false;
    }

    
    public function uploadMultiple() {
        foreach ($this->extra_images as $image) {
            $random = random_int(1, 99999);
            $relativePath = 'images/' . $random . '.' . $image->extension;
            $absolutePath = \Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . $relativePath;
            $image->saveAs($absolutePath);
            //$this->image = $this->id . "." .$this->eventImage->extension;
            $dbImage = new Image();
            $dbImage->entityId = $this->id;
            $dbImage->path = $relativePath;
            $dbImage->save();
            //$this->path_to_image = $path;
            //$this->save(false, null);
            return true;
        }
        
        return false;
    }
        
    public function uploadPath() {
        //return Url::to('@web/uploads/events');
    
    }
}
