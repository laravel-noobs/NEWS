var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

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
    mix.sass('app.scss');
    mix.sass([
        inspinia.sass + 'style.scss',
        'style.scss'
    ], 'public/css/style.css');
});

elixir(function(mix){
   mix.styles([
       bower + 'footable/css/footable.core.css'
   ], 'public/css/plugins.css')
});

elixir(function(mix) {
    mix.scripts([
        bower + 'jquery/dist/jquery.js',
        bower + 'bootstrap-sass/assets/javascripts/bootstrap.js'
    ], 'public/js/core.js', './');

    mix.scripts([
        inspinia.js + 'inspinia.js'
    ], 'public/js/app.js', './');

    mix.scripts([
        bower + 'metisMenu/dist/metisMenu.js',
        bower + 'pace/pace.js',
        bower + 'slimscroll/jquery.slimscroll.js'
    ], 'public/js/plugins.js', './');
});

elixir(function(mix){
 mix.copy(bower + 'bootstrap-sass/assets/fonts/bootstrap/**', 'public/fonts')
     .copy(bower + 'fontawesome/fonts/**', 'public/fonts')
     .copy(bower + 'footable/css/fonts/**', 'public/fonts')
     .copy(inspinia.css + "animate.css", 'public/css')
     .copy(inspinia.img + 'patterns/**', 'public/css/patterns')
     .copy(assets.unify+'**', 'public/unify')
});
