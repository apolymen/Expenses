<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// First letter of Model class and corresponding filename must be capital!
class Model_expenses extends CI_Model {

  public function __construct() {
    parent::__construct();
        $this->load->database();
  }

  public function get_records($start, $limit, $st = NULL) {
//    $query = $this->db->get('view_all');
    if ($st == "NIL") $st = "";
    $query = $this->db->select ('expdata.id AS id, xDate AS Date, Amount AS Amount, Person AS Person, Description AS Description')
            ->select ('paymentmethods.Method AS Method')
            ->select ('categories.Name AS Category')
            ->select ('currencies.currency AS Currency')
            ->join ('paymentmethods',  'expdata.method_id = paymentmethods.id')
            ->join ('categories', 'expdata.category_id = categories.id')
            ->join ('currencies', 'expdata.currency_id = currencies.id')
            ->like ('Description', $st)
            ->or_like ('xDate', $st)
            ->order_by ('xDate ASC, id ASC')
            ->limit($limit, $start)
            ->get('expdata');

    if ($query->num_rows() > 0) {
      return $query;
    }
    else {
      return NULL;
    }
  }

  public function get_records_count($st = NULL) {
    if ($st == "NIL") $st = "";
    $query = $this->db->like ('Description', $st)
                      ->or_like ('xDate', $st)
                      ->get('expdata');
    return $query->num_rows();
  }

  public function get_record_by_id($exp_id) {
    $query = $this->db->select('expdata.id, expdata.xDate, expdata.amount, expdata.person, expdata.description')
            ->select('method_id AS payment, category_id AS category, currency_id AS currency')
            ->where('expdata.id', $exp_id)
            ->get('expdata');
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

  public function delete_record($id) {
    $this->db->where('id', $id);
    $this->db->delete('expdata');
  }

  // Get paymentmethods table to populate the "Payment by" dropdown
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

  // Get categories table to populate the Category dropdown
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
  
  // Get currencies table to populate the Currency dropdown
    function get_currencies()
    {
        $this->db->select('id');
        $this->db->select('currency');
        $this->db->from('currencies');
        $query = $this->db->get();
        $result = $query->result();

        //array to store currency id & currency name
        $curr_id = array('-SELECT-');
        $curr_name = array('-SELECT-');

        for ($i = 0; $i < count($result); $i++)
        {
            array_push($curr_id, $result[$i]->id);
            array_push($curr_name, $result[$i]->currency);
        }
        return $currencies_result = array_combine($curr_id, $curr_name);
    }

}
