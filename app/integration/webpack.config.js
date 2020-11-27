let path = require('path');
let Encore = require('@symfony/webpack-encore');
let CopyWebpackPlugin = require('copy-webpack-plugin');
let appWeb = path.resolve(__dirname, '../symfony/public/build');

Encore
    // the project directory where all compiled assets will be stored
    .setOutputPath('../symfony/public/build/')

    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')

    // will create public/build/app.js and public/build/app.css
    .addEntry('front', './js/front/main.js')
    //.addEntry('plugins', './driveon-light/js/plugins.js')
   // .addEntry('modernizr', './driveon-light/js/vendor/modernizr-2.8.3.min.js')

    // will output as web/build/theme.min.css
 //   .addStyleEntry('main.min', './sass/main.scss')

    //.addStyleEntry('base', './css/main.css')

    // allow less files to be processed
    .enableSassLoader()

    // post css
    .enablePostCssLoader((options) => {
        options.config = {
            path: ' postcss.config.js'
        };
    })

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    // allow legacy applications to use $/jQuery as a global variable
    .autoProvidejQuery()

    // empty the outputPath dir before each build
    .cleanupOutputBeforeBuild()

    // enables hashed filenames (e.g. app.abc123.css)
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())

    // show OS notifications when builds finish/fail
    .enableBuildNotifications()

    // Copy vendor
   /* .addPlugin(
        new CopyWebpackPlugin({
            patterns: [
                // Material Design
                //{from: 'driveon-light/*', to: appWeb + '/vendors/'},
                // { context: 'node_modules', from: 'material-design-iconic-font/dist/css/*.*', to: appWeb+'/vendors/' },
                 //{ context: './driveon-light/js/vendor/js/', from: './*.js', to: appWeb+'/vendors/' },

                // Datepicker
                //   { context: 'node_modules', from: 'bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css', to: appWeb+'/vendors/bootstrap-datepicker/dist/css/' },
            ]
        })
    )*/
;

// export the final configuration
module.exports = Encore.getWebpackConfig();
