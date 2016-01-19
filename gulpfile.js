var elixir = require('laravel-elixir');

var bower = './bower_components/';

var assets = {
 'js' : './resources/assets/js/',
 'css': './resources/assets/css/',
 'img': './resources/assets/images/',
 'unify': './resources/assets/unify/'
};

var inspinia = {
 'js': './resources/assets/inspinia/js/',
 'css': './resources/assets/inspinia/css/',
 'sass': './resources/assets/inspinia/sass/',
 'img': './resources/assets/inspinia/img/'
};

elixir(function(mix) {
    mix
        .sass([
            'core.scss',
        ], 'public/css/core.css')
        .styles([
            bower + 'footable/css/footable.core.css',
            bower + 'toastr/toastr.css',
            bower + 'select2/dist/css/select2.css',
            bower + 'eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css'
        ], 'public/css/plugins.css')
        .sass([
            inspinia.sass + 'style.scss',
            'style.scss'
        ], 'public/css/app.css')
});

elixir(function(mix) {
    mix
        .scripts([
            bower + 'jquery/dist/jquery.js',
            bower + 'bootstrap-sass/assets/javascripts/bootstrap.js'
        ], 'public/js/core.js')

        .scripts([
            bower + 'moment/moment.js',
            bower + 'moment/locale/vi.js',
            bower + 'metisMenu/dist/metisMenu.js',
            bower + 'pace/pace.js',
            bower + 'slimscroll/jquery.slimscroll.js',
            bower + 'footable/dist/footable.all.min.js',
            bower + 'toastr/toastr.js',
            bower + 'select2/dist/js/select2.full.min.js',
            bower + 'eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js'
        ], 'public/js/plugins.js')

        .scripts([
            inspinia.js + 'inspinia.js',
            inspinia.js + 'custom.js'
        ], 'public/js/app.js');
});

elixir(function(mix){
    mix
        .copy(bower + 'bootstrap-sass/assets/fonts/bootstrap/**', 'public/fonts')
        .copy(bower + 'fontawesome/fonts/**', 'public/fonts')
        .copy(bower + 'footable/css/fonts/**', 'public/fonts')
        .copy(inspinia.img + 'patterns/**', 'public/css/patterns')
        .copy(assets.unify + '**', 'public/unify')
        .copy(inspinia.js + 'editor', 'public/js/editor')
});

elixir(function (mix) {
    mix
        .version([
            'public/css/core.css',
            'public/css/plugins.css',
            'public/css/app.css',
            'public/js/core.js',
            'public/js/plugins.js',
            'public/js/app.js'
        ]);
})
