<?php
namespace App\Http\Controllers\Front\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Penawaran;
use App\Models\Transaksi;
use Illuminate\Support\Arr;
use Lintas\helpers\utils;
use Lintas\helpers\cnotif;
use Lintas\libraries\CMemberLogin;
use Lintas\libraries\CTransaction;
use Lintas\libraries\CApi\Exception as ApiException;
use DB;

class OfferController extends Controller
{
    public function offer() {
        return view('front.user.offer');
    }

    // public function offerList() {
    //     $errCode = 0;
    //     $errMsg = "";
    //     $data = array();
    //     $penjahit_id = "";
    //     $request = array_merge($_GET, $_POST);

    //     if($request != null) {
    //         $penjahit_id = Arr::get($request, 'penjahit_id');
    //     }

    //     if($errCode == 0) {
    //         $modelPenawaran = Penawaran::with(['project'])
    //                             ->where('status', '>', 0)
    //                             ->where('penjahit_id', '=', $penjahit_id)
    //                             ->get();
    //         if($modelPenawaran != null) {
    //             foreach($modelPenawaran as $rows) {
    //                 $data[] = array(
    //                     'id' => $rows->id,
    //                     'owner_id' => $rows->project->ikm_id,
    //                     'owner' => $rows->project->ikm->name,
    //                     'project' => $rows->project->name,
    //                     'type' => $rows->type,
    //                     'price' => $rows->project->price,
    //                     'rate' => $rows->rate,
    //                     'offer_price' => $rows->offer_price,
    //                     'offer_price_system' => $rows->offer_price_system,
    //                     'created_at' => (string)$rows->created_at,
    //                     'updated_at' => (string)$rows->updated_at,
    //                     'is_approve_penjahit' => $rows->is_approve_penjahit,
    //                     'is_approve_ikm' => $rows->is_approve_ikm,
    //                     'status_confirm' => $rows->status_confirm == null ? "Pending" : $rows->status_confirm,
    //                     'status' => $rows->status
    //                 );
    //             }
    //         }
    //     }

    //     $json = array();
    //     if($errCode == 0) {
    //         $json['errCode'] = $errCode;
    //         $json['errMsg'] = $errMsg;
    //         $json['data'] = $data;
    //     } else {
    //         $json['errCode'] = $errCode;
    //         $json['errMsg'] = $errMsg;
    //     }
    //     return response()->json($json);
    // }

    // public function approve(Request $request, $id = null) {
    //     $errCode = 0;
    //     $errMsg = "";
    //     $data = array();
    //     $project_name = '';

    //     if(strlen($id) > 0) {
    //         $model = Penawaran::find($id);
    //         if($model != null) {
    //             DB::beginTransaction();
    //             try {
    //                $param = array();
    //                $param["id"] = $id;
    //                $param["is_approve_penjahit"] = 1;
    //                $param["date_approve_penjahit"] = date('Y-m-d H:i:s');
    //                $param["last_approve"] = date('Y-m-d H:i:s');
    //                $param["last_request"] = date('Y-m-d H:i:s');
    //                $param["status_confirm"] = "Confirm";
    //                $param["note"] = "Approve by Penjahit";

    //                $model->fill($param);
    //                $save = $model->save();
    //                if($save) {
    //                     $project = \App\Models\Project::find($id);
    //                     if($project != null) {
    //                         $project_name = $project->name;
    //                     }

    //                     //create notif dulu
    //                     $dataNotif = array(
    //                         'name' => 'Notification Penawaran Project '.$project_name,
    //                         'description' => 'Project '.$project_name.' dengan kode penawaran '.$model->code.' telah sukses dikonfirmasi oleh '.CMemberLogin::get('name'),
    //                         'project_id' => $id,
    //                         'type' => 'penawaran',
    //                         'transaksi_id' => null,
    //                         'penawaran_id' => $model->id,
    //                         'ikm_id' => CMemberLogin::get('id'),
    //                         'ikm_name' => CMemberLogin::get('name'),
    //                         'penjahit_id' => $model->penjahit_id,
    //                         'penjahit_name' => \App\Models\Penjahit::find($model->penjahit_id)->name
    //                     );
    //                     $n = cnotif::create($dataNotif);
    //                     if($n) {
    //                         //sukses baru create transaksi
    //                         $project = \App\Models\Project::find($model->project_id);
    //                         //$ikm_id = $project->ikm_id;
    //                         //$project_name = $project->name;
    //                         //$description = $project->description;
    //                         //$spesifikasi = $project->spesification;
    //                         //$deadline = $project->deadline;

    //                         //$ikm = ;
    //                         //$owner_company = $ikm->company;
    //                         //$owner_code = $ikm->code;
    //                         //insert transaction
    //                         $dataTrans = array(
    //                             'offer_id' => $id,
    //                             'penjahit_id' => $model->penjahit_id,
    //                             'project_id' => $model->project_id,
    //                             'ikm_id' => $model->ikm_id,
    //                             'owner_project' => \App\Models\Ikm::find($model->ikm_id)->name,
    //                             'transaction_type' => $model->type,
    //                             'transaction_name' => 'Transaksi Project '.$project->name,
    //                             'transaction_code' => utils::generateTransaction($model->project_id),
    //                             'transaction_date' => date('Y-m-d H:i:s'),
    //                             'transaction_total' => $model->offer_price,
    //                             'transaction_status' => 'Pending',
    //                             'transaction_description' => null,
    //                             'transaction_note' => null
    //                         );
    //                         $result = false;
    //                         try {
    //                             $result = CTransaction::createTransaction($dataTrans);
    //                             //$result = CTransaction::createFormKerjasama($dataTrans);
    //                         } catch (ApiException $e) {
    //                             $errCode = 1455;
    //                             $errMsg = $e->getMessage();
    //                         } catch (\Exception $e) {
    //                             $errCode = 14414;
    //                             $errMsg = '[FATAL ERROR] '.$e->getMessage();
    //                         }
    //                     }


