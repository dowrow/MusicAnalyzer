<?php
class Modelo extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        public function getVideos()
        {
            $query = $this->db->get('videos');
            return $query->result_array();
        }
}
