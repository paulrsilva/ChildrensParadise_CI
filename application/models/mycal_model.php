<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mycal_model
 *
 * @author paulinorochaesilva
 */
class Mycal_model extends CI_Model  {
    
    var $conf;
    
    function __construct(){
       parent::__construct();
       //$this->load->database(); //já está no autoload  
       
       $this->conf = array(
            'start_day' => 'monday',
            'day_type' => 'short',
            'show_next_prev' => true,
            'next_prev_url' => base_url().'ci/index.php/childrens/index'
            //'next_prev_url' => base_url().'ci/index.php/childrens/display'
        );
       
        $this->conf['template'] = '
            {table_open}<table border="0" cellpadding="0" cellspacing="0" class="calendar">{/table_open}

            {heading_row_start}<tr class="heading">{/heading_row_start}

            {heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
            {heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
            {heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}

            {heading_row_end}</tr>{/heading_row_end}

            {week_row_start}<tr>{/week_row_start}
            {week_day_cell}<td>{week_day}</td>{/week_day_cell}
            {week_row_end}</tr>{/week_row_end}

            {cal_row_start}<tr class="days">{/cal_row_start}
            {cal_cell_start}<td class="day">{/cal_cell_start}
            {cal_cell_start_today}<td>{/cal_cell_start_today}
            {cal_cell_start_other}<td class="other-month">{/cal_cell_start_other}

            {cal_cell_content}
                <div class="day_num">{day}</div>
                <div class="content">{content}</div>
            {/cal_cell_content}
            {cal_cell_content_today}
                <div class="day_num highlight">{day}</div>
                <div class="content">{content}</div>
            {/cal_cell_content_today}

            {cal_cell_no_content}<div class="day_num">{day}</div>{/cal_cell_no_content}
            {cal_cell_no_content_today}<div class="day_num highlight">{day}</div>{/cal_cell_no_content_today}

            {cal_cell_blank}&nbsp;{/cal_cell_blank}

            {cal_cell_other}{day}{/cal_cel_other}

            {cal_cell_end}</td>{/cal_cell_end}
            {cal_cell_end_today}</td>{/cal_cell_end_today}
            {cal_cell_end_other}</td>{/cal_cell_end_other}
            {cal_row_end}</tr>{/cal_row_end}

            {table_close}</table>{/table_close}
        ';
       
    }
    
    function get_calendar_data($year, $month){
        //$query =  $this->db->select('data, evento')->from('calendario')->like('data', "$year-$month", 'after')->get();
        
        $this->db->select('data, evento');
        $this->db->from('calendario');
        $this->db->like('data',"$year-$month",'after');
        $query=  $this->db->get();
        
        $cal_data=array();
        
        foreach ($query->result() as $row){
            
            $cal_data[substr($row->data,8,2)]=$row->evento;    
        }     
        
        return $cal_data;
    }
    
    
    
    
    function pre_agendamento_calendario($data, $email){
        
        /**
        // verifica se a data solicitada está livre
        
        // se não estiver, verifica o email da solicitação
        
        // se o email for o mesmo, leva o usuário à página de login para gestão do evento
        
        // se o email for diferente, verifica se ouve confirmação de email
        
        // verifica prazo de pagto (4 dias)
        
        // marca como - solicitado/Pre-Agendado/Agendado
        
        //se não estiver pago ainda, coloca na lista de espera
         * 
         */
        
        $data_sol = date('Y-m-d');
        
        if($this->db->select('data')->from('calendario')->where('data', $data)->count_all_results()){
            
            $this->db->where('data', $data)
                    ->update('calendario', array(
                'data' =>$data,
                'email_reserva' => $email,
                'data_solicitacao' => $data_sol              
            ));
                return $this->db->insert_id();
            
                }else{
                     $this->db->insert('calendario', array(
                    'data' =>$data,
                    'email_reserva' => $email,
                    'data_solicitacao' => $data_sol
                ));
                return $this->db->insert_id();
            }  
            return $this->db->insert_id();
    }
    
    public function insertToken($evento_id)
        {   
            $token = substr(sha1(rand()), 0, 30); 
            $date = date('Y-m-d');

            $string = array(
                    'token'=> $token,
                    'evento_id'=>$evento_id,
                    'created'=>$date
                );
            $query = $this->db->insert_string('tokens',$string);
            $this->db->query($query);
            return $token;
        }   
        
    public function isTokenValid($token)
        {
        
            //mudando o charset (collation) pra manter compatibilidade com o mysql
            $this->db->query("SET NAMES 'latin1'");
            //$this->db->insert('table_name', $data);
        
            //fim mudança collation
        
            $q = $this->db->get_where('tokens', array('token' => $token), 1);        
            if($this->db->affected_rows() > 0){
                $row = $q->row();             
                $created = $row->created;
                $utilizado = $row->utilizado;
                $createdTS = strtotime($created);
                $today = date('Y-m-d'); 
                $todayTS = strtotime($today);
                
                //echo $utilizado;

                if(($createdTS != $todayTS) OR ($utilizado==='1') ){
                    return false;
                }
                
                

                $calendar_info = $this->pegaInfoCalendar($row->evento_id);
                return $calendar_info;

            }else{
                return false;
            }
            
            /**
            $q = $this->db->get_where('tokens', array('token' => $token), 1);        
            if($this->db->affected_rows() > 0){
                $row = $q->row();             

                $created = $row->created;
                $createdTS = strtotime($created);
                $today = date('Y-m-d'); 
                $todayTS = strtotime($today);

                if($createdTS != $todayTS){
                    return false;
                }

                $user_info = $this->getUserInfo($row->user_id);
                return $user_info;
            
            }else{
            return false;
            }
            **/
        
        } 
        
    
   
    public function confirma_email_calendario($idCalendario) {
       $dataConfirmacao = date('Y-m-d'); //pega a data atual
       $data=array(
           'data_confirmacao' => $dataConfirmacao,
           'email_confirmado' =>1  
       );

        $this->db->where('id', $idCalendario);
        $this->db->update('calendario',$data);
        $success = $this->db->affected_rows();
        if(!$success){
            //echo 'impossivel atualizar user';
            error_log("Impossivel atualizar conf. de email para o evento: $idCalendario ");
            return false;
        }
        return TRUE;
    }
    
    public function confirma_evento_calendario($idCalendario,$evento){
        $data=array(
            'evento' => $evento
        );
        $this->db->where('id', $idCalendario);
        $this->db->update('calendario',$data);
        $success = $this->db->affected_rows();
        if(!$success){
            //echo 'impossivel atualizar e';
            error_log("Impossivel atualizar  o evento: $idCalendario ");
            return false;
        }
        return TRUE;      
        
    }
    
    public function criaUser($data){
        $this->db->insert('users', $data);
        if(!$success){
            //echo 'impossivel atualizar e';
            error_log("Impossivel incluir user");
            return false;
        }
       return $this->db->insert_id(); 
    }
    
    public function UsuariosDuplicados($email){
        
        $numeroUsuarios = $this->db->select('*')->from('users')->where('email', $email)->count_all_results();
        
        if ($numeroUsuarios>1){
            return $numeroUsuarios;
        } else {
            return false;
        }
        
      
        /**
        $query = $this->db->select('*')->from('calendario')->where('email_reserva', $email);
        $numero_eventos = $query->count_all_results();
         * 
         */
        
        
    }
    
    
    public function pegaDadosUser_EB($email){
                $numero_eventos = $this->db->select('*')->from('calendario')->count_all_results();

        
    }

    

    
    public function verifica_calendarioUser($email){
        $q = $this->db->get_where('users', array('email' => $email), 1);  
        if($this->db->affected_rows() > 0){
            $row = $q->row();
            //return $row;
            
            //return $this->db->get('users')->row()->id;
            return $row;
            
            
            
            //return true;
        }else{
            return false;
        }  
    }
  
    
    public function criaPagto($dadosPagto){
        $this->db->insert('pagamentos',$dadosPagto);
        $success = $this->db->affected_rows();
        if(!$success){
            //echo 'impossivel atualizar e';
            error_log("Impossivel incluir dados Pagto");
            return false;
        }
       return $this->db->insert_id(); 
    }
    
    
    
    public function atualizaDadosPagto($idEvento, $data){
        $this->db->where('calendario_id', $idEvento);
        $this->db->update('pagamentos', $data); 
        $success = $this->db->affected_rows();
        if(!$success){
            //echo 'impossivel atualizar e';
            error_log("Impossivel atualizar pagamentos");
            return false;
        }
       return $this->db->insert_id();         
        
    }
    
    
    public function atualizaUsuario($idUser,$data){
        $this->db->where('id',$idUser);
        $this->db->update('users',$data);
        $success = $this->db->affected_rows();
        if(!$success){
            error_log("Impossivel atualizar usuario/cliente");
            return false;
        }
        return $this->db->insert_id();           
    }
   
    
    public function atualizaAgenda($idEvento, $data){
        $this->db->where('id', $idEvento);
        $this->db->update('calendario', $data); 
        $success = $this->db->affected_rows();
        if(!$success){
            error_log("Impossivel atualizar agenda");
            return false;
        }
       return $this->db->insert_id();  
    }








    public function marca_token($token){
        $data = array('utilizado'=>1);
        $this->db->where('token', $token);
        $this->db->update('tokens',$data);
        $success = $this->db->affected_rows();
        if(!$success){
            //echo 'impossivel atualizar user';
            error_log("Impossivel atualizar token: $token ");
            return false;
        }
        return TRUE;  
    }


    
    public function pegaInfoCalendar($id)
     {
       $q = $this->db->get_where('calendario', array('id' => $id), 1);  
        if($this->db->affected_rows() > 0){
            $row = $q->row();
            return $row;
        }else{
            error_log('evento não encontrado('.$id.')');
            return false;
        }
    }
    
    public function updateUserInfo($post)
    {
        $data = array(
               //'password' => $post['password'],
               'last_login' => date('Y-m-d h:i:s A'), 
               'status' => $this->status[1],
                'email_verificado' => 1 //se a primeira verificação for por email
            );
        
        $this->db->where('id', $post['user_id']);
        $this->db->update('users', $data); 
        $success = $this->db->affected_rows(); 
              
        if(!$success){
            //echo 'impossivel atualizar user';
            error_log('Unable to updateUserInfo('.$post['user_id'].')');
            return false;
        }
        
        $user_info = $this->getUserInfo($post['user_id']); 
        return $user_info; 
    }
    
    
    function add_calendar_data($data, $evento){
        
        /**
         *         $condition = "user_name =" . "'" . $username . "'";
        $this->db->select('*');
        $this->db->from('user_login');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
        return $query->result();
        } else {
        return false;
        }
         */

        if($this->db->select('data')->from('calendario')->where('data', $data)->count_all_results()){
            
            $this->db->where('data', $data)
                    ->update('calendario', array(
                'data' =>$data,
                'evento' => $evento   
            ));
            
            }else{
                 $this->db->insert('calendario', array(
                'data' =>$data,
                'evento' => $evento   
            ));

            }
        }
    
    function pega_dados_calendario($ano, $mes){
        $this->db->select('*');
        $this->db->from('calendario');
        $this->db->like('data',"$ano-$mes",'after');
        $this->db->order_by('data','asc');
        $query=  $this->db->get();
        $dados_calendario=array();
        
        $diaDeHj = date('d');
        $MesAtual = date('m');
        $AnoAtual = date('Y');               
        
        //Icones
        $iconPagtoOk = "<span class='glyphicon glyphicon-thumbs-up' aria-hidden='true'></span>";
        $iconAguardConf = "<span class='glyphicon glyphicon-time' aria-hidden='true'></span>";
        $iconNaoConf = "<span class='glyphicon glyphicon-erase' aria-hidden='true'></span>";
        $iconEnviadoEmail =  "<span class='glyphicon glyphicon-envelope' aria-hidden='true'></span>";
        
        foreach ($query->result() as $linhaEvento){     
            /**
            // Os eventos de calendário abaixo de 10 não eram mostrados. 
            // isto pque datas abaixo de 10 sao armazenadas como zero na primeira decimal
            // fazendo um ajuste em [substr($linhaEvento->data,8,2)] 
            // ($dados_calendario[substr($linhaEvento->data,8,2)]=$linhaEvento->evento;)
             * 
             */
            
            
            //Verificar valores de confirmação, reserva e pago pra passar na geracao de dados do calendario     
            $AnoReserva = date('Y',strtotime($linhaEvento->data_confirmacao));
            $MesReserva = date('m',strtotime($linhaEvento->data_confirmacao));
            $diaConfReserva = date('d',strtotime($linhaEvento->data_confirmacao));
            
            
  
            if (isset($linhaEvento->email_reserva) AND $linhaEvento->email_Confirmado==1){
                    if (isset($linhaEvento->evento)){
                        if ($linhaEvento->reserva_paga==1){ //reserva paga
                            $sitEvento = $iconPagtoOk." ";
                        } elseif (($AnoAtual==$AnoReserva) AND ($MesAtual==$MesReserva)) {//aguardando conf. pagto
                            if (($diaDeHj-$diaConfReserva)<=4){
                                $sitEvento=$iconAguardConf." ";
                            } else {
                                //cancelar evento agenda
                                $sitEvento = $iconNaoConf." ";
                            }                       
                        }     
                    }elseif($linhaEvento->reserva_paga==1){
                        $sitEvento=$iconPagtoOk." ";       
                    } else {
                        if (($diaDeHj-$diaConfReserva)<=4){
                          $sitEvento =$iconAguardConf." ";
                          //enviar email para nome evento
                        } else {
                            //cancelar evento agenda
                            $sitEvento =$iconNaoConf." ";
                        }
                    }
                } elseif(isset($linhaEvento->email_reserva)) {
                    if (($AnoAtual==$AnoReserva) AND ($MesAtual==$MesReserva)){
                       if (($diaDeHj==$diaConfReserva)){//aguardando confirmacao
                          $sitEvento=$iconEnviadoEmail." "; 
                       } else {
                          //cancelar evento agenda
                          $sitEvento =$iconNaoConf." "; 
                       }
                    }
                } else {
                   $sitEvento =$iconEnviadoEmail." ";  
                }
            
            if ($linhaEvento->data_confirmacao==NULL){
                $sitEvento =$iconEnviadoEmail.' ';     
            }
            
            if (substr($linhaEvento->data,8,1)==0){
                $dados_calendario[substr($linhaEvento->data,9,1)]=$sitEvento.$linhaEvento->evento;
            } else {
                $dados_calendario[substr($linhaEvento->data,8,2)]=$sitEvento.$linhaEvento->evento;   
            }      
        }
        return $dados_calendario;
        
    }
    
     
    function PegaTodosEventos(){
        $numero_eventos = $this->db->select('*')->from('calendario')->count_all_results();
        
        $rel_eventos=array();
        
        if ($numero_eventos>=1){
           $query = $this->db->select('*')->from('calendario')->get(); 
           foreach ($query->result() as $row){  
               //verificando confirmacoes de reserva
                if (!$row->data_confirmacao){
                    //adicionar verificação de tempo de reserva
                } else {
                   $nEventosConfirmados= $nEventosConfirmados+1;
                } 
                //verificando pagamento de reservas
                if ($row->reserva_paga){
                   $nEventosPagos=$nEventosPagos+1;  
                }         
            }
        }
        $rel_eventos['confirmados']=$nEventosConfirmados;
        $rel_eventos['pagos']=$nEventosPagos;
        $rel_eventos['numero']=$numero_eventos;
        
        return $rel_eventos;
        
    }
    
    function PegaEventosAgendados_User($email){
            
        /**
        $this->db->select('data, evento');
        $this->db->from('calendario');
        $this->db->like('data',"$year-$month",'after');
        $query=  $this->db->get();
        
        $cal_data=array();
        
        foreach ($query->result() as $row){
            
            $cal_data[substr($row->data,8,2)]=$row->evento;    
        }     
        
        return $cal_data;
        **/
        
        $numero_eventos = $this->db->select('*')->from('calendario')->where('email_reserva', $email)->count_all_results();
        
        //$query=$q->get();
       // $numero_eventos=$q->count_all_results();
        //var_dump($query);
        
        /**
        $this->db->select('*');
        $this->db->from('calendario');
        $this->db->where('email_reserva', $email);
        $query = $this->db->get();  
        $numero_eventos = $this->db->count_all_results();
         * 
         */
        
        $rel_eventos=array();
        //$nEventosConfirmados=0;
        //$nEventosPagos=0;

        if ($numero_eventos>=1){
           $query = $this->db->select('*')->from('calendario')->where('email_reserva', $email)->get(); 
           foreach ($query->result() as $row){  
               //verificando confirmacoes de reserva
                if (!$row->data_confirmacao){
                    //adicionar verificação de tempo de reserva
                } else {
                   $nEventosConfirmados= $nEventosConfirmados+1;
                }
                
                //verificando pagamento de reservas
                if ($row->reserva_paga){
                   $nEventosPagos=$nEventosPagos+1;  
                }         
            }

        }
        
        
        $rel_eventos['confirmados']=$nEventosConfirmados;
        $rel_eventos['pagos']=$nEventosPagos;
        $rel_eventos['numero']=$numero_eventos;
        
        
        //var_dump($rel_eventos);
        
        return $rel_eventos;
        
        /**
        $cal_data=array();
        foreach ($query->result() as $row){
            
            $cal_data[substr($row->data,8,2)]=$row->evento;    
        }  
         * 
         * @return type
         */ 
    }
    
    
    public function DeletaEventoCalendario($idEvento){
        $this->db->where('id',$idEvento);
        $this->db->delete('calendario');
    }
    
    function listaEventosUsuario($email){
        $query=$this->db->query("SELECT * from calendario WHERE email_reserva='$email'");
        return $query; 
    }
    
    function listaTodosEventos(){
        $query=$this->db->query("SELECT * from calendario order by 'data'");
        return $query;
    }
    
    function listaStatusPagto(){
        $query=$this->db->query("SELECT * from StatusPagto ORDER BY 'StatusPagto'");
        return $query->result();        
    }
    
    function listaFormasPagto(){
        $query=$this->db->query("SELECT * from formasPagto ORDER BY 'forma'");
        return $query->result();          
    }
            
    
    function checaUsuario($idEvento, $email){
        
        $query = $this->db->select('email_reserva')->from('calendario')->where('id', $idEvento)->get();
        $ret = $query->row();
        
        if ($ret->email_reserva==$email)
        {
            return TRUE;
        } else {
            return FALSE;  
        }
    }
    
    function dadosPagto($idEvento){   
        
        $q = $this->db->get_where('pagamentos', array('calendario_id' => $idEvento), 1);  
        if($this->db->affected_rows() > 0){
            $row = $q->row();
            return $row;
        }else{
            error_log('pagamento não encontrado('.$id.')');
            return false;
        }
        
    }
   
    /**
    function ListaTodosEventos(){
        //$query=$this->db->query()
        $mes='10';
        $ano='2016';
                
        //$query=$this->db->query("SELECT * from calendario ");
        $query =  $this->db->select('*')->from('calendario')->like('data', "$ano-$mes", 'after')->get();
        return $query->result();          
    }
     * 
     * @param type $ano
     * @param type $mes
     * @return type
     */
            
    function geradata($ano, $mes){
        $this->load->library('calendar', $this->conf);  
        
        //just a test
        //$this->add_calendar_data('2016-10-22', 'funcxxx');
        
        $dados_cal = $this->pega_dados_calendario($ano, $mes);  

        return  $this->calendar->generate($ano,$mes, $dados_cal);
    }
    
    function teste(){
        return 'hoje';
    }
    
    
    //put your code here
}
