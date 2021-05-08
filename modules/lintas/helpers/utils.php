<?php
namespace Lintas\helpers;
// use Illuminate\Support\Arr;
// use Lintas\helpers\cdbutils;

class utils {
    // public static function generateCode() {
    //     $s = uniqid();
    //     return strtoupper(base_convert($s, 16, 36));
    // }

    public static function generateUnique($param = '', $char = '', $field = null, $table = '') {
        if($field == null) {
            $field = 'code';
        }

        $char_length = strlen($char) == 3 ? '7' : '6';
        $noUrut = null;
        $q = "SELECT max({$field}) as maxCode FROM $table WHERE {$field} LIKE '$char%'";
        $data = cdbutils::get_value($q);
        if($data == null) {
            $noUrut = 1;
        } else {
            $noUrut = (int) substr($data, $char_length, 4);
            $noUrut++;
        }
        $newKode = $char.date('m').substr(date('Y'),2,2).sprintf("%04s", $noUrut);
        return $newKode;
    }

    public static function generateOtpCode() {
        $digits = 4;
        $res = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
        return $res;
    }

    // public static function gen_code($id) {
    //     $res = bcadd(bcpow(36, 7), bcmod(bcmul($id, 2521109907419), bcsub(bcpow(36, 8), bcpow(36, 7))));
    //     $res = strtoupper(base_convert($res, 10, 36));
    //     return $res;
    // }

    // public static function generateOfferCode($id) {
    //     return self::gen_code($id);
    // }
    public static function generateInvoice($id = null) {
        return self::generateUnique(null, 'INV', 'order_invoice', 'delivery');
    }
    public static function generateProjectUnique($param = null) {
       return self::generateUnique(null, 'PR', null, 'project');
    }
    public static function generateOffer($id = null) {
        return self::generateUnique(null, 'OF', null, 'offers');
    }
    public static function generateTransaction($id = null) {
        return self::generateUnique(null, 'TR', null, 'transaction');
    }
    public static function generateIkm($id = null) {
        return self::generateUnique(null, 'IKM', null, 'ikm');
    }
    public static function generatePenjahit($id = null) {
        return self::generateUnique(null, 'PJ', null, 'penjahit');
    }

    // public static function generateTransactionCode($id) {
    //     return self::gen_code($id);
    // }

    // public static function generateTransferCode($id) {
    //     return self::gen_code($id);
    // }

    // public static function generateMemberCode($id) {
    //     $res = bcadd(bcpow(36, 7), bcmod(bcmul($id, 2521109907419), bcsub(bcpow(36, 8), bcpow(36, 7))));
    //     $res = strtoupper(base_convert($res, 10, 36));
    //     return $res;
    // }

    public static function generateQrCode($code, $type = 'project') {
        $url = "https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl=".$type."_".$code."&choe=UTF-8&chld=L|2";
        return $url;
    }

    public static function generateUrl($phrase, $maxLength = 10) {
        $result = strtolower($phrase);
        $result = preg_replace("/[^a-z0-9\s-]/", "", $result);
        $result = trim(preg_replace("/[\s-]+/", " ", $result));
        $result = trim(substr($result, 0, $maxLength));
        $result = preg_replace("/\s/", "-", $result);

        return $result;
    }

    // public static function formatPhoneIndo($phone = '') {
    //     $number = '';
    //     $phone = str_replace(" ", "", $phone);
    //     $phone = str_replace("(", "", $phone);
    //     $phone = str_replace(")", "", $phone);
    //     $phone = str_replace(".", "", $phone);
    //     if (!preg_match('/[^+0-9]/', trim($phone))) {
    //         if (substr(trim($phone), 0, 3) == '+62') {
    //             $number = trim($phone);
    //         } elseif (substr(trim($phone), 0, 1) == '0') {
    //             $number = '+62' . substr(trim($phone), 1);
    //         }
    //     }
    //     return $number;
    // }

    // public static function unformatPhoneIndo($phone = '') {
    //     $number = '';
    //     $number = substr_replace($phone, '0', 0, 3);
    //     return $number;
    // }

