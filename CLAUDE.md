# Simple Cookie Consent — CLAUDE.md

## Working Agreement

**Human = Product Owner. AI = Developer.**

- All requirements are broken into discrete features/tasks.
- Before implementing any task, the AI presents it and waits for PO approval.
- Each approved feature gets its own git branch (`feature/<slug>`), merged to `main` when complete.
- No code is written speculatively — only what has been approved.

## Workflow per task

1. AI proposes the task scope and acceptance criteria.
2. PO approves (or adjusts).
3. AI creates a `feature/<task-slug>` branch.
4. AI implements, commits, and summarizes changes.
5. PO reviews; AI merges to `main` on approval.

## Feature / Task List

Tasks are tracked in order below. Status: [ ] pending | [~] in progress | [x] done.

### Phase 0 — Project setup
- [x] CLAUDE.md: Working agreement and task list
- [x] FEAT-01: Docker dev environment (docker-compose.yml + .env.example)
- [x] FEAT-02: Plugin scaffold (main file, activator, deactivator, uninstall)

### Phase 1 — Core consent engine
- [x] FEAT-03: Cookie consent storage (JS cookie read/write + PHP reader)
- [x] FEAT-04: GTM Consent Mode v2 — default + update signals (Basic mode)
- [x] FEAT-05: GTM Advanced mode support

### Phase 2 — Banner UI
- [x] FEAT-06: Banner HTML template + CSS (position, colors, responsive)
- [x] FEAT-07: Accept All / Deny All / Preferences modal
- [x] FEAT-08: Re-open preferences via footer link

### Phase 3 — Admin settings
- [x] FEAT-09: Admin menu + General settings tab (texts, logo, legal page links)
- [x] FEAT-10: Appearance tab (position, colors, custom CSS)
- [x] FEAT-11: Jurisdiction tab (GDPR / LGPD / CCPA selector)
- [x] FEAT-12: Integrations tab (GTM toggle + mode, Site Kit info)

### Phase 4 — Cookie scanner
- [x] FEAT-13: DB table for cookies + admin cookie list UI
- [x] FEAT-14: Cookie scanner (PHP header scan + JS client scan via admin-ajax)
- [x] FEAT-15: Open Cookie Database (bundled CSV) lookup + built-in fallback list

### Phase 5 — Integrations & shortcode
- [x] FEAT-16: WP Consent Level API integration
- [x] FEAT-17: Polylang compatibility (pll_register_string)
- [x] FEAT-18: [scc_cookie_list] shortcode

### Phase 6 — Polish & release
- [x] FEAT-21: Banner & modal style review + expanded appearance settings
- [x] FEAT-19: Uninstall cleanup (drop table, delete options)
- [x] FEAT-20: readme.txt for WordPress.org

### Phase 7 — Developer experience, polish & repository health
- [x] FEAT-22: Register scc_consent cookie in DB on activation
- [x] FEAT-23: Replace preferences icon with cookie SVG
- [x] FEAT-24: Banner preview via ?scc_preview=1 URL param + admin link
- [x] FEAT-25: Admin Help tab (CSS classes, shortcodes, JS API reference)
- [x] FEAT-26: Accessibility review (focus trap, tabindex, aria-checked)
- [x] FEAT-27: README.md for developers (Docker setup, contributing, AI workflow)
- [x] FEAT-28: GitHub Actions release workflow (zip + GitHub Release on tag push)
- [x] FEAT-29: License fix (GPL v2) + CODE_OF_CONDUCT.md
- [x] FEAT-30: UX improvements — focus, button order, modal text, openBanner()
- [x] FEAT-31: i18n — PT and DE translations, POT file, load_plugin_textdomain()

## Release process

### How WordPress identifies the plugin version

WordPress reads the version from **two places** that must always be in sync:

1. **Plugin header** — `simple-cookie-consent.php`, line `Version: X.X.X`
2. **PHP constant** — `simple-cookie-consent.php`, line `define('SCC_VERSION', 'X.X.X')`

The `readme.txt` field `Stable tag: X.X.X` is only relevant if/when the plugin is submitted to WordPress.org.

### Steps to release a new version

When the PO asks for a new release (e.g. "release v1.2.0"), the AI must:

1. **Create a release branch** — `git checkout -b release/vX.X.X`
2. **Bump the version** in `simple-cookie-consent.php`:
   - `Version: X.X.X` (plugin header comment)
   - `define('SCC_VERSION', 'X.X.X')` (constant, same file)
3. **Bump `Stable tag`** in `readme.txt` to match.
4. **Commit** — message: `chore: bump version to X.X.X`
5. **Merge to `main`** — merge the release branch into `main`.
6. **Tag and push** — creates the GitHub Release automatically:
   ```bash
   git tag vX.X.X
   git push origin vX.X.X
   ```

### What happens automatically (GitHub Actions)

The `.github/workflows/release.yml` workflow triggers on `vX.X.X` tags and:
- **Validates** the tag version matches the `Version:` header — fails loudly if they don't match.
- Builds a clean zip (`simple-cookie-consent-X.X.X.zip`) excluding dev files.
- Creates a GitHub Release with the zip attached and auto-generated release notes.

### Version format

Follow [Semantic Versioning](https://semver.org/): `MAJOR.MINOR.PATCH`
- `PATCH` — bug fixes, copy changes, minor tweaks
- `MINOR` — new features, backwards-compatible
- `MAJOR` — breaking changes or major rewrites

---

## Code conventions

- PHP prefix: `scc_` on all functions, classes, hooks, options.
- JS namespace: `window.SimpleCookieConsent`
- Text domain: `simple-cookie-consent`
- Min WP: 6.0 | Min PHP: 7.4
- Use WordPress Settings API for all admin forms.
- Enqueue scripts/styles via `wp_enqueue_scripts` / `admin_enqueue_scripts`.
- No inline styles in PHP templates (use CSS files or `wp_add_inline_style`).

## Plugin identity

- Slug: `simple-cookie-consent`
- Main file: `simple-cookie-consent.php`
- GitHub: https://github.com/sergiorsmaster/simple-wp-cookie-consent
