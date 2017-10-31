<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Agenda de Festas</title>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="<?php echo base_url('ci/includes/bootstrap/css/bootstrap.css'); ?>" >

  
         <?php get_header(); ?>       
    </head>
    
    <body>
        <!-- Desnecessário. Já está carregando o .11 no head  <script type="text/javascript" src="js/vendor/jquery-1.9.1.js"></script> -->
        <div class="row">
            <div class="col-md-5 col-md-offset-1">
                <h3> Erro de Autenticação </h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-md-offset-1">
                <p> O token gerado é <strong>inválido</strong> ou já <strong>expirou</strong>. Por favor <a href="http://www.eventosbacacheri.com.br/eventos/ci/">faça um novo agendamento</a> </p>
            </div>
        </div>
        
        <?php get_footer(); ?>
    </body>
</html>
