// Carousel Logic
let index = 0;
const testimonials = document.querySelectorAll(".testimonial");
setInterval(() => {
  testimonials[index].classList.remove("active");
  index = (index + 1) % testimonials.length;
  testimonials[index].classList.add("active");
}, 4000);

// FAQ Accordion Logic
document.querySelectorAll(".accordion-toggle").forEach(btn => {
  btn.addEventListener("click", () => {
    const content = btn.nextElementSibling;
    content.style.display = content.style.display === "block" ? "none" : "block";
  });
});

// Trip Filter
document.getElementById("trip-filter").addEventListener("change", function () {
  const value = this.value;
  document.querySelectorAll(".trip-card").forEach(card => {
    card.style.display = (value === "all" || card.classList.contains(value)) ? "block" : "none";
  });
});