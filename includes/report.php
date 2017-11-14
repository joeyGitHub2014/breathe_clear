<?php
//require_once(LIB_PATH.DS.'database.php');
require_once('database.php');

class Report extends DatabaseObject{
    public $reportID;
    public $analysisID;
    public $analysisCount;
    public $patientID;
    public $allergenID;
    public $allergenName;
    public $treatment;
    public $dilutionLevel;
    public $dilution;
    public $lotNumber;
    public $expDate;
    public $quantity;
    public $errors = array();
    //-------------------------
    //function set_table_fields
    //-------------------------
    public static function set_table_fields(){
        $db_feilds =  array('reportID','patientID','analysisID','allergenID','analysisCount','allergenName','treatment','dilutionLevel',
			    'dilution','quantity','lotNumber','expDate');
        parent::set_table_fields("analysis",$db_feilds);
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
	$sql = "SELECT id, username FROM users
                WHERE username = '{$username}'
		AND password = '{$password}'
                LIMIT 1";
        $result = self::find_by_sql($sql);
        return !empty($result) ? array_shift($result) : false;
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
        $sql .= " WHERE patientID = " .  $database->escape_value($this->patientID);
	$sql .= " AND analysisCount = " .  $database->escape_value($this->analysisCount);
        $database->query($sql);
        return ($database->affected_rows() == 1)? true : false;
    }
    //-------------------------
    //function delete
    //-------------------------
    public function delete(){
        global $database;
        $sql  = "DELETE FROM  " .self::$table_name;
        $sql .= " WHERE id = " .  $database->escape_value($this->id);
        $sql .= " LIMIT 1";
        $database->query($sql);
        return ($database->affected_rows() == 1)? true : false;

    }
    //-------------------------
    //function save
    //-------------------------
     public function save(){
         if (isset($this->)){
            // new record won't have an reportID
            // update the report
            $this->update();
         }else{
            // check errors
            if(!empty($this->errors)){
                return false;
            }
            if(  $this->create()){
                    // we are done with temp_path file isn't there anymore
                    return true;
            }else{
                $this->errors[] = "Creating of report failed.";
                return false;
            }
         }
     }
     }
?>