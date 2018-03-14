const { mix } = require('laravel-mix');
const purgeCss = require('purgecss-webpack-plugin');
const glob = require('glob');

mix.js('js/app.js', './')
    .sass('sass/style.scss', './');

mix.options({
    postCss: [
        require('autoprefixer')({
            grid: true,
            browsers: ['last 2 versions', 'IE 9', 'Safari 9']
        })
    ]
});

if (mix.inProduction()) {
    mix.webpackConfig({
        plugins: [
            new purgeCss({
                paths: glob.sync([
                    path.join(__dirname, 'template-parts/**/*.php'),
                    path.join(__dirname, 'js/**/*.vue')
                ]),
                extractors: [
                    {
                        extractor: class {
                            static extract(content) {
                                return content.match(/[A-z0-9-:\/]+/g)
                            }
                        },
                        extensions: ['html', 'js', 'php', 'vue']
                    }
                ]
            })
        ]
    })
}