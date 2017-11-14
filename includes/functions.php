<?php
function redirectTo($location = NULL){
        if ($location != NULL){
				 header("Location:{$location}");
                exit;
        }
    }
//-------------------------------
//function strip_zeros_from_date
//-------------------------------
function strip_zeros_from_date($marked_string= ""){
    // remove the marked zeros
    $no_zeros = str_replace('*0','',$marked_string);
    // remove any remaining marks
    $clean_string = str_replace("*",'',$no_zeros);
    return $clean_string;
}

//----------------------------
//function outputMessage
//----------------------------
function outputMessage($message="", $color=""){
    if (!empty($message) ){
        echo "<p class=\"message\" style=\"color:".$color."\">". $message . "</p>";
    }else{
        return("");
    }
}

//----------------------------
//function __autoload
//----------------------------
function __autoload($class_name){
        $class_name = strtolower($class_name);
        $path = LIB_PATH.DS."{$class_name}.php";
        if (file_exists($path)){
                require_once($path);
        }else{
                die("The file {$class_name}.php could not be found");
        }
        
}
//----------------------------
//function inlcudeLayoutTemplet
//----------------------------
function inlcudeLayoutTemplet($templete=""){
  //include(SITE_ROOT.DS.'public'.DS.'layouts'.DS.$templete);
    include('../layouts'.DS.$templete);

}
//----------------------------
//function logAction
//----------------------------
function logAction($action, $message=""){
 $file ="../../logs/logfile.txt";
 //$file = SITE_ROOT.DS."/logs/logfile.txt";
 if($handle = fopen($file,'a')){
// appends records
         $dt = time();
        // my sql formate my sql understands
        $mysql_datetime = strftime("%Y-%m-%d %H:%M:%S",$dt);
        $content = $mysql_datetime;
        $content .= "  |  " ;
        $content .= $action;
        $content .= $message . "\n";
        fwrite($handle, $content);
        fclose($handle);
 }else{
        echo   "Could not open file for writing.";
  };
}

//----------------------------
//function datetime_to_text
//----------------------------
function datetime_to_text($datetime=""){
  $unixdatetime = strtotime($datetime);
  return strftime("%B %d %Y at %I:%M %p", $unixdatetime);
      
}