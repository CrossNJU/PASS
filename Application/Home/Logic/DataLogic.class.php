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
    }

    private function addAdministrator(){
        $user_model = D('User');
        $data['number'] = 'Admin01';
        $data['password'] = 'test123';
        $data['phone'] = '13209870987';
        $data['email'] = '1395314348@qq.com';
        $data['permission'] = 3;
        $data['name'] = '陈睿';
        $data['academy'] = '软件';
        $user_model->create($data);
        $user_model->add();
    }

}