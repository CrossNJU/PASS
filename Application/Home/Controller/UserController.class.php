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
//        $course_model = M('Coursedis');
//        $students = $course_model->where("cNumber = '1'")
//            ->field('stdNumber')->select();
//        foreach ($students as $s){
////            dump($s);
//            echo $s['stdnumber'];
//        }
        $course_dis_model = M('Coursedis');
        $data['cNumber'] = '1';
        $data['stdNumber'] = 'cr';
        $data['cName'] = '1';
        $res = $course_dis_model
            ->where("cNumber = '1' AND stdNumber = 'cr' AND cName = '1'")->select();
//        dump($test);
        dump($res);
    }

    public function test_url($id="0"){
        echo $id;
        $this->display('User:test2');
    }

    public function test2(){
        $this->ajaxReturn(12);
    }

    public function index(){
//        echo "index";
        $this->test_url();
    }
}