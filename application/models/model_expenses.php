<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_expenses extends CI_Model {

	public function __construct() {
		parent::__construct();
        $this->load->database();
	}

	public function get_all_records() {
		$query = $this->db->get('view_all');

		if ($query->num_rows() > 0) {
			return $query;
		}
		else {
			return NULL;
		}
	}
	
	public function add_record($data) {
		$this->db->insert('expdata', $data);
	}

	public function update_record($id, $data) {
		$this->db->where('id', $id);
		$this->db->update('expdata', $data);
	}

}
