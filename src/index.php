<?php

if (!isset($app)) {
    
        /*----------------------------------
         *      GLOBAL STATIC PROPERTIES
         *----------------------------------*/
        $libs=__DIR__ . "/interfaces";
        $line_header="[cesar.addressbook.index.php->";
        $log_header=$line_header . "main]";
            
        /*----------------------------------
         *         LIBRARIES
         *----------------------------------*/
        // 1.- Load Libraries
        $access = date("Y/m/d H:i:s");
        error_log($log_header . "STARTING APPLICATION... [$access]"); 
        try {
            
             // Configuration File
             $libs=__DIR__ . "/config";
             require $libs . "/config.php";
            
             // Composer Libraries (dependencies)
             $libs=__DIR__ . "/../vendor";
             require_once $libs . "/autoload.php";
             
             // Parent Classes
             $libs=__DIR__ . "/interfaces";
             require $libs . "/ObjetoWeb.php";
             require $libs . "/AddressBook.php";
             require $libs . "/Controller.php";
             require $libs . "/View.php";
             require $libs . "/Model.php";
             require $libs . "/DataBase.php";
    
        } catch (Exception $e) {
            error_log($log_header . "ERROR LOADING MODULES  $e->getMessage()");
            echo($log_header . "ERROR LOADING MODULES:  $e->getMessage()" );
        }
    
        /*----------------------------------
         *              MAIN
         *----------------------------------*/
        
        // 1.- Start Logging System
        $log=ObjetoWeb::initLoggingSystem("[cesar.addressbook]");
        $out = print_r($log, true);
        $log->addDebug($log_header . "....... log=[$out]");
        
        // 2.- Launch Application
        try {
                $app=new AddressBook();
                $app->setLog($log);
                $app->init();
                $app->start();
        } catch (Error $e) {
            error_log($log_header . "APPLICATION FAIL TO START");
            error_log($e->getMessage());
            $log->addError($log_header . "APPLICATION FAIL TO START");
            $log->addError($e->getMessage());
            $log->addError($e->getTraceAsString());
        }
}
?>