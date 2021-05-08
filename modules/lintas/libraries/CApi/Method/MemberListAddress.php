<?php
namespace Lintas\libraries\CApi\Method;
use Lintas\libraries\CApi\Method;
use DB;
use Illuminate\Support\Arr;

class MemberListAddress extends Method {
    public function execute() {
        $err_code = 0;
        $err_message = '';
        $data = array();
        $request = $this->request();
        $member_id = Arr::get($request, 'member_id');

        if ($err_code == 0) {
            if (empty($member_id)) {
                $err_code++;
                $err_message = 'member_id is required.';
            }
        }

        if ($err_code == 0) {
            $q = '
                SELECT
                    ma.id as penjahit_address_id,
                    ma.penjahit_id, ma.type, ma.name, ma.phone, ma.address, ma.postal,
                    ma.email,
                    ma.lat as lat, ma.long as `long`,
                    ma.province_id as province_id, p.name as province_name,
                    ma.city_id as city_id, ci.name as city_name,
                    -- ma.districts_id, d.name as district_name,
                    ma.is_active
                FROM
                    penjahit_address ma
                    left join province p on p.id = ma.province_id
                    left join city ci on ci.id = ma.city_id
                    -- left join districts d on d.id = ma.districts_id
                WHERE ma.status > 0
                AND ma.penjahit_id = ' . ($member_id) . '
                ORDER BY ma.id desc
              ';
            $r = DB::select(DB::raw($q));
            if(count($r) > 0) {
                $billing = array();
                $shipping = array();
                foreach ($r as $row) {
                    $arr_data = array();
                    $arr_data['penjahit_address_id'] = $row->penjahit_address_id;
                    $arr_data['is_main_address'] = $row->is_active;
                    $arr_data['type'] = $row->type;
                    $arr_data['name'] = $row->name;
                    $arr_data['address'] = $row->address;
                    $arr_data['phone'] = $row->phone;
                    $arr_data['postal'] = $row->postal;
                    $arr_data['email'] = $row->email;
                    $arr_data['country_id'] = $row->country_id;
                    $arr_data['country_name'] = $row->country_name;
                    $arr_data['province_id'] = $row->province_id;
                    $arr_data['province_name'] = $row->province_name;
                    $arr_data['city_id'] = $row->city_id;
                    $arr_data['city_name'] = $row->city_name;
                    //$arr_data['districts_id'] = $row->districts_id;
                    //$arr_data['district_name'] = $row->district_name;
                    $arr_data['lat'] = $row->lat;
                    $arr_data['long'] = $row->long;
                    if ($row->type == 'billing') {
                        $billing[] = $arr_data;
                    }
                    if ($row->type == 'shipping') {
                        $shipping[] = $arr_data;
                    }
                }
                $data[] = array('billing' => $billing);
                $data[] = array('shipping' => $shipping);
            }
        }

        $this->err_code = $err_code;
        $this->err_message = $err_message;
        $this->data = $data;
        return $this;
    }
}