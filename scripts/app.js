// JavaScript for the contact page: enhanced form UX + menu toggle

document.addEventListener('DOMContentLoaded', () => {
  // Enhanced contact form handling
  const contactForm = document.querySelector('.contact-form');
  if (contactForm) {
    const statusEl = contactForm.querySelector('.form-status');
    const submitButton = contactForm.querySelector('button[type="submit"]');

    // Show server-side status if redirected with query params
    try {
      const params = new URLSearchParams(window.location.search);
      if (params.get('sent') === '1' && statusEl) {
        statusEl.textContent = 'Thanks — we received your message and will reply shortly.';
      }
      if (params.get('error') === '1' && statusEl) {
        statusEl.textContent = 'Sorry — there was a problem sending your message. Please try again.';
      }
    } catch (e) {
      // ignore
    }

    contactForm.addEventListener('submit', event => {
      // If a real server action is present, allow normal form submit to backend
      const actionAttr = contactForm.getAttribute('action');
      if (actionAttr && actionAttr.trim() !== '') {
        // let the browser submit the form to the server
        if (statusEl) statusEl.textContent = 'Sending…';
        if (submitButton) submitButton.disabled = true;
        return;
      }

      // Client-side handling for static deployments (no action)
      event.preventDefault();
      if (!contactForm.checkValidity()) {
        contactForm.reportValidity();
        if (statusEl) statusEl.textContent = 'Please complete the highlighted fields.';
        return;
      }

      const formData = new FormData(contactForm);
      const payload = Object.fromEntries(formData.entries());
      if (statusEl) statusEl.textContent = 'Sending…';
      if (submitButton) submitButton.disabled = true;
      setTimeout(() => {
        if (statusEl) statusEl.textContent = 'Thanks — we received your message and will reply shortly.';
        contactForm.reset();
        if (submitButton) submitButton.disabled = false;
        console.log('Contact form submitted (simulated):', payload);
      }, 700);
    });
  }

  // Menu toggle behavior (progressive enhancement)
  const toggle = document.querySelector('.menu-toggle');
  const nav = document.querySelector('.site-nav');
  if (toggle && nav) {
    toggle.addEventListener('click', () => {
      const isOpen = nav.classList.toggle('is-open');
      toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      if (isOpen) {
        const firstLink = nav.querySelector('a');
        firstLink && firstLink.focus();
      } else {
        toggle.focus();
      }
    });
  }
});
