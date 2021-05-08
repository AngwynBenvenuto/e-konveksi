<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Delivery;
use App\Models\Penawaran;
use App\Models\Review;
use App\Models\Revisi;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Lintas\helpers\cnotif;
use Lintas\helpers\utils;
use Lintas\libraries\CTransaction;
use Lintas\libraries\CApi\Exception as ApiException;
// use Lintas\libraries\CUserLogin;

class ApiController extends Controller {

    public function detail_checkout() {
        $errCode = 0;
        $errMsg = "";
        $data = array();
        $transaksi_id = '';
        $transaksi_code = '';
        $ikm_array = array();
        $penjahit_array = array();

        $request = array_merge($_GET, $_POST);
        if($request != null) {
            $transaksi_id = Arr::get($request, 'transaksi_id');
            $transaksi_code = Arr::get($request, 'transaksi_code');
            $ikm_id = Arr::get($request, 'ikm_id');
            $penjahit_id = Arr::get($request, 'penjahit_id');
        }

        if($errCode == 0) {
            try{
                $model_checkout = Delivery::where('transaksi_id', '=', $transaksi_id)
                                    ->where('status', '>', 0);
                // if(strlen($ikm_id) > 0) {
                //     $model = $model->where('ikm_id', '=', $ikm_id);
                // }
                // else if(strlen($penjahit_id) > 0) {
                //     $model = $model->where('penjahit_id', '=', $penjahit_id);
                // }
                $model_checkout = $model_checkout->get();
                if($model_checkout != null) {
                    foreach($model_checkout as $rows) {
                        $data['invoice'] = $rows->order_invoice;
                        $data['project_id'] = $rows->project_id;
                        $data['project_name'] = $rows->project_name;
                        if($rows->penjahit_id) {
                            $penjahit_array[] = array(
                                'penjahit_id' => $rows->penjahit_id,
                                'penjahit_name' => $rows->buyer_name,
                                'penjahit_address' => $rows->buyer_address,
                                'penjahit_phone' => $rows->buyer_phone,
                                'penjahit_province_id' => $rows->buyer_province_id,
                                'penjahit_province_name' => $rows->buyer_province_name,
                                'penjahit_city_id' => $rows->buyer_city_id,
                                'penjahit_city_name' => $rows->buyer_city_name,
                                'penjahit_bank' => $rows->bank,
                                'penjahit_courier' => $rows->courier,
                                //'penjahit_payment_method' => $rows->payment_method,
                                'penjahit_payment_total' => $rows->payment_total,
                            );
                        }
                        if($rows->ikm_id) {
                            $ikm_array[]= array(
                                'ikm_id' => $rows->ikm_id,
                                'ikm_name' => $rows->buyer_name,
                                'ikm_address' => $rows->buyer_address,
                                'ikm_phone' => $rows->buyer_phone,
                                'ikm_province_id' => $rows->buyer_province_id,
                                'ikm_province_name' => $rows->buyer_province_name,
                                'ikm_city_id' => $rows->buyer_city_id,
                                'ikm_city_name' => $rows->buyer_city_name,
                                'ikm_bank' => $rows->bank,
                                'ikm_courier' => $rows->courier,
                                //'ikm_payment_method' => $rows->payment_method,
                                'ikm_payment_total' => $rows->payment_total,
                            );
                        }
                        $data['penjahit'] = $penjahit_array;
                        $data['ikm'] = $ikm_array;
                        $data['payment_method'] = $rows->payment_method;
                        $data['barang'] = $rows->barang;
                    }

                } else {
                    $errCode = 2566;
                    $errMsg  = "Data checkout belum ada";
                }
            } catch(\Exception $e) {
                $errCode = 222;
                $errMsg = $e->getMessage();
            }
        }

        $array = array();
        if($errCode == 0) {
            $array['errCode'] = $errCode;
            $array['errMsg'] = $errMsg;
            $array['data'] = $data;
        } else {
            $array['errCode'] = $errCode;
            $array['errMsg'] = $errMsg;
        }
        return response()->json($array, 200);
    }


