<?php
/**
 * Created by PhpStorm.
 * User: raychen
 * Date: 16/2/6
 * Time: 10:14
 */

namespace Home\Controller;
use Think\Controller;

class AdministerController extends Controller
{
    public function index(){
        $validate_logic = D('Validate','Logic');
        if(!$validate_logic->checkLogin(3)) $this->redirect('Common/login');
        $validate_logic->setSession();

        $this->display('Administrator:student-admin');
    }

    public function student_manage(){//......................................................学生管理

        $validate_logic = D('Validate','Logic');
        if(!$validate_logic->checkLogin(3)) $this->redirect('Common/login');
        $validate_logic->setSession();

        $all = $this->user_show(1);
        if(isset($_POST['find'])){//查找学生,空白默认查找全部
            $key = I('post.search');
            if($key != "") $all = $this->user_find(1,$key);
        }
        $students = array();
        $i = 0;
        foreach ($all as $student){
            $courses = $this->stu_show_course($student['number']);
            $student_detail = array(
                'order' => $i+1,
                'name' => $student['name'],
                'num' => $student['number'],
                'major' => $student['academy'].'-'.$student['speciality'],
                'grade' => $student['grade'],
                'numOfClass' => count($courses),
                'classes' => $courses
            );
            $students[$i] = $student_detail;
            $i ++;
        }

        $this->numbers = count($this->user_show(1));
        $this->students = $students;
        $this->display('Administrator:student-admin');
    }

    protected function user_show($per){
        $user_model = M('User');
        return $user_model->where("permission = '$per'")->order('number')->select();
    }

    protected function user_find($per, $key){
        $user_model = M('User');
        $where['_string']='(name like "%'.$key.'%")  OR (number like "%'.$key.'%")';
        $all = $user_model->where($where)->order('save_time desc')->select();
        $ret = array();
        $i = 0;
        foreach ($all as $user){
            if($user['permission'] == $per){
                $ret[$i] = $user;
                $i++;
            }
        }
        return $ret;
    }

    public function stu_del($stu_id){//..........................................................................删除学生

        $validate_logic = D('Validate','Logic');
        if(!$validate_logic->checkLogin(3)) $this->redirect('Common/login');
        $validate_logic->setSession();

        $user_model = M('User');
        $course_model = M('Course');
        $course_dis_model = M('Coursedis');
        $assignment_dis_model = M('Assignmentdis');
        $user_model->where("number = '$stu_id' AND permission = 1")->delete();
        $courses = $course_dis_model->where("stdNumber = '$stu_id'")->select();
        foreach ($courses as $course){
            $course_id = $course['cnumber'];
            $course_model->where("number = '$course_id'")->setDec('selected');
        }
        $course_dis_model->where("stdNumber = '$stu_id'")->delete();
        $assignment_dis_model->where("stdNumber = '$stu_id'")->delete();
        $this->ajaxReturn(1);
    }

    protected function stu_show_course($stu_id){//显示学生所选课程名
        $course_dis_model = M('Coursedis');
        $course_model = M('Course');
        $rows = $course_dis_model->where("stdNumber = '$stu_id'")->order('add_time desc')->select();
        $i = 0;
        $titles = array();
        foreach ($rows as $course){
            $course_id = $course['cnumber'];
            $course_detail = $course_model->where("number = '$course_id'")
                ->select() [0];
            $titles[$i] = array(
                'name' => $course_detail['title']
            );
            $i++;
        }
        return $titles;
    }

