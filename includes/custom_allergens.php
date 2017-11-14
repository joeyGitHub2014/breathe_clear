<?php
//require_once(LIB_PATH.DS.'database.php');
require_once('database.php');
// REMEMBER "->" is instances and "::" is static
class CustomAllergens extends DatabaseObject
{
    public $patientID;
    public $analysisCount;
    public $allergenID;
    public $batteryName;
    public $antigenName;
    public $groupID;
    public $site;
    public $lotNumber;
    public $expDate;
    public $caption;
    public $disabled;
    public $MSPScore;
    public $ISPScore;
    public $fileName;

    public $twoWhl;

    //-------------------------
    //function set_table_fields
    //-------------------------
    public static function set_custom_allergens_table() {
        $db_feilds = array('patientID', 'analysisCount', 'batteryName', 'antigenName', 'groupID', 'site', 'lotNumber',
            'expDate','fileName', 'caption', 'disabled', 'MSPScore', 'ISPScore', 'twoWhl');
        $str = "custom_allergens";
        parent::set_table_fields($str, $db_feilds);
    }
    //-------------------------
    //function create
    //-------------------------
    public function create() {
        global $database;

        $attributes = $this->sanitized_attributes();
        $sql = "INSERT INTO " . self::$table_name . " (";
        $sql .= join(", ", array_keys($attributes));
        $sql .= ") VALUES ('";
        $sql .= join("', '", array_values($attributes));
        $sql .= "')";
        if ($database->query($sql)) {
            $this->id = $database->insert_id();
            return true;
        } else {
            return false;
        }
    }

    //-------------------------
    //function update
    //-------------------------
    public function update($allergenID,$patientID ){
        global $database;
        $attributes = $this->sanitized_attributes();
        foreach($attributes as $key => $value){
            if(!empty($value)) {
                $attributes_pairs[] = "{$key} = '{$value}'";
            }
        }

        if (!empty($attributes_pairs)){
            $sql  = "UPDATE " .self::$table_name .  "  SET ";
            $sql .= join(", ", $attributes_pairs);
            $sql .= " WHERE allergenID = " .  $allergenID;
            $sql .= " AND patientID = " .  $patientID;
            $database->query($sql);
            return ($database->affected_rows() == 1)? true : false;
        }else{
            return  true;

        }
    }
    //-------------------------
    //function delete
    //-----------------------
    public function delete() {
        global $database;
        $sql = "DELETE  FROM  " . self::$table_name;
        $sql .= " WHERE allergenID = " . $database->escape_value($this->allergenID);
        $sql .= " AND patientID = " . $database->escape_value($this->patientID);

        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;

    }
    //-------------------------
    //function getAllergen
    //-------------------------
    public static function getCustomAllergen($id = 0, $patiendID) {
        global $database;
        //  make a late satinc bunding. binding that happens at run time
        $result_array = static::find_by_sql($sql =
            "SELECT * FROM " . static::$table_name . " WHERE allergenID = " . $database->escape_value($id) . " AND patientID = " . $patiendID . " LIMIT 1");
        //array_shift pulls first element out of the array ==  $result_array[0]
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    //-------------------------
    //function update_msp
    //-------------------------
    public function update_msp() {
        global $database;
        $sql = "UPDATE   " . self::$table_name . "  SET ";
        $sql .= " MSPScore = " . $database->escape_value($this->MSPScore);
        $sql .= " WHERE patientID = " . $database->escape_value($this->patientID);
        $sql .= " AND allergenID = " . $database->escape_value($this->allergenID);
        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;
    }
    //-------------------------
    //function update_isp
    //-------------------------
    public function update_isp() {
        global $database;
        $sql = "UPDATE   " . self::$table_name . "  SET ";
        $sql .= " ISPScore = " . $database->escape_value($this->ISPScore);
        $sql .= " WHERE patientID = " . $database->escape_value($this->patientID);
        $sql .= " AND allergenID = " . $database->escape_value($this->allergenID);
        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;
    }
    //-------------------------
    //function update_twoWhl
    //-------------------------
    public function update_twoWhl(){
        global $database;
        $sql  = "UPDATE   " .self::$table_name .  "  SET ";
        $sql .= " twoWhl = " .  $database->escape_value($this->twoWhl);
        $sql .= " WHERE patientID = " .  $database->escape_value($this->patientID);
        $sql .= " AND allergenID = " .  $database->escape_value($this->allergenID);
        $database->query($sql);
        return ($database->affected_rows() == 1)? true : false;
    }
}
?>