<?php

// Composer
require 'vendor/autoload.php';

// Namespaces
use Facebook\FacebookSession;
use Facebook\FacebookCanvasLoginHelper;

class FacebookSessionFactory {
    public static function getSession() {
        // Important
        session_start();

        // Set app keys
        FacebookSession::setDefaultApplication('1468034890110746','09e80af7d50f86bc41d5d4895e0a978d');

        // Get login helper
        $helper = new FacebookCanvasLoginHelper();

        try {
            return $helper->getSession();
        } catch(Exception $ex) {
            return null;
        }
    }
}

?>
