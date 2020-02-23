<?php 
use Monolog\Logger;
use Error;
use Exception;

/**
 *
 * @author cesar
 *        
 */
class BookModel extends Model
{

    /**
     *
     * @param Logger $log
     */
    public function __construct(Logger $log = null)
    {
        parent::__construct($log = null);
    }
    
    public function list() {
        $log_header=$this->line_header . __METHOD__ ."()] - ";
        try {
            echo "----- LISTING USERS ----- ";
        } catch (Exception $e) {
            $this->treatException($e
                , $log_header . "ERROR STARTING CONTROLLER"
                );
        } catch (Error $e) {
            $this->treatError($e
                , $log_header . "ERROR STARTING CONTROLLER"
                );
        }
    }
    
}

