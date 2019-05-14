<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property int $status
 * @property string $client_email
 * @property int $partner_id
 * @property string $delivery_dt
 * @property string $created_at
 * @property string $updated_at
 *
 * @property OrderProduct[] $orderProducts
 * @property Partner $partner
 */
class Order extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_CONFIRMED = 10;
    const STATUS_COMPLETED = 20;

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
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'client_email', 'partner_id'], 'required'],
            [['status', 'partner_id'], 'integer'],
            [['delivery_dt', 'created_at', 'updated_at'], 'safe'],
            [['client_email'], 'string', 'max' => 255],
            [
                ['partner_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Partner::className(),
                'targetAttribute' => ['partner_id' => 'id']
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
            'status' => 'Статус',
            'client_email' => 'Email клиента',
            'partner' => 'Партнер',
            'partner_id' => 'Партнер',
            'delivery_dt' => 'Дата доставки',
            'total_price' => 'Стоимость заказа',
            'items' => 'Состав заказа',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата изменения',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderProducts()
    {
        return $this->hasMany(OrderProduct::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTotal()
    {
        return $this->hasMany(OrderProduct::className(), ['order_id' => 'id'])->sum('price');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartner()
    {
        return $this->hasOne(Partner::className(), ['id' => 'partner_id']);
    }

    /**
     * @return array the partners list
     */
    public function getPatnersList()
    {
        return ArrayHelper::map(Partner::find()->all(), 'id', 'name');
    }

    /**
     * @return string the total price
     */
    public function getTotalPrice()
    {
        return array_sum(array_column($this->orderProducts, 'price'));
    }

    /**
     * {@inheritdoc}
     * @return \app\models\queries\OrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\queries\OrderQuery(get_called_class());
    }
}
