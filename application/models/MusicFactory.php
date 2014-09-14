<?php

// !!
session_start();

// Composer
require 'vendor/autoload.php';
//require 'FacebookSessionFactory.php';

// Namespaces
use Facebook\FacebookSession;
use Facebook\FacebookCanvasLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookRequestException;
use Facebook\GraphUser;
use Facebook\GraphPage;

class MusicFactory {
    public static function getArtists () {
        $artists = array();
        
        try {

            // Set app keys
            FacebookSession::setDefaultApplication('1468034890110746','09e80af7d50f86bc41d5d4895e0a978d');
            // Get login helper
            $helper = new FacebookCanvasLoginHelper();
            
            try {
              $session = $helper->getSession();
            } catch (FacebookRequestException $ex) {
                array_push($artists, 'Facebook returs: ' . $ex->getMessage());
            } catch (\Exception $ex) {
                 array_push($artists, 'Exception: ' . $ex->getMessage());
            }
            
            if ($session) {

                    $musicRequest = new FacebookRequest($session, 'GET', '/me/music');
                    $objectList = $musicRequest->execute()->getGraphObjectList();
                    foreach ($objectList as $obj) {
                        array_push($artists, $obj->getProperty('name'));
                    }

            } else {
                array_push($artists, 'No session wtf');
            }
            
        } catch (Exception $e) {
                array_push($artists, 'No music wtf');
        }
        
        return $artists;
    }
}



/* END */