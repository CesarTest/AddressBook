<?php
/**
 *
 * @author cesar
 *        
 */
use Monolog\Logger;

class Pdf extends \Controller
{

    /**
     */
    public function __construct(Logger $log = null)
    {
        parent::__construct($log = null);
    }
}

