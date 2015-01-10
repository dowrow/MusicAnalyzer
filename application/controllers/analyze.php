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
            $this->load->model('Facebook');
        }
        
        public function index()
        {
            // Set language
            if (strpos($this->Facebook->getLocale(), 'es_') !== false) {
                $this->lang->load('analyze', 'spanish');
            } else {
                $this->lang->load('analyze', 'english');
            }
            
            // Test session
            echo $this->Facebook->getSession();
            
            // Load view
            $this->load->view('analyze');
        }
        
        
}

/* End of file */