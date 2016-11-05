<?php
/**
 * Created by PhpStorm.
 * User: one
 * Date: 12.10.2016
 * Time: 1:11
 */

$firstDate = date('j.n.Y',strtotime(date("Y-m-d", time()) . " - 16 year")); // 16
$lastDate = date('j.n.Y',strtotime(date("Y-m-d", time()) . " - 25 year")); // 25