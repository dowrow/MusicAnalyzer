<?php
/**
 * DatabaseManager
 * 
 * @author Diego
 */
class DatabaseManager extends CI_Model {
    
   
    /*
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('/CRUD/Artist_model');
        $this->load->model('/CRUD/LastfmArtist_model');
        $this->load->model('/CRUD/Album_model');
        $this->load->model('/CRUD/Fan_model');
        $this->load->model('/CRUD/ArtistFan_model');
        $this->load->model('/CRUD/Tag_model');
        $this->load->model('/CRUD/ArtistTag_model');
        $this->load->model('/CRUD/SimilarArtist_model');
        $this->load->model('/CRUD/FacebookObject_model');
    }
     
    /*
     * DB population
     */
    
    public function insertFacebookObject ($pageid) {
        
        
    }
    
    public function insertArtist ($name, $url, $image) {
        
        // Insert name in Artists
        $id = $this->Artist_model->insert(array('name' => $name));
        
        // Already inserted?
        if ($id == FALSE){
            return FALSE;
        }
        
        // Insert in LastfmArtists
        $lastfmId = $this->LastfmArtist_model->insert(array(
            'url' => $url,
            'image' => $image
        ));
        
        // Already inserted?
        if ($lastfmId == FALSE) {
            return FALSE;
        }
        
        // Insert reference in Artists
        $this->Artist_model->update($id, 
            array('lastfmartistid' => $lastfmId)
        );
        
        return $id;
        
    }
     
    public function insertAlbum ($artist, $album, $url, $date) {
        
        // Get artist id
        $artistObj = $this->Artist_model->get_by('name', $artist);
        
        if (!is_object($artistObj)) {
            return FALSE;
        }
        
        $artistId = $artistObj->id;
                
        // Insert album in Albums
        $this->Album_model->insert(array(
            'name' => $album,
            'url' => $url,
            'artistid' => $artistId,
            'date' => $date
        ));
        
    }
    
    public function insertTag ($artist, $name, $url) {
        
        // Get artist id
        $artistObj = $this->Artist_model->get_by('name', $artist);
        
        if (!is_object($artistObj)) {
            return FALSE;
        }
        
        $artistId = $artistObj->id;
        
        // Insert into tags
        $tagId = $this->Tag_model->insert(array(
            'name' => $name,
            'url' => $url
        ), true);
        
        // Insert into artisttags
        $this->ArtistTag_model->insert(array(
            'tagid' => $tagId,
            'artistid' => $artistId
        ), true);
        
    }
    
    public function insertFan ($artist, $age, $url) {
        
        // Get artist id
        $artistObj = $this->Artist_model->get_by('name', $artist);
        
        if (!is_object($artistObj)) {
            return FALSE;
        }
        
        $artistId = $artistObj->id;
        
        // Insert into fans
        $fanId = $this->Fan_model->insert(array(
            'age' => $age,
            'url' => $url
        ), true);
        
        // Insert into artistfans
        $this->ArtistFan_model->insert(array(
            'fanid' => $fanId,
            'artistid' => $artistId
        ), true);

    }
    
    public function insertSimilar ($artist, $similar, $url, $image) {
        
        // Get artist id
        $artistObj = $this->Artist_model->get_by('name', $artist);
        
        if (!is_object($artistObj)) {
            return FALSE;
        }
        
        $artistId = $artistObj->id;
        
        // Insert artist into Artists and LastFMArtists tables
        $similarId = self::insertArtist($similar, $url, $image);

        // Insert in SimilarArtists
        $this->SimilarArtist_model->insert(array(
            'artistid1' => $artistId,
            'artistid2' => $similarId
        ));
        
    }
    
}

?>
