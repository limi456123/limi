<?php


class platformController extends Controller
{
    public function __construct()
    {
        $result = $this->checklogin();
        if ($result === false) {
          $this->redirect("index,php?p=Admin&c=Longin&a=login");
        }
    }
    public function checklogin(){
        @session_start();
        if(!isset($_SESSION['user'])){
            if(isset($_COOKIE['id']) && isset($_COOKIE['password'])){
                $id=$_COOKIE['id'];
                $password= $_COOKIE['password'];
                $usersModel=new UsersModel();
                $result=$usersModel->cookiecheck($id,$password);
                if($result!==false){
                    $_SESSION['userinfo']=$result;
                }
            }
            return false;
        }

    }
}