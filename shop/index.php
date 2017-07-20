<?php
    /**
     * 将项目中所有的路径定义一个常量来保存  规定 每个路径 都以 /
     */
    defined("DS") or define("DS",DIRECTORY_SEPARATOR);//将目录分隔符定义一个简单的常量来表示
    defined("ROOT_PATH") or define("ROOT_PATH",dirname($_SERVER['SCRIPT_FILENAME']).DS);//项目根目录
    defined("APP_PATH") or define("APP_PATH",ROOT_PATH."Application".DS);//application的目录
    defined("FRAME_PATH") or define("FRAME_PATH",ROOT_PATH."Framework".DS);//framework的目录
    defined("PUBLIC_PATH") or define("PUBLIC_PATH",ROOT_PATH."Public".DS);//public的目录
    defined("UPLOADS_PATH") or define("UPLOADS_PATH",ROOT_PATH."Uploads".DS);//Uploads的目录
    defined("CONFIG_PATH") or define("CONFIG_PATH",APP_PATH."Config".DS);//Config的目录
    defined("CONTROLLER_PATH") or define("CONTROLLER_PATH",APP_PATH."Controller".DS);//Controller的目录
    defined("MODEL_PATH") or define("MODEL_PATH",APP_PATH."Model".DS);//Model的目录
    defined("VIEW_PATH") or define("VIEW_PATH",APP_PATH."View".DS);//View的目录
    defined("TOOLS_PATH") or define("TOOLS_PATH",FRAME_PATH."Tools".DS);//Tools的目录
    //引入配置文件
    $GLOBALS['config'] = require CONFIG_PATH.'application.config.php';

//    var_dump();
//>>>1.接收连接上的参数
    $p = $_GET['p'] ?? $GLOBALS['config']['app']['default_platform'];
    $c = $_GET['c'] ?? $GLOBALS['config']['app']['default_controller'];
    $a = $_GET['a'] ?? $GLOBALS['config']['app']['default_action'];

    //定义当前访问的控制器的路径和当前访问的视图文件的路径
    defined("CURRENT_CONTROLLER_PATH") or define('CURRENT_CONTROLLER_PATH',CONTROLLER_PATH.$p.DS);//当前控制器
    defined("CURRENT_VIEW_PATH") or define('CURRENT_VIEW_PATH',VIEW_PATH.$p.DS.$c.DS);//当前视图
//>>>2.创建控制器类对象
    //先使用一个变量来表示类名
    $class_name = $c."Controller";
    $controller = new $class_name();//可变类名

//>>>3.调用对象上的方法
    $controller->$a();

//>>4.类的自动加载
    function __autoload($class_name){
        $classMapping = [
            'Model'=>FRAME_PATH."Model.class.php",//加载基础模型
            'DB'=>TOOLS_PATH."DB.class.php",//加载DB类
            "Controller"=>FRAME_PATH."Controller.class.php"//记载基础控制器
        ];
        //判断是否为控制器
        if (isset($classMapping[$class_name])){//优先判断加载框架核心里的类
            require $classMapping[$class_name];
        }elseif(substr($class_name,-10) == "Controller"){
            require CURRENT_CONTROLLER_PATH."{$class_name}.class.php";
        }elseif (substr($class_name,-5) == "Model"){
            //判断是否为模型
            require MODEL_PATH."{$class_name}.class.php";
        }elseif (substr($class_name,-4) == "Tool"){
            //加载框架工具中的以Tool结尾的类
            require TOOLS_PATH."{$class_name}.class.php";
        }
    }