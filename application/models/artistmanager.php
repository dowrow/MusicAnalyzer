<?php
/**
 * ArtistManager
 * 
 * @author Diego
 */
class ArtistManager extends CI_Model {
    
   
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
    }
    
    
    /*
     * DB population
     */
    
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
        
    }
     
    public function insertAlbum () {
        
    }
    
    public function insertFan () {
        
    }
    
    public function insertSimilar () {
        
    }
    
    public function insertTag () {
        
    }
    /*
     * public function getArtistFromLastFM($artist) {
        
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
        
        return $id;
    }
    
    public function getAlbumsFromLastFM($artist) {
        // Get id
        $artistObj = $this->Artist_model->get_by('name', $artist);
        
        if (!is_object($artistObj)) {
            return FALSE;
        }
        
        $artistId = $artistObj->id;
        
        // Get Lastfm albums
        $albums = $this->LastFM->getTopAlbums($artist);
                
        // Insert each album in Albums
        if ($albums == FALSE) {
            return FALSE;
        }
        
        if (isset($albums->topalbums->album)) {
            foreach ($albums->topalbums->album as $album) {
                
                $albumId = $this->Album_model->insert(array(
                    'name' => $album->name,
                    'url' => $album->url,
                    'artistid' => $artistId,
                    'date' => $this->LastFM->getAlbum($artist, $album->name)->album->releasedate
                ));
            }
        }
        
    }
    
    public function getTagsFromLastFM($artist) {
        // Get id
        $artistObj = $this->Artist_model->get_by('name', $artist);
        
        if (!is_object($artistObj)) {
            return FALSE;
        }
        
        $artistId = $artistObj->id;
        
        // Get lastfm tags
        $tags = $this->LastFM->getTopTags($artist);
        
        // Insert each tag in Tags and ArtistTags
        if ($tags == FALSE) {
            return FALSE;
        }
        
        if (isset($tags->toptags->tag)) {
            
            foreach ($tags->toptags->tag as $tag) {
                $tagId = $this->Tag_model->insert(array(
                    'name' => $tag->name,
                    'url' => $tag->url
                ), true);
                
                $this->ArtistTag_model->insert(array(
                    'tagid' => $tagId,
                    'artistid' => $artistId
                ), true);
            }
        }      
    }
    
    public function getFansFromLastFM($artist) {
        // Get id
        $artistObj = $this->Artist_model->get_by('name', $artist);
        
        if (!is_object($artistObj)) {
            return FALSE;
        }
        
        $artistId = $artistObj->id;
        
        // Get lastfm tags
        $fans = $this->LastFM->getTopFans($artist);
        
        // Insert each tag in Tags and ArtistTags
        if ($fans == FALSE) {
            return FALSE;
        }
        
        if (isset($fans->topfans->user)) {
            
            foreach ($fans->topfans->user as $fan) {
                $fanId = $this->Fan_model->insert(array(
                    'age' => $this->LastFM->getUser($fan->name)->user->age,
                    'url' => $fan->url
                ), true);
                
                $this->ArtistFan_model->insert(array(
                    'fanid' => $fanId,
                    'artistid' => $artistId
                ), true);
            }
        }      
    }
    
    public function getSimilarFromLastFM($artist) {
        // Get id
        $artistObj = $this->Artist_model->get_by('name', $artist);
        
        if (!is_object($artistObj)) {
            return FALSE;
        }
        
        $artistId = $artistObj->id;
        
        // Get lastfm similar artists
        $similarArtists = $this->LastFM->getSimilar($artist);
        
        // Insert each similar in Artists and SimilarArtists
        if ($similarArtists == FALSE) {
            return FALSE;
        }
        
        if (isset($similarArtists->similarartists->artist)) {
            foreach ($similarArtists->similarartists->artist as $artist) {

                // Insert artist into Artists and LastFMArtists tables
                $similarId = self::getArtistFromLastFM($artist->name);
            
                // Insert in SimilarArtists
                $this->SimilarArtist_model->insert(array(
                    'artistid1' => $artistId,
                    'artistid2' => $similarId
                ));
                
            }
        }
        
    
    }
    */
    
    
}

?>
