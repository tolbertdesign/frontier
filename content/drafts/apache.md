---
title: Apache
---

## Security

In order to keep us less vulnerable, it's important that we not broadcast our
Apache Version, which could have a known exploit. The code below will prevent
Apache from displaying the version information in the response Headers. This
should be placed in the `httpd.conf` or `apache2.conf` file, depending on the
version installed.

```
ServerSignature Off
ServerTokens Prod
```
