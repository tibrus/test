<?php

namespace app\models\queries;

/**
 * This is the ActiveQuery class for [[\app\models\Order]].
 *
 * @see \app\models\Order
 */
class OrderQuery extends \yii\db\ActiveQuery
{
    public function new()
    {
        $this->andWhere(['status' => Order::STATUS_NEW]);

        return $this;
    }

    public function confirmed()
    {
        $this->andWhere(['status' => Order::STATUS_CONFIRMED]);

        return $this;
    }

    public function completed()
    {
        $this->andWhere(['status' => Order::STATUS_COMPLETED]);

        return $this;
    }
}
