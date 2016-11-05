<?php
/**
 * Created by PhpStorm.
 * User: Lida
 * Date: 04.11.2016
 * Time: 2:14
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

$response = $vk->getFriends($userClass->dataUsers['userUid']);
$friends = $response->response;
foreach ($friends as $friend) {
    $mysqliClass->addQuery('vk_all_fFriends', ['user_id' => $userClass->dataUsers['userId'], 'user_uid' => $friend->uid, 'flag' => 0]);
}
$start = 0;
while (true) {
    /* 0 - friend _ not checked
    1 - friend checked
    2 - friend friend  - not likes
    3 - friend friend - with like
    */
    $sql = $mysqliClass->dbQuery("SELECT user_id,user_uid FROM vk_all_fFriends WHERE user_id='{$userClass->dataUsers['userId']}' and flag=0 LIMIT 0,10");
    if (mysqli_num_rows($sql) == 0) break;
    while ($rowFriend = mysqli_fetch_assoc($sql)) {
        echo $rowFriend['user_uid'] . ' ';
        $friends = $vk->getFriends($rowFriend['user_uid']);
        $friends = $friends->response;
        foreach ($friends as $friend) {
            if (!$mysqliClass->existsRow('vk_all_fFriends', ['user_id' => $userClass->dataUsers['userId'], 'user_uid' => $friend->uid])) {
                $mysqliClass->addQuery('vk_all_fFriends', ['user_id' => $userClass->dataUsers['userId'], 'user_uid' => $friend->uid, 'flag' => 2]);
            }
        }
        $mysqliClass->updQuery('vk_all_fFriends', [
            'whr' => ['user_id' => $userClass->dataUsers['userId'], 'user_uid' => $rowFriend['user_uid']],
            'upd' => ['flag' => 1]
        ]);
    }
    sleep(10);
}