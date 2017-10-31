<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Olá ao CodeIgniter</title>
        
        <!-- Adicionando funções bootstrap -->
        
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="<?php echo base_url('ci/includes/bootstrap/css/bootstrap.css'); ?>" >

        <!-- Latest compiled and minified JavaScript -->
        <script src="<?php echo base_url('ci/includes/bootstrap/js/bootstrap.min.js'); ?>"></script>
        
        <?php echo base_url('ci/includes/bootstrap/js/bootstrap.min.js'); ?>
        
        <!--
        http://191.252.51.58/eventos/ci/
        
        includes/bootstrap/css/ -->
        <!-- FIM Adicionando funções bootstrap -->
        
</head>
<body>

<div id="container">
	<h1>Welcome to CodeIgniter!</h1>

        <!-- Single button -->
        <div class="btn-group">
          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Action <span class="caret"></span>
          </button>
          <ul class="dropdown-menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Separated link</a></li>
          </ul>
        </div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
        
        <button type="button" class="btn btn-default" aria-label="Left Align">
            <span class="glyphicon glyphicon-align-left" aria-hidden="true"></span>
        </button>
</div>
   
<div id="container">
    <button type="button" class="btn btn-default" aria-label="Left Align">
      <span class="glyphicon glyphicon-align-left" aria-hidden="true"></span>
    </button>

    <button type="button" class="btn btn-default btn-lg">
      <span class="glyphicon glyphicon-star" aria-hidden="true"></span> Star
    </button>
</div>
    
    
</body>
</html>