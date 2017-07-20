<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/18
 * Time: 13:09
 */
class wuxianfenleiTool
{
	public function wuxianfenlei(&$rows,$start_id=0,$deep=0){
		static $result=[];
		foreach ($rows as $row){
			if ($row['parent_id']==$start_id){

				$row['name']=str_repeat("&emsp;",$deep*2).$row['name'];
				$result[]=$row;
				$this->wuxianfenlei($rows,$row['id'],$deep+1);
			}
		}
		return $result;
	}
}