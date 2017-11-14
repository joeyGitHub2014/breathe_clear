<?php
//require_once(LIB_PATH.DS.'database.php');
require_once('database.php');

class Analysis extends DatabaseObject{
    public $analysisID;
    public $analysisCount;
    public $patientID;
    public $allergenID;
    public $MSPScore;
    public $ITScore;
    public $validated;
    public $dateAdded;
    public $treatment;
    public $twoWhl;
    public $dilutionLevel;
    public $refill;
    private $temp_path;
    public $upload_dir = "images";
    public $errors = array();
    public $upload_errors = array( 
       UPLOAD_ERR_OK          => "No Errors.",
       UPLOAD_ERR_INI_SIZE    => "Larger than uplaod_max_filesize.",
       UPLOAD_ERR_FORM_SIZE   => "Larger than form MAX_FILE_SIZE.",
       UPLOAD_ERR_PARTIAL     => "Partial upload.",
       UPLOAD_ERR_NO_FILE     => "No File.",
       UPLOAD_ERR_NO_TMP_DIR  => "No temporary directory.",
       UPLOAD_ERR_CANT_WRITE  => "Can't write to disk.",
       UPLOAD_ERR_EXTENSION   => "File upload stopped by extension."
    );
    //-------------------------
    //function set_table_fields
    //-------------------------
    public static function set_analysis_table($tname='analysis'){
        $db_feilds =  array('analysisCount','patientID','allergenID','MSPScore','ITScore','validated','dateAdded',
			    'treatment','dilutionLevel','twoWhl','refill');
        parent::set_table_fields($tname,$db_feilds);
     }
     
