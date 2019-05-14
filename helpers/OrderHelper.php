<?php

namespace app\helpers;

use app\models\Order;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

class OrderHelper
{
    /**
     * @return array the statuses.
     */
    public static function statusList()
    {
        return [
            Order::STATUS_NEW => 'Новый',
            Order::STATUS_CONFIRMED => 'Подтвержден',
            Order::STATUS_COMPLETED => 'Завершен',
        ];
    }

    /**
     * @return string the status name.
     */
    public static function statusName($status)
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    /**
     * @return string the status label.
     */
    public static function statusLabel($status)
    {
        switch ($status) {
            case Order::STATUS_NEW:
                $class = 'label label-success';
                break;
            case Order::STATUS_CONFIRMED:
                $class = 'label label-primary';
                break;
            default:
                $class = 'label label-default';
        }

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }
}
