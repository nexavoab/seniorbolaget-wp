# Staging Form Test V34 Proof

Date: 2026-06-19

Scope: verify staging forms and route staging test emails to `wasim.bitar@seniorbolaget.se`.

Production was not changed.

## What changed

Staging `functions.php` was updated through One.com File Manager from v32 to v34.

V34 adds:

- staging-only form recipient helper:
  - staging host: `wasim.bitar@seniorbolaget.se`
  - non-staging host: `info@seniorbolaget.se`
- backend handler for the three contact page tab forms.
- footer override on `/kontakt/` so the visible contact forms submit to the working JSON endpoint and only show success after server success.

The first v33 contact attempt reused `sb_contact_inquiry`, but staging already had another active handler for that action which returned:

`Sakerhetsverifiering misslyckades. Ladda om sidan och forsok igen.`

V34 fixes the collision by using a separate action:

`sb_contact_inquiry_v33`

## Deploy proof

Readback source:

`filemanager-functions-deploy-20260618-0925/functions-editor-after-v34-readback.php`

SHA256:

`410ec7c607c8a5b7de379093932847caa3e9f5af8aea7a41d5a6d6c269d1b861`

Browser File Manager readback matched the expected v34 text exactly:

- copied chars: `210537`
- hash match: yes
- contains `sb_contact_inquiry_v33`: yes

## Submitted tests

The following test submissions were accepted by WordPress/PHP mail on staging.

Expected recipient for staging: `wasim.bitar@seniorbolaget.se`.

At `2026-06-19 06:53 CEST`:

- `TEST Codex Intresseanmälan 2026-06-19 06:53 CEST`
  - endpoint: `seniorbolaget_wizard`
  - response: `success=true`, `Förfrågan skickad!`
- `TEST Codex Jobbansökan 2026-06-19 06:53 CEST`
  - endpoint: `sb_job_application`
  - response: `success=true`, `Ansökan skickad!`

At `2026-06-19 06:57 CEST`:

- `TEST Codex Kontakt Boka 2026-06-19 06:57 CEST`
  - endpoint: `sb_contact_inquiry_v33`
  - response: `success=true`, `Meddelande skickat!`
- `TEST Codex Kontakt Jobba 2026-06-19 06:57 CEST`
  - endpoint: `sb_contact_inquiry_v33`
  - response: `success=true`, `Meddelande skickat!`
- `TEST Codex Kontakt Allmän 2026-06-19 06:57 CEST`
  - endpoint: `sb_contact_inquiry_v33`
  - response: `success=true`, `Meddelande skickat!`

Raw result artifacts:

- `form-test-v33-results.json`
- `form-test-v34-contact-results.json`

## Cache and smoke proof

One.com Performance Cache was cleared from WordPress admin.

Post-clear smoke without cache-bypass:

- `/` -> 200, `main=1`, CSP includes `worker-src`
- `/kontakt/` -> 200, `main=1`, contains `sb_contact_inquiry_v33`, contains `seniorbolaget-contact-form-submit-fix-v33`, CSP includes `worker-src`
- `/intresseanmalan/` -> 200, `main=1`, CSP includes `worker-src`
- `/jobba-med-oss/` -> 200, `main=1`, CSP includes `worker-src`
- `/priser/` -> 200, `main=1`, CSP includes `worker-src`

Local verification:

- `node scripts\verify-conversion-a11y.mjs` -> passed
- `node scripts\verify-launch-trust.mjs` -> passed
- `git diff --check` -> no whitespace errors, CRLF warning only

## Caveat

`wp_mail()` returning success means WordPress accepted the message for sending. Final delivery still depends on mail transport and recipient inbox filtering. Confirm the five `TEST Codex` emails in `wasim.bitar@seniorbolaget.se`.

## Rollback

Fast rollback for this form patch:

1. Restore `functions-editor-after-v32-readback.php` to remove v33/v34 form routing and contact handler.
2. Or restore `functions-editor-after-v33-readback.php` to keep staging recipient routing but return to the colliding contact action state.
3. Clear One.com Performance Cache.
4. Re-run:
   - `/kontakt/` smoke
   - `seniorbolaget_wizard` test
   - `sb_job_application` test
   - contact form endpoint test
