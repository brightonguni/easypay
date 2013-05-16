<?php
/**
 * Easypay Communication Simple Library
 * @package 	Easypay-PHP
 * @subpackage	api
 * @version 	1.0.0
 * @author 		Ricardo Lopes
 * @copyright	Easypay
 * @license		GPL v2
 */
class Easypay
{
	/**
	 * Request Reference Holder
	 * @access 	private
	 * @var 	string
	 */
	private $request_reference = "";
	
	/**
	 * Request Reference Holder
	 * @access 	private
	 * @var 	string
	 */
	private $request_payment = "";
	
	/**
	 * Request Reference Holder
	 * @access 	private
	 * @var 	string
	 */
	private $request_payment_data = "";
	
	/**
	 * Request Reference Holder
	 * @access 	private
	 * @var 	string
	 */
	private $request_payment_list = "";
        
	/**
	 * Request Reference Holder
	 * @access 	private
	 * @var 	string
	 */
	private $request_transaction_key_verification = "";
        
	/**
	 * Test Server
	 * @access 	private
	 * @var 	string
	 */
	private $test_server = 'http://test.easypay.pt/';
	
	/**
	 * Live Server
	 * @access 	private
	 * @var 	string
	 */
	private $production_server = 'https://www.easypay.pt/';
	
	/**
	 * URI holder
	 * @access 	private
	 * @var 	string
	 */
	private $uri = array();
	
	/**
	 * Mode Holder
	 * @var string
	 */
	private $live_mode = false;
	
	/**
	 * Define Country
	 * @access 	private
	 * @var 	string
	 */
	private $country = 'PT';
	
	/**
	 * Define Language
	 * @access 	private
	 * @var 	string
	 */
	private $language = 'PT';
	
	/**
	 * Define reference type
	 * @access 	private
	 * @var 	string
	 */
	private $ref_type = 'auto';
	
	/**
	 * Define user
	 * @access 	private
	 * @var 	string
	 */
	private $user = '' ;
	
	/**
	 * Define CIN
	 * @access 	private
	 * @var 	string
	 */
	private $cin = '' ;
	
	/**
	 * Define Entity
	 * @access 	private
	 * @var 	string
	 */
	private $entity = '' ;
	
        /**
	 * Define Custumer Name
	 * @access 	private
	 * @var 	string
	 */
        private $name = '';
        
        /**
	 * Define Description
	 * @access 	private
	 * @var 	string
	 */
        private $description = '';
        
        /**
	 * Define Observations
	 * @access 	private
	 * @var 	string
	 */
        private $observation = '';
        
        /**
	 * Define Custumer Mobile Contact
	 * @access 	private
	 * @var 	string
	 */
        private $mobile = '';
        
        /**
	 * Define Custumer Email
	 * @access 	private
	 * @var 	string
	 */
        private $email = '';
        
        /**
	 * Defines the transference Value
	 * @access 	private
	 * @var 	string
	 */
        private $value = '';
        
        /**
	 * Defines the transference Key
	 * @access 	private
	 * @var 	string
	 */
        private $key = '';

        /**
	 * Handler for easypay communications
	 */
	public function __construct( $params = array() )
	{
		@require( dirname(__FILE__) . '/Easypay-config.php' );
		
		foreach( $ep_conf as $key => $value )
		{
			$this->$key = $value;
		}
		
		foreach( $params as $key => $value)
		{
			$this->$key = $value;
		}
	}
	
	/**
	 * Creates a New Reference
	 * @param string $type ["normal", "boleto", "recurring", "moto"]
	 * @return array
	 */
	public function createReference( $type = 'normal' )
	{
 		$this->_add_uri_param('ep_user', $this->user);
 		$this->_add_uri_param('ep_entity', $this->entity);
 		$this->_add_uri_param('ep_cin', $this->cin);
 		$this->_add_uri_param('t_value', $this->value);
 		$this->_add_uri_param('t_key', $this->key);
 		$this->_add_uri_param('ep_language', $this->language);
 		$this->_add_uri_param('ep_country', $this->country);
 		$this->_add_uri_param('ep_ref_type', $this->ref_type);
 		$this->_add_uri_param('o_name', $this->name);
 		$this->_add_uri_param('o_description', $this->description);
 		$this->_add_uri_param('o_obs', $this->observation);
 		$this->_add_uri_param('o_mobile', $this->mobile);
 		$this->_add_uri_param('o_email', $this->email);
 		                
 		switch ($type)
 		{
 			case 'boleto':
 				$this->_add_uri_param('ep_type', 'boleto');
 			break;
 			
 			case 'recurring':
 				$this->_add_uri_param('ep_rec_type', 'yes');
 			break;
 			
 			case 'moto':
 				$this->_add_uri_param('ep_type', 'moto');
 			break;
 			
 			default:
 			break;
 		}
                                
 		return $this->_xmlToArray( $this->_get_contents( $this->_get_uri( $this->request_reference)));
	}
	
