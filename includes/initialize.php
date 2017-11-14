<?php
    // DIRECTORY SEPARATOR is a php pre-defined constant
    // (\ windows, / for Unix)
    defined ("DS") ? null : define ("DS", DIRECTORY_SEPARATOR );
    defined ("SITE_ROOT") ? null : define ("SITE_ROOT","breathe_clear" );
    defined ("LIB_PATH") ? null : define ("LIB_PATH", SITE_ROOT.DS."includes" );

    require_once("functions.php");
    require_once("config.php");
    // core objects
    require_once("session.php");
    require_once("database.php");
    require_once("database_object.php");
    require_once("pagination.php");
    // database related classs
    require_once("user.php");
    require_once("allergens.php");
    require_once("analysis.php");
    require_once("patient.php");
    require_once("custom_allergens.php");
    // config auto load
    //require_once("../../config/appConfig.php");
    require "../../vendor/autoload.php";
    require "../../config/appConfig.php";
    
    use DebugBar\StandardDebugBar;
    $debugbar = new StandardDebugBar();
    $debugbarRenderer = $debugbar->getJavascriptRenderer();
    $debugbar["messages"]->addMessage("hello world!");
    $debugbarRenderer->renderHead();

    $debugbarRenderer->render();
    

   // require_once(LIB_PATH.DS."config.php");
   // require_once(LIB_PATH.DS."functions.php");
    // core objects
  //  require_once(LIB_PATH.DS."session.php");
   // require_once(LIB_PATH.DS."database.php");
  //  require_once(LIB_PATH.DS."database_object.php");
  //  require_once(LIB_PATH.DS."pagination.php");

    // database related classs
  //  require_once(LIB_PATH.DS."user.php");
   // require_once(LIB_PATH.DS."allergens.php");
  //  require_once(LIB_PATH.DS."analysis.php");
 //   require_once(LIB_PATH.DS."patient.php");
?>