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
        session_start();
        $artists = array();
        $session = FacebookSessionFactory::getSession();
        if (!is_null($session)) {
            try {
                $musicRequest = new FacebookRequest($session, 'GET', '/me/music');
                $objectList = $musicRequest->execute()->getGraphObjectList();
                foreach ($objectList as $obj) {
                    array_push($artists, $obj->getProperty('name'));
                }
            } catch (Exception $e) {
                array_push($artists, 'No music');
            }
        } else {
            array_push($artists, 'No session');
        }
        return $artists;
    }
}



/* END */