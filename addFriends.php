<?php
/**
 * Created by PhpStorm.
 * User: one
 * Date: 12.10.2016
 * Time: 13:22
 */

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


require('classes/vk.php');
require('classes/config.php');
require('classes/mysqli_test.php');

$mysqliClass = new mysqliDb('testUsers');
//2b2b140ba7318a793dd0f92aafc4fd246ed05c114bf1fb010939a7a7110bdfe5114c70ea2eefcef341025

$vk = \vkApi\vk::create('393270fc56f51929cde4c83396fa27b52bf5fc9585b1028b7dc5ec8f665375bb2fc10479ac7f3b91418c1');
$sql = "SELECT id_user FROM users_id WHERE main_user=0 ORDER BY id_user DESC LIMIT 0,10";
$rezult = $mysqliClass->dbQuery($sql);
$id = [];
while ($row = mysqli_fetch_assoc($rezult)) {
    echo $row['id_user'] . ' ';
    $a = $vk->get('friends.add', ['user_id' => $row['id_user']]);
    if (isset($a->error->error_code)) {
        print_r($a);
        echo 'error log ';
    } else {
        $id[] = "id_user = '" . $row['id_user'] . "'";
    }
    sleep(1000);
}
if (count($id)) {
    $id = implode(' and ', $id);
    $sql = "UPDATE users_id SET  main_user='9040088' WHERE " . $id;
    $mysqliClass->dbQuery($sql);
}