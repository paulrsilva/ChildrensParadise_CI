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
        
        <!-- Adicionando Funções BootStrap -->
        
        <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> -->
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        

        <!-- Latest compiled and minified JavaScript 
        <script src="<?php //echo base_url('ci/includes/bootstrap/js/bootstrap.min.js'); ?>"></script>-->
        
        <!--
        <script type="text/javascript" src="/bower_components/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>  
        <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css" />
        -->
        <!-- Novas funções para o Bootstrap-Calendar (https://github.com/Serhioromano/bootstrap-calendar) 
        //foi carregado todo bootstrap ao invés do min.
        -->
        
        <link rel="stylesheet" href="<?php echo base_url('ci/includes/bootstrap/css/bootstrap.css'); ?>" >
                
         <script type="text/javascript" src="<?php echo base_url('ci/bower_components/moment/min/moment.min.js'); ?>"></script>
        
        <script type="text/javascript" src="<?php echo base_url('ci/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js'); ?>"></script>
        
        <link rel="stylesheet" href="<?php echo base_url('ci/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css'); ?>" />
        
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Satisfy">
                
        <style type="text/css">
            
          .spacer { margin:0; padding:0; height:50px; }
            
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
            font-family: Satisfy;
            font-size: 25px;
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

          .aviso {
                    font-weight: 600;
                    text-align: center;
                    color: #757575;
                    font-size: 14px;  
                    padding-top: 10px;
                    padding-bottom: 10px;
          }
          
          .caixa-legenda {
              padding-left: 30px;
              background-color: hsla(0,0%,0%,0.2);
              color: #FFFFFF;
              font-size: 10px;
              width: 250px;
              position: relative;
              margin: 0 0 0 40px;
          }

            .calendar {
                font-family: Arial, Verdana, Sans-serif;
                width: 100%;
                border-collapse: collapse;
            }
            
            .heading {
                    font-weight: bold;
                    text-align: right;
                    color: #757575;
                    font-size: 18px; 
            }
            
            table.calendar {
                margin: auto; border-collapse: collapse;
            }
            .calendar .days td{
                width: 80px; height: 70px; padding: 4px; 
                max-width:80px;
                max-height: 70px;
                border: 1px solid #999;
                vertical-align: top;
                background-color: #DEF; 
                overflow:scroll;
                display: table-cell;
            }
            .calendar .days td:hover{
                background-color: #FFF;
            }
            .calendar .highlight {
                font-weight: bold; color: #00F;
            }
            
        </style>
        
         <?php get_header(); ?>       
    </head>
    
    <?php include_once("../analyticstracking.php") ?>
    
    <body>
        <!-- Desnecessário. Já está carregando o .11 no head  <script type="text/javascript" src="js/vendor/jquery-1.9.1.js"></script> -->
        
        
        <script type="text/javascript" src="<?php echo base_url('ci/bower_components/underscore/underscore-min.js'); ?>"></script>
        
        <!--
        <script type="text/javascript" src="js/language/xx-XX.js"></script>
        -->
        
        <ol class="breadcrumb">
            <li><a href="#">Agenda</a></li>
            <li><a href="#">Datas</a></li>
            <li class="active">Reservar Salão</li>
       </ol>
        
        <div class="container-fluid">
            
            <!--
            <ul class="nav nav-tabs">
                <li role="presentation" class="active"><a href="#">Calendário</a></li>
                <li role="presentation"><a href="#">Reserva</a></li>
                <li role="presentation"><a href="#">Convidados</a></li>
            </ul>
            -->
            
            <div class="row">
                <div class="page-header">
                    <center> <h1>Calendário <small>Escolha a data para reserva.</small></h1> </center>
                </div>
            </div>
            
            <div class="row">
                
                <!--
                <div class="form-group">
                    <br>
                    <label class="col-md-2 col-md-offset-1 control-label">Escolha a Data</label>
                    <div class="col-md-6">
                
                       

                            <div class='input-group date' id='datetimepicker1'>
                                <input type='text' class="form-control" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                    </div>
                        <script type="text/javascript">
                            $(function () {
                                $('#datetimepicker1').datetimepicker();
                            });
                        </script>
                         
                        <br> 
                -->
                </div>
            
            <div class="row">  
                <!-- Calendário -->
                
                <!--
                <div class="col-md-2 col-md-offset-1"> -->
                    
                    
                <!-- Split button -->
                <!--
                   <div class="btn-group">
                     <button type="button" class="btn btn-danger">Reservar</button>
                     <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       <span class="caret"></span>
                       <span class="sr-only">Verificar Preços</span>
                     </button>
                     <ul class="dropdown-menu">
                       <li><a href="#">Solicitar Reserva</a></li>
                       <li><a href="#">Confirmar Reserva</a></li>
                       <li role="separator" class="divider"></li>
                       <li><a href="#">Cancelar Reserva</a></li>
                     </ul>
                   </div>  
                -->
                <!--Fim slipt button -->
                
               <!-- 
               </div> -->
                    
                    <!--
                    <div class="col-md-6 col-md-offset-1">
                        <div class="form-group">
                            <div id="datetimepicker12"></div>
                        </div>
                    </div>       
                    <script type="text/javascript">
                        $(function () {
                            $('#datetimepicker12').datetimepicker({
                                inline: true,
                                sideBySide: false
                            });
                        });
                    </script>
                    -->

                 
                    
                <!-- Sticky note -->
                <div class="col-sm-4">
                    <div class="row">
                        <div class="spacer"></div>
                        <div class="quote-container">
                            <i class="pin"></i>
                          <div class="note yellow">
                              <p>Selecione uma data no calendário para iniciar o processo de reserva&nbsp;</p>
                              <!--<p>Se você já efetuou, <a href="http://www.eventosbacacheri.com.br/eventos/ci/index.php/childrens/gerenciaEvento"> clique aqui </a> para gerenciar o evento.</p>-->
                          </div>
                        </div>
                    </div>
                    <div class="row">
                        <br>
                        <div class="caixa-legenda">
                            
                            <center><h5>legenda</h5></center>
                            <ul>
                                <li class='glyphicon glyphicon-thumbs-up'> Data Confirmada;</li>
                                <li class='glyphicon glyphicon-time'> Aguardado Confirmação</li>
                                <li class='glyphicon glyphicon-erase'> Não Confirmada. </li>
                                <li class='glyphicon glyphicon-envelope'> Enviado Email. Pré-Agendamento </li>
                            </ul>
                        </div>
                        
                        
                        <!--</center>
                                $iconPagtoOk = "<span class='glyphicon glyphicon-thumbs-up' aria-hidden='true'></span>";
                                $iconAguardConf = "<span class='glyphicon glyphicon-time' aria-hidden='true'></span>";
                                $iconNaoConf = "<span class='glyphicon glyphicon-erase' aria-hidden='true'></span>";
                                $iconEnviadoEmail =  "<span class='glyphicon glyphicon-envelope' aria-hidden='true'></span>";
                        -->
                    </div>
                </div>
                <!-- Fim Sticky note -->
                    
                    
                    <div class="col-sm-8">
                        <br>
                        
                        <?php
                            echo $calendar;
                        ?>

                    <script type="text/javascript">
                        $(document).ready(function(){
                            $(' .calendar .day').click(function() {
                                day_num = $(this).find('.day_num').html();
                                email_val = prompt('Digite seu email para confirmar a Reserva', $(this).find('.content').html());
                                
                                //Validando o email
                                function validateEmail(email_val) {

                                    //var objRegExp = /(^[a-z]([a-z_\.]*)@([a-z_\.]*)([.][a-z]{3})$)|(^[a-z]([a-z_\.]*)@([a-z_\.]*)(\.[a-z]{3})(\.[a-z]{2})*$)/i;
                                    
                                    var objRegExp = /(^[a-z0-9_]([a-z-0-9_\.]*)@([a-z_\.]*)([.][a-z]{3})$)|(^[a-z]([a-z_\.]*)@([a-z_\.]*)(\.[a-z]{3})(\.[a-z]{2})*$)/i;
                                    
                                    //var objRegExp = /^(([^<>()[]\.,;:s@"]+(.[^<>()[]\.,;:s@"]+)*)|(".+"))@(([[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}])|(([a-zA-Z-0-9]+.)+[a-zA-Z]{2,}))$/;

                                    return objRegExp.test(email_val);

                                } 
                                
                                //Fim validando o email
                                
                                if (validateEmail(email_val)){
                                    $.ajax({
                                      data: {
                                          dia: day_num,
                                          mes: "<?php echo $mes; ?>",
                                          ano: "<?php echo $ano; ?>",
                                          email: email_val
                                      },
                                      type: 'POST',
                                      url: '<?php echo ci_site_url('/ci/index.php/childrens/index'); ?>',
                                      success: function(result) {
                                          alert("Um email de foi enviado. Por favor confirme para prosseguir com a Reserva.");
                                          //$('#result2').html(result);
                                          location.reload();
                                      }
                                    });
                                } else { alert("Por favor insira um email válido!"); }
                            })
                        });
                    </script>
        
                        
      
                    </div>
                <!-- FIM Calendário -->
                
                
            </div>
            
            <div class="row">
                <div class="col-sm-12">
                    <div class="aviso">  
                        <div class="bg-primary">
                            <p> <span class="glyphicon glyphicon-warning-sign" aria-hidden="true">  <strong>Importante: </strong></span> 
                                Os pré-agendamentos deverão ser confirmados no email informado no mesmo dia </p>
                            <p> <span class="glyphicon glyphicon-time" aria-hidden="true"> </span> Após a confirmação por email, será gerado e enviado um boleto por email. A pré-reserva será mantida por <strong>4 dias</strong>.</p>
                            <p> <span class="glyphicon glyphicon-calendar" aria-hidden="true"> </span> No caso de dois agendamentos para <strong>mesma data</strong>, o primeiro terá prevalência.&nbsp;<br> Na não confirmação, o segundo passa a valer automaticamente</p>
                        </div>
                    </div>
                    
                </div>
                
            </div>
            
            <!--
            <div class="row">
                <div class="col-md-6 col-md-offset-2">
                    <script>
                        moment('10/09/2015', 'MM/DD/YYYY').format()
                    </script>
                    ----
                </div>
            </div>
            -->
            
        </div>    
        
     </div>

        
        <?php get_footer(); ?>
    </body>
</html>
