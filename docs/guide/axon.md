---
title: Axon
---
## About Axon

**Axon** attempts to standardize Booster's internal Axios calls by adding a default loading state, default error handling, and simple RESTful endpoints. **Axon** is included globally throughout the project's Vue components and can be accessed by using `vm.$axon`.

To use an existing endpoint, simply use one of the methods listed below. When using the method, you can also include a callback function to override the default loading state.

## Current Projects that Contain Axon

- Titan Dashboard

## Creating a New Endpoint

**Axon** assumes all endpoints start with `/v3/api/` and follow a RESTful pattern.

For example, in order to add an endpoint to update a user, you would need to allow a put request for `/v3/api/user/&lt;id>`.

In Laravel, that would look like the following:

```php
Route::put('/v3/api/users/<id>', 'UserController@update')
```

Now that the endpoint is created, **Axon** will be able to execute the Axios request successfully.

## Current Axon Methods

The endpoints were designed to be RESTful and to follow Eloquent's naming conventions for methods. Please keep these conventions in mind when creating new methods. Please note that `<resource>` is the table name (e.g. _users_ or _pledges_), &lt;id> is that resource's id, and &lt;item> is the object being passed to the endpoint.

```js
$axon.get('<resource>')
$axon.find('<resource>', '<id>')
$axon.create('<resource>', '<item>')
$axon.update('<resource>', '<id>', '<item>')
$axon.delete('<resource>', '<id>')
```

## Using a Custom Loading State

The default loading state can be overwritten by passing in a custom callback function like in the following examples, where `loadingFn` is the custom loading function:

```js
$axon.get('{ resource }', loadingFn)
$axon.find('{resource }', '<id>', loadingFn)
$axon.create('<resource>', <item>, loadingFn)
$axon.update('<resource>', '<id>', <item>, loadingFn)
$axon.delete('<resource>', '<id>', loadingFn)
```

## Using a Custom Error Response

The default error response can be overwritten by passing in a custom callback function like in the following examples, where `errorFn` is the custom error response and `loadingFn` is the custom loading function:

```js
$axon.get('<resource>', loadingFn, errorFn)
$axon.find('<resource>', '<id>', loadingFn, errorFn)
$axon.create('<resource>', '<item>', loadingFn, errorFn)
$axon.update('<resource>', '<id>', '<item>', loadingFn, errorFn)
$axon.delete('<resource>', '<id>', loadingFn, errorFn)
```

## Axon Methods and Request Types

```js
$axon.get(): GET Request
$axon.find(): GET Request
$axon.create(): POST Request
$axon.update(): PUT Request
$axon.delete(): DELETE Request
```

## Adding `then` and `catch` Methods

Just like with Axios, you can add `.then()` and `.catch()` methods to **Axon** calls.

```js
$axon.find('<resource>', '<id>').then('do something').catch('do something else')
```

## Mocking in Jest

When testing code that uses **Axon**, you will need to mock the **Axon** call in Jest. There currently is a default mock, which does not return any values, located in `@/axon/mocks`. After importing that into your jest test, simply mock the global `$axon` method with that imported mock in your mounted test component, like in the following example:

```js
import axonMock from '@/axon/mocks'

shallowMount(ComponentUnderTest, {
  mocks: { $axon: axonMock }
})
```
