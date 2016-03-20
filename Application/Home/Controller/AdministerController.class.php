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
        if(!session('?user') || session('per')!=3)
            $this->redirect('Home/Common/login/res/login-war/type/war');

        $this->display('Administrator:student-admin');
    }

    public function student_manage($res=NULL,$type=NULL){//......................................................学生管理
        if(!session('?user') || session('per')!=3)
            $this->redirect('Home/Common/login/res/login-war/type/war');

        $common_logic = D('Common','Logic');
        $this->msg = "";
        if($res!=NULL) {
            $message = $common_logic->getMessage($res,$type);
            $this->msg = $message['res'];
            $this->type = $message['type'];
        }

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
        return $user_model->where("permission = '$per'")->select();
    }

    protected function user_find($per, $key){
        $user_model = M('User');
        $all = $user_model->where("name = '$key' OR number = '$key'")->select();
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
        if(!session('?user') || session('per')!=3)
            $this->redirect('Home/Common/login/res/login-war/type/war');

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
        $rows = $course_dis_model->where("stdNumber = '$stu_id'")->select();
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
        if(!session('?user') || session('per')!=3)
            $this->redirect('Home/Common/login/res/login-war/type/war');

        $this->msg = "";
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
            $change_pwd = false;
            if($id == NULL && count($rows)>0){
                $this->msg = "学生已存在!";
                $this->type = "warning";
            }else{

                $data['number'] = $student_id;
                if(I('post.pwd')!=null){
                    $data['password'] = I('post.pwd');
                    $change_pwd = true;
                }
                $data['phone'] = I('post.phone');
                $data['email'] = I('post.email');
                $data['name'] = I('post.name');
                $data['academy'] = I('post.aca');
                $data['speciality'] = I('post.spe');
                $data['grade'] = I('post.grade');
                $data['permission'] = 1;
                if($id == NULL && $user_model->create($data)){
                    $user_model->add();
                    $this->redirect('Home/Administer/student_manage/res/add-stu-suc/type/suc');
                }elseif ($id != NULL && $change_pwd && $user_model->create($data)){
                    $user_model->save();
                    $this->redirect('Home/Administer/student_manage/res/mod-stu-suc/type/suc');
                }elseif ($id != NULL && !$change_pwd && $user_model->save($data)){
                    $this->redirect('Home/Administer/student_manage/res/mod-stu-suc/type/suc');
                } else {
                    $this->msg = "添加/修改学生失败!";
                    $this->type = "danger";
                }

            }
        }

        if($id == NULL) $this->display('Administrator:student-add');
        else $this->display('Administrator:student-modify');
    }

    //--------------------------------------------------------------------------

    public function course_manage($res = NULL, $type = NULL){//..................................................课程管理
        if(!session('?user') || session('per')!=3)
            $this->redirect('Home/Common/login/res/login-war/type/war');

        $common_logic = D('Common','Logic');
        $this->msg = "";
        if($res!=NULL) {
            $message = $common_logic->getMessage($res,$type);
            $this->msg = $message['res'];
            $this->type = $message['type'];
        }

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
        return $course->select();
    }

    protected function course_find($key){
        $course = M('Course');
        return $course->where("title = '$key' OR number = '$key'
            OR teacher = '$key'")->select();
    }

    public function course_del($course_id){//....................................................................删除课程
        if(!session('?user') || session('per')!=3)
            $this->redirect('Home/Common/login/res/login-war/type/war');

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
        if(!session('?user') || session('per')!=3)
            $this->redirect('Home/Common/login/res/login-war/type/war');
        $course_model = M('Course');
        $common_logic = D('Common', 'Logic');

        $this->msg = "";

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
            $data['depict'] = I('post.depict');
            $data['students'] = I('post.people');
            $data['time'] = I('post.year')." ".I('post.season');
            if($id == NULL) {
                $data['assignments'] = 0;
                $data['selected'] = 0;
            }
            if($id == NULL && $course_id = $course_model->add($data)) {
                $data['number'] = $course_id;
                $data['number_display'] = $common_logic->get_display_number($course_id,1);
                $course_model->save($data);
                $this->redirect('Home/Administer/course_manage/res/add-cou-suc/type/suc');
            }elseif($id != NULL && $course_model->where("number = '$id'")->save($data)){
                $this->redirect('Home/Administer/course_manage/res/mod-cou-suc/type/suc');
            }else {
                $this->msg = "添加/修改课程失败!";
                $this->type = "danger";
            }
        }

        if($id!= NULL) $this->display('Administrator:lesson-modify');
        else if($teacher_id!= NULL){
            $this->teacher = $teacher_id;
            $this->display('Administrator:teacher-lesson-add');
        } else $this->display('Administrator:lesson-add');

    }

    public function download($assignment_id){//..................................................................批量下载
        if(!session('?user') || session('per')!=3)
            $this->redirect('Home/Common/login/res/login-war/type/war');

        $common_logic = D('Common','Logic');
        $url = $common_logic->addToZip($assignment_id);
        $this->ajaxReturn($url);
    }
    //--------------------------------------------------------------------------

    public function teacher_manage($res=NULL,$type=NULL){//......................................................教师管理
        if(!session('?user') || session('per')!=3)
            $this->redirect('Home/Common/login/res/login-war/type/war');
        $all = $this->user_show(2);

        $common_logic = D('Common','Logic');
        $this->msg = "";
        if($res!=NULL) {
            $message = $common_logic->getMessage($res,$type);
            $this->msg = $message['res'];
            $this->type = $message['type'];
        }

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
        if(!session('?user') || session('per')!=3)
            $this->redirect('Home/Common/login/res/login-war/type/war');

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
        $courses = $course_model->where("teacher = '$teacher_id'")->select();
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
        if(!session('?user') || session('per')!=3)
            $this->redirect('Home/Common/login/res/login-war/type/war');
        $user_model = D('User');

        $this->msg = "";

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
               $this->msg = "已存在教师!";
               $this->type = "warning";
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
               $data['permission'] = 2;
               if($id == NULL && $user_model->create($data)){
                   $user_model->add();
                   $this->redirect('Home/Administer/teacher_manage/res/add-tea-suc/type/suc');
               }
               elseif($id!=NULL && $change_pwd && $user_model->create($data)){
                   $user_model->save();
                   $this->redirect('Home/Administer/teacher_manage/res/mod-tea-suc/type/suc');
               }
               elseif($id!=NULL && !$change_pwd && $user_model->save($data)){
                   $this->redirect('Home/Administer/teacher_manage/res/mod-tea-suc/type/suc');
               } else{
                   $this->msg = "添加/修改教师失败!";
                   $this->type = "danger";
               }

           }

        }

        if ($id== NULL) $this->display('Administrator:teacher-add');
        else $this->display('Administrator:teacher-modify');
    }

}
