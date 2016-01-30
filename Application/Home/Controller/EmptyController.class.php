<?php
/**
 * Created by PhpStorm.
 * User: raychen
 * Date: 16/1/30
 * Time: 20:00
 */

namespace Home\Controller;
use Think\Controller;

class EmptyController extends Controller
{
    public function index(){
        echo CONTROLLER_NAME;
    }
}