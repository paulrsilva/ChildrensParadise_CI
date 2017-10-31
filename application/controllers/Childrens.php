<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Childrens
 *
 * @author paulinorochaesilva
 */

/**
require_once '/ci/vendor/mercadopago/sdk/lib/mercadopago.php';
$mp = new MP ("4066569559077839", "AZg4ww23WtXx5MvNJbWmiYYQ7APDLSfE");
 * 
 */


class Childrens extends CI_Controller {
    
        public function __construct() {
            parent::__construct();
            global $table_prefix, $wp_embed, $wp_widget_factory, $_wp_deprecated_widgets_callbacks, $wp_locale, $wp_rewrite;
            $this->load->helper('url','array','date','security');
            $this->load->model('Mycal_model');
            $this->load->library('form_validation');
            $this->load->library('xmlrpc');
            $this->load->library('xmlrpcs');
            //$this->load->helper('security');
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            //$this->load->library('google_weather_api'); 
            
            $CI = &get_instance();
            $CI->config->load("mercadopago", TRUE);
            $config = $CI->config->item('mercadopago');
            $this->load->library('Mercadopago', $config);  
            setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
            date_default_timezone_set('America/Sao_Paulo');
            //include_once('.../analyticstracking.php');
            include_once './vendor/autoload.php';
            require_once '../wp-load.php';
            
        }
    
    
	public function index($ano=null, $mes=null)
	{
            if (!$ano){
                $ano=date('Y');
            }
            if (!$mes){
                $mes=date('m');
            }
            //$this->load->model('Mycal_model');
  
            //var_dump($_POST);
            
            if($this->input->post('dia')){
                
                $dia = $this->input->post('dia');
                $mes = $this->input->post('mes');
                $ano = $this->input->post('ano');
                //$evento = $this->input->post('data');
                $email_val=$this->input->post('email');
           
                //$this->Mycal_model->add_calendar_data("$ano-$mes-$dia",$email_val);
                
                $id = $this->Mycal_model->pre_agendamento_calendario("$ano-$mes-$dia",$email_val);
                
                //var_dump($id);
                
                $token = $this->Mycal_model->insertToken($id);  
                
                $qstring = base64_encode($token); //Estava dando pau na codificação do token. Verificar mais tarde     
                
                //$url = ci_site_url() . 'dashboard/complete/token/' . $qstring; 
                
                $url = ci_site_url('/ci/index.php/childrens/confirmar/').$qstring;
                
                
                $link = '<a href="' . $url . '">' . $url . '</a>'; 
                
                $link = '<a href="' . $url . '">' . $url . '</a>';               
                
                
                //Enviando email de confirmação de agendamento
                
                $emailDestino =  $email_val;
                $assunto = 'Agendamento de Salão';
                
                $mensagem = '';                     
                $mensagem .= '<strong>Confirmação Childrens Paradise</strong><br><br>';
                $mensagem .= '<br><strong>Por favor clique no link abaixo para confirmar seu agendamento: </strong> <br><br>' . $link;                
                 
                
                if ($this->enviar_email($emailDestino, $assunto, $mensagem)){
                     echo "<script>alert('Email enviado');</script>";
                }else {
                    echo "<script>alert('Falha de envio');</script>";
                }
                
                //Fim Enviando email
                
            }
            
            /** Para verificar os pushs para pagina (GET, POST, etc)
            
            echo "<br>";
            echo $this->input->method(TRUE); // Outputs: POST
            echo "<br>";
            echo $this->input->method(FALSE); // Outputs: post
            echo "<br>";
            echo $this->input->method(); // Outputs: post
            echo "<br>";
             * 
             */
  
            $data['calendar']=$this->Mycal_model->geradata($ano,$mes);
            $data['ano']=$ano;
            $data['mes']=$mes;
            $eventosCalendar=  $this->Mycal_model->ListaTodosEventos();
     
            //$data['eventos']=$eventosCalendar;
            
            
            
            $this->load->view('agenda', $data);   
            
            
	}
        
        public function confirmar()
            {                                   
                $token = base64_decode($this->uri->segment(3));  //Descriptografando o Token
            
                $cleanToken = $this->security->xss_clean($token);

                $calendario_info = $this->Mycal_model->isTokenValid($token); //either false or array();                 
                
                /** 
                var_dump($this->uri->segment(3));
                echo "<br>";
                var_dump($token);
                echo "<br>";
                var_dump($cleanToken);
                echo "<br>";
                var_dump($calendario_info);
                **/
                
                  
                if(!$calendario_info){
                    //$this->session->set_flashdata('flash_message', 'O Token é inválido ou expirou');
                    //redirect(ci_site_url('/ci/index.php/childrens/index'));
                    redirect(ci_site_url('?page_id=200')); //Página do Wordpress
                }    
                
                $this->Mycal_model->confirma_email_calendario($calendario_info->id);
                
                $data = array(
                    'id'=> $calendario_info->id, 
                    'email'=>$calendario_info->email_reserva, 
                    'token'=>base64_encode($token)
                );
                
                $dataAgenda = Array(
                    'id_evento'=>$calendario_info->id,
                    'email'=>$calendario_info->email_reserva,
                    'data_agenda'=>$calendario_info->data,
                    'token'=>$token,     
                );
                                        
                $this->load->view('cadastro/confirma_agenda',$dataAgenda);
                
                /**
                $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
                $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');   
                 * 
                 */           
                
                
                /**
                
                if ($this->form_validation->run() == FALSE) {   
                    $this->load->view('cadastro/cabecalho');
                    $this->load->view('cadastro/confirmar', $data);
                    $this->load->view('cadastro/rodape');

                   // echo $data['email'].' '.$data['user_id'];
                }else{

                    //$this->load->library('password');    # biblioteca externa libraries/Password não carregando. Verificar             
                    $post = $this->input->post(NULL, TRUE);

                    $cleanPost = $this->security->xss_clean($post);

                    //$hashed = $this->password->create_hash($cleanPost['password']); // Antiga utilizacao da bib. ext. Password

                    $hashed = $this->hashPassword($cleanPost['password'],$data['email']);

                    $cleanPost['password'] = $hashed;

                    unset($cleanPost['passconf']);

                    $userInfo = $this->PDCModel->updateUserInfo($cleanPost);
                    if(!$userInfo){
                        $this->session->set_flashdata('flash_message', 'Houve um problema na atualização do usuário');
                        redirect(ci_site_url().'dashboard/login');
                    }

                    unset($userInfo->password);

                    foreach($userInfo as $key=>$val){
                        $this->session->set_userdata($key, $val);
                    }
                    redirect(ci_site_url().'/');

                }  **/
            }
       
            
            
