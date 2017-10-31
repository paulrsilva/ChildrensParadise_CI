<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Carrinho
 *
 * @author paulinorochaesilva
 */
class Carrinho extends CI_Controller {
    
        public function __construct() {
            parent::__construct ();

            $this->load->config('pagseguro');
            $this->load->library('PagSeguroLibrary');
        }
    
        
        public function boleto(){
            require './locaweb-gateway-php-master/LocawebGateway.php';
            
            $array_pedido = array(
                'numero'=>13,
                'total'=>10,
                'moeda'=>'real',
                'descricao'=>'Pedido:13'
                );
            
            $array_pagamento = array (
                'meio-pagamento' => 'boleto_itau',
                'data_vencimento' => date("dmY")
            );
            
            $array_comprador = array(
                'nome'=>'John Doe',
                'documento'=>'12345678910',
                'endereco'=>'Rua Pettit Carneiro',
                'numero'=>'98',
                'CEP'=> '80240-050',
                'bairro'=>'Agua Verde',
                'Cidade'=>'Curitiba',
                'estado'=>'PR'
            );
            
            $array_transacao = array(
                'url_retorno'=>  base_url('/ci/carrinho/retorno-pagamento'),
                'capturar'=>'true',
                'pedido'=>$array_pedido,
                'pagamento'=>$array_pagamento,
                'comprador'=>$array_comprador
                
            );
            
            $transação = LocawebGateway::criar($array_transacao)->sendRequest();
            
            echo "<pre>";
            
            print_r($transação);
            
            //echo base_url('/ci/carrinho/retorno-pagamento');
        }
        
        
        
        
        
        public function pagueSeguro(){
            
            // Instantiate a new payment request
            $paymentRequest = new PagSeguroPaymentRequest ();
            
            // Sets the currency
            $paymentRequest->setCurrency ( "BRL" );
            
            // Sets a reference code for this payment request, it is useful to
            // identify this payment in future notifications.
            
            //$paymentRequest->setReference ( $venda->idVenda );
            $paymentRequest->setReference ( '00123' );
            
            // Add an item for this payment request
            //$paymentRequest->addItem ( '0001', substr($promocao->nome, 0, 80), 1, number_format ( $venda->valorDevido, 2, '.', '' ) );
            $paymentRequest->addItem ( '0001', 'Reserva salao', 1, number_format ( 900, 2, '.', '' ) );
            
            /**
            $paymentRequest->setShippingAddress ( str_replace ( '-', '', str_replace ( '.', '', $userObj->CEP ) )
                    , $userObj->endereco
                    , $userObj->numero
                    , $userObj->complemento
                    , $userObj->bairro
                    , $userObj->cidade
                    , (($estadoObj->sigla)? $estadoObj->sigla : ''), 'BRA' );
             * 
             */
            
            $paymentRequest->setShippingAddress (        
                        '80240050',
                        'rua Pettit Carneiro',
                        '631',
                        'apto 31',
                        'agua verde',
                        'Curitiba',
                        'PR',
                        'BRA'
                    );
            
            // Sets your customer information.
            
            /**
            $paymentRequest->setSenderName(substr($userObj->nome,0,40));
            $paymentRequest->setSenderEmail($userObj->email);
            $paymentRequest->setSenderPhone($userObj->telefone1);
            $paymentRequest->setRedirectUrl ( base_url('ofertas/retornoPagamento') );
            $paymentRequest->setMaxAge(86400 * 3);
             * 
             */
            
            $paymentRequest->setSenderName('Sender name');
            $paymentRequest->setSenderEmail('contato@eventosbacacheri.com.br');
            $paymentRequest->setSenderPhone('+554192099962');
            $paymentRequest->setRedirectUrl ( base_url('/ci/carrinho/retornopagto_ps') );
            $paymentRequest->setMaxAge(86400 * 3);
             
            
            try {
                    $credentials = new PagSeguroAccountCredentials ( $this->config->item ( 'pagseguroAccount' ), $this->config->item ( 'pagseguroToken' ) );
                    $url = $paymentRequest->register ( $credentials );
                    $dados = array(
                                    'meioPagamento' => 2
                                    ,'statusPagamento' => 1
                                    ,'dataAtualizacao' => date('Y-m-d H:i:s')
                    );
                    //$this->Vendas_model->update($dados, $venda->idVenda);
                    redirect ( $url );
            } catch ( PagSeguroServiceException $e ) {
                    $this->data['hasError'] = true;
                    $this->data['errorList'][] = array('message' => 'Ocorreu um erro ao comunicar com o Pagseguro.' .$e->getCode() . ' - ' .  $e->getMessage());
            }
            
            var_dump($this->data['errorList']);        
            
            
            
            
        }
        
        public function retornopagto_ps(){
                $transaction = false;
		// Verifica se existe a transação
		if ($this->input->get ( 'idTransacao' )) {
			$transaction = self::TransactionNotification ( $this->input->get ( 'idTransacao' ) );
		}
		// Se a transação for um objeto
		if (is_object ( $transaction )) {
			self::setTransacaoPagseguro($transaction);
		}
		redirect ( base_url('minha-conta') );  
        }
        
        
        	/**
	 * setTransacaoPagseguro
	 *
	 * Seta os status da transação vindas do Pagseguro
	 *
	 * @param array $transaction
	 * @return void
	 */
        
