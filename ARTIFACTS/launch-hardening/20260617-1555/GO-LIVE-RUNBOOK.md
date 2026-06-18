# Go-Live Runbook

Date: 2026-06-18

Scope: production launch checklist for the Seniorbolaget staging hardening work.

This runbook is intentionally non-destructive. It does not authorize production changes by itself. Use it during a separate launch window after the draft PR has been reviewed and the remaining content decisions are resolved.

## Current state

- Staging is updated and verified through v32.
- Production has not been changed by this launch-hardening session.
- PR: `https://github.com/nexavoab/seniorbolaget-wp/pull/6`
- Branch: `codex/launch-hardening-20260617-1555`
- Latest commit at handoff: `a980e62 fix: harden staging launch gates`
- File Manager readback proof for staging v32:
  - `filemanager-functions-deploy-20260618-0925/functions-editor-after-v32-readback.php`
  - SHA256: `bfbaaefbe9188de25b91da12afdd8ecece2fa5c6c21ddf79dc2650bae183bbd3`

## Launch blockers before production

Resolve these before production deploy:

1. Reviews/testimonials:
   - Replace with verified real reviews, or hide the modules.
   - Do not launch public fake/example names or unverified local five-star reviews.
2. SEO:
   - Keep staging `noindex,nofollow`.
   - Remove noindex only on production at launch.
   - Set production canonical policy to production URLs.
3. Backups:
   - Take production filesystem backup or hosting snapshot.
   - Take production database backup/export.
   - Export or screenshot relevant SEO/plugin/header settings before changes.
4. Launch window:
   - Confirm correct domain/admin context before any production action.
   - Confirm rollback owner and decision maker are available.

## Recommended launch order

1. Review PR #6 and keep it draft until the two review/testimonial items are resolved.
2. Merge only after review and after the final content decision is recorded.
3. Deploy through the normal production theme/deploy path. Avoid ad hoc production File Manager edits unless there is a documented before-copy and a rollback file.
4. Clear production cache/CDN after deploy.
5. Remove production noindex/canonical staging policy only after deploy is confirmed on the production domain.
6. Enable HSTS only after HTTPS/header checks pass. Use a conservative first rollout, for example without preload.
7. Run production post-checks below.

## Production post-checks

Minimum checks immediately after launch:

- Crawl: at least sitemap top 75, all expected pages return 200, no redirect loops.
- SEO: production pages do not send `noindex,nofollow`; canonical points to production URLs.
- Runtime: no fresh console errors, failed requests, mixed content, CSP worker/blob errors, or `wp is not defined`.
- Headers: HTTPS OK, CSP includes required worker policy, HSTS present only if deliberately enabled.
- Accessibility smoke: keyboard header, mobile menu, forms, cookie modal, CTA/help panel.
- Conversion smoke: logo home link, interest form labels/GDPR label, phone/email links, contact flow.
- Content smoke: no "4.9", no public "kommer snart" image placeholders, no hemtjanst/omsorg wording, no forbidden example-review text.
- Performance lab sample: Lighthouse mobile for home, interest form, prices or guide page; compare against staging v32 proof, but do not treat lab data as field data.

## Abort rules

Abort launch and roll back if any of these occur:

- Wrong domain/admin context is detected.
- Production shows unexpected 5xx, redirect loops, broken theme rendering, or missing CSS/JS.
- Production search indexing policy is wrong and cannot be corrected quickly.
- Reviews/testimonials are still unverified but visible publicly.
- Form submission, cookie consent, or primary CTA flow is broken.
- CSP blocks critical runtime functionality.
- Rollback file/backup cannot be located.

## Fast rollback

Use `ROLLBACK.md` as the source of truth.

Fast production rollback pattern:

1. Restore the production filesystem/theme backup or revert the production deploy commit.
2. Restore pre-change SEO/header/plugin settings if they were changed.
3. Clear production cache/CDN.
4. Re-run:
   - top-page HTTP status checks
   - noindex/canonical/header checks
   - console runtime sample
   - contact/interest form smoke
5. Document rollback timestamp, reason, operator and verification result.

## Final launch evidence to save

Save these into a new dated artifact folder after production launch:

- Production crawl JSON/Markdown.
- Production header sample.
- Production console/runtime sample.
- Lighthouse lab JSON for home, interest form and one guide/prices page.
- Screenshots for 390x844 and 1280x900 on home, interest form, prices and one city page.
- Backup/snapshot identifiers.
- Review/testimonial decision evidence.
