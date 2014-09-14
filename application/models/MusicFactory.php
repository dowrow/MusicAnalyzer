<?php

// Composer
require 'vendor/autoload.php';

use Facebook\FacebookRequest;

require 'FacebookSessionFactory.php';

class MusicFactory {
    public static function getArtists () {
        $artists = array();
        try {
            $session = FacebookSessionFactory::getSession();
            if (!is_null($session)) {

                    $musicRequest = new FacebookRequest($session, 'GET', '/me/music');
                    $objectList = $musicRequest->execute()->getGraphObjectList();
                    foreach ($objectList as $obj) {
                        array_push($artists, $obj->getProperty('name'));
                    }
            }
        } catch (Exception $e) {
        }
        return $artists;
    }
}

/* END */