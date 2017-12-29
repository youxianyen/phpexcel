<?php
require (dirname(__FILE__).'/dbconfig.php');  //引入配置文件

class db {
	public $conn = null;

	public function __construct($config)
	{
		$this->conn = mysqli_connect($config['host'], $config['username'], $config['password']) or die(mysqli_error());
		mysqli_select_db($this->conn, $config['database']) or die(mysqli_error());  //选择数据库		
		mysqli_set_charset($this->conn,"utf8");     // 修改数据库连接字符集为 utf8
	}

    /*
    根据传入SQL语句，查询MySQL结果集
    */

    
	public function getResult($sql)
	{
		echo "<pre>";
		print_r($this->conn);exit();
		$resource = mysqli_query($this->conn, $sql) or die (mysqli_error($this->conn));  //查询SQL语句
		$res = [];
		while (($row = mysqli_fetch_assoc($resource)) != false) {
			$res = $row;
		}
		return $res; 
	}

	/*
	根据传入年级数 查询每个学生的数据
	*/
	public function getDataByGrade($grade)
	{
		$sql = "select username, score, class, grade from user where grade = " . $grade . "order by score desc";
		$res = self::getResult($sql);
		return $res;
	}
}