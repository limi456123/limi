<?php


class historiesModel extends Model
{
  public function getAll(){
      $sql="select * from histories ";
      $rows=$this->db->fetchAll($sql);
      return $rows;
  }
}