<?php 
namespace book\views;

use book\interfaces\ObjetoWeb;
use book\interfaces\View;
use Monolog\Logger;
use Exception;
use Error;

/**
 *
 * @author cesar
 *        
 */
class BookView extends View
{
    
    //--------------------------------
    //       PRIVATE METHODS
    //--------------------------------
    // 1.- Form Fields
    protected $contact;
    protected $labels;
    
    /**
     * @return multitype:multitype: 
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @param multitype:multitype:  $contact
     */
    public function setContact(array $contact)
    {
        $this->contact = $contact;
    }

    /**
     *
     * @param Logger $log
     */
    public function __construct(Logger $log = null)
    {
        parent::__construct($log = null);
    }
    
    /**
     *
     * {@inheritDoc}
     * @see ObjetoWeb::init()
     */
    public function init(array $parentProperties=[])
    {
        $log_header=$this->line_header . __METHOD__ ."()] - ";
        try {
            
            // 0.- Trace Entry
            $this->debug($log_header . "INIT class=[$this->clase]");
            
            // 1.- Set Child Properties
            $this->labels=[ 'firstname'  => 'Name' 
                           , 'lastname'  => 'Surname'
                           , 'address'   => 'Address'
                           , 'email'     => 'eMail'
                           , 'phone'     => 'Phone'
                          ];
            
            // 2.- Set Parent Properties
            parent::init($parentProperties);
            
        } catch (Exception $e) {
            $this->treatException($e
                , $log_header . "ADDRESS BOOK LISTING"
                );
        } catch (Error $e) {
            $this->treatError($e
                , $log_header . "ADDRESS BOOK LISTING"
                );
        }
    }
}

