<?php 
    namespace Config;

    class Request
    {
        private $controller;
        private $method;
        private $parameters = array();
        
        public function __construct()
        {
          	// $url = filter_input(INPUT_GET, "url", FILTER_SANITIZE_URL);
            // 1. Capturamos la URL. Si no existe (estás en la home), le asignamos un string vacío ""
    		// El operador ?? "" es la clave para que no explote en PHP 8
			$url = filter_input(INPUT_GET, "url", FILTER_SANITIZE_URL) ?? "";
            $urlArray = explode("/", $url);
       
            $urlArray = array_filter($urlArray);

            if(empty($urlArray))
                $this->controller = "Home";            
            else
                $this->controller = ucwords(array_shift($urlArray));

            if(empty($urlArray))
                $this->method = "Index";
            else
                $this->method = array_shift($urlArray);

            $methodRequest = $this->getMethodRequest();
                        
            if($methodRequest == "GET")
            {
                unset($_GET["url"]);

                if(!empty($_GET))
                {                    
                    foreach($_GET as $key => $value)                    
                        array_push($this->parameters, $value);
                }
                else
                    $this->parameters = $urlArray;
            }
            elseif ($_POST)
                $this->parameters = $_POST;
            
            if(isset($this->parameters["btn"]))
                unset($this->parameters["btn"]);

            if(isset($this->parameters["button"]))
                unset($this->parameters["button"]);
            
            if($_FILES)
            {
                foreach($_FILES as $key => $file)
                {
                    $this->parameters[$key] = $file;
                }
            }
        }

        private static function getMethodRequest()
        {
            return $_SERVER["REQUEST_METHOD"];
        }            

        public function getController() {
            return $this->controller;
        }

        public function getMethod() {
            return $this->method;
        }

        public function getparameters() {
            return $this->parameters;
        }
    }
?>