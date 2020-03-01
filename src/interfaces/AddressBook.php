<?php 
namespace book\interfaces;

/**
 * 
 * ADDRESS BOOK 
 * 
 * Small AddressBook application following Model-Viewer-Controller archetype
 * 
 * @author Cesar Delgado
 * @link http://brainit.cesar-delgado.info       
 */
use Monolog\Logger;
use Error;
use Exception;

class AddressBook extends ObjetoWeb 
{
      
    /*----------------------------------
     *      PRIVATE PROPERTIES
     *----------------------------------*/
     // 1.- Module Properties
     protected $modulo=__CLASS__;
    
     // 2.- Parameters Capture
     protected $url;
     protected $controllerName='Index';
     protected $controllerProperties=[];
     
     // 3.- Model-Viewer-Controller Object Referente
     protected $controller;
     
     /*----------------------------------
      *      PRIVATE METHODS
      *----------------------------------*/

     private function captureURL(){
         $log_header=$this->line_header . __METHOD__ ."()] - ";
         $success=false;
         try {
             $this->debug($log_header . "CAPTURE URL");
             $this->url=null;
             if (isset($_GET['url'])) {$success=true; $this->url=$_GET['url'];}
             
         } catch (Exception $e) {
             $this->treatException($e
                 , $log_header . "CAPTURE URL"
                 );
         } catch (Error $e) {
             $this->treatError($e
                 , $log_header . "CAPTURE URL"
                 );
         }
         return $success;
     }

     private function captureParametersURL(){
         $log_header=$this->line_header . __METHOD__ ."()] - ";
         $output=[];
         try {
             if (isset($_GET)) {
                 $this->debug($log_header . "CAPTURE PARAMETERS URL [".serialize($_GET)."]");
                 foreach ($_GET as $key => $value) {
                     if(strpos($key, 'url')===false) {
                        $output[$key] = $value;
                     }
                 }
             } 
             
         } catch (Exception $e) {
             $this->treatException($e
                 , $log_header . "CAPTURE PARAMETERS URL"
                 );
         } catch (Error $e) {
             $this->treatError($e
                 , $log_header . "CAPTURE PARAMETERS URL"
                 );
         }
         return $output;
     }
     
     /*
      *  Input Format: / field[ key=value ] / field[ key=value ] / ...
      *  If key provided in $keys, then value=field 
      *   
      */
     private function decomposeURL(string $field, array $keys=[]) {
         
         $log_header=$this->line_header . __METHOD__ ."()] - ";
         $output=[];
         try {
             
             $this->debug($log_header . "DECOMPOSE URL [" . serialize($field) . "]");

             // 1.- Prepare Field
             $field=rtrim($field, '/');
             $properties=explode('/', $field);
             if(empty($properties)) {$properties[0]=$field;}
             
             // 2.- Capture fields
             $nprop = sizeof($properties);
             $nkeys = sizeof($keys);
             $output= [];
             for($i = 0; $i < $nprop; $i++){
                 $key=''; $value='';
                 if($i < $nkeys) {
                     $key=$keys[$i];
                     $value=$properties[$i];
                     $output[$key]=$value;
                 } else {
                     $campo=explode('=', $properties[$i]);
                     if(empty($campo)) {$key=$campo;
                     } else {
                        $key=$campo[0];
                        if(sizeof($campo)>1) {$value=$campo[1];}
                        $output[$key]=$value;
                     }
                 }
             }
             
         } catch (Exception $e) {
             $this->treatException($e
                 , $log_header . "DECOMPOSE URL"
                 );
         } catch (Error $e) {
             $this->treatError($e
                 , $log_header . "DECOMPOSE URL"
                 );
         }
       
         // 2.- Return Properties
         //---------------------
         return $output;
     }
     
     /*
      *
      */ 
     private function treatURL() {
         $log_header=$this->line_header . __METHOD__ ."()] - ";
         try {
             $this->debug($log_header . "TREAT URL");
             
             // 1.- Treat URL
             if ($this->captureURL()) {
                 $properties=$this->decomposeURL($this->url,['controller','command']);
                 
                 // 2.- Treat Parameters
                 $parameters=$this->captureParametersURL();
                 $properties=array_merge($properties, $parameters);
                 
                 // 3.- Set object properties
                 if (!empty($properties)) {
                     if (!empty($properties['controller'])) {
                        $this->controllerName=ucwords($properties['controller']);
                     }
                     unset($properties['controller']);
                 }
                 $properties['book']=$this;
                 $this->controllerProperties=$properties;
             }
             
         } catch (Exception $e) {
             $this->treatException($e
                 , $log_header . "TREAT URL : [" . serialize($this->url) . "]"
                 );
         } catch (Error $e) {
             $this->treatError($e
                 , $log_header . "TREAT URL : [" . serialize($this->url) . "]"
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
      * Decompose URL, create controller and trace object properties
      * {@inheritDoc}
      * @see ObjetoWeb::init()
      */
     public function init(array $properties=[]) {
         $log_header=$this->line_header . __METHOD__ ."()] - ";
         try {

             // 0.- Log Entry
             $this->debug($log_header . "INITIATING ADDRESS BOOK url=[" . serialize($_GET) ."]");
             
             // 1.- Capture URL
             $this->treatURL();
            
             // 2.- Load Controller
             $this->debug($log_header . "......CONTROLLER NAME [" . $this->controllerName . "]");
             $this->controller=$this->createClass($this->controllerName,"/../controllers","book\\controllers","Index");
             
             // 4.- Initiate Controller
             if (!($this->controller===false)) {
                 $this->debug($log_header . "CONTROLLER PROPERTIES [" . serialize($this->controllerProperties) . "]");
                 $this->controller->setLog($this->log);
                 $this->controller->init($this->controllerProperties);
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
                $this->debug($log_header . "START class=[$class]");
           
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