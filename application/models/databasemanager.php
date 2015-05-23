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
    /**
     * Insert and updates user likes 
     */
    public function insertLikes ($userid, $likes) {

        if (!isset($likes) || !isset($userid)) {
            return;
        }

        // Insert user and retrieve its id
        $this->User_model->insert(array('userid' => $userid), TRUE);
        $me = $this->User_model->get_by('userid', $userid);
        $userId = $me->id;

        // Insert only new facebookobjects
        $newFacebookObjects = $this->getNewFacebookObjects($likes);
        if (count($newFacebookObjects) > 0) {
            $this->db->insert_batch('facebookobjects', $newFacebookObjects);
        }
        // Update old likes of the current user that the user no longer likes
        $oldLikes = $this->getOldLikes($userId, $likes);
        if (count($oldLikes) > 0) {
            $this->db->where('userid', $userId)->where_in('facebookobjectid', $oldLikes)->update('likes', array('valid' => 'false'));
        }
        
        // Insert new likes of the current user
        $newLikes = $this->getNewLikes($userId, $likes);
        if (count($newLikes) > 0) {
            $this->db->insert_batch('likes', $newLikes);
        }
        
    }

    /**
     * 
     * @param array Like objects
     * @return array Pageids of the objects
     */
    public function getPageidsFromLikes($likes) {
        $pageids = array();
        foreach ($likes as $like) {
            array_push($pageids, $like->id);
        }
        return $pageids;  
    }

    /**
     * Get the rows only for the not-already-inserted facebook objects
     * @param $userid Id of current app user
     * @param $pageids Pageid of every like (already inserted or not)
     * @return array New facebookobject rows ready for insert_batch
     */
    public function getNewFacebookObjects ($likes) {
        
        $pageids = $this->getPageidsFromLikes($likes);
        $query = $this->db->select('*')->from('facebookobjects')->where_in('pageid', $pageids)->get();
        if ($query) {
            $alreadyInsertedObjs = $query->result();
        } else {
            $alreadyInsertedObjs = array();
        }
        $newFacebookObjs = array();
        
        // For each pageid
        foreach ($likes as $like) {
            // Is already inserted?
            $inserted = false;
            foreach ($alreadyInsertedObjs as $alreadyInsertedObj) {
                if (!strcmp($like->id, $alreadyInsertedObj->pageid)) {
                    $inserted = true;
                    break;
                }
            }
            // If it is
            if ($inserted) {
                // Do nothing
            } else {
                // Otherwise push
                array_push($newFacebookObjs, array(
                    'pageid' => $like->id,
                    'category' => $like->category
                ));
            }
        }
        return $newFacebookObjs;
    }

    /**
     * Get the facebookobjectid of the likes that the user does not like anymore
     * @param $userid Id of current app user
     * @param $pageids Pageid of every like (already inserted or not)
     * @return array FacebookObjectIds of the old likes
     */
    public function getOldLikes ($userid, $likes) {
        $pageids = $this->getPageidsFromLikes($likes);
        $this->db->select('facebookobjectid')->from('likes')->join('facebookobjects', 'facebookobjects.id = likes.facebookobjectid');
        $query = $this->db->where_not_in('pageid', $pageids)->where('userid', $userid)->get();
        if ($query) {
            $oldRows = $query->result();
        } else {
            $oldRows = array();
        }
        $oldLikes = array();
        foreach ($oldRows as $oldRow) {
            array_push($oldLikes, $oldRow->facebookobjectid); 
        }
        return $oldLikes;
    }

    /**
     * Get the rows for the new likes of the current user
     * @param $userid Id of current app user
     * @param $pageids Pageid of every like (already inserted or not)
     * @return array New like rows ready for insert_batch
     */
    public function getNewLikes ($userid, $likes) {

        $pageids = $this->getPageidsFromLikes($likes);
        $this->db->select('*')->from('likes')->join('facebookobjects', 'facebookobjects.id = likes.facebookobjectid');
        $query = $this->db->where('userid', $userid)->where_in('pageid', $pageids)->get();
        if ($query) {
            $insertedLikes = $query->result();
        } else {
            $insertedLikes = array();
        }
        
        $newLikes = array();
        
        // For each pageid
        foreach ($likes as $like) {
            // Is already liked?
            $liked = false;
            foreach ($insertedLikes as $insertedLike) {
                if ($like->id == $insertedLike->pageid) {
                    $liked = true;
                    break;
                }                
            }
            
            // If it is
            if ($liked) {
                // Do nothing
            } else {
                
                $timestamp = $like->created_time;
                $facebookobjectid = $this->db->select('id')->from('facebookobjects')->where('pageid', $like->id)->get()->row()->id;
                
                // Otherwise push
                array_push($newLikes, array(
                    'userid' => $userid,
                    'facebookobjectid' => $facebookobjectid,
                    'valid' => 'true',
                    'timestamp' => $timestamp
                ));
            }
        }
        return $newLikes;
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
            
            // Bidirecctional
            array_push($rows, array(
                'userid1' => $ownId->id,
                'userid2' => $friendId->id
           ));
            
            array_push($rows, array(
                'userid2' => $ownId->id,
                'userid1' => $friendId->id
           ));
        }
        
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $this->db->insert('friends', $row);
            }
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