       function confirmar_agenda_evento(){
           //incluir id variavel do evendo pré-agendado no calendário
           
           $this->load->helper('form');
           $this->load->view('cadastro/confirma_agenda');
           
       }
       
       function PegaIdPagto($idEvento){
           
           //$idDePagto = $this->Mycal_model->dadosPagto($idEvento)->id;
        
           if (!$this->Mycal_model->dadosPagto($idEvento)->id){
               $dadosPagto = array (
                   'calendario_id' => $idEvento  
               );
               $idDePagto=$this->Mycal_model->criaPagto($dadosPagto);
               return $idDePagto;
           } else {
               return $this->Mycal_model->dadosPagto($idEvento)->id;
           }
       }
       
               
       function AdmAtualizaEvento($idEvento){
           
           /**
           echo $idEvento;
           echo "<br><br>";
           var_dump($_POST);
           
            echo "<br> ----- <br>";
           
            echo $this->PegaIdPagto($idEvento);
            * 
            */

            if($this->input->post()){ 
                
                $idUsuarioCadastrado = $this->Mycal_model->verifica_calendarioUser($this->input->post('email_solicitante'));
                
                $idPagto = $this->PegaIdPagto($idEvento);
                
                
                //caso não tenha sido setada a situação de pagamento no calendário
                if ($this->input->post('sitPagto')==""){
                    $sitReservaCal = 'Indefinido';
                } else {
                    $sitReservaCal = $this->input->post('sitPagto');      
                }
                
                
   
                $ReservaEfetuada=false;
                
                switch ($sitReservaCal){
                        case 'Aguard. Lib. Pagto':
                            $ReservaEfetuada=TRUE;
                            break;
                        case 'Aguardando Pagto':
                            $ReservaEfetuada=TRUE;
                            break;
                        case 'Cancelado':
                            $ReservaEfetuada=FALSE;
                            break;                           
                        case 'Cortesia':
                            $ReservaEfetuada=TRUE;
                            break;                            
                        case 'Pago':
                            $ReservaEfetuada=TRUE; 
                            break;                            
                        case 'Pago Sinal':
                            $ReservaEfetuada=TRUE;   
                            break;                            
                        default:
                            $ReservaEfetuada=FALSE;   
                }
                
       
                //echo $idUsuarioCadastrado->id  
     
                $DadosPagamento  = Array(
                    'id' => $idPagto,
                    'calendario_id' => $idEvento,
                    'user_id' => $idUsuarioCadastrado->id,
                    'valor_reserva' => $this->input->post('valor_reserva'),
                    'valor_sinal' => $this->input->post('valor_sinal'),
                    'forma_pagto' => $this->input->post('FormaPagto'),
                    'forma_pagto_sinal' => $this->input->post('sitPagto_reserva'),
                    'data_pagto' => $this->input->post('DataPagto'),
                    'data_sinal' => $this->input->post('dataPagtoSinal'),
                    'obs' => $this->input->post('Obs_Pagto')      
                );
                
                
                $dadosCalendario = Array(
                    'id' => $this->input->post('calendario_id'),
                    'email_reserva' => $this->input->post('email_solicitante'),
                    'email_Confirmado' => $this->input->post('email_confirmado'),
                    'data' => $this->input->post('dataEvento'),
                    'evento' => $this->input->post('nomeEvento'),
                    

                    'data_confirmacao' => $this->input->post('DataConf'),
                    'data_pagto' => $this->input->post('DataPagtoCal'),

                    'id_pagto' => $idPagto,
                    
                    'reserva_efetuada' => $sitReservaCal, //associar reserva paga (bit) com dados da tabela pagto.
                    'status_pagto' => $sitReservaCal, 
                        
                    'obs_agenda' => $this->input->post('Obs_Agenda') 
                );
                
                
                //atualizando dados da agenda pelo id de evento
                $this->Mycal_model->atualizaAgenda($idEvento,$dadosCalendario);
                
                //atualizando dados de pagamento com o id do evento
                $this->Mycal_model->atualizaDadosPagto($idEvento,$DadosPagamento);
                
                $this->gestaoEvento($idEvento);
     

            }         

           
       }
               
