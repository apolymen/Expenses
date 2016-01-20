<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct() {
		parent::__construct();
//		$this->session->keep_flashdata('msg');
	}

	public function index() {
		//$this->load->view('view_mainmenu');
		$this->output();
	}

	public function input() {
		$this->load->model('model_expenses');

		$data['persons'] = array(
			'-SELECT-' => '-SELECT-',
			'Απόστολος' => 'Απόστολος',
			'Μαίρη' => 'Μαίρη',
		);

		//fetch data from paymentmethods and categories tables
		$data['paymentmethods'] = $this->model_expenses->get_paymentmethods();
		$data['categories'] = $this->model_expenses->get_categories();

		//set validation rules
		$this->form_validation->set_rules('xDate', 'Date', 'required|callback_date_valid');
		$this->form_validation->set_rules('amount', 'Amount', 'trim|required|regex_match[/^\d+(,\d{1,3})?$/]');
		$this->form_validation->set_rules('person', 'Person', 'callback_combo_check');
		$this->form_validation->set_rules('description', 'Description', 'trim|required|max_length[255]');
		$this->form_validation->set_rules('payment', 'Payment by', 'callback_combo_check');
		$this->form_validation->set_rules('category', 'Category', 'callback_combo_check');

        //check form validation
		if ($this->form_validation->run() == FALSE) {
            //failed validation, reload view. Next line also used for initial view load.
            $this->load->view('view_input', $data);
        }
		else {
			//passed validation, insert record to database
			$data = array(
				'xDate' => $this->input->post('xDate'),
				'Amount' => floatval(str_replace(',', '.', $this->input->post('amount'))),
				'Person' => $this->input->post('person'),
				'Description' => $this->input->post('description'),
				'method_id' => $this->input->post('payment'),
				'category_id' => $this->input->post('category')
			);
			//echo base_url().'<br>';
			//echo 'Data array created<br>';
			//print_r($data);
			$this->model_expenses->add_record($data);

			//display success message
			$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Record added to Database!!!</div>');
			redirect('input');
		}
	}

	//custom date validation function (except leap year)
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

	//custom validation function for dropdown input
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
	
	public function output() {
		$this->load->model('model_expenses');
		$results = $this->model_expenses->get_all_records();
		$data['expenses'] = $results->result();
		$data['rows'] = $results->num_rows();
		$this->load->view('view_retrieve', $data);
	}

}
