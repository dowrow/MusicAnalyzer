<?php
class Prueba extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('modelo');
	}

	public function index()
	{
		$data['videos'] = $this->modelo->getVideos();
                $this->load->view('prueba', $data);
	}
}