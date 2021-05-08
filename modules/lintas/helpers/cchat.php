<?php
namespace Lintas\helpers;
use DB;

class cchat {
    // public static function getUnread($id = null) {
    //     $q = " SELECT SQL_CALC_FOUND_ROWS c.*
    //            FROM `chatting` c ";
    //         $where = "";
    //         if(strlen($id) > 0) {
    //             $where .= "(c.sender = '{$id}' OR c.receiver = '$id') AND ";
    //         }
    //         $where .= " 1=1 ";
    //     $q .= "
    //         WHERE $where
    //         GROUP BY c.project_id
    //         ORDER BY c.id DESC
    //     ";
    //     $value = cdbutils::get_value($q);
    //     dd($value);
    //     $label_notif_chat = $value == null ? 0 : $value;
    //     $label_notif_chat = ($label_notif_chat > 100 ? '99+' : $label_notif_chat);
    //     return $label_notif_chat;
    // }

    public static function list($id = null, $project_id = null, $offset = 0, $limit = 10) {
        $sql = "SELECT SQL_CALC_FOUND_ROWS
                       c.id,
                       c.project_id,
                       c.sender,
                       c.sender_unique,
                       c.receiver,
                       c.receiver_unique,
                       c.message,
                       p.name as project_name,
                       c.created_at
                FROM `chatting` c
                JOIN (
                    SELECT id, project_id, sender, receiver, message, MAX(created_at) AS max_date
                    FROM chatting
                    GROUP BY project_id
                ) b ON c.created_at = b.max_date AND c.`project_id` = b.project_id
                INNER JOIN project p ON p.id = c.project_id
                -- c.receiver = b.receiver AND c.sender = b.sender
        ";
            $where = "";
            if(strlen($id) > 0) {
                $where .= " (c.sender = '{$id}' OR c.receiver = '{$id}')  AND ";
            } 
            if(strlen($project_id) > 0) {
                $where .= " (c.project_id = '{$project_id}')  AND ";
            }
            $where .= " 1=1 ";
        $sql .= " WHERE $where
            -- GROUP BY c.project_id
            ORDER BY c.id DESC
            -- LIMIT 1
        ";
        //if(strlen($offset) > 0 || strlen($limit) > 0) {
            //$sql .= " LIMIT $offset, $limit ";
        //}

        $data = array();
        $data['result'] = DB::select(DB::raw($sql));
        $found = DB::select(DB::raw("SELECT FOUND_ROWS() as found_rows"));
        if($found != null) {
            $found_rows = $found[0]->found_rows;
        }
        $data['found_rows'] = $found_rows;
        return $data;
    }

    // public static function getList($id = null) {
    //     if($id == null)
    //         return;

    //     $list = array();
    //     $q = "SELECT id, project_id, receiver, userid, `message`
    //           FROM chatting ";
    //     $where = " 1=1 ";
    //     if(strlen($id) > 0) {
    //         $where .= " AND (receiver = '$id' OR receiver = '$id') ";
    //     }
    //     $q .= " WHERE $where ";
    //     $result = DB::select(DB::raw($q));
    //     if($result != null) {
    //         foreach($result as $r){
    //             $list[] = array(
    //                 'project_id' => $r->project_id,
    //                 'receiver' => $r->receiver,
    //                 'user' => $r->userid,
    //                 'message' => $r->message,
    //             );
    //         }
    //     }

    //     return chtml::renderListChat($list);
    // }

}