<?php
namespace Lintas\helpers;
class cobj {
    public static function get($object, $key, $default = NULL){
        return isset($object->$key) ? $object->$key : $default;
    }
}

// $id = cobj::get($user, 'id');
// StdClass {
//     "user": {
//         id: "1",
//         nama: "a"
//     }
// }