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
        $this->display('Administrator:student-admin');
    }

    public function student_manage(){
        $all = $this->user_show(1);
        $students = array();
        $i = 0;
        foreach ($all as $student){
            $courses = $this->stu_show_course($student['number']);
            $student_detail = array(
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
        if(isset($_POST['find'])){//查找学生,空白默认查找全部
            $key = I('post.search');
            if($key == ""){
                $this->ajaxReturn($students);
            }else{
                $all = $this->user_find(1,$key);
                $i = 0;
                foreach ($all as $student){
                    $courses = $this->stu_show_course($student['number']);
                    $student_detail = array(
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
                $this->ajaxReturn($students);
            }
        }

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

    public function stu_del($stu_id){//删除学生
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

    public function student_add()//添加学生
    {
        if (isset($_POST['register'])) {
            $user_model = M('User');

            $student_id = I('post.stu_id');
            $rows = $user_model->where("number = '$student_id'")->select();
            if(count($rows)>0)
                $this->ajaxReturn(-1);//已存在用户

            $data['number'] = $student_id;
            $data['password'] = I('post.pwd');
            $data['email'] = I('post.email');
            $data['name'] = I('post.name');
            $data['academy'] = I('post.aca');
            $data['speciality'] = I('post.spe');
            $data['grade'] = I('post.grade');
            $data['permission'] = 1;
            if($user_model->add($data))
                $this->ajaxReturn(1);
            else $this->ajaxReturn(0);//加入失败
        }
        $this->display('Administrator:student-add');
    }
    //--------------------------------------------------------------------------

    public function course_manage(){
        $course_logic = D('Course','Logic');
        $user_logic = D('User','Logic');
        $all = $this->course_show();
        $courses = array();
        $i = 0;
        foreach ($all as $course){
            $ass = $course_logic->get_assignments_course($course['number']);
            $course_detail = array(
                'num' => $course['number'],
//                'period' => $course['time'],
                'name' => $course['title'],
                'nameOfTea' => $user_logic->get_user_name($course['teacher']),
//                'numOfStu' =>$course['selected'],
//                'description' => $course['depict'],
                'numOfHomework' => count($ass),
                'homeworks' => $ass
            );
            $courses[$i] = $course_detail;
            $i ++;
        }

        if(isset($_POST['find'])){//查找课程,空白默认查找全部
            $key = I('post.search');
            if($key == ""){
                $this->ajaxReturn($courses);
            }else{
                $all = $this->course_find($key);
                $i = 0;
                foreach ($all as $course){
                    $course_detail = array(
                        'num' => $course['number'],
//                'period' => $course['time'],
                        'name' => $course['title'],
                        'nameOfTea' => $user_logic->get_user_name($course['teacher']),
//                'numOfStu' =>$course['selected'],
//                'description' => $course['depict'],
                        'numOfHomework' => $course['assignments'],
                        'homeworks' => $course_logic->get_assignments_course($course['number'])
                    );
                    $courses[$i] = $course_detail;
                    $i ++;
                }
                $this->ajaxReturn($courses);
            }
        }

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

    public function course_del($course_id){//删除课程
        $course_model = M('Course');
        $course_dis_model = M('Coursedis');
        $assignment_model = M('Assignment');
        $assignment_dis_model = M('Assignmentdis');
        $assignment_model->where("course = '$course_id")->delete();
        $assignment_dis_model->where("cNumber = '$course_id'")->delete();
        $course_dis_model->where("cNumber = '$course_id'")->delete();
        $course_model->where("number = '$course_id'")->delete();
        $this->ajaxReturn(1);
    }

    public function course_add(){//新增课程
        $course_model = M('Course');
        if(isset($_POST['add'])){
            $data['title'] = I('post.title');
            $data['teacher'] = I('post.teacher');
            $data['depict'] = I('post.depict');
            $data['selected'] = I('post.people');
            $data['time'] = I('post.time');
            if($course_model->add($data))
                $this->ajaxReturn(1);
            else $this->ajaxReturn(0);//加入失败
        }
        $this->display('Administrator:lesson-add');
    }

    public function download($assignment_id){//批量下载
        $urls = array();
        $assignment_dis_model = M('Assignmentdis');
        $assignment_for_students = $assignment_dis_model
            ->where("assNumber = '$assignment_id'")->select();
        $i = 0;
        foreach ($assignment_for_students as $assignment){
            $url = array(
                'source' => $assignment['url'].'source.pdf',
                'modify' => $assignment['url'].'modify.pdf'
            );
            $urls[$i] = $url;
        }
        $this->ajaxReturn($urls);
    }
    //--------------------------------------------------------------------------

    public function teacher_manage(){
        $all = $this->user_show(2);
        $teachers = array();
        $i = 0;
        foreach ($all as $teacher){
            $courses = $this->teacher_show_courses($teacher['number']);
            $teacher_detail = array(
                'order' => $teacher['number'],
                'name' => $teacher['name'],
                'num' => count($all),
                'numOfClass' => count($courses),
                'classes' => $courses,
            );
            $teachers[$i] = $teacher_detail;
            $i ++;
        }
        if(isset($_POST['find'])){//查找课程,空白默认查找全部
            $key = I('post.search');
            if($key == ""){
                $this->ajaxReturn($teachers);
            }else{
                $all = $this->user_find(2,$key);
                $i = 0;
                foreach ($all as $teacher){
                    $courses = $this->teacher_show_courses($teacher['number']);
                    $teacher_detail = array(
                        'order' => $teacher['number'],
                        'name' => $teacher['name'],
                        'num' => count($all),
                        'numOfClass' => count($courses),
                        'classes' => $courses,
                    );
                    $teachers[$i] = $teacher_detail;
                    $i ++;
                }
                $this->ajaxReturn($teachers);
            }
        }

        $this->teachers = $teachers;
        $this->display('Administrator:teacher-admin');
    }

    public function teacher_del($teacher_id){//删除教师
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

    protected function teacher_show_courses($teachers){//显示课程作业
        $course = M('Course');
        $courses = array();
        $i = 0;
        foreach ($teachers as $teacher){
            $teacher_id = $teacher['number'];
            $course = $course->where("teacher = '$teacher_id'")
                ->select();
            $course_detail = array(
                'name' => $course['name']
            );
            $courses[$i] = $course_detail;
            $i ++;
        }
        return $courses;
    }

    public function teacher_add(){//新增教师
        $user_model = M('User');
        if(isset($_POST['add'])){

            $teacher_id = I('post.tea_id');
            $rows = $user_model->where("number = '$teacher_id'")->select();
            if(count($rows)>0)
                $this->ajaxReturn(-1);//已存在用户

            $data['number'] = $teacher_id;
            $data['password'] = I('post.pwd');
            $data['email'] = I('post.email');
            $data['name'] = I('post.name');
            $data['academy'] = I('post.aca');
            $data['speciality'] = I('post.spe');
            $data['permission'] = 2;
            if($user_model->add($data))
                $this->ajaxReturn(1);
            else $this->ajaxReturn(0);//加入失败
        }
        $this->display('Administrator:teacher-add');
    }

}
