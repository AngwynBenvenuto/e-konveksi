<?php

namespace Lintas\libraries;
class CBlocks {
    protected static $data;
    protected static $file;
    protected static $instance;
    protected function __construct() {
        self::$data = array();
    }

    public static function instance() {
        if (self::$instance == null) {
            self::$instance = new CBlocks();
        }
        return self::$instance;
    }

    protected static function loadBlock($block_filename, $input_data = array()) {
        if ($block_filename == '')
            return;
        ob_start();
        $data = array_merge(self::$data, $input_data);
        extract($data, EXTR_SKIP);
        try {
            $result = view($block_filename, $data)->render();
        } catch (\Exception $e) {
            ob_end_clean();
            throw $e;
        }
        ob_get_clean();
        return $result;
    }

    public static function render($name, $data = array(), $is_render = true) {
        $instance = self::instance();
        $view = "template/blocks/$name";
        $file = $view;
        if ($file == null) {
            $file = null;
        }

        if ($file == null) {
            throw new \Exception('Block file '.$name.' not found');
        }

        $html = self::loadBlock($file, $data);
        if (!$is_render) {
            echo $html;
            $is_render = true;
        }
        return $html;
    }
}