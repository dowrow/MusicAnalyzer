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
                        $name = $obj->getProperty('name');
                        array_push($artists, $name . ' - ' . self::getAverageFanAge($name));
                    }
            }
        } catch (Exception $e) {
        }
        return $artists;
    }
    
    public static function getAverageFanAge ($artist = '') {
        $average = 0;
        $fanNames = array();
        $fanAges = array();
        $topFansURL = 'http://ws.audioscrobbler.com/2.0/?method=artist.gettopfans&api_key=5554fc23346ee78a88be13fa9a5201c7&format=json&artist=' . urlencode($artist);
        $userInfoURL = 'http://ws.audioscrobbler.com/2.0/?method=user.getinfo&api_key=5554fc23346ee78a88be13fa9a5201c7&format=json&user=';
        
        try {
            
            // Get fan names
            $topFansJSON = json_decode(file_get_contents($topFansURL), true);
            $topFans = $topFansJSON['topfans']['user'];
            foreach ($topFans as $fan) {
                array_push($fanNames, $fan['name']);
            }
            
            // For every fan get its age
            foreach ($fanNames as $name) {
                $userInfoJSON = json_decode(file_get_contents($userInfoURL . urlencode($name)), true);
                $age = intval($userInfoJSON['user']['age']);
                array_push($fanAges, $age);
            }

            // Calculate average
            if (count($fanAges) > 0) {
                $average = array_sum($fanAges) / count($fanAges);
            }
            
        } catch (Exception $e) {
            
        }
        
        return $average;
        
    }
}

/* END */