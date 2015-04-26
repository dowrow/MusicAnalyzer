<?php

/**
 * Stats
 *
 * @author Diego
 */
class Stats extends CI_Model {
    
   
    /*
     * Constructor
     */
    public function __construct() {
        parent::__construct();
         $this->load->model('Facebook');
    }
    
    /*
     * Returns JSON with friendsStats
     */
    public function getFriendStats ($userid) {
        
        $friendStats = array();
    
        // Get user friends
       $friends = $this->Facebook->getFriends();
                    
        // For each friend get its full name and get musical age
        foreach ($friends as $friend) {
            array_push($friendStats, array(
                'name' => $this->Facebook->getName($friend),
                'value' => $this->getMusicalAge($friend)
           ));
        }
                
        return $friendStats;
    }
    
    
    public function getMusicalAge ($userid) {
        /*
         * SELECT AVG(age) 
                FROM
                        Users AS U,
                        Likes AS L,
                        FacebookObjects as FO,
                        Artists AS A,
                        ArtistFans AS AF,
                        Fans AS F
                WHERE
                        U.userid = '10152333894445777' AND
                        L.userid = U.id AND
                        L.facebookobjectid = FO.id AND
                        A.facebookobjectid = FO.id AND
                        AF.artistid = A.id AND
                        AF.fanid = F.id;
         */
        $this->db->select_avg('age');
        $this->db->from('users');
        $this->db->join('likes', 'users.id = likes.userid');
        $this->db->join('facebookobjects', 'likes.facebookobjectid = facebookobjects.id');
        $this->db->join('artists', 'facebookobjects.id = artists.facebookobjectid');
        $this->db->join('artistfans', 'artists.id = artistfans.artistid');
        $this->db->join('fans', 'artistfans.fanid = fans.id');
        $this->db->where('users.userid', $userid);
        $query = $this->db->get();
        if ($query) {
            return $query->result();
        } else {
            return 0;
        }
        
    }
        
    /*
     * Returns JSON string with stats
     * 0 if not in fb
     */
    public function getStats ($artist) {
        
        // 0 -> Error code for "NOT IN DB"
        if (!$this->isInDB($artist)) {
            return 0;
        }
        
        // 1 -> Error code for "DOESN'T HAVE LASTFM INFO"
        if (!$this->hasLastFM($artist)) {
            return 1;
        }
        
        $averageFanAge = $this->getAverageFanAge($artist);
        $firstAlbum = $this->getFirstAlbum($artist);
        $similar = $this->getSimilar($artist);
        $tags = $this->getTags($artist);
        
        $stats = (object) array(
            'averageFanAge' => $averageFanAge,
            'firstAlbum' => $firstAlbum,
            'similar' => $similar,
            'tags' => $tags
        );
        
        return $stats;
    }
    
    private function hasLastFM ($artist) {
        $this->db->select('*');
        $this->db->from('artists');
        $this->db->join('lastfmartists', 'artists.lastfmartistid = lastfmartists.id');
        $this->db->like('LOWER(artists.name)', strtolower($artist));
        $query = $this->db->get();
        return count($query->result()) != 0;
    }
    
    private function isInDB ($artist) {
        $this->db->select('*');
        $this->db->from('artists');
        $this->db->like('LOWER(artists.name)', strtolower($artist));
        $query = $this->db->get();
        return count($query->result()) != 0;
    }
    
    private function getAverageFanAge ($artist) {
        $sum = 0;
        
        $this->db->select('fans.age');
        $this->db->from('artistfans');
        $this->db->join('fans', 'artistfans.fanid = fans.id');
        $this->db->join('artists', 'artistfans.artistid = artists.id');
        $this->db->like('LOWER(artists.name)', strtolower($artist));
        $query = $this->db->get();
        
        if (count($query->result()) == 0) {
            return -1;
        }
        
        $total = 0;
        foreach ($query->result() as $row) {
            if ($row->age > 0 && $row->age < 100) {
                $sum += $row->age;
                $total++;
            }            
        }
        return ($sum / $total);
    }
    
    private function getFirstAlbum ($artist) {
        
        $this->db->select('albums.*');
        $this->db->from('albums');
        $this->db->join('artists', 'albums.artistid = artists.id');
        $this->db->like('LOWER(artists.name)', strtolower($artist));
        $this->db->order_by('date', 'asc');
        $this->db->limit(1);        
        $query = $this->db->get();
        return $query->result();
        
    }
    
    private function getSimilar ($artist) {
        $this->db->select('a2.*');
        $this->db->from('similarartists');
        $this->db->join('artists AS a1', 'similarartists.artistid1 = a1.id');
        $this->db->join('artists AS a2', 'similarartists.artistid2 = a2.id');
        $this->db->like('LOWER(a1.name)', strtolower($artist));
        $query = $this->db->get();
        return $query->result();
    }
    
    private function getTags ($artist) {
        $this->db->select('tags.name');
        $this->db->from('artisttags');
        $this->db->join('artists', 'artisttags.artistid = artists.id');
        $this->db->join('tags', 'artisttags.tagid = tags.id');
        $this->db->like('LOWER(artists.name)', strtolower($artist));
        $query = $this->db->get();
        return $query->result();
    }
 
}
    