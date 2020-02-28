<?php
use Monolog\Logger;


/**
 *
 * @author Cesar Delgado
 *        
 */
class ObjetoWeb
{

    /*----------------------------------
     *        PRIVATE PROPERTIES
     *----------------------------------*/
    
    /**
     *   Log
     */
    protected $log;
    protected $line_header;
    protected $clase="ObjetoWeb";
    
    /*----------------------------------
     *           PRIVATE METHODS
     *----------------------------------*/
    /**
     * 
     * @param string $class
     * @param array $properties
     * @return object
     */
    protected function spawnObject(string  $class="View") 
    {
        // 0.- Trace Entry
        //-----------------
        $log_header=$this->line_header . __METHOD__ ."()] - ";
        
        // 1.- Creating Object
        //-----------------
        $object=false;
        try {
            $this->log->addDebug($log_header . "SPAWN OBJECT class=[" . $class . "]");
            $object = new $class;
            if(!empty($this->log))  {$object->setLog($this->log);}
        } catch (Exception $e) {
            $this->treatException($e
                , $log_header . "FAIL SPAWING OBJECT"
                );
        } catch (Error $e) {
            $this->treatError($e
                , $log_header . "FAIL SPAWING OBJECT"
                );
        }
        
        // 2.- Return Object
        //-----------------
        return $object;
    }
    
    /**
     * 
     * @param string $class
     * @param string $path
     * @param string $default
     * @param string $error
     * @return string $class
     */
    protected function loadModule(string  $class="View"
                                  , string $path="/./controllers"
                                  , string $default="Index"
                                  , string $error="Errors") {
         
        // 0.- Trace Entry 
        //-----------------
        $log_header=$this->line_header . __METHOD__ ."()] - ";
        
        // 1.- Load Module
        //-----------------
        $out=false;
        try {

            // 1.0.- Trace Entry
            $this->log->addDebug($log_header . "LOADING MODULE class=[" . $path . "/" . $class . "]");
            
            // 1.1.- Module File Detection
            $modulePath=__DIR__ . $path;
            $ext="php";
            $moduleFile =$modulePath . '/' .  $class . '.' . $ext;
            
            if(!file_exists($moduleFile)) {$class=$default;}
            $moduleFile =$modulePath . '/' .  $class . '.' . $ext;
            
            if(!file_exists($moduleFile)) {$class=$error;}
            $moduleFile =$modulePath . '/' .  $class . '.' . $ext;
            
            // 1.2.- Loading Class
            if(file_exists($moduleFile)) {
                $this->log->addDebug($log_header . "LOADING CLASS MODULE: [$moduleFile]");
                require $moduleFile;
                $out=$class;
            } else {
                $this->log->addError($log_header . "CLASS MODULE NOT FOUND : [$moduleFile]");
            }
            
        } catch (Exception $e) {
            $this->treatException($e
                , $log_header . "LOADING MODULE"
                 );
            
        } catch (Error $e) {
            $this->treatError($e
                , $log_header . "LOADING MODULE"
                );
        }
        
        // 2.- Return result
        //-----------------
        return $out;
    }

    protected function createClass(string  $module="View"
                                 , string  $path="" 
                                 , string  $default="none"
                                 , string  $error="none"
                                )
    {
        $log_header=$this->line_header . __METHOD__ ."()] - ";
        
        // 1.- Creating Object
        //-----------------
        $object=false;
        try {

            // 1.0.- Trace Entry
            $this->log->addDebug($log_header . "CREATE CLASS module=[" . $module . "]");
            
            // 1.1.- Spawn Object
            $class=$this->loadModule($module,$path,$default,$error);
            if(!($class===false)) {$object=$this->spawnObject($class);}
            
            // 1.2.- Set Property
            if (!($object===false)) {
                $property=strtolower($module);
                if(property_exists($this, $property)){$this->{$property}=$object;}
            }
        } catch (Exception $e) {
            $this->treatException($e
                , $log_header . "FAIL CREATING CLASS [$type]"
                );
        } catch (Error $e) {
            $this->treatError($e
                , $log_header . "FAIL CREATING CLASS [$type]"
                );
        }
        
        // 2.- Return the object
        //-------------------
        return $object;
    }
      
