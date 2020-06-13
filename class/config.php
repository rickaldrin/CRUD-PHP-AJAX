<?php 
/**
 * 6-9-2020;
 */
class config{
	
	private $user = 'root';
	private $pass = '';
	private $db = 'todolist_db';
	private $server = 'localhost';
	private $dbtype = 'mysql';	
	public $pdo = null;
	

	public function __construct(){
		
		$this->con = $this->connect();
	}

	public function connect(){
		
		try {
		//charset=utf8";	
		$this->pdo = new PDO($this->dbtype.":host=".$this->server.";dbname=".$this->db,$this->user,$this->pass);

		} catch (PDOException $e) {
			
			die('Connection error, because: ' .$e->getMessage());
		}

		return $this->pdo;
	}

	public function select_table($sql_query,$values = array(),$error_msg = 'Select Error query'){
		
		$data = $this->con->prepare($sql_query);
		$data->execute($values);

		return  $data;
	}

	public function insert_table($table,$data,$error_msg = 'Insert Error query'){
		

		$data_field = null;
		$data_value = null;
		foreach ($data as $key => $value) {
			$data_field .= '`'.$key.'`,';
			$data_value .= "'".$value."',";
		}

		$sql = "INSERT INTO `$table` (".rtrim($data_field, ',').") VALUES (".rtrim($data_value, ',').")";
		$data = $this->con->prepare($sql);
		if ($data->execute()) {

			return true;

		}else{

			return $error_msg;//.' '.var_dump($data);
		}

	}

	public function delete_table($sql_query,$values = array(),$error_msg = 'delete Error query'){
		
		$data = $this->con->prepare($sql_query);
		$data->execute($values);

		return  $data;
	}

	public function update_table($sql_query,$values = array(),$error_msg = 'update Error query'){
		
		$data = $this->con->prepare($sql_query);
		$data->execute($values);

		return  $data;
	}


	public function lastinsert_table(){
		return $this->con->lastInsertId();
	}
}
?>