<?php
/**
 * Created by PhpStorm.
 * User: one
 * Date: 12.10.2016
 * Time: 13:12
 */
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


$config['secret_key'] = 'Jm3THEgc4ohprC07c61p'; // ��� ��������� ���� ����������
$config['client_id'] = 5630587; // (�����������) �������� ��� https://vk.com/apps?act=manage ��� ID ���������� = client_id
$config['user_id'] = 9040088; // ��� ����� ������������ � ��
/*$config['group_id'] = 101723005; // ��� ����� ������������ � ��*/
$config['scope'] = 'wall,photos,friends,groups,video,offline';  // ����� �������

require('classes/vk2.php');
$v = new Vk(
    array(
        'client_id' => $config['client_id'], // (required) app id
        'secret_key' => $config['secret_key'], // (required) get on https://vk.com/editapp?id=12345&section=options
        'user_id' => $config['user_id'], // your user id on vk.com
        'scope' => $config['scope'], // scope access
        'v' => '5.35' // vk api version
    ));

echo $v->get_code_token();
//2b2b140ba7318a793dd0f92aafc4fd246ed05c114bf1fb010939a7a7110bdfe5114c70ea2eefcef341025