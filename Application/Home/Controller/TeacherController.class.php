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
    public function my_course(){//..................................................教师:我的课程
        $validate_logic = D('Validate','Logic');
        if(!$validate_logic->checkLogin(2)) $this->redirect('Common/login');
        $validate_logic->setSession();

        $course_model = M('Course');
        $user_logic = D('User','Logic');
        $course_logic = D('Course','Logic');
        $teacher_id = session("user");
        $courses = $course_model->where("teacher = '$teacher_id'")->order('create_time desc')->select();
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

    public function my_assignments(){//..........................................教师:我布置的作业
        $validate_logic = D('Validate','Logic');
        if(!$validate_logic->checkLogin(2)) $this->redirect('Common/login');
        $validate_logic->setSession();

        $common_logic = D('Common','Logic');
//        $this->msg = "";
//        if($res!=NULL) {
//            $message = $common_logic->getMessage($res,$type);
//            $this->msg = $message['res'];
//            $this->type = $message['type'];
//        }

        $teacher = session('user');
        $assignment_model = M('Assignment');
        $course_logic = D('Course','Logic');
        $assignments = $assignment_model->where("teacher = '$teacher'")->order('endtime desc')->select();
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

        $validate_logic = D('Validate','Logic');
        if(!$validate_logic->checkLogin(2)) $this->redirect('Common/login');
        $validate_logic->setSession();

        $assignment_model = M('Assignment');
        $assignment_dis_model = M('Assignmentdis');
        $course = M('Course');

        $course_id = $assignment_model->where("number = '$assignment_id'")->getField('course');
        $assignment_model->where("number = '$assignment_id'")->delete();
        $assignment_dis_model->where("assNumber = '$assignment_id'")->delete();
        $course->where("number = '$course_id'")->setDec('assignments');

        $this->ajaxReturn(1);
    }

    public function assignment_detail($assignment_id){//..............................作业详情

        $validate_logic = D('Validate','Logic');
        if(!$validate_logic->checkLogin(2)) $this->redirect('Common/login');
        $validate_logic->setSession();

        $common_logic = D('Common','Logic');
        $assignment_model = M('Assignment');
        $course_logic = D('Course','Logic');
        $user_logic = D('User','Logic');
        $assignments_detail = $assignment_model->where("number = '$assignment_id'")
            ->select()[0];
        $assignment_dis_model = M('Assignmentdis');
        $assignments = $assignment_dis_model
            ->where("assNumber = '$assignment_id' AND isSubmitted = 1")
            ->order('submittime desc')
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

        $assignment_not_examine_all = $assignment_dis_model
            ->where("assNumber = '$assignment_id' AND isExamined = 0")
            ->order('submittime')
            ->select();
        if(count($assignment_not_examine_all)>0)
            $assignment_not_examine = $assignment_not_examine_all[0]['stdnumber'];
        else $assignment_not_examine = -1;

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
            'numOfSubmit' =>  $course_logic->get_sub_exa($assignments_detail['number'],1),
            'corrected' =>  $course_logic->get_sub_exa($assignments_detail['number'],2),
            'submit' => $submit,
            'type' => $assignments_detail['type'],
            'next_student_id' => $assignment_not_examine,
        );
        $this->display('Teacher:homework-details');
    }

    public function assignment_to_modify($assignment_id,$student_id,$display){//............................批改/修改作业

        $validate_logic = D('Validate','Logic');
        if(!$validate_logic->checkLogin(2)) $this->redirect('Common/login');
        $validate_logic->setSession();

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
            $data['isExamined'] = 1;

            if($assignment_dis_model->create($data)){
                $assignment_dis_model
                    ->where("assNumber = '$assignment_id' AND stdNumber = '$student_id'" )
                    ->save();

                $ret = $common_logic->save_as_word($data['comm'],$data['mark'],$student_id,$assignment_id);
                if($ret) {
                    $validate_logic->sendMsg('保存成功','success');
                    $this->redirect('Teacher/assignment_detail/assignment_id/'.$assignment_id);
                } else {
                    $validate_logic->sendMsg('保存失败','danger',0);
                }
            }else{
                $validate_logic->sendMsg($assignment_dis_model->getError(),'danger',0);
            }
        }

        if(isset($_POST['next'])){
            $data['comm'] = I('post.comment');
            $data['mark'] = I('post.mark');
            $data['isExamined'] = 1;

            if($assignment_dis_model->create($data)){
                $assignment_dis_model
                    ->where("assNumber = '$assignment_id' AND stdNumber = '$student_id'" )
                    ->save();

                $ret = $common_logic->save_as_word($data['comm'],$data['mark'],$student_id,$assignment_id);
                if($ret){
                    $assignment_next = $assignment_dis_model
                        ->where("assNumber = '$assignment_id' AND isExamined = 0")
                        ->select()[0];
                    if($assignment_next == null){
                        $validate_logic->sendMsg('保存成功','success');
                        $this->redirect('Teacher/assignment_detail/assignment_id/'
                            .$assignment_id);
                    }else{
                        $this->redirect('Teacher/assignment_to_modify/assignment_id/'
                            .$assignment_id.'/student_id/'.$assignment_next['stdnumber']
                            .'/display/correct');
                    }
                }else {
                    $validate_logic->sendMsg('保存失败','danger',0);
                }
            }else{
                $validate_logic->sendMsg($assignment_dis_model->getError(),'danger',0);
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

        $validate_logic = D('Validate','Logic');
        if(!$validate_logic->checkLogin(2)) $this->redirect('Common/login');
        $validate_logic->setSession();

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
            $data['startTime'] = I('post.startTime');
            $data['endTime'] = I('post.endTime');
            $data['course'] = $course_id;
            $data['teacher'] = session('user');
            $data['type'] = I('post.type');

            if($assignment_id == NULL && $assignment_model->create($data)){
                $assignment_id_new = $assignment_model->add();
                $data['number_display'] = $common_logic->get_display_number($assignment_id_new,2);
                $data['number'] = $assignment_id_new;
                $assignment_model->save($data);
                $course_model->where("number = '$course_id'")->setInc('assignments');
                foreach ($students as $i){
                    $course_logic->assignment_dis($course_id, $assignment_id_new,$i['stdnumber']);
                }

                $validate_logic->sendMsg('布置新作业成功!','success');
                $this->redirect('Teacher/my_assignments');
            }elseif($assignment_id != NULL && $assignment_model->create($data)){
                $assignment_model->where("number = '$assignment_id'")->save();

                $validate_logic->sendMsg('修改作业成功!','success');
                $this->redirect('Teacher/my_assignments');
            }else{
                $validate_logic->sendMsg($assignment_model->getError(),'danger',0);
            }
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

        $validate_logic = D('Validate','Logic');
        if(!$validate_logic->checkLogin(2)) $this->redirect('Common/login');
        $validate_logic->setSession();

        $common_logic = D('Common','Logic');
        $url = $common_logic->addToZip($assignment_id);
        if($url) $this->ajaxReturn(1);
        else $this->ajaxReturn(0);
    }

    public function reupload($stu_id,$assignment_id){//..............................................教师-发邮件要求学生重交作业

        $validate_logic = D('Validate','Logic');
        if(!$validate_logic->checkLogin(2)) $this->redirect('Common/login');
        $validate_logic->setSession();

        $assignment_dis_model = M('Assignmentdis');
        $user_model = M('User');
        $course_logic = D('Course','Logic');
        $user_logic = D('User','Logic');
        $common_logic = D('Common','Logic');

        $assignment = $assignment_dis_model
            ->where("stdNumber = '$stu_id' AND assNumber = '$assignment_id'")->select()[0];
        $assignment['isSubmitted'] = 1;
        $assignment['isExamined'] = -1;
        $assignment_dis_model
            ->where("stdNumber = '$stu_id' AND assNumber = '$assignment_id'")->save($assignment);

        $sub = "请重新提交作业!";
        $course_name = $course_logic->get_course_name($assignment['cnumber']);
        $teacher_name = $user_logic->get_user_name(session('user'));
        $assignment_name = $course_logic->get_assignment_name($assignment['assnumber']);
        $stu_name = $user_logic->get_user_name($stu_id);
        $prefix = C('URL_HEAD').'Student/my_assignment/reload/1';

        $body = $stu_name."同学,你好!<br>"."<p>你的老师 $teacher_name 要求你重新提交<em>
            课程 $course_name</em> 的作业:<em> $assignment_name </em></p><br>"."详情请与老师联系!<br>"
            ."<br> 你可以点击以下链接进入<你的作业界面>:<br>"
            .$prefix;

        $address = $user_model->where("number = '$stu_id'")->select()[0]['email'];

        if($common_logic->sendEmail($sub,$address,$body))
            $this->ajaxReturn(1);//发送成功
        else $this->ajaxReturn(0);
    }

    public function student_detail($student_id){//...........................................................学生详情界面

        $validate_logic = D('Validate','Logic');
        if(!$validate_logic->checkLogin(2)) $this->redirect('Common/login');
        $validate_logic->setSession();

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

    public function _empty(){
        $this->display('Common:not-found');
    }
}