    //                }
    //             } catch (\Exception $e) {
    //                 $errCode = 1345;
    //                 $errMsg = $e->getMessage();
    //             }

    //             if($errCode == 0) {
    //                 DB::commit();
    //             } else {
    //                 DB::rollback();
    //             }
    //         } else {
    //             $errCode = 1414;
    //             $errMsg = "Data tidak ada";
    //         }
    //     }

    //     $json = array();
    //     if($errCode == 0) {
    //         $json['errCode'] = $errCode;
    //         $json['errMsg'] = $errMsg;
    //         $json['data'] = $data;
    //     } else {
    //         $json['errCode'] = $errCode;
    //         $json['errMsg'] = $errMsg;
    //     }
    //     return response()->json($json);
    // }


    // public function offerShow($id = null) {
    //     $errCode = 0;
    //     $errMsg = "";
    //     $data = array();
    //     $ukuranArray=array();
    //     $ikm_name = '';

    //     if(strlen($id) > 0) {
    //         $q = "SELECT o.id,
    //                  o.type,
    //                  p.id as project_id,
    //                  p.name as project_name,
    //                  p.price as project_price,
    //                  i.name as project_creator,
    //                  o.ikm_id,
    //                  o.offer_price,
    //                  o.is_approve_ikm,
    //                  o.is_approve_penjahit,
    //                  o.note ";
    //         $q .= " FROM offers o ";
    //         $q .= " JOIN project p ON p.id = o.project_id ";
    //         $q .= " JOIN ikm i ON i.id = o.ikm_id ";
    //         $where = "";
    //         if(strlen($id) > 0) {
    //             $where .= " o.id = '{$id}' AND ";
    //         }
    //         $where .= " 1=1 ";
    //         $q .= " WHERE $where ";
    //         $m = DB::select(DB::raw($q));
    //         if(count($m) > 0) {
    //             foreach($m as $rows) {
    //                 $project_id=$rows->project_id;
    //                 $ukuran=utils::get_ukuran($project_id);
    //                 if($ukuran!=null)
    //                 {
    //                     foreach ($ukuran as $key => $value) {
    //                         $ukuranArray[]=array(
    //                             'ukuran_nama'=>$value->name,
    //                             'qty'=>$value->qty
    //                         );
    //                     }
    //                     $data['ukuran']=$ukuranArray;
    //                 }

    //                 $image_name='';
    //                 $image_url='';
    //                 $image_project=utils::get_image($project_id);
    //                 if($image_project!=null)
    //                 {
    //                     foreach ($image_project as $key => $value) {
    //                         $file = $value->image_name;
    //                         $file_url = $value->image_url;
    //                     }
    //                     $image_name = $file;
    //                     $image_url = $file_url;
    //                 }
    //                 $data['image_name'] = $image_name;
    //                 $data['image_url'] = $image_url;

    //                 $data['id'] = $rows->id;
    //                 $data['project'] = $rows->project_name;
    //                 $data['type'] = $rows->type;
    //                 $ikm = \App\Models\Ikm::find($rows->ikm_id);
    //                 if($ikm != null) {
    //                     $ikm_name = $ikm->name;
    //                 }
    //                 $data['ikm_name'] = $ikm_name;
    //                 $data['project_price'] = config('cart.currency'). utils::formatCurrency($rows->project_price);
    //                 $data['project_creator'] = $rows->project_creator;
    //                 $data['offer_price'] = config('cart.currency'). utils::formatCurrency($rows->offer_price);
    //                 $data['is_approve_ikm'] = $rows->is_approve_ikm;
    //                 $data['is_approve_penjahit'] = $rows->is_approve_penjahit;
    //                 $data['note'] = $rows->note;
    //             }
    //         }

    //     }

    //     $array = array();
    //     if($errCode == 0) {
    //         $array['errCode'] = $errCode;
    //         $array['errMsg'] = $errMsg;
    //         $array['data'] = $data;
    //     } else {
    //         $array['errCode'] = $errCode;
    //         $array['errMsg'] = $errMsg;
    //     }
    //     return response()->json($array, 200);
    // }

    // public function kerja_sama() {
    //     $errCode = 0;
    //     $errMsg = "";
    //     $data = array();
    //     $request = array_merge($_GET, $_POST);
    //     if($request != null) {
    //         if($errCode == 0) {
    //         }
    //         if($errCode == 0) {
    //             try{
    //             } catch(\Exception $ex) {
    //             }
    //             if($errCode == 0) {
    //             } else {
    //                 cmsg::add('error', $errMsg);
    //             }
    //         }
    //     }
    //     $res = array();
    //     if($errCode == 0) {
    //         $res['errCode'] = $errCode;
    //         $res['errMsg'] = $errMsg;
    //         $res['data'] = $doc;
    //     } else {
    //         $res['errCode'] = $errCode;
    //         $res['errMsg'] = $errMsg;
    //     }
    //     return response()->json($res, 200);
    // }
}
