<?php
namespace Lintas\libraries\CApi\Method;
use Lintas\libraries\CApi\Method;
use DB;
use Illuminate\Support\Arr;

class MemberGetAddressType extends Method {
    public function execute() {
        $err_code = 0;
        $err_message = '';
        $data = array();
        $request = $this->request();
        $member_address_id = Arr::get($request, 'member_address_id');

        if($err_code==0){
            if(strlen($member_address_id)==0){
                $err_code++;
                $err_message='member_address_id is required';
            }
        }

        if($err_code == 0) {
            $q = '
                SELECT
                    ma.id as penjahit_address_id,
                    ma.penjahit_id, ma.type, ma.name, ma.phone, ma.address, ma.postal,
                    ma.email, ma.lat as lat, ma.long as `longitude`,
                    ma.province_id as province_id, p.name as province_name,
                    ma.city_id as city_id, ci.name as city_name,
                    -- ma.districts_id as districts_id, d.name as district_name,
                    ma.is_active
                FROM
                    penjahit_address ma
                    left join province p on p.id = ma.province_id
                    left join city ci on ci.id = ma.city_id
                    -- left join districts d on d.id = ma.districts_id
                WHERE ma.status > 0
            ';
            if (strlen($member_address_id) > 0) {
                $q .= " and ma.id = " .($member_address_id);
            }
            $r = DB::select(DB::raw($q));
            if(count($r) > 0) {
                foreach ($r as $row) {
                    $arr = array();
                    $arr['penjahit_address_id'] = $row->penjahit_address_id;
                    $arr['penjahit_id'] = $row->penjahit_id;
                    $arr['type'] = $row->type;
                    $arr['name'] = $row->name;
                    $arr['phone'] = $row->phone;
                    $arr['address'] = $row->address;
                    $arr['postal'] = $row->postal;
                    $arr['email'] = $row->email;
                    $arr['province_id'] = $row->province_id;
                    $arr['province_name'] = $row->province_name;
                    $arr['city_id'] = $row->city_id;
                    $arr['city_name'] = $row->city_name;
                    //$arr['districts_id'] = $row->districts_id;
                    //$arr['district_name'] = $row->district_name;
                    $arr['lat'] = $row->lat;
                    $arr['long'] = $row->longitude;
                    $data = $arr;
                }
            }
        }

        $this->err_code = $err_code;
        $this->err_message = $err_message;
        $this->data=$data;
        return $this;
    }
}