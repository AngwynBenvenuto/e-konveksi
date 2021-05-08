<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\Transaksi;
use Lintas\helpers\cmsg;
use DB;
use Lintas\helpers\cnotif;
use Lintas\helpers\utils;
use Lintas\libraries\CUserLogin;

class TransactionController extends AdminController
{
    public function list() {
        $data = array();
        $data['title'] = "Transaksi";
        return view('admin.transaction.list', $data);
    }

    // public function transaksiList() {
    //     $errCode = 0;
    //     $errMsg = "";
    //     $data = array();
    //     $ikm_id = '';
    //     $request = array_merge($_GET, $_POST);

    //     if($request != null) {
    //         $ikm_id = Arr::get($request, 'ikm_id');
    //     }

    //     if($errCode == 0) {
    //         $modelTransaksi = Transaksi::with(['project'])
    //                             ->where('status', '>', 0)
    //                             ->where('ikm_id', '=', $ikm_id)
    //                             ->get();
    //         if($modelTransaksi != null) {
    //             foreach($modelTransaksi as $rows) {
    //                 $data[] = array(
    //                     'id' => $rows->id,
    //                     'code' => $rows->code,
    //                     'project' => $rows->project->name,
    //                     'type' => $rows->type,
    //                     'price' => $rows->project->price,
    //                     'payment' => $rows->transaction_total,
    //                     'progress' => $rows->progress,
    //                     'created_at' => (string)$rows->created_at,
    //                     'updated_at' => (string)$rows->updated_at,
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



}
