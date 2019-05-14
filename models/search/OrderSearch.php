<?php

namespace app\models\search;

use Yii;
use app\models\Order;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * OrderSearch represents the model behind the search form of `app\models\Order`.
 */
class OrderSearch extends Order
{
    const TYPE_OVERDUE = 'overdue';
    const TYPE_CURRENT = 'current';
    const TYPE_NEW = 'new';
    const TYPE_EXECUTED = 'executed';

    public $partner;
    public $type;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['delivery_dt', 'partner', 'type'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Order::find()
            ->from(['o' => Order::tableName()])
            ->with('orderProducts.product')
            ->joinWith('partner p');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['delivery_dt' => SORT_DESC],
            ],
            'pagination' => [
                'defaultPageSize' => 25,
            ],
        ]);

        $dataProvider->sort->attributes['partner'] = [
            'asc' => ['p.name' => SORT_ASC],
            'desc' => ['p.name' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'o.id' => $this->id,
            'o.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'delivery_dt', $this->delivery_dt])
            ->andFilterWhere(['like', 'p.name', $this->partner]);

        $this->deliveryDate($query);

        return $dataProvider;
    }

    public function deliveryDate($query)
    {
        $from = $to = null;
        $format = 'Y-m-d H:i:s';
        $date = new \DateTime(Yii::$app->params['currentTime']);

        switch ($this->type) {
            case self::TYPE_OVERDUE:
                $to = $date->format($format);
                break;
            case self::TYPE_CURRENT:
                $from = $date->format($format);
                $to = $date->modify('+1 day')->format($format);
                break;
            case self::TYPE_NEW:
                $from = $date->format($format);
                break;
            case self::TYPE_EXECUTED:
                $from = $date->format('Y-m-d 00:00:00');
                $to = $date->modify('+1 day')->format('Y-m-d 00:00:00');
                break;
        }

        if ($from) {
            $query->andFilterWhere(['>', 'delivery_dt', $from]);
        }

        if ($to) {
            $query->andFilterWhere(['<', 'delivery_dt', $to]);
        }

        return $query;
    }

    /**
     * @param mixed $type
     * @return boolean the result
     */
    public function currentType($type = null)
    {
        return $this->type === $type;
    }
}
