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
     *------------;----------------------*/
    // 1.- Reference to Pool of Connection
    protected $pool;
    
    // 2.- Properties
    protected $host;
    protected $db;
    protected $user;
    protected $password;    
    protected $charset;
    
    
    /**
     */
    public function __construct(Logger $log = null)
    {
        parent::__construct($log = null);
        $this->host=constant('HOST');
        $this->db=constant('DB');
        $this->user=constant('USER');
        $this->password=constant('PASSWORD');
        $this->charset=constant('CHARSET');
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
            $this->log->addDebug($log_header . "CONNECTING TO DATABASE");
            
            // 1.- Create pool of Connections
            $connection = "mysql:host=" . $this->host . ";dbname=" . $this->db . ";charset=" . $this->charset;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $pdo = new PDO($connection, $this->user, $this->password, $options);
            
            // 2.- Assign Pool
            $this->setPool($pdo);
            
        } catch (PDOException $e) {
            $this->treatException($e
                , $log_header . "EXCEPTION INITIATING DATABASE"
                );
        } catch (Error $e) {
            $this->treatError($e
                , $log_header . "ERROR INITIATING DATABASE"
                );
        }
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