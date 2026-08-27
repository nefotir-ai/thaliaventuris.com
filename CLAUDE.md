# thaliaventuris.com

Custom-built static site replacing the previous Namecheap Website Builder (Sitejet)
version. Five pages — `index.html`, `Growth/`, `Contacts/`, `News-and-Insights/`,
`At-a-Glance/` — sharing `assets/css/style.css` and `assets/js/main.js`. No JS
framework, no build step.

- Local preview: `npm run dev` (serves the directory on http://localhost:8080)
- The `Contacts/` page posts to `contact-handler.php`, which needs a PHP runtime
  (`mail()`) — the plain `python3 -m http.server` dev server does **not** execute
  PHP, so form submission can only be exercised with `php -S localhost:8080`
  (requires PHP installed locally) or once deployed to the cPanel host.
- Not yet deployed live — deployment plan (same pattern as `../nefotir.ai`, via
  cPanel Git Version Control) documented in README.md but intentionally not
  wired up until explicitly approved.
- Content was ported from the live Sitejet site (Aug 2026 snapshot); a handful
  of obvious typos in the original copy were corrected during the port — see
  README.md "Content notes".
- New pages must link `assets/css/style.css` (not inline `<style>`) to stay
  consistent with the shared design system. All internal links/asset paths use
  root-absolute URLs (`/Growth/`, `/assets/...`) rather than relative paths.
