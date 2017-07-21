<?php

/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/7/21
 * Time: 14:51
 */
class MembersModel extends Model
{
  public function getAll(){
      $sql="select * from  members";
      $rows=$this->db->fetchAll($sql);
      return $rows;
  }
  public function add($data){
        $sql="insert into members set username='{$data['username']}',password='{$data['password']}',realname='{$data['realname']}',sex='{$data['sex']}',telephone='{$data['telephone']}',group_id='{$data['group_id']}',last_login='{$data['last_login']}',last_loginip='{$data['last_loginip']}',is_admin='{$data['is_admin']}',photo='{$data['photo']}'";
        $this->db->execute($sql);
    }
  public function getone($member_id){
        $sql="select * from members where member_id=".$member_id;
       $row= $this->db->fetchRow($sql);
        return $row;
    }
  public function update($data){

      $sql="update members set username='{$data['username']}',password='{$data['password']}',realname='{$data['realname']}',sex='{$data['sex']}',telephone='{$data['telephone']}',group_id='{$data['group_id']}',last_login='{$data['last_login']}',last_loginip='{$data['last_loginip']}',is_admin='{$data['is_admin']}',photo='{$data['photo']}' where member_id=".$data['member_id'];
        $this->db->execute($sql);
    }
  public function delete($member_id){
      $sql="delete from members where member_id=".$member_id;
      $this->db->execute($sql);
    }
}