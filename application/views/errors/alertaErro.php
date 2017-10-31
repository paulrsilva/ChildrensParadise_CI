<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url('ci/includes/bootstrap/css/bootstrap.css'); ?>" >
        
        <title>Alerta de Erro</title>
        
        <style type="text/css">
            .content-header{
                background-color: rgba(255, 255, 255, 0.7) ;
                padding: 10px;
            }
            /* Blocks */
            .block {
                margin: 20px 20px 20px 20px;
                padding: 20px 20px 20px 20px;
                background-color: #ffffff;
                border: 1px solid #dbe1e8;
            }

            .block.full {
                padding: 20px 15px;
            }

            .block .block-content-full {
                margin: -20px -15px -1px;
            }

            .block .block-content-mini-padding {
                padding: 8px;
            }

            .block.full .block-content-full {
                margin: -20px -15px;
            }

            .block-title {
                margin: -20px -15px 20px;
                background-color: #f9fafc;
                border-bottom: 1px solid #eaedf1;
            }

            .block-title h1,
            .block-title h2,
            .block-title h3,
            .block-title h4,
            .block-title h5,
            .block-title h6 {
                display: inline-block;
                font-size: 16px;
                line-height: 1.4;
                margin: 0;
                padding: 10px 16px 7px;
                font-weight: normal;
            }

            .block-title h1 small,
            .block-title h2 small,
            .block-title h3 small,
            .block-title h4 small,
            .block-title h5 small,
            .block-title h6 small {
                font-size: 13px;
                color: #777777;
                font-weight: normal;
            }

            .block-title h1,
            .block-title h2,
            .block-title h3 {
                padding-left: 15px;
                padding-right: 15px;
            }

            .block-title .nav-tabs,
            .block-options {
                min-height: 40px;
                line-height: 38px;
            }

            .block-title .nav-tabs {
                padding: 3px 1px 0;
                border-bottom: none;
            }

            .block-title .nav-tabs > li > a {
                border-bottom: none;
            }

            .block-title .nav-tabs {
                margin-bottom: -2px;
            }

            .block-title .nav-tabs > li > a {
                margin-bottom: 0;
            }

            .block-title .nav-tabs > li > a:hover {
                background: none;
            }

            .block-title .nav-tabs > li.active > a,
            .block-title .nav-tabs > li.active > a:hover,
            .block-title .nav-tabs > li.active > a:focus {
                border: 1px solid #eaedf1;
                border-bottom-color: #ffffff;
                background-color: #ffffff;
            }

            .block-title code {
                padding: 2px 3px;
            }

            .block-options {
                margin: 0 6px;
                line-height: 37px;
            }

            .block-options .label {
                display: inline-block;
                padding: 6px;
                vertical-align: middle;
                font-size: 13px;
            }

            .block-top {
                margin: -20px -15px 20px;
                border-bottom: 1px dotted #dbe1e8;
            }

            .block-section {
                margin-bottom: 20px;
            }

            .block.block-fullscreen {
                position: fixed;
                top: 5px;
                bottom: 5px;
                left: 5px;
                right: 5px;
                z-index: 1031;
                margin-bottom: 0;
                overflow-y: auto;
            }
            
            .caixa_Alerta {
                position: absolute;

                margin: 50px 0 0 50px;                
                top: 50%;
                left: 10%;

            }

        </style>
        
        
        <?php get_header(); ?>  
    </head>
    <body>
        <!-- Page content -->
    <div id="page-content">
        <!-- Blank Header -->
        <div class="content-header">
            <div class="header-section">
                <h1>
                    <i class="glyphicon glyphicon-exclamation-sign"> Alerta </i><br><small> <marquee> Erro de Solicitação </marquee> <strong><?php echo $emailUser; ?></strong> 
                        </small>
                </h1>
            </div>
        </div>
        <ul class="breadcrumb breadcrumb-top">
            <li><a href="http://www.eventosbacacheri.com.br/eventos/ci/">Agenda</a></li>
            <li><a href="http://www.eventosbacacheri.com.br/eventos/?page_id=216">Gestão</a></li>
            <li><a href="">Gerenciar Evento</a></li>
        </ul>
        <!-- END Blank Header -->
 
        
        <div class="block">
            <div class="block-title">
                <h2>Olá <strong> <?php echo ucfirst($usuario->display_name); ?> </strong>.  Houve um Erro em Sua solicitação </h2>
            </div>

            <div class="row">
                
                <div class="col-xs-6">
                    <div class="caixa_Alerta">
                        <h4> <?php echo $msgErro; ?> </h4>
                    </div>
                    
                </div>
                
                <div class="col-xs-6">
                    
                    <img class="alignnone size-medium wp-image-366" src="http://www.eventosbacacheri.com.br/eventos/wp-content/uploads/2016/11/alertaDaVaca-238x300.png" alt="alertadavaca" width="238" height="300" />
                    
                </div>
                
            </div>
        </div>        
        

        
     </div>   
     <?php get_footer(); ?>
    </body>
</html>
