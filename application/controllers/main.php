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
		$this->form_validation->set_rules('xDate', 'Date', 'required|callback_date_valid');
		$this->form_validation->set_rules('amount', 'Amount', 'trim|required|regex_match[/^\d+(,\d{1,3})?$/]');
		$this->form_validation->set_rules('description', 'Description', 'trim|required|max_length[255]');

        if ($this->form_validation->run() == FALSE) {
            //fail validation
            $this->load->view('view_input');
        }
		else {
			//pass validation
			$amount = $this->input->post('amount');
			$val = floatval(str_replace(',', '.', $amount));
			echo "Success<br>Amount: " . $amount . " --> " . $val;
			echo "<br>Date: " . $this->input->post('xDate');
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
