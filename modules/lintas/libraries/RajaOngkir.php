<?php
namespace Lintas\libraries;
use Lintas\libraries\RajaOngkir\Province;
use Lintas\libraries\RajaOngkir\City;
use Lintas\libraries\RajaOngkir\Cost;

class RajaOngkir {
    public static function city(){
        $kota = new City;
        return $kota;
	}
    
    public static function province(){
		$province = new Province;
        return $province;
	}

    public static function cost($attributes = null){
        $cost = new Cost($attributes);
        return $cost;
	}
}