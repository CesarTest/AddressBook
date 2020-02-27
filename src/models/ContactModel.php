<?php
use Monolog\Logger;

/**
 *
 * @author cesar
 *        
 */
class ContactModel extends Model
{

    /**
     *
     * @param Logger $log
     */
    public function __construct(Logger $log=null)
    {
        parent::__construct($log);
    }

    public function addContact() {
        echo("AGREGANDO USUARIO.........");
        //echo serialize(get_class_methods($this));
        return true;
    }
    
}

