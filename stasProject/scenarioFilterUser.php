<?php
/**
 * Created by PhpStorm.
 * User: Lida
 * Date: 04.11.2016
 * Time: 3:04
 */

use vkApi\vk;

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


require('../classes/vk.php');
require('../classes/mysqli_test.php');
require('../classes/userClass.php');
require('vkClass.php');
require('htmlCreator.php');

$mysqliClass = new mysqliDb('testUsers');
$userClass = new userClass($mysqliClass);
$userClass->getUsersInfo(2);

$vk = new vkClass($userClass->dataUsers['access_token']);
$start = 0;
$step = 200;
while (true) {
    $sql = $mysqliClass->dbQuery("SELECT * FROM vk_all_fFriends ORDER BY user_uid LIMIT {$start},{$step}");
    echo "\r\n" . 'Start ' . $start . "\r\n";
    if (mysqli_num_rows($sql) == 0) {
        break;
    }
    $users = [];
    while ($rowFriend = mysqli_fetch_assoc($sql)) {
        $users[] = $rowFriend['user_uid'];
    }
    $users = implode(',', $users);
    $result = $vk->getUserInfo($users);
    $result = $result->response;
    foreach ($result as $friend) {
        if (isset($friend->city) and $friend->city == 2) {
            $mysqliClass->addQuery('vk_all_withCity', ['user_id' => $userClass->dataUsers['userId'], 'user_uid' => $friend->uid, 'flag' => 0]);
        } elseif(!isset($friend->city)){
            $mysqliClass->addQuery('vk_all_withOutCity', ['user_id' => $userClass->dataUsers['userId'], 'user_uid' => $friend->uid, 'flag' => 0]);
        }
    }
    sleep(1);
    $start += $step;
}