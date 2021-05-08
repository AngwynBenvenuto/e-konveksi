<?php 
namespace Lintas\helpers;
use DB;
class cdbutils {
    public static function get_value($query) {
        $result = DB::select(DB::raw($query));
        $res = array();
        $value = null;
        foreach ($result as $row) {
            foreach ($row as $k => $v) {
                $value = $v;
                break;
            }
            break;
        }
        return $value;
    }

    public static function get_row($query) {
        $r = DB::select(DB::raw($query));
        $result = null;
        if (count($r) > 0) {
            $result = $r[0];
        }
        return $result;
    }

    public static function get_array($query) {
        $r = DB::select(DB::raw($query));
        $result = ($r == null ? null : $r);
        if($result == null)
            return;

        $res = array();
        foreach ($result as $row) {
            $cnt = 0;
            $arr_val = "";
            foreach ($row as $k => $v) {
                if ($cnt == 0)
                    $arr_val = $v;
                $cnt++;
                if ($cnt > 0)
                    break;
            }
            $res[] = $arr_val;
        }
        return $res;
    }


}