       function  atualizaUsuario(){
           
           //var_dump($_POST);
           
            //$origem = explode("/", parse_url($_SERVER[HTTP_REFERER],PHP_URL_PATH)); //Determinando a origem de chamada
         
                
                      
           if ($this->input->post('emailVerificado')){
               $emailVerificado=true;
               //echo 'email verificado';
           }
           
           if ($this->input->post('FixoVerificado')){
               $fixoVerificado=true;
               //echo 'Fixo verificado';

           }
           
           if ($this->input->post('CelularVerificado')){
               $cellVerificado=true;
                //echo 'Cel verificado';

           }
                        
           
           $dadosUsuario = array(
               'nome' => $this->input->post('nome_cliente'),
               'sexo' => $this->input->post('sexoCliente'),
               'CPF' => $this->input->post('clienteCPF'),
               'RG' => $this->input->post('clienteRG'),
               'email' => $this->input->post('cliente_email'),
               'Data_Nascimento' => $this->input->post('cliente_aniversario'),
               'NumCelular' => $this->input->post('cel_cliente'),
               'NumFixo' => $this->input->post('tel_cliente'),
               'UF' => $this->input->post('clienteUF'),
               'Cidade' => $this->input->post('clienteCidade'),
               'End' => $this->input->post('endereco_Cliente'),
               'CEP' => $this->input->post('CEPCliente'),
               'email_verificado' => $emailVerificado,
               'celular_verificado' =>$cellVerificado ,             
               'fixo_verificado' =>$fixoVerificado ,
               'obs' => $this->input->post('Obs_Cliente')            
           );
           
           
            // verifica se existe um id de usuário associado. Se não tiver, cria um
            // se tiver, atualiza
           
            if (!$this->input->post('cliente_id')){          
                $this->Mycal_model->criaUser($dadosUsuario);
           } else {     
               $this->Mycal_model->atualizaUsuario($this->input->post('cliente_id'),$dadosUsuario);
           }     
           
          //Verificando se a chamada veio de GerenciaEvento ou GerenciaTodosEventos -> retornar o usuario admin do evento pro lugar certo
           /**
          switch ($origem[count($origem)-1]){
              case 'gerenciaEvento':
                  $this->load->view('/gestao/gestaoEvento',$data);
                  break;
              case 'gerenciaTodosEventos':
                  $this->load->view('/gestao/gestaoEventoAdmin',$data);
                  break;
              default:
                $this->load->view('/gestao/gestaoEventoAdmin',$data);  
          }
            * 
            */
          //fim validação de origem           

   
           $this->gestaoEvento($this->input->post('id_evento'));
    
       }
       
               
       
       function atualizaCalendario(){
           //var_dump($_POST);
           if($this->input->post()){             
                $this->Mycal_model->marca_token($this->input->post('token')); //Marca token como utilizado
               
                $idEvento = $this->input->post('id_evento');
                $emailUser =  $this->input->post('email');
                $NomeUser = $this->input->post('txt_nome');
                $CelUser = $this->input->post('txt_celular');
                $TelUser = $this->input->post('txt_telefone');
                $evento = $this->input->post('txt_evento');
                $date = date('Y-m-d');
                
                //$this->Mycal_model->confirma_evento_calendario($idEvento,$evento);
                
                if ($this->Mycal_model->confirma_evento_calendario($idEvento,$evento)){
                    //cria user - redireciona e envia email para gerar senha user
                                        
                    $dadosUser = Array(
                        'nome' => $NomeUser,
                        'NumCelular' => $CelUser,
                        'NumFixo' => $TelUser,
                        'email' => $emailUser,
                        'created' => $date,
                        'email_verificado' => 1
                            
                    );     
                    
                    if ($idNewUser = $this->Mycal_model->criaUser($dadosUser)){
                        echo 'Usuario '.$idNewUser.' incluido';
                        $this->load->view('cadastro/confirma_reserva');
                    }
             
                }
            $this->load->view('cadastro/confirma_reserva');
    
           }
           
       }
       
                    
       function enviar_email($emailDestino,$assunto, $mensagem){
            
            $config = array(
                'protocol' => 'sendmail',
                'smtp_host' => 'ssl://email-ssl.com.br',
                'smtp_port' => 465,
                'smtp_user' => 'eventos@raminaesilva.adv.br', 
                'smtp_pass' => 'asfadas2016', 
                'mailtype' => 'html',
                'charset' => 'UTF-8',
                'wordwrap' => TRUE
              );
            
            $this->load->library('email', $config);
            $this->email->initialize($config); // Add 

            $this->email->from('eventos@eventosbacacheri.com.br','Childrens Paradise' );
            $this->email->to($emailDestino);
            $this->email->cc('eventos@eventosbacacheri.com.br');
            $this->email->subject($assunto);
            $this->email->message($mensagem);
            
            if($this->email->send()) {
                //echo 'Email sent.';    
                return TRUE;
              } else {
                print_r($this->email->print_debugger()); 
                return FALSE;
            }

        }
        
        
        public function pagamento_aprovado(){
            echo 'Pagto aprovado';
        }
        
        public function pagamento_em_processo(){
            $accessToken = $this->mercadopago->get_access_token();
            //var_dump($this->mercadopago->get_preference('preferencias'));
            
            //$testePagto=$this->mercadopago->get_payment();
            
            var_dump($accessToken);
        }
        
        public function retorno_pagto($infoPagto){
            echo $infoPagto;
        }
        
        public function login(){
            //echo 'login';
            $this->load->view('/cadastro/login');
        }
        
