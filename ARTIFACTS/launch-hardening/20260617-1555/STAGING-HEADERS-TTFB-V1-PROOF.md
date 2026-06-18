# Staging Headers And TTFB Proof

Datum: 2026-06-18
Scope: staging only, no production changes.

## TTFB/cache sample

`staging-headers-ttfb-v1.json`:

- 9/9 requests returned `http_code=200`.
- Sample URLs: `/`, `/intresseanmalan/`, `/priser/`.
- `time_starttransfer` range: about `0.07s` to `0.09s`.
- Headers include `X-Varnish` and `Age`, which confirms cached staging responses in this sample.

## Header sample

Home response headers in the same artifact show:

- `X-Robots-Tag: noindex, nofollow` on staging.
- `Content-Security-Policy` present, but currently without explicit `worker-src`.
- No `Strict-Transport-Security` header on staging.

## Status

- `LH-P3-007` marked Verified for staging cache-hit TTFB.
- `LH-P2-005` remains Ready: HSTS is a production/hosting decision and should be enabled only after production HTTPS verification, conservative ramp, and rollback path.
- `LH-P2-006` remains Ready: CSP `worker-src` needs header/plugin/hosting config access; do not loosen/tighten blindly from theme JS.

## Command

```powershell
curl.exe -sS -w "time_starttransfer=%{time_starttransfer};time_total=%{time_total};http_code=%{http_code};url_effective=%{url_effective}\n" -o NUL <url>
curl.exe -sS -D - -o NUL https://staging.seniorbolaget.se/
```
