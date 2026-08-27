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

## Deployment (not yet active)

Not connected to any live hosting yet — this is local-only until explicitly
approved. When ready, the plan mirrors `../nefotir.ai`: cPanel **Git™ Version
Control**, pulling from a GitHub repo and deploying via `.cpanel.yml` into
the site's document root on the `thalwyas` cPanel account.
