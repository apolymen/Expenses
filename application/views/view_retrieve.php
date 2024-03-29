<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Expenses Home</title>

  <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url(); ?>assets/images/expenses32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>assets/images/expenses16.png">

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
  
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
      <div class="col-xs-2">
        <button type="button" class="btn btn-primary" onclick="location.href='<?php echo base_url(); ?>input'">Input</button>
      </div>
      <?php 
      $attributes = array("class" => "form-horizontal", "id" => "searchform", "name" => "searchform", "autocomplete" => "off");
      echo form_open('search', $attributes); ?>
      <div class="col-xs-4">
          <input type="text" class="form-control" id="descr_search" name="descr_search" placeholder="Search description" value="<?php echo set_value('descr_search', $search); ?>" />
          <span class="text-danger"><?php echo form_error('descr_search'); ?></span>
      </div>
      <div class="col-xs-6">
        <button type="submit" class="btn btn-success">Search</button>
        <button type="button" class="btn btn-danger" onclick="location.href='<?php echo base_url(); ?>'">Show all</button>
      </div>
      <?php echo form_close(); ?>
    </div>
    <div class="top-buffer"></div>
    <p>Total entries: <?=$rows?></p>
    <table class="table table-bordered table-condensed table-striped">
      <thead>
        <tr>
          <th>Date</th>
          <th>Amount</th>
          <th>Currency</th>
          <th>Person</th>
          <th>Description</th>
          <th>Payment</th>
          <th>Category</th>
        </tr>
      </thead>
      <tbody>
        <?php if (is_array($expenses)) { ?>
          <?php foreach ($expenses as $row): ?>
          <tr> <td class="hidden"><?=$row->id?></td> <td style="white-space: nowrap;"><?=implode('-', array_reverse(explode('-', $row->Date)))?></td> <td><?=number_format($row->Amount,2)?></td> <td><?=$row->Currency?></td> <td><?=$row->Person?></td> <td><?=$row->Description?></td> <td><?=$row->Method?></td> <td><?=$row->Category?></td> </tr>
          <?php endforeach; ?>
        <?php } ?>
      </tbody>
    </table>

    <div class="row">
      <div class="col-md-12">
        <?php echo $pagination; ?>
      </div>
    </div>

    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
  </div>

  <script src="<?php echo base_url(); ?>assets/js/jquery-2.2.0.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>

  <script>
  $(document).ready(function() {
    $('tbody tr').click( function() {
      var id = $(this).children('td').html();
      bootbox.dialog( {
        title: 'Confirm',
        message: 'Edit this entry?',
        size: 'small',
        animate: 'false',
        onEscape: 'true',
        buttons: {
          OK: {
            label: 'OK',
            className: "btn-primary",
            callback: function() {
              window.location.href = "<?php echo base_url(); ?>edit/" + id;
            }
          },
          Cancel: {
            label: 'Cancel',
            className: "btn-default",
            callback: function() {
              //nothing to do
            }
          }
        }
      });
    });
  });
/*
  $(document).ready(function() {
    $('tbody tr').click( function() {
      var r = confirm("Edit this record?");
      if (r === true) {
        window.location.href = "/expenses/main/edit/" + $(this).children('td').html();
      }
    });
  });
*/
  </script>

</body>
</html>
