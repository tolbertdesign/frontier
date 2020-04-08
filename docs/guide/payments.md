---
title: Payments
---

## Disabling Payments

Below are the steps to disable payments across the system

### Disable Payments Trapper Keeper

#### To disable

```
hmset system_control:tk:online_payments_enabled __ci_type integer __ci_value 0
```

### To re-enable

```
del system_control:tk:online_payments_enabled
```
