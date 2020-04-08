module.exports = {
  root: true,
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
    Skycons: true,
    places: true,
  },
  plugins: ['jest'],
  extends: [
    'plugin:vue/recommended',
    'eslint:recommended',
    // https://github.com/standard/standard/blob/master/RULES.md
    '@vue/standard',
  ],
  rules: {
    camelcase: 0,
    eqeqeq: 'off',
    indent: ['error', 2],
    'dot-notation': 0,
    'comma-dangle': ['error', 'always-multiline'],
    'no-console': process.env.NODE_ENV === 'production' ? 'error' : 'off',
    'no-debugger': process.env.NODE_ENV === 'production' ? 'error' : 'off',
    'no-extend-native': 'off',
    'no-return-assign': 'off',
    'no-unused-vars': 1,
    'no-new': 0,
    'prefer-promise-reject-errors': 0,
    'import/order': 'error',
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
    // 'vue/max-attributes-per-line': 'off',
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
    'vue/require-default-prop': 'off',
    'vue/require-prop-types': 'off',
    'vue/require-valid-default-prop': 'off',
    'vue/return-in-computed-property': 'off',
    'vue/v-bind-style': ['error', 'shorthand'],
    'vue/v-on-style': ['error', 'shorthand'],
    'vue/array-bracket-spacing': 'error',
    'vue/arrow-spacing': 'error',
    'vue/block-spacing': 'error',
    'vue/brace-style': 'error',
    'vue/camelcase': 'error',
    'vue/comma-dangle': ['error', 'always-multiline'],
    'vue/dot-location': ['error', 'property'],
    'vue/eqeqeq': 'error',
    'vue/key-spacing': 'error',
    'vue/keyword-spacing': 'error',
    'vue/no-boolean-default': ['error', 'default-false'],
    'vue/no-deprecated-scope-attribute': 'error',
    'vue/no-empty-pattern': 'error',
    'vue/object-curly-spacing': ['error', 'always'],
    'vue/padding-line-between-blocks': 'error',
    'vue/space-infix-ops': 'error',
    'vue/space-unary-ops': 'error',
    'vue/v-on-function-call': 'error',
    'vue/v-slot-style': [
      'error',
      {
        atComponent: 'v-slot',
        default: 'v-slot',
        named: 'longform',
      },
    ],
    'vue/valid-v-slot': 'error',
  },
  parserOptions: {
    parser: 'babel-eslint',
  },
  overrides: [
    {
      files: [
        '**/__tests__/*.{j,t}s?(x)',
        '**/tests/unit/**/*.spec.{j,t}s?(x)',
      ],
      env: {
        jest: true,
      },
    },
  ],
}
