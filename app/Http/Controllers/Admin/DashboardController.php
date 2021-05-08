<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Arr;
use Lintas\libraries\CUserLogin;

class DashboardController extends AdminController {
    public function index() {
        $data = array();
        $penjahit = \App\Models\Penjahit::where('status', '>', 0)
                            ->where('verified', '>', 0)
                            ->get();

        $project = \App\Models\Project::where('status', '>', 0)
                            ->where('ikm_id', '=', CUserLogin::get('id'))
                            ->get();

        $data['penjahit'] = $penjahit;
        $data['project'] = $project;
        return view('admin.dashboard', $data);
    }

    public function list() {
        $errCode = 0;
        $errMsg = "";
        $data = array();
        $request = array_merge($_POST, $_GET);
        $start_date = '';
        $end_date = '';
        $response = array();
        $user = array();
        $penawaran = array();

        if($request != null) {
            $start_date = Arr::get($request, 'start_date');
            $end_date = Arr::get($request, 'end_date');
        }

        if($errCode == 0) {
            $result_user = $this->buildQuery('ikm', $start_date, $end_date);
            $result_penawaran = $this->buildQuery('offers', $start_date, $end_date);
            $result_transaksi = $this->buildQuery('transaction', $start_date, $end_date);
            if($result_user != null) {
                $res_user = $result_user[0];
                $user = array(
                    'active' => $res_user->active == NULL ? 0 : $res_user->active,
                    'disable' => $res_user->disable == NULL ? 0 : $res_user->disable,
                    'total' => $res_user->total == NULL ? 0 : $res_user->total
                );
            }
            if($result_penawaran != null) {
                $res_penawaran = $result_penawaran[0];
                $penawaran = array(
                    'active' => $res_penawaran->active == NULL ? 0 : $res_penawaran->active,
                    'disable' => $res_penawaran->disable == NULL ? 0 : $res_penawaran->disable,
                    'total' => $res_penawaran->total == NULL ? 0 : $res_penawaran->total
                );
            }
            if($result_transaksi != null) {
                $res_transaksi = $result_transaksi[0];
                $transaksi = array(
                    'active' => $res_transaksi->active == NULL ? 0 : $res_transaksi->active,
                    'disable' => $res_transaksi->disable == NULL ? 0 : $res_transaksi->disable,
                    'total' => $res_transaksi->total == NULL ? 0 : $res_transaksi->total
                );
            }
        }

        if($errCode == 0) {
            $data['user'] = $user;
            $data['penawaran'] = $penawaran;
            $data['transaksi'] = $transaksi;
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

    public function chat() {
        $user_id = CUserLogin::get('id');
        $project = array();
        $project_id = '';
        $q = "
            SELECT id,
                    name,
                    code,
                    status
            FROM project
        ";
            $where = "";
            if(strlen($user_id) > 0) {
                $where .= " ikm_id = '{$user_id}' AND ";
            }
            $where .= "
                status > 0 AND
                1=1
            ";
        $q .= " WHERE $where ";
        $result = DB::select(DB::raw($q));
        if($result != null) {
            foreach($result as $r) {
                $project[] = array(
                    'id' => $r->id,
                    'name' => $r->name,
                    'code' => $r->code,
                );
            }
        }

        $data = array();
        $data['project'] = $project;
        $data['project_id'] = $project_id;
        $data['title'] = "Chat";
        return view('admin.ikm.chat', $data);
    }



    //
    private function buildQuery($table = null, $start_date = null, $end_date = null) {
        $q = "SELECT SUM(IF(`status` > 0, 1, 0)) as `active`,
                     SUM(IF(`status` = 0, 1, 0)) as `disable`,
                     SUM(IF(`status` > 0, 1, 0) + IF(`status` = 0, 1, 0)) as `total`
              FROM $table ";
        if(strlen($start_date) > 0 && strlen($end_date) > 0) {
            $q .= " WHERE created_at BETWEEN '{$start_date}' AND '{$end_date}' ";
        }
        $result = DB::select(DB::raw($q));
        return $result;
    }




}