    /**
     *
     * @param string $json
     */
    protected function setProperties(array $input=null){
        
        $log_header=$this->line_header . __METHOD__ ."()] - ";
        try {
            if (!is_null($input)) {
                $this->log->addDebug($log_header . "SETTING OBJECT PROPERTIES - [" . serialize($input) . "]");
                if (!empty($input)) {
                    foreach($input as $key=>$value){
                        if (property_exists($this, $key)) {$this->$key = $value;}
                    }
                }
            }
        } catch (Exception $e) {
            $this->treatException($e
                , $log_header . "EXCEPTION CAPTURING OBJECT PROPERTIES"
                );
        } catch (Error $e) {
            $this->treatError($e
                , $log_header . "ERROR SETTING OBJECT PROPERTIES"
                );
        }
    }
    
    /**
     * 
     * @param string $modulo
     * @param string $method
     * @param string $lib
     */
    protected function printProperties() 
    {
        $log_header=$this->line_header . __METHOD__ ."()] - ";
        try {
            $this->log->addDebug($log_header . "DUMPING OBJECT PROPERTIES class=[$this->clase]");
            $r=new \ReflectionClass($this);
            $properties=$r->getProperties();
            foreach ($properties as $property ) {
                $name=$property->name;
                $type=$property->class;
                $this->log->addDebug($log_header . ".......$name=[" . serialize($this->{$name}) . "]");
            }
        } catch (Exception $e) {
            $this->treatException($e
                , $log_header . "EXCEPTION SETTING LOGGER"
                );
        } catch (Error $e) {
            $this->treatError($e
                , $log_header . "ERROR SETTING LOGGER"
                );
        }
    }
   
    /**
     * 
     * @param string $data
     * @return string
     */
    protected function test_input($data) {
        
        
        // 1.- Trim Input 
        $log_header=$this->line_header . __METHOD__ ."()] - ";
        try {
            $this->log->addDebug($log_header . "....data=[$data]");
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            
        } catch (Exception $e) {
            $this->treatException($e
                , $log_header . "EXCEPTION TEST INPUT"
                );
        } catch (Error $e) {
            $this->treatError($e
                , $log_header . "ERROR TEST INPUT"
                );
        }
        
        // 2.- Return
        return $data;
    }
    
    /**
     * 
     * @param \Error $error
     * @param string $msg
     */
    protected function treatError(\Error $error, $msg="[interfaces.ObjetoWeb.treatError()] - ERROR") 
      {
          $log_header=$this->line_header . __METHOD__ ."()] - ";
          try {
              error_log($msg);
              if(!empty($this->log)) {
                  $this->log->addError($msg);
                  $this->log->addError($error->getMessage());
                  $this->log->addError($error->getTraceAsString());
              }
          } catch (Exception $e) {
              error_log($log_header ."- EXCEPTION TREATING ERROR{$e->getMessage()}");
              $e->getMessage();
              $e->getTraceAsString();
              
          } catch (Error $e) {
              error_log($log_header . "ERROR TREATING ERROR{$e->getMessage()}");
              $e->getMessage();
              $e->getTraceAsString();
          }
      }
      
      /**
       * 
       * @param \Exception $exception
       * @param string $msg
       */
      protected function treatException(\Exception $exception, $msg="[interfaces.ObjetoWeb.treatException()] - EXCEPTION") {
          try {
              $log_header=$this->line_header . __METHOD__ ."()] - ";
              error_log($log_header . $msg);
              if(!empty($this->log)) {
                  $this->log->addError($log_header . $msg);
                  $this->log->addError($exception->getMessage());
                  $this->log->addError($exception->getTraceAsString());
              }
          } catch (Exception $e) {
              error_log($log_header . "EXCEPTION SETTING LOGGER{$e->getMessage()}");
              $e->getMessage();
              $e->getTraceAsString();
              
          } catch (Error $e) {
              error_log($log_header . "ERROR SETTING LOGGER{$e->getMessage()}");
              $e->getMessage();
              $e->getTraceAsString();
              
          }
      }

      /**
       *
       * @param \Exception $exception
       * @param string $msg
       */
      protected function debug(String $msg, array $context=[]) 
      {
          if (!empty($msg)) {$this->log->addDebug($msg, $context);}
      }
      
