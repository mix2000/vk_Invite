<?php
/**
 * Created by PhpStorm.
 * User: one
 * Date: 24.10.2016
 * Time: 12:28
 */
require('main.php');
$nextMaxId = 0;

while(true){
    $valSql = [];
    $followers = $instagram->getUserFollowers(828850802, $nextMaxId);
    $users = $followers->getFollowers();
    foreach($users as $key=>$value){
        if($value->isIsPrivate()==''){
            $valSql[] = "('{$value->getPk()}',0,'{$value->getUsername()}')";
        }
    }
    if(count($valSql)!=0){
        $valSql = implode(',',$valSql);
        $sql = "INSERT INTO followers (`insta_uid`,`flag`,`nickname`) VALUES $valSql";
        $mysqliClass->dbQuery($sql);
    }
    $nextMaxId = $followers->getNextMaxId();

//We have another page of Items
    if ($nextMaxId == null) {
        //Get the next page.
        break;
    }
    sleep(1);
}
echo 'getAllUsersDone';