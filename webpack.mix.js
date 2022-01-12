const mix = require("laravel-mix");

if (mix == 'undefined') {
    const { mix } = require("laravel-mix");
}

require("laravel-mix-merge-manifest");

if (mix.inProduction()) {
    var publicPath = 'publishable/assets';
} else {
    var publicPath = '../../../public/themes/default/assets';
}
publicPath = 'publishable/assets';
mix.setPublicPath(publicPath).mergeManifest();
mix.disableNotifications();

mix.sass(__dirname + '/src/Resources/assets/sass/suggestion.scss', 'css/suggestion.css')
    .options({
        processCssUrls: false
    });


if (! mix.inProduction()) {
    mix.sourceMaps();
}

if (mix.inProduction()) {
    mix.version();
}