        public function contratoLocacao($idEvento){
            
            $page='gestao/ContratoLocacao';
            //echo $IdLocatario." ".$idEvento;
            
            $dadosEvento = $this->Mycal_model->pegaInfoCalendar($idEvento);
            $dadosLocatario = $this->Mycal_model->verifica_calendarioUser($dadosEvento->email_reserva);
            $dadosPagto = $this->Mycal_model->dadosPagto($idEvento);
            
            $valorLocacaoExtenso = $this->escreverValorMoeda($dadosPagto->valor_reserva);
            
            
            $valLocacao = floatval($dadosPagto->valor_reserva);
            $valSinal = floatval($dadosPagto->valor_sinal);
            
            
            
            if (isset($dadosPagto->valor_sinal)){
                $valorSinalExtenso= $this->escreverValorMoeda($dadosPagto->valor_sinal);
                $valResidual = ($valLocacao-$valSinal);
                $ValResidualExtenso = $this->escreverValorMoeda($valResidual);
            }
            
            $data = array (
                'Evento' => $dadosEvento,
                'Locatario' => $dadosLocatario,
                'Pagamento' => $dadosPagto,
                'valorLocacaoExtenso' => $valorLocacaoExtenso,
                'valorSinalExtenso' =>$valorSinalExtenso,
                'valorResidual' => $valResidual,
                'valorResidualExtenso' => $ValResidualExtenso
            );
            
            
            /**
            var_dump($dadosLocatario);
            echo '---'."<br>";
            var_dump($dadosEvento);
            echo '---'."<br>";
            var_dump($dadosPagto);
             * 
             */

            

            $this->load->view($page,$data);
        }


        public function verificaPrazo($data=NULL){
            $this->load->helper('date');
            $today = date('Y-m-d');
            $dataAgendamento = date("Y-m-d", strtotime($data));
            
            //var_dump($data); //Revisar a naba... Nao esta pegando o timestamp
            $dateC = strtr($data, '/', '-'); // substituindo o '/' pelo '-' para compatibilidade             
            $data3 = mdate( "%Y-%m-%d", strtotime($dateC)); //convertendo p/ Data p/o MySQL
            //
            //testes cegos
            
            $data1 = new DateTime($today);
            $data2 = new DateTime($dataAgendamento);
                           
            //echo "<br>";
            
            //var_dump($data2);
            
            $diff=date_diff($data1,$data2);
            
            // %a outputs the total number of days
           
            return $diff->format("%a");
        }
        
