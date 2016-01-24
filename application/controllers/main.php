<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('model_expenses');
	}

	public function index() {
		$this->output();
	}

	public function output() {
		$results = $this->model_expenses->get_all_records();
		$data['expenses'] = $results->result();
		$data['rows'] = $results->num_rows();
		$this->load->view('view_retrieve', $data);
	}

	public function input() {
		$data = $this->prepare_dropdowns();

		// Check form validation
		if ($this->form_validation->run() == FALSE) {
			//failed validation, reload view. Also used for initial view load.
			$this->load->view('view_input', $data);
		}
		else {
			// Passed validation, insert record to database
			$data = array(
				'xDate' => $this->input->post('xDate'),
				'Amount' => $this->input->post('amount'),
				'Person' => $this->input->post('person'),
				'Description' => $this->input->post('description'),
				'method_id' => $this->input->post('payment'),
				'category_id' => $this->input->post('category')
			);
			$this->model_expenses->add_record($data);

			// Display success message
			$this->session->set_flashdata('msg', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Record added to database!</strong></div>');
			redirect('input');
		}
	}

	public function edit($exp_id) {
		$data = $this->prepare_dropdowns();
		$result = $this->model_expenses->get_record_by_id($exp_id);
		$data['exp_id'] = $exp_id;
		$data['row'] = $result->row();
		//$this->load->view('view_edit', $data);

		// Check form validation
		if ($this->form_validation->run() == FALSE) {
			//failed validation, reload view. Also used for initial view load.
			$this->load->view('view_edit', $data);
		}
		else {
			// Passed validation, insert record to database
			$data = array(
				'xDate' => $this->input->post('xDate'),
				'Amount' => $this->input->post('amount'),
				'Person' => $this->input->post('person'),
				'Description' => $this->input->post('description'),
				'method_id' => $this->input->post('payment'),
				'category_id' => $this->input->post('category')
			);
			$this->model_expenses->update_record($exp_id, $data);

			// Display success message
			$this->session->set_flashdata('msg', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Record updated in database!</strong></div>');
			redirect('edit/' . $exp_id);
		}
	}

	public function delete($exp_id) {
		$this->model_expenses->delete_record($exp_id);
		redirect('/');
	}

	public function prepare_dropdowns() {
		// Prepare persons static dropdown
		$temp['persons'] = array(
			'-SELECT-' => '-SELECT-',
			'Απόστολος' => 'Απόστολος',
			'Μαίρη' => 'Μαίρη',
		);
		// Fetch data from paymentmethods and categories tables
		$temp['paymentmethods'] = $this->model_expenses->get_paymentmethods();
		$temp['categories'] = $this->model_expenses->get_categories();
		
		return $temp;
	}

	// Custom date validation function (except leap year)
	// Validation not needed if date field is readonly
	function date_valid($str)
	{
		$month = substr($str,5,2);
		$day = substr($str,8,2);

		if (!preg_match("/^2[0-1]\d\d-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])$/", $str)) {
			$this->form_validation->set_message('date_valid', 'Date format should be yyyy-mm-dd');
			return FALSE;
		}
		elseif ($month === "02" and $day >29) {
			$this->form_validation->set_message('date_valid', 'Invalid date!');
			return FALSE;
		}
		elseif ((($month === "04") or ($month === "06") or ($month === "09") or ($month === "11")) and $day >30) {
			$this->form_validation->set_message('date_valid', 'Invalid date!');
			return FALSE;
		}
		else {
			return TRUE;
		}
	}

	// Custom validation function for dropdown input
	function combo_check($str)
	{
		if ($str == '-SELECT-')
		{
			$this->form_validation->set_message('combo_check', 'The {field} field is required.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	public function reset_form() {
		$data = [];
		redirect('input');
	}

}
