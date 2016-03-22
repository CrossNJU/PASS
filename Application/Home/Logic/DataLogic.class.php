<?php
/**
 * Created by PhpStorm.
 * User: raychen
 * Date: 16/3/19
 * Time: 20:28
 */

namespace Home\Logic;


class DataLogic
{
    public function createOriginDataBase(){
        $user_model = M('User');
        $course_model = M('Course');
        $course_dis_model = M('Coursedis');
        $assignment_model = M('Assignment');
        $assignment_dis_model = M('Assignmentdis');

        $user_model->where(1)->delete();
        $course_model->where(1)->delete();
        $course_dis_model->where(1)->delete();
        $assignment_dis_model->where(1)->delete();
        $assignment_model->where(1)->delete();

        $this->addAdministrator();
        $this->addTeacher('131250001','陈晓燕',2);
        $this->addTeacher('131250002','费祥林',2);
        $this->addTeacher('131250003','骆冰',2);
        $this->addTeacher('131250004','刘钦',2);
        $this->addTeacher('141250011','陈睿',1);
        $this->addTeacher('141250012','陈沐恩',1);
        $this->addTeacher('141250013','陈丹妮',1);
        $this->addTeacher('141250014','陈灿海',1);
        $this->addTeacher('141250015','程翔',1);
    }

    private function addAdministrator(){
        $user_model = D('User');
        $data['number'] = 'Admin01';
        $data['password'] = '1234567';
        $data['phone'] = '18309870987';
        $data['email'] = '1395314348@qq.com';
        $data['permission'] = 3;
        $data['name'] = '陈睿';
        $data['academy'] = '软件';
        $data['save_time'] = date("y-m-d");
        echo $data['password']."\n";
        if($user_model->create($data)) $user_model->add();
        else echo $user_model->getError();
    }

    private function addTeacher($number,$name,$per){
        $data['number'] = $number;
        $data['password'] = '123456';
        $data['email'] = '1395314348@qq.com';
        $data['phone'] = '13867167891';
        $data['permission'] = $per;
        $data['name'] = $name;
        $data['academy'] = '哲学系';
        $data['speciality'] = '哲学';
        $data['save_time'] = date("y-m-d");
        if($per == 1) $data['grade'] = 2012;
        $user_model = D('User');
        if($user_model->create($data)) $user_model->add();
        else echo $user_model->getError();
    }

}