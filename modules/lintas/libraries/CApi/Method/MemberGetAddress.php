<?php
namespace Lintas\libraries\CApi\Method;
use Lintas\libraries\CApi\Method;
use DB;
use Illuminate\Support\Arr;

class MemberGetAddress extends Method {
    public function execute() {
        $err_code = 0;
        $err_message = '';
        $data = array();
        $request = $this->request();
        $member_id = Arr::get($request, 'member_id');
        $billing_member_address_id = Arr::get($request, 'billing_member_address_id');
        $shipping_member_address_id = Arr::get($request, 'shipping_member_address_id');

        if ($err_code == 0) {
            if (empty($member_id)) {
                $err_code++;
                $err_message = 'member_id is required.';
            }
        }

        if ($err_code == 0) {
            if (empty($billing_member_address_id)) {
                $err_code++;
                $err_message = 'billing_member_address_id is required.';
            }
        }

        if ($err_code == 0) {
            if (empty($shipping_member_address_id)) {
                $err_code++;
                $err_message = 'shipping_member_address_id is required.';
            }
        }

        if ($err_code == 0) {
            $q = '
                SELECT
                        ma.ud as penjahit_address_id,
                        ma.penjahit_id,
                        ma.type,
                        ma.name,
                        ma.phone,
                        ma.address,
                        ma.postal,
                        ma.email,
                        ma.lat as lat,
                        ma.long as `long`,
                        ma.province_id,
                        p.name as province_name,
                        ma.city_id,
                        ci.name as city_name,
                        -- ma.districts_id,
                        -- d.name as district_name
                FROM
                        member_address ma
                        left join province p on p.id = ma.province_id
                        left join city ci on ci.id = ma.city_id
                        -- left join districts d on d.id = ma.districts_id
                WHERE ma.status > 0
                AND ma.penjahit_id = ' . ($member_id);
            if (strlen($billing_member_address_id) > 0) {
                $q .= ' AND ma.member_address_id = ' . ($billing_member_address_id);
            }
            if (strlen($shipping_member_address_id) > 0) {
                $q .= ' OR ma.member_address_id = ' . ($shipping_member_address_id);

            }
            $r = DB::select(DB::raw($q));
            if(count($r) > 0) {
                foreach ($r as $row) {
                    $arr_data = array();
                    $arr_data['member_address_id'] = $row->penjahit_address_id;
                    $arr_data['member_id'] = $row->member_id;
                    $arr_data['type'] = $row->type;
                    $arr_data['name'] = $row->name;
                    $arr_data['phone'] = $row->phone;
                    $arr_data['address'] = $row->address;
                    $arr_data['postal'] = $row->postal;
                    $arr_data['email'] = $row->email;
                    //$arr_data['country_id'] = $row->country_id;
                    //$arr_data['country_name'] = $row->country_name;
                    $arr_data['province_id'] = $row->province_id;
                    $arr_data['province_name'] = $row->province_name;
                    $arr_data['city_id'] = $row->city_id;
                    $arr_data['city_name'] = $row->city_name;
                    //$arr_data['districts_id'] = $row->districts_id;
                    //$arr_data['district_name'] = $row->district_name;
                    $arr_data['lat'] = $row->lat;
                    $arr_data['long'] = $row->long;
                    $data = array();
                    $data[$row->type] = $arr_data;
                    $data_all[] = $data;
                }
            }

        }


        $this->err_code = $err_code;
        $this->err_message = $err_message;
        $this->data=$data;
        return $this;
    }
}