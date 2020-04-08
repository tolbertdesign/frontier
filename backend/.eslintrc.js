module.exports = {
  root: true,
  parserOptions: {
    parser: 'babel-eslint',
    ecmaVersion: 2017,
  },
  env: {
    node: true,
    'jest/globals': true,
  },
  globals: {
    $: true,
    _: true,
    FB: true,
    ga: true,
    Vue: true,
    axios: true,
    Vuex: true,
    gtag: true,
    dataLayer: true,
    createComponentMocks: true,
  },
  plugins: ['jest'],
  extends: [
    'plugin:vue/recommended',
    'eslint:recommended',
    '@vue/standard',
  ],
  rules: {
    camelcase: 0,
    eqeqeq: 'off',
    indent: ['error', 2],
    'comma-dangle': ['error', 'always-multiline'],
    'dot-notation': 0,
    'no-console': process.env.NODE_ENV === 'production' ? 'error' : 'off',
    'no-debugger': process.env.NODE_ENV === 'production' ? 'error' : 'off',
    'no-extend-native': 'off',
    'no-return-assign': 'off',
    'no-unused-vars': 1,
    'vue/component-name-in-template-casing': ['error', 'PascalCase', {
      registeredComponentsOnly: true,
      ignores: [],
    }],
    'vue/html-indent': ['error', 2, {
      attribute: 1,
      closeBracket: 0,
      ignores: [],
    }],
    'vue/match-component-file-name': ['error', {
      extensions: ['jsx'],
      shouldMatchCase: false,
    }],
    'vue/max-attributes-per-line': [
      'error',
      {
        singleline: 4,
        multiline: {
          max: 1,
          allowFirstLine: false
        }
      }
    ],
    'vue/multiline-html-element-content-newline': 'off',
    'vue/no-template-shadow': 'off',
    'vue/no-unused-components': 'off',
    'vue/no-v-html': 'off',
    'vue/prop-name-casing': 'off',
    'vue/require-default-prop': 'off',
    'vue/require-prop-types': 'off',
    'vue/require-valid-default-prop': 'off',
    'vue/return-in-computed-property': 'off',
    'vue/v-bind-style': ['error', 'shorthand'],
    'vue/v-on-style': ['error', 'shorthand'],
  },
  overrides: [
    {
      files: [
        '**/*.js', '**/*.vue',
        '**/__tests__/*.{j,t}s?(x)',
        '**/tests/unit/**/*.spec.{j,t}s?(x)',
      ],
      excludedFiles: [ '*.test.js', 'public/*.js', 'vendor/**' ],
      env: {
        jest: true,
      },
    },
  ],
}
