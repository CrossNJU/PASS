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
        if(isset($_POST['test1'])){
//            echo "in";
            $data['info'] = "success";
            $this->ajaxReturn($data);
        }
        if(isset($_POST['test2'])){
            $this->assign('mess','bbc');
//            return;
        }
        $this->mess = "a";
        $this->display('User:test1');
    }

    public function test_url(){
        $this->display('User:test2');
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

    public function get_display_number($number, $type){
        if ($type == 1){//课程
            echo 'PC'.$this->get_string($number);
        }
        echo "NULL";
    }

    private function get_string($p){
        $ret = '';
        $len = 0;
        $ps = $p;
        while($ps>=1){
            $len++;
            $ps/=10;
        }
        for($i=0;$i<4-$len;$i++) $ret.='0';
        $ret.=$p;
        return $ret;
    }
    public function php(){
//        phpinfo();
        $zip = new \ZipArchive();
        $filename = "./Public/uploads/assignments/S1/test.zip";

        if (!$zip->open($filename, \ZIPARCHIVE::CREATE)) {
            exit("cannot open <$filename>\n");
        } else {
            echo "file <$filename> OK\n";
        }

        $zip->addFromString("testfilephp.txt", "#1 This is a test string added as testfilephp.txt.\n");
        $zip->addFromString("testfilephp2.txt", "#2 This is a test string added as testfilephp2.txt.\n");
//        $zip->addFile($thisdir . "/too.php","/testfromfile.php");
        echo "numfiles: " . $zip->numFiles . "\n";
        echo "status:" . $zip->status . "\n";
        $zip->close();
        unset($zip);

    }

    public function my_upload(){

        $upload = new Upload();

        $upload->maxSize = 3145728 ;// 设置附件上传大小
        $upload->exts = array('pdf');// 设置附件上传类型
        $upload->rootPath = C('URL_BASE'); // 设置附件上传根目录
        $upload->savePath = '';
        $upload->subName = 'assignments/'.'S1'.'/'.'1';
        $upload->saveName = 'source';
        $upload->replace = true;

        if(isset($_POST['sub'])){
            $info = $upload->upload();
            dump($info);
        }

        $this->display('User:test2');
    }

    public function add_word(){
        $common_logic = D('Common','Logic');
        $common_logic->save_as_word("test","test","S1","1");
    }

    public function download(){
        echo "in";
        $zip = new \ZipArchive();
        $zip->open('./Public/uploads/downloads/1.zip',\ZIPARCHIVE::CREATE | \ZIPARCHIVE::OVERWRITE);
        $zip->addFile('./Public/uploads/assignments/S1-1/source.pdf','S1/source.pdf');
        $zip->addFile('./Public/uploads/assignments/S1-1/modify.doc','S1/modify.doc');
        $zip->addFile('./Public/uploads/assignments/S1-2/source.pdf','S2/S3/source.pdf');
        $zip->addFile('./Public/uploads/assignments/S1-2/modify.doc','S2/modify.doc');
        echo $zip->numFiles;
        $zip->close();
        unset($zip);
//        $this->display('User:test_down');
    }

}