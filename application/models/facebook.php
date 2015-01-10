<?php

// Composer
require 'vendor/autoload.php';

// Important
session_start();

// Namespaces
use Facebook\FacebookSession;
use Facebook\FacebookJavaScriptLoginHelper;

    
class Facebook extends CI_Model {
    
    const APP_ID = '1468034890110746';
    const APP_SECRET = '09e80af7d50f86bc41d5d4895e0a978d';

    public function __construct() {
        parent::__construct();
        // Set app keys
        FacebookSession::setDefaultApplication(self::APP_ID, self::APP_SECRET);
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
    
    function base64_url_decode($input) {
        return base64_decode(strtr($input, '-_', '+/'));
    }
    
    public function getLocale () {
        if (isset($_REQUEST['signed_request'])) {
            
            list($encoded_sig, $payload) = explode('.', $_REQUEST['signed_request'], 2); 

            $secret = self::APP_SECRET; // Use your app secret here

            // decode the data
            $sig = $this->base64_url_decode($encoded_sig);
            $data = json_decode($this->base64_url_decode($payload), true);
            
            print_r($data);
            
            // confirm the signature
            $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
            if ($sig !== $expected_sig) {
              error_log('Bad Signed JSON signature!');
              return null;
            }

            return $data;
        }
    }
    
    
}

?>
