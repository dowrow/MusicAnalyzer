<?php

// Composer
require 'vendor/autoload.php';

// Important
session_start();

// Namespaces
use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\FacebookJavaScriptLoginHelper;

// Fix third-party cookie problem for Internet Explorer
// Thanks Obama
header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');

class Facebook extends CI_Model {
    
    const APP_ID = '1468034890110746';
    const APP_SECRET = '09e80af7d50f86bc41d5d4895e0a978d';
    
    // Singleton
    private $session;
    
    public function __construct() {
        
        parent::__construct();
        
        // Set app keys
        FacebookSession::setDefaultApplication(self::APP_ID, self::APP_SECRET);
        
        // Build session once
        $this->buildSession();
    }
    
    private function buildSession() {
        
        // See if  $_SESSION exists
        if (isset($_SESSION) && isset($_SESSION['fb_token'])) {
            
            // Create new fb session from saved fb_token
            $this->session = new FacebookSession($_SESSION['fb_token']);
            
            // Validate the access_token to make sure it's still valid
            try {
              if ( !$this->session->validate() ) {
                $this->session = null;
              }
            } catch ( Exception $e ) {
              // catch any exceptions
              $this->session = null;
            }
            
        }
        
        if ( !isset( $this->session ) || $this->session === null ) {

            // Get login helper
            $helper = new FacebookJavaScriptLoginHelper();

            try {            
                $this->session = $helper->getSession();
            } catch(Exception $ex) {
                var_dump($ex);
                //$this->session = null;
            }
        }
    }
    
    public function getSession() {
        return $this->session;
    }
    
    function base64_url_decode($input) {
        return base64_decode(strtr($input, '-_', '+/'));
    }
    
    public function getLocale () {
        if (isset($_REQUEST['signed_request'])) {
            
            list($encoded_sig, $payload) = explode('.', $_REQUEST['signed_request'], 2); 

            $data = json_decode($this->base64_url_decode($payload), true);
            
            return $data['user']['locale'];
        }
    }
    
    public function getLikesPageids () {
        
        $likes = array();
        $session = $this->getSession();
        
        $request = new FacebookRequest(
            $session,
            'GET',
            '/me/likes'
        );
            
        do {
            $response = $request->execute();
            $graphObject = $response->getGraphObject();
            if ($graphObject->getProperty('data') !== null) {
                $some_likes = $graphObject->getProperty('data')->asArray();
                $likes = array_merge($likes, $some_likes);
            }
            
        } while ($request = $response->getRequestForNextPage());
        
        // Extract pageids
        $pageids = array();
        foreach ($likes as $page) {
            array_push($pageids, $page->id);
        }
        
        return $pageids;
    }
    
    public function getUserId () {
        $session = $this->getSession();
        $request = new FacebookRequest(
            $session,
            'GET',
            '/me'
        );
        $response = $request->execute();
        return $response->getGraphObject()->getProperty('id');
    }
}

?>
