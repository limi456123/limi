<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/20
 * Time: 11:41
 */
class UploadImageTool extends Model
{
	//上传文件的方法.
//@param $file 文件信息
//@param $dir 不同功能单独使用一个文件夹存放 以 / 结尾
//                  例子:Admin/
	public function UploadImage($file,$dir=''){
		//允许的类型
		$allow_type = [
			'image/png',
			'image/gif',
			'image/jpeg',
			'image/jpg'
		];
		//允许上传文件的最大值
		$max_size=2*1024*1024;
		//判断上传是否错误
		if ($file['error']!=0){
			$this->error="文件类型错误!";
			return false;
		}
		//判断上传类型
		if(!in_array($file['type'],$allow_type)){
			$this->error = "文件类型错误!";
			return false;
		}
		//判断上传大小
		if($file['size'] > $max_size){
			$this->error = "上传文件过大!";
			return false;
		}
		//判断是否http post 上传
		if(!is_uploaded_file($file['tmp_name'])){
			$this->error = "不是通过HTTP POST上传的文件!";
			return false;
		}
		//准备文件的路径和文件名
		//文件名
		$filename = uniqid("IT_").strrchr($file['name'],".");
		//文件路径 分日期存放
		$dirname = UPLOADS_PATH.$dir.date("Ymd")."/";
		/**
		 * 创建文件夹
		 * 判断 如果文件夹已经有了就不再创建
		 */
		if(!is_dir($dirname)){
			mkdir($dirname,0777,true);
		}
		//完整的文件名称
		$full_name = $dirname.$filename;
//            echo $full_name;exit;
		//移动文件
		if(move_uploaded_file($file['tmp_name'],$full_name)){
			/**
			 * 移动成功,返回文件路径
			 * 网络的绝对路径 http://域名/xxxx
			 * 返回相对路径,相对于Uploads文件夹
			 */
			return str_replace(UPLOADS_PATH,"",$full_name);
		}else{
			//移动失败
			$this->error = "文件移动失败!";
			return false;
		}
	}
}