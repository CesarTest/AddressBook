<?php
use Monolog\Logger;

/**
 *
 * @author Cesar Delgado
 *        
 */
class DataBase extends ObjetoWeb
{
 
    /*----------------------------------
     *        PRIVATE PROPERTIES
     *----------------------------------*/
    // 1.- References
    protected $model;
    protected $pool;
    
    // 2.- Properties
    protected $host;
    protected $db;
    protected $user;
    protected $password;    
    protected $charset;

    //----------------------------------------------
    // PRIVATE METHOD
    //----------------------------------------------
    private function startConnection() {

        $log_header=$this->line_header . __METHOD__ ."()] - ";
        $success=false;
        try {
            
            // 1.- Connection String
            $connection = "mysql:host=" . $this->host . ";dbname=" . $this->db . ";charset=" . $this->charset;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            
            // 2.- Start Connection
            $this->debug($log_header . "CONNECTING TO DATABASE [$connection]");
            $pdo = new PDO($connection, $this->user, $this->password, $options);
            $this->setPool($pdo);
            $success=true;
            
        } catch (PDOException $e) {
            $this->treatException($e
                , $log_header . "EXCEPTION STARTING CONNECTION"
                );
            if(!empty($this->model)) {$controller=$this->model->getController();}
            if(!empty($controller)) {
                $controller->phpErrors('database',$e->getMessage());
            }
            
        } catch (Error $e) {
            $this->treatError($e
                , $log_header . "ERROR STARTING CONNECTION"
                );
            if(!empty($this->model)) {$controller=$this->model->getController();}
            if(!empty($controller))  {
                $controller->phpErrors('database',$e->getMessage());
            }
        }
 
        return $success;
    }
    
    
    //----------------------------------------------
    // PUBLIC METHOD
    //----------------------------------------------
    
    /**
     */
    public function __construct(Logger $log = null)
    {
        parent::__construct($log);
    }
    
    /**
     *
     * {@inheritDoc}
     * @see Controller::start()
     */
    public function start(){
        
        $log_header=$this->line_header . __METHOD__ ."()] - ";
        try {

            $this->debug($log_header . "STARTING..... [" . $this->clase . "]");
            $this->startConnection();
            
        } catch (Exception $e) {
            $this->treatException($e
                , $log_header . "EXCEPTION INITIATING DATABASE"
                );
            
        } catch (Error $e) {
            $this->treatError($e
                , $log_header . "ERROR INITIATING DATABASE"
                );
        }
    }
    
    //----------------------------------------------
    // GETTER / SETTER
    //----------------------------------------------
    
    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return mixed
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return mixed
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * @param mixed $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * @param mixed $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @param mixed $db
     */
    public function setDb($db)
    {
        $this->db = $db;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param mixed $charset
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;
    }

    
    /**
     * 
     * @param PDO $pool
     */
    public function setPool(PDO $pool) {
        $log_header=$this->line_header . __METHOD__ ."()] - ";
        try {
            $this->pool=$pool;
        } catch (Exception $e) {
            $this->treatException($e
                , $log_header . "EXCEPTION SETTING POOL"
                );
        } catch (Error $e) {
            $this->treatError($e
                , $log_header . "ERROR SETTING POOL"
                );
        }
    }
    
    /**
     * 
     * @return PDO
     */
    public function getPool() {
        $log_header=$this->line_header . __METHOD__ ."()] - ";
        try {
            return $this->pool;
        } catch (Exception $e) {
            $this->treatException($e
                , $log_header . "EXCEPTION GETTING POOL"
                );
        } catch (Error $e) {
            $this->treatError($e
                , $log_header . "ERROR GETTING POOL"
                );
        }
    }
}