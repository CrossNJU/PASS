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
        $this->redirect('Student/my_course');
    }

    public function sets(){//学生-设置
        if(!session('?per') || session('per')!= 1)
            $this->redirect('Home/Common/login/res/login-war/type/war');

        $this->msg = "";//消息

        $stu = session('user');
        $user_model = D('User');
        $student = $user_model->where("number = '$stu'")->select()[0];
        $this->info = $student;//学生原始信息,字段参见数据库

        if(isset($_POST['save_info'])){
            $data['number'] = I('post.number');
            $data['name'] = I('post.name');
            $data['phone'] = I('post.phone');
            $data['academy'] = I('post.academy');
            $data['speciality'] = I('post.speciality');
            $data['grade'] = I('post.grade');
            $data['email'] = I('post.email');
            if($user_model->save($data)) {
                $this->msg = "保存成功!";
                $this->type = "success";
                session('user',$data['number']);
                $stu = session('user');
                $student = $user_model->where("number = '$stu'")->select()[0];
                $this->info = $student;
            }
            else {
                $this->msg = "保存失败!";
                $this->type = "danger";
            }
        }
        if(isset($_POST['save_pwd'])){
            $old = I('post.old_pwd');
            $old_in_db = $user_model->where("number = '$stu'")->getField('password');
            if(md5($old)!=$old_in_db) {
                $this->msg = "原密码错误!";
                $this->type = "danger";
            }

            $new = I('post.new_pwd');
            $row['password'] = $new;
            $row['number'] = $stu;
            $res = $user_model->create($row);
            if($res) {
                $user_model->save();
                $this->msg = "保存成功!";
                $this->type = "success";
            }
            else {
                $this->msg = "保存失败!";
                $this->type = "danger";
            }
        }

        $this->display('Student:setting-stu');
    }

    public function my_course($res = NULL,$type = NULL){//学生-我的课程
        if(!session('?user') || session('per')!=1)
            $this->redirect('Home/Common/login/res/login-war/type/war');
        $common_logic = D('Common','Logic');
        $this->msg = "";
        if($res!=NULL) {
            $message = $common_logic->getMessage($res,$type);
            $this->msg = $message['res'];
            $this->type = $message['type'];
        }
        $student_id = session('user');

        $course_model = M('Course');
        $course_dis_model = M('Coursedis');
        $course_ids = $course_dis_model->where("stdNumber = '$student_id'")
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
        $this->courses = $courses;

        $this->display('Student:mycourse-stu');
    }

    public function my_assignment($res=NULL,$type=NULL){//学生-我的作业
        if(!session('?user') || session('per')!=1)
            $this->redirect('Home/Common/login/res/login-war/type/war');
        $student_id = session('user');

        $common_logic = D('Common','Logic');
        $this->msg = "";
        if($res!=NULL) {
            $message = $common_logic->getMessage($res,$type);
            $this->msg = $message['res'];
            $this->type = $message['type'];
        }

        $course_dis_model = M('Coursedis');
        $course_ids = $course_dis_model->where("stdnumber = '$student_id'")
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
        $this->homeworkDetails = $assignments;
        $this->display('Student:myhomework-stu');
    }

    public function course_remove($course_id){//退选课程
        if(!session('?user') || session('per')!=1)
            $this->redirect('Home/Common/login/res/login-war/type/war');
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

    public function course_in(){//学生-加入新课程
        if(!session('?user') || session('per')!=1)
            $this->redirect('Home/Common/login/res/login-war/type/war');

        $course_model = M('Course');
        $course_all = $course_model->select();
        $course_logic = D('Course','Logic');
        $user_logic = D('User','Logic');
        $status = $course_logic->get_course_status($course_all);

        if(isset($_POST['search'])){
            $key = I('post.search');
            $course_all = $course_model
                ->where("title = '$key' OR number = '$key'")
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

    public function course_add($course_id){//点击加入课程
        if(!session('?user') || session('per')!=1)
            $this->redirect('Home/Common/login/res/login-war/type/war');
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
        $assignments = $assignment_model->where("course = '$course_id'")->select();
        foreach ($assignments as $assignment){
            $course_logic->assignment_dis($course_id,$assignment['number'],$student_id);
        }

        $this->ajaxReturn(1);
    }

    public function assignment_see($assignment_id){//预览作业...url还有问题
        if(!session('?user') || session('per')!=1)
            $this->redirect('Home/Common/login/res/login-war/type/war');
        $student_id = session('user');
        $course_logic = D('Course','Logic');

        $assignment_dis_model = M('Assignmentdis');
        $assignment = $assignment_dis_model
            ->where("assNumber = '$assignment_id' AND stdNumber = '$student_id'")
            ->select()[0];

//        $url_base = C('URL_BASE');
        $this->submit = array(
            'name' => $assignment['submitname'],
            'time' => $assignment['submittime']
        );
        $this->homework = array(
            'num' => $assignment_id,
            'name' => $course_logic->get_assignment_name($assignment_id),
            'submitName' => $assignment['submittime'],
            'submitTime' => $assignment['submitName']
        );
        $this->display('Student:preview');
    }

    public function assignment_submit($assignment_id){//提交作业
        if(!session('?user') || session('per')!=1)
            $this->redirect('Home/Common/login/res/login-war/type/war');
        $student_id = session('user');

        $this->msg = "";

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
                $this->msg = "上传失败!";
                $this->type = "danger";
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
                    $assignment_model = M('Assignment');
                    $assignment_model->where("number = '$assignment_id'")->setInc('submitted');
                }
                $data['url'] = $url;
                $data['submitTime'] = date("y-m-d h:i");
                $data['submitName'] = $real_info['name'];
                $data['saveName'] = $real_info['savename'];
                $data['saveType'] = $real_info['ext'];
                $assignment_dis_model
                    ->where("stdNumber = '$student_id' AND assNumber = '$assignment_id'")
                    ->save($data);
                $this->redirect('Home/Student/my_assignment/res/upload-suc/type/suc');
            }
        }

        $this->display('Student/submit');
    }

    public function student_detail($student_id){//学生详情界面
        $user_model = M('User');
        $student = $user_model->where("number = '$student_id'")->select()[0];
        $student_detail = array(
            'name' => $student['name'],
            'id' => $student['number'],
            'academy' => $student['academy'],
            'email' => $student['email'],
            'grade' => $student['grade'],
            'phone' => $student['phone'],
        );
        $this->ajaxReturn($student_detail);
    }
}