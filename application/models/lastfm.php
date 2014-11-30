<?php

/**
 * LastFM
 * Contains methods for accessing LastFM JSON API
 *
 * @author Diego
 */
class LastFM extends CI_Model {
    
    /*
     * LastFM private token
     */
    const API_KEY = "5554fc23346ee78a88be13fa9a5201c7";
    
    /*
     * API query limits
     */
    const MAX_ARTISTS = 10;
    const MAX_ALBUMS = 10;
    const MAX_TAGS = 10;
    const MAX_FANS = 10;
    
    /*
     * Constructor
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**************************
     * LastfFM API primitives *
     **************************/
    
    /*
     * Get an artist
     * @param String name Artist name
     * @returns Object or false if error
     */
    public function getArtist($name="") {
        $url = "http://ws.audioscrobbler.com/2.0/?method=artist.getinfo";
        $url .= "&artist=" . urlencode($name);
        $url .= "&limit=" . self::MAX_ARTISTS;
        $url .= "&api_key=" . self::API_KEY . "&format=json";
        $obj = json_decode(file_get_contents($url));
        if (is_string($obj)) {
            return false;
        }
        return $obj;
    }
    
    /*
     * Get an album
     * @param String artist
     * @param String album
     * @returns Object or false if error
     */
    public function getAlbum($artist="", $album="") {
        $url = "http://ws.audioscrobbler.com/2.0/?method=album.getinfo";
        $url .= "&artist=" . urlencode($artist);
        $url .= "&album=" . urlencode($album);
        $url .= "&limit=" . self::MAX_ALBUMS;
        $url .= "&api_key=" . self::API_KEY . "&format=json";
        $obj = json_decode(file_get_contents($url));
        if (is_string($obj)) {
            return false;
        }
        return $obj;
    }
    
    /*
     * Get a user 
     * @param String name
     * @returns Object or false if error
     */
    public function getUser($name="") {
        $url = "http://ws.audioscrobbler.com/2.0/?method=user.getinfo";
        $url .= "&user=" . urlencode($name);
        $url .= "&limit=" . self::MAX_FANS;
        $url .= "&api_key=" . self::API_KEY . "&format=json";
        $obj = json_decode(file_get_contents($url));
        if (is_string($obj)) {
            return false;
        }
        return $obj;
    }
    
    /*
     * Get tags by any property
     * @param String property
     * @param String value
     * @returns Array 
     */
    public function getTag($name="") {
        $url = "http://ws.audioscrobbler.com/2.0/?method=tag.getinfo";
        $url .= "&tag=" . urlencode($name);
        $url .= "&limit=" . self::MAX_TAGS;
        $url .= "&api_key=" . self::API_KEY . "&format=json";
        $obj = json_decode(file_get_contents($url));
        if (is_string($obj)) {
            return false;
        }
        return $obj;
    }
    
    /*
     * Derivatives
     */
    
    /*
     * Get top tags from given artist
     * @param String artist
     * @return Array or false if error
     */
    public function getTopTags($artist="") {
        if (!$artist)
            return false;
        $url = "http://ws.audioscrobbler.com/2.0/?method=artist.gettoptags";
        $url .= "&artist=" . urlencode($artist);
        $url .= "&limit=" . self::MAX_TAGS;
        $url .= "&api_key=" . self::API_KEY . "&format=json";
        $obj = json_decode(file_get_contents($url));
        if (is_string($obj)) {
            return false;
        } else {
            return $obj;
        }
    }
    
    /*
     * Get top fans given artist
     * @param String artist
     * @return Array or false if error
     */
    public function getTopFans($artist="") {
        if (!$artist)
            return false;
        $url = "http://ws.audioscrobbler.com/2.0/?method=artist.gettopfans";
        $url .= "&artist=" . urlencode($artist);
        $url .= "&limit=" . self::MAX_FANS;
        $url .= "&api_key=" . self::API_KEY . "&format=json";
        $obj = json_decode(file_get_contents($url));
        if (is_string($obj)) {
            return false;
        } else {
            return $obj;
        }
    }
    
    /*
     * Get albums given artist
     * @param String artist
     * @return Array or false if error
     */
    public function getTopAlbums($artist="") {
        if (!$artist)
            return false;
        $url = "http://ws.audioscrobbler.com/2.0/?method=artist.gettopalbums";
        $url .= "&artist=" . urlencode($artist);
        $url .= "&limit=" . self::MAX_ALBUMS;
        $url .= "&api_key=" . self::API_KEY . "&format=json";
        $obj = json_decode(file_get_contents($url));
        if (is_string($obj)) {
            return false;
        } else {
            return $obj;
        }
    }
    
    /*
     * Get similar artists
     * @param String artist
     * @return Array or false if error
     */
    public function getSimilar($artist="") {
        if (!$artist)
            return false;
        $url = "http://ws.audioscrobbler.com/2.0/?method=artist.getsimilar";
        $url .= "&artist=" . urlencode($artist);
        $url .= "&limit=" . self::MAX_ARTISTS;
        $url .= "&api_key=" . self::API_KEY . "&format=json";
        $obj = json_decode(file_get_contents($url));
        if (is_string($obj)) {
            return false;
        } else {
            return $obj;
        }
    }
    
}

?>
