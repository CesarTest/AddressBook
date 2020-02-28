<?php
use Monolog\Logger;

/**
 *
 * @author cesar
 *        
 */
class Book extends Controller
{
    
    //--------------------------------
    //       PUBLIC METHOD
    //--------------------------------
    public function start()
    {
        $log_header=$this->line_header . __METHOD__ ."()] - ";
        try {
  
            
            $this->debug($log_header . "STARTING BOOK.... [$this->clase]");
            
            // 1.- Start Database Connection
            if(!empty($this->model)) {
                $model=$this->model;
                if (method_exists($model, 'start')) {$model->start();}
            }
            
            // 2.- List Users
            $this->command="list";
            
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
     */
    public function __construct(Logger $log = null)
    {
        parent::__construct($log = null);
    }
   
    
    /**
     */
    public function list()
    {
        $log_header=$this->line_header . __METHOD__ ."()] - ";
        try {
            $this->debug($log_header . "LISTING BOOK.... [$this->clase]");
            $this->view->setName("index");
            $this->view->setContact($this->model->list());
            
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