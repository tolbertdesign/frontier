---
title: Amazon Web Services
---

### Route 53 Health Checks

:::warning Important
If you block access to health checking IP addresses, Route53 health checks consider your resources to be unhealthy.
:::

Route53 health checks can originate from any IP address in the following ranges. Over a short time, you might see that health check requests come from just a few IP addresses in an AWS region. However, those IP addresses can change at any time to other IP addresses for the same AWS region.

#### Existing Ranges

```
15.177.0.0/18
54.245.168.0/26
54.243.31.192/26
177.71.207.128/26
54.255.254.192/26
54.244.52.192/26
176.34.159.192/26
54.251.31.128/26
54.183.255.128/26
54.241.32.64/26
54.252.254.192/26
107.23.255.0/26
54.248.220.0/26
54.228.16.0/26
54.250.253.192/26
54.232.40.64/26
54.252.79.128/26
```

For reference, Route 53 health checks use the following IPv6 ranges.

```
2600:1f1c:7ff:f800::/53
2a05:d018:fff:f800::/53
2600:1f1e:7ff:f800::/53
2600:1f1c:fff:f800::/53
2600:1f18:3fff:f800::/53
2600:1f14:7ff:f800::/53
2600:1f14:fff:f800::/53
2406:da14:7ff:f800::/53
2406:da14:fff:f800::/53
2406:da18:7ff:f800::/53
2406:da1c:7ff:f800::/53
2406:da1c:fff:f800::/53
2406:da18:fff:f800::/53
2600:1f18:7fff:f800::/53
2a05:d018:7ff:f800::/53
2600:1f1e:fff:f800::/53
2620:107:300f::36b7:ff80/122
2a01:578:3::36e4:1000/122
2804:800:ff00::36e8:2840/122
2620:107:300f::36f1:2040/122
2406:da00:ff00::36f3:1fc0/122
2620:108:700f::36f4:34c0/122
2620:108:700f::36f5:a800/122
2400:6700:ff00::36f8:dc00/122
2400:6700:ff00::36fa:fdc0/122
2400:6500:ff00::36fb:1f80/122
2403:b300:ff00::36fc:4f80/122
2403:b300:ff00::36fc:fec0/122
2400:6500:ff00::36ff:fec0/122
2406:da00:ff00::6b17:ff00/122
2a01:578:3::b022:9fc0/122
2804:800:ff00::b147:cf80/122
```
