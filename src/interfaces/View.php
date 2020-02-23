<?php

/**
 *
 * @author cesar
 *        
 */
use Monolog\Logger;

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
            $this->log->addDebug($log_header . "STARTING VIEW [$controlador / $vista]");
            $fileVista=$ruta . "/" . $controlador . "/" . $vista . "." . $ext;
            if (!file_exists($fileVista)) {$fileVista=$ruta . "/" . $controlador . "/index." . $ext;}
            if (!file_exists($fileVista)) {$fileVista=$ruta . "/index/" . $vista . "." . $ext;}
            if (!file_exists($fileVista)) {$fileVista=$ruta . "/index/index.php";}
            
            // 3.- Load View (DHTML)
            $this->log->addDebug($log_header . "LAUNCHING VIEW [$fileVista]");
            if (file_exists($fileVista)) { 
                require $fileVista; 
            } else {
                $this->log->addDebug($log_header . "VIEW NOT FOUND[$fileVista]");
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