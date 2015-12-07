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
    'unify': './resources/assets/unify/'
};
elixir(function(mix) {
    mix.sass('app.scss');
});

elixir(function(mix) {
    mix.scripts([
        bower + 'jquery/dist/jquery.js',
        bower + 'bootstrap-sass/assets/javascripts/bootstrap.js'
    ], 'public/js/core.js', './');

   // mix.scripts([], 'public/js/app.js', './');

   // mix.scripts([], 'public/js/plugins.js', './');
});

elixir(function(mix){
    mix.copy(bower + 'bootstrap-sass/assets/fonts/bootstrap/**', 'public/fonts')
        .copy(bower + 'fontawesome/fonts/**', 'public/fonts')
        .copy(assets.unify+'**', 'public/unify')
});
