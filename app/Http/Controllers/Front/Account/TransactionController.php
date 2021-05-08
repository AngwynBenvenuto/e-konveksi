<?php

namespace App\Http\Controllers\Front\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Delivery;
use Illuminate\Support\Arr;
use Lintas\helpers\utils;
use Lintas\helpers\cnotif;
use Lintas\libraries\CMemberLogin;
use DB;

class TransactionController extends Controller
{
    public function list(){
        return view('front.user.transaction');
    }

    // public function transaksiList() {
    //     $errCode = 0;
    //     $errMsg = "";
    //     $data = array();
    //     $penjahit_id = '';
    //     $request = array_merge($_GET, $_POST);

    //     if($request != null) {
    //         $penjahit_id = Arr::get($request, 'penjahit_id');
    //     }

    //     if($errCode == 0) {
    //         $modelTransaksi = Transaksi::with(['project'])
    //                             ->where('status', '>', 0)
    //                             ->where('penjahit_id', '=', $penjahit_id)
    //                             ->get();
    //         if($modelTransaksi != null) {
    //             foreach($modelTransaksi as $rows) {
    //                 $data[] = array(
    //                     'id' => $rows->id,
    //                     'code' => $rows->code,
    //                     'owner' => $rows->project->ikm->name,
    //                     'project' => $rows->project->name,
    //                     'type' => $rows->type,
    //                     'price' => $rows->project->price,
    //                     'payment' => $rows->transaction_total,
    //                     'payment_confirmed' => $rows->payment_confirmed,
    //                     'created_at' => (string)$rows->created_at,
    //                     'updated_at' => (string)$rows->updated_at,
    //                     'progress' => $rows->progress,
    //                     'status' => $rows->transaction_status == null ? "Pending" : $rows->transaction_status,
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


    // public function transaksiShow($id = null) {
    //     $errCode = 0;
    //     $errMsg = "";
    //     $data = array();
    //     $ukuranArray=array();
    //     $ikm_name = '';

    //     if(strlen($id) > 0) {
    //         $q = "SELECT t.id,
    //                  t.name,
    //                  t.code,
    //                  t.type,
    //                  t.ikm_id,
    //                  p.id as project_id,
    //                  p.name as project_name,
    //                  p.price as project_price,
    //                  i.name as project_creator,
    //                  t.transaction_total,
    //                  t.transaction_status,
    //                  t.note ";
    //         $q .= " FROM transaction t ";
    //         $q .= " JOIN project p ON p.id = t.project_id ";
    //         $q .= " JOIN ikm i ON i.id = t.ikm_id ";
    //         $where = "";
    //         if(strlen($id) > 0) {
    //             $where .= " t.id = '{$id}' AND ";
    //         }
    //         $where .= " 1=1 ";
    //         $q .= " WHERE $where ";
    //         $m = DB::select(DB::raw($q));
    //         if(count($m) > 0) {
    //             foreach($m as $rows) {
    //                  $project_id=$rows->project_id;
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
    //                 $data['project'] = $rows->project_name;
    //                 $data['type'] = $rows->type;
    //                 $ikm = \App\Models\Ikm::find($rows->ikm_id);
    //                 if($ikm != null) {
    //                     $ikm_name = $ikm->name;
    //                 }
    //                 $data['ikm_name'] = $ikm_name;
    //                 $data['project_price'] = config('cart.currency'). utils::formatCurrency($rows->project_price);
    //                 $data['project_creator'] = $rows->project_creator;
    //                 $data['transaction_total'] = config('cart.currency'). utils::formatCurrency($rows->transaction_total);
    //                 $data['transaction_status'] = $rows->transaction_status;
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
    //     if($errCode == 0) {
    //         if(strlen($id) == 0) {
    //             $errCode++;
    //             $errMsg = "ID required";
    //         }
    //     }
    //     if($errCode == 0) {
    //         $model = Transaksi::find($id);
    //         if($model != null) {
    //             DB::beginTransaction();
    //             try {
    //                $param = array();
    //                $param["id"] = $id;
    //                $param["transaction_status"] = "Approve";
    //                $param["note"] = "";
    //                if(strlen($id) == 0) {
    //                   $model = new Transaksi;
    //                }
    //                $model->fill($param);
    //                $s = $model->save();
    //                if($s) {
    //                     $dataNotif = array(
    //                         'name' => 'Notification Transaksi '.$model->code,
    //                         'description' => 'Transaksi '.$model->code.' telah sukses dikonfirmasi oleh '.\App\Models\Ikm::find($model->ikm_id)->name,
    //                         'project_id' => $id,
    //                         'type' => 'transaksi',
    //                         'transaksi_id' => $model->id,
    //                         'penawaran_id' => null,
    //                         'ikm_id' => $model->ikm_id,
    //                         'ikm_name' => \App\Models\Ikm::find($model->ikm_id)->name,
    //                         'penjahit_id' =>  \Lintas\libraries\CMemberLogin::get('id'),
    //                         'penjahit_name' => \Lintas\libraries\CMemberLogin::get('name')
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

    // public function print_form_kerjasama() {
    //     $file = public_path('data/rtf/surat_pernyataan.rtf');
	// 	$array = array(
	// 		'[NOMOR_SURAT]' => '015/BT/SK/V/2017',
	// 		'[PERUSAHAAN]' => 'CV. Borneo Teknomedia',
	// 		'[NAMA]' => 'Melani Malik',
	// 		'[NIP]' => '6472065508XXXX',
	// 		'[ALAMAT]' => 'Jl. Manunggal Gg. 8 Loa Bakung, Samarinda',
	// 		'[PERMOHONAN]' => 'Permohonan pengurusan pembuatan NPWP',
	// 		'[KOTA]' => 'Samarinda',
	// 		'[DIRECTOR]' => 'Noviyanto Rahmadi',
	// 		'[TANGGAL]' => date('d F Y'),
	// 	);
	// 	$nama_file = 'surat-keterangan-kerja.doc';
	// 	return \WordTemplate::export($file, $array, $nama_file);
    // }





}
