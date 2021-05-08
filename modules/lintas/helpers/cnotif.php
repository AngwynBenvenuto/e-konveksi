<?php
namespace Lintas\helpers;
use DB;
use App\Models\Notification;
use App\Models\NotificationDetail;

class cnotif {
    // public static function getId($param = null, $key = null){
    //     $user_id = "";
    //     if($param == null)
    //         return;
    //     if($param == 'penjahit') {
    //         $user_id = CMemberLogin::get('id');
    //     } else {
    //         $user_id = CUserLogin::get('id');
    //     }
    //     return $user_id;
    // }

    public static function unread($ikm_id = null, $penjahit_id = null) {
        $q = "SELECT count(*)
              FROM `notification` n
              LEFT JOIN notification_detail nd ON nd.notification_id = n.id
            ";
            $where = "";
            if(strlen($ikm_id) > 0 && $ikm_id != null) {
                $where .= " nd.ikm_id = '{$ikm_id}'  AND ";
            } else if(strlen($penjahit_id) > 0 && $penjahit_id != null) {
                $where .= " nd.penjahit_id = '{$penjahit_id}' AND ";
            }
            $where .= " 1=1 ";
        $q .= " WHERE $where ";
        $value = cdbutils::get_value($q);
        $label_notif = $value == null ? 0 : $value;
        $label_notif = ($label_notif > 100 ? '99+' : $label_notif);
        return $label_notif;
    }

    public static function list($ikm_id = null, $penjahit_id = null, $offset = 0, $limit = 10) {
        $sql = "SELECT SQL_CALC_FOUND_ROWS n.*,
                       nd.notification_id,
                       p.id as project_id,
                       p.name as project_name,
                       nd.ikm_id,
                       nd.ikm_name,
                       nd.penjahit_id,
                       nd.penjahit_name,
                       nd.is_opened,
                       nd.type
                FROM `notification` n
                INNER JOIN notification_detail nd ON nd.notification_id = n.id
                INNER JOIN project p ON p.id = nd.project_id
        ";
            $where = "";
            $where .= "
                n.status > 0 AND
                timestamp(n.created_at) < now() AND
            ";
            if(strlen($ikm_id) > 0 && $ikm_id != null) {
                $where .= " nd.ikm_id = '{$ikm_id}'  AND ";
            } else if(strlen($penjahit_id) > 0 && $penjahit_id != null) {
                $where .= " nd.penjahit_id = '{$penjahit_id}' AND ";
            }
            $where .= " 1=1 ";
        $sql .= "
            WHERE $where
            ORDER BY n.updated_at DESC
        ";
        if(strlen($offset) > 0 || strlen($limit) > 0) {
            $sql .= " LIMIT $offset, $limit ";
        }

        $data = array();
        $data['result'] = DB::select(DB::raw($sql));
        //$data['found_rows'] = DB::select(DB::raw("SELECT FOUND_ROWS() as found_rows"))->found_rows;
        return $data;
    }

    public static function read() {

    }

    public static function create($param = null) {
        $return = '';
        if($param == null)
            return;

        $options = array(
            'name' => $param['name'],
            'description' => $param['description'],
        );
        $notif = new Notification();
        $notif->fill($options);
        $s = $notif->save();
        if($s) {
            $options_detail = array(
                'notification_id' => $notif->id,
                'type' => $param['type'],
                'transaksi_id' => $param['transaksi_id'],
                'penawaran_id' => $param['penawaran_id'],
                'project_id' => $param['project_id'],
                'ikm_id' => $param['ikm_id'],
                'ikm_name' => $param['ikm_name'],
                'penjahit_id' => $param['penjahit_id'],
                'penjahit_name' => $param['penjahit_name'],
            );
            $notif_detail = new NotificationDetail();
            $notif_detail->fill($options_detail);
            $nd_save = $notif_detail->save();
            if($nd_save) {
                $return = 1;
            }
        }
        return $return;
    }
}