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
        
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="<?php echo base_url('ci/includes/bootstrap/css/bootstrap.css'); ?>" >

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
        
         <link rel="stylesheet" href="<?php echo base_url('ci/bower_components/bootstrap-calendar/css/calendar.css'); ?>" />
        
        <style type="text/css">
            .calendar {
                font-family: Arial; font-size:14px;
            }
            table.calendar {
                margin: auto; border-collapse: collapse;
            }
            .calendar .days td{
                width: 80px; height: 80px; padding: 4px; 
                border: 1px solid #999;
                vertical-align: top;
                background-color: #DEF; 
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
    <body>
        <div id="calendar"></div>
        <!-- Desnecessário. Já está carregando o .11 no head  <script type="text/javascript" src="js/vendor/jquery-1.9.1.js"></script> -->
        
        
        <script type="text/javascript" src="<?php echo base_url('ci/bower_components/underscore/underscore-min.js'); ?>"></script>
        
        <script type="text/javascript" src="js/language/xx-XX.js"></script>
        
        <script type="text/javascript" src="<?php echo base_url('ci/bower_components/bootstrap-calendar/js/language/pt-BR.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('ci/bower_components/bootstrap-calendar/js/calendar.js'); ?>"></script>
        
        <script type="text/javascript">
            var calendar = $("#calendar").calendar(
                {
                    tmpl_path: "/tmpls/",
                    language: 'pt-BR',
                    events_source: function () { return []; }
                });         
        </script>    
        
        
        
        
        <ol class="breadcrumb">
            <li><a href="#">Agenda</a></li>
            <li><a href="#">Datas</a></li>
            <li class="active">Reservar Salão</li>
       </ol>
        
        <div class="container-fluid">
            <ul class="nav nav-tabs">
                <li role="presentation" class="active"><a href="#">Calendário</a></li>
                <li role="presentation"><a href="#">Reserva</a></li>
                <li role="presentation"><a href="#">Convidados</a></li>
            </ul>
            
            <div class="row">
                <div class="form-group">
                    <br>
                    <label class="col-md-2 col-md-offset-1 control-label">Escolha a Data</label>
                    <div class="col-md-6">
                        <!-- Picker -->

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
                        <!-- FIM Picker -->
                        <br>
                </div>
            </div>
            
            <div class="row">  
                <!-- Calendário -->
                <div class="col-md-2 col-md-offset-1"
                <!-- Split button -->
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
               </div>
                <div style="overflow:hidden;">
                    
                    
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
                    
                    
                    <div class="col-md-6 col-md-offset-1">
                        
                        <?php
                            echo $calendar;
                        ?>
      
                    </div>
                    
                </div>   
                <!-- FIM Calendário -->
            </div>
            
            <div class="row">
                <div class="col-md-6 col-md-offset-2">
                    <script>
                        moment('100110/09/2015', 'MM/DD/YYYY').format()
                    </script>
                </div>
            </div>
        </div>    
        
        <?php get_footer(); ?>
    </body>
</html>
