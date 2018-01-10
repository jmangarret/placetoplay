<?php
session_start();
/*Parametros para cache soap*/
ini_set('soap.wsdl_cache_enabled', 1);
ini_set('soap.wsdl_cache_ttl', 86400);

class Transaction extends CI_Controller {
	/**
	 * Index Page for this controller.
	 *
	 */
	public function __construct()
	{
		parent::__construct();		
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->library('form_validation');
		$this->load->model('transaction_model');
	}
	
	/*Controlador inicial*/
	public function index()
	{
		/*Obtenemos lista de bancos para el select*/
		$data['bankOptions'] = $this->transaction_model->getBankOptions();
		/*Cargamos vistas del formulario de pago*/
		$this->load->view('templates/header');
		$this->load->view('transaction/index', $data);
		$this->load->view('templates/footer');
	}		
	/*Controlador al Enviar Pago*/
	public function create()
	{	
		/*Seteamos validaciones de form*/
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger fade in">','</div>');
		$this->form_validation->set_rules('bankCode', 'Debe seleccionar el banco', 'required');
		$this->form_validation->set_rules('bankInterface', 'Campo Banco', 'required');
		$this->form_validation->set_rules('reference', 'Campo Referencia', 'required');
		$this->form_validation->set_rules('description', 'Campo Descripcion', 'required');
		$this->form_validation->set_rules('totalAmount', 'Campo Total a Pagar', 'required');
		$this->form_validation->set_rules('taxAmount', 'Campo Impuesto', 'required');
		$this->form_validation->set_rules('devolutionBase', 'Campo Impuesto', 'required');
		$this->form_validation->set_rules('tipAmount', 'Campo Impuesto', 'required');
		$this->form_validation->set_rules('document', 'Campo Nro. de Identificacion', 'required');
		$this->form_validation->set_rules('firstName', 'Campo Nombre', 'required');
		$this->form_validation->set_rules('lastName', 'Campo Apellido', 'required');
		$this->form_validation->set_rules('company', 'Campo Compania', 'required');
		$this->form_validation->set_rules('emailAddress', 'Campo Email', 'required');
		$this->form_validation->set_rules('address', 'Campo Direccion', 'required');
		$this->form_validation->set_rules('city', 'Campo Ciudad', 'required');
		$this->form_validation->set_rules('province', 'Campo Departamento', 'required');
		$this->form_validation->set_rules('phone', 'Campo Telf. Local', 'required');
		$this->form_validation->set_rules('mobile', 'Campo Celular', 'required');
		/*Si faltan campos requeridos retornamos sino ejecutamos la transaccion*/
		if ($this->form_validation->run() === FALSE)
		{
			$data['bankOptions'] = $this->transaction_model->getBankOptions();
			$this->load->view('templates/header');
			$this->load->view('transaction/index', $data);
			$this->load->view('templates/footer');
		}
		else
		{
			/*Invocamos al modelo que creara la transaccion*/
			$transaction= $this->transaction_model->setTransaction();

			$data["transactionID"]  	= $transaction->createTransactionResult->transactionID;
			$data["returnCode"]			= $transaction->createTransactionResult->returnCode;
			$data["responseReasonCode"] = $transaction->createTransactionResult->responseReasonCode;
			$data["responseReasonText"] = $transaction->createTransactionResult->responseReasonText;
			$data["bankURL"] 			= $transaction->createTransactionResult->bankURL;
			/*Si se crea la transaccion redireccionamos al banco, sino volvemos al form*/
			if ($data["returnCode"]=="SUCCESS") {
				$_SESSION["transactionID"]=$data["transactionID"];
				redirect($transaction->createTransactionResult->bankURL, 'refresh');
			}else{
				$data['bankOptions'] = $this->transaction_model->getBankOptions();
				$data['returnCode']  = "FAILED";
				$this->load->view('templates/header');
				$this->load->view('transaction/index', $data);
				$this->load->view('templates/footer');
			}
		}
	}

	public function view()
	{
		/*Obtenemos variables del modelo para conectarnos al WS*/
		$auth 		= $this->transaction_model->getAuth();
		$client		= $this->transaction_model->getClient();
		/*Obtenemos informacion de la transaccion, al retornar del simulador de banco*/
		$transaction= $client->getTransactionInformation(array('auth' => $auth,'transactionID'=>$_SESSION["transactionID"]));
		$data["transactionID"] 		= $transaction->getTransactionInformationResult->transactionID;
		$data["reference"] 			= $transaction->getTransactionInformationResult->reference;
		$data["returnCode"] 		= $transaction->getTransactionInformationResult->returnCode;
		$data["transactionState"] 	= $transaction->getTransactionInformationResult->transactionState;
		$data["responseReasonText"] = $transaction->getTransactionInformationResult->responseReasonText;
		/*Desplegamos vista con status de la transaccion*/
		$this->load->view('templates/header');
		$this->load->view('transaction/view', $data);
		$this->load->view('templates/footer');

	}	

}

/* End of file transaction.php */
/* Location: ./application/controllers/transaction.php */