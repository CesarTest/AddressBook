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
        $log_header=$this->line_header . __METHOD__ ."()] - ";
        $success=false;
        try {
            $vista=$this->getController()->getView();
            $address=$vista->getFields();            
            $this->debug($log_header . "ADDING CONTACT - [" . $address['firstname'] . "]");
            var_dump($address['firstname']['value']);
            $pool=$this->connection->getPool();
            $query=$pool->prepare('INSERT INTO contact (firstname, lastname, address, email, phone) VALUES(:firstname, :lastname, :address, :email, :phone)');  
            $success=$query->execute([
                          'firstname' => $address['firstname']['value']
                        , 'lastname'  => $address['lastname']['value']
                        , 'address'   => $address['address']['value']
                        , 'email'     => $address['email']['value']
                        , 'phone'     => $address['phone']['value']
                        ]);
            
        } catch (Exception $e) {
            $this->treatException($e
                , $log_header . "ERROR LISTING USERS"
                );
        } catch (Error $e) {
            $this->treatError($e
                , $log_header . "ERROR LISTING USERS"
                );
        }
        
        return $success;
    }
    
}

