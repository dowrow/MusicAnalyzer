<?php
class Prueba extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Modelo');
	}

	public function index()
	{
		$data['videos'] = $this->Modelo->getVideos();
                $this->load->view('prueba', $data);
	}
}