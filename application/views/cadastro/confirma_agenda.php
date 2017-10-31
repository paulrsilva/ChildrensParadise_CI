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

        <?php get_header(); ?>   
    </head>
    <body>
       
       <ol class="breadcrumb">
            <li><a href="#">Agenda</a></li>
            <li><a href="#">Datas</a></li>
            <li><a href="http://www.eventosbacacheri.com.br/eventos/ci/">Reservar Salão</a></li>
            <li class="active">Confirmar Reserva</li>
       </ol>
        
        <div class="container-fluid">
            <div class="row">
                <div class="alert alert-info" role="alert"><center><P>Por favor confirme o evento para o email <strong><?php echo $email ?></strong> para <strong><?php echo $data_agenda ?></strong> </p></center></div>
            </div>
           
            <div class="row">  
                <div class="col-md-8 col-md-offset-4">
                    <?php
                        $atributos = array('name'=>'formulario_agenda', 'id'=>'formulario_agenda');
                        
                        $dataHidden = array(
                            'token' => $token,
                            'email'=> $email,
                            'id_evento'=>$id_evento  
                        );
                        
                        echo form_open(base_url('/ci/index.php/childrens/atualizaCalendario'), $atributos).
                        form_hidden($dataHidden).
                        form_label("Responsavel: ", "txt_nome").br().
                        form_input("txt_nome" ). br().
                        form_label("Aniversariante ou Evento", "txt_aniversariante").br().
                        form_input("txt_evento"). br().
                        form_label("Celular", "txt_celular").br().
                        form_input("txt_celular"). br().
                        form_label("Telefone Fixo", "txt_tel").br().
                        form_input("txt_telefone"). br().                   
                        form_submit('btn_enviar','Confirmar Agendamento').
                        form_close();
                    ?>
                </div>
            </div>
            </div>
        
        <br>
        
       <?php get_footer(); ?>
    </body>
</html>
