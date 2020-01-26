<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Login extends CI_Controller
{

     public function __construct()
     {
          parent::__construct();
          $this->load->helper('html');
          $this->load->helper('security');
          //load the login model
          $this->load->model('login_model');
     }

     public function index()
     {
          //get the posted values
          $username = $this->input->post("txt_username");
          $password = $this->input->post("txt_password");

          //set validations
          $this->form_validation->set_rules("txt_username", "Username", "trim|required");
          $this->form_validation->set_rules("txt_password", "Password", "trim|required");

          if ($this->form_validation->run() == FALSE) {
            //validation fails
            $this->load->view('login_view');
          }
          else {
            //validation succeeds
                //check if username exists and is active
                $usr_result = $this->login_model->get_user($username);
                if ($usr_result->num_rows() > 0) {  //active user record is present
                  $temp = $usr_result->row();
                  $hash = $temp->password;  //get password hash from database
                  if (password_verify($password, $hash)) {  //verify given password with against stored hash
                    //password verified, set the session variables
                    $sessiondata = array(
                      'username' => $username,
                      'loginuser' => TRUE
                    );
                    $this->session->set_userdata($sessiondata);
                    redirect('main/index');
                  }
                  else {
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid username or password! </div>');
                    redirect('login/index');
                  }
                }
                else {
                  $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid username or password! </div>');
                  redirect('login/index');
                }
          }
     }
}
