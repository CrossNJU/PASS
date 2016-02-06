<?php
/**
 * Created by PhpStorm.
 * User: raychen
 * Date: 16/2/6
 * Time: 10:13
 */

namespace Home\Controller;
use Think\Controller;

class CommonController extends Controller
{
    public function index(){
        $this->display('Common:Login');
    }
}