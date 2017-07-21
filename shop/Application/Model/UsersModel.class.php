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
    public function getAll(){
        $sql="select * from users";
        $rows=$this->db->fetchAll($sql);
        return $rows;
    }
   public function getone( $user_id){
       $sql="select * from users where user_id=".$user_id;
       $row=$this->db->fetchRow( $sql);
       return $row;
   }
    public function update($data){
        $sql="update users set username='{$data['username']}',password='{$data['password']}',realname='{$data['realname']}',sex='{$data['sex']}',telephone='{$data['telephone']}',remark='{$data['remark']}',money='{$data['money']}',is_vip='{$data['is_vip']}',photo='{$data['photo']}' where user_id=".$data['user_id'];
        $this->db->execute($sql);
    }
    public function delete($user_id){
        $sql="delete from users where user_id=".$user_id;
        $this->db->execute( $sql);
    }
    public function add($data){
        $sql="insert into users set username='{$data['username']}',password='{$data['password']}',realname='{$data['realname']}',sex='{$data['sex']}',telephone='{$data['telephone']}',remark='{$data['remark']}',money='{$data['money']}',is_vip='{$data['is_vip']}',photo='{$data['photo']}'";
        $this->db->execute($sql);
    }
}