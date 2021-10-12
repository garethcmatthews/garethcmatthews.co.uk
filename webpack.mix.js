const mix = require('laravel-mix');
require('laravel-mix-purgecss');

switch (process.env.npm_config_build) {
    case "development-css":
        buildDevelopmentCss(false)
        break;
    case "development-js":
        buildDevelopmentJs()
        break;
    case "production-css":
        buildProductionCss(false)
        break;
    case "production-js":
        buildProductionJs()
        break;
    default:
        console.log("ERROR - BAD CONFIGURATION");
        break;
}

function buildDevelopmentCss(purgeCss) {
    let blPurgeCss = purgeCss ?? true;
    const files = [
        { src: 'resources/assets/sass/1-mainsite/1-main.scss', dest: 'public/css/main.css' },
        { src: 'resources/assets/sass/2-modules/1-technology-module.scss', dest: 'public/css/technology.css' },
        { src: 'resources/assets/sass/2-modules/2-links-module.scss', dest: 'public/css/links.css' },
        { src: 'resources/assets/sass/2-modules/3-projects-module.scss', dest: 'public/css/projects.css' }
    ];

    for (i = 0; i < files.length; i++) {
        mix.sass(files[i].src, files[i].dest).options({
            processCssUrls: false
        }).purgeCss({
            enabled: blPurgeCss,
        });
    }
}

function buildDevelopmentJs() {
    const files = [
        { src: 'resources/assets/js/main.js', dest: 'public/js/main.js' }
    ];

    for (i = 0; i < files.length; i++) {
        mix.js(files[i].src, files[i].dest);
    }
}

function buildProductionCss(purgeCss) {
    let blPurgeCss = purgeCss ?? true;
    const files = [
        { src: 'resources/assets/sass/1-mainsite/1-main.scss', dest: 'public/css/main.css' },
        { src: 'resources/assets/sass/2-modules/1-technology-module.scss', dest: 'public/css/technology.css' },
        { src: 'resources/assets/sass/2-modules/2-links-module.scss', dest: 'public/css/links.css' },
        { src: 'resources/assets/sass/2-modules/3-projects-module.scss', dest: 'public/css/projects.css' }
    ];

    for (i = 0; i < files.length; i++) {
        mix.sass(files[i].src, files[i].dest).options({
            processCssUrls: false
        }).purgeCss({
            enabled: blPurgeCss,
        })
    }
}

function buildProductionJs() {
    const files = [
        { src: 'resources/assets/js/main.js', dest: 'public/js/main.js' }
    ];

    for (i = 0; i < files.length; i++) {
        mix.js(files[i].src, files[i].dest);
    }
}
