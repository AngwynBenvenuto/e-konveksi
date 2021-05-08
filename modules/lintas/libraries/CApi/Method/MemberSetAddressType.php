<?php
namespace Lintas\libraries\CApi\Method;
use Lintas\libraries\CApi\Method;
use DB;
use Illuminate\Support\Arr;
use App\Models\PenjahitAddress;
use Lintas\helpers\cdbutils;

class MemberSetAddressType extends Method {
    public function execute() {
        $err_code = 0;
        $err_message = '';
        $data = '';

        $request = $this->request();
        $date = date("Y-m-d H:i:s");
        $member_address_id = Arr::get($request, 'member_address_id');
        $member_id = Arr::get($request,'member_id');
        $type = Arr::get($request, 'type');
        $name = Arr::get($request, 'name');
        $phone = Arr::get($request, 'phone');
        $address = Arr::get($request, 'address');
        $postal = Arr::get($request, 'postal');
        $email = Arr::get($request, 'email');
        $province_id = Arr::get($request, 'province_id');
        $city_id = Arr::get($request, 'city_id');
        $districts_id = Arr::get($request, 'districts_id');
        $lat = Arr::get($request, 'lat');
        $long = Arr::get($request, 'long');

        if ($err_code == 0) {
            if (strlen($type) == 0) {
                $err_code = 34;
                $err_message = 'type is required';
            }
        }

        if ($err_code == 0) {
            if (strlen($name) == 0) {
                $err_code = 35;
                $err_message = 'name required';
            }
        }

        if ($err_code == 0) {
            if (strlen($phone) == 0) {
                $err_code = 36;
                $err_message = 'phone is required';
            }
        }

        if ($err_code == 0) {
            if (strlen($address) == 0) {
                $err_code = 37;
                $err_message = 'address is required';
            }
        }

        if ($err_code == 0) {
            DB::beginTransaction();
            try {
                $data_member_address = array(
                    'penjahit_id' => $member_id,
                    'type' => $type,
                    'name' => $name,
                    'phone' => $phone,
                    'address' => $address,
                    'postal' => $postal,
                    'email' => $email,
                    'province_id' => $province_id,
                    'city_id' => $city_id,
                    //'districts_id' => $districts_id,
                    'lat' => $lat,
                    'long' => $long,
                );

                if ($member_address_id == null) {
                    $member_address = cdbutils::get_row("select id from penjahit_address where status>0 and type='".$type."' and penjahit_id=".($member_id));
                    if($member_address==null){
                        $data_member_address["is_active"]=1;
                    }

                    $r = new PenjahitAddress;
                    $r->fill($data_member_address);
                    $save = $r->save();
                    if(!$save) {
                        $err_message = "Failed to save.";
                        DB::rollback();
                    } else {
                        DB::commit();
                    }
                } else {
                    $r = PenjahitAddress::whereId($member_address_id)->update($data_member_address);
                    DB::commit();
                }
            } catch(\Exception $ex) {
                $err_code = 5331;
                $err_message = "Set Address Not Succesfully".$ex->getMessage();
                DB::rollback();
            }
        }

        $this->err_code = $err_code;
        $this->err_message = $err_message;
        $this->data = $data;
        return $this;
    }
}