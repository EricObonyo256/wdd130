// JavaScript for the WWR contact page

document.addEventListener('DOMContentLoaded', () => {
  const contactForm = document.querySelector('.contact-form');

  if (!contactForm) {
    return;
  }

  contactForm.addEventListener('submit', event => {
    event.preventDefault();
    alert('Thank you! Your message has been sent.');
    contactForm.reset();
  });
});

// Menu toggle behavior (progressive enhancement)
document.addEventListener('DOMContentLoaded', () => {
  const toggle = document.querySelector('.menu-toggle');
  const nav = document.querySelector('.site-nav');
  if (!toggle || !nav) return;

  toggle.addEventListener('click', () => {
    const isOpen = nav.classList.toggle('is-open');
    toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    if (isOpen) {
      // move focus into first link for keyboard users
      const firstLink = nav.querySelector('a');
      firstLink && firstLink.focus();
    } else {
      toggle.focus();
    }
  });
});
