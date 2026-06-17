# Paket 1 Proof - Launch Trust

Datum: 2026-06-17
Branch: `codex/launch-hardening-20260617-1555`

## Scope i denna korning

Autonomt genomfort:

- `LH-P1-009` source-prep for home hero/theme/WXR SEO-title: bytte hemtjanst/hemtjanster-formulering till hushallsnara tjanster.
- Lade till `scripts/verify-launch-trust.mjs` som regression/lint for just dessa kallsignaler.

Inte genomfort utan beslut:

- `LH-P0-001`: recensioner/exempelrecensioner.
- `LH-P1-006`: ortsbilder eller "bild kommer snart".
- `LH-P1-007`: ortssidors omdomen.
- `LH-P1-008`: ortstelefon/e-post.
- `LH-P1-010`: statistikansprak.

## RED

Kommando:

```powershell
node scripts\verify-launch-trust.mjs
```

Resultat fore fix: `FAIL`.

Verifieraren hittade:

- `wp/seniorbolaget-theme/patterns/hero.php`
- `wp/seniorbolaget-theme/style.css`
- `seniorbolaget.wordpress.xml`

## GREEN

Kommando:

```powershell
node scripts\verify-launch-trust.mjs
```

Resultat efter fix: `PASS`.

Ytterligare verifiering:

```powershell
node --check scripts\verify-launch-trust.mjs
git diff --check
```

Resultat:

- `node --check`: `PASS`.
- `git diff --check`: exit 0, endast befintlig Git line-ending-varning om LF/CRLF.
- `php -l wp\seniorbolaget-theme\patterns\hero.php`: ej kort; `php` finns inte i PATH i denna miljo.

## Kvarvarande beslutskansliga traffar

Bredare scan visar fortfarande `hemtjanst`/`omsorg` i bland annat ortsbios/generator och allman copy. Dessa ar inte andrade i denna autonoma patch eftersom de kan krava copy-/faktabeslut och staging/live-verifiering.

Kommando:

```powershell
rg -n -i "hemtjänst|hemtjanst|omsorg|ledsagning|privat hemt" wp seniorbolaget.wordpress.xml generate_stad_pages.py
```

Kvarvarande klasser:

- `generate_stad_pages.py`: ortsberattelser med kommunal hemtjanst/vard och omsorg.
- `wp/seniorbolaget-theme/patterns/stad-*.php`: genererade ortsberattelser.
- `wp/seniorbolaget-theme/patterns/cta-band.php`, `hemstad-page.php`, `services-grid.php`: allman "omsorg och precision"-copy.
- `seniorbolaget.wordpress.xml`: importerad om-oss/body-copy med recensioner och "omsorg och precision".

## Rollback

Git rollback:

```powershell
git revert <package-1-commit-sha>
```

Ingen WordPress/WPCode/staging/cache/databasandring gjordes i denna korning.
