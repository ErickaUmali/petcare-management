const mix = require('laravel-mix');

/*
    |--------------------------------------------------------------------------
    | Mix Asset Management
    |--------------------------------------------------------------------------
    |
    | Mix provides a clean, fluent API for defining some Webpack build steps
    | for your Laravel applications. By default, we are compiling the CSS
    | file for the application as well as bundling up all the JS files.
    |
 */

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/feedback.js', 'public/js')
    .js('resources/js/notif.js', 'public/js')
    .js('resources/js/pets/create.js', 'public/js/pets')
    .js('resources/js/client/reservations/create.js', 'public/js/client/reservations')
    .sass('resources/scss/app.scss', 'public/css')
    .sass('resources/scss/home.scss', 'public/css')
    .sass('resources/scss/templates/navbar.scss', 'public/css/templates')
    .sass('resources/scss/auth/index.scss', 'public/css/auth')
    .sass('resources/scss/auth/create.scss', 'public/css/auth')
    .sass('resources/scss/pets/index.scss', 'public/css/pets')
    .sass('resources/scss/pets/create.scss', 'public/css/pets')
    .sass('resources/scss/pets/show.scss', 'public/css/pets')
    .sass('resources/scss/client/reservations/index.scss', 'public/css/client/reservations')
    .sass('resources/scss/client/reservations/create.scss', 'public/css/client/reservations')
    .sass('resources/scss/client/reservations/show.scss', 'public/css/client/reservations')
    .sass('resources/scss/client/dashboard/index.scss', 'public/css/client/dashboard')
    .sass('resources/scss/admin/reservations/show.scss', 'public/css/admin/reservations')
    .sass('resources/scss/admin/reservations/pending.scss', 'public/css/admin/reservations')
    .sass('resources/scss/admin/reservations/completed.scss', 'public/css/admin/reservations')
    .sass('resources/scss/admin/appointments/index.scss', 'public/css/admin/appointments')
    .sass('resources/scss/admin/doctors/index.scss', 'public/css/admin/doctors')
    .sass('resources/scss/admin/staffs/index.scss', 'public/css/admin/staffs')
    .sass('resources/scss/admin/staffs/create.scss', 'public/css/admin/staffs');