    //-------------------------
    //function comments
    //-------------------------
    public function comments(){
        return Comment::find_comments_on($this->id);
    }
    //-------------------------
    //function attach_file
    //-----------------------
    // Pass in $_FILE(['uploaded_file'])  as an argument
    public  function attach_file($file){
        if(!$file || empty($file) || !is_array($file)){
            $this->errors[] = "No file was uploaded";    
            return false;
        }elseif($file['error'] != 0){
             $this->errors[] = $this->upload_errors[$file['error']];
            return false;
        }else{
            // set object att. to the form parameters
            $this->temp_path = $file['tmp_name'];
            $this->filename = basename( $file['name']);
            $this->type =  $file['type'];
            $this->size =  $file['size'];
            return true;
        }
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
    //function create
    //-------------------------
    public function insertNewRecord(){
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
    //function update_msp
    //-------------------------
    public function update_msp(){
        global $database;
        $sql  = "UPDATE   " .self::$table_name .  "  SET ";
        $sql .= " MSPScore = " .  $database->escape_value($this->MSPScore) ;
        $sql .= " WHERE patientID = " .  $database->escape_value($this->patientID);
	    $sql .= " AND analysisCount = " .  $database->escape_value($this->analysisCount);
	    $sql .= " AND allergenID = " .  $database->escape_value($this->allergenID);
        $database->query($sql);
        return ($database->affected_rows() == 1)? true : false;
        
    }

    //-------------------------
    //function update_isp
    //-------------------------
    public function update_isp(){
        global $database;
        $sql  = "UPDATE   " .self::$table_name .  "  SET ";
        $sql .= " ITScore = " .  $database->escape_value($this->ITScore);
        $sql .= " WHERE patientID = " .  $database->escape_value($this->patientID);
	    $sql .= " AND analysisCount = " .  $database->escape_value($this->analysisCount);
	    $sql .= " AND allergenID = " .  $database->escape_value($this->allergenID);
        $database->query($sql);
        return ($database->affected_rows() == 1)? true : false;
    }
    //-------------------------
    //function delete_analisys
    //-------------------------
    public function delete_analysis($id,$count){
        global $database;
        $sql  = "DELETE FROM  " .self::$table_name;
        $sql .= " WHERE patientID = {$id} ";
        $sql .= " AND analysisCount = {$count} ";
        $database->query($sql);
        return ($database->affected_rows() >= 1)? true : false;

    }
    //-------------------------
    //function update_twoWhl
    //-------------------------
    public function update_twoWhl(){
        global $database;
        $sql  = "UPDATE   " .self::$table_name .  "  SET ";
        $sql .= " twoWhl = " .  $database->escape_value($this->twoWhl);
        $sql .= " WHERE patientID = " .  $database->escape_value($this->patientID);
	    $sql .= " AND analysisCount = " .  $database->escape_value($this->analysisCount);
	    $sql .= " AND allergenID = " .  $database->escape_value($this->allergenID);
        $database->query($sql);
        return ($database->affected_rows() == 1)? true : false;
    }
    //-------------------------
    //function delete_all_analysis
    //-------------------------
    public function delete_all_analysis($id){
        global $database;
        $sql  = "DELETE FROM  " .self::$table_name;
        $sql .= " WHERE patientID = {$id} ";
        $database->query($sql);
        return ($database->affected_rows() >= 1)? true : false;

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
    //function custom save
    //-------------------------
     public function save(){
         if (isset($this->id)){
            // new record won't have an id
            // update the caption
            $this->update();
         }else{
            // check errors
            if(!empty($this->errors)){
                return false;
            }
            if (strlen($this->caption)  >= 255){
                $this->errors[] = "The caption is greater than 255.";
                return false;
            }
            if(  empty($this->filename) || empty($this->temp_path)){
                $this->errors[] = "The file location was not available.";
                return false;
            }
            $target_path = SITE_ROOT .DS. 'public' .DS. $this->upload_dir .DS. $this->filename;
            if ( file_exists($target_path)){
                $this->errors[] = "The File {$this->filename} already exists.";
                return false;
            }
            if (move_uploaded_file($this->temp_path,$target_path)){
                if(  $this->create()){
                    // we are done with temp_path file isn't there anymore
                    unset($this->temp_path);
                    return true;
                }
            }else{
                $this->errors[] = "File uploaded failed, possibly incorrect permissions on the upload file.";
                return false;
            }
         }
     }
        //-------------------------
        //function size_as_text
        //-------------------------
        public function size_as_text(){
            if($this->size < 1024){
                return "{$this->size} bytes";
            }elseif ($this->size < 1048576){
                $size_kb = round($this->size/1024);
                return "{$size_kb} KB";
            }else{
                $size_mb = round($this->size/1048576);
                return "{$size_mb} MB";
            }
        }
        //-------------------------
        //function destroy
        //-------------------------
        public function destroy(){
            if ($this->delete()){
                $target_path = SITE_ROOT .DS. 'public' .DS. $this->upload_dir .DS. $this->filename;
                return unlink($target_path)? true : false;
            }else {
                return false;
            }
        }
	//------------------------------
	//function get_max_analysis_count
	//------------------------------
	public static function get_max_analysis_count($id){
	    global $database;
	    $sql = "SELECT MAX(analysisCount) FROM analysis WHERE patientID = {$id} LIMIT 1";
	    $result = $database->query($sql);
	    $count =  mysqli_fetch_assoc($result);
	    return !empty($count) ? array_shift($count)  : 'false';
	}
	//------------------------------
	//function get_analysis_date
	//------------------------------
	public static function get_analysis_date($id, $count){
	    global $database;
	    $sql = "SELECT dateAdded FROM analysis WHERE patientID = {$id} AND analysisCount = {$count} LIMIT 1";
	    $result = self::find_by_sql($sql);
	    return !empty($result) ? array_shift($result) : false;
	}
	//------------------------------
	//function get_treatment
	//------------------------------
	public static function get_treatment($id, $count){
	    global $database;
	    $sql = "SELECT treatment FROM analysis WHERE patientID = {$id} AND analysisCount = {$count} LIMIT 1";
	    $result = $database->query($sql);
	    $treatment =  mysqli_fetch_assoc($result);
	    return !empty($treatment) ? array_shift($treatment) : 0;
	}
	//------------------------------
	//function get_dilutionLevel
	//------------------------------
	public static function get_dilutionLevel($id, $count){
	    global $database;
	    $sql = "SELECT dilutionLevel FROM analysis WHERE patientID = {$id} AND analysisCount = {$count} LIMIT 1";
	    $result = $database->query($sql);
	    $dilutionLevel =  mysqli_fetch_assoc($result);
	    return !empty($dilutionLevel) ? array_shift($dilutionLevel) : 0;
	}
	
	//-------------------------
    //function update_dilution
    //-------------------------
    public function update_dilution(){
        global $database;
        $sql  = "UPDATE   " .self::$table_name .  "  SET ";
        $sql .= " dilution = " .  $database->escape_value($this->dilution) ;
        $sql .= " WHERE patientID = " .  $database->escape_value($this->patientID);
		$sql .= " AND analysisCount = " .  $database->escape_value($this->analysisCount);
		$sql .= " AND allergenID = " .  $database->escape_value($this->allergenID);
        $database->query($sql);
        return ($database->affected_rows() == 1)? true : false;
        
    }
	//-------------------------
	//function update_treat
	//-------------------------
	public function update_treat(){
	    global $database;
	    $sql  = "UPDATE   " .self::$table_name .  "  SET ";
	    $sql .= " treatment = " .  $database->escape_value($this->treatment) ;
	    $sql .= " WHERE patientID = " .  $database->escape_value($this->patientID);
	    $sql .= " AND analysisCount = " .  $database->escape_value($this->analysisCount);
	    $database->query($sql);
	    return ($database->affected_rows() > 1)? true : false;
	}
	//-------------------------
	//function update_dilutionLevel
	//-------------------------
	public function update_dilutionLevel(){
	    global $database;
	    $sql  = "UPDATE   " .self::$table_name .  "  SET ";
	    $sql .= " dilutionLevel = " .  $database->escape_value($this->dilutionLevel) ;
	    $sql .= " WHERE patientID = " .  $database->escape_value($this->patientID);
	    $sql .= " AND analysisCount = " .  $database->escape_value($this->analysisCount);
	    $database->query($sql);
	    return ($database->affected_rows() > 1)? true : false;
	}
	//------------------------------
	//function get_refill
	//------------------------------
	public static function get_refill($id, $count){
	    global $database;
	    $sql = "SELECT refill FROM analysis WHERE patientID = {$id} AND analysisCount = {$count} LIMIT 1";
	    $result = $database->query($sql);
	    $refill =  mysqli_fetch_assoc($result);
	    return !empty($refill) ? array_shift($refill) : 0;
	}
	//-------------------------
	//function update_refill
	//-------------------------
	public function update_refill(){
	    global $database;
	    $sql  = "UPDATE   " .self::$table_name .  "  SET ";
	    $sql .= " refill = " .  $database->escape_value($this->refill) ;
	    $sql .= " WHERE patientID = " .  $database->escape_value($this->patientID);
	    $sql .= " AND analysisCount = " .  $database->escape_value($this->analysisCount);
	    $database->query($sql);
	    return ($database->affected_rows() > 1)? true : false;
	}
}

?>