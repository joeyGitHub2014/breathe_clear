<?php
 
require_once('database.php');

class DatabaseObject{
    protected static $table_name ;
    protected static $db_fields ;
    
    protected function set_table_name($table){
        self::$table_name = $table;
    }
    protected static function set_table_fields($table,$array_fields){
        self::$table_name = $table;
        self::$db_fields = $array_fields;
    }
    //late static binding new in php 5.3
    // php.net/lsb
    // common database methodes   
    public static function find_all(){
        $result_set = static::find_by_sql("SELECT * FROM " .static::$table_name);
        return $result_set;
    }

    public static function count_all(){
        global $database;
        $sql = "SELECT COUNT(*) FROM " .static::$table_name;
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
    }
    public  function find_by_id($id=0){
        global $database;
        //  make a late satinc bunding. binding that happens at run time
        $result_array = static::find_by_sql($sql = "SELECT * FROM ".static::$table_name . " WHERE id = " .$database->escape_value($id). " LIMIT 1");
        //array_shift pulls first element out of the array ==  $result_array[0]
        return !empty($result_array) ? array_shift($result_array) : false;
    }
    public  function find_by_patientID($id=0){
        global $database;
        // make a late static bunding. binding that happens at run time
        $result_array = static::find_by_sql($sql = "SELECT * FROM ".static::$table_name .
            " WHERE patientID = " .$database->escape_value($id). " LIMIT 1");
        //array_shift pulls first element out of the array ==  $result_array[0]
        return !empty($result_array) ? array_shift($result_array) : false;
    }    
    public static function find_by_sql($sql=""){
        global $database;
        $result_set = $database->query($sql);

        $object_array = array();

        while($row = $database->fetch_array($result_set)){
            $object_array[]= self::instantiate($row);

        }
        // returns an array of objects

        return $object_array;
    }
    private static function instantiate($record){
        $class_name = get_called_class();
        $object = new $class_name;
        foreach($record as $attribute=> $value){

            if($object->has_attribute($attribute)){
                $object->$attribute  = $value;
            }
        }
        return $object;
    }

    private  function has_attribute($attribute){
         // get_object_vars returns assotitive array with all attributes
         // includes private atrributes as well
         $object_vars = get_object_vars($this);
         // just want to know if key exisits not consernd about value
         return array_key_exists($attribute,$object_vars);
    }
    protected function attributes(){
        $attributes = array();
        // return an array of attributes keys and their values
        foreach(self::$db_fields as $field){
            if (property_exists($this,$field)){
                $attributes[$field] = $this->$field;
            }
        }
        return $attributes;
     }
    protected function sanitized_attributes(){
        global $database;
        $clean_attributes = array();
        foreach ($this->attributes() as $key => $value){
            $clean_attributes[$key] = $database->escape_value($value);
        }
         return $clean_attributes;
    }

}
?>