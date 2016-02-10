<?php
/**
 * Created by PhpStorm.
 * User: raychen
 * Date: 16/2/6
 * Time: 10:31
 */

namespace Home\Controller;
use Think\Controller;

class StudentController extends Controller
{

    public function sets(){//学生-设置
        if(!session('?per') || session('per')!= 1)
            $this->ajaxReturn(0);

        $stu = session('user');
        $user_model = M('User');
        if(isset($_POST['save_info'])){
            $data['number'] = I('post.number');
            $data['name'] = I('post.name');
            $data['academy'] = I('post.academy');
            $data['speciality'] = I('post.speciality');
            $data['grade'] = I('post.grade');
            $data['email'] = I('post.email');
            $user_model->save($data);

            session('user',$data['number']);
            $stu = session('user');
        }
        if(isset($_POST['save_pwd'])){
            $old = I('post.old_pwd');
            $old_in_db = $user_model->where("number = '$stu'")->getField('password');
            if($old!=$old_in_db)
                $this->ajaxReturn(-1);//原密码错误
            $new = I('post.new_pwd');
            $user_model->where("number = '$stu'")->setField('password',$new);
        }

        $this->display('Student:_sets');
    }

    public function my_course(){//学生-我的课程
        if(!session('?user') || session('per')!=1)
            $this->ajaxReturn(-1);
        $student_id = session('user');

        $course_model = M('Course');
        $course_dis_model = M('Coursedis');
        $course_ids = $course_dis_model->where("stdNumber = '$student_id'")
            ->select();
        $i = 0;
        $course = array();
        foreach ($course_ids as $var){
            $course_id = $var['cNumber'];
            $course[$i] = $course_model->where("number = '$course_id'")
                ->select() [0];
            $i ++;
        }
        $this->course = $course;

        $this->display('Student:_course');
    }

    public function my_assignment(){//学生-我的作业
        if(!session('?user') || session('per')!=1)
            $this->ajaxReturn(-1);
        $student_id = session('user');

        $course_dis_model = M('Coursedis');
        $course_ids = $course_dis_model->where("stdNumber = '$student_id'")
            ->select();
        $i = 0;
        $assignments = array();
        foreach ($course_ids as $var){
            $course_id = $var['cNumber'];
            $assignment = $this->get_assignment($course_id);
            $assignments_in = $assignment['assignments'];
            foreach ($assignments_in as $var2){
                $assignments[$i] = $var2;
                $i ++;
            }
        }

        $this->assignments = $assignments;
        $this->display('Student: _assignment');
    }

    public function get_ass_in_course($course_id){//得到课程中的作业
        if(!session('?user') || session('per')!=1)
            $this->ajaxReturn(-1);

        $assignments = $this->get_assignment($course_id);
        $this->ajaxReturn($assignments['assignments']);
    }

    protected function get_assignment($course_id){//得到具体某一门的的作业
        $student_id = session('user');

        $assignment_dis_model = M('Assignmentdis');
        $assignment_model = M('Assignment');
        $assignment_dis_s = $assignment_dis_model
            ->where("stdNumber = '$student_id' AND cNumber = '$course_id'")
            ->select();
        $i = 0;
        $assignments = array();
        foreach ($assignment_dis_s as $var){
            $assignment_id = $var['assNumber'];
            $assignments[$i] = $assignment_model->where("number = '$assignment_id'")
                ->select();
            $i ++;
        }
        $assignment_all = array(
            'assignment_dis' => $assignment_dis_s,
            'assignments' => $assignments
        );

        return $assignment_all;
    }

    public function course_remove($course_id){//退选课程
        if(!session('?user') || session('per')!=1)
            $this->ajaxReturn(-1);
        $student_id = session('user');

        $course_dis_model = M('Coursedis');
        $course_model = M('Course');
        $assign_dis_model = M('Assignmentdis');

        $assign_dis_model->where("cNumber = '$course_id'")->delete();
        $course_model->where("number = '$course_id'")->setDec('selected');
        $course_dis_model->where("stdNumber = '$student_id' AND cNumber = '$course_id'")
            ->delete();
    }

    public function course_in(){//学生-加入新课程
        if(!session('?user') || session('per')!=1)
            $this->ajaxReturn(-1);

        $course_model = M('Course');
        $course_all = $course_model->select();
        $status = $this->get_course_status($course_all);

        $this->course = array(
            'course' => $course_all,
            'selected' => $status
        );

        if(isset($_POST['search'])){
            $key = I('post.search');
            $course_all = $course_model
                ->where("title = '$key' OR number = '$key'")
                ->select();
            $status = $this->get_course_status($course_all);
            $this->course = array(
                'course' => $course_all,
                'selected' => $status
            );
        }
        $this->display('Student:_course_in');
    }

    protected function get_course_status($course_all){
        $student_id = session('user');
        $course_dis_model = M('Coursedis');
        $course_status = array();
        $i = 0;
        foreach ($course_all as $course){
            $course_id = $course['number'];
            $check = false;
            $sel = $course_dis_model
                ->where("cNumber = '$course_id' AND stdNumber = '$student_id'")
                ->select();
            if(count($sel)>0) $check = true;
            if($check){
                $course_status[$i] = true;
            }else $course_status[$i] = false;
            $i ++;
        }
        return $course_status;
    }

    public function course_add($course_id){//点击加入课程,之前的作业呢?
        if(!session('?user') || session('per')!=1)
            $this->ajaxReturn(-1);
        $student_id = session('user');

        $course_model = M('Course');
        $course_model->where("number = '$course_id'")
            ->setInc('selected');

        $course_dis_model = M('Coursedis');
        $data['cNumber'] = $course_id;
        $data['stdNumber'] = $student_id;
        $course_dis_model->add($data);
    }

    public function assignment_see(){//预览作业

    }

    public function assignment_submit(){//提交作业

    }
}