    // public static function removeZeroPhone($phone = '') {
    //     $number = '';
    //     $phone = str_replace(" ", "", $phone);
    //     $phone = str_replace("(", "", $phone);
    //     $phone = str_replace(")", "", $phone);
    //     $phone = str_replace(".", "", $phone);
    //     if (!preg_match('/[^+0-9]/', trim($phone))) {
    //         if (substr(trim($phone), 0, 1) == '0') {
    //             $number = '' . substr(trim($phone), 1);
    //         } else {
    //             $number = trim($phone);
    //         }
    //     }

    //     return $number;
    // }

    public static function formatCurrency($val) {
        if (!$val) {
            $val = 0;
        }
        return str_replace('.00', '', number_format($val, 2));
    }

    public static function unformatCurrency($number, $force_number = true, $dec_point = '.', $thousands_sep = ',') {
        if ($force_number) {
            $number = preg_replace('/^[^\d]+/', '', $number);
        } else if (preg_match('/^[^\d]+/', $number)) {
            return false;
        }

        $type = (strpos($number, $dec_point) === false) ? 'int' : 'float';
        $number = str_replace(array($dec_point, $thousands_sep), array('.', ''), $number);
        settype($number, $type);
        return $number;
    }

    public static function formatDate($date = null) {
        if ($date == null) {
            $date = date('Y-m-d');
        }
        return date('Y-m-d', strtotime($date));
    }

    public static function formatTime($time = null) {
        if ($time == null) {
            $time = date('H:i');
        }
        return date('H:i', strtotime($time));
    }

    // public static function urlExist($url = null){
    //     $ch = curl_init($url);
    //     curl_setopt($ch, CURLOPT_HEADER, true);
    //     curl_setopt($ch, CURLOPT_NOBODY, true);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_exec($ch);
    //     if(curl_errno($ch)){
    //         curl_close($ch);
    //         return false;
    //     }
    //     $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    //     curl_close($ch);
    //     return $code == 200 ? true : false;
    // }


    // public static function getSession($credential = null) {
    //     if($credential == null)
    //         return;
    //     $data = array();
    //     $data['id'] = $credential->id;
    //     $data['name'] = $credential->name;
    //     $data['name_display'] = $credential->name_display;
    //     $data['birthdate'] = $credential->birthdate;
    //     $data['phone'] = $credential->phone;
    //     $data['email'] = $credential->email;
    //     $data['image_url'] = $credential->image_url;
    //     $data['gender'] = $credential->gender;
    //     return $data;
    // }

    //generate ikm
    // public static function getIkm($project_id = '', $key) {
    //     $q = "
    //           SELECT p.id as project_id, p.name as project_name,
    //                  i.id as ikm_id, i.name as ikm_name,
    //                  p.code as project_code
    //           FROM project p
    //           LEFT JOIN ikm i ON p.ikm_id = i.id
    //           WHERE p.id = '{$project_id}'
    //         ";
    //     $value = cdbutils::get_array($q);
    //     return Arr::get($value, $key);
    // }

// get ukuran dan gambar detail penawaran
    public static function get_ukuran($project_id=null)
    {
        $q = "
            SELECT u.name, pu.qty
            FROM project p
            JOIN project_ukuran pu ON pu.project_id=p.id
            JOIN ukuran u ON u.id=pu.ukuran_id
            WHERE p.id = '{$project_id}'
        ";
        $value = \DB::select(\DB::raw($q));
        return $value;
    }
    public static function get_image($project_id=null)
    {
        $q = "
            SELECT pi.image_name, pi.image_url
            FROM project p
            JOIN project_image pi ON pi.project_id=p.id
            WHERE p.id = '{$project_id}'
        ";
        $value = \DB::select(\DB::raw($q));
        return $value;
    }
    public static function setInterval($f, $milliseconds)
    {
        $seconds=(int)$milliseconds/1000;
        while(true)
        {
            $f();
            sleep($seconds);
        }
    }
}