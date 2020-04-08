---
title: Vuelidate
---

## Install plugin

```sh
yarn add vuelidate
```

## Create <code>@/plugins/vuelidate.js</code> and add the following

```js
import Vue from 'vue'
import Vuelidate from 'vuelidate'

Vue.use(Vuelidate)
```

## Import the appropriate validators in your component

```js
import { required, minLength, email, sameAs } from "vuelidate/lib/validators";
```
