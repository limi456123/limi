<?php

/**
 * 基础模型
 */
abstract class Model
{
    protected $db;//保存创建好的db对象
    //保存错误信息
    protected $error;
    //初始化,创建对象的同时.里面代码就已经自动执行
    public function __construct()
    {
        $this->db = DB::getInstance($GLOBALS['config']['db']);
    }

    /**
     * 获取错误信息
     */
    public function getError(){
        return $this->error;
    }
}