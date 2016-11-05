<?php
/**
 * Created by PhpStorm.
 * User: Lida
 * Date: 04.11.2016
 * Time: 4:11
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

while (true) {
    $mysqliClass = new mysqliDb('testUsers');
    $sql = "SELECT * FROM vk_all_withCity WHERE flag=0 ORDER BY user_uid LIMIT 50";
    $sql = $mysqliClass->dbQuery($sql);
    $friendsResult = [];
    while ($rowFriend = mysqli_fetch_assoc($sql)) {
        /*
         * get photo
         */
        echo $rowFriend['user_uid'].' ';
        $friendsResult[] = ['id'=>$rowFriend['user_uid']];
        $items = $vk->getAlbumItems($rowFriend['user_uid'], 'profile', 5);
        $items = $items->response;
        foreach ($items as $photo) {
            $a = $vk->addLike('photo', $photo->owner_id, $photo->pid);
        }
        /*
         * get wall posts
         */
        $items = $vk->getWallItems($rowFriend['user_uid'], 6);

        $items = $items->response;
        $i = 0;
        foreach ($items as $wall) {
            if($i==0){// all posts
                $i++;
                continue;
            }
            $wall->post_type = ($wall->post_type=='copy')?'post':$wall->post_type;
            $vk->addLike($wall->post_type, $wall->from_id, $wall->id);
        }
        $mysqliClass->updQuery('vk_all_withCity',
            [
                'whr' => ['user_uid' => $rowFriend['user_uid'], 'user_id' => 2],
                'upd' => ['flag' => 1]
            ]
        );
        sleep(3);
    }
    htmlCreator::createHtmlFile($friendsResult,'users','usersLink.php','users_like_test');
    exit();
}