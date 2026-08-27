// Thalia Venturis Partners — contact form submit handler
// Posts to /contact-handler.php via fetch, shows inline success/error status,
// and fires a GA4 "generate_lead" event on success (once analytics.js/gtag is wired up).
document.addEventListener('DOMContentLoaded', function () {
  var form = document.getElementById('contact-form');
  if (!form) return;

  var statusEl = document.getElementById('form-status');
  var submitBtn = form.querySelector('.submit-btn');

  form.addEventListener('submit', function (e) {
    e.preventDefault();

    // Honeypot check — if the hidden field got filled, silently drop it.
    var honeypot = form.querySelector('[name="company_website"]');
    if (honeypot && honeypot.value.trim() !== '') {
      return;
    }

    statusEl.className = 'form-status';
    statusEl.textContent = '';
    submitBtn.disabled = true;
    submitBtn.textContent = 'Sending…';

    fetch(form.action, {
      method: 'POST',
      body: new FormData(form),
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
      .then(function (res) { return res.json().catch(function () { return { ok: res.ok }; }); })
      .then(function (data) {
        if (data && data.ok) {
          statusEl.className = 'form-status success';
          statusEl.textContent = 'Thank you — your message has been sent. We’ll be in touch within 1–2 business days.';
          form.reset();
          if (typeof gtag === 'function') {
            gtag('event', 'generate_lead', { form_id: 'contact-form' });
          }
        } else {
          throw new Error((data && data.error) || 'Something went wrong.');
        }
      })
      .catch(function () {
        statusEl.className = 'form-status error';
        statusEl.textContent = 'Sorry, we couldn’t send your message. Please try again or email us directly.';
      })
      .finally(function () {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Submit';
      });
  });
});
