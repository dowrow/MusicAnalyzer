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
        
    }
    
    // Insert an album
    public function insertAlbum () {
        
    }
    
    // Insert a fan
    public function insertFan () {
        
    }
    
    // Insert a tag
    public function insertTag () {
        
    }
    
    // Insert a similar artist
    public function insertSimilar () {
        
    }

    
}
