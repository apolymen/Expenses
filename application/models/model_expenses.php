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

	//get paymentmethods table to populate the "Payment by" dropdown
    function get_paymentmethods()     
    { 
        $this->db->select('id');
        $this->db->select('Method');
        $this->db->from('paymentmethods');
        $query = $this->db->get();
        $result = $query->result();

        //array to store paymentmethod id & paymentmethod name
        $pay_id = array('-SELECT-');
        $pay_name = array('-SELECT-');

        for ($i = 0; $i < count($result); $i++)
        {
            array_push($pay_id, $result[$i]->id);
            array_push($pay_name, $result[$i]->Method);
        }
        return $paymentmethods_result = array_combine($pay_id, $pay_name);
    }

	//get categories table to populate the Category dropdown
    function get_categories()     
    { 
        $this->db->select('id');
        $this->db->select('Name');
        $this->db->from('categories');
        $query = $this->db->get();
        $result = $query->result();

        //array to store category id & category name
        $cat_id = array('-SELECT-');
        $cat_name = array('-SELECT-');

        for ($i = 0; $i < count($result); $i++)
        {
            array_push($cat_id, $result[$i]->id);
            array_push($cat_name, $result[$i]->Name);
        }
        return $categories_result = array_combine($cat_id, $cat_name);
    }

}
