<?php

/**
 *
 * @author cesar
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
        
        // 2.- Controller operties
        protected $command; 
        protected $parameters;
       
        /*----------------------------------
         * PRIVATE METHODS
         *----------------------------------*/
        
        private function test_type($type, $value) {

            // 1.- Validate Type
            //-----------------
            $log_header=$this->line_header . __METHOD__ ."()] - ";
            $output=$formFields;
            try {
                $this->log->addDebug( $log_header . "OK");
                
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
            
        
        
        protected function validationTier2(array $formFields) {
            
            
            // 1.- Capture Form
            //-----------------
            $log_header=$this->line_header . __METHOD__ ."()] - ";
            $output=$formFields; 
            try {
 
                $this->log->addDebug( $log_header . "VALIDATE FORM FIELDS");                
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    foreach($formFields as $key=>$value){
                        $valor  = $this->test_input($_POST[$key]);
                        $tipo   = $formFields[$key][$type];
                        if ($this->test_type($tipo, $valor)) {
                            $output[$key][$value]=$valor;
                        } else {
                            $output[$key][$value]="Invalid Entry, type=[$type]";
                            $this->view->setName("error");
                            $this->view->setMessage("[$key]=[$valor] - Type=[$tipo]");
                        }
                    }
                }
            } catch (Exception $e) {
                $this->treatException($e
                    , $log_header . "TIER 2 DATA VALIDATIONS"
                    );
            } catch (Error $e) {
                $this->treatError($e
                    , $log_header . "TIER 2 DATA VALIDATIONS"
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
         */
        public function render(){
            $log_header=$this->line_header . __METHOD__ ."()] - ";
            try { 
                $name=$this->view->getName();
                $this->log->addDebug($log_header . "LAUNCHING VIEW [$name]");
                if(!empty($this->view)) {$this->view->start();}
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
                $this->log->addDebug($log_header . "INITIATING CONTROLLER [$this->clase]");
                
                // 1.- Set Properties
                if (!empty($properties)) {$this->setProperties($properties);}
                
                // 1.- Create View
                $vista=$this->spawnObject();
                $this->view=$vista;
                     
                // 2.- Load Model
                $nombre=$this->clase ."Model";
                $class=$this->loadModule($nombre,"/../models");
                
                if (!empty($class)) {
                    $modelo=$this->spawnObject($class);
                    $this->model=$modelo;
                } 
               
                // 3.- Dump Controller Properties
                $this->printProperties();
                
                // 4.- Init View
                $properties=[
                      'controller'=>$this 
                    , 'vista'=>$this->command
                    ];                
                if (!empty($this->view)) {
                    if (method_exists($this->view, "init")) { 
                        $this->view->init($properties);
                    } else {
                        $this->log->addError($log_header . "INIT METHOD NOT FOUND IN [get_class($this->view)]");
                    }
                }
                
                // 5.- Init Model
                $properties=[];
                if (method_exists($this->model, "init")) {
                    $this->model->init();
                } else {
                    $tmp=get_class($this->view);
                    $this->log->addError($log_header . "INIT METHOD NOT FOUND IN [$tmp]");
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
            $this->log->addDebug( $log_header . "LAUNCH COMMAND [" . $this->command . "]");
            try {
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