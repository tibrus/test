<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\YandexWeather;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Displays weather page.
     *
     * @return string
     */
    public function actionWeather()
    {
        $weather = new YandexWeather([
            'lat' => '53.243562',
            'lon' => '34.363407',
        ]);

        return $this->render('weather', [
            'weather' => $weather
        ]);
    }
}
