<?php
require_once(LIB_PATH.DS.'database.php');
class Comment extends DatabaseObject{
    public $id;
    public $photograph_id;
    public $created;
    public $author;
    public $body;
    //-------------------------
    //function make
    //-------------------------
    public function set_table_fields(){
        $db_feilds =  array('id','photograph_id','created', 'author','body');
        $table_name ="comments";
        parent::set_table_fields($table_name,$db_feilds);
     }
    //-------------------------
    //function make
    //-------------------------
    public static function make($photo_id, $author="Anonymous", $body=''){
        date_default_timezone_set('America/Los_Angeles');
        if (!empty($photo_id) && !empty($author) && !empty($body)){
            $comment = new Comment();
            $comment->set_table_fields();
            $comment->photograph_id = (int) $photo_id;
            $comment->created = strftime("%Y-%m-%d %H:%M:%S", time() );
            $comment->author = $author;
            $comment->body = $body;
            return $comment;
        }else{
            return false;
        }
    }
    //-------------------------
    //function find_comments_on
    //-------------------------
    public static function find_comments_on($photo_id=0){
        self::set_table_fields();
        global $database;
        $sql  = "SELECT * FROM ".parent::$table_name;
        $sql .= " WHERE photograph_id=" .$database->escape_value($photo_id);
        $sql .= " ORDER BY created ASC";
        return parent::find_by_sql($sql);
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
    //function delete
    //-------------------------
    public function save(){
        return  (isset($this->id))  ? $this->update() :  $this->create();
    }
}
?>