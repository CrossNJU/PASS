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
    public function student_manage(){
        $all = $this->user_show(1);
        if(isset($_POST['find'])){//查找学生,空白默认查找全部
            $key = I('post.search');
            if($key == ""){
                $this->ajaxReturn($all);
            }else{
                $ret = $this->user_find(1,$key);
                $this->ajaxReturn($ret);
            }
        }

        $this->num = count($all);
        $this->students = $all;
        $this->display('Administrator:_stu_mag');
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
            $course_id = $course['cNumber'];
            $course_model->where("number = '$course_id'")->setDec('selected');
        }
        $course_dis_model->where("stdNumber = '$stu_id'")->delete();
        $assignment_dis_model->where("stdNumber = '$stu_id'")->delete();
        $this->ajaxReturn(1);
    }

    public function stu_show_course($stu_id){//显示学生所选课程名
        $course_dis_model = M('Coursedis');
        $course_model = M('Course');
        $rows = $course_dis_model->where("stdNumber = '$stu_id'")->select();
        $i = 0;
        $titles = array();
        foreach ($rows as $course){
            $course_id = $course['cNumber'];
            $course_detail = $course_model->where("number = '$course_id'")
                ->select() [0];
            $titles[$i] = $course_detail['title'];
            $i++;
        }
        $this->ajaxReturn($titles);
    }
    //--------------------------------------------------------------------------

    public function course_manage(){
        $all = $this->course_show();

        if(isset($_POST['find'])){//查找课程,空白默认查找全部
            $key = I('post.search');
            if($key == ""){
                $ret = array(
                    'course' => $all,
                    'assignments' => $this->course_show_assignments($all)
                );
                $this->ajaxReturn($ret);
            }else{
                $courses = $this->course_find($key);
                $ret = array(
                    'course' => $courses,
                    'assignments' => $this->course_show_assignments($courses)
                );
                $this->ajaxReturn($ret);
            }
        }

        $this->num = count($all);
        $this->courses = array(
            'course' => $all,
            'assignments' => $this->course_show_assignments($all)
        );
        $this->display('Administrator:_course_mag');
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
    }

    protected function course_show_assignments($courses){//显示课程作业
        $assignment_model = M('Assignment');
        $assignments = array();
        $i = 0;
        foreach ($courses as $course){
            $course_id = $course['number'];
            $assignments[$i] = $assignment_model->where("course = '$course_id'")
                ->select();
            $i ++;
        }
        return $assignments;
    }

    public function course_add(){//新增课程
        $course_model = M('Course');
        if(isset($_POST['add'])){
            $data['title'] = I('post.title');
            $data['teacher'] = I('post.teacher');
            $data['depict'] = I('post.depict');
            $data['selected'] = I('post.people');
            $data['time'] = I('post.time');
            $course_model->add($data);
        }
    }

    public function download(){//批量下载

    }
    //--------------------------------------------------------------------------

    public function teacher_manage(){
        $all = $this->user_show(2);
        if(isset($_POST['find'])){//查找课程,空白默认查找全部
            $key = I('post.search');
            if($key == ""){
                $ret = array(
                    'teacher' => $all,
                    'titles' => $this->teacher_show_courses($all)
                );
                $this->ajaxReturn($ret);
            }else{
                $teachers = $this->user_find(2,$key);
                $ret = array(
                    'teacher' => $teachers,
                    'titles' => $this->teacher_show_courses($teachers)
                );
                $this->ajaxReturn($ret);
            }
        }

        $this->num = count($all);
        $this->teachers = array(
            'teacher' => $all,
            'titles' => $this->teacher_show_courses($all)//课程的数组
        );
        $this->display('Administrator:_teacher_mag');
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
        $this->display('Administrator:_teacher_mag');
    }

    protected function teacher_show_courses($teachers){//显示课程作业
        $course = M('Course');
        $courses = array();
        $i = 0;
        foreach ($teachers as $teacher){
            $teacher_id = $teacher['number'];
            $course = $course->where("teacher = '$teacher_id'")
                ->select();
            $courses[$i] = $course;
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
            $user_model->add($data);
        }
        $this->display('Administrator:_teacher_add');
    }

}