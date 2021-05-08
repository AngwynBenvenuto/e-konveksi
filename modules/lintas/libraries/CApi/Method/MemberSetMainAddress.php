<?php
namespace Lintas\libraries\CApi\Method;
use Lintas\libraries\CApi\Method;
use DB;
use Illuminate\Support\Arr;
use App\Models\PenjahitAddress;

class MemberSetMainAddress extends Method {
    public function execute() {
        $err_code = 0;
        $err_message = '';
        $data = '';

        $request = $this->request();
        $member_id = Arr::get($request, 'member_id');
        $member_address_id = Arr::get($request, 'member_address_id');
        $type = Arr::get($request, 'type');
        $modelMemberAddress = '';

        if ($err_code == 0) {
            if(strlen($member_id) == 0) {
                $err_code = 2542;
                $err_message = "Member id not found";
            }
            else if(strlen($member_address_id) == 0) {
                $err_code = 2555;
                $err_message = "Member Address id not found";
            }
        }

        if ($err_code == 0) {
            $modelMemberAddress=PenjahitAddress::find($member_address_id);
            if($modelMemberAddress == null){
                $err_code=4566;
                $err_message="Member Address not Found";
            }
        }

        if($err_code==0){
            $member_ma_id=$modelMemberAddress->penjahit_id;
            if($member_id!=$member_ma_id){
                $err_code=5742;
                $err_message="This Member Address not belongs to you";
            }
        }

        if ($err_code == 0) {

            try {
                $type = $modelMemberAddress->type;
                $q = "update penjahit_address set is_active = 0 where type ='{$type}' and penjahit_id='{$member_id}'";
                $res = DB::select(DB::raw($q));
                $modelMemberAddress->is_active=1;
                $save = $modelMemberAddress->save();
                if($save) {
                    DB::commit();
                }
            } catch (\Exception $ex) {
                $err_code = 5555;
                $err_message = "Set Address Error " . $ex->getMessage();
            }
        }

        $this->err_code = $err_code;
        $this->err_message = $err_message;
        $this->data = $data;
        return $this;
    }
}