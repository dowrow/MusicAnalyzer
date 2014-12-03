<?php
class Rest extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ArtistManager');
    }
    
    public function index() {
        echo 'REST API OK';
    }
    
    public function GetArtistInfo () {
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
    public function GetTagsInfo () {
        
        // Get parameter
        $parameter = $this->input->get('artist', TRUE);
        if ($parameter == FALSE) {
            echo 'Error. Missig ?artist=URL_ENCODED_ARTIST';
            return;
        }
        $artist = urldecode($parameter);
        if ($this->ArtistManager->hasLastFM($artist)) {
            $this->ArtistManager->getTagsFromLastFM($artist);
            echo 'Ok';
        } else {
            echo 'No info';
        }
    }
    public function GetAlbumsInfo () {
        
        // Get parameter
        $parameter = $this->input->get('artist', TRUE);
        if ($parameter == FALSE) {
            echo 'Error. Missig ?artist=URL_ENCODED_ARTIST';
            return;
        }
        $artist = urldecode($parameter);
        if ($this->ArtistManager->hasLastFM($artist)) {
            $this->ArtistManager->getAlbumsFromLastFM($artist);
            echo 'Ok';
        } else {
            echo 'No info';
        }
    }
    public function GetFansInfo () {
        
        // Get parameter
        $parameter = $this->input->get('artist', TRUE);
        if ($parameter == FALSE) {
            echo 'Error. Missig ?artist=URL_ENCODED_ARTIST';
            return;
        }
        $artist = urldecode($parameter);
        if ($this->ArtistManager->hasLastFM($artist)) {
            $this->ArtistManager->getFansFromLastFM($artist);
            echo 'Ok';
        } else {
            echo 'No info';
        }
    }
    public function GetSimilarsInfo() {
        
        // Get parameter
        $parameter = $this->input->get('artist', TRUE);
        if ($parameter == FALSE) {
            echo 'Error. Missig ?artist=URL_ENCODED_ARTIST';
            return;
        }
        $artist = urldecode($parameter);
        if ($this->ArtistManager->hasLastFM($artist)) {
            $this->ArtistManager->getSimilarFromLastFM($artist);
            echo 'Ok';
        } else {
            echo 'No info';
        }
    }
    
}
