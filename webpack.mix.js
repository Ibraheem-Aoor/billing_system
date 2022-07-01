const mix = require("laravel-mix");
const path = require('path');

mix.webpackConfig({
    resolve: {
    alias: {
        "@app": path.resolve(__dirname, "src/resources/js/app/"),
        "@core": path.resolve(__dirname, "src/resources/js/core/")
        }
    }
});
if (mix.inProduction()) {
    mix.version().options({
        // Optimize JS minification process
        terser: {
        cache: true,
        parallel: true,
        sourceMap: true
    }
});}
else {
    // Uses inline source-maps on development
    mix.webpackConfig({
    devtool: "inline-source-map",
    });
}
