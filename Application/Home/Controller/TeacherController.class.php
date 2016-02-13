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
            $this->ajaxReturn(0);
        }
        $status = session("per");
        if($status!=2){
            $this->ajaxReturn(0);//未登录
        }
        $course_model = M('Course');
        $teacher_id = session("user");
        $courses = $course_model->where("teacher = '$teacher_id'")->select();
        $course_ret = array();
        $i = 0;
        foreach ($courses as $course){
            $course_detail = array(
                'num' => $course['number'],
                'period' => $course['time'],
                'name' => $course['title'],
                'teacher' => $this->get_user_name($course['teacher']),
                'numOfStu' =>$course['selected'],
                'description' => $course['depict'],
                'numOfHomework' => $course['assignments'],
                'homework' => $this->assignments_get($course['number'])
            );
            $course_ret[$i] = $course_detail;
            $i ++;
        }

        $this->courses = $course_ret;
        $this->display('Teacher:mycourse-tch');
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
        $assignment_ret = array();
        $i = 0;
        foreach ($assignments as $assignment){
            $assignment_detail = array(
                'num' => $assignment['number'],
                'name' => $this->get_assignment_name($assignment['number']),
                'course' => $this->get_course_name($assignment['course']),
                'start' => $assignment['startTime'],
                'end' => $assignment['endTime'],
                'isEnd' => $this->isEnded($assignment['endTime']),
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

    protected function assignments_get($course_id){//查看作业
        $assignment_model = M('Assignment');
        $assignments = $assignment_model->where("course = '$course_id'")->select();
        $homework = array();
        $i = 0;
        foreach ($assignments as $assignment_detail) {
            $assignment_detail = array(
                'num' => $assignment_detail['number'],
                'name' => $this->get_assignment_name($assignment_detail['number']),
                'start' => $assignment_detail['startTime'],
                'end' => $assignment_detail['endTime'],
                'isEnd' => $this->isEnded($assignment_detail['endTime']),
                'require' => $assignment_detail['requi'],
                'numOfSubmit' => $assignment_detail['submitted'],
                'corrected' => $assignment_detail['examined'],
            );
            $homework[$i] = $assignment_detail;
            $i++;
        }
        return $homework;
    }

    public function assignment_detail($assignment_id){//作业详情
        $assignment_model = M('Assignment');
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
                'name' => $this->get_assignment_name($assignment_id),
                'studentName' => $this->get_user_name($assignment['stdNumber']),
                'studentNum' => $assignment['stdNumber'],
                'isCorrected' => $assignment['isExamined'],
                'comment' => $assignment['comm'],
                'score' => $assignment['mark']
            );
            $i++;
        }

        $this->homework = array(
            'num' => $assignment_id,
            'name' => $this->get_assignment_name($assignment_id),
            'course' => $assignments_detail['course'],
            'start' => $assignments_detail['startTime'],
            'end' => $assignments_detail['endTime'],
            'isEnd' => $this->isEnded($assignments_detail['endTime']),
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

            $this->save_as_word($data['comm'],$data['mark'],$student_id,$assignment_id);
        }

        $this->url = $assignment_dis['url'].'source.pdf';
        $this->submit = array(
            'name' => $assignment['submitName'],
            'studentName' => $this->get_user_name($student_id),
            'studentNum' => $student_id
        );
        $this->homework = array(
            'num' => $assignment_id,
            'name' => $this->get_assignment_name($assignment_id),
        );
        $this->display('Teacher:homework-'.$display);
    }

    protected function save_as_word($comments,$mark,$student_id,$assignment_id){
        vendor('PHPWord.PHPWord');
        $word = new PHPWord();

        $section = $word->createSection();
        $section->addTitle('Comments && marks:');
        $section->addTextBreak(2);
        $section->addText($comments);
        $section->addTextBreak(2);
        $section->addText($mark);

        $output = \PHPWord_IOFactory::createWriter($word,'Word2007');
        $output->save('./Public/uploads/'.$student_id.'/'.$assignment_id.'/modify.doc');

        return 1;
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

        $this->display('Teacher:homework-new');
    }

    protected function assignment_dis($course_id, $assignment_id, $student_id){
        $assignment_dis_model = M('Assignmentdis');
        $data['assNumber'] = $assignment_id;
        $data['stdNumber'] = $student_id;
        $data['cNumber'] = $course_id;
        $data['isSubmitted'] = 0;
        $data['isExamined'] = 0;
        $assignment_dis_model->add($data);
    }

    protected function get_user_name($user_id){
        $user_model = M('User');
        $user = $user_model->where("number = '$user_id'")
            ->select()[0];
        return $user['name'];
    }

    protected function get_course_name($course_id){
        $course_model = M('Course');
        $course = $course_model->where("number = '$course_id'")
            ->select()[0];
        return $course['title'];
    }

    protected function get_assignment_name($assignment_id){
        $assignment_model = M('Assignment');
        $assignment = $assignment_model->where("number = '$assignment_id'")
            ->select()[0];
        return $assignment['title'];
    }

    protected function isEnded($time){
        $now = date("y-m-d h:i:s");
        if(strtotime($time)<strtotime($now)) return true;
        return false;
    }
}