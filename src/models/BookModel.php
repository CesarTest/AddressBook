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
    
    //--------------------------------
    //       PUBLIC METHOD
    //--------------------------------
    
    /**
     *
     * @param Logger $log
     */
    public function __construct(Logger $log = null)
    {
        parent::__construct($log = null);
    }
    
    public function list() {
        echo "MODEL - LISTING USERS";
        $log_header=$this->line_header . __METHOD__ ."()] - ";
        $contact=[[]];
        try {
            $this->debug($log_header . "LISTING CONTACTS");

            $contact=[[ 'Name' => 'Cesar'
                ,'Surname'  => 'Delgado'
                ,'Address'   => 'Cerrillo, 1'
                ,'eMail'     => 'cesar@gmail.com'
                ,'Phone'     => '694-456-774'
            ]];
            
        } catch (Exception $e) {
            $this->treatException($e
                , $log_header . "ERROR LISTING USERS"
                );
        } catch (Error $e) {
            $this->treatError($e
                , $log_header . "ERROR LISTING USERS"
                );
        }
        
        return $contact;
        
    }
    
}

