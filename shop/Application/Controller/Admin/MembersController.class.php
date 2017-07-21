<?php

/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/7/21
 * Time: 14:47
 */
class MembersController extends  platformController
{
   public function index(){
       $MembersModel=new MembersModel();
       $rows=$MembersModel->getAll();
       $this->assign("rows",$rows);
       $this->display("members_index");
   }
    public function add(){
        if($_SERVER["REQUEST_METHOD"]=="GET"){
            $this->display("members_add");
        }else{
            $data=$_POST;
            $MembersModel=new MembersModel();
            $MembersModel->add($data);
            $this->redirect("index.php?p=Admin&c=Members&a=index");
        }
    }
    public function update(){
        if($_SERVER["REQUEST_METHOD"]=="GET"){
            $member_id=$_GET['id'];
            $MembersModel=new MembersModel();
            $row=$MembersModel->getone( $member_id);
            $this->assign($row);
            $this->display("members_update");
        }else{
            $data=$_POST;
            $MembersModel=new MembersModel();
            $MembersModel->update($data);
            $this->redirect("index.php?p=Admin&c=Members&a=index");
        }
    }
    public function delete(){
        $member_id=$_GET['id'];
        $MembersModel=new MembersModel();
        $MembersModel->delete($member_id);
        $this->redirect("index.php?p=Admin&c=Members&a=index");
    }
}