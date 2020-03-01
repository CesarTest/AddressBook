<?php 
namespace book\interfaces;

/**
 *
 * @author Cesar Delgado
 *        
 */
use Monolog\Logger;
use Error;
use Exception;

class Model extends ObjetoWeb
{
    
    //----------------------------
    //   PRIVATE PROPERTIES
    //----------------------------
    protected $connection;
    protected $controller;


    //----------------------------
    //      PUBLIC METHODS
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
            $this->debug($log_header . "INITIATING MODEL: [" . $this->clase . "]");
                        
            // 1.- Init Connection
            $object=$this->spawnObject(__NAMESPACE__.'\\DataBase');
            $properties['connection']=$object;

      
            // 2.- Set Object Properties
            parent::init($properties);
            
            // 3.- Init Connection
            $this->loadModule('config','/../config','config','config');
            $db_connection=[ 'model'   => $this
                        ,'host'     => constant('DB_HOST')
                        ,'db'       => constant('DB_NAME')
                        ,'user'     => constant('DB_USER')
                        ,'password' => constant('DB_PASSWORD')
                        ,'charset'  => constant('DB_CHARSET')
                        ];
            $this->connection->init($db_connection);                            
            
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
            $this->debug($log_header . "STARTING MODEL : [" . $this->clase . "]");
            $this->connection->start();
            
        } catch (Exception $e) {
            $this->eatException($e
                , $log_header . "EXCEPTION STARTING MODEL"
                );
        } catch (Error $e) {
            $this->treatError($e
                , $log_header . "ERROR STARTING MODEL"
                );
        }
    }

    //----------------------------
    //      GETTER / SETTER
    //----------------------------
    
    
    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }
    
    /**
     * @param mixed $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }
    
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
    
}