    public function student_add($id = NULL)//....................................................................添加学生
    {

        $validate_logic = D('Validate','Logic');
        if(!$validate_logic->checkLogin(3)) $this->redirect('Common/login');
        $validate_logic->setSession();

        $user_model = D('User');

        if($id != NULL){
            $stu = $user_model->where("number = '$id'")->select()[0];
            $stu['password'] = '12345678';
            $this->student = $stu;//当前学生
            $this->isAdmin = true;
        }

        if (isset($_POST['register'])) {

            $student_id = I('post.stu_id');
            $rows = $user_model->where("number = '$student_id'")->select();
            //$change_pwd = false;
            if($id == NULL && count($rows)>0){
                $validate_logic->sendMsg('学生已存在','warning',0);
            }else{

                $data['number'] = $student_id;
                if(I('post.pwd')!=null){
                    $data['password'] = I('post.pwd');
                    //$change_pwd = true;
                }
                $data['phone'] = I('post.phone');
                $data['email'] = I('post.email');
                $data['name'] = I('post.name');
                $data['academy'] = I('post.aca');
                $data['speciality'] = I('post.spe');
                $data['grade'] = I('post.grade');
                $data['save_time'] = date("y-m-d h:i:s");
                $data['permission'] = 1;
                if($id == NULL && $user_model->create($data)){
                    $user_model->add();
                    $validate_logic->sendMsg('增加学生成功','success');
                    $this->redirect('Administer/student_manage');
                }elseif ($id != NULL && $user_model->save($data)){
                    //$user_model->save();
                    $validate_logic->sendMsg('修改学生成功','success');
                    $this->redirect('Administer/student_manage');
//                }elseif ($id != NULL && !$change_pwd && $user_model->save($data)){
//                    $validate_logic->sendMsg('修改学生成功','success');
//                    $this->redirect('Administer/student_manage');
                } else {
                    $validate_logic->sendMsg($user_model->getError(),'danger',0);
                }

            }
        }

        if($id == NULL) $this->display('Administrator:student-add');
        else $this->display('Administrator:student-modify');
    }

    //--------------------------------------------------------------------------

    public function course_manage(){//..................................................课程管理

        $validate_logic = D('Validate','Logic');
        if(!$validate_logic->checkLogin(3)) $this->redirect('Common/login');
        $validate_logic->setSession();

        $course_logic = D('Course','Logic');
        $user_logic = D('User','Logic');
        $all = $this->course_show();
        if (isset($_POST['find'])){
            $key = I('post.search');
            if($key!="") $all = $this->course_find($key);
        }
        $courses = array();
        $i = 0;
        foreach ($all as $course){
            $course_detail = array(
                'order' => $i +1,
                'num' => $course['number'],
                'number' => $course['number_display'],
                'name' => $course['title'],
                'nameOfTea' => $user_logic->get_user_name($course['teacher']),
                'numOfHomework' => $course['assignments'],
                'homeworks' => $course_logic->get_assignments_course($course['number'])
            );
            $courses[$i] = $course_detail;
            $i ++;
        }

        $this->numbers = count($this->course_show());
        $this->courses = $courses;
        $this->display('Administrator:lesson-admin');
    }

    protected function course_show(){
        $course = M('Course');
        return $course->order('create_time desc')->select();
    }

    protected function course_find($key){
        $course = M('Course');
        $where['_string']='(number_display like "%'.$key.'%")  OR (title like "%'.$key.'%") OR (teacher_name like "%'.$key.'%")';
        return $course->where($where)->order('create_time desc')->select();
    }

    public function course_del($course_id){//....................................................................删除课程

        $validate_logic = D('Validate','Logic');
        if(!$validate_logic->checkLogin(3)) $this->redirect('Common/login');
        $validate_logic->setSession();

        $course_model = M('Course');
        $course_dis_model = M('Coursedis');
        $assignment_model = M('Assignment');
        $assignment_dis_model = M('Assignmentdis');
        $assignment_model->where("course = '$course_id'")->delete();
        $assignment_dis_model->where("cNumber = '$course_id'")->delete();
        $course_dis_model->where("cNumber = '$course_id'")->delete();
        $course_model->where("number = '$course_id'")->delete();
        $this->ajaxReturn(1);
    }

