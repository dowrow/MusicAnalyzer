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
        $this->load->model('/CRUD/User_model');
        $this->load->model('/CRUD/Like_model');
    }
     
    /*
     * DB population
     */
       
    public function insertLikes ($userid, $pageids) {
        
        if (!isset($pageids) || !isset($userid)) {
            return;
        }
        
        // Insert user
        $userId = $this->User_model->insert(array('userid' => $userid), TRUE);
        
        // Insert facebookobjects
        foreach ($pageids as $pageid) {
            $this->db->insert('facebookobjects', array('pageid' => $pageid));
        }
                
        // Get facebookobjects ids
        $this->db->select('id');
        $this->db->from('facebookobjects');
        $this->db->where_in('pageid', $pageids);
        $query = $this->db->get();
        if ($query) {
            $facebookObjectIds = $query->result();
        } else {
            $facebookObjectIds = array();
        }

        // Insert likes
        $rows = array();
        foreach ($facebookObjectIds as $facebookObjectId) {
            
            $this->db->insert('likes', array(
                'userid' => $userId,
                'facebookobjectid' => $facebookObjectId->id
            ));
        }
    }
        
    public function insertFriends ($userid, $friends) {
        
        if (!isset($friends) || !isset($userid)) {
            return;
        }
        
        // Every userid in $friends already exists in Users table
        
        // Get own id
        $ownId = $this->User_model->get_by('userid', $userid);
        
        // Get friends ids
        $this->db->select('id');
        $this->db->from('users');
        $this->db->where_in('userid', $friends);
        $query = $this->db->get();
        if ($query) {
            $friendIds = $query->result();
        } else {
            $friendIds = array();
        }
        
        // Insert friendship
        $rows = array();
        foreach ($friendIds as $friendId) {
            array_push($rows, array(
                'userid1' => $ownId->id,
                'userid2' => $friendId->id
           ));
        }
        
        if (count($rows) > 0) {
            $this->db->insert_batch('friends', $rows);
        }
    }
    public function insertReference($artist, $pageid) {
        if ($pageid === "") {
            return;
        }
        try {
            $facebookObject = $this->FacebookObject_model->get_by('pageid', $pageid);
            if (is_object($facebookObject)) {
                
                $data = array(
                    'facebookobjectid' => $facebookObject->id,
                );
                //$this->db->like('LOWER(artists.name)', strtolower($artist));
                $artist = strtolower($artist);
                $this->db->where("(LOWER(artists.name) LIKE '{$artist}')");
                $this->db->update('artists', $data);
                
            }
        } catch (Exception $e) {
            return;
        }

    }
    
    public function insertArtist ($pageid, $name, $url, $image) {
        
        if ($pageid === "") {
            $id = $this->Artist_model->insert(array(
                'name' => $name
            ));
        } else {
            
            // Get facebook object id
            $facebookObject = $this->FacebookObject_model->get_by('pageid', $pageid);

            if (is_object($facebookObject)) {
                
                $id = $this->Artist_model->insert(array(
                    'name' => $name,
                    'facebookobjectid' => $facebookObject->id
                ));
                
            } else {
            
                // Insert name in Artists
                $id = $this->Artist_model->insert(array(
                    'name' => $name
                ));
                
            }
        }
        
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
        $similarId = self::insertArtist("", $similar, $url, $image);

        // Insert in SimilarArtists
        $this->SimilarArtist_model->insert(array(
            'artistid1' => $artistId,
            'artistid2' => $similarId
        ));
        
    }
    
}

?>