    public function detail_revisi() {
        $errCode = 0;
        $errMsg = "";
        $data = array();
        $transaksi_id = '';
        $transaksi_code = '';
        $ikm_array = array();
        $penjahit_array = array();

        $request = array_merge($_GET, $_POST);
        if($request != null) {
            $transaksi_id = Arr::get($request, 'transaksi_id');
            $transaksi_code = Arr::get($request, 'transaksi_code');
            $ikm_id = Arr::get($request, 'ikm_id');
            $penjahit_id = Arr::get($request, 'penjahit_id');
            //$delivery_id = Arr::get($request, 'delivery_id');
        }

        if($errCode == 0) {
            try{
                $model_revisi = Revisi::where('transaksi_id', '=', $transaksi_id);
                // if(strlen($ikm_id) > 0) {
                //     $model = $model->where('ikm_id', '=', $ikm_id);
                // }
                // else if(strlen($penjahit_id) > 0) {
                //     $model = $model->where('penjahit_id', '=', $penjahit_id);
                // }
                $model_revisi = $model_revisi->get();
                if($model_revisi != null) {
                    $payment_total = 0;
                    foreach($model_revisi as $rows) {
                        $data['delivery_id'] = $rows->delivery_id;
                        $delivery = Delivery::where('transaksi_id', '=', $rows->transaksi_id)->get();
                        if($delivery != null) {
                            foreach($delivery as $delivery_detail) {
                                $data['invoice'] = $delivery_detail->order_invoice;
                                $data['project_id'] = $delivery_detail->project_id;
                                $data['project_name'] = $delivery_detail->project_name;
                                if($delivery_detail->penjahit_id) {
                                    $penjahit_array[] = array(
                                        'penjahit_id' => $delivery_detail->penjahit_id,
                                        'penjahit_name' => $delivery_detail->buyer_name,
                                        'penjahit_address' => $delivery_detail->buyer_address,
                                        'penjahit_phone' => $delivery_detail->buyer_phone,
                                        'penjahit_province_id' => $delivery_detail->buyer_province_id,
                                        'penjahit_province_name' => $delivery_detail->buyer_province_name,
                                        'penjahit_city_id' => $delivery_detail->buyer_city_id,
                                        'penjahit_city_name' => $delivery_detail->buyer_city_name,
                                        'penjahit_bank' => $delivery_detail->bank,
                                        'penjahit_courier' => $delivery_detail->courier,
                                        //'penjahit_payment_method' => $delivery_detail->payment_method,
                                        'penjahit_payment_total' => $delivery_detail->payment_total,
                                    );
                                }
                                else if($delivery_detail->ikm_id) {
                                    $ikm_array[]= array(
                                        'ikm_id' => $delivery_detail->ikm_id,
                                        'ikm_name' => $delivery_detail->buyer_name,
                                        'ikm_address' => $delivery_detail->buyer_address,
                                        'ikm_phone' => $delivery_detail->buyer_phone,
                                        'ikm_province_id' => $delivery_detail->buyer_province_id,
                                        'ikm_province_name' => $delivery_detail->buyer_province_name,
                                        'ikm_city_id' => $delivery_detail->buyer_city_id,
                                        'ikm_city_name' => $delivery_detail->buyer_city_name,
                                        'ikm_bank' => $delivery_detail->bank,
                                        'ikm_courier' => $delivery_detail->courier,
                                        //'ikm_payment_method' => $delivery_detail->payment_method,
                                        'ikm_payment_total' => $delivery_detail->payment_total,
                                    );
                                }
                                $data['penjahit'] = $penjahit_array;
                                $data['ikm'] = $ikm_array;
                                $data['payment_method'] = $delivery_detail->payment_method;
                                $data['barang'] = $delivery_detail->barang;
                            }
                           // dd($delivery_detail);
                        }
                        //dd($delivery_detail);


                        $data['transaksi_id'] = $rows->transaksi_id;
                        $transaksi = Transaksi::find($rows->transaksi_id);
                        if($transaksi != null) {
                            $data['payment_total'] = $transaksi->transaction_total;
                        }

                        $data['note'] = $rows->note;
                        //
                        // if($rows->penjahit_id) {
                        //     $penjahit_array[] = array(
                        //         'penjahit_id' => $rows->penjahit_id,
                        //         'penjahit_name' => $rows->buyer_name,
                        //         'penjahit_address' => $rows->buyer_address,
                        //         'penjahit_phone' => $rows->buyer_phone,
                        //         'penjahit_province_id' => $rows->buyer_province_id,
                        //         'penjahit_province_name' => $rows->buyer_province_name,
                        //         'penjahit_city_id' => $rows->buyer_city_id,
                        //         'penjahit_city_name' => $rows->buyer_city_name,
                        //         'penjahit_bank' => $rows->bank,
                        //         'penjahit_courier' => $rows->courier,
                        //         //'penjahit_payment_method' => $rows->payment_method,
                        //         'penjahit_payment_total' => $rows->payment_total,
                        //     );
                        // }
                        // if($rows->ikm_id) {
                        //     $ikm_array[]= array(
                        //         'ikm_id' => $rows->ikm_id,
                        //         'ikm_name' => $rows->buyer_name,
                        //         'ikm_address' => $rows->buyer_address,
                        //         'ikm_phone' => $rows->buyer_phone,
                        //         'ikm_province_id' => $rows->buyer_province_id,
                        //         'ikm_province_name' => $rows->buyer_province_name,
                        //         'ikm_city_id' => $rows->buyer_city_id,
                        //         'ikm_city_name' => $rows->buyer_city_name,
                        //         'ikm_bank' => $rows->bank,
                        //         'ikm_courier' => $rows->courier,
                        //         //'ikm_payment_method' => $rows->payment_method,
                        //         'ikm_payment_total' => $rows->payment_total,
                        //     );
                        // }
                        // $data['penjahit'] = $penjahit_array;
                        // $data['ikm'] = $ikm_array;
                        // $data['payment_method'] = $rows->payment_method;
                        // $data['barang'] = $rows->barang;
                    }
                } else {
                    $errCode = 2566;
                    $errMsg  = "Data revisi belum ada";
                }
            } catch(\Exception $e) {
                $errCode = 222;
                $errMsg = $e->getMessage();
            }
        }

        $array = array();
        if($errCode == 0) {
            $array['errCode'] = $errCode;
            $array['errMsg'] = $errMsg;
            $array['data'] = $data;
        } else {
            $array['errCode'] = $errCode;
            $array['errMsg'] = $errMsg;
        }
        return response()->json($array, 200);
    }

