<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
	array(
			'field' => 'xDate',
			'label' => 'Date',
			'rules' => 'required|callback_date_valid'
	),
	array(
			'field' => 'amount',
			'label' => 'Amount',
			'rules' => 'trim|required'
	),
	array(
			'field' => 'person',
			'label' => 'Person',
			'rules' => 'callback_combo_check'
	),
	array(
			'field' => 'description',
			'label' => 'Description',
			'rules' => 'trim|required|max_length[255]'
	),
	array(
			'field' => 'payment',
			'label' => 'Payment by',
			'rules' => 'callback_combo_check'
	),
	array(
			'field' => 'category',
			'label' => 'Category',
			'rules' => 'callback_combo_check'
	)
);
