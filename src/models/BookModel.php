<?php 
use Monolog\Logger;

/**
 *
 * @author cesar
 *        
 */
class BookModel extends Model
{
    
    //--------------------------------
    //       PUBLIC METHOD
    //--------------------------------
    
    /**
     *
     * @param Logger $log
     */
    public function __construct(Logger $log = null)
    {
        parent::__construct($log = null);
    }
    
    public function list() {
        echo "MODEL - LISTING USERS";
        $log_header=$this->line_header . __METHOD__ ."()] - ";
        $contacts=[[]];
        try {
            $this->debug($log_header . "LISTING CONTACTS");
            $pool=$this->connection->getPool();
            $query=$pool->query('SELECT * FROM contact');
            
            while($row = $query->fetch()){
                $contact=[ 'firstname' => ['value'=>$row['firstname'], 'type'=>'varchar', 'min'=>'1', 'max'=>'50', 'label'=>'First Name' ]
                         , 'lastname'  => ['value'=>$row['lastname'] , 'type'=>'varchar', 'min'=>'1', 'max'=>'50', 'label'=>'Surname' ]
                         , 'address'   => ['value'=>$row['address']  , 'type'=>'varchar', 'min'=>'1', 'max'=>'255', 'label'=>'Address' ]
                         , 'email'     => ['value'=>$row['email']    , 'type'=>'varchar', 'min'=>'0', 'max'=>'50', 'label'=>'eMail' ]
                         , 'phone'     => ['value'=>$row['phone']    , 'type'=>'varchar', 'min'=>'0', 'max'=>'20', 'label'=>'Phone' ]
                        ];
                array_push($contacts, $contact);
            }
            
        } catch (Exception $e) {
            $this->treatException($e
                , $log_header . "ERROR LISTING USERS"
                );
        } catch (Error $e) {
            $this->treatError($e
                , $log_header . "ERROR LISTING USERS"
                );
        }
        
        return $contacts;
        
    }
    
}

