<?php

/**
 * 三私一公:
 *      私有的静态成员变量
 *      私有的构造方法
 *      私有的克隆方法
 *      公有的静态方法(创建对象,如果已经创建了对象就不再创建,如果没有创建才创建)
 * 在工作中一般情况下:  一个类放在一个类文件中. 该文件的名字   类的名字.class.php
 * 用来执行SQL.
 */
class DB
{
    private $host;//连接数据库的主机
    private $user;//连接数据库的用户名
    private $password;//连接数据库的密码
    private $dbname;//连接数据库的名字
    private $port;//连接数据库的端口号
    private $charset;//连接数据库的编码;

    private $link;//数据库连接

    //私有的静态变量,保存创建好的对象
    private static $instance = null;

    //私有的构造方法
    private function __construct($params)
    {
        $this->host = $params['host']??'127.0.0.1';
        $this->user = $params['user']??'root';
        $this->password = $params['password'];
        $this->dbname = $params['dbname'];
        $this->port = $params['port']??3306;
        $this->charset = $params['charset']??'utf8';

        //>>1.连接上数据库
        $this->link();
        //>>2.设置好编码
        $this->setCharset();
    }

    //私有的克隆方法
    private function __clone(){

    }

    //公有的静态方法(创建对象)
    public static function getInstance($params){
        if(self::$instance == null){
            self::$instance = new DB($params);
        }
        return self::$instance;
    }

    /**
     * 连接数据库
     * @return mysqli
     */
    private function link()
    {
        $this->link = mysqli_connect($this->host, $this->user, $this->password, $this->dbname, $this->port) or exit("连接失败");
    }

    /**
     * 设置编码
     */
    private function setCharset()
    {
        mysqli_set_charset($this->link, $this->charset);
    }

    /**
     * execute 执行 最好返回 bool 用该方法
     * 执行SQL的方法
     * @param $sql
     * @return mixed
     */
    public function execute($sql)
    {
        //>>1.执行SQL
        $result = mysqli_query($this->link, $sql);
        if ($result === false) {
            echo "错误编码:" . mysqli_errno($this->link) . "<br/>";
            echo "错误信息:" . mysqli_error($this->link) . "<br/>";
            echo "执行SQL:" . $sql . "<br/>";
            exit;
        }
        return $result;
    }

    /**
     * query 查询 建议执行 查询类的sql 用该方法
     * 执行SQL的方法
     * @param $sql
     * @return mixed
     */
    public function query($sql)
    {
        //>>1.执行SQL
        $result = mysqli_query($this->link, $sql);
        if ($result === false) {
            echo "错误编码:" . mysqli_errno($this->link) . "<br/>";
            echo "错误信息:" . mysqli_error($this->link) . "<br/>";
            echo "执行SQL:" . $sql . "<br/>";
            exit;
        }
        return $result;
    }


    /**
     * 执行查询sql,返回所有的数据
     * @return []|array 返回二维数组
     */
    public function fetchAll($sql)
    {
        //执行sql
        $result = $this->query($sql);//返回结果集对象
//        var_dump($result);exit;
        //返回所有数据
        //解析结果集对象
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
//            var_dump($rows);
        //返回
        return $rows;
    }

    /**
     * 执行查询类的sql语句,返回一条数据
     * @return [] 一维数组
     */
    public function fetchRow($sql)
    {
//        //执行sql语句
//            $result = $this->query($sql);//返回结果集对象
//        //返回执行后的结果
//            //解析结果集对象
//            $row = mysqli_fetch_assoc($result);//从结果集对象中取出一条关联数组
//            //返回
//            return $row;

        //执行sql语句
        $rows = $this->fetchAll($sql);
//            var_dump($rows);exit;
        //返回一条数据
        return empty($rows) ? [] : $rows[0];//当var存在，并且是一个非空非零的值时返回 FALSE 否则返回 TRUE.
    }

    /**
     * 执行sql语句,返回结果中的第一行的第一列的值
     * select count(*) as count from student
     * @return $value 返回一个值
     */
    public function fetchColumn($sql)
    {
//        //执行sql语句
//            $result = $this->query($sql);
////            var_dump($result);exit;
//        //返回结果
//            $row = mysqli_fetch_row($result);//取出结果集中的索引数组
////            var_dump($row[0]);exit;
//            return $row[0];

        //执行sql语句
        $row = $this->fetchRow($sql);//返回关联数组 一维
        //返回结果中的第一列的值
//            $row = array_values($row);
//            var_dump($row);exit;
        return empty($row) ? null : array_values($row)[0];
    }
    //该方法在对象序列化的时候自动调用,返回需要被序列化的变量名组成的数组
    public function __sleep()
    {
        return ['host','user','password','dbname','port','charset'];
    }
    //反序列化的时候自动调用,用于重新连接数据等初始化操作
    public function __wakeup()
    {
        //>>1.连接上数据库
        $this->link();
        //>>2.设置好编码
        $this->setCharset();
    }

    //转义字符串
    public function escape($param){
        return mysqli_real_escape_string($this->link,$param);
    }
}

