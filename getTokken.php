<?php
/**
 * Created by PhpStorm.
 * User: one
 * Date: 12.10.2016
 * Time: 13:12
 */
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


$config['secret_key'] = 'Jm3THEgc4ohprC07c61p'; // ваш секретный ключ приложения
$config['client_id'] = 5630587; // (обязательно) получить тут https://vk.com/apps?act=manage где ID приложения = client_id
$config['user_id'] = 9040088; // ваш номер пользователя в вк
/*$config['group_id'] = 101723005; // ваш номер пользователя в вк*/
$access_token = ['3afc9e8a8546a842185a711b1ed0aec23d296885d7f5859837c4abf0726fcf1e2069323929abbf76dc340', 'ec5a839532772a9a63da01f6a1eb39a5671aa91fac7181b37c178fc87a93c898dd9a3ddd1c5d931015fa2']; // ваш токен доступа
$config['scope'] = 'wall,photos,friends,groups,video,offline';  // права доступа

require('classes/vk2.php');
$v = new Vk(
    array(
        'client_id' => $config['client_id'], // (required) app id
        'secret_key' => $config['secret_key'], // (required) get on https://vk.com/editapp?id=12345&section=options
        'user_id' => $config['user_id'], // your user id on vk.com
        'scope' => $config['scope'], // scope access
        'v' => '5.35' // vk api version
    ));

echo $v->get_code_token();
//2b2b140ba7318a793dd0f92aafc4fd246ed05c114bf1fb010939a7a7110bdfe5114c70ea2eefcef341025