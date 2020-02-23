<?php

/**
 *
 * @author cesar
 *        
 */
use Monolog\Logger;

class Errors extends Controller
{

    /**
     */
    public function __construct(Logger $log=null){parent::__construct($log);}
        
}