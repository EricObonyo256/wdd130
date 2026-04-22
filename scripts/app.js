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
