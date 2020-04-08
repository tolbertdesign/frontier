---
title: Google Analytics
---

## Event Tracking

Here is the reference [article](https://developers.google.com/analytics/devguides/collection/analyticsjs/events)

Going forward when using google analytics to track various custom events in the application. Call the following function passing the appropriate variables.

this is all detailed in the article referenced above

```js
ga('send', 'event', 'category', 'action', 'custom_label', 'value');
```
