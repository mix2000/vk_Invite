<?php
/**
 * Created by PhpStorm.
 * User: one
 * Date: 31.10.2016
 * Time: 12:51
 */
use vkApi\vk;

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require('../classes/vk.php');
require('../classes/mysqli_test.php');
require('vkClass.php');
require('htmlCreator.php');

// отложенный старт
sleep(3600);
$mysqli_Class = new mysqliDb('testUsers');

//37e6a609836c5e3bf56acdbdc963a2caddd26d5ffead82c5601e47b5a57a40afea87806b2954ca854990b
$vk = new vkClass('37e6a609836c5e3bf56acdbdc963a2caddd26d5ffead82c5601e47b5a57a40afea87806b2954ca854990b');
$ids = $vk->getFriendsOutGroup(112222198, 486493);
$i = 0;
/*
 * [error_code] =>
 * [error_msg] => Access denied: could invite only friends
 */

foreach ($ids as $value) {
    $mysqli_Class = new mysqliDb('testUsers');
    if (!$mysqli_Class->existsRow('statUsers', ['uid' => $value->user_id, 'user' => 1])) {
        $response = $vk->inviteUser(112222198, $value->user_id);
        if (!isset($response->error)) {
            $i++;
        } else {
            switch ($response->error->error_code) {
                case 14:
                    sleep(600);
                    break;
                case 15;
                    $mysqli_Class->addQuery('statUsers', ['uid' => $value->user_id, 'user' => 1]);
                    break;
                case 103:
                    exit('Out of limits: invites limit');
            }
        }
        print_r($response);
        echo $value->user_id;
        if ($i == 60) break;
        sleep(180);
    }

}

/*
print_r($friends);*/

/*htmlCreator::setTitle('Пользователи СПБ');
htmlCreator::createHtmlFile($friendsResult,'users','usersView.php','usersCity');*/


/*
print_r($id);*/
/*
$friendsResult = $vk->filterBy($friends->response,['city'=>'']);
htmlCreator::setTitle('Пользователи');
htmlCreator::createHtmlFile($friendsResult,'users','usersView.php','usersWithOut');
*/


/*
var_dump($vk->inviteUser(112222198, 9040088));*/
