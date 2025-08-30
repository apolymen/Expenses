<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// First letter of Main class and corresponding filename must be capital!
class Main extends CI_Controller {

	public function __construct() {
		parent::__construct();

// Restrict access only to logged in users
    if(!$this->session->username){
      redirect('login/index');
    }

 		$this->load->model('model_expenses');
  //$this->output->enable_profiler(TRUE);
	}

	public function index() {
	// Comment/Uncomment next 2 lines accordingly

//		$this->output(); // load first page of table
		$this->last_page(); // load last page of table
	}

	public function last_page() {
		$last = ceil($this->db->count_all('expdata') / $this->config->item('per_page'));
		// PHP dot operator used to concatenate strings
		redirect('output/' . $last);
	}

	public function output() {
		// CI pagination settings
		$config['base_url'] = site_url('output');
		$config['per_page'] = $this->config->item('per_page'); //defined in main config
		$config['num_links'] = 2;
		$config['uri_segment'] = 2;
		$config['use_page_numbers'] = True;

		//config for bootstrap pagination class integration
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = "First";
		$config['last_link'] = "Last";
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo';
		$config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '&raquo';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		$data['rows'] = $this->db->count_all('expdata');
		$config['total_rows'] = $data['rows'];
		$data['per_page'] = $config['per_page'];

		$data['currentpage'] = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
		$results = $this->model_expenses->get_records(max(0,($data['currentpage']-1))*$config['per_page'], $config['per_page'], 'NIL');
		$data['expenses'] = $results->result();
    	$data['search'] = '';

		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

		$this->load->view('view_retrieve', $data);
	}

	public function search() {
	    // If empty search string AND this is the first call, redirect to start
	    if ($this->input->post('descr_search') == '' && ! $this->uri->segment(2)) {
	      redirect('/');
	    }

      // Get search string either from form POST (first call) or from URI (subsequent calls due to pagination)
	    $searchenc = ($this->uri->segment(2)) ? $this->uri->segment(2) : $this->input->post('descr_search');

      // URLdecode search string for Greek support
	    $search = urldecode($searchenc);

      // If non empty search string AND this is the first call, redirect to last page of search results
	    if ($this->input->post('descr_search') != '' && ! $this->uri->segment(2)) {
	      $last = ceil($this->model_expenses->get_records_count($search) / $this->config->item('per_page'));
        redirect("search/$search/" . $last);
	    }

      // CI pagination settings
	    $config['base_url'] = site_url("search/$search");
	    $config['per_page'] = $this->config->item('per_page'); //defined in main config
	    $config['num_links'] = 2;
	    $config['uri_segment'] = 3;
	    $config['use_page_numbers'] = True;

	    //config for bootstrap pagination class integration
	    $config['full_tag_open'] = '<ul class="pagination">';
	    $config['full_tag_close'] = '</ul>';
	    $config['first_link'] = "First";
	    $config['last_link'] = "Last";
	    $config['first_tag_open'] = '<li>';
	    $config['first_tag_close'] = '</li>';
	    $config['prev_link'] = '&laquo';
	    $config['prev_tag_open'] = '<li class="prev">';
	    $config['prev_tag_close'] = '</li>';
	    $config['next_link'] = '&raquo';
	    $config['next_tag_open'] = '<li>';
	    $config['next_tag_close'] = '</li>';
	    $config['last_tag_open'] = '<li>';
	    $config['last_tag_close'] = '</li>';
	    $config['cur_tag_open'] = '<li class="active"><a href="#">';
	    $config['cur_tag_close'] = '</a></li>';
	    $config['num_tag_open'] = '<li>';
	    $config['num_tag_close'] = '</li>';

	    $data['rows'] = $this->model_expenses->get_records_count($search);
	    $config['total_rows'] = $data['rows'];
	    $data['per_page'] = $config['per_page'];

	    $data['currentpage'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
	    $results = $this->model_expenses->get_records(max(0,($data['currentpage']-1))*$config['per_page'], $config['per_page'], $search);
		//var_dump($search,$results);
	    // Check for empty result set
	    $data['expenses'] = (! is_null($results)) ? $results->result() : '';
	    $data['search'] = $search;

	    $this->pagination->initialize($config);
	    $data['pagination'] = $this->pagination->create_links();

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
				'category_id' => $this->input->post('category'),
				'currency_id' => $this->input->post('currency')
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
				'category_id' => $this->input->post('category'),
				'currency_id' => $this->input->post('currency')
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
			'Ελεάνα' => 'Ελεάνα'
		);
		// Fetch data from paymentmethods and categories tables
		$temp['paymentmethods'] = $this->model_expenses->get_paymentmethods();
		$temp['categories'] = $this->model_expenses->get_categories();
		$temp['currencies'] = $this->model_expenses->get_currencies();

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
