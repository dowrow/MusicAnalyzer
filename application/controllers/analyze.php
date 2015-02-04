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
            
            // Get current user
            $user = $this->Facebook->getUser();
            
            // Get all likes
            $pages = $this->Facebook->getLikes();
            
            // Extract its page ids
            $pageids = array();
            foreach ($pages as $page) {
                array_push($pageids, $page->id);
            }
            
            // Insert in DB
            $this->DatabaseManager->insertLikes($user->id, $pageids);
            
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