<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $name
 * @property int $price
 * @property int $vendor_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Vendor $vendor
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'vendor_id'], 'required'],
            [['price', 'vendor_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [
                ['vendor_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Vendor::className(),
                'targetAttribute' => ['vendor_id' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'price' => 'Цена',
            'vendor_id' => 'Поставщик',
            'vendor' => 'Поставщик',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата изменения',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendor()
    {
        return $this->hasOne(Vendor::className(), ['id' => 'vendor_id']);
    }

    /**
     * @return array the vendors list
     */
    public function getVendorsList()
    {
        return ArrayHelper::map(Vendor::find()->all(), 'id', 'name');
    }
}
