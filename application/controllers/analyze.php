<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Analyze extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
        public function __construct() {
            parent::__construct();
            $this->load->library('session');
            $this->load->model('Facebook');
            $this->load->model('DatabaseManager');

        }
        
        private function storeUserLikes() {
            
            // Get current user id
            $userid = $this->Facebook->getUserid();
            
            // If no user id, try login again
            if ($userid == "") {
                header('Location: https://apps.facebook.com/music-analyzer');
            }
            
            // Get all likes pageids
            $pageids = $this->Facebook->getLikesPageids();
                        
            // Insert in DB
            $this->DatabaseManager->insertLikes($userid, $pageids);
            
        }
        
        public function index()
        {
            // Set language
            $this->lang->load('analyze', $this->session->userdata('locale'));
            
            // Store user likes
            $this->storeUserLikes();
            
            // Load view
            $this->load->view('analyze');
        }
        
        
}

/* End of file */