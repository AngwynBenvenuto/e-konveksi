<?php
namespace Lintas\libraries\CApi\Method;
use Lintas\libraries\CApi\Method;
use DB;
use Illuminate\Support\Arr;

class MemberDeleteAddress extends Method {
    public function execute() {
        $err_code = 0;
        $err_message = '';
        $data = array();

        $request = $this->request();
        $member_address_id = Arr::get($request, 'member_address_id');

        if (empty($member_address_id)) {
            $err_code++;
            $err_message = 'id is required.';
        }

        if ($err_code == 0) {
            try {
                DB::table("penjahit_address")
                    ->where(array("id" => $member_address_id))
                    ->update(array("status" => 0, "updated_at" => date("Y-m-d H:i:s")));
            } catch (Exception $ex) {
                $err_code++;
                $err_message = "Delete Address Failed, please call administrator";
            }
        }

        $this->err_code = $err_code;
        $this->err_message = $err_message;
        $this->data = $data;
        return $this;
    }
}