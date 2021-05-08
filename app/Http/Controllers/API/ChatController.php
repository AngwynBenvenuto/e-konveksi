<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Lintas\helpers\utils;
use Lintas\helpers\cmsg;
use App\Models\Chat;
use App\Models\Project;
use DB;

class ChatController extends Controller {

    // public function getProject() {
    //     $errCode = 0;
    //     $errMsg = '';
    //     $user_id = '';
    //     $data = array();
    //     $request = array_merge($_GET, $_POST);
    //     if($request != null) {
    //         $user_id = Arr::get($request, 'user_id');
    //     }
    //     if($errCode == 0) {
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

     public function getChatByPenjahit() {
        $errCode = 0;
        $errMsg = '';
        $data = array();
        $request = array_merge($_GET, $_POST);
        $project_id = '';
        $penjahit_id = '';

        if($request != null) {
            $project_id = Arr::get($request, 'project_id');
            $penjahit_id = Arr::get($request, 'penjahit_id');
            $user_login_id = Arr::get($request, 'user_login_id');
            $penjahit_code = Arr::get($request, 'penjahit_code');
        }

        if($errCode == 0) {
            $q = "
                SELECT id,
                     project_id,
                     receiver,
                     receiver_unique,
                     sender_unique,
                     sender,
                     `message`,
                     created_at as `time`
              FROM chatting
            ";
                $where = "";
                if(strlen($project_id) > 0) {
                    $where .= " project_id = '{$project_id}' AND ";
                }
                if(strlen($penjahit_id) > 0) {
                    $where .= " (receiver = '{$penjahit_id}' OR sender = '{$penjahit_id}') AND ";
                }
                if(strlen($penjahit_code) > 0) {
                    $where .= " (receiver_unique = '{$penjahit_code}' OR sender_unique = '{$penjahit_code}') AND ";
                }
                $where .= " 1=1 ";
            $q .= " WHERE $where ";
            $result = DB::select(DB::raw($q));
            if($result != null) {
                foreach($result as $r) {
                    $data[] = array(
                        'id' => $r->id,
                        'project_id' => $r->project_id,
                        'receiver' => $r->receiver,
                        'receiver_unique' => $r->receiver_unique,
                        'sender' => $r->sender,
                        'sender_unique' => $r->sender_unique,
                        'message' => $r->message,
                        'time' => utils::formatTime($r->time),
                    );
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

    public function getChatByIkm() {
        $errCode = 0;
        $errMsg = '';
        $data = array();
        $request = array_merge($_GET, $_POST);
        $project_id = '';
        $ikm_id = '';

        if($request != null) {
            $project_id = Arr::get($request, 'project_id');
            $ikm_id = Arr::get($request, 'ikm_id');
            $ikm_code = Arr::get($request, 'ikm_code');
        }

        if($errCode == 0) {
            $q = "
                SELECT id,
                     project_id,
                     receiver,
                     receiver_unique,
                     sender_unique,
                     sender,
                     `message`,
                     created_at as `time`
              FROM chatting
            ";
                $where = "";
                if(strlen($project_id) > 0) {
                    $where .= " project_id = '{$project_id}' AND ";
                }
                if(strlen($ikm_id) > 0) {
                    $where .= " (receiver = '{$ikm_id}' OR sender = '{$ikm_id}') AND ";
                }
                if(strlen($ikm_code) > 0) {
                    $where .= " (receiver_unique = '{$ikm_code}' OR sender_unique = '{$ikm_code}') AND ";
                }
                $where .= " 1=1 ";
            $q .= " WHERE $where ";
            $result = DB::select(DB::raw($q));
            if($result != null) {
                foreach($result as $r) {
                    $data[] = array(
                        'id' => $r->id,
                        'project_id' => $r->project_id,
                        'receiver' => $r->receiver,
                        'receiver_unique' => $r->receiver_unique,
                        'sender' => $r->sender,
                        'sender_unique' => $r->sender_unique,
                        'message' => $r->message,
                        'time' => utils::formatTime($r->time),
                    );
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

    public function chatboxList() {
        $errCode = 0;
        $errMsg = '';
        $data = array();
        $request = array_merge($_GET, $_POST);
        $chatbox = array();
        $dataChatbox = array();
        $project_id = '';

        if($request != null) {
            $project_id = Arr::get($request, 'project_id');
        }

        if($errCode == 0) {
            $q = "
                SELECT c.id as chatting_id,
                     c.project_id,
                     c.receiver,
                     p.id as penjahit_id,
                     p.name as penjahit_name,
                     p.code as penjahit_code,
                     p.image_url as penjahit_image,
                     c.sender,
                     MAX(c.message) as `message`,
                     c.created_at as `time`
                FROM chatting c
                INNER JOIN penjahit p ON p.id = c.receiver
            ";
                $where = "";
                if(strlen($project_id) > 0) {
                    $where .= " c.project_id = '{$project_id}' AND ";
                }
                $where .= " 1=1 ";
            $q .= "
                WHERE $where
                GROUP BY c.receiver, c.project_id
                ORDER BY c.message DESC
            ";
            $result = DB::select(DB::raw($q));
            if($result != null) {
                foreach($result as $r) {
                    $dataChatbox[] = array(
                        'id' => $r->chatting_id,
                        'project_id' => $r->project_id,
                        'receiver' => $r->receiver,
                        'penjahit_id' => $r->penjahit_id,
                        'penjahit_name' => $r->penjahit_name,
                        'penjahit_code' => $r->penjahit_code,
                        'penjahit_image' => $r->penjahit_image,
                        'sender' => $r->sender,
                        'message' => $r->message,
                        'time' => utils::formatTime($r->time),
                    );
                }
            }
        }

        $array = array();
        if($errCode == 0) {
            $array['errCode'] = $errCode;
            $array['errMsg'] = $errMsg;
            $array['data'] = $dataChatbox ;
        } else {
            $array['errCode'] = $errCode;
            $array['errMsg'] = $errMsg;
        }
        return response()->json($array, 200);


    }

    // public function getChatByProject() {
    //     $errCode = 0;
    //     $errMsg = '';
    //     $project_id = '';
    //     $data = array();
    //     $request = array_merge($_GET, $_POST);

    //     if($request != null) {
    //         $project_id = Arr::get($request, 'project_id');
    //         // $receiver = Arr::get($request, 'receiver');
    //         // $user = Arr::get($request, 'user');
    //     }

    //     if($errCode == 0) {
    //         //$result = self::buildChatQuery($project_id, $receiver, $user);
    //         $q = "
    //             SELECT id,
    //                  project_id,
    //                  receiver,
    //                  sender,
    //                  `message`,
    //                  created_at as `time`
    //           FROM chatting
    //         ";
    //             $where = "";
    //             if(strlen($project_id) > 0) {
    //                 $where .= " project_id = '{$project_id}' AND ";
    //             }
    //             $where .= " 1=1 ";
    //         $q .= " WHERE $where ";
    //         $result = DB::select(DB::raw($q));
    //         if($result != null) {
    //             foreach($result as $r) {
    //                 $data[] = array(
    //                     'id' => $r->id,
    //                     'project_id' => $r->project_id,
    //                     'receiver' => $r->receiver,
    //                     'sender' => $r->sender,
    //                     'message' => $r->message,
    //                     'time' => utils::formatTime($r->time),
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

    public function sendChat() {
        $errCode = 0;
        $errMsg = "";
        $data = array();
        $request = array_merge($_GET, $_POST);
        if($request != null) {
            $project_id = Arr::get($request, 'project_id');
            $receiver = Arr::get($request, 'receiver');
            $receiver_unique = Arr::get($request, 'receiver_unique');
            $user = Arr::get($request, 'sender');
            $user_unique = Arr::get($request, 'sender_unique');
            $message = Arr::get($request, 'message');

            if($errCode == 0) {
                if(strlen($message) == 0) {
                    $errCode = 14566;
                    $errMsg = "Message required";
                }
            }

            if($errCode == 0) {
                $param = array();
                $param['project_id'] = $project_id;
                $param['receiver'] = $receiver;
                $param['receiver_unique'] = $receiver_unique;
                $param['sender'] = $user;
                $param['sender_unique'] = $user_unique;
                $param['message'] = $message;
                $param['send_date'] = date('Y-m-d H:i:s');

                DB::beginTransaction();
                try{
                    $cht = new Chat;
                    $cht->fill($param);
                    $cht->save();
                } catch(\Exception $ex) {
                    $errCode = 151;
                    $errMsg = $ex->getMessage();
                }

                if($errCode == 0) {
                    DB::commit();
                } else {
                    DB::rollback();
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

    // public function listChat() {
    //     $errCode = 0;
    //     $errMsg = "";
    //     $data = array();
    //     $request = array_merge($_GET, $_POST);
    //     if($request != null) {
    //         $id = Arr::get($request, 'id');
    //         if($errCode == 0) {
    //             if(strlen($id) == 0) {
    //                 $errCode++;
    //                 $errMsg = "Penerima required";
    //             }
    //         }
    //         if($errCode == 0) {
    //             $result = self::buildChatList($id);
    //             if($result != null) {
    //                 foreach($result as $row) {
    //                     $data[] = array(
    //                         'id'=> $row->id,
    //                         'project_id' => $row->project_id,
    //                         'receiver_id' => $row->receiver_id,
    //                         'receiver_name' => $row->receiver_name,
    //                         'receiver_image' => $row->receiver_image,
    //                         'message' => $row->message,
    //                         'created_at' => utils::formatTime($row->created_at),
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


    //query chat
    // private static function buildChatQuery($project_id, $receiver, $user) {
    //     $q = "SELECT id,
    //                  project_id,
    //                  receiver,
    //                  sender,
    //                  `message`,
    //                  created_at as `time`
    //           FROM chatting ";
    //         $where = "";
    //         if(strlen($receiver) > 0) {
    //             $where .= " (receiver = '$receiver') AND ";
    //         }
    //         if(strlen($project_id) > 0) {
    //             $where .= " project_id = '$project_id' AND ";
    //         }
    //         $where .= " 1=1 ";
    //     $q .= "
    //             WHERE $where
    //             ORDER BY created_at DESC
    //     ";
    //     $result = DB::select(DB::raw($q));
    //     return $result;
    // }

    // private static function buildChatList($id) {
    //     $q = "SELECT c.id,
    //                  c.project_id,
    //                  p.id as receiver_id,
    //                  p.name as receiver_name,
    //                  p.image_url as receiver_image,
    //                  MAX(c.message) as `message`,
    //                  c.created_at
    //           FROM chatting c
    //           JOIN penjahit p ON p.id = c.sender
    //         ";
    //         $where = "";
    //         if(strlen($id) > 0) {
    //             $where .= " c.receiver = '$id' AND ";
    //             $where .= " c.project_id <> 'null' AND ";
    //         }
    //         $where .= " 1=1 ";
    //     $q .= " WHERE $where
    //             GROUP BY c.project_id, p.name
    //             ORDER BY c.created_at DESC
    //         ";
    //     $result = DB::select(DB::raw($q));
    //     return $result;
    // }
}