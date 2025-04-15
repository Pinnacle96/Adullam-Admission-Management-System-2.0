document.addEventListener("DOMContentLoaded", () => {
  // Animate content in
  gsap.to("#hero-title", {
    duration: 1,
    y: 0,
    opacity: 1,
    ease: "power3.out",
    delay: 0.3,
  });
  gsap.to("#hero-sub", {
    duration: 1,
    y: 0,
    opacity: 1,
    ease: "power3.out",
    delay: 0.6,
  });

  // Background slider logic
  const slides = document.querySelectorAll("#hero-slider > div.bg-cover");
  let current = 0;

  setInterval(() => {
    slides[current].style.opacity = 0;
    current = (current + 1) % slides.length;
    slides[current].style.opacity = 1;
  }, 5000); // Change every 5 seconds
});

document.addEventListener("DOMContentLoaded", () => {
  const slides = document.querySelectorAll("#hero-slider .slide");
  let current = 0;

  setInterval(() => {
    slides[current].classList.remove("opacity-100");
    slides[current].classList.remove("active");
    slides[current].style.opacity = 0;

    current = (current + 1) % slides.length;

    slides[current].classList.add("opacity-100");
    slides[current].classList.add("active");
    slides[current].style.opacity = 1;
  }, 6000); // every 6 seconds
});

document.addEventListener("DOMContentLoaded", () => {
  const slides = document.querySelectorAll("#hero-slider .slide");
  const textSlides = document.querySelectorAll(
    "#hero-content .hero-text-slide"
  );

  let current = 0;

  const animateText = (el) => {
    const children = el.querySelectorAll("h2, p");
    children.forEach((child, i) => {
      child.classList.remove("opacity-0", "translate-y-6");
      child.style.transition = `all 0.6s ease ${i * 0.2}s`;
      child.style.opacity = 1;
      child.style.transform = "translateY(0)";
    });
  };

  const hideText = (el) => {
    const children = el.querySelectorAll("h2, p");
    children.forEach((child) => {
      child.style.opacity = 0;
      child.style.transform = "translateY(24px)";
    });
  };

  // Initial animate
  animateText(textSlides[current]);

  setInterval(() => {
    slides[current].classList.remove("active");
    slides[current].style.opacity = 0;
    textSlides[current].classList.add("hidden");
    hideText(textSlides[current]);

    current = (current + 1) % slides.length;

    slides[current].classList.add("active");
    slides[current].style.opacity = 1;
    textSlides[current].classList.remove("hidden");
    animateText(textSlides[current]);
  }, 7000);
});
/*testimonial*/
document.addEventListener("DOMContentLoaded", () => {
  const testimonials = document.querySelectorAll(".testimonial-slide");
  let t = 0;

  setInterval(() => {
    testimonials[t].classList.add("hidden");
    t = (t + 1) % testimonials.length;
    testimonials[t].classList.remove("hidden");
  }, 6000);
});
// Auto-show modal (you can trigger via button too)
window.addEventListener("DOMContentLoaded", () => {
  const modal = document.getElementById("messageModal");
  const closeBtn = document.getElementById("closeModal");

  // Delay open for better UX (optional)
  setTimeout(() => {
    modal.classList.remove("hidden");
  }, 1000);

  closeBtn.addEventListener("click", () => {
    modal.classList.add("hidden");
  });
});
// Swiper
const swiperEvents = new Swiper(".swiper-events", {
  loop: true,
  pagination: { el: ".swiper-pagination" },
  autoplay: { delay: 3500 },
});

const swiperChapel = new Swiper(".swiper-chapel", {
  loop: true,
  pagination: { el: ".swiper-pagination" },
  autoplay: { delay: 3000 },
});
new Swiper(".swiper-testimonials", {
  loop: true,
  speed: 600,
  autoplay: {
    delay: 5000,
    disableOnInteraction: false,
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  breakpoints: {
    320: {
      slidesPerView: 1,
      spaceBetween: 20,
    },
    768: {
      slidesPerView: 2,
      spaceBetween: 24,
    },
    1024: {
      slidesPerView: 3,
      spaceBetween: 32,
    },
  },
});
