const mix = require('laravel-mix');


mix.styles([
    'resources/css/bootstrap/bootstrap.css',
    'resources/css/bootstrap/bootstrap-grid.min.css',
    'resources/css/bootstrap/sb-admin.min.css',
    'resources/css/google/fontgoogleapi.css',
    'resources/css/google/fontgoogleapi2.css',
    'resources/css/custom/style.css',
    'resources/css/custom/admin.css',
    'resources/css/custom/slider.css',
    'resources/css/custom/blog.css',
    'resources/css/zoom/example.css',
    'resources/css/zoom/pygments.css',
    'resources/css/zoom/easyzoom.css',
    'resources/css/chosen/chosen.css',
    'resources/css/other/select2.min.css',

],'public/front/css/app.css');

mix.scripts([
    'resources/js/vendor/jquery/jquery.min.js',
    'resources/js/vendor/bootstrap/js/bootstrap.bundle.min.js',
    'resources/js/vendor/jquery-easing/jquery.easing.min.js',
    'resources/js/vendor/magnific-popup/jquery.magnific-popup.min.js',
    'resources/js/admin/sb-admin.min.js',
    'resources/js/chosen/chosen.jquery.js',
    'resources/js/chosen/chosen.proto.js',
    'resources/js/custom/prefixfree.min.js',
    'resources/js/custom/divar.js',
    'resources/js/custom/desktop.js',
    'resources/js/custom/mobile.js',
    'resources/js/custom/map.js',
    'resources/js/custom/admin.js',
    'resources/js/custom/uploadImage.js',
    'resources/js/custom/login.js',
    'resources/js/custom/blog.js',
    'resources/js/other/select2.min.js',
    'resources/js/other/sweetalert.js',

],'public/front/js/app.js');
