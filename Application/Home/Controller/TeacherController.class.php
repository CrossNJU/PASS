<?php
/**
 * Created by PhpStorm.
 * User: raychen
 * Date: 16/2/6
 * Time: 10:30
 */

namespace Home\Controller;
use Think\Controller;

class TeacherController extends Controller
{
    public function my_course(){//教师:我的课程
        if(!session('?per')){
            $this->ajaxReturn(0);
        }
        $status = session("per");
        if($status!=2){
            $this->ajaxReturn(0);//未登录
        }
        $course_model = M('Course');
        $teacher_id = session("user");
        $courses = $course_model->where("teacher = '$teacher_id'")->select();

        $this->course = $courses;
        $this->display('Teacher:_course');
    }

    public function my_assignments(){//教师:我布置的作业
        if(!session('?per')){
            $this->ajaxReturn(0);
        }
        $status = session("per");
        if($status!=2) {
            $this->ajaxReturn(0);//未登录
        }

        $teacher = session('user');
        $assignment_model = M('Assignment');
        $assignments = $assignment_model->where("teacher = '$teacher'")->select();

        $this->assignments = $assignments;
        $this->display('Teacher:_assignments');
    }

    public function assignment_delete($assignment_id){//删除作业
        $assignment_model = M('Assignment');
        $assignment_dis_model = M('Assignmentdis');
        $course = M('Course');

        $course_id = $assignment_model->where("number = '$assignment_id'")->getField('course');
        $assignment_model->where("number = '$assignment_id'")->delete();
        $assignment_dis_model->where("assNumber = '$assignment_id'")->delete();
        $course->where("number = '$course_id'")->setDec('assignments');

        $this->ajaxReturn('delete success!');
    }

    public function assignments_get($course_id){//查看作业
        $assignment_model = M('Assignment');
        $assignments = $assignment_model->where("course = '$course_id'")->select();
        $this->ajaxReturn($assignments);
    }

    public function assignment_detail($assignment_id){//作业详情
        $assignment_model = M('Assignment');
        $assignments_detail = $assignment_model->where("number = '$assignment_id'")->select();
        $assignment_dis_model = M('Assignmentdis');
        $assignments = $assignment_dis_model->where("assNumber = '$assignment_id'")->select();

        $this->assignment_detail = $assignments_detail[0];
        $this->assignment = $assignments;
        $this->display('Teacher:_assignment_detail');
    }

    public function assignment_modify(){//批改作业

    }

    public function assignment_deliver(){//布置新作业
        if(!session('?per')){
            $this->ajaxReturn(0);
        }
        $status = session("per");
        if($status!=2){
            $this->ajaxReturn(0);//未登录
        }

        $assignment_model = M('Assignment');
        $course_dis_model = M('Coursedis');
        $course_model = M('Course');
        if(isset($_POST['save'])){
            $course_id = I('post.course');
            $students = $course_dis_model->where("cNumber = '$course_id'")
                ->select();

            $data['requi'] = I('post.requi');
            $data['title'] = I('post.title');
            $data['submitted'] = 0;
            $data['examined'] = 0;
            $data['startTime'] = I('post.startTime');
            $data['endTime'] = I('post.endTime');
            $data['course'] = $course_id;
            $data['teacher'] = session('user');

            $assignment_id = $assignment_model->add($data);
            $course_model->where("number = '$course_id'")->setInc('assignments');
            foreach ($students as $i){
                $this->assignment_dis($course_id, $assignment_id,$i['stdnumber']);
            }
        }

        $this->display('Teacher:_deliver');
    }

    protected function assignment_dis($course_id, $assignment_id, $student_id){
        $assignment_dis_model = M('Assignmentdis');
        $data['assNumber'] = $assignment_id;
        $data['stdNumber'] = $student_id;
        $data['cNumber'] = $course_id;
        $assignment_dis_model->add($data);
    }
}