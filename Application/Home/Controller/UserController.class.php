<?php
/**
 * Created by PhpStorm.
 * User: raychen
 * Date: 16/1/30
 * Time: 17:05
 */

namespace Home\Controller;
use Think\Controller;
class UserController extends Controller
{
    public function test(){
        $this->user = "cr";
        $this->display('test1');
    }
}