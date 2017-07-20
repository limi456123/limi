<?php

/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/7/18
 * Time: 11:20
 */
class UsersModel extends Model
{
    public function cookiecheck($id,$password){
      $sql="select * from users id=".$id;
       $result= $this->db->fetchRow($sql);
       if(empty($result)){
           $this->error="没有对应的用户信息";
           return false;
       }
        if($password !=$result['password']){
            $this->error="没有对应的用户信息";
            return false;
        }else{
            return $result;
        }
    }
    public function check($data){
        if(empty($data['username'])){
            return false;
        }
        if(empty($data['password'])){
            return false;
        }
        $name=$data['username'];
        $pass=$data['password'];

        $sql="select * from users where username='{$name}' and password='{$pass}' ";
        $row=$this->db->fetchColumn($sql);
        if(empty($row)){
            return false;
        }else{
            return $row;
        }

    }
}