<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Expenses Home</title>

	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

	<style type="text/css">
	p.footer {
		text-align: right;
		font-size: 11px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	.top-buffer {
		margin-top:10px;
	}
	</style>

</head>
<body>

    <div class="container">

	<div class="row top-buffer">
	<div class="col-xs-1">
		 <button type="button" class="btn btn-primary btn-lg" onclick="location.href='/expenses/input'">Input</button>
	</div>
	</div>
	<div class="top-buffer"></div>

    <p style="font-size: 14px;">Total entries: <?=$rows?></p>
	
	<table class="table table-bordered table-condensed table-striped">
	    <thead>
	      <tr>
		<th>Date</th>
		<th>Amount</th>
		<th>Person</th>
		<th>Description</th>
		<th>Payment</th>
		<th>Category</th>
	      </tr>
	    </thead>
	    <tbody>

	    <?php foreach ($expenses as $row): ?>
		<tr> <td><?=$row->Date?></td> <td><?=$row->Amount?></td> <td><?=$row->Person?></td> <td><?=$row->Description?></td> <td><?=$row->Method?></td> <td><?=$row->Category?></td> </tr>
	    <?php endforeach; ?>

	    </tbody>
	</table>

    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

</body>
</html>