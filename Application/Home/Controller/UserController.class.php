<?php
/**
 * Created by PhpStorm.
 * User: raychen
 * Date: 16/1/30
 * Time: 17:05
 */

namespace Home\Controller;
use Think\Controller;
use Think\Upload;
use PHPWord;
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
//        $course_dis_model = M('Coursedis');
//        $data['cNumber'] = '1';
//        $data['stdNumber'] = 'cr';
//        $data['cName'] = '1';
//        $res = $course_dis_model
//            ->where("cNumber = '1' AND stdNumber = 'cr' AND cName = '1'")->select();
////        dump($test);
//        dump($res);
        $this->display('User:test1');
    }

    public function test_url($id1,$id2){
        echo $id1." ".$id2;
//        $this->display('User:test2');
    }

    public function test2(){
        $upload = new Upload();// 实例化上传类
        $upload->maxSize = 3145728 ;// 设置附件上传大小
        $upload->exts = array('pdf');// 设置附件上传类型
        $upload->rootPath = './Public/uploads/'; // 设置附件上传根目录
        $upload->savePath = '';
        $upload->subName = 'assignments/S1';
        $upload->saveName = 'source';
        if(isset($_POST['sub'])) {
            $info = $upload->upload();
            dump($info);
        }
        $this->display('User:test2');
    }

    public function index(){
//        echo "index";
        $this->test_url();
    }

    public function doc_read(){
        vendor('PHPWord.PHPWord');
        $word = new PHPWord();

        $section = $word->createSection();
        $section->addText("my name is cr");
        $section->addTextBreak(2);
        $section->addText(98);

        $output = \PHPWord_IOFactory::createWriter($word,'Word2007');
        $output->save('./Public/uploads/cr.doc');
    }
}