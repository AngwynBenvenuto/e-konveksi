<?php
namespace Lintas\libraries\CApi\Method;
use Lintas\libraries\CApi\Method;
use DB;
use Illuminate\Support\Arr;
use Lintas\helpers\cdbutils;
use Lintas\helpers\clog;
use Lintas\helpers\utils;
use Lintas\helpers\cnotif;
use App\Models\Transaksi;

class Transaction extends Method {
    public function execute() {
        $err_code = 0;
        $err_message = '';
        $data = array();
        $request = $this->request();
        $offer_id = Arr::get($request, 'offer_id');
        $penjahit_id = Arr::get($request, 'penjahit_id');
        $project_id = Arr::get($request, 'project_id');
        $ikm_id = Arr::get($request, 'ikm_id');
        $owner = Arr::get($request, 'owner_project');
        $type = Arr::get($request, 'transaction_type');
        $name = Arr::get($request, 'transaction_name');
        $code = Arr::get($request, 'transaction_code');
        $transaction_date = Arr::get($request, 'transaction_date');
        $transaction_price = Arr::get($request, 'transaction_price');
        $transaction_total = Arr::get($request, 'transaction_total');
        $transaction_status = Arr::get($request, 'transaction_status');
        $description = Arr::get($request, 'transaction_description');
        $note = Arr::get($request, 'transaction_note');

        if($err_code == 0) {
            if(strlen($penjahit_id) == 0) {
                $err_code = 14;
                $err_message = "Penjahit ID required";
            } else if(strlen($project_id) == 0) {
                $err_code = 15;
                $err_message = "Project ID required";
            } else if(strlen($owner) == 0) {
                $err_code = 16;
                $err_message = "Owner required";
            }
        }

        if($err_code == 0) {
            //disable offer data
            $query = cdbutils::get_row("UPDATE offers SET `status` = 0 WHERE id = '{$offer_id}' ");

            DB::beginTransaction();
            try {
                $param = array();
                $param['penjahit_id'] = $penjahit_id;
                $param['project_id'] = $project_id;
                $param['ikm_id'] = $ikm_id;
                $param['owner_project'] = $owner;
                $param['type'] = $type;
                $param['name'] = $name;
                $param['code'] = $code;
                $param['transaction_date'] = $transaction_date;
                $param['transaction_price'] = $transaction_price;
                $param['transaction_total'] = $transaction_total;
                $param['transaction_status'] = $transaction_status;
                $param['description'] = $description;
                $param['note'] = $note;

                $model_transaction = new Transaksi;
                $model_transaction->fill($param);
                $save = $model_transaction->save();
                if($save) {
                    //create notif
                    $dataNotif = array(
                        'name' => 'Notification '.$name,
                        'description' => 'Transaksi '.$code.' telah sukses request',
                        'project_id' => $project_id,
                        'type' => 'transaksi',
                        'transaksi_id' => $model_transaction->id,
                        'penawaran_id' => null,
                        'ikm_id' => $ikm_id,
                        'ikm_name' => \App\Models\Ikm::find($ikm_id)->name,
                        'penjahit_id' => $penjahit_id,
                        'penjahit_name' => \App\Models\Penjahit::find($penjahit_id)->name
                    );
                    cnotif::create($dataNotif);
                }

            } catch (\Exception $ex) {
                $err_code = 99;
                $err_message = $ex->getMessage();
            }

            if($err_code == 0) {
                DB::commit();
            } else {
                DB::rollback();
            }
        }

        $this->err_code = $err_code;
        $this->err_message = $err_message;
        $this->data = $data;
        return $this;
    }
}