	private function setTransacaoPagseguro($transaction = null) {
		// Pegamos o objeto da transação
		$transactionObj = self::getTransaction ( $transaction );
		// Buscamos a venda
		$filter = array ('idVenda' => $transactionObj ['reference']);
		//$vendaList = $this->Vendas_model->getVenda ( $filter );
		// existindo a venda
                
		//if (is_array ( $vendaList ) && sizeof ( $vendaList ) > 0) {
			//$venda = array_shift($vendaList);
			// Aguardando pagamento
			if ($transactionObj ['status'] == 1) {
				$dados = array(
						'meioPagamento' => 2
						,'statusPagamento' => 1
						,'idTransacao' => $transaction->getCode()
						,'dataAtualizacao' => date('Y-m-d H:i:s')
				);
				//$this->Vendas_model->update($dados, $venda->idVenda);
			}
			// Aguardando aprovação
			if ($transactionObj ['status'] == 2) {
				$dados = array(
						'meioPagamento' => 2
						,'statusPagamento' => 2
						,'idTransacao' => $transaction->getCode()
						,'dataAtualizacao' => date('Y-m-d H:i:s')
				);
				//$this->Vendas_model->update($dados, $venda->idVenda);
			}
			// Transação paga
			if ($transactionObj ['status'] == 3) {
				$lastEvent = strtotime($transaction->getLastEventDate());
				$dados = array(
						'statusPagamento' => 3
						,'valorPago' =>  $transaction->getGrossAmount()
						,'taxas' => $transaction->getFeeAmount()
						,'idTransacao' => $transaction->getCode()
						,'dataAtualizacao' => date('Y-m-d H:i:s')
						,'dataCredito' => date('Y-m-d H:i:s', $lastEvent)
				);
				//$this->Vendas_model->update($dados, $venda->idVenda);
			}
			// Pagamento cancelado
			if ($transactionObj ['status'] == 7 && $venda->statusPagamento != 3) {
				$dados = array(
						'meioPagamento' => 2
						,'statusPagamento' => 7
						,'taxas' => $transaction->getFeeAmount()
						,'idTransacao' => $transaction->getCode()
						,'dataAtualizacao' => date('Y-m-d H:i:s')
				);
				//$this->Vendas_model->update($dados, $venda->idVenda);
			}
		//}
	}
        
        /**
          * getTransaction
          *
          * Método para buscar a transação no pag reguto
          * @access public
          * @param PagSeguroTransaction $transaction
          * @return array
          */
        
         public static function getTransaction(PagSeguroTransaction $transaction) {
                 return array ('reference' => $transaction->getReference (), 'status' => $transaction->getStatus ()->getValue () );
         } 
         
 	/**
	 * NotificationListener
	 *
	 * Recebe as notificações do pagseguro sobre atualização de pagamento.
	 * @access public
	 * @return bool
	 */
	public function NotificationListener() {
		$code = (isset ( $_POST ['notificationCode'] ) && trim ( $_POST ['notificationCode'] ) !== "" ? trim ( $_POST ['notificationCode'] ) : null);
		$type = (isset ( $_POST ['notificationType'] ) && trim ( $_POST ['notificationType'] ) !== "" ? trim ( $_POST ['notificationType'] ) : null);
		$transaction = false;
		if ($code && $type) {
			$notificationType = new PagSeguroNotificationType ( $type );
			$strType = $notificationType->getTypeFromValue ();
			switch ($strType) {
				case 'TRANSACTION' :
					$transaction = self::TransactionNotification ( $code );
					break;
				default :
					LogPagSeguro::error ( "Unknown notification type [" . $notificationType->getValue () . "]" );
			}
		} else {
			LogPagSeguro::error ( "Invalid notification parameters." );
			self::printLog ();
		}
		if (is_object ( $transaction )) {
			self::setTransacaoPagseguro($transaction);
		}
		return TRUE;
	}        
        
        
        
 	/**
	 * TransactionNotification
	 *
	 * Recupera a transação através de uma notificação
	 * @access private
	 * @param unknown_type $notificationCode
	 * @return Ambigous <a, NULL, PagSeguroTransaction>
	 */
	private static function TransactionNotification($notificationCode) {
		$CI = & get_instance ();
		$credentials = new PagSeguroAccountCredentials ( $CI->config->item ( 'pagseguroAccount' ), $CI->config->item ( 'pagseguroToken' ) );
		try {
			$transaction = PagSeguroNotificationService::checkTransaction ( $credentials, $notificationCode );
		} catch ( PagSeguroServiceException $e ) {
			die ( $e->getMessage () );
		}
		return $transaction;
	}
        
        
 	/**
	 * Método que registra logs do pagseguro
	 * @access private
	 * @param String $strType
	 */
	private static function printLog($strType = null) {
		$count = 30;
		echo "<h2>Receive notifications</h2>";
		if ($strType) {
			echo "<h4>notifcationType: $strType</h4>";
		}
		echo "<p>Last <strong>$count</strong> items in <strong>log file:</strong></p><hr>";
		echo LogPagSeguro::getHtml ( $count );
	}       
        
        
        
        
   
   }