    public function transaksi_list() {
        $errCode = 0;
        $errMsg = "";
        $data = array();
        $ikm_id = '';
        $penjahit_id = '';
        $request = array_merge($_GET, $_POST);

        if($request != null) {
            $ikm_id = Arr::get($request, 'ikm_id');
            $penjahit_id = Arr::get($request, 'penjahit_id');
        }

        if($errCode == 0) {
            $modelTransaksi = Transaksi::with(['project'])
                                ->where('status', '>', 0);
            if(strlen($ikm_id) > 0) {
                $modelTransaksi = $modelTransaksi->where('ikm_id', '=', $ikm_id);
            }
            else if(strlen($penjahit_id) > 0) {
                $modelTransaksi = $modelTransaksi->where('penjahit_id', '=', $penjahit_id);
            }
            $modelTransaksi = $modelTransaksi->get();
            if($modelTransaksi != null) {
                foreach($modelTransaksi as $rows) {
                    $data[] = array(
                        'id' => $rows->id,
                        'code' => $rows->code,
                        'owner' => $rows->project->ikm->name,
                        'project' => $rows->project->name,
                        'type' => $rows->type,
                        'price' => $rows->project->price,
                        'payment' => $rows->transaction_total,
                        'payment_confirmed' => $rows->transaction_price,
                        'transaction_price' => $rows->transaction_price,
                        'progress' => $rows->progress,
                        'created_at' => (string)$rows->created_at,
                        'updated_at' => (string)$rows->updated_at,
                        'status' => $rows->transaction_status == null ? "Pending" : $rows->transaction_status,
                    );
                }
            }
        }

        $json = array();
        if($errCode == 0) {
            $json['errCode'] = $errCode;
            $json['errMsg'] = $errMsg;
            $json['data'] = $data;
        } else {
            $json['errCode'] = $errCode;
            $json['errMsg'] = $errMsg;
        }
        return response()->json($json);
    }
    public function transaksi_get_data() {
        $errCode = 0;
        $errMsg = "";
        $data = array();
        $ukuranArray=array();
        //$penjahit_name = '';
        $request = array_merge($_GET, $_POST);
        if($request != null) {
            $transaksi_id = Arr::get($request, 'transaksi_id');
        }

        if($errCode == 0) {
            if(strlen($transaksi_id) == 0) {
                $errCode = 1556;
                $errMsg = "Transaksi ID required";
            }
        }

        if($errCode == 0){
            try{
                $q = "SELECT t.id,
                        t.name,
                        t.code,
                        t.type,
                        t.penjahit_id,
                        t.ikm_id,
                        p.id as project_id,
                        p.name as project_name,
                        p.price as project_price,
                        i.name as project_creator,
                        t.transaction_total,
                        t.transaction_price,
                        t.transaction_status,
                        t.note ";
                $q .= " FROM transaction t ";
                $q .= " JOIN project p ON p.id = t.project_id ";
                $q .= " JOIN ikm i ON i.id = t.ikm_id ";
                $where = "";
                if(strlen($transaksi_id) > 0) {
                    $where .= " t.id = '{$transaksi_id}' AND ";
                }
                $where .= " 1=1 ";
                $q .= " WHERE $where ";
                $m = \DB::select(\DB::raw($q));
                if(count($m) > 0) {
                    foreach($m as $rows) {
                        $project_id=$rows->project_id;
                        $ukuran= utils::get_ukuran($project_id);
                        if($ukuran!=null)
                        {
                            foreach ($ukuran as $key => $value) {
                                $ukuranArray[]=array(
                                    'ukuran_nama'=>$value->name,
                                    'qty'=>$value->qty
                                );
                            }
                            $data['ukuran']=$ukuranArray;
                        }

                        $image_name='';
                        $image_url='';
                        $image_project= utils::get_image($project_id);
                        if($image_project!=null)
                        {
                            foreach ($image_project as $key => $value) {
                                $file = $value->image_name;
                                $file_url = $value->image_url;
                            }
                            $image_name = $file;
                            $image_url = $file_url;
                        }

                        $data['project_id'] = $project_id;
                        $data['project'] = $rows->project_name;
                        $data['image_name'] = $image_name;
                        $data['image_url'] = $image_url;
                        $data['type'] = $rows->type;
                        $penjahit = \App\Models\Penjahit::find($rows->penjahit_id);
                        if($penjahit != null) {
                            $penjahit_name = $penjahit->name;
                            $penjahit_code = $penjahit->code;
                        }
                        $data['penjahit_name'] = $penjahit_name;
                        $data['penjahit_code'] = $penjahit_code;

                        $ikm = \App\Models\Ikm::find($rows->ikm_id);
                        if($ikm != null) {
                            $ikm_name = $ikm->name;
                            $ikm_code = $ikm->code;
                        }
                        $data['ikm_name'] = $ikm_name;
                        $data['ikm_code'] = $ikm_code;

                        $data['project_price'] = config('cart.currency'). utils::formatCurrency($rows->project_price);
                        $data['project_creator'] = $rows->project_creator;
                        $data['transaction_total'] = config('cart.currency'). utils::formatCurrency($rows->transaction_total);
                        $data['transaction_price'] = config('cart.currency'). utils::formatCurrency($rows->transaction_price);
                        $data['transaction_status'] = $rows->transaction_status;
                        $data['note'] = $rows->note;
                    }
                }
            } catch(\Exception $e) {
                $errCode = 666;
                $errMsg = $e->getMessage();
            }
        }

        $array = array();
        if($errCode == 0) {
            $array['errCode'] = $errCode;
            $array['errMsg'] = $errMsg;
            $array['data'] = $data;
        } else {
            $array['errCode'] = $errCode;
            $array['errMsg'] = $errMsg;
        }
        return response()->json($array, 200);
    }
    public function transaksi_approve() {
        $errCode = 0;
        $errMsg = "";
        $data = array();
        $request = array_merge($_GET, $_POST);
        $transaksi_id = '';
        if($request != null) {
            $transaksi_id = Arr::get($request, 'transaksi_id');
            $penjahit_id = Arr::get($request, 'penjahit_id');
        }

        if($errCode == 0) {
            if(strlen($transaksi_id) == 0) {
                $errCode++;
                $errMsg = "Transaksi ID required";
            }
        }

        if($errCode == 0) {
            $model = Transaksi::find($transaksi_id);
            if($model != null) {
                \DB::beginTransaction();
                try {
                   $param = array();
                   $param["id"] = $transaksi_id;
                   if(strlen($penjahit_id) > 0) {
                       $param["transaction_status"] = "In Progress";
                   } else {
                        $param["transaction_status"] = "Done";
                   }
                   $param["updated_at"] = date('Y-m-d H:i:s');
                   $param["note"] = "";
                   if(strlen($transaksi_id) == 0) {
                      $model = new Transaksi;
                   }
                   $model->fill($param);
                   $save = $model->save();
                   if($save) {
                        $dataNotif = array(
                            'name' => 'Notification Transaksi '.$model->code,
                            'description' => 'Transaksi '.$model->code.' telah sukses dikonfirmasi oleh '.\App\Models\Penjahit::find($model->penjahit_id)->name,
                            'project_id' => $model->project_id,
                            'type' => 'transaksi',
                            'transaksi_id' => $model->id,
                            'penawaran_id' => null,
                            'ikm_id' => $model->ikm_id,
                            'ikm_name' => \App\Models\Ikm::find($model->ikm_id)->name,
                            'penjahit_id' => $model->penjahit_id,
                            'penjahit_name' => \App\Models\Penjahit::find($model->penjahit_id)->name
                        );
                        cnotif::create($dataNotif);
                   }
                } catch (\Exception $e) {
                    $errCode = 1345;
                    $errMsg = $e->getMessage();
                }

                if($errCode == 0) {
                    \DB::commit();
                } else {
                    \DB::rollback();
                }
            } else {
                $errCode = 1445;
                $errMsg = "Data tidak ada";
            }
        }

        if($errCode == 0) {
            $response['errCode'] = $errCode;
            $response['errMsg'] = $errMsg;
            $response['data'] = $data;
        } else {
            $response['errCode'] = $errCode;
            $response['errMsg'] = $errMsg;
        }
        return response()->json($response);
    }
    public function transaksi_lihat_bukti_transfer() {
        $errCode = 0;
        $errMsg = "";
        $data = array();
        $request = array_merge($_GET, $_POST);
        $transaksi_id = '';
        if($request != null) {
            $transaksi_id = Arr::get($request, 'transaksi_id');
        }

        if($errCode == 0) {
            if(strlen($transaksi_id) == 0) {
                $errCode++;
                $errMsg = "Transaksi ID required";
            }
        }

        if($errCode == 0) {
            try {
                $transaksi = Transaksi::find($transaksi_id);
                if($transaksi != null) {
                    $bukti = $transaksi->payment_confirmed;
                    if($bukti == null) {
                        $errCode = 1547;
                        $errMsg = "Bukti pembayaran masih belum di upload";
                    }
                    $data['bukti_upload'] = $bukti;
                }

            } catch(\Exception $e) {
                $err_code = 2999;
                $err_message = 'Failed ' . $e->getMessage();
            }
        }

        if($errCode == 0) {
            $response['errCode'] = $errCode;
            $response['errMsg'] = $errMsg;
            $response['data'] = $data;
        } else {
            $response['errCode'] = $errCode;
            $response['errMsg'] = $errMsg;
        }
        return response()->json($response);
    }
    public function transaksi_confirm_transfer() {
        $errCode = 0;
        $errMsg = "";
        $data = array();
        $request = array_merge($_GET, $_POST);
        $transaksi_id = '';
        if($request != null) {
            $transaksi_id = Arr::get($request, 'transaksi_id');
        }

        if($errCode == 0) {
            if(strlen($transaksi_id) == 0) {
                $errCode++;
                $errMsg = "Transaksi ID required";
            }
        }

        if($errCode == 0) {
            \DB::beginTransaction();
            try {
                $transaksi = Transaksi::find($transaksi_id);
                if($transaksi != null) {
                    $bukti = $transaksi->payment_confirmed;
                    if($bukti == null) {
                        $errCode = 345;
                        $errMsg = "Bukti pembayaran harap di upload.";
                    }
                }
                $dataUpdate = array();
                $dataUpdate["transaction_status"] = "Payment Confirmed";
                $dataUpdate["updated_at"] = date("Y-m-d H:i:s");

                $transaksi->fill($dataUpdate);
                $saved = $transaksi->save();
                if($saved) {
                    $data = array('message' => 'Sukses konfirmasi');
                }
            } catch(\Exception $e) {
                $err_code = 2999;
                $err_message = 'Failed ' . $e->getMessage();
            }

            if($errCode == 0) {
                \DB::commit();
            } else {
                \DB::rollback();
            }
        }

        if($errCode == 0) {
            $response['errCode'] = $errCode;
            $response['errMsg'] = $errMsg;
            $response['data'] = $data;
        } else {
            $response['errCode'] = $errCode;
            $response['errMsg'] = $errMsg;
        }
        return response()->json($response);
    }
    public function transaksi_update_progress() {
        $errCode = 0;
        $errMsg = '';
        $data = array();
        $request = array_merge($_GET, $_POST);
        $ikm_name = '';

        if($request != null) {
            $transaksi_id = Arr::get($request, 'transaksi_id');
            $progress = Arr::get($request, 'progress');

            if($errCode == 0){
                if(strlen($transaksi_id) == 0) {
                    $errCode = 111;
                    $errMsg = "Transaksi ID required";
                }
            }

            if($errCode == 0) {
                try{
                    $dataUpdate = array();
                    if(strlen($transaksi_id) > 0) {
                        $dataUpdate['id'] = $transaksi_id;
                    }
                    if(strlen($progress) > 0) {
                        $dataUpdate['progress'] = $progress;
                    }
                    $dataUpdate['transaction_status'] = "In Progress";
                    $dataUpdate['updated_at'] = date('Y-m-d H:i:s');

                    $modal = Transaksi::whereId($transaksi_id)->first();
                    if($modal == null) {
                        $errCode = 145;
                        $errMsg = "Transaksi not found";
                    }
                    $modal->fill($dataUpdate);
                    $saved = $modal->save();
                    if($saved) {
                        //Transaksi::whereId($transaksi_id)->update($dataUpdate);
                        //notif
                        // $t = Transaksi::whereId($transaksi_id)->first();
                        // if($t == null) {
                        //     $errCode = 111;
                        //     $errMsg = "Data transaksi not found";
                        // }
                        $ikm = \App\Models\Ikm::find($modal->ikm_id);
                        if($ikm != null) {
                            $ikm_name = $ikm->name;
                        }
                        $notif = array(
                            'project_id' => $modal->project_id,
                            'name' => 'Progress '.$progress,
                            'description' => 'Notification Progress '.$progress,
                            'type' => null,
                            'transaksi_id' => $transaksi_id,
                            'penawaran_id' => null,
                            'ikm_id' => $modal->ikm_id,
                            'ikm_name' => \App\Models\Ikm::find($modal->ikm_id)->name,
                            'penjahit_id' => $modal->penjahit_id,
                            'penjahit_name' => \App\Models\Penjahit::find($modal->penjahit_id)->name
                        );
                        cnotif::create($notif);
                    }
                } catch(\Exception $e) {
                    $errCode = 222;
                    $errMsg = $e->getMessage();
                }
            }
        }

        $response = array();
        if($errCode == 0) {
            $response['errCode'] = $errCode;
            $response['errMsg'] = $errMsg;
            $response['data'] = $data;
        } else {
            $response['errCode'] = $errCode;
            $response['errMsg'] = $errMsg;
        }
        return response()->json($response, 200);
    }
    public function transaksi_bukti_transfer() {
        $errCode = 0;
        $errMsg = "";
        $data = array();
        $request = array_merge($_GET, $_POST);
        $files = $_FILES;
        if($request != null) {
            $transaction_id = Arr::get($request, 'transaction_id');
            $transfer = Arr::get($files, 'bukti_transfer');
            $bukti_transfer = Arr::get($transfer, 'name');
            $file = request()->file('bukti_transfer');
        }

        if($errCode == 0) {
            if(strlen($transaction_id) == 0) {
                $errCode++;
                $errMsg = "Transaksi ID required";
            }
        }

        if($errCode == 0) {
            \DB::beginTransaction();
            try {
                $path = public_path('uploads/bukti_transfer/');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                $dataUpdate = array();
                if (strlen($bukti_transfer) > 0) {
                    $file->move($path, $bukti_transfer);
                    $fileNameGenerated = trim($file->getClientOriginalName());
                    $imageUrl = asset('public/uploads/bukti_transfer/'.$fileNameGenerated);
                    $dataUpdate['payment_confirmed'] = $imageUrl;
                    // $dataUpdate["image_name"] = $fileNameGenerated;
                    // $dataUpdate["image_url"] = $imageUrl;
                }
                //$dataUpdate["transaction_status"] = "Waited Payment";
                $dataUpdate["updated_at"] = date("Y-m-d H:i:s");

                $modelTransaksi = Transaksi::find($transaction_id);
                $modelTransaksi->fill($dataUpdate);
                $save = $modelTransaksi->save();
                if($save) {
                    $penjahit_name = '';
                    $penjahit = \App\Models\Penjahit::find($modelTransaksi->penjahit_id);
                    if($penjahit != null) {
                        $penjahit_name = $penjahit->name;
                    }

                    $notif = array(
                        'project_id' => $modelTransaksi->project_id,
                        'name' => 'Bukti Transfer',
                        'description' => 'Bukti transfer untuk transaksi dengan kode '.$modelTransaksi->code.' telah diupload',
                        'type' => null,
                        'transaksi_id' => $modelTransaksi->id,
                        'penawaran_id' => null,
                        'ikm_id' => $modelTransaksi->ikm_id,
                        'ikm_name' => \App\Models\Ikm::find($modelTransaksi->ikm_id)->name,
                        'penjahit_id' => $modelTransaksi->penjahit_id,
                        'penjahit_name' => \App\Models\Penjahit::find($modelTransaksi->penjahit_id)->name
                    );
                    cnotif::create($notif);
                }
            } catch(\Exception $e) {
                $err_code = 2999;
                $err_message = 'Failed ' . $e->getMessage();
            }


            if($errCode == 0) {
                \DB::commit();
            } else {
                \DB::rollback();
            }
        }

        if($errCode == 0) {
            $response['errCode'] = $errCode;
            $response['errMsg'] = $errMsg;
            $response['data'] = $data;
        } else {
            $response['errCode'] = $errCode;
            $response['errMsg'] = $errMsg;
        }
        return response()->json($response);
    }
    public function transaksi_session() {
        $errCode = 0;
        $errMsg = '';
        $data = array();
        $request = array_merge($_GET, $_POST);
        if($request != null) {
            $transaksi_id = Arr::get($request, 'transaksi_id');
            if($errCode == 0) {
                if(strlen($transaksi_id) == 0) {
                    $errCode = 13;
                    $errMsg = "Transaksi ID required";
                }
            }
            if($errCode == 0) {
                \Session::put('transaksi_id', $transaksi_id);
            }
        }
        return response()->json(array('message' => 'success save session'), 200);
    }



