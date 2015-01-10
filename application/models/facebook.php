<?php

// Composer
require 'vendor/autoload.php';

// Important
session_start();

// Namespaces
use Facebook\FacebookSession;
use Facebook\FacebookJavaScriptLoginHelper;

class Facebook extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        // Set app keys
        FacebookSession::setDefaultApplication('1468034890110746','09e80af7d50f86bc41d5d4895e0a978d');
    }
    
    public function getSession() {
        // Get login helper
        $helper = new FacebookJavaScriptLoginHelper();
        try {            
            $session = $helper->getSession(); 
            return $session;
        } catch(Exception $ex) {
            return null;
        }
    }
    
    public function getLocale () {
        if (isset($_REQUEST['signed_request'])) {
            echo $_REQUEST['signed_request'];
        } else {
            echo 'No signed request';
        }
    }
}

?>
