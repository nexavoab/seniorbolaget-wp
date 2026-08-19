# Seniorbolaget WordPress repository agreement

The global `AGENTS.md` owns communication, safety, delegation, Git hygiene, and
completion. This file adds only WordPress-specific rules.

## Source boundary

The product source is the block theme in `wp/seniorbolaget-theme/`.
`seniorbolaget.wordpress.xml` is import content; `scraped/`, `comparison/`, and
generated images are evidence or working artifacts, not theme source.

- Preserve pattern headers and slugs. When adding or renaming city or named
  information patterns, keep the manual registrations in `functions.php` in
  sync.
- Keep the postcode feature disabled in `inc/feature-flags.php` until its price
  API dependency is implemented and explicitly approved.
- Changes around `seniorbolaget_wizard_submit` require focused review of public
  AJAX access, validation, personal data, and email delivery.
- Never add hardcoded credentials. Use environment variables or an approved
  secret store, and never copy existing credential material into evidence.

## Local verification

`bash launch-wp.sh` starts WordPress Playground on port 9400 and requires Node
20+. The separate `.wp-env.json` environment uses port 8888.

`python compare.py [slug]` writes screenshots for seven fixed routes and expects
the local site on port 8888; do not claim it tested the port-9400 path. Treat a
visual comparison as evidence only for the routes actually captured.

`seniorbolaget-theme.zip` is a distribution artifact. Update it only when the
release contract requires an archive and verify that it matches the reviewed
theme source.

## Release boundary

This repository contains no verified staging, deployment, or rollback workflow.
A local launch or screenshot is not publication proof. Stop before publishing
until the actual WordPress host, target environment, deploy method, backup, and
rollback path have been identified and authorized.
