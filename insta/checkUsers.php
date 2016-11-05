<?php
/**
 * Created by PhpStorm.
 * User: one
 * Date: 24.10.2016
 * Time: 14:39
 */
require('main.php');


while (true) {
    $userVal = [];
    $sqlUsers = "SELECT * FROM followers WHERE flag=0 ORDER BY id LIMIT 0,50 ";
    $sqlUsers = $mysqliClass->dbQuery($sqlUsers);
    if (mysqli_num_rows($sqlUsers) == 0) {
        break;
    }
    while ($row = mysqli_fetch_assoc($sqlUsers)) {
        echo $row['insta_uid'].' ';
        $countHaveTrick = 0;
        $posts = $instagram->getUserFeed($row['insta_uid'], 0);
        $items = $posts->getItems();
        foreach ($items as $item) {
            if ($item->getMediaType() !== 1) {
                $comment = $item->getComments();
                $comment = $comment[0];
                if ($comment !== null) {
                    if (stristr($comment->getText(), 'tricking') === FALSE) {
                        $countHaveTrick++;
                    }
                }
            }
        }
        if($countHaveTrick>0){
            $userVal[] = "('{$row['insta_uid']}',1)";
        }
        sleep(2);

    }
    if(count($userVal)>0){
        $userVal = implode(',',$userVal);
        $sql = "INSERT INTO trickVideo (insta_uid,flag) VALUES $userVal";
        $mysqliClass->dbQuery($sql);
    }
    $mysqliClass->dbQuery( "UPDATE followers SET flag=1 WHERE flag=0 ORDER BY id LIMIT 0,50");

    // пометка что обработаны
}
