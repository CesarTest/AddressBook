<?php

/**
 * 
 * ADDRESS BOOK 
 * 
 * Small AddressBook application following Model-Viewer-Controller archetype
 * 
 * @author Cesar Delgado
 * @link http://Ocesar-delgado.info       
 */
use Monolog\Logger;

class AddressBook extends ObjetoWeb 
{
      
    /*----------------------------------
     *      PRIVATE PROPERTIES
     *----------------------------------*/
     // 1.- Module Properties
     protected $modulo=__CLASS__;
    
     // 2.- Parameters Capture
     protected $url;
     protected $controllerModule='Index';
     protected $controllerCommand;
     protected $controllerParameters;
     
     // 3.- Model-Viewer-Controller Object Referente
     protected $controller;
     
     /*----------------------------------
      *      PRIVATE METHODS
      *----------------------------------*/
     
     /*
      *
      */
     private function treatURL() {
         $log_header=$this->line_header . __METHOD__ ."()] - ";
         try {

             // 1.- Prepare URL
             $this->url=rtrim($this->url, '/');
             $this->url=explode('/', $this->url);
             
             // 2.- Decompose URL
             $properties=array("controllerModule", "controllerCommand", "controllerParameters" );
             $nparam = sizeof($this->url);
             for ($i=0; $i<3; $i++) {
                 $name=$properties[$i];
                 if (!empty($this->url[$i])) {
                     
                     if ($i<2) { $value=$this->url[$i];}
                     else      {
                         $value = [];
                         for($p = $i; $p < $nparam; $p++){
                             array_push($value, $this->url[$p]);
                         }
                         //$value=$this->url.array_slice($i+1, $nparam); 
                     }
                     $this->log->addDebug($log_header . ".....". $name . "= [" . serialize($value) . "]"); 
                     $this->{$name}=$value;
                 }
             }
             
             // 3.- Normalize naming
             $this->controllerModule=ucfirst($this->controllerModule);
             
             
         } catch (Exception $e) {
             $this->treatException($e
                 , $log_header . "URL DECOMPOSITION FAIL : [" . serialize($this->url) . "]"
                 );
         } catch (Error $e) {
             $this->treatError($e
                 , $log_header . "URL DECOMPOSITION FAIL : [" . serialize($this->url) . "]"
                 );
         }
     }

     /*----------------------------------
      *      PUBLIC METHODS
      *----------------------------------*/
     /**
      *
      * @param Logger $log
      */
     public function __construct(Logger $log=null){parent::__construct($log);}
     
     /**
      *  Decompose URL, create controller and trace object properties
      */
     public function init() {
         $log_header=$this->line_header . __METHOD__ ."()] - ";
         try {

             // 0.- Log Entry
             $this->log->addDebug($log_header . "CAPTURING PARAMETERS");
             
             // 1.- Capture URL
             $this->url=isset($_GET['url'])? $_GET['url']: null;
             $this->treatURL();
             
             // 2.- Load Controller
             $class=$this->loadModule($this->controllerModule,"/../controllers", "none");
             
             // 3.- Spawn Controller
             if (!empty($class)) {
                 $controller=$this->spawnObject($class);
                 $this->controllerModule=$class;
                 $this->controller=$controller;
             }
             
             // 4.- Initiate Controller
             if (!empty($this->controller)) {
                 $properties = ['command'   =>$this->controllerCommand
                              , 'parameters'=>$this->controllerParameters];
                 $this->controller->init($properties);
             }
             
             // 4.- Dump Object Propeties
             $this->printProperties();
             
         } catch (Exception $e) {
             $this->treatException($e 
                 , $log_header . "ADDRESS BOOK FAIL TO INITIATE"
                 );
         } catch (Error $e) {
             $this->treatError($e
                 , $log_header . "ADDRESS BOOK FAIL TO INITIATE"
                 );
         }
     }

    /**
     *  Launch Controller {Index|URL[0]}
     */
    public function start() {
        $log_header=$this->line_header . __METHOD__ ."()] - ";
        try {
            if (!empty($this->controller)) {
                
                // 1.- Trace Entry
                $class=get_class($this->controller);
                $this->log->addDebug($log_header . "START CONTROLLERS class=[$class]");
           
                // 2.- Start Controller
                $this->controller->start();
            } else {
                $this->log->addError($log_header . "NON EXISTING CONTROLLER : [" . serialize($this->controller) . "] ");
            }
           
        } catch (Exception $e) { 
            $this->treatException($e
                , $log_header . "ADDRESS BOOK FAIL TO START"
                );
        } catch (Error $e) {
            $this->treatError($e
                , $log_header . "ADDRESS BOOK FAIL TO START"
                );
        }
    }
}