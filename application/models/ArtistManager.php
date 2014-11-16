<?php

include __DIR__.'/Artist.php';

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
        $this->load->model('Artist_model');
        $this->load->model('LastfmArtist_model');
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

    /*******************/
    /* Proxy functions */
    /*******************/
    
    private function getInfoFromLastFM ($artist) {
        $this->getArtistFromLastFM($artist);
        $this->getAlbumsFromLastFM($artist);
        $this->getTagsFromLastFM($artist);
        $this->getSimilarFromLastFM($artist);
    }
    
    private function getArtistFromLastFM($artist) {
        
        // Insert name in Artists
        $id = $this->Artist_model->insert(array('name' => $artist));
        
        // Get id
        if ($id == FALSE){
            return FALSE;
        }
        
        // Get LastfmArtist 
        $lastfmArtist = $this->LastFM->getArtist($artist);
        
        if ($lastfmArtist == FALSE) {
            return FALSE;
        }
        
        // Insert in LastfmArtists
        $lastfmId = $this->LastfmArtist_model->insert(array(
            'url' => $lastfmArtist->artist->url,
            'image' => $lastfmArtist->artist->image[3]->{'#text'}
        ));
        
        if ($lastfmId == FALSE) {
            return FALSE;
        }
        
        // Insert reference in Artists
        $this->Artist_model->update($id, 
                array('lastfmartistid' => $lastfmId)
        );
        
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
