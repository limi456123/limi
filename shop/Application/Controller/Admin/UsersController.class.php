<?php


class UsersController  extends platformController
{
    public function index(){
        $usersModel=new UsersModel();
        $rows=$usersModel->getAll();

        $this->assign("rows",$rows);
        $this->display('users_index');
    }
    public function update(){
        if($_SERVER["REQUEST_METHOD"]=="GET"){
            $user_id=$_GET['id'];
            $usersModel=new UsersModel();
            $row=$usersModel->getone( $user_id);
            $this->assign($row);
            $this->display('users_update');
        }else{
            $data=$_GET;
            $usersModel=new UsersModel();
            $usersModel->update( $data);
            $this->redirect("index.php?p=Admin&c=Users&a=index");
        }
    }
    public function delete(){

        $user_id=$_GET['id'];
        $usersModel=new UsersModel();
        $usersModel->delete( $user_id);
        $this->redirect("index.php?p=Admin&c=Users&a=index");
    }
    public function add(){
        if($_SERVER["REQUEST_METHOD"]=="GET"){
            $this->display('users_add');
        }else{
            $data=$_GET;
            $usersModel=new UsersModel();
            $usersModel->add( $data);
            $this->redirect("index.php?p=Admin&c=Users&a=index");
        }

    }
}