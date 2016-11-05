<?php

/**
 * Created by PhpStorm.
 * User: one
 * Date: 31.10.2016
 * Time: 12:53
 */
class vkClass extends \vkApi\vk
{
    public function __construct($token)
    {
        parent::__construct($token);
    }

    public function getFriends($userId, $fields = '') // mass
    {
        $fields = ($fields == '') ? 'city,domain' : $fields;
        return $this->get('friends.get', ['user_id' => $userId, 'fields' => $fields]);
    }

    public function inviteUser($group_id, $user_id)
    {
        return $this->get('groups.invite', ['group_id' => $group_id, 'user_id' => $user_id]);
    }

    public function filterBy($friends, $rule)
    {
        $emptyArray = [];
        $countRule = count($rule);
        foreach ($friends as $friend) {
            $it = 0;
            foreach ($rule as $label => $value) {
                if ($value === '') {
                    if (!isset($friend->$label)) {
                        $it++;
                    }
                } else {
                    if (isset($friend->$label) and $friend->$label == $value) {

                        $it++;
                    }
                }
            }
            if ($it == $countRule) {
                $emptyArray[] = $friend;
            }
        }
        return $emptyArray;
    }


    public function isMember($groupId, $userId)
    {
        $userId = array_chunk($userId, 250);
        $finalMembersArray = [];
        foreach ($userId as $miniId) {
            $arrayUid = [];
            foreach ($miniId as $value) {
                $arrayUid[] = $value->uid;
            }
            $arrayUid = implode(',', $arrayUid);
            $response = $this->get('groups.isMember', ['user_ids' => $arrayUid, 'group_id' => $groupId, 'extended' => 1]);
            $finalMembersArray = array_merge($finalMembersArray, $response->response);
        }
        return $finalMembersArray;
    }

    public function getFriendsInGroup($idGroup, $userId)
    {
        $id = $this->getFriendsUserMember($idGroup, $userId);
        return $this->filterBy($id, ['member' => 1]);
    }

    public function getFriendsOutGroup($idGroup, $userId)
    {
        $id = $this->getFriendsUserMember($idGroup, $userId);
        return $this->filterBy($id, ['member' => 0, 'invitation' => '']);
    }

    private function getFriendsUserMember($idGroup, $userId)
    {
        $friends = $this->getFriends($userId);
        $friendsResult = $this->filterBy($friends->response, ['city' => 2]);
        return $id = $this->isMember($idGroup, $friendsResult);
    }

    public function getFeed($data)
    {
        return $this->get('newsfeed.get', $data);
    }

    public function addLike($type, $source_id, $post_id)
    {
        return $this->get('likes.add', ['type' => $type, 'owner_id' => $source_id, 'item_id' => $post_id]);
    }

    public function setOnline()
    {
        return $this->get('account.setOnline', []);
    }

    public function getUserInfo($idUser)
    {
        return $this->get('users.get', ['fields' => 'city','user_ids'=>$idUser]);
    }
    public function getAlbumItems($uid,$album_id,$count){
        return $this->get('photos.get',['owner_id'=>$uid,'album_id'=>$album_id,'count'=>$count,'rev'=>1]);
    }
    public function getWallItems($uid,$count){
        return $this->get('wall.get',['owner_id'=>$uid,'count'=>$count]);
    }

}