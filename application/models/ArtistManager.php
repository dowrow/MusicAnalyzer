<?php

include 'Artist.php';

/**
 * ArtistManager
 * 
 *
 * @author Diego
 */
class ArtistManager extends CI_Model {
    
   
    /*
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('LastFM');
        $this->load->model('Artist_Model', 'Artist');
    }
    
    /*
     * DB queries *
     */
    
    /*
     * Has lastfm
     * @param String $artist
     * @return Boolean 
     */
    public function hasLastFM ($artist) {
        if ($this->LastFM->getArtist() != false) {
            return true;   
        } else {
            return false;
        }
        
    }
    
    public function getArtist ($artist) {
        $this->getInfoFromLastFM($artist);
        return new Artist($artist);
    }


    /* Proxy functions */
    private function getInfoFromLastFM ($artist) {
        $this->getArtistFromLastFM($artist);
        $this->getAlbumsFromLastFM($artist);
        $this->getTagsFromLastFM($artist);
        $this->getSimilarFromLastFM($artist);
    }
    
    private function getArtistFromLastFM($artist) {
        // Insert name in Artists
        $id = $this->Artist->insert();
        // Get id
        // Get LastfmArtist 
        // Insert in LastfmArtists
    }
    
    private function getAlbumsFromLastFM($artist) {
        // Get id
        // Get Lastfm albums
        // Insert each album in Albums and AlbumTags
    }
    
    private function getTagsFromLastFM($artist) {
        // Get id
        // Get lastfm tags
        // Insert each tag in Artist and ArtistTags
    }
    
    private function getSimilarFromLastFM($artist) {
        // Get id
        // Get lastfm similar artists
        // Insert each similar in Artists and SimilarArtists
    }
    
    
}

?>
