<?php
/**
 * Created by PhpStorm.
 * User: raychen
 * Date: 16/2/6
 * Time: 10:31
 */

namespace Home\Controller;
use Think\Controller;
use Think\Upload;

class StudentController extends Controller
{

    public function index(){
        $validate_logic = D('Validate','Logic');
        if(!$validate_logic->checkLogin(1)) $this->redirect('Common/login');
        $validate_logic->setSession();

        $this->redirect('Student/my_course');
    }

    public function sets(){//...................................................................................学生-设置

        $validate_logic = D('Validate','Logic');
        if(!$validate_logic->checkLogin(1)) $this->redirect('Common/login');
        $validate_logic->setSession();

        $stu = session('user');
        $user_model = D('User');
        $user_logic = D('User','Logic');
        $student = $user_model->where("number = '$stu'")->select()[0];
        $this->student = $student;//学生原始信息,字段参见数据库
        $this->isAdmin = false;

        if(isset($_POST['register'])){
            $data['number'] = I('post.stu_id');
            $data['name'] = I('post.name');
            $data['phone'] = I('post.phone');
            $data['academy'] = I('post.aca');
            $data['speciality'] = I('post.spe');
            $data['grade'] = I('post.grade');
            $data['email'] = I('post.email');
            if($user_model->create($data)) {
                $user_model->add();
                $validate_logic->sendMsg('保存成功','success');
                session('user',$data['number']);
                session("username",$user_logic->get_user_name($data['number']));
                $stu = session('user');
                $student = $user_model->where("number = '$stu'")->select()[0];
                $this->student = $student;
                $this->redirect('Student/my_course');
            }
            else {
                $validate_logic->sendMsg('保存失败','danger',0);
            }
        }
        if(isset($_POST['save_pwd'])){
            $old = I('post.old_pwd');
            $old_in_db = $user_model->where("number = '$stu'")->getField('password');
            if(md5($old)!=$old_in_db) {
                $validate_logic->sendMsg('原密码错误','danger',0);
            }else{
                $new = I('post.new_pwd');
                $row['password'] = $new;
                $row['number'] = $stu;
                $res = $user_model->create($row);
                if($res) {
                    $user_model->save();
                    $validate_logic->sendMsg('保存成功','success');
                    $this->redirect('Student/my_course');
                }
                else {
                    $validate_logic->sendMsg('保存失败','danger',0);
                }
            }

        }

        $this->display('Administrator:student-modify');
    }

    public function my_course(){//..................................................学生-我的课程

        $validate_logic = D('Validate','Logic');
        if(!$validate_logic->checkLogin(1)) $this->redirect('Common/login');
        $validate_logic->setSession();

        $student_id = session('user');

        $course_model = M('Course');
        $course_dis_model = M('Coursedis');
        $course_ids = $course_dis_model->where("stdNumber = '$student_id'")
            ->order('add_time desc')
            ->select();
        $i = 0;
        $courses = array();
        $course_logic = D('Course','Logic');
        $user_logic = D('User','Logic');
        foreach ($course_ids as $var){
            $course_id = $var['cnumber'];
            $course = $course_model->where("number = '$course_id'")
                ->select() [0];
            $course_detail = array(
                'num' => $course['number_display'],
                'id' => $course['number'],
                'period' => $course['time'],
                'name' => $course['title'],
                'teacher' => $user_logic->get_user_name($course['teacher']),
                'numOfStu' =>$course['selected'],
                'description' => $course['depict'],
                'numOfHomework' => $course['assignments'],
                'homework' => $course_logic->get_assignments_student($course_id)
            );
            $courses[$i] = $course_detail;
            $i ++;
        }
//        dump($courses);
        $this->courses = $courses;

        $this->display('Student:mycourse-stu');
    }

    public function my_assignment($reload=0){//..................................................学生-我的作业

        if($reload == 1)
            session('forUrl','Student/my_assignment');
        else session('forUrl',null);

        $validate_logic = D('Validate','Logic');
        if(!$validate_logic->checkLogin(1)) $this->redirect('Common/login');
        $validate_logic->setSession();

        $student_id = session('user');

        $course_dis_model = M('Coursedis');
        $course_ids = $course_dis_model->where("stdnumber = '$student_id'")
            ->order('add_time desc')
            ->select();
        $i = 0;
        $assignments = array();
        $course_logic = D('Course','Logic');
        foreach ($course_ids as $var){
            $course_id = $var['cnumber'];
            $assignment = $course_logic->get_assignments_student($course_id);
            foreach ($assignment as $assignment_detail){
                $assignments[$i] = $assignment_detail;
                $i ++;
            }
        }
//        dump($assignments);
        $this->homeworkDetails = $assignments;
        $this->display('Student:myhomework-stu');
    }

    public function course_remove($course_id){//.................................................................退选课程

        $validate_logic = D('Validate','Logic');
        if(!$validate_logic->checkLogin(1)) $this->redirect('Common/login');
        $validate_logic->setSession();

        $student_id = session('user');

        $course_dis_model = M('Coursedis');
        $course_model = M('Course');
        $assign_dis_model = M('Assignmentdis');

        $assign_dis_model->where("cNumber = '$course_id'")->delete();
        $course_model->where("number = '$course_id'")->setDec('selected');
        $course_dis_model->where("stdNumber = '$student_id' AND cNumber = '$course_id'")
            ->delete();
        $this->ajaxReturn(1);
    }

