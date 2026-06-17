# Seniorbolaget Launch Hardening - Preflight

Datum: 2026-06-17 15:55 Europe/Stockholm
Miljo: staging endast, https://staging.seniorbolaget.se
Fas: Planering och skyddsracken. Inga kod-, WordPress-, WPCode-, cache-, databas- eller produktionsandringar har gjorts.

## Worktree och branch

| Kontroll | Resultat |
| --- | --- |
| Originalrepo | `C:\Users\wasim\Documents\seniorbolaget-wordpress-dev` |
| Ursprunglig branch | `fix/p0-p1-design-cleanup-20260615-212150` |
| Ursprungligt arbetstrad | Rent vid `git status --short --branch` |
| Remote | `origin https://github.com/nexavoab/seniorbolaget-wp.git` |
| Remote default branch | `origin/main` enligt `git remote show origin` |
| Basval | `origin/main`, eftersom remote HEAD pekar pa `main` |
| Baseline SHA | `ec77a08efdea5f44b58720beeb32e577814a8ec3` |
| Ny branch | `codex/launch-hardening-20260617-1555` |
| Worktree | `C:\Users\wasim\.config\superpowers\worktrees\seniorbolaget-wordpress-dev\launch-hardening-20260617-1555` |
| Upstream | `origin/main` |
| Worktree status | Rent efter skapande |

## Kommandon som kordes

```powershell
git status --short --branch
git remote -v
git remote show origin
git fetch origin --prune
git worktree add C:\Users\wasim\.config\superpowers\worktrees\seniorbolaget-wordpress-dev\launch-hardening-20260617-1555 -b codex/launch-hardening-20260617-1555 origin/main
git status --short --branch
git rev-parse HEAD
```

## Senaste relevanta commits vid preflight

```text
ec77a08 (origin/main, origin/HEAD) Merge pull request #4 from nexavoab/codex/design-cleanup-source-20260617
14a82c6 fix: permanentize full visual hotfix
f944054 fix: add design cleanup to theme source
e345187 (origin/codex/logo-home-link-20260617, codex/logo-home-link-20260617) fix: normalize foretag trust band
96b01d2 fix: link logo to homepage
```

Notering: `origin/codex/logo-home-link-20260617` finns redan och verkar innehalla logo-lank-fix, men denna fas baseras pa `origin/main` enligt remote default. Inget cherry-pick eller merge har gjorts.

## Kallor som lastes

| Kalla | Status |
| --- | --- |
| `C:\Users\wasim\Documents\seniorbolaget-wordpress-dev\ARTIFACTS\design-audit\2026-06-17T10-01-35-357Z\audit-report.md` | Last |
| `C:\Users\wasim\Documents\seniorbolaget-wordpress-dev\ARTIFACTS\design-audit\2026-06-17T10-01-35-357Z\lighthouse-summary.json` | Last |
| `C:\Users\wasim\Documents\seniorbolaget-wordpress-dev\ARTIFACTS\design-audit\2026-06-17T10-01-35-357Z\runtime-technical-sample.json` | Last |
| `C:\Users\wasim\Documents\seniorbolaget-wordpress-dev\ARTIFACTS\design-audit\2026-06-17T10-01-35-357Z\technical-headers-browser.json` | Last |
| `C:\Users\wasim\Documents\seniorbolaget-wordpress-dev\ARTIFACTS\claude-independent-audit\20260617-130003\audit-report.md` | Last |
| `C:\Users\wasim\Documents\seniorbolaget-wordpress-dev\ARTIFACTS\claude-independent-audit\20260617-130003\jamforelse.md` | Last |
| `C:\Users\wasim\Documents\seniorbolaget-wordpress-dev\ARTIFACTS\claude-independent-audit\20260617-130003\evidence\01-teknisk-status-headers.md` | Last |
| `C:\Users\wasim\Documents\seniorbolaget-wordpress-dev\ARTIFACTS\claude-independent-audit\20260617-130003\evidence\02-matdata.md` | Last |
| `C:\Users\wasim\Documents\seniorbolaget-wordpress-dev\PROOFS.md` | Last fran originalcheckout; saknas pa `origin/main` worktree |
| `C:\Users\wasim\Documents\seniorbolaget-wordpress-dev\HOTFIX-READY.md` | Last fran originalcheckout; saknas pa `origin/main` worktree |
| `CLAUDE.md` i worktree | Last |

## Ramverkskallor for quality gates

- WCAG 2.2: https://www.w3.org/TR/WCAG22/
- W3C/WAI Easy Checks: https://www.w3.org/WAI/test-evaluate/preliminary/
- NN/g 10 usability heuristics: https://www.nngroup.com/articles/ten-usability-heuristics/
- Google Core Web Vitals: https://developers.google.com/search/docs/appearance/core-web-vitals
- Google SEO Starter Guide: https://developers.google.com/search/docs/fundamentals/seo-starter-guide
- OWASP WSTG: https://owasp.org/www-project-web-security-testing-guide/
- WordPress Theme Handbook: https://developer.wordpress.org/themes/
- WordPress revisions: https://wordpress.org/documentation/article/revisions/
- WordPress backups: https://developer.wordpress.org/advanced-administration/security/backup/

## Baseline setup/test

- `package.json` saknas i repo-roten och i `wp\seniorbolaget-theme`.
- Ingen Node-testharness installerades i fas 1.
- Ingen lokal WordPress/Docker-start gjordes i fas 1.
- Baseline for fas 1 ar git/remote/worktree-renhet samt befintliga auditbevis, inte en ny verifieringskorsning.

## Skyddsracken

- Inga produktionsandringar.
- Inga staging-admin/WPCode/content-andringar.
- Inga destruktiva DB-andringar.
- Alla framtida WPCode/content-andringar maste ha fore-kopia, rollbackvag och bevis innan de utforas.
- Live staging ar sanningen for UX/design/verifiering, men fas 1 anvander befintliga live-auditbevis och gor inga nya sajtingrepp.

