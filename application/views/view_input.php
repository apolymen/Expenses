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
			<label for="date">Date:</label>
			<input type="text" name="date" id="date" />
		</p>
		<p>
			<label for="amount">Amount:</label>
			<input type="text" name="amount" id="amount" value="<?php echo set_value('amount'); ?>" />
			<span><?php echo form_error('amount'); ?></span>
		</p>
		<p>
			<label for="person">Person:</label>
			<input type="text" name="person" id="person" />
		</p>
		<p>
			<label for="description">Description:</label>
			<input type="text" name="description" id="description" />
		</p>
		<p>
			<label for="payment">Payment by:</label>
			<input type="text" name="payment" id="payment" />
		</p>
		<p>
			<label for="category">Category:</label>
			<input type="text" name="category" id="category" />
		</p>
		<p>
			<input type="submit" value="Submit" />
		</p>
		
		<?php echo form_close(); ?>
    </body>
</html>
