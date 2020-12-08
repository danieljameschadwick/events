var Encore = require('@symfony/webpack-encore');

// var CopyWebpackPlugin = require('copy-webpack-plugin');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    //js entry
    .addEntry('app', './assets/js/entry_points/app.js')
    .addEntry('parsley', './assets/js/entry_points/parsley.js')
    .addEntry('calendar', ['./assets/js/entry_points/calendar.js', './assets/scss/components/calendar.scss'])
    .addEntry('events', ['./assets/js/entry_points/events.js'])

    //css entry
    .addStyleEntry('main', ['./assets/less/main.less', './assets/scss/main.scss'])
    .addStyleEntry('login', './assets/less/pages/login.less')
    .addStyleEntry('register', './assets/less/pages/register.less')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // enables @babel/preset-env polyfills
    .configureBabel(() => {}, {
        useBuiltIns: 'usage',
        corejs: 3
    })

    .enableReactPreset()

    // enables Less support
    .enableLessLoader() // todo: remove legacy styling
    // enable SASS
    .enableSassLoader(function (options) {}, {
        resolveUrlLoader: false
    })

    .enablePostCssLoader(function(options) {
        options.postcssOptions = {
            path: 'postcss.config.js',
        }
    })
;

module.exports = Encore.getWebpackConfig();
