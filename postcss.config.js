const postcssPurgecss = require('@fullhuman/postcss-purgecss')

const purgecss = postcssPurgecss({
  content: ['./public/**/*.html', './src/**/*.vue'],
  defaultExtractor: content => content.match(/[\w-/:]+(?<!:)/g) || [],
  whitelistPatterns: [
    /-(leave|enter|appear)(|-(to|from|active))$/,
    /^(?!(|.*?:)cursor-move).+-move$/,
    /^router-link(|-exact)-active$/,
  ],
})

module.exports = {
  plugins: [
    require('postcss-import'),
    require('postcss-custom-properties'),
    require('tailwindcss'),
    require('autoprefixer'),
    ...(process.env.NODE_ENV === 'production' ? [purgecss] : []),
  ],
}
