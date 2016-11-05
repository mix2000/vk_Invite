<?php

/**
 * Created by PhpStorm.
 * User: Lida
 * Date: 04.11.2016
 * Time: 0:55
 */
class userClass
{
    private $db;
    public $dataUsers = [];
    private $userId;

    public function __construct(mysqliDb $db)
    {
        $this->db = $db;
    }

    public function getUsersInfo($idUser)
    {
        if (!is_numeric($idUser)) return false;
        $sql = "SELECT * FROM usersParam WHERE user_id='$idUser'";
        $this->userId = $idUser;
        $sql = $this->db->dbQuery($sql);
        $data = [];
        while ($row = mysqli_fetch_assoc($sql)) {
            $data[$row['param_name']] = $row['value'];
        }
        $data['userId'] = $idUser;
        $this->dataUsers = $data;
    }

    public function setLastPost($valuePost)
    {
        $sql = "UPDATE usersParam SET `value`='{$valuePost}'  WHERE user_id='{$this->userId}' and `param_name`='last_post_id'";
        $this->db->dbQuery($sql);
    }
}