<?php

/**
 * 基础控制器类
 **
 */
abstract class Controller
{
    private $data = [];//保存需要分配到视图页面的数据
    /**
     * 加载视图文件
     * @param $template 模板文件的名称
     */
    protected function display($template){
        extract($this->data);//将关联数组 导入符号表 键作为变量名 值作为变量的值
//        var_dump($rows,$name,$age);
        require CURRENT_VIEW_PATH."{$template}.html";
        //选择视图文件后,后面没有代码需要执行,必须退出
        exit;
    }

    /**
     * 将 模型处理好后的数据 保存 到data属性中,并且data属性数组设置一个键名
     * @param $name 其实是data数组的键名
     * @param $value 其实是data数组的值
     * assign() 如果只传一个参数,那么要求该参数为关联数组,在视图页面通过关联数组的键名取值
     */
    protected function assign($name,$value=null){
        if(is_array($name)){//判断$name是否为一个数组
            $this->data = array_merge($this->data,$name);
        }else{//$name 字符串
            $this->data[$name] = $value;
        }
    }

    /**
     * 跳转到其它连接上
     * @param 跳转的url $url
     * @param $msg 提示信息
     * @param $times 延迟秒数
     */
    protected function redirect($url, $msg = '', $times = 0)
    {
        //第二种用法
        if ($times) {//延迟跳转
            //提示错误信息
            echo "<h1>{$msg}</h1>";
        }
        //延迟跳转
        header("Refresh: {$times};{$url}");
        //记得退出
        exit;
    }
}