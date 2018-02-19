<?php

use GuzzleHttp\Client;

class Weather
{
    protected $token ="8d3c09499ab056f9e70e6450d67d04c1";

    public function getWeather($lat, $lon)
    {
        $url ="https://api.openweathermap.org/data/2.5/weather";

        $params = [];
        $params['lat'] =($lat);
        $params['lon'] =($lon);
        $params['appid'] = $this->token;



        $url .= "?" . http_build_query($params) . '&units=metric';
        $client = new Client([
            'base_uri' => $url
        ]);

        $result = $client->request('GET');

        return json_decode($result->getBody());
    }
}
/**
 * Created by PhpStorm.
 * User: Maxim
 * Date: 18.02.2018
 * Time: 0:59
 */