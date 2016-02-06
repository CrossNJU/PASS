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
        if(IS_POST){
//            echo I('post.in');
            echo $_POST['in'];
        }
        $this->display('User:test1');
    }

    public function test_url($id="0"){
        echo $id;
        $this->display('User:test2');
    }

    public function index(){
//        echo "index";
        $this->test_url();
    }
}