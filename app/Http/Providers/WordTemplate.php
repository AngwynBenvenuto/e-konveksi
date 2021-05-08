<?php
namespace App\Providers;

use Novay\WordTemplate\WordTemplate;

class LintasWordTemplate extends WordTemplate {
    public static $instance;
    public function __construct() {
        parent::__construct();
    }

    public static function instance() {
        if(self::$instance == null) {
            self::$instance = new LintasWordTemplate;
        }
        return self::$instance;
    }

    public function export($file = null, $replace = null, $filename = 'default.doc') {
        if(is_null($file))
            return response()->json(['error' => 'This method needs some parameters. Please check documentation.']);

        if(is_null($replace))
            return response()->json(['error' => 'This method needs some parameters. Please check documentation.']);

        $dokumen = $this->verify($file);

        foreach($replace as $key => $value) {
            $dokumen = str_replace($key, $value, $dokumen);
        }

        header("Content-type: application/vnd.ms-word");
        header("Content-disposition: attachment; filename={$filename}");
        header('Content-Length: '.strlen($dokumen));
        header('Expires: 0');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: private, no-transform, no-store, must-revalidate');
        echo $dokumen;
    }
}