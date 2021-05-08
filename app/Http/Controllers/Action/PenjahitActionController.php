<?php

namespace App\Http\Controllers\Action;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Support\Arr;

class PenjahitActionController extends Controller
{


    public function review() {
        $errCode = 0;
        $errMsg = '';
        $note = '';
        $invoice_id = '';
        $invoice = '';
        $penjahit_id = '';
        $penjahit_name = '';
        $ikm_id = '';
        $ikm_name = '';
        $transaction_id = '';
        $transaction_code = '';
        $project_id = '';
        $project_name = '';

        $request = array_merge($_GET, $_POST);
        if($request != null) {
            $transaksi_id = Arr::get($request, 'transaksi_id');
        }

        if($errCode == 0) {
            $transaksi = \App\Models\Transaksi::find($transaksi_id);
            if($transaksi != null) {
                $transaction_id = $transaksi->id;
                $transaction_code = $transaksi->code;
                $penjahit_id = $transaksi->penjahit_id;
                $penjahit = \App\Models\Penjahit::find($penjahit_id);
                if($penjahit != null) {
                    $penjahit_name = $penjahit->name_display;
                }

                $ikm_id = $transaksi->ikm_id;
                $ikm = \App\Models\Ikm::find($ikm_id);
                if($ikm != null) {
                    $ikm_name = $ikm->name_display;
                }

                $project_id = $transaksi->project_id;
                $project = \App\Models\Project::find($project_id);
                if($project != null) {
                    $project_name = $project->name;
                }
            }
        }

        $data = array();
        $data['title'] = "Review";
        $data['invoice_id'] = $invoice_id;
        $data['invoice'] = $invoice;
        $data['transaction_id'] = $transaction_id;
        $data['transaction_code'] = $transaction_code;
        $data['ikm_id'] = $ikm_id;
        $data['ikm_name'] = $ikm_name;
        $data['project_id'] = $project_id;
        $data['project_name'] = $project_name;
        $data['penjahit_id'] = $penjahit_id;
        $data['penjahit_name'] = $penjahit_name;
        return view('front.user.review', $data);
    }
}
