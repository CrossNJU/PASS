<?php
/**
 * Created by PhpStorm.
 * User: raychen
 * Date: 16/2/19
 * Time: 18:59
 */

namespace Home\Logic;
use Think\Model;

class UserLogic
{

    public function get_user_name($user_id){
        $user_model = M('User');
        $user = $user_model->where("number = '$user_id'")
            ->select()[0];
        return $user['name'];
    }

}