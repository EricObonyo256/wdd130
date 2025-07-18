// Smooth page transition
document.addEventListener("DOMContentLoaded", () => {
  document.body.classList.remove("page-transition");
});

// Section reveal animation
const observer = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add("visible");
      observer.unobserve(entry.target);
    }
  });
}, { threshold: 0.1 });

document.querySelectorAll(".fade-in").forEach(el => observer.observe(el));

// Trip filter
document.getElementById("trip-filter").addEventListener("change", e => {
  const filter = e.target.value;
  document.querySelectorAll(".trip-card").forEach(card => {
    card.style.display = filter === "all" || card.classList.contains(filter) ? "block" : "none";
  });
});

// Testimonial carousel
let testimonialIndex = 0;
const testimonials = document.querySelectorAll(".testimonial");

setInterval(() => {
  testimonials.forEach(t => t.classList.remove("active"));
  testimonials[testimonialIndex].classList.add("active");
  testimonialIndex = (testimonialIndex + 1) % testimonials.length;
}, 4000);

// Live weather widget for Jinja (via Open-Meteo API)
async function fetchWeather() {
  try {
    const response = await fetch("https://api.open-meteo.com/v1/forecast?latitude=0.44&longitude=33.2&current_weather=true");
    const data = await response.json();
    const weather = data.current_weather;
    const weatherText = `☀️ ${weather.temperature}°C, ${weather.windspeed} km/h winds`;
    document.getElementById("weather-status").textContent = weatherText;
  } catch (error) {
    document.getElementById("weather-status").textContent = "Unable to load weather right now.";
    console.error("Weather error:", error);
  }
}

fetchWeather();