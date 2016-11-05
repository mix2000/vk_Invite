<?php
/**
 * Created by PhpStorm.
 * User: one
 * Date: 24.10.2016
 * Time: 14:39
 */
require("../classes/instagram/vendor/autoload.php");
require('../classes/vk.php');
require('../classes/config.php');
require('../classes/mysqli_test.php');



$instagram = new \Instagram\Instagram();
$mysqliClass = new mysqliDb('testUsers');


/*$instagram->login("ozma_split", "createNewSkill");

//Serialize the Session into a JSON string
$savedSession = $instagram->saveSession();*/


$string = '{"loggedInUser":{"username":"ozma_split","has_anonymous_profile_picture":false,"profile_pic_url":"http:\/\/instagram.fhen1-1.fna.fbcdn.net\/t51.2885-19\/14156436_708423492639962_1781413697_a.jpg","full_name":"\u041c\u0438\u0445\u0430\u043d","pk":"1267039696","is_verified":false,"is_private":false},"cookies":{"csrftoken":"2nwBxfAEHWhUvIjDEpKTa09a7HIYJDWC","sessionid":"IGSC516844be171a8d3a116b4fac5baae4d26de7605efe7fdb5a43202e3ca62aca18%3AzcFjLPG64Oe9x1PhqeGCpv3WFPynZBw4%3A%7B%22_token_ver%22%3A2%2C%22_auth_user_id%22%3A1267039696%2C%22_token%22%3A%221267039696%3AxZsnPuhMM5Qwmdxc6IHeD0piGwjmuevF%3A3afe9679af820e3b325e682dabaa21f36c05efa7239bcaa66fb5885f4025a6a6%22%2C%22asns%22%3A%7B%22time%22%3A1477302383%7D%2C%22_auth_user_backend%22%3A%22accounts.backends.CaseInsensitiveModelBackend%22%2C%22last_refreshed%22%3A1477302383.533206%2C%22_platform%22%3A1%2C%22_auth_user_hash%22%3A%22%22%7D","ds_user":"ozma_split","mid":"WA3YbwABAAHDbgA9hvm01DDE8EHF","ds_user_id":"1267039696"},"csrfToken":"2nwBxfAEHWhUvIjDEpKTa09a7HIYJDWC","rankToken":"26028cc9-c6d7-47eb-8a2d-b22df013f112","phoneId":"159c8489-d4bb-4830-a51e-0d3d0fa897b7","deviceId":"android-ca5c678f6cfeb0e6","guid":"814b500c-0a2b-4084-aff0-83e15cb5510b","uuid":"814b500c-0a2b-4084-aff0-83e15cb5510b","googleAdId":"cb666ec0-3188-411d-941a-00392f582727"}';


$instagram->initFromSavedSession($string);