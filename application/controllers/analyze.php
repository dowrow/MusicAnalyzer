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
            // Load locale strings
            $this->lang->load('start', $this->session->userdata('locale'));
        }
        
        private function storeUserInfo() {
            
            // Get current user id
            $userid = $this->Facebook->getUserid();
            
            // If no user id, try login again
            if ($userid == "") {
                echo "[]";
            }
            
            // Get all likes pageids
            $likes = $this->Facebook->getLikes();
            
            // Get friends ids
            $friends = $this->Facebook->getFriends();
                    
            // Insert in DB
            $this->DatabaseManager->insertLikes($userid, $likes);
            $this->DatabaseManager->insertFriends($userid, $friends);
            
            echo json_encode($this->Stats->getFriendStats($userid));
        }
        
        private function notifyFriends () {
           
            $message = $this->lang->line('notification_message');
            
            foreach ($this->Facebook->getFriends() as $friendId) {
                $text = "@[" . $this->Facebook->getUserid() . "] " . $message;
                $href = "/";
                $this->Facebook->sendNotification($friendId, $text, $href);
            }
        }
        
        public function index()
        {
            // Store user likes & friends
            $this->storeUserInfo();
            //$this->notifyFriends();
        }
        
        
}

/* End of file */