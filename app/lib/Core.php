<?php

/*
* App core class
* Creates url and loads core controller
* URL FORMAT - /controller/method/params
*/

class Core {
    protected $currentController = 'Pages'; // Stores the controller being used by the app, the default is the Pages controller
    protected $currentMethod = 'index'; // Stores the current method being called by the controller, the default is index
    protected $parameters = []; // the peramiters that need to be passed to methods

    // Core class constructor, calls getUrl method when the class is instatiated
    public function __construct() {    
        // Grabs url and stores it in $url variable
        $url = $this->getUrl();

        // Look for controller in Controllers folder
        if(file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
            // if exists, set as current controller
            $this->currentController = ucwords($url[0]);

            // Unset 0 index
            unset($url[0]);
        }

        // Require the controller (bring it into index.php)
        require_once '../app/controllers/' . $this->currentController . '.php';

        // Instantiate the current controller class
        $this->currentController = new $this->currentController;

        // Check for method that is found in second peramiter of url and saved in the second ([1]) part of the url array
        if(isset($url[1])) {
            // Check if method exists in the controller 
            if(method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];

                // Unset 1 index
                unset($url[1]);
            }
        }

        // Get parametersn and insert it into the parameters array
        $this->parameters = $url ? array_values($url) : [];

        // Callbak with array of parameters
        call_user_func_array([$this->currentController, $this->currentMethod], $this->parameters);

    }

    // Gets url set in header (text after the ?url parameters)
    public function getUrl() {
        if(isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
}