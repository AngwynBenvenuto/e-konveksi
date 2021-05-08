<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Auth, Hash, DB;
use Lintas\helpers\cmsg;
use Lintas\helpers\utils;
use Illuminate\Support\Arr;
use App\Models\Penjahit;
use App\Models\Chat;
use Lintas\libraries\CUserLogin;

class ChatController extends AdminController {
    public function index() {
        return view('admin.chat');
    }

    // public function chatList() {
    //     $errCode = 0;
    //     $errMsg = '';
    //     $request = array_merge($_GET, $_POST);
    //     $ikm_id = "";

    //     if($request != null) {
    //         $ikm_id = Arr::get($request, 'id');
    //     } else {
    //         $ikm_id = CUserLogin::get('id');
    //     }

    //     $q = "SELECT c.id,
    //                  i.name as ikm_name,
    //                  p.id as penjahit_id,
    //                  p.name as penjahit_name,
    //                  p.image_url as penjahit_image_url,
    //                  MAX(c.`message`) as messages,
    //                  c.created_at as `time`
    //           FROM chatting c
    //           LEFT JOIN ikm i ON i.id = c.receiver
    //           LEFT JOIN penjahit p ON p.id = c.sender ";
    //     $where = " 1=1 ";
    //     if(strlen($ikm_id) > 0) {
    //         $where .= " AND c.receiver = '$ikm_id' ";
    //     }
    //     $q .= " WHERE $where
    //             GROUP BY p.name
    //             ORDER BY c.created_at ASC

    //         ";
    //     $result = DB::select(DB::raw($q));
    //     if($result != null) {
    //         foreach($result as $r) {
    //             $data[] = array(
    //                 'ikm_name' => $r->ikm_name,
    //                 'id' => $r->penjahit_id,
    //                 'name' => $r->penjahit_name,
    //                 'image_url' => ($r->penjahit_image_url == null ? asset('public/img/no_image.png') : $r->penjahit_image_url),
    //                 'message' => $r->messages,
    //                 'time' => utils::formatTime($r->time),
    //             );
    //         }
    //     } else {
    //         $errCode = 1466;
    //         $errMsg = "Data tidak ada";
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

    // public function chatUser() {
    //     $errCode = 0;
    //     $errMsg = '';
    //     $request = array_merge($_GET, $_POST);

    //     if($request != null) {
    //         $sender = Arr::get($request, 'sender');

    //         if($errCode == 0) {
    //             if(strlen($sender) == 0) {
    //                 $errCode = 1566;
    //                 $errMsg = "Sender harus diisi";
    //             }
    //         }

    //         if($errCode == 0) {
    //             $model = Penjahit::find($sender);
    //             if($model != null) {
    //                 $data = array(
    //                     'name' => $model->name,
    //                     'name_display' => $model->name_display,
    //                     'image_url' => ($model->image_url == null ? asset('public/img/no_image.png') : $model->image_url),
    //                 );
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

    // public function chatMessage() {
    //     $errCode = 0;
    //     $errMsg = '';
    //     $request = array_merge($_GET, $_POST);
    //     $data = array();

    //     if($request != null) {
    //         $receiver = Arr::get($request, 'receiver');
    //         $sender = Arr::get($request, 'sender');

    //         if($errCode == 0) {
    //             if(strlen($sender) == 0) {
    //                 $errCode = 1566;
    //                 $errMsg = "Sender harus diisi";
    //             }
    //         }

    //         if($errCode == 0) {
    //             $q = "SELECT id, project_id, receiver, sender, `message`
    //                   FROM chatting ";
    //             $where = " 1=1 ";
    //             if(strlen($sender) > 0 && strlen($receiver) > 0) {
    //                 $where .= " AND ((receiver = '$receiver' OR receiver = '$sender') AND (sender = '$receiver' OR sender = '$sender')) ";
    //             }
    //             $q .= " WHERE $where ";
    //             $result = DB::select(DB::raw($q));
    //             if($result != null) {
    //                 foreach($result as $r) {
    //                     $data[] = array(
    //                         'project_id' => $r->project_id,
    //                         'receiver' => $r->receiver,
    //                         'sender' => $r->sender,
    //                         'message' => $r->message,
    //                     );
    //                 }
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

    // public function chatSend() {
    //     $errCode = 0;
    //     $errMsg = "";
    //     $data = array();
    //     $request = array_merge($_GET, $_POST);

    //     if($request != null) {
    //         $receiver = Arr::get($request, 'receiver');
    //         $sender = Arr::get($request, 'penjahit');
    //         $message = Arr::get($request, 'message');

    //         if($errCode == 0) {
    //             $param = array();
    //             $param['receiver'] = $receiver;
    //             $param['sender'] = $sender;
    //             $param['message'] = $message;
    //             $param['send_date'] = date('Y-m-d H:i:s');

    //             try{
    //                 $cht = Chat::where('receiver', '=', $sender)
    //                             ->where('sender', '=', $receiver)
    //                             ->first();
    //                 if($cht != null) {
    //                     $param['project_id'] = $cht->project_id;
    //                 }

    //                 //insert
    //                 $new_cht = new Chat;
    //                 $new_cht->fill($param);
    //                 $new_cht->save();
    //             } catch(\Exception $ex) {
    //                 $errCode = 151;
    //                 $errMsg = $ex->getMessage();
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
}