        public function gestaoEvento($idEvento){
            if ( is_user_logged_in() ) {
                $current_user = wp_get_current_user();
                $dadosEvento=$this->Mycal_model->pegaInfoCalendar($idEvento);
                $origem = explode("/", parse_url($_SERVER[HTTP_REFERER],PHP_URL_PATH));
                
                $cliente = $this->Mycal_model->verifica_calendarioUser($dadosEvento->email_reserva); //Usuario na tabela de usuarios na Eventos Bacacheri
                
                //Verifica se há mais de um usuário com o mesmo email na tabela users        
                $UsuariosDuplicados = $this->Mycal_model->UsuariosDuplicados($dadosEvento->email_reserva);
                
                if ($this->Mycal_model->verifica_calendarioUser($dadosEvento->email_reserva)){
                    $usuarioCadastrado = true;     
                    //echo 'USUARIO CADASTRADO';
                    //echo $idUsuarioCadastrado->id;
                } else{
                    $usuarioCadastrado = false;  
                    //echo 'USUARIO NAO CADASTRADO';
                }                
                     
                if ($current_user->user_email===$dadosEvento->email_reserva){
                    //var_dump($dadosEvento);
                    //echo "<br>";
                    //echo $dadosEvento->email_reserva;
                    
                    //$usuarioCadastrado = $this->Mycal_model->verifica_calendarioUser($dadosEvento->email_reserva);
                                       
                    
                    $data = array (
                        'usuario' => $current_user,
                        'calendario' =>$dadosEvento,
                        'usuarioCadastrado' => $usuarioCadastrado,
                            
                        'listaPagtos' => $this->Mycal_model->listaStatusPagto(),
                        'formasPagto' => $this->Mycal_model->listaFormasPagto(),
                        'dadosPagto' => $this->Mycal_model->dadosPagto($idEvento),
                        
                        'usuariosDuplicados' => $UsuariosDuplicados,
                                                
                        'EventosAgendadosUser' => $this->Mycal_model->PegaEventosAgendados_User($dadosEvento->email_reserva),
                        
                        'cliente' => $cliente
                    );
                    
                    //echo $dadosEvento->data;
                    //echo strftime('%A, %d de %B de %Y', strtotime($dadosEvento->data));
                    
                    
                    //Verificando se a chamada veio de GerenciaEvento ou GerenciaTodosEventos
                    switch ($origem[count($origem)-1]){
                        case 'gerenciaEvento':
                            $this->load->view('/gestao/gestaoEvento',$data);
                            break;
                        case 'gerenciaTodosEventos':
                            $this->load->view('/gestao/gestaoEventoAdmin',$data);
                            break;
                        default:
                          $this->load->view('/gestao/gestaoEvento',$data);  
                    }
                    //fim validação de origem                   
            
                } else {
                         if (is_super_admin()){
                            
                            $data = array (
                                'usuario' => $current_user,
                                'calendario' =>$dadosEvento,
                                'usuarioCadastrado' => $usuarioCadastrado,
                                'listaPagtos' => $this->Mycal_model->listaStatusPagto(),
                                'formasPagto' => $this->Mycal_model->listaFormasPagto(),
                                'dadosPagto' => $this->Mycal_model->dadosPagto($idEvento),
                                
                                 'usuariosDuplicados' => $UsuariosDuplicados,
                        
                                'EventosAgendadosUser' => $this->Mycal_model->PegaEventosAgendados_User($dadosEvento->email_reserva),
                                
                                'cliente' => $cliente    
                            );
                             
                             
                            //Verificando se a chamada veio de GerenciaEvento ou GerenciaTodosEventos
                            switch ($origem[count($origem)-1]){
                                case 'gerenciaEvento':
                                    $this->load->view('/gestao/gestaoEvento',$data);
                                    break;
                                case 'gerenciaTodosEventos':
                                    $this->load->view('/gestao/gestaoEventoAdmin',$data);
                                    break;
                                default:
                                  $this->load->view('/gestao/gestaoEventoAdmin',$data);  
                            }
                            //fim validação de origem                                    
                         } else {
                            $dadosErro = array(
                                'emailUser' => $current_user->user_email,
                                'msgErro' => "<br><br>Este evento está cadastrado para outro email.<br><br>"
                                . " Faça o <a href='http://www.eventosbacacheri.com.br/eventos/?page_id=216'>login</a> do email registrado para continuar. "
                            );
                            $this->load->view('/errors/alertaErro',$dadosErro);              
                        }  
                }
            
            } else {
                $dadosErro = array(
                    'emailUser' => 'Não Conectado',
                    'msgErro' => "<br><br>Você não está conectado no sistema.<br><br>"
                    . " Faça seu <a href='http://www.eventosbacacheri.com.br/eventos/?page_id=216'>login</a> para continuar. "
                    . "<br><br> Você também pode fazer ir direto para nossa <a href='http://www.eventosbacacheri.com.br/eventos/ci/'> agenda de eventos </a>"
                );
                $this->load->view('/errors/alertaErro',$dadosErro);  
            }
        }
        
        
        public function gerenciaTodosEventos(){     
            
            if ( !is_super_admin()){
                if (!is_user_logged_in()){
                    $dadosErro = array(
                        'emailUser' => 'Não Conectado',
                        'msgErro' => "<br><br>Você não está conectado no sistema.<br><br>"
                        . " Faça seu <a href='http://www.eventosbacacheri.com.br/eventos/?page_id=216'>login</a> para continuar. "
                    );
                    $this->load->view('/errors/alertaErro',$dadosErro);  
                } else {
                    $current_user = wp_get_current_user();  
                        $dadosErro = array(
                            'emailUser' => $current_user->user_email,
                            'msgErro' => "O email $current_user->user_email não pode acessar isto! "
                                . "<br><br> Esta página é para Administradores do Sistema. <br><br> "
                            . "Clique <a href='http://www.eventosbacacheri.com.br/eventos/?page_id=216'>aqui</a> para se conectar com outra conta. ",
                        );
                        $this->load->view('/errors/alertaErro',$dadosErro);
                }
            } else {
                
                $current_user = wp_get_current_user();
                $EventosCalendario = $this->Mycal_model->PegaTodosEventos();
                $listaEventos = $this->Mycal_model->listaTodosEventos();
                
                //Verifica se há mais de um usuário com o mesmo email na tabela users
                
                $UsuariosDuplicados = $this->Mycal_model->UsuariosDuplicados($current_user->user_email);
                
     
                foreach ($listaEventos->result() as $eventoAgendado){
                    
                    
                    if ($eventoAgendado->reserva_efetuada){ 
                        
                        
                       //$statusEvento = 'Pago'; 
                        
                        $statusEvento = $eventoAgendado->status_pagto;
                        
                       //$statusEvento = $this->Mycal_model->dadosPagto($eventoAgendado->id)->forma_pagto;
                       
                    } elseif (isset($eventoAgendado->data_confirmacao)) {
                        if ($this->verificaPrazo($eventoAgendado->data_confirmacao)<=3){
                            $statusEvento='Aguardando Pagto';
                        } elseif ($this->verificaPrazo($eventoAgendado->data_confirmacao)===4){
                            $statusEvento='Venc.Prazo Pagto';
                        } else {
                            $statusEvento='Prazo Pagto Expirado';
                        }
                    } else {
                        if ($this->verificaPrazo($eventoAgendado->solicitacao)<2){
                            $statusEvento='Aguardando Conf.'; //Acertar depois o timestamp (verificaPrazo)
                        } else {
                            $statusEvento='Não Confirmado.';
                        }  
                    }    
                    
                    //preg_replace( "/\r|\n/", "", $statusEvento ); / para remover espaços extras
                    
                    if ($this->Mycal_model->verifica_calendarioUser($eventoAgendado->email_reserva)){
                        $usuarioCadastrado = true;     
                    } else{
                        $usuarioCadastrado = false;  
                    }
                    
                    
                    
                    
                    $dataFormatadaBrasil = date("d-m-Y", strtotime($eventoAgendado->data));
                    
                    $dataEventosAgendados[$eventoAgendado->id]=array(
                        'id' => $eventoAgendado->id,
                        'email' => $eventoAgendado->email_reserva,
                        'data_solicitacao' => $eventoAgendado->data_solicitacao,
                        'data_confirmacao' => $eventoAgendado->data_confirmacao,
                        'data_pagto' => $eventoAgendado->data_pagto,
                        //'data_evento' => $eventoAgendado->data,
                        'data_evento' => $dataFormatadaBrasil,
                        'nome_evento' => $eventoAgendado->evento,
                        'status' => $statusEvento,
                        'usuarioCadastrado' => $usuarioCadastrado
                    );
       
                }        
                
                
    
                 $data = array(
                    'usuario' => $current_user,
                    'eventos' => $EventosCalendario,
                    'listaEventos' =>$dataEventosAgendados,
                    'usuariosDuplicados' => $UsuariosDuplicados
                );
                
                 
                //echo 'teste';
                $this->load->view('/gestao/gerenciarTodosEventos',$data);  
            }
            
        }

        

