<?php
require_once(LIB_PATH.DS.'database.php');

class Photograph extends DatabaseObject{
    public $id;
    public $filename;
    public $type;
    public $size;
    public $caption;
    
    private $temp_path;
    public $upload_dir = "images";
    public $errors = array();
    
    public function set_table_fields(){
        $db_feilds =  array('id','filename','type', 'size','caption');
        parent::set_table_fields("photographs",$db_feilds);
     }
     
    //-------------------------
    //function comments
    //-------------------------
    public function comments(){
        return Comment::find_comments_on($this->id);
    }
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
        $sql .= " WHERE id = " .  $database->escape_value($this->id);
        $sql .= " LIMIT 1";
        $database->query($sql);
        return ($database->affected_rows() == 1)? true : false;

    }
    //-------------------------
    //function save
    //-------------------------
    //public function save(){
        // new record won't have an id
        //return  (isset($this->id))  ? $this->update() :  $this->create();
    //}
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
}
?>