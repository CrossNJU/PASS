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
    public function my_course($res = NULL,$type = NULL){//..................................................教师:我的课程
        if(!session('?per') || session('per')!= 2)
            $this->redirect('Home/Common/login/res/login-war/type/war');

        $common_logic = D('Common','Logic');
        $this->msg = "";
        if($res!=NULL) {
            $message = $common_logic->getMessage($res,$type);
            $this->msg = $message['res'];
            $this->type = $message['type'];
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
                'id' => $course['number'],
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

    public function my_assignments($res = NULL, $type = NULL){//..........................................教师:我布置的作业
        if(!session('?per') || session('per')!= 2)
            $this->redirect('Home/Common/login/res/login-war/type/war');

        $common_logic = D('Common','Logic');
        $this->msg = "";
        if($res!=NULL) {
            $message = $common_logic->getMessage($res,$type);
            $this->msg = $message['res'];
            $this->type = $message['type'];
        }

        $teacher = session('user');
        $assignment_model = M('Assignment');
        $course_logic = D('Course','Logic');
        $assignments = $assignment_model->where("teacher = '$teacher'")->select();
        $assignment_ret = array();
        $i = 0;
        foreach ($assignments as $assignment){
            $assignment_detail = array(
                'num' => $assignment['number_display'],
                'id' => $assignment['number'],
                'name' => $course_logic->get_assignment_name($assignment['number']),
                'course' => $course_logic->get_course_name($assignment['course']),
                'start' => $assignment['starttime'],
                'end' => $assignment['endtime'],
                'isEnd' => $common_logic->isEnded($assignment['endtime']),
                'require' => $assignment['requi'],
                'numOfSubmit' => $course_logic->get_sub_exa($assignment['number'],1),
                'corrected' => $course_logic->get_sub_exa($assignment['number'],2),
                'sum' => $course_logic->get_assignment_stus($assignment['number']),
                'type' => $assignment['type'],
            );
            $assignment_ret[$i] = $assignment_detail;
            $i ++;
        }
//        dump($assignment_ret);
        $this->homeworks = $assignment_ret;
        $this->display('Teacher:myhomework-tch');
    }

    public function assignment_delete($assignment_id){//.........................................................删除作业
        if(!session('?per') || session('per')!= 2)
            $this->redirect('Home/Common/login/res/login-war/type/war');

        $assignment_model = M('Assignment');
        $assignment_dis_model = M('Assignmentdis');
        $course = M('Course');

        $course_id = $assignment_model->where("number = '$assignment_id'")->getField('course');
        $assignment_model->where("number = '$assignment_id'")->delete();
        $assignment_dis_model->where("assNumber = '$assignment_id'")->delete();
        $course->where("number = '$course_id'")->setDec('assignments');

        $this->ajaxReturn(1);
    }

    public function assignment_detail($assignment_id, $res = NULL, $type = NULL){//..............................作业详情
        if(!session('?per') || session('per')!= 2)
            $this->redirect('Home/Common/login/res/login-war/type/war');

        $common_logic = D('Common','Logic');
        $this->msg = "";
        if($res!=NULL) {
            $message = $common_logic->getMessage($res, $type);
            $this->msg = $message['res'];
            $this->type = $message['type'];
        }
        $assignment_model = M('Assignment');
        $course_logic = D('Course','Logic');
        $user_logic = D('User','Logic');
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
                'score' => $assignment['mark'],
                'upload' => $assignment['url'].$assignment['savename'],
            );
            $i++;
        }

        $assignment_not_examine = $assignment_dis_model
            ->where("assNumber = '$assignment_id' AND isExamined = 0")
            ->select()[0];

//        dump($assignment_not_examine);

        $this->homework = array(
            'num' => $assignments_detail['number_display'],
            'id' => $assignments_detail['number'],
            'sum' => $course_logic->get_assignment_stus($assignments_detail['number']),
            'name' => $course_logic->get_assignment_name($assignment_id),
            'course' => $course_logic->get_course_name($assignments_detail['course']),
            'start' => $assignments_detail['starttime'],
            'end' => $assignments_detail['endtime'],
            'isEnd' => $common_logic->isEnded($assignments_detail['endtime']),
            'require' => $assignments_detail['requi'],
            'numOfSubmit' =>  $course_logic->get_sub_exa($assignments_detail['number'],2),
            'corrected' =>  $course_logic->get_sub_exa($assignments_detail['number'],2),
            'submit' => $submit,
            'type' => $assignments_detail['type'],
            'next_student_id' => $assignment_not_examine['stdnumber']
        );
        $this->display('Teacher:homework-details');
    }

    public function assignment_to_modify($assignment_id,$student_id,$display){//............................批改/修改作业
        if(!session('?per') || session('per')!= 2)
            $this->redirect('Home/Common/login/res/login-war/type/war');

        $assignment_dis_model = M('Assignmentdis');
        $assignment_model = M('Assignment');
        $course_logic = D('Course','Logic');
        $user_logic = D('User','Logic');
        $common_logic = D('Common','Logic');

        $this->msg = "";

        $assignment_dis = $assignment_dis_model
            ->where("assNumber = '$assignment_id' AND stdNumber = '$student_id'" )
            ->select()[0];
        $assignment = $assignment_model->where("number = '$assignment_id'")
            ->select()[0];

        if(isset($_POST['save'])){
            if($display == "correct"){
//                $assignment_model->where("number = '$assignment_id'")->setInc('examined');
            }
            $data['comm'] = I('post.comment');
            $data['mark'] = I('post.mark');
            $data['isExamined'] = 1;

            $assignment_dis_model
                ->where("assNumber = '$assignment_id' AND stdNumber = '$student_id'" )
                ->save($data);

            $ret = $common_logic->save_as_word($data['comm'],$data['mark'],$student_id,$assignment_id);
            if($ret) $this->redirect('Home/Teacher/assignment_detail/assignment_id/'.$assignment_id.'/res/save-suc/type/suc');
            else {
                $this->msg = "保存失败!";
                $this->type = "danger";
            }
        }

        if(isset($_POST['next'])){
            if($display == "correct"){
//                $assignment_model->where("number = '$assignment_id'")->setInc('examined');
            }
            $data['comm'] = I('post.comment');
            $data['mark'] = I('post.mark');
            $data['isExamined'] = 1;

            $assignment_dis_model
                ->where("assNumber = '$assignment_id' AND stdNumber = '$student_id'" )
                ->save($data);

            $common_logic->save_as_word($data['comm'],$data['mark'],$student_id,$assignment_id);
            $assignment_next = $assignment_dis_model
                ->where("assNumber = '$assignment_id' AND isExamined = 0")
                ->select()[0];
            if($assignment_next == null){
                $this->redirect('Home/Teacher/assignment_detail/assignment_id/'
                    .$assignment_id.'/res/modify-suc/type/suc');
            }else{
                $this->redirect('Home/Teacher/assignment_to_modify/assignment_id/'
                    .$assignment_id.'/student_id/'.$assignment_next['stdnumber']
                    .'/display/correct');
            }
        }

        $this->submit = array(
            'name' => $assignment_dis['submitname'],
            'studentName' => $user_logic->get_user_name($student_id),
            'studentNum' => $student_id,
            'fileUrl' => $assignment_dis['url'].$assignment_dis['savename'],
        );
        $this->homework = array(
            'num' => $assignment['number_display'],
            'id' => $assignment['number'],
            'name' => $course_logic->get_assignment_name($assignment_id),
            'type' => $assignment['type']
        );
        if($display == "modify"){
            $this->score = $assignment_dis['mark'];
            $this->comment = $assignment_dis['comm'];
        }
        $this->display('Teacher:homework-'.$display);
    }

    public function assignment_deliver($assignment_id=NULL,$course_id=NULL){//..................................布置新作业
        if(!session('?per') || session('per')!= 2)
            $this->redirect('Home/Common/login/res/login-war/type/war');

        $assignment_model = M('Assignment');
        $course_dis_model = M('Coursedis');
        $course_logic = D('Course','Logic');
        $common_logic = D('Common','Logic');
        $course_model = M('Course');
        if(isset($_POST['save'])){
            $course_name = I('post.course');
            $course_id = $course_model->where("title = '$course_name'")->select()[0]['number'];
            $students = $course_dis_model->where("cNumber = '$course_id'")
                ->select();

            $data['requi'] = I('post.requi');
            $data['title'] = I('post.title');
            if($assignment_id == NULL){
//                $data['submitted'] = 0;
//                $data['examined'] = 0;
            }
            $data['startTime'] = I('post.startTime');
            $data['endTime'] = I('post.endTime');
            $data['course'] = $course_id;
            $data['teacher'] = session('user');
            $data['type'] = I('post.type');

            if($assignment_id == NULL){
                $assignment_id_new = $assignment_model->add($data);
                $data['number_display'] = $common_logic->get_display_number($assignment_id_new,2);
                $data['number'] = $assignment_id_new;
                $assignment_model->save($data);
                $course_model->where("number = '$course_id'")->setInc('assignments');
                foreach ($students as $i){
                    $course_logic->assignment_dis($course_id, $assignment_id_new,$i['stdnumber']);
                }
            }else{
                $assignment_model->where("number = '$assignment_id'")->save($data);
            }

            $this->redirect('Home/Teacher/my_assignments/res/del-suc/type/suc');
        }

        $this->course = $course_logic->get_course_name($course_id);
        $this->isModify = false;
        if($assignment_id!=NULL){
            $assignment = $assignment_model->where("number = '$assignment_id'")->select()[0];
            $assignment_detail = array(
                'num' => $assignment['number_display'],
                'id' => $assignment['number'],
                'name' => $assignment['title'],
                'require' => $assignment['requi'],
                'start' => $assignment['starttime'],
                'end' => $assignment['endtime'],
                'course' => $course_logic->get_course_name($assignment['course']),
                'type' => $assignment['type'],
            );
            $this->homework = $assignment_detail;
            $this->isModify = true;
        }

        $this->display('Teacher:homework-new');
    }

    public function download($assignment_id){//.............................................................教师-下载作业
        if(!session('?per') || session('per')!= 2)
            $this->redirect('Home/Common/login/res/login-war/type/war');

        $common_logic = D('Common','Logic');
        $url = $common_logic->addToZip($assignment_id);
        if($url) $this->ajaxReturn(1);
        else $this->ajaxReturn(0);
    }

