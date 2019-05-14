<?php

/* @var $this yii\web\View */
/* @var $weather app\models\YandexWeather */
?>

<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">

            <div class="panel-heading">
                <h1 class="panel-title">Погода в Брянске</h1>
            </div>

            <div class="panel-body">
                <div class="row">

                    <div class="col-md-6">
                        <div class="tm-weather-temp"><?= $weather->field('fact.temp') ?> °C</div>
                        <div><?= Yii::$app->formatter->asDateTime($weather->field('now')) ?></div>
                        <a href="<?= $weather->field('info.url') ?>" target="_blank">Прогноз на 10 дней</a>
                    </div>

                    <div class="col-md-6">
                        <div>
                            <img src="https://yastatic.net/weather/i/icons/blueye/color/svg/<?= $weather->field('fact.icon') ?>.svg" width="150" alt="Погода в Брянске">
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
