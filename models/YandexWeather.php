<?php

namespace app\models;

use Yii;
use yii\helpers\Html;
use yii\httpclient\Client;
use yii\helpers\ArrayHelper;

/**
 * YandexWeather model.
 */
class YandexWeather
{
    /**
     * @var string the url request.
     */
    public $url = 'https://api.weather.yandex.ru/v1/forecast/';
    /**
     * @var array the response data.
     */
    protected $_data = [];

    public function __construct($params = [])
    {
        $this->_data = $this->request($params);
    }

    /**
     * @param array $params the request parameters.
     * @return array the response.
     */
    public function request($params)
    {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl($this->url)
            ->setData($params)
            ->addHeaders(['X-Yandex-API-Key' => Yii::$app->params['yandex.api.key.weather']])
            ->send();
        if ($response->isOk) {
            return $response->data;
        }
    }

    /**
     * @param string $value
     * @return string the result
     */
    public function field($value)
    {
        return Html::encode(ArrayHelper::getValue($this->_data, $value));
    }
}
