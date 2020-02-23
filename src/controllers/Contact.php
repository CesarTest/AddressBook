<?php
use Monolog\Logger;

/**
 *
 * @author cesar
 *        
 */
class Contact extends \Controller
{

    
    //--------------------------------
    //       PRIVATE METHODS 
    //--------------------------------
    private function validateNewAddressForm() {
        $log_header=$this->line_header . __METHOD__ ."()] - ";
        $this->log->addDebug( $log_header . "NEW ADDRESS FORM");
        try {
            
            $fields=[  'name'    => [ 'value' => '' , 'type' => 'varchar(20)' ] 
                     , 'surname' => [ 'value' => '' , 'type' => 'varchar(40)' ]
                     , 'address' => [ 'value' => '' , 'type' => 'varchar(60)' ]
                     , 'email'   => [ 'value' => '' , 'type' => 'varchar(40)' ]
                     , 'phone'   => [ 'value' => '' , 'type' => 'varchar(10)' ]
                     ];

            $this->validationTier2($fields);
            
            
        } catch (Exception $e) {
            $this->treatException($e
                , $log_header . "NEW ADDRESS FORM"
                );
        } catch (Error $e) {
            $this->treatError($e
                , $log_header . "NEW ADDRESS FORM"
                );
        }    
    }
    
    /**
     */
    public function __construct(Logger $log = null)
    {
        parent::__construct($log = null);
    }

    //--------------------------------
    //   PUBLIC METHOD FOR VIEWS
    //--------------------------------
    
    /**
     *  Validate Form Data and Insert User
     */
    public function newAddress()
    {
        $log_header=$this->line_header . __METHOD__ ."()] - ";
        $this->log->addDebug( $log_header . "LAUNCH [$this->clase] COMMAND");
        try {
            
            // 1.- Data Validations
            $this->validateNewAddressForm();
            
            // 1.- Data Manipulation
            $this->model->addContact();
            
            // 2.- Set View
            $this->view->setName("success");
            
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

