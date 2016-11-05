<?php

/**
 * Created by PhpStorm.
 * User: one
 * Date: 11.10.2016
 * Time: 23:47
 */
/*
 * Class Vk
 * @author: Dmitriy Nyashkin
 * @link: https://github.com/fdcore/vk.api
 * @version: 2
 */

// ������������ ������ https://vk.com/dev/errors

namespace vkApi;

class vk {

    const CALLBACK_BLANK = 'https://oauth.vk.com/blank.html';
    const AUTHORIZE_URL  = 'https://oauth.vk.com/authorize?';

    public $token;
    private $count = -1;
    public function __construct($token){
        $this->token = $token;
    }

    public function get($method, array $data){
        $this->count ++;
        if($this->count >= 3){
            $this->count = 0;
            sleep(1);
        }
        $params = [];
        foreach($data as $name => $val){
            $params[$name] = $val;
        }
        $params['access_token'] = $this->token;
        /*$params['access_key'] = $this->token;*/
        /*echo 'https://api.vk.com/method/' . $method . '?' . http_build_query($params);*/
        $json = file_get_contents('https://api.vk.com/method/' . $method . '?' . http_build_query($params));
        return json_decode($json);
    }
}


https://api.vk.com/method/likes.add?type=photo&owner_id=9040088&item_id=377660222&access_token=3de42ce2cb9af2843669ca7e92c0420793ab1e52e1b2c744255d0309328d2bf826a1f8617d3f9b4227af0