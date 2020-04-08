---
title: Vuelidate
description: Simple, lightweight model-based validation for Vue.js
---

## About `vuelidate`

- Simple, lightweight model-based validation for Vue.js 2.0
- Model based
- Decoupled from templates
- Dependency free, minimalistic library
- [Support for collection validations](https://vuelidate.js.org/#sub-collections-validation)
- [Support for nested models](https://vuelidate.js.org/#sub-data-nesting)
- [Contextified validators](https://vuelidate.js.org/#sub-contextified-validators)
- Easy to use with custom validators (e.g. Moment.js)
- Support for function composition
- Validates different data sources: Vuex getters, computed values, etc.
- High test coverage

## Examples

<https://vuelidate.js.org/#examples>

## Import the appropriate validators

```js
import { required, minLength, email, sameAs } from "vuelidate/lib/validators";
```

## Our custom validators
