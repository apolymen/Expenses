<!DOCTYPE html>

<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Input</title>

		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.min.css">

		<style type="text/css">
			.colbox {
				margin-left: 0px;
				margin-right: 0px;
			}
		</style>
	</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-sm-offset-3 col-lg-6 col-sm-6 well">
			<?php
			$attributes = array("class" => "form-horizontal", "id" => "inputform", "name" => "inputform", "autocomplete" => "off");
			echo form_open('input', $attributes); ?>
			<fieldset>

			<div class="form-group">
			<div class="row colbox">
			<div class="col-lg-4 col-sm-4">
				<label for="xDate" class="control-label">Date:</label>
			</div>
			<div class="col-lg-8 col-sm-8">
				<input type="text" name="xDate" id="xDate" placeholder="Date (yyyy-mm-dd)" class="form-control" value="<?php echo set_value('xDate'); ?>" readonly />
				<span class="text-danger"><?php echo form_error('xDate'); ?></span>
			</div>
			</div>
			</div>
			<div class="form-group">
			<div class="row colbox">
			<div class="col-lg-4 col-sm-4">
				<label for="amount" class="control-label">Amount:</label>
			</div>
			<div class="col-lg-8 col-sm-8">
				<input type="number" step="0.01" name="amount" id="amount" placeholder="Amount (max 2 decimals)" class="form-control" value="<?php echo set_value('amount'); ?>" />
				<span class="text-danger"><?php echo form_error('amount'); ?></span>
			</div>
			</div>
			</div>
			<div class="form-group">
			<div class="row colbox">
			<div class="col-lg-4 col-sm-4">
				<label for="person" class="control-label">Person:</label>
			</div>
			<div class="col-lg-8 col-sm-8">
				<?php
					$attributes = 'class="form-control" id="person"';
					echo form_dropdown('person',$persons,set_value('person'),$attributes);?>
				<span class="text-danger"><?php echo form_error('person'); ?></span>
			</div>
			</div>
			</div>
			<div class="form-group">
			<div class="row colbox">
			<div class="col-lg-4 col-sm-4">
				<label for="description" class="control-label">Description:</label>
			</div>
			<div class="col-lg-8 col-sm-8">
				<input type="text" name="description" id="description" placeholder="Short description" class="form-control" value="<?php echo set_value('description'); ?>" />
				<span class="text-danger"><?php echo form_error('description'); ?></span>
			</div>
			</div>
			</div>
			<div class="form-group">
			<div class="row colbox">
			<div class="col-lg-4 col-sm-4">
				<label for="payment" class="control-label">Payment by:</label>
			</div>
			<div class="col-lg-8 col-sm-8">
				<?php
					$attributes = 'class="form-control" id="payment"';
					echo form_dropdown('payment',$paymentmethods,set_value('payment'),$attributes);?>
				<span class="text-danger"><?php echo form_error('payment'); ?></span>
			</div>
			</div>
			</div>
			<div class="form-group">
			<div class="row colbox">
			<div class="col-lg-4 col-sm-4">
				<label for="category" class="control-label">Category:</label>
			</div>
			<div class="col-lg-8 col-sm-8">
				<?php
					$attributes = 'class="form-control" id="category"';
					echo form_dropdown('category',$categories,set_value('category'),$attributes);?>
				<span class="text-danger"><?php echo form_error('category'); ?></span>
			</div>
			</div>
			</div>
			<div class="form-group">
			<div class="col-sm-offset-4 col-lg-8 col-sm-8">
				<button type="submit" class="btn btn-success">Submit</button>
				<button type="button" class="btn btn-danger" onclick="location.href='<?php echo base_url(); ?>main/reset_form	'">Reset</button>
				<button type="button" class="btn btn-primary pull-right" onclick="location.href='<?php echo base_url(); ?>main/last_page'">Main page</button>
			</div>
			</div>

			</fieldset>
			<?php echo form_close(); ?>

			<?php echo $this->session->flashdata('msg'); ?>

			</div>
		</div>
	</div>

	<script src="<?php echo base_url(); ?>assets/js/jquery-2.2.0.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery-ui.min.js"></script>

	<script>
		//load datepicker control onfocus
		$(function () {
			$("#xDate").datepicker({
						dateFormat: "yy-mm-dd",
						firstDay: 1
			});
		});
	</script>
</body>
</html>
