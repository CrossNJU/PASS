<?php
/**
 * Created by PhpStorm.
 * User: raychen
 * Date: 16/2/6
 * Time: 10:30
 */

namespace Home\Controller;
use Think\Controller;
use PHPWord;

class TeacherController extends Controller
{
    public function my_course(){//教师:我的课程
        if(!session('?per')){
            $this->redirect('Common/login');
        }
        $status = session("per");
        if($status!=2){
            $this->redirect('Common/login');
        }
        $course_model = M('Course');
        $user_logic = D('User','Logic');
        $course_logic = D('Course','Logic');
        $teacher_id = session("user");
        $courses = $course_model->where("teacher = '$teacher_id'")->select();
        $course_ret = array();
        $i = 0;
        foreach ($courses as $course){
            $course_detail = array(
                'num' => $course['number_display'],
                'period' => $course['time'],
                'name' => $course['title'],
                'teacher' => $user_logic->get_user_name($course['teacher']),
                'numOfStu' =>$course['selected'],
                'description' => $course['depict'],
                'numOfHomework' => $course['assignments'],
                'homework' => $course_logic->get_assignments_course($course['number'])
            );
            $course_ret[$i] = $course_detail;
            $i ++;
        }

        $this->courses = $course_ret;
        $this->display('Teacher:mycourse-tch');
    }

    public function my_assignments(){//教师:我布置的作业
        if(!session('?per')){
            $this->redirect('Common/login');
        }
        $status = session("per");
        if($status!=2) {
            $this->redirect('Common/login');
        }

        $teacher = session('user');
        $assignment_model = M('Assignment');
        $course_logic = D('Course','Logic');
        $common_logic = D('Common','Logic');
        $assignments = $assignment_model->where("teacher = '$teacher'")->select();
        $assignment_ret = array();
        $i = 0;
        foreach ($assignments as $assignment){
            $assignment_detail = array(
                'num' => $assignment['number_display'],
                'name' => $course_logic->get_assignment_name($assignment['number']),
                'course' => $course_logic->get_course_name($assignment['course']),
                'start' => $assignment['starttime'],
                'end' => $assignment['endtime'],
                'isEnd' => $common_logic->isEnded($assignment['endtime']),
                'require' => $assignment['requi'],
                'numOfSubmit' => $assignment['submitted'],
                'corrected' => $assignment['examined'],
                'sum' => count($assignments),
            );
            $assignment_ret[$i] = $assignment_detail;
            $i ++;
        }

        $this->homworks = $assignment_ret;
        $this->display('Teacher:myhomework-tch');
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

    public function assignment_detail($assignment_id){//作业详情
        $assignment_model = M('Assignment');
        $course_logic = D('Course','Logic');
        $user_logic = D('User','Logic');
        $common_logic = D('Common','Logic');
        $assignments_detail = $assignment_model->where("number = '$assignment_id'")
            ->select()[0];
        $assignment_dis_model = M('Assignmentdis');
        $assignments = $assignment_dis_model
            ->where("assNumber = '$assignment_id' AND isSubmitted = 1")
            ->select();

        $submit = array();
        $i = 0;
        foreach ($assignments as $assignment){
            $submit[$i] = array(
                'name' => $course_logic->get_assignment_name($assignment_id),
                'studentName' => $user_logic->get_user_name($assignment['stdnumber']),
                'studentNum' => $assignment['stdnumber'],
                'isCorrected' => $assignment['isexamined'],
                'comment' => $assignment['comm'],
                'score' => $assignment['mark']
            );
            $i++;
        }

        $this->homework = array(
            'num' => $assignments_detail['number_display'],
            'name' => $course_logic->get_assignment_name($assignment_id),
            'course' => $assignments_detail['course'],
            'start' => $assignments_detail['starttime'],
            'end' => $assignments_detail['endtime'],
            'isEnd' => $common_logic->isEnded($assignments_detail['endtime']),
            'require' => $assignments_detail['requi'],
            'numOfSubmit' => $assignments_detail['submitted'],
            'corrected' => $assignments_detail['examined'],
            'submit' => $submit
        );
        $this->display('Teacher:homework-details');
    }

    public function assignment_to_modify($assignment_id,$student_id,$display){//批改作业
        $assignment_dis_model = M('Assignmentdis');
        $assignment_model = M('Assignment');
        $course_logic = D('Course','Logic');
        $user_logic = D('User','Logic');
        $common_logic = D('Common','Logic');

        $assignment_dis = $assignment_dis_model
            ->where("assNumber = '$assignment_id' AND stdNumber = '$student_id'" )
            ->select()[0];
        $assignment = $assignment_model->where("number = '$assignment_id'")
            ->select()[0];

        if(isset($_POST['save'])){
            $data['comm'] = I('post.comment');
            $data['mark'] = I('post.mark');

            $assignment_dis_model
                ->where("assNumber = '$assignment_id' AND stdNumber = '$student_id'" )
                ->save($data);

            $common_logic->save_as_word($data['comm'],$data['mark'],$student_id,$assignment_id);
        }

        $this->url = $assignment_dis['url'].'source.pdf';
        $this->submit = array(
            'name' => $assignment['submitname'],
            'studentName' => $user_logic->get_user_name($student_id),
            'studentNum' => $student_id
        );
        $this->homework = array(
            'num' => $assignment['number_display'],
            'name' => $course_logic->get_assignment_name($assignment_id),
        );
        $this->display('Teacher:homework-'.$display);
    }

    public function assignment_deliver(){//布置新作业
        if(!session('?per')){
            $this->redirect('Common/login');
        }
        $status = session("per");
        if($status!=2){
            $this->redirect('Common/login');
        }

        $assignment_model = M('Assignment');
        $course_dis_model = M('Coursedis');
        $course_logic = D('Course','Logic');
        $common_logic = D('Common','Logic');
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
            $data['number_display'] = $common_logic->get_display_number($assignment_id,2);
            $data['number'] = $assignment_id;
            $assignment_model->save($data);
            $course_model->where("number = '$course_id'")->setInc('assignments');
            foreach ($students as $i){
                $course_logic->assignment_dis($course_id, $assignment_id,$i['stdnumber']);
            }
        }

        $this->display('Teacher:homework-new');
    }
}