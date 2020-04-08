---
title: CodeIgniter
---

## Manual Changes to CodeIgniter Core

3.1.11

- Database changes for Read Write servers being different
- Redis cache driver is actually on 3.1-stable (somewhere between 3.1.11 and 3.1.12 which isn't out yet) to accomodate for php redis on our server being so new.
- Form generator has been manually edited to include `class="form-control"` in multiple locations to persist styling of bootstrap. (this could be removed if all spots in the code that use this generator are changed