    public function penawaran_list() {
        $errCode = 0;
        $errMsg = "";
        $data = array();
        $request = array_merge($_GET, $_POST);
        if($request != null) {
            $ikm_id = Arr::get($request, 'ikm_id');
            $penjahit_id = Arr::get($request, 'penjahit_id');
        }

        if($errCode == 0) {
            try{
                $q = "SELECT o.id,
                            o.penjahit_id,
                            o.ikm_id,
                            o.type,
                            p.id as project_id,
                            p.name as project_name,
                            p.price as project_price,
                            i.id as project_creator_id,
                            i.name_display as project_creator,
                            o.offer_price,
                            IFNULL(o.status_confirm, 'Pending') as status_confirm,
                            o.is_approve_ikm,
                            o.is_approve_penjahit,
                            o.created_at,
                            o.updated_at,
                            o.status ";
                $q .= " FROM offers o ";
                $q .= " JOIN project p ON p.id = o.project_id ";
                $q .= " JOIN ikm i ON i.id = o.ikm_id ";
                $where = "";
                if($request != null) {
                    if(strlen($ikm_id) > 0) {
                        $where .= " o.ikm_id = '{$ikm_id}' AND ";
                    }
                    else if(strlen($penjahit_id) > 0) {
                        $where .= " o.penjahit_id = '{$penjahit_id}' AND  ";
                    }
                }
                $where .= " o.status > 0 AND ";
                $where .= " 1=1 ";
                $q .= " WHERE $where ";
                $result = \DB::select(\DB::raw($q));
                if($result != null) {
                    foreach($result as $d) {
                        $data[] = array(
                            'id' => $d->id,
                            'type' => $d->type,
                            'owner_id' => $d->project_creator_id,
                            'owner' => $d->project_creator,
                            'project_creator' => $d->project_creator,
                            'project' => $d->project_name,
                            //'rate' => $d->rate,
                            'price' => $d->project_price,
                            'offer_price' => $d->offer_price,
                            //'offer_price_system' => $d->offer_price_system,
                            'is_approve_ikm' => $d->is_approve_ikm,
                            'is_approve_penjahit' => $d->is_approve_penjahit,
                            'created_at' => (string)$d->created_at,
                            'updated_at' => (string)$d->updated_at,
                            'status_confirm' => $d->status_confirm,
                            'status' => $d->status
                        );
                    }
                }
            } catch(\Exception $e) {
                $errCode = 26;
                $errMsg = $e->getMessage();
            }
        }

        $array = array();
        if($errCode == 0) {
            if(count($data) > 0) {
                foreach($data as $rows){
                    $array['data'][] = $rows;
                }
            } else {
                $array['data'] = array();
            }
        }
        return response()->json($array, 200);
    }
    public function penawaran_get_data() {
        $errCode = 0;
        $errMsg = "";
        $data = array();
        $penjahit_name = '';
        $ukuranArray=array();
        $request = array_merge($_GET, $_POST);
        if($request != null) {
            $penawaran_id = Arr::get($request, 'penawaran_id');
        }

        if($errCode == 0) {
            if(strlen($penawaran_id) == 0) {
                $errCode++;
                $errMsg = "Penawaran ID required";
            }
        }

        if($errCode == 0) {
             $q = "SELECT o.id,
                     o.type,
                     p.id as project_id,
                     p.name as project_name,
                     p.price as project_price,
                     i.name as project_creator,
                     o.penjahit_id,
                     o.ikm_id,
                     o.offer_price,
                     o.is_approve_ikm,
                     o.is_approve_penjahit,
                     o.note ";
            $q .= " FROM offers o ";
            $q .= " JOIN project p ON p.id = o.project_id ";
            $q .= " JOIN ikm i ON i.id = o.ikm_id ";
            $where = "";
            if(strlen($penawaran_id) > 0) {
                $where .= " o.id = '{$penawaran_id}' AND ";
            }
            $where .= " 1=1 ";
            $q .= " WHERE $where ";
            $m = \DB::select(\DB::raw($q));
            if(count($m) > 0) {
                foreach($m as $rows) {
                    $data['id'] = $rows->id;
                    $project_id=$rows->project_id;
                    $data['project_id'] = $project_id;
                    $ukuran=utils::get_ukuran($project_id);
                    if($ukuran!=null)
                    {
                        foreach ($ukuran as $key => $value) {
                            $ukuranArray[]=array(
                                'ukuran_nama'=>$value->name,
                                'qty'=>$value->qty
                            );
                        }
                        $data['ukuran']=$ukuranArray;
                    }

                    $image_name='';
                    $image_url='';
                    $image_project=utils::get_image($project_id);
                    if($image_project!=null)
                    {
                        foreach ($image_project as $key => $value) {
                            $file = $value->image_name;
                            $file_url = $value->image_url;
                        }
                        $image_name = $file;
                        $image_url = $file_url;
                    }

                    $data['project'] = $rows->project_name;
                    $data['image_name'] = $image_name;
                    $data['image_url'] = $image_url;
                    $data['type'] = $rows->type;

                    $penjahit = \App\Models\Penjahit::find($rows->penjahit_id);
                    if($penjahit != null) {
                        $penjahit_id = $penjahit->id;
                        $penjahit_name = $penjahit->name;
                        $penjahit_code = $penjahit->code;
                    }
                    $data['penjahit_id'] = $penjahit_id;
                    $data['penjahit_name'] = $penjahit_name;
                    $data['penjahit_code'] = $penjahit_code;

                    $ikm = \App\Models\Ikm::find($rows->ikm_id);
                    if($ikm != null) {
                        $ikm_id = $ikm->id;
                        $ikm_name = $ikm->name;
                        $ikm_code = $ikm->code;
                    }
                    $data['ikm_id'] = $ikm_id;
                    $data['ikm_name'] = $ikm_name;
                    $data['ikm_code'] = $ikm_code;

                    $data['project_price'] = config('cart.currency'). utils::formatCurrency($rows->project_price);
                    $data['project_creator'] = $rows->project_creator;
                    $data['offer_price'] = config('cart.currency'). utils::formatCurrency($rows->offer_price);
                    $data['is_approve_ikm'] = $rows->is_approve_ikm;
                    $data['is_approve_penjahit'] = $rows->is_approve_penjahit;
                    $data['note'] = $rows->note;
                }
            }
        }

        $array = array();
        if($errCode == 0) {
            $array['errCode'] = $errCode;
            $array['errMsg'] = $errMsg;
            $array['data'] = $data;
        } else {
            $array['errCode'] = $errCode;
            $array['errMsg'] = $errMsg;
        }
        return response()->json($array, 200);
    }
    public function penawaran_approve() {
        $errCode = 0;
        $errMsg = "";
        $data = array();
        $project_name = '';
        $request = array_merge($_GET, $_POST);
        if($request != null) {
            $penawaran_id = Arr::get($request, 'penawaran_id');
            $ikm_id = Arr::get($request, 'ikm_id');
            $penjahit_id = Arr::get($request, 'penjahit_id');
        }

        if($errCode == 0) {
            if(strlen($penawaran_id) == 0) {
                $errCode++;
                $errMsg = "Penawaran ID required";
            }
        }

        if($errCode == 0) {
            $model = Penawaran::find($penawaran_id);
            if($model != null) {
                \DB::beginTransaction();
                try {
                    $param = array();
                    $param["id"] = $penawaran_id;
                    if(strlen($ikm_id) > 0) {
                        $param["is_approve_ikm"] = 1;
                        $param["date_approve_ikm"] = date('Y-m-d H:i:s');
                        $param["last_approve"] = date('Y-m-d H:i:s');
                        $param["last_request"] = date('Y-m-d H:i:s');
                        $param["note"] = "Approve by IKM";
                    }
                    if(strlen($penjahit_id) > 0) {
                        // $param["is_approve_ikm"] = 1;
                        // $param["date_approve_ikm"] = date('Y-m-d H:i:s');
                        // $param["last_approve"] = date('Y-m-d H:i:s');
                        // $param["last_request"] = date('Y-m-d H:i:s');
                        // $param["note"] = "Approve by IKM";
                        $param["is_approve_penjahit"] = 1;
                        $param["date_approve_penjahit"] = date('Y-m-d H:i:s');
                        $param["last_approve"] = date('Y-m-d H:i:s');
                        $param["last_request"] = date('Y-m-d H:i:s');
                        $param["status_confirm"] = "Confirm";
                        $param["note"] = "Approve by Penjahit";
                    }
                    if(strlen($penawaran_id) == 0) {
                      $model = new Penawaran;
                    }
                    $model->fill($param);
                    $s = $model->save();
                    if($s) {
                        $project = \App\Models\Project::find($penawaran_id);
                        if($project != null) {
                            $project_name = $project->name;
                        }

                        $dataNotif = array(
                            'name' => 'Notification Penawaran Project '.$project_name,
                            'description' => 'Project '.$project_name.' dengan kode penawaran '.$model->code.' telah sukses dikonfirmasi oleh '.\App\Models\Ikm::find($model->ikm_id)->name,
                            'project_id' => $model->project_id,
                            'type' => 'penawaran',
                            'transaksi_id' => null,
                            'penawaran_id' => $model->id,
                            'ikm_id' => $model->ikm_id,
                            'ikm_name' => \App\Models\Ikm::find($model->ikm_id)->name,
                            'penjahit_id' => $model->penjahit_id,
                            'penjahit_name' => \App\Models\Penjahit::find($model->penjahit_id)->name
                        );
                        cnotif::create($dataNotif);

                        if(strlen($penjahit_id) > 0) {
                            $project = \App\Models\Project::find($model->project_id);
                            if($project != null) {
                                $dataTrans = array(
                                    'offer_id' => $penawaran_id,
                                    'penjahit_id' => $model->penjahit_id,
                                    'project_id' => $model->project_id,
                                    'ikm_id' => $model->ikm_id,
                                    'owner_project' => \App\Models\Ikm::find($model->ikm_id)->name,
                                    'transaction_type' => $model->type,
                                    'transaction_name' => 'Transaksi Project '.$project->name,
                                    'transaction_code' => utils::generateTransaction($model->project_id),
                                    'transaction_date' => date('Y-m-d H:i:s'),
                                    'transaction_price' => $model->offer_price,
                                    'transaction_total' => null,
                                    'transaction_status' => 'Pending',
                                    'transaction_description' => null,
                                    'transaction_note' => null
                                );
                                $result = false;
                                try {
                                    $result = CTransaction::createTransaction($dataTrans);
                                    //$result = CTransaction::createFormKerjasama($dataTrans);
                                } catch (ApiException $e) {
                                    $errCode = 1455;
                                    $errMsg = $e->getMessage();
                                } catch (\Exception $e) {
                                    $errCode = 14414;
                                    $errMsg = '[FATAL ERROR] '.$e->getMessage();
                                }
                            } else {
                                $errCode = 566;
                                $errMsg = "Project ID required";
                            }

                        }
                   }
                } catch (\Exception $e) {
                    $errCode = 1345;
                    $errMsg = $e->getMessage();
                }

                if($errCode == 0) {
                    \DB::commit();
                } else {
                    \DB::rollback();
                }
            } else {
                $errCode = 1445;
                $errMsg = "Data tidak ada";
            }
        }

        if($errCode == 0) {
            $response['errCode'] = $errCode;
            $response['errMsg'] = $errMsg;
            $response['data'] = $data;
        } else {
            $response['errCode'] = $errCode;
            $response['errMsg'] = $errMsg;
        }
        return response()->json($response);
    }
    public function penawaran_cancel() {
        $errCode = 0;
        $errMsg = "";
        $data = array();
        $penjahit_name='';
        $request = array_merge($_GET, $_POST);
        if($request != null) {
            $penawaran_id = Arr::get($request, 'penawaran_id');
            $ikm_id = Arr::get($request, 'ikm_id');
        }

        if($errCode == 0) {
            if(strlen($penawaran_id) == 0) {
                $errCode++;
                $errMsg = "Penawaran ID required";
            }
        }

        if($errCode == 0) {
            $model = Penawaran::find($penawaran_id);
            if($model != null) {
                \DB::beginTransaction();
                try {
                    $param = array();
                    $param["id"] = $penawaran_id;
                    if(strlen($ikm_id) > 0) {
                        $param["is_approve_ikm"] = 0;
                        $param["date_approve_ikm"] = null;
                        $param["last_approve"] = null;
                        $param["last_request"] = null;
                        $param["note"] = "Cancelled by IKM";
                        $param["status_confirm"] = "Cancel";
                    }
                    if(strlen($penawaran_id) == 0) {
                        $model = new Penawaran;
                    }
                    $model->fill($param);
                    $s = $model->save();
                    if($s) {
                        $penjahit=\App\Models\Penjahit::find($model->penjahit_id);
                        if($penjahit != null)
                        {
                            $penjahit_name = $penjahit->name;
                        }

                        $dataNotif = array(
                            'name' => 'Notification Penawaran '.$model->code,
                            'description' => 'Penawaran '.$model->code.' telah dicancel oleh '.\App\Models\Ikm::find($model->ikm_id)->name,
                            'project_id' => $model->project_id,
                            'type' => 'penawaran',
                            'transaksi_id' => null,
                            'penawaran_id' => $model->id,
                            'ikm_id' => $model->ikm_id,
                            'ikm_name' => \App\Models\Ikm::find($model->ikm_id)->name,
                            'penjahit_id' => $model->penjahit_id,
                            'penjahit_name' => \App\Models\Penjahit::find($model->penjahit_id)->name
                        );
                        cnotif::create($dataNotif);
                    }
                } catch (\Exception $e) {
                    $errCode = 1345;
                    $errMsg = $e->getMessage();
                }

                if($errCode == 0) {
                    \DB::commit();
                } else {
                    \DB::rollback();
                }
            } else {
                $errCode = 1445;
                $errMsg = "Data tidak ada";
            }
        }

        if($errCode == 0) {
            $response['errCode'] = $errCode;
            $response['errMsg'] = $errMsg;
            $response['data'] = $data;
        } else {
            $response['errCode'] = $errCode;
            $response['errMsg'] = $errMsg;
        }
        return response()->json($response);
    }



