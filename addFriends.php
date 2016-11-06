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
//

$vk = \vkApi\vk::create('');
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