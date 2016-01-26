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
}

elixir(function(mix) {
    mix
        .sass([
            'core.scss',
            inspinia.css + 'animate.css'
        ], 'public/css/core.css')

        .styles([
            bower + 'footable/css/footable.core.css',
            bower + 'toastr/toastr.css'
        ], 'public/css/plugins.css')

        .sass([
            inspinia.sass + 'style.scss',
            'style.scss'
        ], 'public/css/app.css');
});

elixir(function(mix) {
    mix
        .scripts([
            bower + 'jquery/dist/jquery.js',
            bower + 'bootstrap-sass/assets/javascripts/bootstrap.js'
        ], 'public/js/core.js')

        .scripts([
            bower + 'metisMenu/dist/metisMenu.js',
            bower + 'pace/pace.js',
            bower + 'slimscroll/jquery.slimscroll.js',
            bower + 'footable/dist/footable.all.min.js',
            bower + 'toastr/toastr.js'
        ], 'public/js/plugins.js', './')

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
        .copy(assets.img  + '**', 'public/images')
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