        public function gerenciaEvento(){

            if ( is_user_logged_in() ) {
                
                $current_user = wp_get_current_user();
                
                $EventosUsuario = $this->Mycal_model->PegaEventosAgendados_User($current_user->user_email);
                
                
                
                /**
                printf( 'Olá %s!', esc_html( $current_user->user_firstname ) );
                echo "<br>";    
                echo "você está conectado com o email: $current_user->user_email" ;
                echo "<br>";
                echo "você tem ". $EventosUsuario["numero"] ." eventos agendados"."<br>";
                echo "você tem ". $EventosUsuario["confirmados"] ." eventos confirmados"."<br>";
                echo "você tem ". $EventosUsuario["pagos"] ." eventos pagos"."<br>";
                echo "<br>";
                //$agendaUser=$this->Mycal_model->PegaEventosAgendados_User("paulino@neoplace.com.br");
                //var_dump($agendaUser);
                **/
                
                // Atualizando lista
                
                 $listaEventos = $this->Mycal_model->listaEventosUsuario($current_user->user_email); //se for admin, listar todos os eventos
            
                //Criando array com dados atualizados de lista de eventos
                 //$today = date('Y-m-d');
                 //echo $this->verificaPrazo($today);
            
                foreach ($listaEventos->result() as $eventoAgendado){
                    if ($eventoAgendado->reserva_efetuada){
                       $statusEvento = 'Pago'; 
                    } elseif (isset($eventoAgendado->data_confirmacao)) {
                        if ($this->verificaPrazo($eventoAgendado->data_confirmacao)<=3){
                            $statusEvento='Aguardando Pagto';
                        } elseif ($this->verificaPrazo($eventoAgendado->data_confirmacao)===4){
                            $statusEvento='Venc.Prazo Pagto';
                        } else {
                            $statusEvento='Prazo Pagto Expirado';
                        }
                    } else {
                        if ($this->verificaPrazo($eventoAgendado->solicitacao)<2){
                            $statusEvento='Aguardando Conf.'; //Acertar depois o timestamp (verificaPrazo)
                        } else {
                            $statusEvento='Não Confirmado.';
                        }
                        
                    }
                    
                    $dataFormatadaBrasil = date("d-m-Y", strtotime($eventoAgendado->data));
                    
                    $dataEventosAgendados[$eventoAgendado->id]=array(
                        'id' => $eventoAgendado->id,
                        'email' => $eventoAgendado->email_reserva,
                        'data_solicitacao' => $eventoAgendado->data_solicitacao,
                        'data_confirmacao' => $eventoAgendado->data_confirmacao,
                        'data_pagto' => $eventoAgendado->data_pagto,
                        //'data_evento' => $eventoAgendado->data,
                        'data_evento' => $dataFormatadaBrasil,
                        'nome_evento' => $eventoAgendado->evento,
                        'status' => $statusEvento
                    );
                    
                    /**
                    $dataMembrosEquipe[$membroEquipe->Id_MembroEquipe]=array(
                      'id' => $membroEquipe->Id_MembroEquipe,
                      'nome'  => $membroEquipe->Nome,
                      'foto' => $this->RetornaImagemMembro($membroEquipe->foto),
                      'email' =>  $membroEquipe->email,
                      'Acesso' =>  $membroEquipe->Role
                    );
                     * 
                     */
                }
    
                // FIM Atualizando lista
                
                $data = array(
                    'usuario' => $current_user,
                    'eventos' => $EventosUsuario,
                    'listaEventos' =>$dataEventosAgendados
                );
                
                $this->load->view('gerenciarEvento',$data);
     
            } else {
                $dadosErro = array(
                    'emailUser' => 'Não Conectado',
                    'msgErro' => "<br><br>Você não está conectado no sistema.<br><br>"
                    . " Faça seu <a href='http://www.eventosbacacheri.com.br/eventos/?page_id=216'>login</a> para continuar. "
                    . "<br><br> Você também pode fazer ir direto para nossa <a href='http://www.eventosbacacheri.com.br/eventos/ci/'> agenda de eventos </a>"
                );
                $this->load->view('/errors/alertaErro',$dadosErro);  
            }            
        }
        
        public function deletaEvento($idEvento){
                        
            // Verifica a sessão, depois se o id do evento está com o mesmo email de quem apaga
            // Colocar validação para que o admin possa apagar qquer evento
            // colocar repasse e opção de reserva para outra data em eventos já pagos.
                            
            if ( is_user_logged_in() ) {
                $current_user = wp_get_current_user();
               $origem = explode("/", parse_url($_SERVER[HTTP_REFERER],PHP_URL_PATH));
                if ($this->Mycal_model->checaUsuario($idEvento, $current_user->user_email)){
                    $this->Mycal_model->DeletaEventoCalendario($idEvento);            
                    //Verificando se a chamada veio de GerenciaEvento ou GerenciaTodosEventos
                    switch ($origem[count($origem)-1]){
                        case 'gerenciaEvento':
                            $this->gerenciaEvento();  
                            break;
                        case 'gerenciaTodosEventos':
                            $this->gerenciaTodosEventos();
                            break;
                        default:
                          $this->gerenciaEvento();   
                    }
                                   
                } else {
                    
                        if (is_super_admin()){
                            $this->Mycal_model->DeletaEventoCalendario($idEvento);
                            switch ($origem[count($origem)-1]){
                                case 'gerenciaEvento':
                                    $this->gerenciaEvento();  
                                    break;
                                case 'gerenciaTodosEventos':
                                    $this->gerenciaTodosEventos();
                                    break;
                                default:
                                    $this->gerenciaEvento();                    
                            }                           
                        } else {
                             $dadosErro = array(
                                'emailUser' => $current_user->user_email,
                                'msgErro' => "Você está conectado como $current_user->user_email. "
                                    . "<br><br> O evento que está tentando excluir está cadastrado para outro endereço. <br><br> "
                                . "Clique <a href='http://www.eventosbacacheri.com.br/eventos/?page_id=216'>aqui</a> para se conectar com outra conta. ",
                             );
                            $this->load->view('/errors/alertaErro',$dadosErro);   
                        } 
                }
            } else{
                $dadosErro = array(
                    'emailUser' => 'Não Conectado',
                    'msgErro' => "<br><br>Você não está mais conectado no sistema.<br><br> Faça seu <a href='http://www.eventosbacacheri.com.br/eventos/?page_id=216'>login</a> para continuar. "
                );
                $this->load->view('/errors/alertaErro',$dadosErro);
            }
        }
        
