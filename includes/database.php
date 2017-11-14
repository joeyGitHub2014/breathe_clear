<?php
require_once("config.php");

class Database{
	private $connection;
	public $last_query;
	public $magic_quotes_active;
	public $real_escape_string_exists;
	//-------------------------
	//function __construct
	//-------------------------
	function __construct(){
		$this->openConnection();
		$this->magic_quotes_active = get_magic_quotes_gpc();
		$this->real_escape_string_exists = function_exists("mysqli_real_escape_string");
	}
	//-------------------------
	//function openConnection
	//-------------------------
	public function openConnection(){
		// 1. Create a database connection
		$this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
		if(!$this->connection){
			die("Database connection failed  Code--> openConnection " . mysqli_error($this->connection));
		}
		else{
			// 2. Select a database to use
			//$db_select = mysql_select_db(DB_NAME,$this->connection);
 			$db_select = mysqli_select_db($this->connection, DB_NAME);
			///outputMessage('jjjjdjjjdj');
			if(!$db_select){
				die("Database selection failed " . mysqli_error($this->connection));
			}
		}
	}
	//-------------------------
	//function closeConnection
	//-------------------------
	public function closeConnection(){
	//Close connection
		if(isset($this->connection)){
			mysqli_close($this->connection);
			unset($this->connection);
		}
	}
	//-------------------------
	//function query
	//-------------------------
	public function query($sql){
		$this->last_query =  $sql;
		$results = mysqli_query($this->connection,$sql);
		$this->confirmQuery($results);
		return $results;
	}
	//-------------------------
	//function confirmQuery
	//-------------------------
	// all basic functions
	private function confirmQuery($result){
		if(!$result){
			$output = "Database query failed   ".mysqli_connect_error(). "<br/>";
			$output .= "Last SQL query was  :  " . $this->last_query;
			print_r($output);
			die(mysqli_error($this->connection));
		}
	}
	//-------------------------
	//function fetch_array
	//-------------------------
	//making fetch_array agnostic. might have a differnt database i.e. database neutral
	public function fetch_array($value){
		return mysqli_fetch_array($value);
	}
	//-------------------------
	//function num_rows
	//-------------------------
	public function num_rows($value){
		return mysqli_num_rows($value);
	}
	//-------------------------
	//function insert_id
	//-------------------------
	public function insert_id($value=""){
		// get the last id inserted over the current db connection
		//printf ("New Record has id %d.\n", $mysqli->insert_id);

		return mysqli_insert_id($this->connection);
	}
	//-------------------------
	//function affected_rows
	//-------------------------
	public function affected_rows( ){
		return mysqli_affected_rows($this->connection);
	}
	//-------------------------
	//function escape_value
	//-------------------------
	public  function escape_value($value){
 		// myphpinfo file and checks magic_quotes_gpc on/off
		if ($this->real_escape_string_exists){ //i.e. PHP  v4.3.0 or higher
			//undo any magic quote effects so mysqli_real_escape_string can do the work
			if($this->magic_quotes_active){
				$value = stripslashes($value);
			}
			 // mysqli_real_escape_string — Escapes special characters in a string for use in an SQL statement
			$value = mysqli_real_escape_string($this->connection, $value);
		} else{//before PHP  v4.3.0  
				if(!$this->magic_quotes_active){
					$value = addslashes($value);
				}
			}


		return ($value);
	}
}
$database = new Database();
?>