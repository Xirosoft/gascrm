const mix = require('laravel-mix');
require('laravel-vue-lang/mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/dist/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/dist/css')
    .lang();



mix.styles([
    'public/admin-assets/css/fontawesome.min.css',
    'public/admin-assets/css/bootstrap.min.css',
    'public/admin-assets/css/animate.css.min.css',
    'public/admin-assets/libs/datetimepicker/datetimepicker.css',
    'public/admin-assets/libs/sweetalert2/sweetalert2.min.css',
    'public/admin-assets/libs/select2/select2.min.css',
    'public/admin-assets/libs/summernote/summernote-bs4.css',
    'public/admin-assets/libs/dropzone/dropzone.min.css',
    'public/admin-assets/css/style.min.css',
], 'public/dist/css/all.css');

// mix.js([
//     'public/admin-assets/libs/jquery.min.js',
//     'public/admin-assets/libs/popper.min.js',
//     'public/admin-assets/libs/bootstrap.min.js',
//     'public/admin-assets/libs/jquery-ui-sortable.js',
//     'public/admin-assets/libs/perfect-scrollbar.min.js',
//     'public/admin-assets/libs/sweetalert2/sweetalert2.all.min.js',
//     'public/admin-assets/libs/select2/select2.full.min.js',
//     'public/admin-assets/libs/dropzone/dropzone.min.js',
//     'public/admin-assets/libs/datetimepicker/datetimepicker.min.js',
//     'public/admin-assets/libs/summernote/summernote-bs4.min.js',
//     'public/admin-assets/js/custom.min.js',
// ], 'public/dist/js/all.js');
       