	/**
	 * Request a Payment
	 * @param string $type ["credit-card", "recurring"]
	 * @return array
	 */
	public function requestPayment( $reference, $key, $type = 'credit-card')
	{
		$this->_add_uri_param('u', $this->user);
		$this->_add_uri_param('e', $this->entity);
		$this->_add_uri_param('r', $reference);
		$this->_add_uri_param('l', $this->language);
		$this->_add_uri_param('k', $key);
		//@todo check this for rec payment types	
		switch ($type)
		{
			case 'recurring':
				$this->_add_uri_param('ep_rec_type', 'yes');
			break;
			default:break;
		}
                                
		return $this->_xmlToArray( $this->_get_contents( $this->_get_uri( $this->request_payment)));
	}
	
	/**
	 * Returns an array with the requested payment information
	 */
	public function getPaymentInfo( $ep_doc = false )
	{
		if(!$ep_doc)
			throw new Exception("ep_doc is required for the communication");
		
		$this->_add_uri_param('ep_user', $this->user);
		$this->_add_uri_param('ep_cin', $this->cin);
		$this->_add_uri_param('ep_doc', $ep_doc);
                                
		return $this->_xmlToArray( $this->_get_contents( $this->_get_uri( $this->request_payment)));
	}
        
    /**
     * Returns an array with the transaction verification
     */    
    public function getTransactionVerification( $reference )
    {
		$this->_add_uri_param('ep_cin', $this->cin);
		$this->_add_uri_param('ep_user', $this->user);
		$this->_add_uri_param('e', $this->entity);
		$this->_add_uri_param('r', $reference);
		$this->_add_uri_param('c', $this->country);
                
        return $this->_xmlToArray( $this->_get_contents( $this->_get_uri( $this->request_transaction_key_verification)));                
    }

    /**
	 * Set current working mode
	 */
	public function set_live( $boolean = false )
	{
		$this->live_mode = $boolean; 
	}

	/**
	 * Generates a reference with design from easypay
	 */
	public function createPaymentWithDesign( $paymentTypes = array() )
	{
		if( empty( $paymentTypes ) )
			$paymentTypes = array('multibanco');

		if( in_array('boleto',$paymentTypes) ) 
		{
			$res = $this->createReference('boleto');
		} else {
			$res = $this->createReference();
		}


	}

	private function _design( $type = '', $params = array() )
	{

		switch ($type)
		{
			
		}
	}
	
	/**
	 * Returns a string from a link via cUrl
	 * @param string $url
	 * @param string $type
	 * @throws Exception
	 * @return string
	 */
	private function _get_contents( $url, $type = 'GET' )
	{            
		$curl = curl_init();
		
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
                
		if( strtoupper($type) == 'GET') {
			//curl_setopt($curl, CURLOPT_HTTPGET, TRUE);
		} elseif( strtoupper($type) == 'POST' ) {
			curl_setopt($curl, CURLOPT_POST, TRUE);
		} else {
			throw new Exception('Communication Error, standart communication not selected, POST or GET required');
		}
		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		
		$result = curl_exec( $curl );
		
		curl_close($curl);
		
		return $result;
	}
	
	/**
	 * Returns an array from and xml formated string
	 * @param string $string
	 * @return array
	 */
	private function _xmlToArray( $string )
	{
		$obj = simplexml_load_string($string);
		
		return json_decode( json_encode($obj), true);
	}
	
	/**
	 * Adds a parameter to our URI
	 * @param string $key
	 * @param string $value
	 */
	private function _add_uri_param( $key, $value )
	{
		$this->uri[$key] = $value;
	}
	
	/**
	 * Returns and clears the URI
	 * @param string $endPoint
	 * @return string
	 */
	private function _get_uri( $endPoint )
	{
		if( $this->live_mode)
		{
			$str = $this->production_server;
		} else {
			$str = $this->test_server;
		}
		
		$str .= $endPoint;
		
		if( isset( $this -> code ) && $this -> code )
		{
			$this -> uri['s_code'] = $this -> code;
		}

		$tmp = str_replace(' ', '+', http_build_query( $this -> uri ) );

		$this->uri = array();

		return ( $str . '?' . $tmp );
		
	}
}