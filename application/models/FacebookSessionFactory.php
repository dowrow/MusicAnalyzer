<?php

// Composer
require 'vendor/autoload.php';

// Important
session_start();

// Namespaces
use Facebook\FacebookSession;
use Facebook\FacebookJavaScriptLoginHelper;

// Set app keys
FacebookSession::setDefaultApplication('1468034890110746','09e80af7d50f86bc41d5d4895e0a978d');

class FacebookSessionFactory {
    
    public static function getSession() {
        try {            
            // Get login helper
            $helper = new FacebookJavaScriptLoginHelper();
            $session = $helper->getSession(); 
            return $session;
        } catch(Exception $ex) {
            return null;
        }
    }
}

?>
