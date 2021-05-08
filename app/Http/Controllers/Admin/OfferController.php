<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\Penawaran;
use Lintas\helpers\utils;
use Lintas\helpers\cmsg;
use Lintas\helpers\cnotif;
use Lintas\libraries\CUserLogin;
use DB, Auth;

class OfferController extends AdminController
{
    public function offer() {
        $data = array();
        $data['title'] = "Penawaran";
        return view('admin.transaction.offer', $data);
    }

    // public function offerList() {
    //     $errCode = 0;
    //     $errMsg = "";
    //     $data = array();
    //     $auth = Auth::guard('admin')->user();
    //     $ikm_id = ($auth->ikm_id == null ? '' : $auth->ikm_id);

    //     $q = "SELECT o.id,
    //                  o.penjahit_id,
    //                  o.ikm_id,
    //                  o.type,
    //                  p.id as project_id,
    //                  p.name as project_name,
    //                  p.price as project_price,
    //                  i.name_display as project_creator,
    //                  o.offer_price,
    //                  IFNULL(o.status_confirm, 'Pending') as status_confirm,
    //                  o.is_approve_ikm,
    //                  o.is_approve_penjahit,
    //                  o.created_at,
    //                  o.updated_at ";
    //     $q .= " FROM offers o ";
    //     $q .= " JOIN project p ON p.id = o.project_id ";
    //     $q .= " JOIN ikm i ON i.id = o.ikm_id ";
    //     $where = "";
    //     if($ikm_id != null) {
    //         $where .= " o.ikm_id = '{$ikm_id}' AND o.status > 0 AND ";
    //     }
    //     $where .= " 1=1 ";
    //     $q .= " WHERE $where ";
    //     $result = DB::select(DB::raw($q));
    //     if(count($result) > 0) {
    //         foreach($result as $d) {
    //             $data[] = array(
    //                 'id' => $d->id,
    //                 'type' => $d->type,
    //                 'project_creator' => $d->project_creator,
    //                 'project' => $d->project_name,
    //                 'price' => $d->project_price,
    //                 'offer_price' => $d->offer_price,
    //                 'is_approve_ikm' => $d->is_approve_ikm,
    //                 'is_approve_penjahit' => $d->is_approve_penjahit,
    //                 'created_at' => (string)$d->created_at,
    //                 'updated_at' => (string)$d->updated_at,
    //                 'status_confirm' => $d->status_confirm
    //             );
    //         }
    //     }

    //     $array = array();
    //     if($errCode == 0) {
    //         if(count($data) > 0) {
    //             foreach($data as $rows){
    //                 $array['data'][] = $rows;
    //             }
    //         } else {
    //             $array['data'] = array();
    //         }
    //     }
    //     return response()->json($array, 200);
    // }

    // public function getPenawaran($id = null) {
    //     $errCode = 0;
    //     $errMsg = "";
    //     $data = array();

    //     $result = \App\Models\Penawaran::where('id', '=', $id)->first();
    //     if($result != null) {
    //         $data['ikm_id'] = $result->ikm_id;
    //         if($result->ikm_id != null) {
    //             $data['ikm_name'] = \App\Models\Ikm::find($result->ikm_id)->name;
    //             $data['ikm_code'] = \App\Models\Ikm::find($result->ikm_id)->code;
    //         }
    //         $data['penjahit_id'] = $result->penjahit_id;
    //         if($result->penjahit_id != null) {
    //             $data['penjahit_name'] = \App\Models\Penjahit::find($result->penjahit_id)->name;
    //             $data['penjahit_code'] = \App\Models\Penjahit::find($result->penjahit_id)->code;
    //         }
    //         $data['project_id'] = $result->project_id;
    //     } else {
    //         $errCode = 14667;
    //         $errMsg = "Data not found";
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

    // public function offerShow($id = null) {
    //     $errCode = 0;
    //     $errMsg = "";
    //     $data = array();
    //     $penjahit_name = '';
    //     $ukuranArray=array();

    //     if(strlen($id) > 0) {
    //         $q = "SELECT o.id,
    //                  o.type,
    //                  p.id as project_id,
    //                  p.name as project_name,
    //                  p.price as project_price,
    //                  i.name as project_creator,
    //                  o.penjahit_id,
    //                  o.offer_price,
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

    //                 $data['project'] = $rows->project_name;
    //                 $data['image_name'] = $image_name;
    //                 $data['image_url'] = $image_url;
    //                 $data['type'] = $rows->type;
    //                 $penjahit = \App\Models\Penjahit::find($rows->penjahit_id);
    //                 if($penjahit != null) {
    //                     $penjahit_name = $penjahit->name;
    //                 }
    //                 $data['penjahit_name'] = $penjahit_name;
    //                 $data['project_price'] = config('cart.currency'). utils::formatCurrency($rows->project_price);
    //                 $data['project_creator'] = $rows->project_creator;
    //                 $data['offer_price'] = config('cart.currency'). utils::formatCurrency($rows->offer_price);
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

