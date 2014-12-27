<?php
class Rest extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Stats');
        $this->load->mode('DatabaseManager');
    }
    
    // Default
    public function index() {
        echo 'REST API OK';
    }
    
    // Get stats for given artist
    public function stats() {
        
        // Get parameter
        $parameter = $this->input->get('artist', TRUE);
        if ($parameter == FALSE) {
            echo 'Error. Missig ?artist=URL_ENCODED_ARTIST';
            return;
        }
        
        echo json_encode($this->Stats->getStats($parameter));
    }
    
    // Insert an artist
    public function insertArtist () {
        
        // Get parameters
        $name = $this->input->get('name', TRUE);
        $url = $this->input->get('url', TRUE);
        $image = $this->input->get('image', TRUE);
        
        if ($name == FALSE || $url == FALSE || $image == FALSE) {
            echo 'Missing arguments';
            return;
        }
        
        $this->DatabaseManager->insertArtist($name, $url, $image);
        
        echo 'ok';
    }
    
    // Insert an album
    public function insertAlbum () {
        
        // Get parameters
        $artist = $this->input->get('artist', TRUE);
        $album = $this->input->get('album', TRUE);
        $url = $this->input->get('url', TRUE);
        $date = $this->input->get('date', TRUE);
        
        if ($artist == FALSE || $album == FALSE || $url == FALSE || $date == FALSE) {
            echo 'Missing arguments';
            return;
        }
        
        $this->DatabaseManager->insertAlbum($artist, $album, $url, $date);
        
        echo 'ok';    
    }
    
    // Insert a fan
    public function insertFan () {
       
        // Get parameters
        $artist = $this->input->get('artist', TRUE);
        $album = $this->input->get('album', TRUE);
        $url = $this->input->get('url', TRUE);
        $date = $this->input->get('date', TRUE);
        
        if ($artist == FALSE || $album == FALSE || $url == FALSE || $date == FALSE) {
            echo 'Missing arguments';
            return;
        }
        
        $this->DatabaseManager->insertAlbum($artist, $album, $url, $date);
        
        echo 'ok';     
    }
    
    // Insert a tag
    public function insertTag () {
        
        // Get parameters
        $artist = $this->input->get('artist', TRUE);
        $name = $this->input->get('name', TRUE);
        $url = $this->input->get('url', TRUE);
        
        if ($artist == FALSE || $name == FALSE || $url == FALSE) {
            echo 'Missing arguments';
            return;
        }
        
        $this->DatabaseManager->insertTag($artist, $name, $url);
        
        echo 'ok';     
        
    }
    
    // Insert a similar artist
    public function insertSimilar () {
        
        // Get parameters
        $artist = $this->input->get('artist', TRUE);
        $similar = $this->input->get('similar', TRUE);
        $url = $this->input->get('url', TRUE);
        $image =  $this->input->get('image', TRUE);
        
        if ($artist == FALSE || $similar == FALSE || $url == FALSE || $image == FALSE) {
            echo 'Missing arguments';
            return;
        }
        
        $this->DatabaseManager->insertSimilar($artist, $similar, $url, $image);
        
        echo 'ok';     
    }

    
}