        public function teste(){
          $this->load->helper('date');
           //var_dump($_POST);
          $diaDeHj = date('d');
          $MesAtual = date('m');
          //echo $today;
          
          $varEventos = $this->Mycal_model->ListaTodosEventos();
          //var_dump($varEventos);
          echo $MesAtual." ".$diaDeHj."<br>";
          
          $this->load->view('agenda_old');
                   
          /** 
          $i=1;

          foreach ($varEventos as $linhaEvento){
              $diaConfReserva = date('d',strtotime($linhaEvento->data_confirmacao));
              echo $linhaEvento->id." ".$linhaEvento->data_confirmacao."<br>";
              echo $diaConfReserva."<br>";
              echo ($diaDeHj-$diaConfReserva);
              echo "<br>";
          }
           * 
           */
          
        }
        
        public function teste2(){
            
            
            $this->load->view('giselle');
            
            
        }
        
        public function verifica_origem(){
            
            /**
            $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            echo $actual_link;
            echo "<br>";
            echo $_SERVER[HTTP_REFERER];
            echo "<br>";
            echo $_SERVER[SCRIPT_FILENAME];
            echo "<br>";
            echo $_SERVER[REQUEST_URI];
            echo "<br>";
            echo $_SERVER[PATH_INFO];
            echo "<br>";
            $linkReferencia = $_SERVER[HTTP_REFERER];
            echo $linkReferencia;
            echo "<br>";
             * 
             */
            
            $linkReferencia = $_SERVER[HTTP_REFERER];
            
            // var_dump(parse_url($linkReferencia));
            // var_dump(parse_url($linkReferencia, PHP_URL_SCHEME));
            //var_dump(parse_url($linkReferencia, PHP_URL_USER));
            //var_dump(parse_url($linkReferencia, PHP_URL_PASS));
            //var_dump(parse_url($linkReferencia, PHP_URL_HOST));
            //var_dump(parse_url($linkReferencia, PHP_URL_PORT));
            //var_dump(parse_url($linkReferencia, PHP_URL_PATH));
            //var_dump(parse_url($linkReferencia, PHP_URL_QUERY));
            //var_dump(parse_url($linkReferencia, PHP_URL_FRAGMENT));
            
            $caminhoOld = parse_url($linkReferencia, PHP_URL_PATH);
            
            echo $caminhoOld;
            
             echo "<br>";

            //$caminho = parse_url($_SERVER[HTTP_REFERER],PHP_URL_PATH);
            
            $origem = explode("/", parse_url($_SERVER[HTTP_REFERER],PHP_URL_PATH));
            echo $origem[count($origem)-1];
            
            var_dump($origem);
            
             echo "<br>";
             
             echo count($origem);
             
             echo "<br>";  
             
             echo $origem[count($origem)-1];

           // echo $caminho;
        }
        
        
        //Funções para retornar valores por extenso
        /**
 * Retorna uma string do numero
 * 
 * @param string $n - Valor a ser traduzido,  apenas numeros inteiros
 * @example numeroEscrito('500');
 * @return string 
 */
        function numeroEscrito($n) {

            $numeros[1][0] = '';
            $numeros[1][1] = 'um';
            $numeros[1][2] = 'dois';
            $numeros[1][3] = 'três';
            $numeros[1][4] = 'quatro';
            $numeros[1][5] = 'cinco';
            $numeros[1][6] = 'seis';
            $numeros[1][7] = 'sete';
            $numeros[1][8] = 'oito';
            $numeros[1][9] = 'nove';

            $numeros[2][0] = '';
            $numeros[2][10] = 'dez';
            $numeros[2][11] = 'onze';
            $numeros[2][12] = 'doze';
            $numeros[2][13] = 'treze';
            $numeros[2][14] = 'quatorze';
            $numeros[2][15] = 'quinze';
            $numeros[2][16] = 'dezesseis';
            $numeros[2][17] = 'dezesete';
            $numeros[2][18] = 'dezoito';
            $numeros[2][19] = 'dezenove';
            $numeros[2][2] = 'vinte';
            $numeros[2][3] = 'trinta';
            $numeros[2][4] = 'quarenta';
            $numeros[2][5] = 'cinquenta';
            $numeros[2][6] = 'sessenta';
            $numeros[2][7] = 'setenta';
            $numeros[2][8] = 'oitenta';
            $numeros[2][9] = 'noventa';

            $numeros[3][0] = '';
            $numeros[3][1] = 'cem';
            $numeros[3][2] = 'duzentos';
            $numeros[3][3] = 'trezentos';
            $numeros[3][4] = 'quatrocentos';
            $numeros[3][5] = 'quinhentos';
            $numeros[3][6] = 'seiscentos';
            $numeros[3][7] = 'setecentos';
            $numeros[3][8] = 'oitocentos';
            $numeros[3][9] = 'novecentos';

            $qtd = strlen($n);

            $compl[0] = ' mil ';
            $compl[1] = ' milhão ';
            $compl[2] = ' milhões ';
            $numero = "";
            $casa = $qtd;
            $pulaum = false;
            $x = 0;
            for ($y = 0; $y < $qtd; $y++) {

                if ($casa == 5) {

                    if ($n[$x] == '1') {

                        $indice = '1' . $n[$x + 1];
                        $pulaum = true;
                    } else {

                        $indice = $n[$x];
                    }

                    if ($n[$x] != '0') {

                        if (isset($n[$x - 1])) {

                            $numero .= ' e ';
                        }

                        $numero .= $numeros[2][$indice];

                        if ($pulaum) {

                            $numero .= ' ' . $compl[0];
                        }
                    }
                }

                if ($casa == 4) {

                    if (!$pulaum) {

                        if ($n[$x] != '0') {

                            if (isset($n[$x - 1])) {

                                $numero .= ' e ';
                            }
                        }
                    }

                    $numero .= $numeros[1][$n[$x]] . ' ' . $compl[0];
                }

                if ($casa == 3) {

                    if ($n[$x] == '1' && $n[$x + 1] != '0') {

                        $numero .= 'cento ';
                    } else {

                        if ($n[$x] != '0') {

                            if (isset($n[$x - 1])) {

                                $numero .= ' e ';
                            }

                            $numero .= $numeros[3][$n[$x]];
                        }
                    }
                }

                if ($casa == 2) {

                    if ($n[$x] == '1') {

                        $indice = '1' . $n[$x + 1];
                        $casa = 0;
                    } else {

                        $indice = $n[$x];
                    }

                    if ($n[$x] != '0') {

                        if (isset($n[$x - 1])) {

                            $numero .= ' e ';
                        }

                        $numero .= $numeros[2][$indice];
                    }
                }

                if ($casa == 1) {

                    if ($n[$x] != '0') {
                        if ($numeros[1][$n[$x]] <= 10)
                            $numero .= ' ' . $numeros[1][$n[$x]];
                        else
                            $numero .= ' e ' . $numeros[1][$n[$x]];
                    } else {

                        $numero .= '';
                    }
                }

                if ($pulaum) {

                    $casa--;
                    $x++;
                    $pulaum = false;
                }

                $casa--;
                $x++;
            }

            return $numero;
        }
        
