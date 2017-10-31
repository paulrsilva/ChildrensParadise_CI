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
        <script data-require="bootstrap@*" data-semver="3.1.1" src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
        <link data-require="bootstrap-css@3.1.1" data-semver="3.1.1" rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" />

        
        <link rel="stylesheet" href="<?php echo base_url('ci/includes/css/style.css'); ?>" >
              
        <link rel="stylesheet" href="<?php echo base_url('ci/includes/bootstrap/css/bootstrap.css'); ?>" >
        
        <title>Eventos Bacacheri - Gestão de Agenda e Usuários</title>
        
         
    </head>
    <body>
        
        <?php //echo base_url('/ci/includes/barraEventos_top.php') ?>
        <?php include 'barraEventos_top.php' ?>
        
        <div id="page-content">       
            <!-- Blank Header -->
            <div class="content-header">
                <div class="header-section">
                    <h1>
                        <i class="glyphicon glyphicon-pencil"> Gestão </i><br><small>  <strong> Todos os Eventos </strong> 
                           | <a href="http://www.eventosbacacheri.com.br/eventos/?page_id=216&cliente-logout"> sair</a></small>
                    </h1>
                </div>
            </div>
            <ul class="breadcrumb breadcrumb-top">
                <li><a href="http://www.eventosbacacheri.com.br/eventos/ci/">Agenda</a></li>
                <li><a href="http://www.eventosbacacheri.com.br/eventos/?page_id=216">Gestão</a></li>
                <li><a href="http://www.eventosbacacheri.com.br/eventos/ci/index.php/childrens/gerenciaEvento">Gerenciar Evento</a></li>
                <li><a href="">Gestão Todos Eventos</a></li>
            </ul>
            <!-- END Blank Header -->

            <?php
                if ($eventos['numero']===1){
                    $msgTitle="Existe um evento registrado no sistema";
                } elseif($eventos['numero']>1){
                    $msgTitle="Existem ".$eventos['numero']." eventos registrados no sistema";
                } else{
                    $msgTitle=":-(  Não existem eventos no sistema";
                }    
            ?>

            <div class="block">
                <div class="block-title">
                    <h2>Olá <strong> <?php echo ucfirst($usuario->display_name); ?> </strong>.  <?php echo $msgTitle; ?> </h2>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <center>
                            <a href="#"> Registrados <span class="badge"><?php echo $eventos['numero'] ?></span></a>
                        </center>
                    </div>
                    <div class="col-sm-3">
                        <?php
                            if (!$eventos['confirmados']){
                                $EventosConfirmados=0;
                            } else{
                              $EventosConfirmados=$eventos['confirmados'];  
                            }
                        ?>
                        <center>
                            <a href="#"> Agendados <span class="badge"><?php echo $EventosConfirmados; ?></span></a>
                        </center>
                    </div>
                    <div class="col-sm-3">
                         <?php
                            if (!$eventos['confirmados']){
                                $EventosConfirmados=0;
                            } else{
                              $EventosConfirmados=$eventos['confirmados'];  
                            }
                        ?>
                        <center>
                            <a href="#"> Confirmados <span class="badge"><?php echo $EventosConfirmados; ?></span></a>
                        </center>
                    </div>
                    <div class="col-sm-3">
                        <?php
                            if (!$eventos['pagos']){
                                $EventosPagos=0;
                            } else{
                              $EventosPagos=$eventos['pagos'];  
                            }
                        ?>
                         <center>
                            <a href="#"> Pagos <span class="badge"><?php echo $EventosPagos ?></span></a>
                        </center>
                    </div>
                </div>
            </div>        


            <div class="block">
                <div class="block-title">
                     <h2>Lista de Eventos  Cadastrados </h2>
                </div>
                    <div class="table-responsive">
                        <table class="table table-vcenter table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 150px;" class="text-center"><i class="glyphicon glyphicon-user"></i></th>
                                    <th>Email</th>
                                    <th>Evento</th>
                                    <th>Data</th>
                                    <th>Status</th>
                                    <th style="width: 150px;" class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Substituido a lista de objetos (lista equipe) por um array formatado pelo controler -->

                                <?php if (isset($listaEventos)) { ?>

                                <?php foreach ($listaEventos as $eventosUser) { ?>

                                    <?php 
                                        //colocando estilo na status da lista
                                        switch ($eventosUser['status']){
                                            case "Aguardando Pagto":
                                                $etiqueta='label label-info';
                                                break;
                                            case "Aguardando Conf.":
                                                $etiqueta='label label-primary';
                                                break;
                                            case "Venc.Prazo Pagto":
                                                $etiqueta='label label-warning';
                                                break;
                                            case "Não Confirmado":
                                                $etiqueta='label label-danger';
                                                break;
                                            case "Prazo Pagto Expirado":
                                                $etiqueta='label label-danger';
                                                break;
                                            case "Pago":
                                                $etiqueta='label label-success';
                                                break;
                                             case "Cortesia":
                                                $etiqueta='label label-info';
                                                break;                                           
                                            default:
                                                 $etiqueta='label label-default';   
                                        }

                                        $caminho='/ci/images/eventos/';

                                    ?>
                                
                                    <?php
                                        //setando um avatar para usuarios cadastrados
                                        if ($eventosUser['usuarioCadastrado']){
                                            $avatarUser = 'ativo-avatar.png';    
                                        }else{
                                            $avatarUser = 'unknown-avatar.png';  
                                        }
                                    ?>

                                    <tr>
                                        <td class="text-center"><img src="<?php echo base_url().'/ci/images/eventos/'.$avatarUser; ?>" alt="avatar" class="img-circle" style="width:20px;height:20px"></td>
                                        <td><a href="#"><?php  echo $eventosUser['email']; ?></a></td>
                                        <td><a href="#"><?php  echo $eventosUser['nome_evento']; ?></a></td>
                                        <td><?php  echo $eventosUser['data_evento']; ?></td>
                                        <td><a href="javascript:void(0)" class="<?php echo $etiqueta ?>"> <?php echo $eventosUser['status']; ?> </a> </td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-xs">
                                                <?php $idE=$eventosUser['id']; ?>
                                                <a href="<?php echo base_url()."/ci/index.php/childrens/gestaoEvento/$idE" ; ?>" data-toggle="tooltip" title="Gerenciar" class="btn btn-default"><i class="glyphicon glyphicon-pencil"></i></a>
                                                <a href="#" data-href="<?php echo base_url()."/ci/index.php/childrens/deletaEvento/$idE" ; ?>" data-toggle="modal" data-target="#confirm-delete" title="Excluir" class="btn btn-default"><i class="glyphicon glyphicon-remove"></i></a>
                                            </div>
                                        </td>
                                    </tr> 
                                <?php }} ?>

                            </tbody>
                        </table> 
                    </div>
               <div class="row">
                    <div class="col-md-6 col-md-offset-1">

                            <div class="caixa_botoes">
                                <a href="http://www.eventosbacacheri.com.br/eventos/ci/" class="btn btn-primary" role="button">Agendar Evento</a>
                            </div>

                    </div>
                </div>
            </div>

            <div class="block">
                <div class="block-title">
                     <h2><strong> Alertas </strong> de Sistema</h2>
                </div>
                <div>
                    <?php //echo base_url(); ?>
                    
                    <?php var_dump($usuariosDuplicados) ?>
                    
                    <a href="<?php echo base_url()."/ci/index.php/childrens/verifica_origem" ; ?>" data-toggle="tooltip" title="teste" class="btn btn-default"><i class="glyphicon glyphicon-pencil"></i></a>
                </div>

            </div>
         </div>  
        
        <!-- modal para confirmação de exclusão no calendário -->
         
        <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Excluir Evento?</h4>
                </div>
            
                <div class="modal-body">
                    <p>Você está prestes a <strong>excluir</strong> um evento do calendário!</p>
                    <p>Esta ação não pode ser desfeita.</p>
                    <p>Gostaria de Continuar?</p>
                    <p class="debug-url"></p>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-danger btn-ok">Excluir</a>
                </div>
            </div>
           </div>
        </div>
        
        <script>
            $('#confirm-delete').on('show.bs.modal', function(e) {
                $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));

                $('.debug-url').html('Delete URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
            });
        </script>

    </body>
</html>