    public function course_in(){//.........................................................................学生-加入新课程

        $validate_logic = D('Validate','Logic');
        if(!$validate_logic->checkLogin(1)) $this->redirect('Common/login');
        $validate_logic->setSession();

        $course_model = M('Course');
        $course_all = $course_model->order('create_time desc')->select();
        $course_logic = D('Course','Logic');
        $user_logic = D('User','Logic');
        $status = $course_logic->get_course_status($course_all);

        if(isset($_POST['search'])){
            $key = I('post.search');
            $where['_string']='(number_display like "%'.$key.'%")  OR (title like "%'.$key.'%")';
            $course_all = $course_model
                ->where($where)
                ->order('create_time desc')
                ->select();
            $status = $course_logic->get_course_status($course_all);
        }

        $i = 0;
        $courses = array();
        for ($j = 0; $j<count($course_all); $j++){
            if($status[$j] == true) continue;
            $course = $course_all[$j];
            $course_single = array(
                'num' => $course['number_display'],
                'id' => $course['number'],
                'period' => $course['time'],
                'name' => $course['title'],
                'teacher' => $user_logic->get_user_name($course['teacher']),
                'numOfStu' => $course['selected'],
                'description' => $course['depict']
            );
            $courses[$i] = $course_single;
            $i++;
        }

        $this->courses = $courses;
        $this->display('Student:joincourse');
    }

    public function course_add($course_id){//................................................................点击加入课程

        $validate_logic = D('Validate','Logic');
        if(!$validate_logic->checkLogin(1)) $this->redirect('Common/login');
        $validate_logic->setSession();

        $student_id = session('user');

        $course_model = M('Course');
        $course_model->where("number = '$course_id'")
            ->setInc('selected');

        $course_dis_model = M('Coursedis');
        $data['cNumber'] = $course_id;
        $data['stdNumber'] = $student_id;
        $course_dis_model->add($data);

        $assignment_model = M('Assignment');
        $course_logic = D('Course','Logic');
        $assignments = $assignment_model->where("course = '$course_id'")->order('endtime desc')->select();
        foreach ($assignments as $assignment){
            $course_logic->assignment_dis($course_id,$assignment['number'],$student_id);
        }

        $this->ajaxReturn(1);
    }

    public function assignment_submit($assignment_id){//.........................................................提交作业

        $validate_logic = D('Validate','Logic');
        if(!$validate_logic->checkLogin(1)) $this->redirect('Common/login');
        $validate_logic->setSession();

        $student_id = session('user');

        $upload = new Upload();

        $upload->maxSize = 1000000000 ;// 设置附件上传大小
        $upload->exts = array('pdf','doc','docx','ppt','pptx','mp4');// 设置附件上传类型
        $upload->rootPath = C('URL_BASE'); // 设置附件上传根目录
        $upload->savePath = '';
        $upload->subName = 'assignments/'.$student_id.'/'.$assignment_id;
        $upload->saveName = 'source';
        $upload->replace = true;

        if(isset($_REQUEST['sub'])) {
            $info = $upload->upload();
            if(!$info) {
                $validate_logic->sendMsg('上传失败','danger',0);
            }
            else{
                $real_info = $info['doc'];
                $url = $real_info['savepath'];
                $assignment_dis_model = M('Assignmentdis');
                $assignment = $assignment_dis_model
                    ->where("stdNumber = '$student_id' AND assNumber = '$assignment_id'")
                    ->select()[0];
                if($assignment['issubmitted']==0){
                    $data['isSubmitted'] = 1;
                }
                $data['url'] = $url;
                $data['submitTime'] = date("y-m-d h:i");
                $data['submitName'] = $real_info['name'];
                $data['saveName'] = $real_info['savename'];
                $data['saveType'] = $real_info['ext'];
                $assignment_dis_model
                    ->where("stdNumber = '$student_id' AND assNumber = '$assignment_id'")
                    ->save($data);
                $validate_logic->sendMsg('上传成功','success');
                $this->redirect('Student/my_assignment');
            }
        }

        $assignment_model = M('Assignment');
        $assignment_dis_model = M('Assignmentdis');
        $assignment_detail = $assignment_model->where("number = '$assignment_id'")->select()[0];
        $assignment_dis_detail = $assignment_dis_model->where("assNumber = '$assignment_id' AND stdNumber = '$student_id'")->select()[0];
        $sub = array(
            'homeworkName' => $assignment_detail['title'],
            'submitted' => -1
        );
        if($assignment_dis_detail['issubmitted'] == 1){
            $sub['submitted'] = $assignment_dis_detail['submitname'];
        }
        $this->submit = $sub;
        $this->type = $assignment_detail['type'];
        $this->display('Student/submit');
    }

    public function _empty(){
        $this->display('Common:not-found');
    }
}