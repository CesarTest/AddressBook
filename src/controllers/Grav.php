<?php namespace book\controllers;

use book\interfaces\Controller;
use Monolog\Logger;

/**
 *
 * @author cesar
 *        
 */
class Grav extends Controller
{

    /**
     */
    public function __construct(Logger $log=null){parent::__construct($log);}
}

