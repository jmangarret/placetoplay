<?php
class Transaction_model extends CI_Model {
	public function __construct()
	{
		//$this->load->database();
	}
	/*Funcion para conectarnos al ws - Debe habilitarse la libreria soap en el php.ini*/
	public function getClient()
	{
		$client = new SoapClient(URL_PLACETOPAY, array('trace'=>true));
		$client->__setLocation(LOCATION_PLACETOPAY);
		
		return $client;
	}
	/*Funcion para obtener parametros de peticion al ws*/
	public function getAuth()
	{
		$seed 			= date('c'); 
		$hashString 	= sha1($seed.TRANKEY_PLACETOPAY, false); 
		$auth 			= array(
    		'login' 	=> LOGIN_PLACETOPAY,
    		'tranKey' 	=> $hashString,
    		'seed' 		=> $seed,
		);

		return $auth;
	}
	/*Funcion para obtener bancos del ws y listarlos en las opciones del select*/
	public function getBankOptions()
	{
		/*Listamos bancos disponibles*/
		$listBanks 	= "";
		$auth 		= $this->getAuth();
		$client 	= $this->getClient();
		$response 	= $client->getBankList(array('auth' => $auth));
		foreach ($response->getBankListResult->item as $key => $value) {
			$bankCode 	= $value->bankCode;
			$bankName 	= $value->bankName;  
			$listBanks .="<option value='$bankCode'>$bankName</option>";
		}

		return $listBanks;
	}
	/*Funcion del controlador create para crear la transacion*/
	public function setTransaction()
	{
		$this->load->helper('url');

		$bankCode       = $this->input->post('bankCode');
		$bankInterface  = $this->input->post('bankInterface');
		$reference      = $this->input->post('reference');
		$description    = $this->input->post('description');
		$totalAmount    = $this->input->post('totalAmount');
		$taxAmount      = $this->input->post('taxAmount');
		$devolutionBase = $this->input->post('devolutionBase');
		$tipAmount      = $this->input->post('tipAmount');
		$currency       = 'COP';
		$language       = 'ES';
		//Datos del Pagador => Tipo Person
		$payerPerson=[
		    'document'      => $this->input->post('document'),
		    'documentType'  => $this->input->post('documentType'),
		    'firstName'     => $this->input->post('firstName'),
		    'lastName'      => $this->input->post('lastName'),
		    'company'       => $this->input->post('company'),
		    'emailAddress'  => $this->input->post('emailAddress'),
		    'address'       => $this->input->post('address'),
		    'city'          => $this->input->post('city'),
		    'province'      => $this->input->post('province'),
		    'phone'         => $this->input->post('phone'),
		    'mobile'        => $this->input->post('mobile'),
		    'country'       => "CO",
		];
		// Solicitud de Transaccion
		$PSETransactionRequest = [
		    'bankCode'      => $bankCode,
		    'bankInterface' => $bankInterface,
		    'reference'     => $reference,
		    'description'   => $description,
		    'language'      => $language,
		    'currency'      => $currency,
		    'totalAmount'   => $totalAmount,
		    'taxAmount'     => $taxAmount,
		    'devolutionBase'=> $devolutionBase,
		    'tipAmount'     => $tipAmount,
		    'payer'         => $payerPerson,    
		    'buyer'         => $payerPerson,
		    'returnURL'     => 'http://localhost/CodeIgniterPlacetoPlay/index.php/transaction/view',
		    'ipAddress'     => '127.0.0.1',
		    'userAgent'     => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'CLIENT_USER_AGENT'
		];

		$auth 		= $this->getAuth();
		$client 	= $this->getClient();
		$transaction= $client->createTransaction(array('auth' => $auth, 'transaction' => $PSETransactionRequest));

		return $transaction;
	}	
}