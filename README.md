# thaliaventuris.com

Custom-built static marketing site for Thalia Venturis Partners, replacing the
previous Namecheap Website Builder (Sitejet) version. Plain HTML/CSS/JS — no
framework, no build step — plus one small PHP script to handle the contact form.

## Structure

```
index.html                    Home
Growth/index.html             Growth
Contacts/index.html           Contacts (lead form)
News-and-Insights/index.html  News and Insights
At-a-Glance/index.html        At a Glance
assets/css/style.css          Shared stylesheet
assets/js/main.js             Mobile nav + footer year
assets/js/contact-form.js     Contact form fetch/validation
assets/images/                Photos, logo, favicon
contact-handler.php           Emails contact-form submissions
```

## Local preview

```bash
npm run dev
```

Then open http://localhost:8080. Note: this serves static files only — the
contact form's PHP handler won't run under it. To test the form locally,
install PHP (`brew install php`) and run `php -S localhost:8080` instead.

## Content notes

Content and images were ported from the live Sitejet site (snapshot taken
14 Aug 2026, backed up in full at `thaliaventuris/website` on GitHub). A
few obvious typos in the original copy were corrected during the port
(e.g. "Engingeering" → "Engineering", "(IRP)" → "(IPP)", "belief" → "believe").
Everything else — structure, wording, sector list, news items — was carried
over as-is. Leadership Team / Vision & Values / Corporate Responsibility in
the footer are decorative labels only in the original (no linked sub-pages),
so they're rendered the same way here.

## Contact form → email

`Contacts/index.html` posts to `contact-handler.php`, which validates the
fields and emails the lead via PHP's `mail()`. Destination address defaults
to `social@thaliaventuris.com`; override by setting the `CONTACT_TO_EMAIL`
environment variable on the host if needed.

## Deployment

Same mechanism as `../nefotir.ai`: cPanel **Git™ Version Control**, pulling
from `git@github.com:nefotir-ai/thaliaventuris.com.git` and deploying via
`.cpanel.yml` on the `thalwyas` cPanel account.

`thaliaventuris.com` is the **primary domain** on that account (unlike
nefotir.ai/nefotir.com, which are addon domains), so its live document root
is `/home/thalwyas/public_html/` directly, not a domain-named subfolder.

**Current state**: `.cpanel.yml` targets a staging subdomain
(`staging.thaliaventuris.com`, expected at
`/home/thalwyas/public_html/staging.thaliaventuris.com/` — confirm the exact
path cPanel assigns when creating it) so the site — especially the PHP
contact form — can be verified in the real hosting environment before
cutting over production.

**Production cutover** (once staging is verified): change `DEPLOYPATH` in
`.cpanel.yml` to `/home/thalwyas/public_html/` and redeploy. This replaces
the current live Namecheap Website Builder/Sitejet site immediately — do
this deliberately, not as a side effect. The full Sitejet export remains
backed up at `thaliaventuris/website` on GitHub as a rollback point.
