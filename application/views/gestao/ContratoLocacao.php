<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script data-require="bootstrap@*" data-semver="3.1.1" src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
        <link data-require="bootstrap-css@3.1.1" data-semver="3.1.1" rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" />

        
        <link rel="stylesheet" href="<?php echo base_url('ci/includes/css/styleDocumento.css'); ?>" >
              
        <link rel="stylesheet" href="<?php echo base_url('ci/includes/bootstrap/css/bootstrap.css'); ?>" >
        
        <title>Contrato de Locação - Eventos Bacacheri</title>
        
        <style type="text/css">
            .ArtigoContrato {
                    margin: 60px 0px 60px 0px;
                    font-size: 16px;  
                    padding: 15px;          
            }
           .ArtigoContrato2 {
                    font-size: 16px;  
                    padding: 15px;          
            }           
            
            .itensContrato {
                margin: inherit;
                padding: 10px 30px  0px  10px;
                font-size: 14px;  
            }
            
           .separador { margin:0; padding:0; height:40px; }
    
            
        </style>
        
        
    </head>
    <body>
        
        
        <?php $itensLocacao = '1 -  Cama elástica com 4,30 mts.;2 -  Piscina de bolinha 3,00 x 1,50 com 5 mil bolinhas;3 – Mesinha de atividades Baby com 2 cadeirinhas;4 – Gangorra motoca;5 – Poltrona de amamentação com puff:6 – berço Moisés;7 – Mesa atrocador:8 – Micro ondas Consul:9 – Refrigerador Consul 280 litros;10 – Fogão Dako 4 bocas com botijão;11 – Refrigerador Dako 340 litros:12 – Freezer Continental 250 litros (vertical)13 – Freezer Eletrolux 300 litros (horizontal)14 – 4 suqueiras;15 – Potes de acrílico para doces16 – TV SAMSUNG 36 com controle17 – DVD Tec Toy:18 – Minisystem Mondial;19 – TV 36”Philco com controle20 – Reck preto;21 –Mesa Aero Rocke:22 – 2 troninhos -  feminino – masculino;23 – 2 suportes para papel toalha24 – 2 assentos baby  - feminino/ masculino25 -  l jogo WII com 2 controles e disquete26 – 6 jogos Black out nas janelas27 – 2 cortinas28 – 4 lixeiras'; ?>
