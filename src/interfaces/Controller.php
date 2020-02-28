<?php

/**
 *
 * @author Cesar Delgado
 *        
 */
use Monolog\Logger;

class Controller extends ObjetoWeb
{

       /*----------------------------------
        * PROPERTIES
        *----------------------------------*/
        // 1.- MVC References
        protected $view;    
        protected $model;
        protected $book;
        
        
        // 2.- Controller operties
        protected $command; 
        protected $parameters;
       
        /*----------------------------------
         * PRIVATE METHODS
         *----------------------------------*/
        /**
         * 
         * @param string $type
         * @param string $value
         * @param int $min
         * @param int $max
         * @return string
         */
        private function test_type(string $type='varchar', string $value='', int $min=0, int $max=0, string $field) {

            // 1.- Validate Type
            //-----------------
            $log_header=$this->line_header . __METHOD__ ."()] - ";
            $output;
            try {

                // 1.1.- Log entry
                $this->debug( $log_header . "Validate Type type=[$type],value=[$value],min=[$min], max=[$max]]");
                
                // 1.2.- Size Validation
                if(empty($value) and ($min>0)) {
                    $output="<p>[$field] - Empty not allowed, expected=[$type], minimum size=[$min] </p>";
                    
                } elseif (sizeof($value) < $min) {
                    $output="<p>[$field] - Too short, expected=[$type], minimum size=[$min] </p>";
                    
                } elseif ($max>0) {
                    if (sizeof($value) > $max) {
                        $output="<p>[$field] - Too long, expected=[$type], maximum size=[$max] <p>";
                    }
                }
                
                // 1.3.- Validate format
                
            } catch (Exception $e) {
                $this->treatException($e
                    , $log_header . "TEST TYPE FAILED"
                    );
            } catch (Error $e) {
                $this->treatError($e
                    , $log_header . "TEST TYPE FAILED"
                    );
            }
            
            // 2.- Return
            //-----------------
            return $output;
        }

        /**
         *
         * @param array $formFields
         * @return array
         */
        protected function captureXMLfile(string $xmlFile="") {
            
            $log_header=$this->line_header . __METHOD__ ."()] - ";
            $out=[];
            try {

                // 1.- Init output
                $output=$this->view->getFields();
                
                // 2.- Capture from XML file
                if(!empty($xmlFile)) {
                    if(file_exists($xmlFile)) {
                        $this->debug( $log_header . "READING XML=[$xmlFile]");
                        $data=simplexml_load_file($xmlFile);
                        foreach ($data as $key => $value) {
                            $output[$key]['value']=$value;                                                        
                        }
                    }
                }
                
            } catch (Exception $e) {
                $this->treatException($e
                    , $log_header . "CAPTURE XML FILE"
                    );
            } catch (Error $e) {
                $this->treatError($e
                    , $log_header . "CAPTURE XML FILE"
                    );
            }
            
            return $output;
        }
        
        
        /**
         * 
         * @param array $formFields
         * @return array
         */
        protected function captureForm(array $formFields=[]) {
                        
            // 1.- Capture Form
            //-----------------
            $log_header=$this->line_header . __METHOD__ ."()] - ";
            try {

                // 1.1.- Detect Form Fields
                if(empty($formFields)){$formFields=$this->view->getFields();}
                $output=$formFields;
                
                // 1.2.- Capture Form                    
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $this->debug( $log_header . "CAPTURE FORM [". serialize($output) ."]");
                    foreach($formFields as $key=>$value){
                        $valor  = $this->test_input($_POST[$key]);
                        $output[$key]['value']=$valor;
                    }
                } 
            } catch (Exception $e) {
                $this->treatException($e
                    , $log_header . "CAPTURE FORM"
                    );
            } catch (Error $e) {
                $this->treatError($e
                    , $log_header . "CAPTURE FORM"
                    );
            }

