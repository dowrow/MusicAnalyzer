<?php 

header("Access-Control-Allow-Origin: *");

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Public interface for REST services
 */
class Rest extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Stats');
        $this->load->model('DatabaseManager');       
    }
    
    /**
     * By default show status text
     */
    public function index() {
        echo 'REST API OK';
    }
    

    
    /**
     * Get the stats of an artist
     * @return type
     */
    public function stats() {
        
        // Get parameter
        $artist = $this->input->get('artist', TRUE);
        $pageid = $this->input->get('pageid', TRUE);
        if ($artist == FALSE ) {
            echo 'Error. Missing ?artist=URL_ENCODED_ARTIST';
            return;
        }
        
        // Add reference to facebookobject 
        $this->DatabaseManager->insertReference($artist, $pageid);
        
        echo json_encode($this->Stats->getStats($artist));
           
    }
    
    /**
     * Insert an artist 
     */    
    public function insertArtist () {
        
        // Get parameters
        $name = $this->input->post('name', TRUE);
        $url = $this->input->post('url', TRUE);
        $image = $this->input->post('image', TRUE);
        $pageid = $this->input->post('pageid', TRUE);
                
        if ($name === FALSE || $url === FALSE || $image === FALSE || $pageid === FALSE) {
            echo 'Missing arguments';
            return;
        }
        
        $this->DatabaseManager->insertArtist($pageid, $name, $url, $image);
        
        echo 'ok';
    }
    
    /**
     * Insert an album
     */
    public function insertAlbum () {
        
        // Get parameters
        $artist = $this->input->post('artist', TRUE);
        $album = $this->input->post('album', TRUE);
        $url = $this->input->post('url', TRUE);
        $date = $this->input->post('date', TRUE);
        
        if ($artist === FALSE || $album === FALSE || $url === FALSE || $date === FALSE) {
            echo 'Missing arguments';
            return;
        }
        
        $this->DatabaseManager->insertAlbum($artist, $album, $url, $date);
        
        echo 'ok';    
    }
    
    /**
     *  Insert a fan
     */
    public function insertFan () {
       
        // Get parameters
        $artist = $this->input->post('artist', TRUE);
        $age = $this->input->post('age', TRUE);
        $url = $this->input->post('url', TRUE);
        
        if ($artist === FALSE || $age === FALSE || $url === FALSE) {
            echo 'Missing arguments';
            return;
        }
        
        $this->DatabaseManager->insertFan($artist, $age, $url);
        
        echo 'ok';     
    }
    
    /**
     * Insert a tag
     */
    public function insertTag () {
        
        // Get parameters
        $artist = $this->input->post('artist', TRUE);
        $name = $this->input->post('name', TRUE);
        $url = $this->input->post('url', TRUE);
        
        if ($artist === FALSE || $name === FALSE || $url === FALSE) {
            echo 'Missing arguments';
            return;
        }
        
        $this->DatabaseManager->insertTag($artist, $name, $url);
        
        echo 'ok';     
        
    }
    
    /**
     * Insert a similar artist
     */
    public function insertSimilar () {
        
        // Get parameters
        $artist = $this->input->post('artist', TRUE);
        $similar = $this->input->post('similar', TRUE);
        $url = $this->input->post('url', TRUE);
        $image =  $this->input->post('image', TRUE);
        
        if ($artist === FALSE || $similar === FALSE || $url === FALSE || $image === FALSE) {
            echo 'Missing arguments';
            return;
        }
        
        $this->DatabaseManager->insertSimilar($artist, $similar, $url, $image);
        
        echo 'ok';     
    }

}
