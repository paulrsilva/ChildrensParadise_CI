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
        
        <title>Gestão de Evento</title>
        
        <link rel="stylesheet" href="<?php echo base_url('ci/includes/css/style.css'); ?>" >
        
        
        <?php get_header(); ?>  
    </head>
    <?php include_once("../analyticstracking.php") ?>
    <body>
        <!-- Page content -->
    <div id="page-content">
        <!-- Blank Header -->
        <div class="content-header">
            <div class="header-section">
                <h1>
                    <i class="glyphicon glyphicon-pencil"> Gestão de evento</i>
                </h1>
            </div>
        </div>
        <ul class="breadcrumb breadcrumb-top">
            <li><a href="http://www.eventosbacacheri.com.br/eventos/ci/">Agenda</a></li>
            <li><a href="http://www.eventosbacacheri.com.br/eventos/?page_id=216">Gestão</a></li>
            <li><a href="http://www.eventosbacacheri.com.br/eventos/ci/index.php/childrens/gerenciaEvento">Gerenciar Evento</a></li>
            <li><a href="#">Configurações</a></li>
        </ul>
        <!-- END Blank Header -->
        
        <?php
            if ($eventos['numero']===1){
                $msgTitle="Você tem um evento registrado";
            } elseif($eventos['numero']>1){
                $msgTitle="Você têm ".$eventos['numero']." eventos registrados";
            } else{
                $msgTitle="Você não tem nenhum evento registrado";
            }    
        ?>
        
        <?php 
            //convertendo da data para Dia-Mes-Ano
            $dataBrasil = date("d-m-Y",strtotime($calendario->data));
            
            //formatando a data para o portugues e por extenso
            $dataFormatadaEvento = strftime('%d de %B de %Y | %A', strtotime($dataBrasil));
            
            //Melhorando com as primeiras letras maiusculas
            //$dataFormatadaEvento = utf8_encode(ucwords(strftime('%d de %B de %Y | %A', strtotime($dataBrasil))));
        
        ?>
        
        <div class="block">
            <div class="block-title">
                <h2>Dados de Agendamento para <strong> <?php echo $dataFormatadaEvento; ?> </strong> </h2>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="block">
                        <div class="block-title">
                             <h2>Dados de Agenda</h2>
                        </div>
                    </div>
                </div>
                 <div class="col-md-6">
                    <div class="block">
                        <div class="block-title">
                             <h2>Dados de Aniversariante</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
        

        
     </div>   
     <?php get_footer(); ?>
    </body>
</html>
