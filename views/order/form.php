<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\helpers\OrderHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Order */

$this->title = 'Изменение заказа: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменение';
?>
<div class="order-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="order-form">

        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'client_email')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'partner_id')->dropdownList($model->getPatnersList()) ?>

        <div class="form-group">
            <label class="control-label"><?= $model->getAttributeLabel('items') ?></label>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Наименование</th>
                        <th>Количество</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($model->orderProducts as $key => $item): ?>
                        <tr>
                            <th><?= $key + 1 ?></th>
                            <td><?= Html::encode($item->product->name) ?></td>
                            <td><?= $item->quantity ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?= $form->field($model, 'status')->dropdownList(OrderHelper::statusList()) ?>

        <div class="form-group">
            <label class="control-label"><?= $model->getAttributeLabel('total_price') ?></label>
            <div class="text-large"><?= $model->getTotalPrice() ?></div>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