    // public function approve(Request $request, $id = null) {
    //     $errCode = 0;
    //     $errMsg = "";
    //     $data = array();
    //     $project_name = '';

    //     if($errCode == 0) {
    //         if(strlen($id) == 0) {
    //             $errCode++;
    //             $errMsg = "ID required";
    //         }
    //     }

    //     if($errCode == 0) {
    //         $model = Penawaran::find($id);
    //         if($model != null) {
    //             DB::beginTransaction();
    //             try {
    //                $param = array();
    //                $param["id"] = $id;
    //                $param["is_approve_ikm"] = 1;
    //                $param["date_approve_ikm"] = date('Y-m-d H:i:s');
    //                $param["last_approve"] = date('Y-m-d H:i:s');
    //                $param["last_request"] = date('Y-m-d H:i:s');
    //                $param["note"] = "Approve by IKM";
    //                if(strlen($id) == 0) {
    //                   $model = new Penawaran;
    //                }
    //                $model->fill($param);
    //                $s = $model->save();
    //                if($s) {
    //                     $project = \App\Models\Project::find($id);
    //                     if($project != null) {
    //                         $project_name = $project->name;
    //                     }

    //                     $dataNotif = array(
    //                         'name' => 'Notification Penawaran Project '.$project_name,
    //                         'description' => 'Project '.$project_name.' dengan kode penawaran '.$model->code.' telah sukses dikonfirmasi oleh '.CUserLogin::get('name'),
    //                         'project_id' => $id,
    //                         'type' => 'penawaran',
    //                         'transaksi_id' => null,
    //                         'penawaran_id' => $model->id,
    //                         'ikm_id' => CUserLogin::get('id'),
    //                         'ikm_name' => CUserLogin::get('name'),
    //                         'penjahit_id' => $model->penjahit_id,
    //                         'penjahit_name' => \App\Models\Penjahit::find($model->penjahit_id)->name
    //                     );
    //                     cnotif::create($dataNotif);
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
    //             $errCode = 1445;
    //             $errMsg = "Data tidak ada";
    //         }
    //     }

    //     if($errCode == 0) {
    //         $response['errCode'] = $errCode;
    //         $response['errMsg'] = $errMsg;
    //         $response['data'] = $data;
    //     } else {
    //         $response['errCode'] = $errCode;
    //         $response['errMsg'] = $errMsg;
    //     }
    //     return response()->json($response);
    // }

    // public function cancel(Request $request, $id = null) {
    //     $errCode = 0;
    //     $errMsg = "";
    //     $data = array();
    //     $penjahit_name='';

    //     if($errCode == 0) {
    //         if(strlen($id) == 0) {
    //             $errCode++;
    //             $errMsg = "ID required";
    //         }
    //     }

    //     if($errCode == 0) {
    //         $model = Penawaran::find($id);
    //         if($model != null) {
    //             DB::beginTransaction();
    //             try {
    //                 $param = array();
    //                 $param["id"] = $id;
    //                 $param["is_approve_ikm"] = 0;
    //                 $param["date_approve_ikm"] = null;
    //                 $param["last_approve"] = null;
    //                 $param["last_request"] = null;
    //                 $param["note"] = "Cancelled by IKM";
    //                 $param["status_confirm"] = "Cancel";
    //                 if(strlen($id) == 0) {
    //                     $model = new Penawaran;
    //                 }
    //                 $model->fill($param);
    //                 $s = $model->save();
    //                 if($s) {
    //                     $penjahit=\App\Models\Penjahit::find($model->penjahit_id);
    //                     if($penjahit != null)
    //                     {
    //                         $penjahit_name = $penjahit->name;
    //                     }

    //                     $dataNotif = array(
    //                         'name' => 'Notification Penawaran '.$model->code,
    //                         'description' => 'Penawaran '.$model->code.' telah dicancel oleh '.CUserLogin::get('name'),
    //                         'project_id' => $model->project_id,
    //                         'type' => 'penawaran',
    //                         'transaksi_id' => null,
    //                         'penawaran_id' => $model->id,
    //                         'ikm_id' => CUserLogin::get('id'),
    //                         'ikm_name' => CUserLogin::get('name'),
    //                         'penjahit_id' => $model->penjahit_id,
    //                         'penjahit_name' => $penjahit_name
    //                     );
    //                     cnotif::create($dataNotif);
    //                 }
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
    //             $errCode = 1445;
    //             $errMsg = "Data tidak ada";
    //         }
    //     }

    //     if($errCode == 0) {
    //         $response['errCode'] = $errCode;
    //         $response['errMsg'] = $errMsg;
    //         $response['data'] = $data;
    //     } else {
    //         $response['errCode'] = $errCode;
    //         $response['errMsg'] = $errMsg;
    //     }
    //     return response()->json($response);
    // }





}
