const mix = require('laravel-mix');

const assets = 'src/assets';
const dist = 'dist';

mix.setPublicPath('src/assets');
mix.setResourceRoot('../');

// compile sass
mix.sass(`${assets}/css/input.scss`, `${dist}`);

// compile js
mix.js(`${assets}/js/input.js`, `${dist}`)

// Source maps when not in production.
if (!mix.inProduction()) {
    mix.sourceMaps();
}

// Hash and version files in production.
if (mix.inProduction()) {
    mix.version();
}
