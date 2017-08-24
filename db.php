<?php 
class mysqlClass{
	var $dbhost;
	var $name;
	var $password;
	var $link;
	var $database;
	var $sql; 
	/*
		初始化
	 */
	function __construct($arrconfig){
		$this->dbhost = $arrconfig['localhost'];
		$this->name = $arrconfig['username'];
		$this->password = $arrconfig['password'];
		$this->database = $arrconfig['database'];
		$this->connect();
		$this->selectdb();
	}
	function connect(){
		$this->link = mysql_connect($this->dbhost,$this->name,$this->password) or die('连接数据库失败');
	}
	function selectdb(){
		mysql_select_db($this->database,$this->link);
	}
	function select($table_name,$selectname,$order){
		$selectsql = 'SELECT'.' '.$selectname.' FROM '.$table_name.' '.$order;
		$arr = array();
		$result = $this->query($selectsql);
		while ( $row = mysql_fetch_assoc($result)) {
			array_push($arr,$row);
		}
		return $arr;
	}

	function inset($sql){
        return $this->query($sql);
	}
	function query($sql){
		return mysql_query($sql,$this->link);
	}
	function delete($table_name,$where){
		$deletesql = 'delete from '.$table_name.' where '.$where;
		if (count($this->select($table_name,'*',''))>0) {
			if ($this->query($deletesql)) {
				return json_encode(array('result'=>'success'));
			}
		}else{
			return json_encode(array('result'=>'fail','info'=>'数据查询不到'));
		}
	}
	function updata($table_name,$set,$where){
		$selectsql = 'select * from '.$table_name.' where '.$where;
		$updatasql = 'update '.$table_name.' set '.$set.'  where '.$where;
		if (count($this->select($table_name,'*',''))>0) {
			if ($this->query($updatasql)) {
				echo json_encode(array('result'=>'success'));
			}
		}else{
			echo json_encode(array('result'=>'fail','info'=>'数据查询不到'));
		}
	}
}
/*
INSERT INTO table_name (column1, column2,...)
VALUES (value1, value2,....)
UPDATE table_name
SET column_name = new_value
WHERE column_name = some_value
 */
 // $mysql = new mysqlClass($config['dbconfig']);
 // $mysql->updata('user',"username = 'ln'","id = '9'");


?>