<?php


class UsersController  extends platformController
{
    public function index(){
        $usersModel=new UsersModel();
        $rows=$usersModel->getAll();
        $this->assign($rows);
        $this->display('users_index');
    }
}