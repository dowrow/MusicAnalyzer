<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(__DIR__.'/../models/MusicFactory.php');

class Music extends CI_Controller {

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
	public function index()
	{
            // Pass array of artists to view
            $data['artists'] = MusicFactory::getArtists();
	    $this->load->view('music', $data);
	}
}

/* End of file music.php */
/* Location: ./application/controllers/music.php */