    public function course_add($id = NULL,$teacher_id = NULL){//.................................................新增课程

        $validate_logic = D('Validate','Logic');
        if(!$validate_logic->checkLogin(3)) $this->redirect('Common/login');
        $validate_logic->setSession();
        $course_model = D('Course');
        $user_model = M('User');
        $common_logic = D('Common', 'Logic');
        $user_logic = D('User','Logic');

        if($id != NULL){
            $cou = $course_model->where("number = '$id'")->select()[0];
            $spl = explode(' ',$cou['time']);
            $cou['year'] = $spl[0];
            $cou['season'] = $spl[1];
            $this->course = $cou;
        }

        if(isset($_POST['add'])){
            $data['title'] = I('post.title');
            $data['teacher'] = I('post.teacher');
            $data['teacher_name'] = $user_logic->get_user_name($data['teacher']);
            $data['depict'] = I('post.depict');
            $data['students'] = I('post.people');
            $data['time'] = I('post.year')." ".I('post.season');
            if($id == NULL) {
                $data['assignments'] = 0;
                $data['selected'] = 0;
                $data['create_time'] = date("y-m-d");
            }
            $teacher = $data['teacher'];
            $search_teacher = $user_model->where("number = '$teacher'")->select();
            if($id ==  NULL && count($search_teacher)==0){
                $validate_logic->sendMsg('教师不存在','warning',0);
            }elseif($id == NULL && $course_model->create($data)) {
                $course_id = $course_model->add();
                $data['number'] = $course_id;
                $data['number_display'] = $common_logic->get_display_number($course_id,1);
                $course_model->save($data);
                $validate_logic->sendMsg('增加课程成功','success');
                $this->redirect('Administer/course_manage');
            }elseif($id != NULL && $course_model->where("number = '$id'")->create($data)){
                $course_model->save();
                $validate_logic->sendMsg('修改课程成功','success');
                $this->redirect('Administer/course_manage');
            }else {
                $validate_logic->sendMsg($course_model->getError(),'danger',0);
            }
        }

        $this->teachers = $user_model->where("permission = 2")->select();

        if($id!= NULL) $this->display('Administrator:lesson-modify');
        else if($teacher_id!= NULL){
            $this->teacher = $teacher_id;
            $this->display('Administrator:teacher-lesson-add');
        } else $this->display('Administrator:lesson-add');

    }

    public function download($assignment_id){//..................................................................批量下载

        $validate_logic = D('Validate','Logic');
        if(!$validate_logic->checkLogin(3)) $this->redirect('Common/login');
        $validate_logic->setSession();

        $common_logic = D('Common','Logic');
        $url = $common_logic->addToZip($assignment_id);
        $this->ajaxReturn($url);
    }
    //--------------------------------------------------------------------------

    public function teacher_manage(){//......................................................教师管理

        $validate_logic = D('Validate','Logic');
        if(!$validate_logic->checkLogin(3)) $this->redirect('Common/login');
        $validate_logic->setSession();

        $all = $this->user_show(2);

        if(isset($_POST['find'])){//查找课程,空白默认查找全部
            $key = I('post.search');
            if($key != "") $all = $this->user_find(2,$key);
        }
        $teachers = array();
        $i = 0;
        foreach ($all as $teacher){
            $courses = $this->teacher_show_courses($teacher['number']);
            $teacher_detail = array(
                'order' => $i+1,
                'name' => $teacher['name'],
                'num' => $teacher['number'],
                'numOfClass' => count($courses),
                'classes' => $courses,
            );
            $teachers[$i] = $teacher_detail;
            $i ++;
        }

        $this->numbers = count($this->user_show(2));
        $this->teachers = $teachers;
        $this->display('Administrator:teacher-admin');
    }

    public function teacher_del($teacher_id){//..................................................................删除教师

        $validate_logic = D('Validate','Logic');
        if(!$validate_logic->checkLogin(3)) $this->redirect('Common/login');
        $validate_logic->setSession();

        $user_model = M('User');
        $course_model = M('Course');
        $course_dis_model = M('Coursedis');
        $assignment_dis_model = M('Assignmentdis');
        $assignment_model = M('Assignment');
        $user_model->where("number = '$teacher_id'")->delete();
        $courses = $course_model->where("teacher = '$teacher_id'")->select();
        foreach ($courses as $course){
            $course_id = $course['number'];
            $course_dis_model->where("cNumber = '$course_id")->delete();
            $assignment_dis_model->where("cNumber = '$course_id")->delete();
        }
        $assignment_model->where("teacher = '$teacher_id'")->delete();
        $course_model->where("teacher = '$teacher_id'")->delete();
        $this->ajaxReturn(1);
    }

