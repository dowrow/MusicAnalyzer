<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Start extends CI_Controller {

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
            $this->load->model('Facebook');
            $this->load->library('session');
        }
        
        private function storeLocale () {

            // Set language
            if (strpos($this->Facebook->getLocale(), 'es_') !== false) {
                $this->session->set_userdata('locale', 'spanish');
            } else {
                $this->session->set_userdata('locale', 'english');
            }
        }
        
        public function index()
        {
            $this->storeLocale();
            
            // Set language
            $this->lang->load('start', $this->session->userdata('locale'));
            $this->load->view('start');
        }
        
        
}

/* End of file */