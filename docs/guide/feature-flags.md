---
title: Feature Flags
categories: engineering, php, laravel
author: josh
published_at: March 31, 2020 11:44
---
## About

Feature flags are used to turn on/off features in the an application or disable/enable certain sections in the codebase. This can be done programmatically based on certain conditions or globally throughout the application. Currently, feature flags are used to prevent users from seeing new features that have been deployed, but are not currently production ready due to missing other unwritten code.

## Why Use Feature Flags

Feature flags are designed to make toggling certain features on and off for several reasons, but some of the most common reasons are listed below:

- To prevent users from interacting with currently developed code, which is especially important within a continuous deployment pipeline
- To direct users accordingly during alpha, beta, and gamma phases during feature releases
- To turn off a feature within the application that is having issues or has a bug

## How to Use Feature Flags

Feature flags in our application leverage [facades](https://laravel.com/docs/master/facades) in Laravel, allowing for seamless switching between feature flag drivers. Furthermore, there's a factory that allows creating the appropriate feature flag class as in a factory pattern.

Currently, Booster uses a custom feature flag facade, `FeatureFlag`, which can be used like any other facade in Laravel.

If you have code that needs to be hidden or displayed globally in certain situations, then you need to use the `checkIfEntityFeatureEnabled()` method, like in this example:

```php
if (FeatureFlag::checkIfEntityFeatureEnabled(FeatureName)) {
    // Code to be on/off
}
```

where the `FeatureName` is the config feature flag name.
