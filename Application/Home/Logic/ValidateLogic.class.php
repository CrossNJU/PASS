<?php
/**
 * Created by PhpStorm.
 * User: raychen
 * Date: 16/3/21
 * Time: 21:04
 */

namespace Home\Logic;


class ValidateLogic
{
    public function setSession(){
        if(!session('?changed')) session('changed',0);
        elseif(session('changed') == 0){
            session('msg',null);
            session('type',null);
        }else{
            session('changed',0);
        }
    }

    public function checkLogin($per){
        if(!session('?per') || session('per')!= $per){
            $this->sendMsg('尚未登录','warning');
            return false;
        }
        return true;
    }

    public function sendMsg($msg,$type,$in=1){
        session('msg',$msg);
        session('type',$type);
        session('changed',1);
        if($in == 0) session('changed',0);
    }
}