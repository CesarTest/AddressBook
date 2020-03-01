<?php namespace book\controllers;

use book\interfaces\Controller;
use Monolog\Logger;


/**
 *
 * @author cesar
 *        
 */
class Errors extends Controller
{

    /**
     */
    public function __construct(Logger $log=null){parent::__construct($log);}
 
    /**
     */
    public function start(){
        echo("Error Loading Resource");
    }
    
    
}