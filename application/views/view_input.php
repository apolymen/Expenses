<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Input</title>
		<style type="text/css" media="screen">
			   label {display: block;}
		</style>
    </head>
    <body>
		<h2>Create</h2>
		<?php echo form_open('input'); ?>

		<p>
			<label for="xDate">Date:</label>
			<input type="text" name="xDate" id="xDate" placeholder="Input date" value="<?php echo set_value('xDate'); ?>" />
			<span><?php echo form_error('xDate'); ?></span>
		</p>
		<p>
			<label for="amount">Amount:</label>
			<input type="text" name="amount" id="amount" placeholder="Amount (max 3 decimals)" value="<?php echo set_value('amount'); ?>" />
			<span><?php echo form_error('amount'); ?></span>
		</p>
		<p>
			<label for="person">Person:</label>
			<input type="text" name="person" id="person" value="<?php echo set_value('person'); ?>" />
		</p>
		<p>
			<label for="description">Description:</label>
			<input type="text" name="description" id="description" placeholder="Short description" value="<?php echo set_value('description'); ?>" />
			<span><?php echo form_error('description'); ?></span>
		</p>
		<p>
			<label for="payment">Payment by:</label>
			<input type="text" name="payment" id="payment" value="<?php echo set_value('payment'); ?>" />
		</p>
		<p>
			<label for="category">Category:</label>
			<input type="text" name="category" id="category" value="<?php echo set_value('category'); ?>" />
		</p>
		<p>
			<input type="submit" value="Submit" />
		</p>
		
		<?php echo form_close(); ?>
    </body>
</html>