    public function review_insert() {
        $errCode = 0;
        $errMsg = '';
        $data = array();
        $request = array_merge($_GET, $_POST);
        if($request != null) {
            $transaksi_id = Arr::get($request, 'transaction_id');
            $ikm_id = Arr::get($request, 'ikm_id');
            $penjahit_id = Arr::get($request, 'penjahit_id');
            $project_id = Arr::get($request, 'project_id');
            $rating = Arr::get($request, 'rating_value');
            $note = Arr::get($request, 'note');

            if($errCode == 0) {
                if(strlen($transaksi_id) == 0){
                    $errCode = 134;
                    $errMsg = "Transaksi required";
                }
                // else if(strlen($ikm_id) == 0){
                //     $errCode = 135;
                //     $errMsg = "Ikm required";
                // }
            }

            if($errCode == 0) {
                try{
                    //insert to table review
                    $dataReview = array(
                        'ikm_id' => $ikm_id,
                        'transaksi_id' => $transaksi_id,
                        'project_id' => $project_id,
                        'penjahit_id' => $penjahit_id,
                        'rating' => $rating,
                        'rating_request' => date('Y-m-d H:i:s'),
                        'note' => $note
                    );
                    $review = new Review;
                    $review->fill($dataReview);
                    $review->save();
                } catch(\Exception $e) {
                    $errCode = 1455;
                    $errMsg = $e->getMessage();
                }
            }
        }

        if($errCode == 0) {
            $response['errCode'] = $errCode;
            $response['errMsg'] = $errMsg;
            $response['data'] = $data;
        } else {
            $response['errCode'] = $errCode;
            $response['errMsg'] = $errMsg;
        }
        return response()->json($response);
    }



