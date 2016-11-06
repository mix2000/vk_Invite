<?php
/**
 * Created by PhpStorm.
 * User: one
 * Date: 11.10.2016
 * Time: 23:51
 */


ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


require('classes/vk.php');
require('classes/config.php');
require('classes/mysqli_test.php');

$mysqliClass = new mysqliDb('testUsers');

$vk = \vkApi\vk::create($vkInfo['token']);
$start = 0;
while (true) {
    $result = $vk->get('groups.getMembers',
        ['group_id' => '4058873', 'sort' => 'id_asc', 'offset' => $start, 'count' => 1000, 'fields' => 'sex, bdate, city, country,last_seen']
    );
    $users = $result->response->users;
    $val = [];
    if ($result->response->count <=$start) {
        exit('well done');
    }
    foreach ($users as $value) {
        if (isset($value->bdate) and validateDate($value->bdate) and $value->country == 1 and $value->city == 2) { //and $value->bdate > $firstDate and $value->bdate < $lastDate
            $arg = strtotime($value->bdate);
            if ($arg > strtotime($lastDate) && $arg < strtotime($firstDate)) {
                $val[] = "('{$value->uid}','1')";
                echo $value->uid . ' ';
            }
        }
    }
    if (count($val) > 0) {
        $val = implode(',', $val);
        $sql = "INSERT INTO users_id (`id_user`,`flag`) VALUES " . $val;
        $mysqliClass->dbQuery($sql);
    }
    $start += 1000;
}
function validateDate($date, $format = 'j.n.Y')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}