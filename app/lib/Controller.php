<?php 

/*
* This is the base controlker and is responsable for loading models and viewa
* All controllers will extend this one
*/

class Controller {
    // Load model
    public function model($model) {
        // Require model file
        require_once '../app/models/' . $model . '.php';

        // Instantiate the model
        return new $model();
    }

    // Load view
    public function view($view, $data = []) {
        // Check for the view file
        if(file_exists('../app/views/' . $view . '.php')) {
            require_once '../app/views/' . $view . '.php';
        } else {
            // View does not exist
            die('View does not exist');
        }

    }
}