    //revisi
    /*
        Alur
        1. get transaksi id,
        2. update status transaksi -> Revisied
        3. update status pengiriman untuk transaksi dan org yang minta revisi jadi 0
            -> ketika get checkout, pastikan data bukan status == 0
        4. masuk kan table revisi:
            transaksi_id
            siapa yang minta revisi
            pengiriman_id brp
            invoicenya brp
            note
        5. ketika sudah, tombol checkout pada table transaksi akan aktif kembali (status revisied)
    */
    public function revisi_insert() {
        $errCode = 0;
        $errMsg = '';
        $data = array();
        $request = array_merge($_GET, $_POST);
        if($request != null) {
            $transaksi_id = Arr::get($request, 'transaksi_id');
            $delivery_id = Arr::get($request, 'delivery_id');
            $invoice = Arr::get($request, 'invoice');
            $ikm_id = Arr::get($request, 'ikm_id_rev');
            $penjahit_id = Arr::get($request, 'penjahit_id_rev');
            $note = Arr::get($request, 'note');
        }
        //dd($invoice);

        if($errCode == 0) {
            try{
                $transaksi = Transaksi::find($transaksi_id);
                if($transaksi != null) {
                    $transaksi->fill(array(
                        'transaction_status' => 'Revisied'
                    ));
                    $save = $transaksi->save();
                    if($save) {
                        $delivery = Delivery::where('transaksi_id', '=', $transaksi_id)
                                            ->where('status','>',0);
                        if(strlen($ikm_id) > 0) {
                            $delivery = $delivery->where('ikm_id', '=', $ikm_id);
                        } else if(strlen($penjahit_id) > 0) {
                            $delivery = $delivery->where('penjahit_id', '=', $penjahit_id);
                        }
                        $delivery = $delivery->first();
                        if($delivery != null) {
                            $delivery->fill(array(
                                'status' => 0
                            ));
                            $d_save = $delivery->save();
                            if($d_save) {
                                $dtRevisi = array(
                                    'transaksi_id' => $transaksi_id,
                                    'delivery_id' => $delivery_id,
                                    'invoice' => $invoice,
                                    'ikm_id' => $ikm_id,
                                    'penjahit_id' => $penjahit_id,
                                    'note' => $note,
                                );
                                $revisi = new Revisi;
                                $revisi->fill($dtRevisi);
                                $r_save = $revisi->save();
                                if($r_save) {
                                    $data = array('message' => "Sukses melakukan permintaan revisi");
                                }
                                //dd($revisi);
                            }
                            //dd($revisi);
                        }
                    }
                }
            } catch(\Exception $e) {
                $errCode = 356;
                $errMsg = $e->getMessage();
            }
        }
        //dd($revisi);

        if($errCode == 0) {
            $response['errCode'] = $errCode;
            $response['errMsg'] = $errMsg;
            $response['data'] = $data;
        } else {
            $response['errCode'] = $errCode;
            $response['errMsg'] = $errMsg;
        }
        return response()->json($response);
    }
    public function detail_data_transaksi() {
        $errCode = 0;
        $errMsg = '';
        $data = array();
        $request = array_merge($_GET, $_POST);
        if($request != null) {
            $transaksi_id = Arr::get($request, 'transaksi_id');
            $ikm_id = Arr::get($request, 'ikm_id'); //ini bisa dari id penjahit atau ikm
            $penjahit_id = Arr::get($request, 'penjahit_id'); //ini bisa dari id penjahit atau ikm
        }

        if($errCode == 0) {
            //transaksi
            $transaksi = Transaksi::find($transaksi_id);
            if($transaksi != null) {
                $trans_id = $transaksi->id;
                $trans_code = $transaksi->code;
                $trans_date = $transaksi->transaction_date;
                $trans_pay = $transaksi->transaction_total;

                $data['transaksi_id'] = $trans_id;
                $data['transaksi_code'] = $trans_code;
                $data['transaksi_date'] = $trans_date;
            }

            //delivery
            //\DB::enableQueryLog();
            $delivery = Delivery::where('transaksi_id', '=', $transaksi_id);
            if(strlen($ikm_id) > 0) {
                $delivery = $delivery->where('ikm_id', '=', $ikm_id);
            }
            else if(strlen($penjahit_id) > 0) {
                $delivery = $delivery->where('penjahit_id', '=', $penjahit_id);
            }
            $delivery = $delivery->first();
            //dd(\DB::getQueryLog());
            if($delivery != null) {
                $del_id = $delivery->id;
                $del_invoice = $delivery->order_invoice;
                $del_project_id = $delivery->project_id;
                $del_project_name = $delivery->project_name;

                $data['delivery_id'] = $del_id;
                $data['delivery_invoice'] = $del_invoice;
                $data['project_id'] = $del_project_id;
            }

            //
            $data['ikm_id_rev'] = $ikm_id;
            $data['penjahit_id_rev'] = $penjahit_id;
        }

        if($errCode == 0) {
            $response['errCode'] = $errCode;
            $response['errMsg'] = $errMsg;
            $response['data'] = $data;
        } else {
            $response['errCode'] = $errCode;
            $response['errMsg'] = $errMsg;
        }
        return response()->json($response);
    }






