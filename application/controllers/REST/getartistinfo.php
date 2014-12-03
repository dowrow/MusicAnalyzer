<?php
class GetArtistInfo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ArtistManager');
    }
    
    public function index() {
        
        // Get parameter
        $parameter = $this->input->get('artist', TRUE);
        if ($parameter == FALSE) {
            echo 'Error. Missig ?artist=URL_ENCODED_ARTIST';
            return;
        }
        $artist = urldecode($parameter);
        if ($this->ArtistManager->hasLastFM($artist)) {
            $this->ArtistManager->getArtistFromLastFM($artist);
            echo 'Ok';
        } else {
            echo 'No info';
        }
    }
}