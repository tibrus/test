<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Товары';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => ['class' => 'table-middle'],
        'columns' => [
            [
                'attribute' => 'id',
                'format' => 'html',
                'value' => function($model) {
                    return Html::a($model->id, ['update', 'id' => $model->id]);
                },
                'headerOptions' => ['style' => ['width' => '100px']]
            ],
            'name',
            [
                'attribute' => 'vendor',
                'value' => 'vendor.name',
            ],
            [
                'attribute' => 'price',
                'format' => 'raw',
                'value' => function($model) {
                    return Html::activeTextInput($model, 'price', [
                        'class' => 'form-control',
                        'data-product-id' => $model->id,
                        'onchange' => 'product.price(this)'
                    ]);
                },
            ],
        ],
    ]); ?>

</div>
