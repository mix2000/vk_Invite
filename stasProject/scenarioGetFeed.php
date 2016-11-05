<?php
/**
 * Created by PhpStorm.
 * User: Lida
 * Date: 03.11.2016
 * Time: 23:04
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

$a = $vk->getFeed(['count' => 50, 'return_banned' => 1, 'source_ids' => 'friends,groups', 'filters' => 'post,groups,photo']);
$a = $a->response->items;
$enter = true;

foreach($a as $value){
  
    if($enter){
        $enter = false;
        $userClass->setLastPost($value->source_id.'_'.$value->post_id);
    }
    /*
     * this scheme work with post
     */
    if($value->likes->user_likes == 0){
        $response = $vk->addLike($value->type,$value->source_id,$value->post_id);
        sleep(3);
    }else{
        exit('like_done');
    }
}