            // 2.- Return
            //-----------------
            return $output;
        }
 
        /**
         *
         * @param array $formFields
         * @return array
         */
        protected function validateFields(array $fields=[]) {
            
            // 1.- Capture Form
            //-----------------
            $log_header=$this->line_header . __METHOD__ ."()] - ";
            try {
                
                // 1.1.- Detect Fields
                if(empty($fields)){$fields=$this->view->getFields();}
                $output=$fields;
                $this->debug( $log_header . "VALIDATE FIELDS ");
                
                // 1.2.- Validate fields
                foreach($fields as $key=>$value){
                    $error  = $this->test_type($fields[$key]['type']
                        ,$fields[$key]['value']
                        ,$fields[$key]['min']
                        ,$fields[$key]['max']
                        ,$fields[$key]['label']);
                    
                    if (!empty($error)) {
                        $this->debug( $log_header . "Input Error error=[". $error . "]");
                        $this->phpErrors("Validation", $error);
                        $formFields[$key]['value']=''; // Remove invalid field
                    }
                }
            } catch (Exception $e) {
                $this->treatException($e
                    , $log_header . "VALIDATE FIELDS"
                    );
            } catch (Error $e) {
                $this->treatError($e
                    , $log_header . "VALIDATE FIELDS"
                    );
            }
            
            // 2.- Return
            //-----------------
            return $output;
        }
        
        /*----------------------------------
         * PUBLIC METHODS
         *----------------------------------*/
        
        /**
         *
         * @param string $errorType
         * @param string $errorMsg
         * @return string
         */
        public function phpErrors(string $errorType, string $errorMsg) {
            
            $log_header=$this->line_header . __METHOD__ ."()] - ";
            $vista=false;
            $view;
            try {
                
                if (property_exists($this, view)) {$view=$this->view;}
                if(!empty($view)) {

                    $this->debug( $log_header . "  PHP ERRORS [$errorType] / [$errorMsg]");
                    
                    // 1.- Set message
                    //-----------------
                    $msg=$view->getErrorMessage();
                    $msg=$msg.$errorMsg;
                    $view->setErrorMessage($msg);
                    $view->setMessage($errorType);
                    
                    // 2.- Set View
                    //--------------
                    $vista="/../errors/" . strtolower( $this->clase );
                    if(method_exists($this->view, 'setName')) {$this->view->setName($vista);}
                }
                
            } catch (Exception $e) {
                $this->treatException($e
                    , $log_header . "LOADING PHP ERROR VIEW"
                    );
            } catch (Error $e) {
                $this->treatError($e
                    , $log_header . "LOADING PHP ERROR VIEW"
                    );
            }
        
            // 3.- Return View
            //---------------
            return $vista;
        }
        
        /**
         *
         */
        public function render(){
            $log_header=$this->line_header . __METHOD__ ."()] - ";
            try { 
                if(!empty($this->view)) {
                    $name=$this->view->getName();
                    $this->debug($log_header . "RENDERING VIEW [$name]");
                    $this->view->start();
                }
            } catch (Exception $e) {
                $this->treatException($e
                    , $log_header . "ERROR STARTING CONTROLLER"
                    );
            } catch (Error $e) {
                $this->treatError($e
                    , $log_header . "ERROR STARTING CONTROLLER"
                    );
            }
        }

        /**
         *  Initiate Default View
         *
         * {@inheritDoc}
         * @see ObjetoWeb::init()
         */
        public function init(array $properties=[]){
    
            $log_header=$this->line_header . __METHOD__ ."()] - ";
            try {
                
                // 0.- Log Entry
                $this->debug($log_header . "INITIATING CONTROLLER....... [$this->clase]");
                
                // 1.- Set Properties
                if (!empty($properties)) {$this->setProperties($properties);}
                
                // 2.- Create View
                $object=$this->createClass($this->clase."View","/../views");
                if($object===false) { $object=$this->spawnObject("View"); }
                $this->view=$object;
                
                // 3.- Create Model
                $object=$this->createClass($this->clase."Model","/../models");
                if(!($object===false)) { $this->model=$object; }
               
                // 4.- Dump Controller Properties
                $this->printProperties();
                
                // 5.- Init View
                $properties=[
                      'controller'=>$this 
                    , 'vista'=>$this->command
                    ];                
                if (!empty($this->view)) {
                    if (method_exists($this->view, "init")) { 
                        $this->view->init($properties);
                    } else {
                        $tmp=get_class($this->view);
                        $this->log->addError($log_header . "INIT METHOD NOT FOUND IN VIEW [$tmp]");
                    }
                }
                
                // 6.- Init Model
                if (method_exists($this->model, "init")) {
                    $this->model->init($properties);
                } else {
                    $tmp=get_class($this->model);
                    $this->log->addError($log_header . "INIT METHOD NOT FOUND IN MODEL [$tmp]");
                }
                
            } catch (Exception $e) {
                $this->treatException($e
                    , $log_header . "ERROR INITIATING CONTROLLER"
                    );
            } catch (Error $e) {
                $this->treatError($e
                    , $log_header . "ERROR INITIATING CONTROLLER"
                    );
            }
        }
        
        /**
         *  Launch Command {render|URL[1]}
         *  
         * {@inheritDoc}
         * @see ObjetoWeb::start()
         */
        public function start(){
           
            $log_header=$this->line_header . __METHOD__ ."()] - ";
            try {
                
                $this->debug( $log_header . "STARTING CONTROLLER...... [" . $this->clase . "]");
                
                // 1.- Load Custom View
                if(method_exists($this, $this->command)) { $this->{$this->command}(); }
                
                // 2.- Render View
                $this->render();
                
            } catch (Exception $e) {
                $this->treatException($e
                    , $log_header . "ERROR STARTING CONTROLLER"
                    );
            } catch (Error $e) {
                $this->treatError($e
                    , $log_header . "ERROR STARTING CONTROLLER"
                    );
            }
        }
        
        /**
         * Contructor
         */
        public function __construct(Logger $log=null){parent::__construct($log);}  
        
        /*----------------------------------
         *           SETTER / GETTER
         *----------------------------------*/
        
        /**
         * 
         * @param View $vista
         */        
        public function setView($vista) {
            $log_header=$this->line_header . __METHOD__ ."()] - ";
            try {
                $this->view=$vista;
            } catch (Exception $e) {
                $this->treatException($e
                    , $log_header . "ERROR SETTING VIEW "
                    );
                
            } catch (Error $e) {
                $this->treatError($e
                    , $log_header . "ERROR SETTING VIEW "
                    );
            }
        }
        
        /**
         *
         * @return View
         */
        public function getView() {
            $log_header=$this->line_header . __METHOD__ ."()] - ";
            try {
                return $this->view;
            } catch (Exception $e) {
                $this->treatException($e
                    , $log_header . "ERROR GETTING VIEW "
                    );
                
            } catch (Error $e) {
                $this->treatError($e
                    , $log_header . "ERROR GETTING VIEW "
                    );
                
            }
        }
        
        /**
         *
         * @param Model $modelo
         */
        public function setModel($modelo) {
            $log_header=$this->line_header . __METHOD__ ."()] - ";
            try {
                $this->model=$modelo;
            } catch (Exception $e) {
                $this->treatException($e
                    , $log_header . "ERROR SETTING MODEL "
                    );
                
            } catch (Error $e) {
                $this->treatError($e
                    , $log_header . "ERROR SETTING MODEL "
                    );
            }
        }
        
        /**
         *
         * @return Model
         */
        public function getModel() {
            $log_header=$this->line_header . __METHOD__ ."()] - ";
            try {
                return $this->model;
            } catch (Exception $e) {
                $this->treatException($e
                    , $log_header . "ERROR GETTING MODEL "
                    );
                
            } catch (Error $e) {
                $this->treatError($e
                    , $log_header . "ERROR GETTING MODEL "
                    );
            }
        }
        
        /**
         * 
         * @param String $comando
         */  
        public function setCommand($comando) {
            $log_header=$this->line_header . __METHOD__ ."()] - ";
            try {
                $this->command=$comando;
            } catch (Exception $e) {
                $this->treatException($e
                    , $log_header . "ERROR SETTING COMMAND "
                    );
                
            } catch (Error $e) {
                $this->treatError($e
                    , $log_header . "ERROR SETTING COMMAND "
                    );
                
            }
        }
        
        /**
         * 
         * @return string|array
         */
        public function getCommand() {
            $log_header=$this->line_header . __METHOD__ ."()] - ";
            try {
                return $this->command;
            } catch (Exception $e) {
                $this->treatException($e
                    , $log_header . "ERROR GETTING COMMAND "
                    );
      
            } catch (Error $e) {
                $this->treatError($e
                    , $log_header . "ERROR GETTING COMMAND "
                    );
                
            }
        }
        
        /**
         * 
         * @param array $param
         */
        public function setParameters(array $param) {
            $log_header=$this->line_header . __METHOD__ ."()] - ";
            try {
                $this->parameters=$param;
            } catch (Exception $e) {
                $this->treatException($e
                    , $log_header . "ERROR SETTING PARAMETERS ]"
                    );
            } catch (Error $e) {
                $this->treatError($e
                    , $log_header . "ERROR SETTING PARAMETERS ]"
                    );
            }
        }
        
        /**
         * 
         * @return array
         */
        public function getParameters() {
            $log_header=$this->line_header . __METHOD__ ."()] - ";            
            try {
                return $this->parameters;
            } catch (Exception $e) {
                $this->treatException($e
                    , $log_header . "ERROR GETTING PARAMETERS ]"
                    );
            } catch (Error $e) {
                $this->treatError($e
                    , $log_header . "ERROR GETTING PARAMETERS ]"
                    );
            }
        }
}