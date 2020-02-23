<?php

/**
 *
 * @author Cesar Delgado
 *        
 */
use Monolog\Logger;

class Model extends ObjetoWeb
{
    
    //----------------------------
    //   PRIVATE PROPERTIES
    //----------------------------
    private $connection;

    /**
     * @return DataBase
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param DataBase $connection
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }

    //----------------------------
    //   PUBLIC CONTACT
    //----------------------------
    /**
     * 
     * @param Logger $log
     */
    public function __construct(Logger $log=null){parent::__construct($log);}
    
    /**
     *
     * {@inheritDoc}
     * @see Controller::init()
     */
    public function init(array $properties=[]){
        $log_header=$this->line_header . __METHOD__ ."()] - ";
        try {
            
            // 0.- Trace Entry
            $this->log->addDebug($log_header . "INITIATING MODEL: [" . $this->clase . "]");
                        
            // 1.- Set Object Properties
            //parent::init($properties);
            
            // 2.- Start Connection
            $this->connection=new DataBase();
            $this->connection->setLog($this->log);

            // 3.- Init Connection
            $this->connection->init($properties);                            
            //$this->connection->start();
            
        } catch (Exception $e) {
            $this->treatException($e
                , $log_header . "EXCEPTION INITIATING MODEL [" . $this->clase . "]"
                );
        } catch (Error $e) {
            $this->treatError($e
                , $log_header . "ERROR INITIATING MODEL [" . $this->clase . "]"
                );
        }
    }

    /**
     *
     * {@inheritDoc}
     * @see Controller::start()
     */
    public function start(){
        $log_header=$this->line_header . __METHOD__ ."()] - ";
        try {
            
            // 0.- Trace Entry
            $this->log->addDebug($log_header . "STARTING MODEL : [" . $this->clase . "]");
            
            // 1.- Set Object Properties
            $this->connection.start();
            
        } catch (Exception $e) {
            $this->treatException($e
                , $log_header . "EXCEPTION STARTING MODEL"
                );
        } catch (Error $e) {
            $this->treatError($e
                , $log_header . "ERROR STARTING MODEL"
                );
        }
    }
}