<?php
namespace Lintas\libraries\CApi\Method;
use Lintas\libraries\CApi\Method;
use DB;
use Illuminate\Support\Arr;

class GetProvince extends Method {
    public function execute() {
        $err_code = 0;
        $err_message = '';
        $data = array();

        $request = $this->request();
        $country_id = Arr::get($request, 'country_id');
        if(strlen($country_id)==0){
            $country_id = 94;
        }
        $province_id = Arr::get($request, 'province_id');

        $q = " select * from province where status>0 ";
        if (strlen($country_id) > 0) {
            $q .= " and country_id = " .($country_id);
        }
        if (strlen($province_id) > 0) {
            $q .= " and id = " .($province_id);
        }

        $r = DB::select(DB::raw($q));
        $arr_data = array();
        if (count($r) > 0) {
            foreach ($r as $row) {
                $data = array();
                $data['id'] = $row->id;
                $data['country_id'] = $row->country_id;
                $data['code'] = $row->code;
                $data['name'] = $row->name;
                $arr_data[] = $data;
            }
        }

        $this->err_code = $err_code;
        $this->err_message = $err_message;
        $this->data = $arr_data;
        return $this;
    }
}