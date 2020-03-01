<?php namespace book\interfaces;

/**
 *
 * @author cesar
 *        
 */
use Monolog\Logger;
use Error;
use Exception;


class View extends ObjetoWeb
{
    
    /*----------------------------------
     * PROPERTIES
     *----------------------------------*/
     
     // 1.- View References
     protected $controller;
 
     // 2.- View Properties
     protected $vista="index"; // Name of current view
     protected $message;
     protected $errorMessage;
     
    /**
     * @return mixed
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * @param mixed $errorMessage
     */
    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * 
     * @param Logger $log
     */
     public function __construct(Logger $log=null){parent::__construct($log);}
    
    /*----------------------------------
     * PUBLIC METHODS
     *----------------------------------*/
     /**
      *
      * {@inheritDoc}
      * @see ObjetoWeb::start()
      */
     public function callController($method, $parameters) {
         
         $log_header=$this->line_header . __METHOD__ ."()] - ";
         try {
             $this->controller->{$method}($parameters);
         } catch (Exception $e) {
             $this->treatException($e
                 , $log_header . "CALLING CONTROLLER "
                 );
             
         } catch (Error $e) {
             $this->treatError($e
                 , $log_header . "ERROR STARTING VIEW ]"
                 );
         }
     }
     
     
     /**
      * 
      */
     public function refresh(string $url="") {
         
         $log_header=$this->line_header . __METHOD__ ."()] - ";
         try {
             if(empty($url)) {$url = $_SERVER['PHP_SELF'];}
             header($url);
             
         } catch (Exception $e) {
             $this->treatException($e
                 , $log_header . "ERROR REFRESHING VIEW ]"
                 );
             
         } catch (Error $e) {
             $this->treatError($e
                 , $log_header . "ERROR REFRESING VIEW ]"
                 );
         }
     }
     
    /**
     * 
     * {@inheritDoc}
     * @see ObjetoWeb::start()
     */
    public function start() {
        
        $log_header=$this->line_header . __METHOD__ ."()] - ";
        try {
           
            // 1.- Default Values
            $ruta=__DIR__ . "/../views";
            $controlador="index";
            $vista="index";
            $ext="php";
            if (!empty($this->controller))  {$controlador=strtolower($this->controller->getClase());}
            if (!empty($this->vista))       {$vista=strtolower($this->vista);}
            
            // 2.- Construct View URL
            $this->debug($log_header . "STARTING VIEW [$controlador / $vista]");
            $fileVista=$ruta . "/" . $controlador . "/" . $vista . "." . $ext;
            if (!file_exists($fileVista)) {$fileVista=$ruta . "/" . $controlador . "/index." . $ext;}
            if (!file_exists($fileVista)) {$fileVista=$ruta . "/index/" . $vista . "." . $ext;}
            if (!file_exists($fileVista)) {$fileVista=$ruta . "/index/index.php";}
            
            // 3.- Load View (DHTML)
            $this->debug($log_header . "LAUNCHING VIEW [$fileVista]");
            $this->debug($log_header . ".... errorMessage [".$this->errorMessage."]");
            
            if (file_exists($fileVista)) { 
                require $fileVista; 
            } else {
                $this->debug($log_header . "VIEW NOT FOUND[$fileVista]");
            }
        } catch (Exception $e) {
            $this->treatException($e
                , $log_header . "ERROR STARTING VIEW ]"
                );
            
        } catch (Error $e) {
            $this->treatError($e
                , $log_header . "ERROR STARTING VIEW ]"
                );
        }
    }

    /*----------------------------------
     * GETTER / SETTER
     *----------------------------------*/
    /**
     * 
     * @param Controller $cont
     */
    public function setController(Controller $cont) {
        $log_header=$this->line_header . __METHOD__ ."()] - ";
        try {
            $this->controller=$cont;
        } catch (Exception $e) {
            $this->treatException($e
                , $log_header . "ERROR SETTING CONTROLLER ]"
                );
            
        } catch (Error $e) {
            $this->treatError($e
                , $log_header . "ERROR SETTING CONTROLLER ]"
                );
            
        }
    }
    
    /**
     * 
     * @return Controller
     */
    public function getController() {
        $log_header=$this->line_header . __METHOD__ ."()] - ";
        try {
            return $this->controller;
        } catch (Exception $e) {
            $this->treatException($e
                , $log_header . "ERROR GETTING CONTROLLER ]"
                );
            
        } catch (Error $e) {
            $this->treatError($e
                , $log_header . "ERROR GETTING CONTROLLER ]"
                );
        }
    }
    
    /**
     *
     * @param String $nombre
     */
    public function setName($nombre) {
        $log_header=$this->line_header . __METHOD__ ."()] - ";
        try {
            $this->vista=$nombre;
        } catch (Exception $e) {
            $this->treatException($e
                , $log_header . "ERROR SETTING NAME ]"
                );
            
        } catch (Error $e) {
            $this->treatError($e
                , $log_header . "ERROR SETTING NAME ]"
                );
        }
    }
    
    /**
     *
     * @return string|array
     */
    public function getName() {
        $log_header=$this->line_header . __METHOD__ ."()] - ";
        try {
            return $this->vista;
        } catch (Exception $e) {
            $this->treatException($e
                , $log_header . "ERROR GETTING NAME ]"
                );
            
        } catch (Error $e) {
            $this->treatError($e
                , $log_header . "ERROR GETTING NAME ]"
                );
            
        }
    } 
}