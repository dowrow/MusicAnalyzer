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
        if ($session) {
            try {
                $musicRequest = new FacebookRequest($session, 'GET', '/me/music');
                $resp = $musicRequest->execute()->getGraphObjectList(GraphPage::className());
                echo 'Prueba:<br/>';
                print_r($resp);
                echo 'Fin<br/>';
            } catch (Exception $e) {
            }
        } 
        return $artists;
    }
}



/* END */