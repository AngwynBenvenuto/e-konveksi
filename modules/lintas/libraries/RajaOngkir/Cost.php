<?php
namespace Lintas\libraries\RajaOngkir;
use Lintas\libraries\RajaOngkir\Api;
class Cost extends Api {
	protected $method = "cost";	
	public function __construct($attributes){
		parent::__construct();
		
		$this->overWriteOptions = [
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => http_build_query($attributes),
			CURLOPT_HTTPHEADER => [
				"content-type: application/x-www-form-urlencoded",
	    		"key: ".$this->apiKey
			]
		];
		$this->getData();
	}
}