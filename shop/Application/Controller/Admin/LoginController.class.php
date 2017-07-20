<?php


class LoginController extends Controller
{
    public function login(){
        $this->display("login");
    }
    public function check(){
        $data=$_POST;
        $captcha = $_POST['captcha'];
        session_start();
       if(strtoupper($captcha)!=strtoupper($_SESSION['random'])){
               $this->redirect("index.php?p=Admin&c=Login&a=login","验证码错误",3);
       }
              $UsersModel =new UsersModel();
              $result = $UsersModel->check($data);
       if( $result!==false) {

                $_SESSION["user"] = $result;
                if (isset($data['remember'])) {
                    setcookie("id", $result['id'], time() + 24 * 60 * 60, "/");
                    setcookie("password", $result['password'], time() + 24 * 60 * 60, "/");

                }
                $this->redirect("index.php?p=Admin&c=Index&a=index","正在登录后台",3);
       }


        $this->redirect("index.php?p=Admin&c=Login&a=login","用户名或密码不正确",3);
    }


}