<?php

include('vendor/autoload.php');

include('TelegramBot.php');

include('Weather.php');

//получить сообщение

$telegramApi = new TelegramBot();
$weatherApi = new Weather();

while (true) {
    sleep(2);    
    $updates = $telegramApi->getUpdates();

//по каждому сообщению продвигаемся
foreach ($updates as $update) {

    if (isset($update->message->location)) {

        //получаем погоду
        $result = $weatherApi->getWeather($update->message->location->latitude, $update->message->location->longitude);

        switch ($result->weather[0]->main) {

            case "Clear":
                $response = "На улице ясно";
                break;
            case "Clouds":
                $response = "На улице облачно";
                break;
            case "Rain":
                $response = "На улице дождь";
                break;
            case "Default":
                $response = "Прогноз не доступен";
                break;
        }
        //выводим погоду

        $telegramApi->sendMessage($update->message->chat->id,

            //Облачность
            $response . " = " . $result->clouds->all . "%". "\n" .

            //Температура
            'Температура = ' .json_encode($result->main->temp).  "\n" .
            //Давление
            'Давление = ' .json_encode($result->main->pressure). " hPa".  "\n".

            'Влажность = ' .json_encode($result->main->humidity). "%" . "\n");

        $telegramApi->sendLocation($update->message->chat->id,50,50);
        


    } else {

        //отвечаем на каждое сообщение
        $telegramApi->sendMessage($update->message->chat->id, 'Отправь локацию');

        }
    }
}
