<?php
// Load config file
require_once 'config/config.php';

// Auto Load Libraries files in the 'lib' folder
spl_autoload_register(function($className) {
    require_once 'lib/' . $className . '.php'; 
});