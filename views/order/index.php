<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Nav;
use app\helpers\OrderHelper;
use app\helpers\DateHelper;
use app\models\Order;
use app\models\search\OrderSearch;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <div class="label label-default pull-right">Тестовое время: <?= Yii::$app->params['currentTime'] ?></div>
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Nav::widget([
            'items' => [
                [
                    'url' => ['/order/index'],
                    'label' => 'Все',
                    'active' => $searchModel->currentType(),
                ],
                [
                    'url' => [
                        '/order/index',
                        'OrderSearch[status]' => Order::STATUS_CONFIRMED,
                        'OrderSearch[type]' => OrderSearch::TYPE_OVERDUE,
                        'per-page' => 50,
                        'sort' => '-delivery_dt',
                    ],
                    'label' => 'Просроченные',
                    'active' => $searchModel->currentType(OrderSearch::TYPE_OVERDUE),
                ],
                [
                    'url' => [
                        '/order/index',
                        'OrderSearch[status]' => Order::STATUS_CONFIRMED,
                        'OrderSearch[type]' => OrderSearch::TYPE_CURRENT,
                        'sort' => 'delivery_dt',
                    ],
                    'label' => 'Текущие',
                    'active' => $searchModel->currentType(OrderSearch::TYPE_CURRENT),
                ],
                [
                    'url' => [
                        '/order/index',
                        'OrderSearch[status]' => Order::STATUS_NEW,
                        'OrderSearch[type]' => OrderSearch::TYPE_NEW,
                        'sort' => 'delivery_dt',
                        'per-page' => 50,
                    ],
                    'label' => 'Новые',
                    'active' => $searchModel->currentType(OrderSearch::TYPE_NEW),
                ],
                [
                    'url' => [
                        '/order/index',
                        'OrderSearch[status]' => Order::STATUS_COMPLETED,
                        'OrderSearch[type]' => OrderSearch::TYPE_EXECUTED,
                        'sort' => '-delivery_dt',
                        'per-page' => 50,
                    ],
                    'label' => 'Выполненные',
                    'active' => $searchModel->currentType(OrderSearch::TYPE_EXECUTED),
                ],
            ],
            'options' => ['class' =>'nav-tabs'],
        ]) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'format' => 'raw',
                'value' => function($model) {
                    return Html::a($model->id, ['update', 'id' => $model->id], ['target' => '_blank']);
                },
                'headerOptions' => ['style' => ['width' => '100px']]
            ],
            'client_email',
            [
                'attribute' => 'partner',
                'value' => 'partner.name',
            ],
            [
                'attribute' => 'total_price',
                'value' => function($model) {
                    return $model->getTotalPrice();
                },
                'headerOptions' => ['style' => ['width' => '1px']]
            ],
            [
                'attribute' => 'items',
                'format' => 'raw',
                'value' => function($model) {
                    $items = [];
                    foreach ($model->orderProducts as $item) {
                        $items[] = Html::tag('div', Html::encode($item->product->name));
                    }
                    return implode("\n", $items);
                },
                'filter' => false
            ],
            'delivery_dt',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function($model) {
                    return OrderHelper::statusLabel($model->status);
                },
                'filter' => OrderHelper::statusList(),
                'headerOptions' => ['style' => ['width' => '160px']]
            ],
        ],
    ]); ?>

</div>
