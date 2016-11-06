<?php
/**
 * Created by PhpStorm.
 * User: Lida
 * Date: 05.11.2016
 * Time: 1:37
 */


$textOriginal =
    "Доброе утро, %name%, сегодня в 10-00 начинается конференция Business Design, пожалуйста, не опаздывай. С уважением, команда Business Design 2016.";

require 'data.php';


foreach ($phonesArray as $key => $phone) {
    
    $text = str_replace('%name%',$nameArray[$key],$textOriginal);
    $text = mb_convert_encoding($text, 'utf-8', mb_detect_encoding($text));
    $ch = curl_init("http://sms.ru/sms/send");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_POSTFIELDS, array(/*
        "api_id" => "26ae33a9-078a-7574-a59d-89644e621c5c",*/
        "to" => "7" . $phone,
        "text" => $text
    ));
    $body = curl_exec($ch);
    curl_close($ch);
    var_dump($body);
}
