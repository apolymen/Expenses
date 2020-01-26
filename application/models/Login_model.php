<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class login_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    //get the username & password from table 'users'
    function get_user($usr) {
//          $sql = "select * from users where username = '" . $usr . "' and password = '" . $pwd . "' and status = 'active'";
//          $query = $this->db->query($sql);
//          return $query->num_rows();
      $query = $this->db->select('username, password')
              ->where('username', $usr)
              ->where('status', 'active')
              ->get('users');
      return $query;
    }
}?>