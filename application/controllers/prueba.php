x<?php
class Prueba extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('LastFM');
        $this->load->model('ArtistManager');
        $this->load->model('Artist_model');
    }
    
    public function index() {
        
        $artistNames = array();
        
        array_push($artistNames, "Linkin Park");
        array_push($artistNames, "Za!");
        array_push($artistNames, "Alt-j");
        array_push($artistNames, "Jagwar Ma");
        array_push($artistNames, "Jack Conte");
        
        foreach ($artistNames as $artist) {
            if ($this->ArtistManager->hasLastFM($artist)) {
                $obj = $this->ArtistManager->getArtist($artist);
                $fanAverageAge = $obj->getFansAge();
                $similarArtists = $obj->getSimilarArtists();
                $styles = $obj->getStyles();
                $musicalYeah = $obj->getMusicalYear();   
            }
        }
        
        
        $data['artist'] = $this->LastFM->getArtist("Linkin Park");
        $data['tags'] = $this->LastFM->getArtist("Linkin park");
        $data['albums'] = $this->LastFM->getTopAlbums("Linkin Park");
        $data['fans'] = $this->LastFM->getTopFans("Linkin Park");
        $data['similar'] = $this->LastFM->getSimilar("Linkin Park");
        
       // $data['all'] = $this->Artist->probar();
        $this->Artist_model->insert(array(
            'name' => 'Linkin Park'
        ));
        $this->load->view("prueba", $data);
    }
}