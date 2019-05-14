<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Product;

/**
 * ProductSearch represents the model behind the search form of `app\models\Product`.
 */
class ProductSearch extends Product
{
    public $vendor;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'price'], 'integer'],
            [['name', 'vendor'], 'safe'],
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
        $query = Product::find()
            ->from(['p' => Product::tableName()])
            ->joinWith('vendor v');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['name' => SORT_ASC]
            ],
            'pagination' => [
                'pageSize' => 25,
            ],
        ]);

        $this->load($params);

        $dataProvider->sort->attributes['partner'] = [
            'asc' => ['p.name' => SORT_ASC],
            'desc' => ['p.name' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'p.id' => $this->id,
            'price' => $this->price,
        ]);

        $query->andFilterWhere(['like', 'p.name', $this->name])
            ->andFilterWhere(['like', 'v.name', $this->vendor]);

        return $dataProvider;
    }
}
