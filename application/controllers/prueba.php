<?php
class Prueba extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('LastFM');
    }
    
    public function index() {
        
        $data['artist'] = $this->LastFM->getArtist("Linkin Park");
        $data['tags'] = $this->LastFM->getArtist("Linkin park");
        $data['albums'] = $this->LastFM->getTopAlbums("Linkin Park");
        $data['fans'] = $this->LastFM->getTopFans("Linkin Park");
        $data['similar'] = $this->LastFM->getSimilar("Linkin Park");
        
        $this->load->view("prueba", $data);
    }
}