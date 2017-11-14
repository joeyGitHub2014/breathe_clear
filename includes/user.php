<?php
//require_once(LIB_PATH.DS.'database.php');
require_once('database.php');
?>
<?php
class User extends DatabaseObject{
    public $id0;
    public $u1;
    public $p2;
    public $first_name;
    public $last_name;
    
    public static function set_user_table(){
        $db_feilds =  array('id0','u1','p2');
        parent::set_table_fields("admin1",$db_feilds);
     }
    //-------------------------
    //function authenticate
    //-------------------------
    public static function authenticate($username="", $password=""){
        global $database;
        $username = $database->escape_value($username);
        $password = $database->escape_value($password);
	
        // creates a 40 char long encrpted string
        //$hashed_password = sha1($password);
		// using ma5
	    $sql = "SELECT id0, u1 FROM admin1 WHERE u1 = '{$username}'
		        AND p2 = '{$password}' LIMIT 1";
        $result = self::find_by_sql($sql);

        return !empty($result) ? array_shift($result) : false;
    }
    //-------------------------
    //function haveUser
    //-------------------------
    public static function haveUser($username=""){
        global $database;
        $username = $database->escape_value($username);
        // creates a 40 char long encrpted string
        //$hashed_password = sha1($password);
	// using ma5
	$sql = "SELECT id0, u1 FROM admin1
                WHERE u1 = '{$username}'
                LIMIT 1";
        $result = self::find_by_sql($sql);
        return !empty($result) ? array_shift($result) : false;
    }
    //-------------------------
    //function full_name
    //-------------------------
    public function full_name(){
        if (isset($this->first_name) && isset($this->last_name) ){
            return $this->first_name ." " . $this->last_name;
        }else{
            return "";
        }
    }
    //-------------------------
    //function create
    //-------------------------
    public function create(){
        global $database;
        $attributes = $this->sanitized_attributes();
        $sql  = "INSERT INTO " .self::$table_name .  " (";
        $sql .= join(", ", array_keys($attributes));  
        $sql .= ") VALUES ('";
        $sql .=  join("', '", array_values($attributes)); 
        $sql .= "')";
        if ($database->query($sql)){
            $this->id = $database->insert_id();
            return true;
        }else{
            return false;
        }
     } 
    //-------------------------
    //function update
    //-------------------------
    public function update(){
        global $database;
        $attributes = $this->sanitized_attributes();
        foreach($attributes as $key => $value){
            $attributes_pairs[] = "{$key} = '{$value}'"; 
        }
        $sql  = "UPDATE   " .self::$table_name .  "  SET ";
        $sql .= join(", ", $attributes_pairs);  
        $sql .= " WHERE id = " .  $database->escape_value($this->id);
        $database->query($sql);
        return ($database->affected_rows() == 1)? true : false;
        
    }
    //-------------------------
    //function delete
    //-------------------------
    public function delete(){
        global $database;
        $sql  = "DELETE FROM  " .self::$table_name;
        $sql .= " WHERE id0 = " .  $database->escape_value($this->id);
        $sql .= " LIMIT 1";
        $database->query($sql);
        return ($database->affected_rows() == 1)? true : false;

    }
    //-------------------------
    //function save
    //-------------------------
    public function save(){
        return  (isset($this->id))  ? $this->update() :  $this->create();
    }
}

?>