    protected function teacher_show_courses($teacher_id){//显示课程作业
        $course_model = M('Course');
        $courses = $course_model->where("teacher = '$teacher_id'")->order('create_time desc')->select();
        $course_details = array();
        $i = 0;
        foreach ($courses as $course){
            $course_detail = array(
                'name' => $course['title']
            );
            $course_details[$i] = $course_detail;
            $i ++;
        }
        return $course_details;
    }

    public function teacher_add($id = NULL){//...................................................................新增教师

        $validate_logic = D('Validate','Logic');
        if(!$validate_logic->checkLogin(3)) $this->redirect('Common/login');
        $validate_logic->setSession();

        $user_model = D('User');

        if($id!= NULL){
            $tea = $user_model->where("number = '$id'")->select()[0];
            $tea['password'] = '12345678';
            $this->teacher = $tea;
        }

        if(isset($_POST['add'])){

            $teacher_id = I('post.tea_id');
            $rows = $user_model->where("number = '$teacher_id'")->select();
            $change_pwd = false;
           if($id == NULL && count($rows)>0){
               $validate_logic->sendMsg('已存在教师','warning',0);
           }else {
               $data['number'] = $teacher_id;
               if(I('post.pwd')!=null) {
                   $data['password'] = I('post.pwd');
                   $change_pwd = true;
               }
               $data['phone'] = I('post.phone');
               $data['email'] = I('post.email');
               $data['name'] = I('post.name');
               $data['academy'] = I('post.aca');
               $data['speciality'] = I('post.spe');
               $data['save_time'] = date("y-m-d h:i:s");
               $data['permission'] = 2;
               if($id == NULL && $user_model->create($data)){
                   $user_model->add();
                   $validate_logic->sendMsg('增加教师成功','success');
                   $this->redirect('Administer/teacher_manage');
               }
               elseif($id!=NULL && $user_model->create($data)){
                   $user_model->save();
                   $validate_logic->sendMsg('修改教师成功','success');
                   $this->redirect('Administer/teacher_manage');
//               }
//               elseif($id!=NULL && !$change_pwd && $user_model->save($data)){
//                   $validate_logic->sendMsg('修改教师成功','success');
//                   $this->redirect('Administer/teacher_manage');
               } else{
                   $validate_logic->sendMsg('增加/修改教师失败','danger',0);
               }

           }

        }

        if ($id== NULL) $this->display('Administrator:teacher-add');
        else $this->display('Administrator:teacher-modify');
    }

    //查看选择某门课程的学生信息
    public function course_student($course_id){

        $validate_logic = D('Validate','Logic');
        if(!$validate_logic->checkLogin(3)) $this->redirect('Common/login');
        $validate_logic->setSession();

        $course_dis_model = M('Coursedis');
        $user_model = M('User');
        $student_ids = $course_dis_model->where("cNumber = '$course_id'")->select();
        $ret = [];
        $i = 0;
        foreach($student_ids as $student_id){
            $id = $student_id['stdnumber'];
            $student = $user_model->where("number = '$id'")->select()[0];
            $ret[$i] = [
                'id' => $student['number'],
                'name' => $student['name'],
                'academy' => $student['academy'],
                'speciality' => $student['speciality']
            ];
//            $ret[$i] = $student;
            $i++;
        }
        $this->ajaxReturn($ret);
    }

    // 查看反馈信息
    // 返回字段 feedback[i=>['number','name','permission','content','add_time']]
    // 显示页面 Administrator/feedback
    public function check_feedback(){
        $validate_logic = D('Validate','Logic');
        if(!$validate_logic->checkLogin(3)) $this->redirect('Common/login');
        $validate_logic->setSession();

        $feedback_model = M('Feedback');
        $this->feedback = $feedback_model->select();
        $this->display('Administrator:feedback-admin');
    }

    public function _empty(){
        $this->display('Common:not-found');
    }

}
