<?php

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

    // Use Libraries
    use Monolog\Logger;
    
     
    /*----------------------------------
     *      STATIC FUNCTIONS
     *----------------------------------*/
         
     /**
      * Transform Permissions to String
      */
     function printPermission(int $permisos) {
         
         $log_header=$line_header . __METHOD__ ."()] - ";
         $info="";
         try {
             
             // Tipo 
             switch ($permisos & 0xF000) {
                 case 0xC000: // Socket
                     $info = 's';
                     break;
                 case 0xA000: // Enlace simbólico
                     $info = 'l';
                     break;
                 case 0x8000: // Normal
                     $info = 'r';
                     break;
                 case 0x6000: // Bloque especial
                     $info = 'b';
                     break;
                 case 0x4000: // Directorio
                     $info = 'd';
                     break;
                 case 0x2000: // Carácter especial
                     $info = 'c';
                     break;
                 case 0x1000: // Tubería FIFO pipe
                     $info = 'p';
                     break;
                 default: // Desconocido
                     $info = 'u';
             }
             
             // Propietario
             $info .= (($permisos & 0x0100) ? 'r' : '-');
             $info .= (($permisos & 0x0080) ? 'w' : '-');
             $info .= (($permisos & 0x0040) ?
                 (($permisos & 0x0800) ? 's' : 'x' ) :
                 (($permisos & 0x0800) ? 'S' : '-'));
             
             // Grupo
             $info .= (($permisos & 0x0020) ? 'r' : '-');
             $info .= (($permisos & 0x0010) ? 'w' : '-');
             $info .= (($permisos & 0x0008) ?
                 (($permisos & 0x0400) ? 's' : 'x' ) :
                 (($permisos & 0x0400) ? 'S' : '-'));
             
             // Mundo
             $info .= (($permisos & 0x0004) ? 'r' : '-');
             $info .= (($permisos & 0x0002) ? 'w' : '-');
             $info .= (($permisos & 0x0001) ?
                 (($permisos & 0x0200) ? 't' : 'x' ) :
                 (($permisos & 0x0200) ? 'T' : '-'));
             
         } catch (Exception $e) {
             error_log($log_header . "ERROR TRANSFORMING PERMISSIONS: $e->getMessage()" );
         }          
         error_log($log_header . "RESULT: [$info]" );
         return $info;
     }
         
    /**
     * Initiate logging system according to input parameters
     */
    function initLoggingSystem() {

        $log_header=$line_header . __METHOD__ ."()] - ";
        error_log($log_header . "INITIATING LOGGING SYSTEM:");
        
        try {

            /*
             *      LOCAL ENVIRONMENT
             *----------------------------------*/
            // 1.- Set Parameters
            $logs = __DIR__ . "/../logs";
            $logfile=$logs . "/addressbook.log";
            $permission=fileperms($logs);     
            $permission_str=printPermission($permission);
            
            // 2.- Trace Parameters
            error_log($log_header . ".................Log File: [$logfile]");
            error_log($log_header . "...............Log Folder: [$logs]");
            error_log($log_header . "........Folder pemissions: [$permission_str]");
            
            /*
             *            ACTIONS
             *----------------------------------*/
            $log = new Logger("[cesar.addressbook]");
            if ( ($permission & 0x0080) | ($permission & 0x0002)) {
                $log->pushHandler(new Monolog\Handler\StreamHandler($logfile, Monolog\Logger::DEBUG));
                $log->addDebug($log_header . "LOGGING SYSTEM CORRECTLY INITIATED");                
            } else {
                error_log($log_header . "NO WRITE PERMISSIONES TO FOLDER - logs=[$logs]" );
            }
            
        } catch (Error $e) {
            error_log($log_header . "LOGGING SYSTEM INITIATION FAILED:" . $e->getMessage());
            error_log($e->getTraceAsString());
        }
        return $log;
    }

    /*----------------------------------
     *              MAIN
     *----------------------------------*/
 
    // 1.- Start Logging System
    $log=initLoggingSystem();
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
?>