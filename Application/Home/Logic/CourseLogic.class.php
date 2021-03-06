<?php
/**
 * Created by PhpStorm.
 * User: raychen
 * Date: 16/2/19
 * Time: 18:55
 */

namespace Home\Logic;
use Think\Model;

class CourseLogic
{

    public function get_sub_exa($assNumber,$type){
        $assignment_dis_model = M('Assignmentdis');
        $assignments = $assignment_dis_model->where("assNumber = '$assNumber'")->order('submittime desc')->select();
        $cou = 0;
        foreach ($assignments as $assignment){
            if(($type == 1 && $assignment['issubmitted'] == 1)||($type == 2 && $assignment['isexamined'] != 0))
                $cou ++;
        }
        return $cou;
    }

    public function get_assignments_course($course_id){//查看作业,根据课程
        $common_logic = D('Common','Logic');
        $assignment_model = M('Assignment');
        $assignment_dis_model = M('Assignmentdis');
        $assignments = $assignment_model->where("course = '$course_id'")->order('modify_time desc')->select();
        $homework = array();
        $i = 0;
        foreach ($assignments as $assignment_detail) {
            $assignment_id = $assignment_detail['number'];
            $students = count($assignment_dis_model->where("assNumber = '$assignment_id'")->select());
            $assignment_detail = array(
                'num' => $assignment_detail['number_display'],
                'id' => $assignment_id,
                'name' => $this->get_assignment_name($assignment_detail['number']),
                'start' => $assignment_detail['starttime'],
                'end' => $assignment_detail['endtime'],
                'isEnd' => $common_logic->isEnded($assignment_detail['endtime']),
                'require' => $assignment_detail['requi'],
                'numOfSubmit' => $this->get_sub_exa($assignment_id,1),
                'corrected' => $this->get_sub_exa($assignment_id,2),
                'type' => $assignment_detail['type'],
                'fileUrl' => $assignment_detail['url'].$assignment_detail['savename'],
                'sum' => $students,
            );
            $homework[$i] = $assignment_detail;
            $i++;
        }
        return $homework;
    }

    public function get_assignments_student($course_id){//得到具体某一门的的作业,根据学生\课程
        $student_id = session('user');

        $assignment_dis_model = M('Assignmentdis');
        $common_logic = D('Common','Logic');
        $assignment_model = M('Assignment');
        $assignment_dis_s = $assignment_dis_model
            ->where("stdNumber = '$student_id' AND cNumber = '$course_id'")
            ->order('submittime desc')
            ->select();
        $i = 0;
        $assignments = array();
        foreach ($assignment_dis_s as $var){
            $assignment_id = $var['assnumber'];
            $assignment = $assignment_model->where("number = '$assignment_id'")
                ->select()[0];
            $assignment_detail = array(
                'num' => $assignment['number_display'],
                'id' => $assignment['number'],
                'name' => $assignment['title'],
                'require' => $assignment['requi'],
                'start' => $assignment['starttime'],
                'end' => $assignment['endtime'],
                'isSubmit' => $var['issubmitted'],
                'isWarning' => $var['iswarning'],
                'isExamined' => $var['isExamined'],
                'isEnd' => $common_logic->isEnded($assignment['endtime']),

                'courseName' => $this->get_course_name($course_id),
                'type' => $assignment['type'],
                'fileUrl' => $var['url'].$var['savename'],
                'submitTime' => $var['submittime'],
                'submitName' => $var['submitname']
            );
            $assignments[$i] = $assignment_detail;
            $i ++;
        }

        return $assignments;
    }

    public function get_course_status($course_all){
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

    public function assignment_dis($course_id, $assignment_id, $student_id){
        $assignment_dis_model = M('Assignmentdis');
        $data['assNumber'] = $assignment_id;
        $data['stdNumber'] = $student_id;
        $data['cNumber'] = $course_id;
        $data['isSubmitted'] = 0;
        $data['isExamined'] = 0;
        $data['isWarning'] = 0;
        $assignment_dis_model->add($data);
    }

    public function get_course_name($course_id){
        $course_model = M('Course');
        $course = $course_model->where("number = '$course_id'")
            ->select()[0];
        return $course['title'];
    }

    public function get_assignment_name($assignment_id){
        $assignment_model = M('Assignment');
        $assignment = $assignment_model->where("number = '$assignment_id'")
            ->select()[0];
        return $assignment['title'];
    }

    public function get_assignment_display_number($number){
        $assignment_model = M('Assignment');
        $assignment = $assignment_model->where("number = '$number'")->select()[0];
        return $assignment['number_display'];
    }

    public function get_assignment_stus($number){
        $assignment_dis_model = M('Assignmentdis');
        $ass = $assignment_dis_model->where("assNumber = '$number'")->select();
        return count($ass);
    }

}