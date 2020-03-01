<?php namespace book\controllers;

use book\interfaces\Controller;
use Monolog\Logger;
use Error;
use Exception;

/**
 *
 * @author Cesar Delgado
 *        
 */
class Contact extends Controller
{
    
    //--------------------------------
    //       PRIVATE PROPERTIES
    //--------------------------------
    protected $xml;
    
    /**
     * @return string
     */
    public function getXml()
    {
        return $this->xml;
    }

    /**
     * @param string $xml
     */
    public function setXml($xml)
    {
        $this->xml = $xml;
    }

    //--------------------------------
    //       PUBLIC METHOD
    //--------------------------------
    public function start()
    {
        $log_header=$this->line_header . __METHOD__ ."()] - ";
        try {
  
            $this->debug($log_header . "START class=[$this->clase]");
            
            // 1.- Start Database Connection
            if(!empty($this->model)) {
                $model=$this->model;
                if (method_exists($model, 'start')) {$model->start();}
            }
            if(!empty($this->xml))   {$this->command="newAddress";}
            
            // 2.- Start View
            parent::start();
            
        } catch (Exception $e) {
            $this->treatException($e
                , $log_header . "START [$this->clase]"
                );
        } catch (Error $e) {
            $this->treatError($e
                , $log_header . "START [$this->clase]"
                );
        }
    }
    
    /**
     * 
     * @param Logger $log
     */
    public function __construct(Logger $log = null)
    {
        parent::__construct($log = null);
    }

    //--------------------------------
    //   PUBLIC METHOD FOR VIEWS
    //--------------------------------
    
    /**
     *  Validate Form Data and Insert User
     */
    public function newAddress()
    {
        $log_header=$this->line_header . __METHOD__ ."()] - ";
        $success=false;
        $xml="";
        try {
            if(!empty($this->xml)) { $xml=__DIR__."/../config/".$this->xml; }
            if(method_exists($this->view,"setFields")) {
                $this->debug( $log_header . "LAUNCH [$this->clase] COMMAND" );
                $address=$this->captureForm();
                $address=$this->captureXMLfile($xml, $address);
                $this->validateFields($address);
                $success=(empty($this->view->getErrorMessage()));
            }
            $this->view->setFields($address);           
            $this->view->setName("index");
            if($success)   {$success=$this->model->addContact($address);}
            if($success)   {$this->view->setName("Success");}
            
        } catch (Exception $e) {
            $this->treatException($e
                , $log_header . "LAUNCH [$this->clase] COMMAND"
                );
        } catch (Error $e) {
            $this->treatError($e
                , $log_header . "LAUNCH [$this->clase] COMMAND"
                );
        }
    }
}