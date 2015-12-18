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

elixir(function(mix) {

    mix.styles([
        'bootstrap.css',
        'bootstrap-theme.css',
        'selectize.bootstrap3.css',
        'style.css'
    ]);

    mix.scripts([
        'jquery-1.11.3.min.js',
        'bootstrap.js',
        'selectize.js',
        'main.js'
    ]);

    mix.version([
        'css/all.css',
        'js/all.js'
    ]);

});
