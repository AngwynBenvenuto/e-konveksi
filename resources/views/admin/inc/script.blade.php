    
<?php
    $cssArray = array();
    $jsArray = array();
    $config = config('setup.default');
    $css_default = $config['css'];
    $js_default = $config['js'];
    $config_admin = config('setup.template.admin');
    $css = $config_admin['css'];
    $js = $config_admin['js'];
    if($css_default != null && $css != null) {
        foreach($css_default as $r) {
            $url = starts_with($r, 'http') ? $r : asset($r);
            $cssArray[] = $url;
        }
        foreach($css as $rs) {
            $url_other = starts_with($rs, 'http') ? $rs : asset($rs);
            $cssArray[] = $url_other;
        }
        
        if(count($cssArray) > 0) {
            foreach($cssArray as $files) {
                $links = starts_with($files, 'http') ? $files : asset($files);
                echo "<link href='$links' rel='stylesheet' media='screen'>".PHP_EOL;
            }
        }
    }
    if($js_default != null && $js != null) {
        foreach($js_default as $r) {
            $url = starts_with($r, 'http') ? $r : asset($r);
            $jsArray[] = $url;
        }
        foreach($js as $rs) {
            $url_other = starts_with($rs, 'http') ? $rs : asset($rs);
            $jsArray[] = $url_other;
        }

        if(count($jsArray) > 0) {
            foreach($jsArray as $files) {
                $links = starts_with($files, 'http') ? $files : asset($files);
                echo "\t<script src='$links'></script>".PHP_EOL;
            }
        }
    }
?>