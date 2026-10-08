/* ============================================================
   Full Stack Developer Portfolio — script.js
   ============================================================ */

document.addEventListener('DOMContentLoaded', () => {
  initMobileMenu();
  initSmoothScroll();
  initActiveNavLink();
  initMarquee();
  initScrollReveal();
  initBackToTop();
  initContactForm();
  initYear();
});

/* ---------------------------------------------------------
   Mobile hamburger menu
--------------------------------------------------------- */
function initMobileMenu() {
  const toggle = document.getElementById('navToggle');
  const menu = document.getElementById('navMenu');
  if (!toggle || !menu) return;

  toggle.addEventListener('click', () => {
    const isOpen = menu.classList.toggle('is-open');
    toggle.classList.toggle('is-open', isOpen);
    toggle.setAttribute('aria-expanded', String(isOpen));
    toggle.setAttribute('aria-label', isOpen ? 'Close navigation menu' : 'Open navigation menu');
  });

  // Close menu after tapping a link (mobile)
  menu.querySelectorAll('.nav-link').forEach((link) => {
    link.addEventListener('click', () => {
      menu.classList.remove('is-open');
      toggle.classList.remove('is-open');
      toggle.setAttribute('aria-expanded', 'false');
    });
  });
}

/* ---------------------------------------------------------
   Smooth scrolling for internal anchor links
--------------------------------------------------------- */
function initSmoothScroll() {
  const navbar = document.getElementById('navbar');

  document.querySelectorAll('a[href^="#"]').forEach((link) => {
    link.addEventListener('click', (e) => {
      const targetId = link.getAttribute('href');
      if (!targetId || targetId === '#') return;

      const target = document.querySelector(targetId);
      if (!target) return;

      e.preventDefault();
      const offset = (navbar ? navbar.offsetHeight : 0) + 10;
      const top = target.getBoundingClientRect().top + window.pageYOffset - offset;

      window.scrollTo({ top, behavior: 'smooth' });
    });
  });
}

/* ---------------------------------------------------------
   Highlight the active nav link based on scroll position
--------------------------------------------------------- */
function initActiveNavLink() {
  const sections = document.querySelectorAll('main section[id]');
  const navLinks = document.querySelectorAll('.nav-link');
  if (!sections.length || !navLinks.length) return;

  const setActive = (id) => {
    navLinks.forEach((link) => {
      link.classList.toggle('active-link', link.getAttribute('href') === `#${id}`);
    });
  };

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          setActive(entry.target.id);
        }
      });
    },
    { rootMargin: '-45% 0px -50% 0px', threshold: 0 }
  );

  sections.forEach((section) => observer.observe(section));
}

/* ---------------------------------------------------------
   Skills marquee — infinite loop, pause on hover
   The list is duplicated once so the track can scroll -50%
   and land exactly back at the start, with no visible jump.
--------------------------------------------------------- */
function initMarquee() {
  const marquee = document.getElementById('marquee');
  const track = document.getElementById('marqueeTrack');
  const list = document.getElementById('marqueeList');
  if (!marquee || !track || !list) return;

  // Clone the list once for a seamless loop
  const clone = list.cloneNode(true);
  clone.setAttribute('aria-hidden', 'true');
  track.appendChild(clone);

  // Pause on hover (mouse) and on focus-within (keyboard)
  marquee.addEventListener('mouseenter', () => marquee.classList.add('is-paused'));
  marquee.addEventListener('mouseleave', () => marquee.classList.remove('is-paused'));
  marquee.addEventListener('focusin', () => marquee.classList.add('is-paused'));
  marquee.addEventListener('focusout', () => marquee.classList.remove('is-paused'));
}

/* ---------------------------------------------------------
   Fade-in / slide-up reveal on scroll
--------------------------------------------------------- */
function initScrollReveal() {
  const items = document.querySelectorAll('[data-animate]');
  if (!items.length) return;

  if (!('IntersectionObserver' in window)) {
    items.forEach((item) => item.classList.add('is-visible'));
    return;
  }

  const observer = new IntersectionObserver(
    (entries, obs) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          obs.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.15, rootMargin: '0px 0px -40px 0px' }
  );

  items.forEach((item) => observer.observe(item));
}

/* ---------------------------------------------------------
   Back-to-top button
--------------------------------------------------------- */
function initBackToTop() {
  const button = document.getElementById('backToTop');
  if (!button) return;

  window.addEventListener('scroll', () => {
    button.classList.toggle('is-visible', window.scrollY > 500);
  });

  button.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
}

/* ---------------------------------------------------------
   Contact form (front-end only placeholder submit handler)
--------------------------------------------------------- */
function initContactForm() {
  const form = document.getElementById('contactForm');
  const status = document.getElementById('formStatus');
  if (!form || !status) return;

  form.addEventListener('submit', (e) => {
    e.preventDefault();

    const name = form.name.value.trim();
    const email = form.email.value.trim();
    const message = form.message.value.trim();

    if (!name || !email || !message) {
      status.textContent = 'Please fill in every field before sending.';
      return;
    }

    // Placeholder behaviour — connect this to a real backend,
    // form service (e.g. Formspree) or mailto link as needed.
    status.textContent = `Thanks, ${name}! This form is a placeholder — connect it to a backend or form service to receive messages.`;
    form.reset();
  });
}

/* ---------------------------------------------------------
   Footer year
--------------------------------------------------------- */
function initYear() {
  const yearEl = document.getElementById('year');
  if (yearEl) yearEl.textContent = new Date().getFullYear();
}
