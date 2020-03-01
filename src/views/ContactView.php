<?php 
namespace book\views;
use book\interfaces\ObjetoWeb;
use book\interfaces\View;
use Monolog\Logger;
use Exception;
use Error;

/**
 *
 * @author Cesar Delgado
 *        
 */
class ContactView extends View
{

    //--------------------------------
    //       PRIVATE METHODS
    //--------------------------------
    // 1.- Form Fields
    protected $fields;
    

    //--------------------------------
    //       PUBLIC METHODS
    //--------------------------------
    
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
            $this->fields=[ 'firstname' => ['value'=>'', 'type'=>'varchar', 'min'=>'1', 'max'=>'50', 'label'=>'First Name' ] 
                    , 'lastname'  => ['value'=>'', 'type'=>'varchar', 'min'=>'1', 'max'=>'50', 'label'=>'Surname' ]
                    , 'address'   => ['value'=>'', 'type'=>'varchar', 'min'=>'1', 'max'=>'255', 'label'=>'Address' ]
                    , 'email'     => ['value'=>'', 'type'=>'varchar', 'min'=>'0', 'max'=>'50', 'label'=>'eMail' ]
                    , 'phone'     => ['value'=>'', 'type'=>'varchar', 'min'=>'0', 'max'=>'20', 'label'=>'Phone' ]
            ];
            
            // 2.- Set Parent Properties
            parent::init($parentProperties);
            
        } catch (Exception $e) {
            $this->treatException($e
                , $log_header . "NEWz ADDRESS FORM"
                );
        } catch (Error $e) {
            $this->treatError($e
                , $log_header . "NEW ADDRESS FORM"
                );
        }
    }

    //--------------------------------
    //       GETTER / SETTER
    //--------------------------------
    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }
    
    /**
     * @param array $address
     */
    public function setFields($address)
    {
        $this->fields = $address;
    }
    
}