        //funcao de valor por extenso
         /**
         * Retorna uma string do valor 
         *  
         * @param string $n - Valor a ser traduzido, pode ser no formato americano ou brasileiro
         * @example escreverValorMoeda('1.530,64');
         * @example escreverValorMoeda('1530.64');
         * @return string 
         */
        function escreverValorMoeda($n){
            //Converte para o formato float 
            if(strpos($n, ',') !== FALSE){
                $n = str_replace('.','',$n); 
                $n = str_replace(',','.',$n);
            }

            //Separa o valor "reais" dos "centavos"; 
            $n = explode('.',$n);

            return ucwords($this->numeroEscrito($n[0])). ' reais' . ((isset($n[1]) && $n[1] > 0)?' e '.  $this->numeroEscrito($n[1]).' centavos.':'');

        }
        
        //fim funcao por valor extenso
        //Fim Funções para retornar valores por extenso

        
        public function testedb(){
            //echo $this->Mycal_model->get_calendar_data('2016','10');
            $this->load->helper('array');
            $this->load->model('Mycal_model');
            $testeDB = $this->Mycal_model->pega_dados_calendario('2016','10');
            var_dump($testeDB);
            foreach ($testeDB as $linhaEvento){
                echo $linhaEvento."<br>";
            }
        }
        
        
        
        
        public function wp(){
            
            //$this->load->library('Wpintegration');
            
             if ( is_user_logged_in() ) {
                $current_user = wp_get_current_user();
                printf( 'Personal Message For %s!', esc_html( $current_user->user_firstname ) );
                var_dump($current_user);
            } else {
                echo( 'Non-Personalized Message!' );
            } 
            
            //echo $this->loginLink();

            /**
            //Pegando dados WP       
            $taxonomy = 'product_cat';
            $orderby = 'name';
            $show_count = 0; // 1 for yes, 0 for no
            $pad_counts = 0; // 1 for yes, 0 for no
            $hierarchical = 1; // 1 for yes, 0 for no
            $title = '';
            $empty = 0;

            $args = array(
                'taxonomy' => $taxonomy,
                'orderby' => $orderby,
                'show_count' => $show_count,
                'pad_counts' => $pad_counts,
                'hierarchical' => $hierarchical,
                'title_li' => $title,
                'hide_empty' => $empty
            );                      
            //fim pegando dados WP
            
            $all_categories = get_categories( $args );
            foreach ($all_categories as $cat)
                {   
                    if($cat->category_parent == 0) {
                        $category_id = $cat->term_id;
                        $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
                        $image = wp_get_attachment_url( $thumbnail_id );
                        echo "<ul class='category'><li>".$cat->name;
                        $args2 = array(
                            'taxonomy' => $taxonomy,
                            'child_of' => 0,
                            'parent' => $category_id,
                            'orderby' => $orderby,
                            'show_count' => $show_count,
                            'pad_counts' => $pad_counts,
                            'hierarchical' => $hierarchical,
                            'title_li' => $title,
                            'hide_empty' => $empty
                        );  
                        $sub_cats = get_categories( $args2 );
                        if($sub_cats) {
                           foreach($sub_cats as $sub_category) {
                               echo "<ul class='subcategory'>";
                               if($sub_cats->$sub_category == 0) {
                                  echo "<li>".$sub_category->cat_name; 
                               }
                           } 
                        }   
                    }
                }
                **/
                
            
            
            
            $this->load->view('testewp'); 
              
              
        }
        
        
        //WP Functions
        public function loginLink()
        {
            $CI = & get_instance();
            $CI->load->helper('ci_url');
            $redirect = current_url();

            return wp_login_url()."?redirect_to=$redirect";
        }
        
}
