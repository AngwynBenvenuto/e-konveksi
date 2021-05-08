<?php

return [
    'default' => array(
        'js' => array(
            'public/js/libraries/jquery-3.3.1.min.js',
            'public/js/bootstrap-4/popper.js',
            'public/js/bootstrap-4/bootstrap.min.js',
            'public/plugins/jquery-ui/jquery-ui.min.js',
            'public/plugins/summernote/summernote-bs4.min.js',
            'public/plugins/autonumeric/autonumeric.js',
            'public/plugins/datepicker/datepicker.min.js',
            'public/plugins/select2/select2.min.js',
            'public/plugins/datatables/datatables.min.js',
            'public/plugins/cropper/cropper.min.js',
            'public/plugins/ionslider/ion.rangeSlider.min.js',
            'public/plugins/pace/pace.js',
            'public/plugins/dropzone/dropzone.js',
            'public/plugins/malihu-scrollbar/jquery.mCustomScrollbar.concat.min.js',
            'public/plugins/sweetalert/sweetalert.min.js',
            'public/plugins/swiper/swiper.min.js',
            'public/plugins/fancybox/jquery.fancybox.min.js',
            'public/js/lintas.js?v='.md5(uniqid(rand(), true)),
            'public/js/konveksi.js?v='.md5(uniqid(rand(), true)),
            
        ),
        'css' => array(
            'public/css/bootstrap-4/bootstrap.min.css',
            'public/css/bootstrap-4-material/bootstrap-material.css',
            'public/plugins/jquery-ui/jquery-ui.min.css',
            'public/css/theme-material/app-material.css',
            'public/css/theme-material/colors-material.css',
            'public/css/theme-material/theme-material.css',
            'public/plugins/summernote/summernote-bs4.css',
            'public/plugins/datepicker/datepicker.min.css',
            'public/plugins/datepicker/bootstrap-datepicker.css',
            'public/plugins/datatables/datatables.min.css',
            'public/plugins/ionslider/ion.rangeSlider.min.css',
            'public/plugins/select2/select2.min.css',
            'public/plugins/cropper/cropper.min.css',
            'public/plugins/dropzone/dropzone.css',
            'public/plugins/malihu-scrollbar/jquery.mCustomScrollbar.min.css',
            'public/plugins/sweetalert/sweetalert.css',
            'public/plugins/swiper/swiper.min.css',
            'public/plugins/fancybox/jquery.fancybox.min.css',
            'public/css/libraries/lintas.css',
            
        )
    ),
    'template' => array(
        'admin' => array(
            'js' => array(
                'public/plugins/metismenu/metismenu.js',
                'public/plugins/touchspin/jquery.bootstrap-touchspin.min.js',
                'public/js/ek-admin.js?v=2',
            ),
            'css' => array(
                'public/css/theme/admin.css?v=2',
                'public/plugins/touchspin/jquery.bootstrap-touchspin.min.css',
                'public/css/ek-admin.css?v=2',
            )
        ),
        'front' => array(
            'js' => array(
                'public/js/ek.js?v='.md5(uniqid(rand(), true)),
            ),
            'css' => array(
                'public/css/ek.css?v='.md5(uniqid(rand(), true)),
            )
        )
    )
];

