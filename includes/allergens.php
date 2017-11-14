<?php
//require_once(LIB_PATH.DS.'database.php');
require_once('database.php');
// REMEMBER "->" is instances and "::" is static
class Allergen extends DatabaseObject{
    public $allergenID;
    public $batteryName;
    public $antigenName;
    public $groupID;
    public $site;
    public $lotNumber;
    public $expDate;
    public $fileName;
    public $caption;
    public $disabled;
    public $customID;

    public $errors = array();
    public $upload_dir = "images";
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
    private $temp_path;
    //-------------------------
    //function set_table_fields
    //-------------------------
    public static  function set_allergen_table(){
        $db_feilds =  array('allergenID','batteryName','antigenName','groupID','site','lotNumber','expDate','fileName','caption', 'disabled', 'customID');
        $str = "allergens1";
        parent::set_table_fields($str,$db_feilds);
     }
    //-------------------------
    //function comments
    //-------------------------
    public function comments(){
        return Comment::find_comments_on($this->id);
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
            if(!empty($value)) {
                $attributes_pairs[] = "{$key} = '{$value}'";
            }
        }
        if (!empty($attributes_pairs)){
            $sql  = "UPDATE   " .self::$table_name .  "  SET ";
            $sql .= join(", ", $attributes_pairs);
            $sql .= " WHERE allergenID = " .  $database->escape_value($this->allergenID);
            $database->query($sql);
            return ($database->affected_rows() == 1)? true : false;
        }else{
            return  true;

        }
    }
    //-------------------------
    //function delete
    //-------------------------
    public function delete(){
        global $database;
        $sql  = "DELETE FROM  " .self::$table_name;
        $sql .= " WHERE allergenID = " .  $database->escape_value($this->allergenID);
        $sql .= " LIMIT 1";
        $database->query($sql);
        return ($database->affected_rows() == 1)? true : false;
    }
    //-------------------------
    //function getAllergen
    //-------------------------
    public static function getAllergen($id=0){
        global $database;
        //  make a late satinc bunding. binding that happens at run time
        $result_array = static::find_by_sql($sql = "SELECT * FROM ".static::$table_name . " WHERE allergenID = " .$database->escape_value($id). " LIMIT 1");
        //array_shift pulls first element out of the array ==  $result_array[0]
        return !empty($result_array) ? array_shift($result_array) : false;
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
         if (isset($this->allergenID)){
            // new record won't have an id
            // update the caption, file, 
            $this->update();
         }else{
            // check errors
            if(!empty($this->errors)){
                return false;
            }
            if (strlen($this->caption)  >= 700){
                $this->errors[] = "The caption is greater than 700";
                return false;
            }
            if(  empty($this->fileName) || empty($this->temp_path)){
                $this->errors[] = "The file location was not available.";
                return false;
            }
            //$target_path = SITE_ROOT .DS. 'public' .DS. $this->upload_dir .DS. $this->fileName;
	        $target_path = '../' .DS. $this->upload_dir .DS. $this->fileName;

            if ( file_exists($target_path)){
                $this->errors[] = "The File {$this->fileName} already exists.";
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
            $this->fileName = basename( $file['name']);
            return true;
        }
    }
    //-------------------------
    //function move_image
    //-----------------------
    public function move_image(){
	    if(  empty($this->fileName) || empty($this->temp_path)){
                $this->errors[] = "The file location was not available.";
                return false;
            }
            //$target_path = SITE_ROOT .DS. 'public' .DS. $this->upload_dir .DS. $this->fileName;
	    $target_path = '../' .DS. $this->upload_dir .DS. $this->fileName;

            if ( file_exists($target_path)){
                $this->errors[] = "The File {$this->fileName} already exists.";
                return false;
            }
            if (move_uploaded_file($this->temp_path,$target_path)){
                    // we are done with temp_path file isn't there anymore
                    unset($this->temp_path);
                    return true;
            }else{
                $this->errors[] = "File uploaded failed, possibly incorrect permissions on the upload file.";
                return false;
            }
    }
    //-------------------------
    //function update_disabled
    //-----------------------
    public static function update_disabled($value, $id){
        global $database;
        $sql  = "UPDATE  " .self::$table_name .  "  SET ";
        $sql .= " disabled = " . $value;
        $sql .= " WHERE allergenID = " . $id;
        $database->query($sql);
        return ($database->affected_rows() == 1)? true : false;
    }
}
?>