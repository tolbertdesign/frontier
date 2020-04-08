---
title: XSS Prevention
---

## Laravel

### When displaying non-HTML user input in Blade

Use the `{{ }}` syntax to display the variable.

### When displaying HTML containing user input

Use the [HTML Purifier](https://github.com/stevebauman/purify), then display the variable using the non-escaped Blade `{!! !!}` syntax.

### When displaying user input inside of JSON

Use `json_encode` with the following options:

- `JSON_HEX_QUOT`
- `JSON_HEX_TAG`
- `JSON_HEX_AMP`
- `JSON_HEX_APOS`

## Vue.js

### When displaying non-HTML user input in Vue

Use the `{{ }}` syntax to display the variable.

### When displaying HTMLd containing user input in Vue

Make sure to use the HTML Purifier on the server side, then display the variable using the non-escaped `v-html` tag.
