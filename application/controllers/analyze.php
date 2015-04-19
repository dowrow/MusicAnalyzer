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
            $this->load->model('Stats');
        }
        
        private function storeUserInfo() {
            
            // Get current user id
            $userid = $this->Facebook->getUserid();
            
            // If no user id, try login again
            if ($userid == "") {
                header('Location: /');
            }
            
            // Get all likes pageids
            $pageids = $this->Facebook->getLikesPageids();
            
            // Get friends ids
            $friends = $this->Facebook->getFriends();
                    
            // Insert in DB
            $this->DatabaseManager->insertLikes($userid, $pageids);
            $this->DatabaseManager->insertFriends($userid, $friends);
            
            echo $this->Stats->getFriendStats($userid);
        }
        
        public function index()
        {
            // Store user likes
            $this->storeUserInfo();
        }
        
        
}

/* End of file */