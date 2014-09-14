<?php

// Composer
require 'vendor/autoload.php';
require 'FacebookSessionFactory.php';

use Facebook\FacebookRequest;
use Facebook\FacebookRequestException;
use Facebook\GraphUser;
use Facebook\GraphPage;

class MusicFactory {
    public static function getArtists () {
        $artists = array();
        $session = FacebookSessionFactory::getSession();
        if (!is_null($session)) {
            
            try {
                $musicRequest = new FacebookRequest($session, 'GET', '/me/music');
                $objectList = $musicRequest->execute()->getGraphObjectList(GraphPage::className());
                foreach ($objectList as $object) {
                    array_push($artists, $object->getProperty('name'));
                }
                
            } catch (Exception $e) {
            }
        }
        return $artists;
    }
}



/* END */