<?php
class Rest extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Stats');
        $this->load->model('DatabaseManager');
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
        $name = $this->input->post('name', TRUE);
        $url = $this->input->post('url', TRUE);
        $image = $this->input->post('image', TRUE);
        $facebookObjectId = $this->input->post('facebookObjectId', TRUE);
        
        if ($name == FALSE || $url == FALSE || $image == FALSE || $facebookObjectId == FALSE) {
            echo 'Missing arguments';
            return;
        }
        
        $this->DatabaseManager->insertArtist($facebookObjectId, $name, $url, $image);
        
        echo 'ok';
    }
    
    // Insert an album
    public function insertAlbum () {
        
        // Get parameters
        $artist = $this->input->post('artist', TRUE);
        $album = $this->input->post('album', TRUE);
        $url = $this->input->post('url', TRUE);
        $date = $this->input->post('date', TRUE);
        
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
        $artist = $this->input->post('artist', TRUE);
        $age = $this->input->post('age', TRUE);
        $url = $this->input->post('url', TRUE);
        
        if ($artist == FALSE || $age == FALSE || $url == FALSE) {
            echo 'Missing arguments';
            return;
        }
        
        $this->DatabaseManager->insertFan($artist, $age, $url);
        
        echo 'ok';     
    }
    
    // Insert a tag
    public function insertTag () {
        
        // Get parameters
        $artist = $this->input->post('artist', TRUE);
        $name = $this->input->post('name', TRUE);
        $url = $this->input->post('url', TRUE);
        
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
        $artist = $this->input->post('artist', TRUE);
        $similar = $this->input->post('similar', TRUE);
        $url = $this->input->post('url', TRUE);
        $image =  $this->input->post('image', TRUE);
        
        if ($artist == FALSE || $similar == FALSE || $url == FALSE || $image == FALSE) {
            echo 'Missing arguments';
            return;
        }
        
        $this->DatabaseManager->insertSimilar($artist, $similar, $url, $image);
        
        echo 'ok';     
    }

    
}
