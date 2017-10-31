<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        
        <script data-require="bootstrap@*" data-semver="3.1.1" src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
        
        <?php ini_set('allow_url_fopen',1); ?>
        
        <link rel="stylesheet" href="<?php echo base_url('ci/includes/bootstrap/css/bootstrap.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('ci/includes/css/style.css'); ?>" >
        <link rel="stylesheet" href="<?php echo base_url('ci/includes/font-awesome/css/font-awesome.min.css'); ?>">
           
        <?php include_once './vendor/autoload.php'; ?>

        
        <title>Eventos Bacacheri - Editar Usuario e Evento</title>
        
        <?php
            header("Content-Type: text/html; charset=utf-8", true);
        ?>
                 
        
    </head>
    <body>
        
         <script type="text/javascript" src="<?php echo base_url('ci/includes/js/eventos.js'); ?>"></script>
        
        <?php include 'barraEventos_top.php' ?>  
        
        <div id="page-content">
            <!-- Blank Header -->
            <div class="content-header">
                <div class="header-section">
                    <h1>
                        <i class="glyphicon glyphicon-edit"> Editar Evento </i><br><small> Agenda para <?php echo mb_convert_encoding( strftime('%A, %d de %B de %Y', strtotime($calendario->data)),"iso-8859-1" ); ?> 
                           | <a href="#"> <?php echo $calendario->email_reserva  ?> </a></small>
                        <!-- foi usada uma gambiarra de conversão de string para resolver temporariamente a naba de formatação de acentos do PHP -->

                    </h1>
                </div>
            </div>
            <ul class="breadcrumb breadcrumb-top">
                <li><a href="http://www.eventosbacacheri.com.br/eventos/ci/">Agenda</a></li>
                <li><a href="http://www.eventosbacacheri.com.br/eventos/?page_id=216">Gestão</a></li>
                <li><a href="http://www.eventosbacacheri.com.br/eventos/ci/index.php/childrens/gerenciaEvento">Gerenciar Evento</a></li>
                <li><a href="http://www.eventosbacacheri.com.br/eventos/ci/index.php/childrens/gerenciaTodosEventos">Gestão Todos Eventos</a></li>
                <li><a href="#">Editar Evento</a></li>
            </ul>
            <!-- END Blank Header -->
            <?php 
                //convertendo da data para Dia-Mes-Ano
                $dataBrasil = date("d-m-Y",strtotime($calendario->data));

                //formatando a data para o portugues e por extenso
                //$dataFormatadaEvento = strftime('%d de %B de %Y | %A', strtotime($dataBrasil));
                
                $dataFormatadaEvento = strftime('%d de %B de %Y', strtotime($dataBrasil));

                //Melhorando com as primeiras letras maiusculas
                //$dataFormatadaEvento = utf8_encode(ucwords(strftime('%d de %B de %Y | %A', strtotime($dataBrasil))));

            ?>
            <div class="block">
               <div class="block-title">
                   <h2>Dados de Agendamento para <strong> <?php echo $dataFormatadaEvento; ?> </strong> </h2>
               </div>
                
                <div class="block">
                    <div class="block-title">
                        <h2>Dados do Agenda | <?php echo $dataFormatadaEvento; ?> </h2>
                    </div>
                                       
                    <form action="<?php echo site_url("/ci/index.php/childrens/AdmAtualizaEvento/$calendario->id"); ?>" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered">
                                  
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="email_solicitante">Email Solicitante</label>
                            <div class="col-md-6">
                                <input type="hidden" value="<?php echo $calendario->id; ?>" name="calendario_id" />
                                <input type="text" id="email_solicitante" name="email_solicitante" value="<?php echo $calendario->email_reserva; ?>" class="form-control" placeholder="email solicitante">
                            </div>
                            <div class="col-md-3">

                               <label class="radio-inline" for="email_confirmado">
                                   <input type="radio" id="email_confirmado" name="email_confirmado"
                                          value="1" 
                                          <?php if($calendario->email_Confirmado=="1") { echo "checked='TRUE'"; }?>> <i class="glyphicon glyphicon-envelope"> Email</i>
                               </label>

                               <label class="radio-inline" for="usuario_sistema">
                                   <input type="radio" id="usuario_sistema" name="usuario_sistema" value="usuario"
                                          <?php if($usuarioCadastrado) { echo "checked='TRUE'"; }?> disabled="true"> <i class="glyphicon glyphicon-user"> Cadastrado</i>
                               </label>                          
                            </div>    
                        </div>
                         <div class="form-group">
                            <label class="col-xs-3 control-label" for="datepicker">Data/Nome Evento</label>  

                            <div class="col-md-3">                                                     
                                 <!-- <input id="datepicker" data-date-format="mm/dd/yyyy"> <p class="glyphicon glyphicon-calendar"></p>  -->                            
                                 <!-- <a href="#" class="glyphicon glyphicon-calendar"> </a>  -->
                                 
                                 <div class="input-group date">
                                     <input class="form-control input-md" type="date" name="dataEvento" value="<?php echo $calendario->data ?>" />  
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                 </div>
                                                                  
                                 <!--
                                 <script type="text/javascript">
                                    var date = $('#datepicker').datepicker('getDate');
                                    document.write(date);
                                 </script>
                                 -->
                                 
                            </div>
                            
                             <div class="col-md-3"> 
                                 <input type="text" id="nomeEvento" name="nomeEvento" value="<?php echo $calendario->evento; ?>" class="form-control" placeholder="Nome Evento">
                             </div>

                            <div class="col-md-3">
                                
  
                                

                                <select class="form-control inputstl" id="sitPagto" name="sitPagto" onchange="SitPagtoCal(this)" data-placeholder="Situação">
 
                                            <?php foreach($listaPagtos  as $situacao):?>
                                                <option value="<?php echo $situacao->StatusPagto ?>"><?php echo $situacao->StatusPagto ?></option>
                                            <?php endforeach;?>  
                                                                                          
                                         <option selected='selected'><?php echo $calendario->status_pagto ; ?></option>    

                                </select>
                                
                                <!--
                                <script>
                                   $('sitPagto').change(function(){
                                          var selected = $(this).find('option:selected');
                                          $('#text').html(selected.text()); 
                                          $('#value').html(selected.val()); 
                                          //$('#foo').html(selected.data('foo')); 
                                          alert('The option with value ' + $(this).val() + ' and text ' + $(this).text() + ' was selected.');
                                       }).change();
                                   });
                                    
                                </script>                            
                                                               
                                
                                
                                
                                <script>
                                   $(function(){
                                       $('sitPagto').change(function(){
                                           var selected = $(this).find('option:selected');
                                          $('#text').html(selected.text()); 
                                          $('#value').html(selected.val()); 
                                          //$('#foo').html(selected.data('foo')); 
                                       }).change();
                                   });
                               </script>
                                    
                                <span id="text"></span>
                                
                                 -->
                                
                                
                                <script> //armasenar situacao do calendario pra usar mais tarde
                                    $('#sitPagto').change(function() {
                                      //alert('The option with value ' + $(this).val() + ' and text ' + $(this).text() + ' was selected.');
                                      var PagtoCalSel = $(this).val();
                                      
                                      //mudando o select da forma de pagto com a opção do calendário
                                        $('[FormaPagto=option] option').filter(function() { 
                                            return ($(this).text() == 'Boleto'); //To select Blue
                                        }).prop('selected', true);
                                      
                                      //alert (PagtoCalSel);
                                      //document.write(PagtoCalSel);
                                      
                                      <?php $teste3 = "<script>document.write(PagtoCalSel)</script>"; ?>
        
                                    });
                                </script>
                                <!-- 
                                
                                I can get the selected value (by using $("#select").val()) and the selected item's display value (by using $("#select :selected").text()
                                
                                -->
                                
                            </div>          
                          </div>
                          <div class="form-group">           
                                  <label class="col-xs-3 control-label" for="Solicitacao">Solic/Conf/Pagto</label>  
                                 
                              <div class="col-md-3">
                                    <input type="text" id="DataSolicitacao" name="DataSolicitacao" value="<?php echo $calendario->data_solicitacao; ?>" class="form-control" disabled>
                             </div>
                              <div class="col-md-3">
                                 <input type="date" id="DataSolicitacao" name="DataConf" value="<?php echo $calendario->data_confirmacao; ?>" class="form-control" >
                              </div>
                               <div class="col-md-3">
                                 <input type="date" id="DataSolicitacao" name="DataPagtoCal" value="<?php echo $calendario->data_pagto; ?>" class="form-control" >
                              </div>
                              
                          </div>
                        
                          <div class="form-group">
                            <label class="col-xs-3 control-label" for="Obs_Agenda">Observações de Agenda</label>  
                            <div class="col-xs-9">
                                <textarea class="form-control" id="Obs_Agenda" name="Obs_Agenda" rows="3"><?php echo $calendario->obs_agenda; ?></textarea>
                            </div>
                         </div>
                        
                            <div class="form-group"> 
                                <legend> 
                                    <small>
                                        >>  Dados de Pagamento  
                                        <small>
                        
                                            <?php 
                                            
                                                if($dadosPagto==FALSE){
                                            
                                                    echo "<span class='label label-warning'>   -> Sem informações de pgto</span>";
                                                }
                                            ?>
                                            
                                        </small>
                                    </small>
                                </legend>
                                <label class="col-xs-3 control-label" for="valor_reserva">Locação</label>  

                                 <div class="col-md-3">
                                     <label><small>Valor Total de Locação</small>
                                     <input type="text" id="valor_reserva" name="valor_reserva" value="<?php echo $dadosPagto->valor_reserva; ?>" placeholder="Valor Total Locação" class="form-control">
                                     </label>
                                     
                                </div>
                                
                                <div class="col-md-3">                                 
                                     <label><small>Data de Pagamento</small>
                                         
                                           <input class="form-control " type="date" id="dataPagto" name="DataPagto" value="<?php echo $dadosPagto->data_pagto; ?>"> 
                                         
                                     </label>                       
                                </div>
                                
                                <div class="col-md-3">
                                     <label><small>Forma de Pagamento</small>
                                        <select class="form-control inputstl" id="FormaPagto" name="FormaPagto"  data-placeholder="Forma Pagto" >

                                                    <?php foreach($formasPagto  as $formaPgto):?>
                                                        <option value="<?php echo $formaPgto->forma ?>"><?php echo $formaPgto->forma ?></option>
                                                    <?php endforeach;?>  

                                                 <option selected='selected'><?php echo $dadosPagto->forma_pagto ; ?></option>    

                                        </select>                    
                                     </label>
                                    
                                    <!-- tentando pegar o situacao de pagto do calendario
                                    <script>
                                        $(function(){
                                            $('sitPagto').change(function(){
                                                var selected = $(this).find('option:selected');
                                               $('#text').html(selected.text()); 
                                               $('#value').html(selected.val()); 
                                               //$('#foo').html(selected.data('foo')); 
                                            }).change();
                                        });
                                    </script>
                                    
                                    <span id="value"></span>
                                    -->
                                    
                                </div>       
                            </div>
                        
                            <div class="form-group"> 
  
                                <label class="col-xs-3 control-label" for="Sinal de Reserva">Sinal</label>  

                                 <div class="col-md-3">
                                     <label><small>Valor de Sinal para Reserva</small>
                                     <input type="text" id="valor_sinal" name="valor_sinal" value="<?php echo $dadosPagto->valor_sinal ; ?>" placeholder="Valor Sinal" class="form-control">
                                     </label>
                                </div>
                                
                                <div class="col-md-3">
                                     <label><small>Data de Pagamento Sinal</small>
                                         <input class="form-control " type="date" id="dataPagto_sinal" name="dataPagtoSinal" value="<?php echo $dadosPagto->data_sinal; ?>" >  
                                     </label>
                                </div>
                                
                                <div class="col-md-3">
                                     <label><small>Forma de Pagamento</small>
                                        <select class="form-control inputstl" id="sitPagto_reserva" name="sitPagto_reserva"  data-placeholder="Situação" >
                                                  <option></option><!-- Required for data-placeholder attribute to work with Chosen plugin --> 

                                                    <?php foreach($formasPagto  as $formaPgto):?>
                                                        <option value="<?php echo $formaPgto->forma ?>"><?php echo $formaPgto->forma ?></option>
                                                    <?php endforeach;?>  

                                                 <option selected='selected'><?php echo $dadosPagto->forma_pagto_sinal ; ?></option>      

                                        </select>                    
                                     </label>
                                </div>       
                            </div>
                        
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="Obs_Pagto">Observações de Pagto.</label>  
                            <div class="col-xs-8">
                                <textarea class="form-control" id="Obs_Pagto" name="Obs_Pagto" rows="3"><?php echo $dadosPagto->obs; ?></textarea>
                            </div>
                        </div>
                        
                        <div class="form-group form-actions">

                            <div class="col-xs-9 col-xs-offset-6">  
                                
                                
                            <div class="btn-group">


                                    <a class='btn btn-sm btn-danger' href='$varURL'  role='button'><i class='glyphicon glyphicon-trash'></i> Apagar Evento</a>

                                    <button type="submit" class="btn btn-sm btn-primary" ><i class="glyphicon glyphicon-plus"></i> Atualizar Evento </button>



                                    <!-- botão de opções -->
                                    
                                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                          Outras Opções
                                          <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                          <li><a href="#">Enviar Confirmação por Email</a></li>
                                          <li><a href="http://www.eventosbacacheri.com.br/eventos/ci/index.php/childrens/contratoLocacao/<?php echo $calendario->id ?>">Gerar Contrato</a></li>
                                          <li><a href="#">Emitir Recibo</a></li>
                                          <li role="separator" class="divider"></li>
                                          <li><a href="#">Arquivar Evento</a></li>
                                        </ul>
                                 
                                  <!-- fim botão de opções -->
                                  
                            </div>
                                
                                
                                
                            </div>
                        </div>
                                                 
                        

                </form>
                
                <!-- Importando FORM -->
                
                <?php
                
                    if ($EventosAgendadosUser[numero]==0){
                        $msgEventosReg = 'Nenhum evento';
                    } elseif ($EventosAgendadosUser[numero]==1){
                        $msgEventosReg = 'evento registrado';
                    } else {
                        $msgEventosReg = 'eventos registrados';
                    }     
                ?>
                
                <div class="block">
                    <div class="block-title">
                        <h2>Dados do Solicitante | <?php echo $calendario->email_reserva ?> | 
                            <span class="badge">  <?php echo $EventosAgendadosUser[numero] ?>  </span> <a href="#"> <?php echo $msgEventosReg; ?> </a> 
                            
                            <?php               
                                if ($usuariosDuplicados) {
                                    echo "| <span class='badge'> $usuariosDuplicados </span> <span class='label label-warning'><a href='#'> Usuarios Duplicados !</a></span>";
                                }
                            ?>
                            
                            <?php 
                                if(!isset($cliente->id)){
                                    echo "|  <span class='label label-warning'><span class='glyphicon glyphicon-eye-close'>  </span> Usuário NÃO Cadastrado </span>";
                                }
                            ?>
                            
                            
                            
                            
                        </h2>
                    </div>
                    <!-- END Example Title -->

                    <!-- Formulário de Conteúdo para adicionar contato -->
                    <!-- Add Contact Content -->
                    <!-- FORMULARIO DO USUARIO -->
                    
                        
                    <form action="<?php echo site_url("/ci/index.php/childrens/atualizaUsuario"); ?>" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered">
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="Nome">Nome </label>
                            <div class="col-md-6">
                                <input type="hidden" value="<?php echo $cliente->id; ?>" name="cliente_id" />
                                <input type="hidden" value="<?php echo $calendario->email_reserva; ?>" name="cliente_email" />
                                <input type="hidden" value="<?php echo $calendario->id; ?>" name="id_evento" />
         
                                <input type="text" id="nome_cliente" name="nome_cliente" value="<?php echo $cliente->nome; ?>" class="form-control" placeholder="Nome Cliente">
                            </div>
                            <div class="col-md-3">

                               <label class="radio-inline" for="sexoUser">
                                   <input type="radio" id="sexoUserF" name="sexoCliente"
                                          value="f" 
                                          <?php if($cliente->sexo=="f") { echo "checked='TRUE'"; }?>> <i class="fa fa-female" aria-hidden="true"> </i>
                               </label>

                               <label class="radio-inline" for="sexoUser">
                                   <input type="radio" id="sexoUserM" name="sexoCliente" value="m" 
                                          <?php if($cliente->sexo=="m") { echo "checked='TRUE'"; }?> > <i class="fa fa-male" aria-hidden="true"> </i>
                               </label>                          
                            </div>    
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="userCPF">CPF</label>
                            <div class="col-md-4">
                                <input type="text" id="clienteCPF" name="clienteCPF" class="form-control" value="<?php echo $cliente->CPF; ?>" placeholder="CPF">
                            </div>
                            <div class="col-md-4">
                                 <input type="text" id="clienteRG" name="clienteRG" class="form-control" value="<?php echo $cliente->RG; ?>" placeholder="RG">
                            </div>    
                        </div>
                        
                         <div class="form-group">
                            <label class="col-md-3 control-label" for="">UF/Cidade</label>
                            <div class="col-md-2">
                                <input type="text" id="clienteUF" name="clienteUF"  class="form-control" value="<?php echo $cliente->UF; ?>" placeholder="UF">
                            </div>
                            <div class="col-md-6">
                                 <input type="text" id="clienteCidade" name="clienteCidade" class="form-control" value="<?php echo $cliente->Cidade; ?>" placeholder="Cidade">
                            </div>    
                        </div>                       
                        
                        
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="CEPCliente">Endereço</label>
                            <div class="col-md-2">
                                 <input type="text" id="CEPCliente" name="CEPCliente" class="form-control" value="<?php echo $cliente->CEP; ?>"placeholder="CEP">
                            </div>   
                            <div class="col-md-6">
                                <input type="text" id="endereco_Cliente" name="endereco_Cliente" value="<?php echo $cliente->End; ?>" class="form-control" placeholder="Endereço">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="tel_cliente">Telefone/Celular</label>
                            <div class="col-md-4">
                                <input type="text" id="tel_cliente" name="tel_cliente" value="<?php echo $cliente->NumFixo; ?>" class="form-control" placeholder="Telefone Fixo">
                            </div>
                            <div class="col-md-4">
                                 <input type="text" id="cel_cliente" name="cel_cliente" class="form-control" value="<?php echo $cliente->NumCelular; ?>" placeholder="Celular">
                            </div>    
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="cliente_aniversario">Dados Cadastro</label>
                            <div class="col-md-3">
                                <label><small>Data de Nascimento</small>
                                    <input type="date" id="cliente_aniversario" name="cliente_aniversario" value="<?php echo $cliente->Data_Nascimento; ?>"  class="form-control" >
                            </div>
                            <div class="col-md-3">
                                <label><small>Data de Cadastro</small>
                                <input type="text" id="ClienteCadastro" name="ClienteCadastro" value="<?php echo $cliente->created; ?>"  class="form-control" disabled="true">
                            </div>    
                            <div class="col-md-2">
                                <label><small>Último Login</small>
                                <input type="text" id="lastLoginCliente" name="lastLoginCliente" class="form-control" value="<?php echo $cliente->last_login; ?>" disabled="true">
                            </div>   
                        </div>
                        
                         <div class="form-group">
                            <label class="col-md-3 control-label" for="OrigemLead">Controle</label>
                            <div class="col-md-2">
                                <label><small>Origem Lead</small>
                                <input type="text" id="OrigemLead" name="OrigemLead" class="form-control" >
                            </div>
                            <div class="col-md-3">
                                <label><small>Status</small>
                                <input type="text" id="Status" name="Status"  class="form-control">
                            </div>    
                            <div class="col-md-3">
                                <label><small>Verificações</small><p>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" id="emailVerificado" name="emailVerificado" <?php if($cliente->email_verificado==1){ echo "checked='TRUE'"; } ?>
                                        > email
                                   </label>
                                   <label class="checkbox-inline">
                                     <input type="checkbox" id="FixoVerificado" name="FixoVerificado" <?php if($cliente->fixo_verificado==1){ echo "checked='TRUE'"; } ?>                                        
                                     > telefone
                                   </label>
                                   <label class="checkbox-inline">
                                       <input type="checkbox" id="CelularVerificado" name="CelularVerificado" <?php if($cliente->celular_verificado==1){ echo "checked='TRUE'"; } ?>        
                                       > celular
                                   </label>
                                        
                            </div>   
                        </div>
                        
                        <div class="form-group">
                            <label class="col-xs-3 control-label" for="Obs_Cliente">Observações Usuário</label>  
                            <div class="col-xs-8">
                                    <textarea class="form-control" id="Obs_Cliente" name="Obs_Cliente" rows="3"><?php echo $cliente->obs; ?></textarea>
                            </div>
                        </div>
                        
                        <div class="form-group form-actions"> 

                            <div class="col-xs-9 col-xs-offset-7">  

                            <?php //Se estiver atualizando muda o nome do botão de adicionar e inclui um botão excluir
                                if (isset($Membro['Nome'])){
                                    $MsgButton = 'Atualizar Membro';

                                    $varURL =  base_url()."dashboard/DeletaMembroEquipeCandidato/".$Membro['Id_MembroEquipe'];
                                    echo "<a class='btn btn-sm btn-danger' href='$varURL' ;' role='button'><i class='fa fa-eraser'></i>Apagar Membro</a>";

                                } elseif(!isset($Membro['Nome']))  {
                                   $MsgButton = 'Adicionar Membro'; 
                                }
                            ?>
                                                              
                                <?php
                                    if (!isset($cliente->id)){
                                        $msgBtn = 'Adicionar Cliente';
                                    } else {
                                        $msgBtn = 'Atualizar Cliente';
                                        echo "<a class='btn btn-sm btn-danger' href='$varURL'  role='button'><i class='glyphicon glyphicon-trash'></i> Apagar cliente</a>";
                                    }
                                
                                ?>
                                             
                                <button type="submit" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-plus"></i> <?php echo $msgBtn; ?> </button>
          
                            </div>
                        </div>
                    </form>
      
                </div>
            
        </div>

                <!-- testes aqui -->
    </div>  
    </div>

    </body>
</html>
