<?php namespace book\controllers;

use book\interfaces\Controller;
use Monolog\Logger;
use Error;
use Exception;


/**
 * 
 * @author cesar
 *
 */
class Index extends Controller {

    /*
     * CALL DIFFERENT VIEWS
     */
    /**
     * 
     */
    public function welcome() {
        $log_header=$this->line_header . __METHOD__ ."()] - ";
        try {
            $vista="welcome";
            $this->debug($log_header . "SWITICHING VIEW [$vista]");
            $this->view->setName($vista);
        } catch (Exception $e) {
            $this->treatException($e
                , $log_header . "ERROR SWITCHING VIEW TO [$vista]"
                );
        } catch (Error $e) {
            $this->treatError($e
                , $log_header . "ERROR SWITCHING VIEW TO [$vista]"
                );
        }
    }
    
    /**
     * Constructor
     */
    public function __construct(Logger $log=null){parent::__construct($log);}
    
}