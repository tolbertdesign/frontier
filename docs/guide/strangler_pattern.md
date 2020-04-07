---
title: Strangler Pattern
---

Strangulation of a legacy or undesirable solution is a safe way
to phase one thing out for something better, cheaper, or more
expandable. You make something new that obsoletes a small
percentage of something old, and put them live together.

https://martinfowler.com/bliki/StranglerFigApplication.html

## Why use it

We have several production "legacy" apps that are in an older version of Laravel with varying degrees of quality given our understanding of Laravel or use of a "great best practices".

**We needed a way to gradually move the apps over to the newest Laravel while still keeping the apps working.**

We decided to **absorb the old app into a fresh install**, and slowly replace the code and routes with fresh, modern code, when possible.

This is also a **great method for taking over an existing Laravel application developed by a different group where you are not familiar with the codebase**. You can slowly rework the code into a format that is more inline with your team's preferences.

## Lifting vs. Shifting

If you are very happy with your codebase, then I would just shift your codebase into the new version of Laravel, and not go through this process. If you are looking for an opportunity to do some major refactoring &amp; cleanup, then lifting may be a better solution for you.

- [Laravel tests generator](https://laravelshift.com/laravel-test-generator)
It generates factories and tests for your code if it's on Laravel 5.8 or higher.
