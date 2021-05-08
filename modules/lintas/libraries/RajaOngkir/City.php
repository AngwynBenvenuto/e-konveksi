<?php 
namespace Lintas\libraries\RajaOngkir;
use Lintas\libraries\RajaOngkir\Api;
class City extends Api {
	protected $method = "city";
	public function byProvinsi($province_id){
		$this->parameters = "?province=".$province_id;
		return $this->getData();
	}
}