    //pks
    public function pks_detail() {
        $errCode = 0;
        $errMsg = '';
        $data = array();
        $nomor_perusahaan = '';
        $nama_perusahaan = '';
        $jangka_waktu = '';
        $ikm_id = '';
        $ikm_name = '';
        $ikm_address = '';
        $penjahit_id = '';
        $penjahit_name = '';
        $penjahit_address = '';
        $project_id = '';
        $code = '';
        $project_date = '';
        $project_nama = '';
        $file = '';
        $file_name = '';
        $image_url = '';
        $image_name = '';
        $bahan = '';
        $pks_date = '';
        $transaksi_price = '';
        $ukurans = array();

        $request = array_merge($_GET, $_POST);
        if($request != null) {
            $transaksi_id = Arr::get($request, 'transaksi_id');
        }

        if($errCode == 0) {
            $transaksi = \App\Models\Transaksi::find($transaksi_id);
            if($transaksi != null) {
                $transaksi_id = $transaksi->id;
                $transaksi_code = $transaksi->code;
                $transaksi_price = $transaksi->transaction_price;
                $project_id = $transaksi->project_id;
                $ikm_id = $transaksi->ikm_id;
                $ikm = \App\Models\Ikm::find($ikm_id);
                if($ikm != null) {
                    $ikm_name = $ikm->name;
                    $ikm_name_display = $ikm->name_display;
                    $ikm_address = $ikm->address;
                }

                $penjahit_id = $transaksi->penjahit_id;
                $penjahit = \App\Models\Penjahit::find($penjahit_id);
                if($penjahit != null) {
                    $penjahit_name = $penjahit->name;
                    $penjahit_name_display = $penjahit->name_display;
                    $penjahit_address = $penjahit->address;
                }

                $project = \App\Models\Project::with(['ukuran', 'images'])->whereId($project_id)->first();
                if($project != null) {
                    $models = $project->toArray();
                    $project_id = Arr::get($models, 'id');
                    $project_nama = Arr::get($models, 'name');
                    $code = Arr::get($models, 'code');
                    $project_date = Arr::get($models, 'published_date');
                    $bahan = Arr::get($models, 'spesification');
                    $ukuran = Arr::get($models, 'ukuran');
                    if($ukuran != null) {
                        foreach($ukuran as $r) {
                            $ukurans[] = array(
                                'ukuran_id' => $r['pivot']['ukuran_id'],
                                'ukuran_nama' => $r['name'],
                                'qty' => $r['pivot']['qty']
                            );
                        }
                    }
                    $image = Arr::get($models, 'images');
                    if($image != null) {
                        foreach($image as $row) {
                            $file = $row['image_name'];
                            $file_url = $row['image_url'];
                        }
                        $image_name = $file;
                        $image_url = $file_url;
                    }
                }
            } else {
                $errCode = 456;
                $errMsg = "Transaksi masih belum ada, segera hubungi ikm '{$ikm_name}'";
            }


            $form_pks = \App\Models\Kerjasama::where('transaksi_id', '=', $transaksi_id)->first();
            if($form_pks != null) {
                $nomor_perusahaan = $form_pks->nomor_perusahaan;
                $nama_perusahaan = $form_pks->nama_perusahaan;
                $jangka_waktu = $form_pks->jangka_pengerjaan;
                $pks_date = (string)$form_pks->created_at;
            } else {
                $errCode = 1565;
                $errMsg = "Form PKS masih belum ada, segera hubungi ikm '{$ikm_name}'";
            }

            $data['transaksi_id'] = $transaksi_id;
            $data['nomor_perusahaan'] = $nomor_perusahaan;
            $data['nama_perusahaan'] = $nama_perusahaan;
            $data['jangka_waktu'] = $jangka_waktu;
            $data['pks_date'] = $pks_date;
            $data['transaksi_price'] = $transaksi_price;
            $data['ikm_id'] = $ikm_id;
            $data['ikm_name'] = $ikm_name;
            $data['ikm_address'] = $ikm_address;
            $data['penjahit_id'] = $penjahit_id;
            $data['penjahit_name'] = $penjahit_name;
            $data['penjahit_address'] = $penjahit_address;
            $data['project_id'] = $project_id;
            $data['project_nama'] = $project_nama;
            $data['project_date'] = $project_date;
            $data['code'] = $code;
            $data['image'] = $image_url;
            $data['bahan'] = $bahan;
            $data['ukuran'] = $ukurans;
        }

        if($errCode == 0) {
            $response['errCode'] = $errCode;
            $response['errMsg'] = $errMsg;
            $response['data'] = $data;
        } else {
            $response['errCode'] = $errCode;
            $response['errMsg'] = $errMsg;
        }
        return response()->json($response);
    }
    public function pks_download() {
        $errCode = 0;
        $errMsg = '';
        $data = array();
        $nama_perusahaan = '';
        $nomor_perusahaan = '';
        $jangka_waktu = '';
        $project_nama = '';
        $project_date = '';
        $pks_date = '';
        $harga = '';
        $ikm_id = '';
        $ikm_name = '';
        $ikm_address = '';
        $penjahit_id = '';
        $penjahit_name = '';
        $penjahit_address = '';
        $city = "";
        $pks = "";

        $request = array_merge($_GET, $_POST);
        if($request != null) {
            $nama_perusahaan = Arr::get($request, 'nama_perusahaan');
            $nomor_perusahaan = Arr::get($request, 'nomor_perusahaan');
            $jangka_waktu = Arr::get($request, 'jangka_waktu');
            $project_nama = Arr::get($request, 'project_name_pks');
            $project_date = Arr::get($request, 'project_date_pks');
            $pks_date = Arr::get($request, 'pks_date');
            $harga = Arr::get($request, 'transaksi_price');
            $ikm_id = Arr::get($request, 'ikm_id_pks');
            $ikm_name = Arr::get($request, 'ikm_name_pks');
            $ikm_address = Arr::get($request, 'ikm_address_pks');
            $penjahit_id = Arr::get($request, 'penjahit_id_pks');
            $penjahit_name = Arr::get($request, 'penjahit_name_pks');
            $penjahit_address = Arr::get($request, 'penjahit_address_pks');
        }

        if($errCode == 0) {
            if($jangka_waktu == null || empty($jangka_waktu) || $jangka_waktu == "") {
                $jangka_waktu = '1';
            }
            if($ikm_id != null) {
                $ikm = \App\Models\Ikm::find($ikm_id);
                if($ikm != null) {
                    $city_id = $ikm->city_id;
                    $city = \App\Models\City::find($city_id)->name;
                }
            }

            $newDate = date('Y-m-d', strtotime("+".$jangka_waktu." MONTH", strtotime($project_date)));

            $options = array(
                '[TANGGAL]' => utils::formatDate($pks_date),
                '[NAMA_PERUSAHAAN]' => $nama_perusahaan,
                '[NOMOR_PERUSAHAAN]' => $nomor_perusahaan,
                '[PIHAK_1]' => $ikm_name,
                '[ALAMAT_1]' => $ikm_address,
                '[PIHAK_2]' => $penjahit_name,
                '[ALAMAT_2]' => $penjahit_address,
                '[PROJECT]' => $project_nama,
                '[PRICE]' => config('cart.currency').number_format($harga, 2),
                '[METODE]' => 'Transfer',
                '[TERBIT]' => $city.", ".utils::formatDate($pks_date),
                '[START]' => utils::formatDate($project_date),
                '[END]' => $newDate,
            );
            $file = public_path('data/rtf/suratperjanjian.rtf');
            $nama_file = 'surat-perjanjian-kerjasama.doc';
            $pks = \App\Providers\LintasWordTemplate::instance()->export($file, $options, $nama_file);
            return $pks;
            // header("Location: ".$pks);
        }

        // if($errCode == 0) {
        //     $response['errCode'] = $errCode;
        //     $response['errMsg'] = $errMsg;
        //     $response['data'] = $data;
        // } else {
        //     $response['errCode'] = $errCode;
        //     $response['errMsg'] = $errMsg;
        // }
        // return response()->json($response);
    }
    // private static function downloadFile($file = '') {
    // }

}