'
        
        <?php
        
        
            if (isset($Pagamento->valor_sinal)){
                $SinalPago=true;
            }
        
        
            switch ($Evento->status_pagto){
                    case 'Aguard. Lib. Pagto':
                        $situacaoPagto = 'efetuou o pagamento ao LOCADOR';          
                        break;
                    case 'Aguardando Pagto':
                        $situacaoPagto = 'pagará ao LOCADOR';
                        break;
                    case 'Cancelado':
                        $situacaoPagto = ' - cancelado - ';
                        break;
                    case 'Cortesia':
                        $situacaoPagto = 'recebeu a título de cortesia do LOCADOR ';
                        break;
                    case 'Indefinido':
                        $situacaoPagto = 'irá pagar ao LOCADOR ';
                        break;
                    case 'Pago':
                        $situacaoPagto = 'pagou ao LOCADOR';
                        break;       
                    case 'Pago Sinal':
                        $situacaoPagto = 'pagará ao LOCADOR';
                        break;    
                    default:
                      $situacaoPagto = 'pagará  ao LOCADOR';
            }
            
            
            switch ($Pagamento->forma_pagto){
                    case 'Dinheiro':
                        $FormaPagto = 'em Dinheiro';
                        break;
                    case 'Cheque':
                        $FormaPagto = 'em Dinheiro';
                        break;
                    case 'Cartão de Crédito':
                        $FormaPagto = 'através de Cartão de Crédito';
                        break;
                    case 'PagSeguro':
                        $FormaPagto = 'via PagSeguro';
                        break;
                    case 'Transf. Banc.':
                        $FormaPagto = 'por Transferência Bancária';
                        break;
                    case 'Boleto':
                        $FormaPagto = 'Através de Boleto';
                        break;       
                  
                    default:
                      $FormaPagto = '';
            }
            
            
            
            
            if (isset($dadosPagto->valor_reserva)){
                
                // $situacaoPagto = true;
                
                
            }
        
        
        ?>

        <?php 
            //melhorando os dados de locatário
           
            //sexo          
            if ($Locatario->sexo=='m'){
                $nacionalidade='brasileiro';
                $locGender = 'LOCATÁRIO';
                
                if (strlen($Locatario->CPF)>5 || strlen($Locatario->RG)>5) {
                    if (isset($Locatario->CPF)){
                      $documento = ', Portador do CPF '.$Locatario->CPF; 
                      if (isset($Locatario->RG)){
                          $documento=$documento.' e RG '.$Locatario->RG;
                      }
                    } else {
                        $documento = ', Portador do RG '.$Locatario->RG;                  
                    }
                }         
                if (isset($Locatario->Cidade)){
                    $residenciaLocatario = "residente e domiciliado em $Locatario->Cidade";
                    if (isset($Locatario->UF)){
                        $residenciaLocatario=$residenciaLocatario."/ $Locatario->UF ";
                    }
                }           
                if (isset($Locatario->End)){
                        $residenciaLocatario=$residenciaLocatario.' , '.$Locatario->End;
                }    
               if (isset($Locatario->CEP)){
                   $residenciaLocatario=$residenciaLocatario.', CEP '.$Locatario->CEP;
               }
                
                
                
                
                
            } elseif ($Locatario->sexo=='f'){
                $nacionalidade='brasileira';
                $locGender = 'LOCATÁRIA';
                
                if (strlen($Locatario->CPF)>5 || strlen($Locatario->RG)>5) {
                    if (strlen($Locatario->CPF)>5){
                      $documento = ', Portadora do CPF '.$Locatario->CPF; 
                      if (strlen($Locatario->RG)>5){
                          $documento=$documento.' e RG '.$Locatario->RG;
                      }
                    } else {
                        $documento = ', Portadora do RG '.$Locatario->RG;                  
                    }
                }         
                if (isset($Locatario->Cidade)){
                    $residenciaLocatario = "residente e domiciliada em $Locatario->Cidade";
                    if (isset($Locatario->UF)){
                        $residenciaLocatario=$residenciaLocatario."/ $Locatario->UF ";
                    }
                }           
                if (isset($Locatario->End)){
                        $residenciaLocatario=$residenciaLocatario.' , '.$Locatario->End;
                }    
               if (isset($Locatario->CEP)){
                   $residenciaLocatario=$residenciaLocatario.' CEP '.$Locatario->CEP;
               }
                
            } else {
               $nacionalidade='brasileira'; 
               $locGender = 'LOCATÁRIA';
                
                if (strlen($Locatario->CPF)>5 || strlen($Locatario->RG)>5) {
                    if (strlen($Locatario->CPF)>5){
                      $documento = ', Portadora do CPF '.$Locatario->CPF; 
                      if (strlen($Locatario->RG)>5){
                          $documento=$documento.' e RG '.$Locatario->RG;
                      }
                    } else {
                        $documento = ', Portadora do RG '.$Locatario->RG;                  
                    }
                }         
                if (isset($Locatario->Cidade)){
                    $residenciaLocatario = "residente e domiciliada em $Locatario->Cidade";
                    if (isset($Locatario->UF)){
                        $residenciaLocatario=$residenciaLocatario."/ $Locatario->UF ";
                    }
                }           
                if (isset($Locatario->End)){
                        $residenciaLocatario=$residenciaLocatario.' , '.$Locatario->End;
                }    
               if (isset($Locatario->CEP)){
                   $residenciaLocatario=$residenciaLocatario.' CEP '.$Locatario->CEP;
               }
            }
        
        ?>
        
        
        <div class="page">
            <div id="cabecalho">
                <center>
                    <h1>
                        Contrato de Locação de Salão
                    </h1>
                </center>
            </div>

            <?php
            // put your code here
            ?>

             <div class="ArtigoContrato">
                <div class="col-xs-8 col-xs-offset-2">
                    <strong>LOCADOR</strong>:  CARLOS ALBERTO RAMINA E SILVA, brasileiro, viúvo, aposentado, residente e domiciliado à Avenida Monteiro Tourinho, 401 – Tingui – Curitiba – Pr.
                </div>
            </div>



             <div class="ArtigoContrato">
                <div class="col-xs-8 col-xs-offset-2">
                    <strong><?php echo $locGender; ?></strong>: <?php echo strtoupper($Locatario->nome); ?>,  <?php echo $nacionalidade ?>  <?php echo $documento; ?>,  <?php echo $residenciaLocatario ?>. 
                </div>
             </div>


            <div class="ArtigoContrato">
               <div class="col-xs-8 col-xs-offset-2">
                   <strong>OBJETO DA LOCAÇÃO </strong>:  Salão Terreo localizado  à Avenida Monteiro Tourinho, 401 – Tingui – Curitiba – Pr. Contendo:
               </div>  
                <div class="col-xs-8 col-xs-offset-2">
                      <div class="itensContrato">
                        <ul class="list-inline">
                            <li>Uma Cama elástica com 4,30 mts |</li>
                            <li>Piscina de bolinha 3,00 x 1,50 com 5 mil bolinhas |</li>
                            <li>Mesinha de atividades Baby com 2 cadeirinhas |</li>
                            <li> Gangorra motoca |</li>
                            <li>Poltrona de amamentação com puff |</li>
                            <li> berço Moisés |</li>
                            <li>Mesa Trocador |</li>    
                            <li>Micro ondas Consul |</li>  
                            <li>Refrigerador Consul 280 litros |</li>  
                            <li>Fogão Dako 4 bocas com botijão |</li>  
                            <li>Refrigerador Dako 340 litros | </li>  
                            <li>Freezer Continental 250 litros (vertical) |</li>  
                            <li> Freezer Eletrolux 300 litros (horizontal) |</li>  
                            <li> 4 suqueiras |</li>  
                            <li> Potes de acrílico para doces |</li>  
                            <li> TV SAMSUNG 36 com controle - rack Preto |</li>  
                            <li> DVD Tec Toy |</li>  
                            <li> Minisystem Mondial |</li>  
                            <li> Mesa Aero Air Hockey | </li>  
                            <li> 2 troninhos - Masculino/Feminino |</li>
                            <li> 2 suportes para papel toalha |</li>
                            <li> 2 assentos baby - feminino/ masculino |</li>
                            <li> 1 jogo WII com 2 controles e DVD |</li>
                            <li> 6 jogos Black out nas janelas | </li>
                            <li> 2 cortinas | </li>
                            <li> 4 lixeiras </li>
                        </ul>
                         <div class="separador" id="separador">  <br> </div>
                    </div>
                </div>
           </div>
            
        


            <div class="ArtigoContrato">
                <div class="col-xs-8 col-xs-offset-2">
                    <strong>DATA</strong>: <?php echo mb_convert_encoding( strftime('%A, %d de %B de %Y', strtotime($Evento->data)),"iso-8859-1" ); ?>, das 9hs às 21hs.
                    <div class="separador" id="separador"> <br>   </div>
                </div>
            </div>

            



            <div class="ArtigoContrato">
                <div class="col-xs-8 col-xs-offset-2">
                    <strong>CONDIÇÕES</strong>: O LOCADOR se compromete a entregar o salão  e acessórios em perfeitas condições de conservação e funcionamento e o LOCATÁRIO em devolve-los nas mesmas condições, responsabilizando-se por sua conservação.
                 <div class="separador" id="separador"> <br>   </div>
                </div>
               

            </div>
            
             <div class="ArtigoContrato">
                <div class="col-xs-8 col-xs-offset-2">
                    <strong>VALOR E FORMA DE PAGAMENTO</strong>: O Valor total da locação é de <strong> R$ <?php echo $Pagamento->valor_reserva ?>,00 ( <?php echo $valorLocacaoExtenso ?> ) </strong>,
                        <?php  
                            $valorReservaReal = intval($Pagamento->valor_sinal);
                        
                            if ($valorReservaReal>0 &&  $Pagamento->forma_pagto=='Aguardando'){
                                echo "sendo que o sinal de reserva, no valor de $Pagamento->valor_sinal,00 ( $valorSinalExtenso ) " ;
                                echo "foi paga pelo LOCADOR ao LOCATARIO em $Pagamento->forma_pagto_sinal em ";
                                echo mb_convert_encoding( strftime('%d de %B de %Y', strtotime($Pagamento->data_sinal)),"iso-8859-1" ); 
                                echo ". A importância residual de R$ $valorResidual,00 ( $valorResidualExtenso ) deverá ser paga até a data do evento, em ";
                                echo ( $valorSinalExtenso );
                                echo ", pelo LOCADOR, sob a pena de perda do sinal de reserva ao LOCATARIO.";
                            } elseif ($valorReservaReal===0){
                                echo "pagos pelo LOCADOR ao LOCATARIO, $FormaPagto";
                                if (isset($Pagamento->obs)){
                                    echo " ( $Pagamento->obs )";
                                }
                                echo ", em ".mb_convert_encoding( strftime('%d de %B de %Y', strtotime($Pagamento->data_pagto)),"iso-8859-1").". ";                                
                            } elseif ($valorReservaReal>0 && $Pagamento->data_pagto<>"0000-00-00"){
                                echo "sendo que o <strong>LOCADOR</strong> pagou, a título de sinal, a importância de <strong>R$ $Pagamento->valor_sinal,00 ( $valorSinalExtenso )</strong>  ,em $Pagamento->forma_pagto_sinal, " ;
                                echo " ao <strong>LOCADOR</strong> em ".mb_convert_encoding( strftime('%d de %B de %Y', strtotime($Pagamento->data_sinal)),"iso-8859-1" )."."; 
                                echo " A importância residual, no valor de <strong>R$ $valorResidual,00 ( $valorResidualExtenso ) </strong>, foi paga $FormaPagto";
                                if (isset($Pagamento->obs)){
                                    echo " ( $Pagamento->obs )";
                                }
                                echo " pelo <strong>LOCADOR</strong> ao <strong>LOCATARIO</strong> em "; 
                                echo mb_convert_encoding( strftime('%d de %B de %Y', strtotime($Pagamento->data_pagto)),"iso-8859-1" ).'.'; 

                                
                            }  
                        ?>  
                    <div class="separador" id="separador"> <br>   </div>
                    <div class="separador" id="separador"> <br>   </div>

                </div>
             </div>
             
            <div class="ArtigoContrato">
                <div class="col-xs-8 col-xs-offset-2">
                    
                </div>
            </div>
            
            <div class="ArtigoContrato">
                <div class="col-xs-8 col-xs-offset-2">
                   <p class="text-right"> Curitiba, <?php echo mb_convert_encoding( strftime('%d de %B de %Y', strtotime(date("Y"))),"iso-8859-1"); ?> </p>                    
                    <div class="separador" id="separador"> <br>   </div>
                </div>
            </div>
         
        </div>     
       
         
    </body>
</html>
