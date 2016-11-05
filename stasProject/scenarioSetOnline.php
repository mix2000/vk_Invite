<?php
/**
 * Created by PhpStorm.
 * User: Lida
 * Date: 04.11.2016
 * Time: 1:53
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
$vk->setOnline();