      protected function info(String $msg, array $context=[])
      {
          if (!empty($msg)) {$this->log->addInfo($msg, $context);}
      }
      
      protected function warn(String $msg, array $context=[])
      {
          if (!empty($msg)) {$this->log->addWarning($msg, $context);}
      }
      
      protected function error(String $msg, array $context=[])
      {
          if (!empty($msg)) {$this->log->addError($msg, $context);}
      }
      
      
      
    /*----------------------------------
     *           SETTER / GETTERs
     *----------------------------------*/
    /**
     * 
     * @param Logger $logger
     */
    public function setLog(Logger $logger) {      
        $log_header=$this->line_header . __METHOD__ ."()] - ";
        try {
            $this->log=$logger;
        } catch (Exception $e) {
            $this->treatException($e
                , $log_header . "EXCEPTION SETTING LOGGER"
                );
        } catch (Error $e) {
            $this->treatError($e
                , $log_header . "ERROR SETTING LOGGER"
                );
        }
    }
    
    /**
     * 
     * @return \Monolog\Logger
     */
    public function getLog() {
        $log_header=$this->line_header . __METHOD__ ."()] - ";
        try {
            return $this->log;
        } catch (Exception $e) {
            $this->treatException($e
                , $log_header . "EXCEPTION GETTING LOGGER"
                );   
        } catch (Error $e) {
            $this->treatError($e
                , $log_header . "ERROR GETTING LOGGER"
                );
        }
    }
    
    /**
     *
     * @return \Monolog\Logger
     */
    public function getClase() {
        $log_header=$this->line_header . __METHOD__ ."()] - ";
        try {
            return $this->clase;
        } catch (Exception $e) {
            $this->treatException($e
                , $log_header . "EXCEPTION GETTING CLASE"
                );
        } catch (Error $e) {
            $this->treatError($e
                , $log_header . "ERROR GETTING CLASE"
                );
        }
    }
    
    
    /*----------------------------------
     *           CONSTRUCTOR
     *----------------------------------*/
    /**
     * 
     * @param Logger $log
     */
    public function __construct(Logger $log=null){
        $log_header=$this->line_header . __METHOD__ ."()] - ";
        try {
            // 1.- Module Properties as Log Header
            $this->clase=get_class($this);
            $this->line_header="[" . __NAMESPACE__ . $this->clase . "->" ;
            
            // 2.- Set Logger
            if(empty($this->log)) {$this->setLog(new Logger($this->clase));}
            if($log!=null)        {$this->setLog($log);}
            
        } catch (Exception $e) {
            error_log($log_header . "EXCEPTION SETTING LOGGER{$e->getMessage()}");
            $e->getMessage();
            $e->getTraceAsString();
            
        } catch (Error $e) {
            error_log($log_header . "ERROR SETTING LOGGER{$e->getMessage()}");
            $e->getMessage();
            $e->getTraceAsString();
            
        }
    }
    
    /*----------------------------------
     *           PUBLIC METHODS
     *----------------------------------*/
    /**
     * 
     * @param array $input
     */
    public function init(array $input=null) {
 
        $log_header=$this->line_header . __METHOD__ ."()] - ";
        try {

            // 0.- Trace Entry
            $this->debug($log_header . "INITIATING.... [" . $this->clase . "]");
            
            // 1.- Set Object Properties
            $this->setProperties($input);
            
            // 2.- Dump Object Properties
            $this->printProperties();
            
        } catch (Exception $e) { 
            $this->treatException($e
                , $log_header . "ERROR INITIATING WEB OBJECT {$e->getMessage()}"
                    );
        } catch (Error $e) {
            $this->treatError($e
                , $log_header . "ERROR INITIATING WEB OBJECT {$e->getMessage()}"
                );
        }
    }
    
    /**
     * 
     */
    public function start() {
        $log_header=$this->line_header . __METHOD__ ."()] - ";
        try {
            $this->debug($log_header . "STARTING..... [" . $this->clase . "]");
        } catch (Exception $e) {
            $this->treatException($e
                , $log_header . "ERROR STARTING WEB OBJECT {$e->getMessage()}"
                );
        } catch (Error $e) {
            $this->treatError($e
                , $log_header . "ERROR STARTING WEB OBJECT {$e->getMessage()}"
                );
        }
    }
}