//    public function check_student_info($stu_id){//...教师-查看学生信息界面
//        $user_model = M('User');
//        $student = $user_model->where("number = '$stu_id'")->select()[0];
//
//        $this->student = $student;
//        $this->display('Teacher:#');
//    }

    public function reupload($stu_id,$assignment_id){//..............................................教师-发邮件要求学生重交作业
        if(!session('?per') || session('per')!= 2)
            $this->redirect('Home/Common/login/res/login-war/type/war');

//        $assignment_model = M('Assignment');
        $assignment_dis_model = M('Assignmentdis');
        $user_model = M('User');
        $course_logic = D('Course','Logic');
        $user_logic = D('User','Logic');
        $common_logic = D('Common','Logic');

//        $assignment_model->where("number = '$assignment_id'")->setDec('submitted');
        $assignment = $assignment_dis_model
            ->where("stdNumber = '$stu_id' AND assNumber = '$assignment_id'")->select()[0];
        $assignment['isSubmitted'] = 0;
        $assignment['isExamined'] = 0;
        $assignment_dis_model
            ->where("stdNumber = '$stu_id' AND assNumber = '$assignment_id'")->save($assignment);

        $sub = "请重新提交作业!";
        $course_name = $course_logic->get_course_name($assignment['cnumber']);
        $teacher_name = $user_logic->get_user_name(session('user'));
        $assignment_name = $course_logic->get_assignment_name($assignment['assnumber']);
        $stu_name = $user_logic->get_user_name($stu_id);

        $body = $stu_name."同学,你好!<br>"."<p>请重新提交'$teacher_name'老师的'$course_name'课程的
            '$assignment_name'作业</p><br>";

        $address = $user_model->where("number = '$stu_id'")->select()[0]['email'];

        if($common_logic->sendEmail($sub,$address,$body))
            $this->ajaxReturn(1);//发送成功
        else $this->ajaxReturn(0);
    }

    public function student_detail($student_id){//...........................................................学生详情界面
        if(!session('?per') || session('per')!= 2)
            $this->redirect('Home/Common/login/res/login-war/type/war');

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