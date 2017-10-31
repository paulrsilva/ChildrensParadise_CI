<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Confirmar Agenda de Eventos - Children's Paradise</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url('ci/includes/bootstrap/css/bootstrap.css'); ?>" >
        
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Montserrat">
        
        <style type="text/css">
            
            .spacer { margin:0; padding:0; height:50px; }
            
            .caixa-confirmacao {
              background-color: hsla(255,0%,0%,0.1);
              width: 400px;
              position: relative;  
              color:white;
              padding-left: 10px;
            }
            .titulo_body {
              color:white;              
            }
          .quote-container {
            margin-top: 50px;
            position: relative;
          }

          .note {
            color: #333;
            position: relative;
            width: 250px;
            margin: 0 auto;
            padding: 20px;
            font-family: Montserrat;
            font-size: 12px;
            box-shadow: 0 10px 10px 2px rgba(0,0,0,0.3);
          }

          .note .author {
            display: block;
            margin: 40px 0 0 0;
            text-align: right;
          }
          
          .yellow {
            background: #eae672;
            -webkit-transform: rotate(2deg);
            -moz-transform: rotate(2deg);
            -o-transform: rotate(2deg);
            -ms-transform: rotate(2deg);
            transform: rotate(2deg);
          }
          
          .pin {
            background-color: #aaa;
            display: block;
            height: 32px;
            width: 2px;
            position: absolute;
            left: 50%;
            top: -16px;
            z-index: 1;
          }
          
          .pin:after {
            background-color: #A31;
            background-image: radial-gradient(25% 25%, circle, hsla(0,0%,100%,.3), hsla(0,0%,0%,.3));
            border-radius: 50%;
            box-shadow: inset 0 0 0 1px hsla(0,0%,0%,.1),
                        inset 3px 3px 3px hsla(0,0%,100%,.2),
                        inset -3px -3px 3px hsla(0,0%,0%,.2),
                        23px 20px 3px hsla(0,0%,0%,.15);
            content: '';
            height: 12px;
            left: -5px;
            position: absolute;
            top: -10px;
            width: 12px;
          }
          
          .pin:before {
            background-color: hsla(0,0%,0%,0.1);
            box-shadow: 0 0 .25em hsla(0,0%,0%,.1);
            content: '';

            height: 24px;
            width: 2px;
            left: 0;
            position: absolute;
            top: 8px;

            transform: rotate(57.5deg);
            -moz-transform: rotate(57.5deg);
            -webkit-transform: rotate(57.5deg);
            -o-transform: rotate(57.5deg);
            -ms-transform: rotate(57.5deg);

            transform-origin: 50% 100%;
            -moz-transform-origin: 50% 100%;
            -webkit-transform-origin: 50% 100%;
            -ms-transform-origin: 50% 100%;
            -o-transform-origin: 50% 100%;
          }            
        </style>

        <?php get_header(); ?>   
    </head>
    <?php include_once("../analyticstracking.php") ?>
    <body>
       
       <ol class="breadcrumb">
           <li><a href="http://www.eventosbacacheri.com.br/eventos/ci/">Agenda</a></li>
            <li><a href="#">Datas</a></li>
            <li><a href="http://www.eventosbacacheri.com.br/eventos/ci/">Reservar Salão</a></li>
            <li><a href="http://www.eventosbacacheri.com.br/eventos/ci/confirma_agenda">Confirmar Reserva</a></li>
            <li class="active">Efetuar Pagamento</li>
       </ol>
        
        <div class="container-fluid">
            <div class="row">
                <div class="alert alert-info" role="alert"><center><P><strong>Parabéns</strong> sua Pré-Reserva foi <strong>Confirmada</strong> </p></center></div>
            </div>
           
            <div class="row">  
                <div class="col-xs-6">
                    <div class="spacer"></div>
                    <div class="caixa-confirmacao">
                        <center><h5 class="titulo_body">Agora você pode: </h5></center>
                        <ul>
                            <li class='glyphicon glyphicon-usd'> <a href="http://www.eventosbacacheri.com.br/eventos/?product=aluguel-de-salao"> Efetuar o Pagamento e Confirmar a Reserva</a></li>
                            <li class="glyphicon glyphicon-asterisk"> <a href="http://www.eventosbacacheri.com.br/eventos/?page_id=216"> Criar/Alterar uma Senha para Gerenciar o Evento </a> </li>
                            <li class="glyphicon glyphicon-shopping-cart"> <a href="http://www.eventosbacacheri.com.br/eventos/?page_id=301"> Adicionar itens ou atrações à festa </a></li>
                            <li class="glyphicon glyphicon-gift">  Criar a lista de presentes </li>
                            <li class="glyphicon glyphicon-check">  Fazer sua lista de Convidados </li>
                            <li class="glyphicon glyphicon-bullhorn">  Criar e Enviar os Convites </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="quote-container">
                      <i class="pin"></i>
                      <div class="note yellow">
                          <center><h5>Lembre-se</h5></center>
                          <p>O pagamento da reserva deverá ser confirmado em até 4 dias.&nbsp;</p>
                          <p><a href="#"> Clique aqui </a> para cancelar e não receber mais notificações de confirmação.</p>
                      </div>
                    </div>
                </div>
                
            </div>
            </div>
        
        <br>
        
       <?php get_footer(); ?>
    </body>
</html>
