const path = require('path')
const mix = require('laravel-mix')
require('laravel-mix-purgecss')

mix.options({
  hmrOptions: {
    host: 'ecosystem.test',
    port: 8080,
  },
})

// mix.browserSync({
//   proxy: 'ecosystem.test',
//   open: true,
// })

mix.sass('resources/css/app.scss', 'public/css', {
  // outputStyle: 'expanded',
}).options({
  autoprefixer: true,
  processCssUrls: false,
  postCss: [
    require('postcss-custom-properties')({
      preserve: true,
    }),
  ],
})

// mix.stylus('resources/stylus/app.styl', 'public/css', {
//   use: [require('rupture')()]
// })

// mix.stylus('resources/stylus/app.styl', 'public/css', {
//   use: [
//     require('rupture')(),
//     require('nib')(),
//     require('jeet')(),
//   ],
//   import: [
//     '~nib/index.styl',
//     '~jeet/jeet.styl',
//   ],
// })

mix.disableSuccessNotifications()

mix.sass('resources/css/auth.scss', 'public/css').options({
  postCss: [
    require('postcss-custom-properties')({
      preserve: true,
    }),
    require('tailwindcss')(),
  ],
})
// postCss without less or sass
// mix.postCss('resources/css/dashboard.pcss', 'public/css', [
//   // require('precss')(),
//   require('postcss-easy-import'),
//   require('postcss-nested'),
//   require('postcss-custom-properties'),
//   require('tailwindcss'),
//   require('autoprefixer'),
// ])
mix.sass('resources/css/dashboard.scss', 'public/css').options({
  postCss: [
    // require('precss')(),
    // require('postcss-easy-import'),
    // require('postcss-nested'),
    // require('postcss-custom-properties'),
    require('tailwindcss'),
    require('postcss-custom-properties')({
      preserve: true,
    }),
    require('autoprefixer'),
  ],
})

// mix.react('resources/js/app.jsx', 'public/js/app.js')
// mix.js('resources/js/public.js', 'public/js')
mix.js('resources/js/auth.js', 'public/js')
mix.js('resources/js/dashboard.js', 'public/js')

mix.sourceMaps()

if (mix.inProduction()) {
  mix.purgeCss({
    globs: [
      path.join(__dirname, 'node_modules/vue-croppa/src/*.vue'),
      path.join(__dirname, 'titan-common/assets/js/**/**/*.vue'),
    ],
    whitelistPatternsChildren: [
      /modal-open$/,
      /modal-backdrop$/,
      /page$/,
      /modal-background$/,
      /^slick/,
    ],
  })
  mix.version()
}

// mix.autoload({
//   jquery: ['$', 'window.jQuery']
// })

// mix.copy(from, to);
// mix.copy('from/regex/**/*.txt', to);
// mix.copy([path1, path2], to);
// mix.copyDirectory(fromDir, toDir);
// mix.copy('node_modules/vendor/acme.txt', 'public/js/acme.txt');
mix.webpackConfig(webpack => {
  return {
    resolve: {
      alias: {
        '@': path.resolve('resources/js'),
        vue$: mix.inProduction()
          ? 'vue/dist/vue.min'
          : 'vue/dist/vue.js',
      },
      // modules: [
      //     'node_modules',
      //     path.resolve(__dirname, 'vendor/laravel/spark/resources/js')
      // ]
    },

    plugins: [
      new webpack.ProvidePlugin({
        $: 'jquery',
        jQuery: 'jquery',
        'window.jQuery': 'jquery',
      }),
    ],

    stats: {
      assets: true,
      chunks: false,
      hash: false,
    },
  }
})
