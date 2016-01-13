<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		//$this->load->view('view_mainmenu');
		$this->output();
	}

	public function input() {
		$this->load->model('model_expenses');
        
		//set validation rules
		$this->form_validation->set_rules('amount', 'Amount', 'trim|required|regex_match[/^[0-9]+,[0-9]+$/]');
		$this->form_validation->set_rules('description', 'Description', 'trim');

        if ($this->form_validation->run() == FALSE) {
            //fail validation
            $this->load->view('view_input');
        }
		else {
			//pass validation
            echo "Success<br>";
			echo print_r($this->input->post('amount'))."<br>";
			echo print_r($this->input->post('description'));
        }
	}

	public function create() {
		$data = array(
			'xDate' => $this->input->post('date'),
			'Amount' => $this->input->post('amount'),
			'Person' => $this->input->post('person'),
			'Description' => $this->input->post('description'),
			'method_id' => $this->input->post('payment'),
			'category_id' => $this->input->post('category')
		);
		echo 'Data array created<br>';
		print_r($data);
		//$this->model_expenses->add_record($data);
	}

	public function output() {
		$this->load->model('model_expenses');
		$results = $this->model_expenses->get_all_records();
		$data['expenses'] = $results->result();
		$data['rows'] = $results->num_rows();
		$this->load->view('view_retrieve', $data);
	}

}
