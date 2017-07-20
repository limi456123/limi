<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/18
 * Time: 11:49
 */
class pingtaiyanzhengzhongxingController extends Controller
{
	public function __construct()
	{
		@session_start();
		if (!isset($_SESSION['userinfo'])){
			$LoginModel=new LoginModel();
			$result=$LoginModel->checkCookie();
			if ($result===false){
				$this->redirect("index.php?p=Admin&c=Login&a=Login","请先登陆!",4);
			}
		}
	}
}