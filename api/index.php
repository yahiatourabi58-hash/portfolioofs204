<?php
declare(strict_types=1);

$formStatus = '';
$formStatusType = '';
$nameValue = '';
$emailValue = '';
$messageValue = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_submit'])) {
    $nameValue = trim((string)($_POST['name'] ?? ''));
    $emailValue = trim((string)($_POST['email'] ?? ''));
    $messageValue = trim((string)($_POST['message'] ?? ''));

    if ($nameValue === '' || $emailValue === '' || $messageValue === '') {
        $formStatus = 'Please fill in every field before sending.';
        $formStatusType = 'error';
    } elseif (!filter_var($emailValue, FILTER_VALIDATE_EMAIL)) {
        $formStatus = 'Please enter a valid email address.';
        $formStatusType = 'error';
    } else {
        $recipient = 'yahyatourabi627@gmail.com';
        $subject = 'Portfolio contact message from ' . $nameValue;
        $safeReplyEmail = str_replace(["\r", "\n"], '', $emailValue);
        $safeName = str_replace(["\r", "\n"], '', $nameValue);
        $body = "Name: {$safeName}\nEmail: {$safeReplyEmail}\n\nMessage:\n{$messageValue}";
        $headers = "From: Portfolio Contact <no-reply@" . ($_SERVER['HTTP_HOST'] ?? 'localhost') . ">\r\n";
        $headers .= "Reply-To: {$safeReplyEmail}\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        if (function_exists('mail') && @mail($recipient, $subject, $body, $headers)) {
            $formStatus = 'Thank you! Your message has been sent.';
            $formStatusType = 'success';
            $nameValue = $emailValue = $messageValue = '';
        } else {
            $formStatus = 'The form was received, but email delivery is not configured on this server. Please contact me using the email link.';
            $formStatusType = 'error';
        }
    }
}
?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Yahya Tourabi — Full Stack Developer Portfolio</title>

<meta name="description" content="Portfolio of Yahya Tourabi, a Full Stack Developer building clean, reliable web applications with modern JavaScript, Python and Laravel.">

<link rel="preconnect" href="https://fonts.googleapis.com">

<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

<style>
/* ============================================================

   Full Stack Developer Portfolio — style.css

   ============================================================ */



:root {

  /* Colors */

  --color-bg: #090c12;

  --color-bg-alt: #0e131c;

  --color-surface: #131a26;

  --color-border: rgba(255, 255, 255, 0.08);

  --color-border-strong: rgba(255, 255, 255, 0.14);



  --color-blue: #3b82f6;

  --color-blue-dim: #1d4ed8;

  --color-orange: #f97316;

  --color-orange-dim: #c2560c;



  --color-text: #e7ebf1;

  --color-text-muted: #93a0b4;

  --color-text-faint: #5c6a80;



  /* Type */

  --font-display: 'Space Grotesk', 'Segoe UI', sans-serif;

  --font-body: 'Inter', 'Segoe UI', sans-serif;



  /* Layout */

  --max-width: 1160px;

  --radius-sm: 8px;

  --radius-md: 14px;

  --radius-lg: 22px;



  /* Motion */

  --ease: cubic-bezier(0.22, 1, 0.36, 1);

  --dur-fast: 180ms;

  --dur-med: 420ms;

}



/* ---------- Reset ---------- */

*, *::before, *::after { box-sizing: border-box; }

html { scroll-behavior: smooth; }

body {

  margin: 0;

  background: var(--color-bg);

  color: var(--color-text);

  font-family: var(--font-body);

  font-size: 16px;

  line-height: 1.65;

  -webkit-font-smoothing: antialiased;

}

img { max-width: 100%; display: block; }

a { color: inherit; text-decoration: none; }

ul, ol { list-style: none; margin: 0; padding: 0; }

h1, h2, h3, h4 { font-family: var(--font-display); margin: 0; line-height: 1.15; }

p { margin: 0; }

button { font-family: inherit; cursor: pointer; }

input, textarea { font-family: inherit; }



@media (prefers-reduced-motion: reduce) {

  *, *::before, *::after {

    animation-duration: 0.001ms !important;

    animation-iteration-count: 1 !important;

    transition-duration: 0.001ms !important;

    scroll-behavior: auto !important;

  }

}



:focus-visible {

  outline: 2px solid var(--color-orange);

  outline-offset: 3px;

}



.skip-link {

  position: absolute;

  left: -999px;

  top: 0;

  background: var(--color-orange);

  color: #10141b;

  padding: 10px 16px;

  border-radius: 0 0 8px 0;

  z-index: 1000;

  font-weight: 600;

}

.skip-link:focus { left: 0; }



/* ---------- Shared layout helpers ---------- */

.section__inner {

  max-width: var(--max-width);

  margin: 0 auto;

  padding: 0 24px;

}

.section__heading {

  margin-bottom: 44px;

  max-width: 560px;

}

.section__heading h2 {

  font-size: clamp(1.7rem, 3vw, 2.3rem);

  font-weight: 600;

  letter-spacing: -0.01em;

}

.section__lede {

  margin-top: 10px;

  color: var(--color-text-muted);

  font-size: 1.02rem;

}

.blogpng{

  width: 10px;

}

.about, .skills, .projects, .blog, .education, .experience, .contact {

  padding: 96px 0;

}

.about { background: var(--color-bg); }

.skills { background: var(--color-bg-alt); padding-bottom: 96px; }

.projects { background: var(--color-bg); }

.blog { background: var(--color-bg-alt); }

.education { background: var(--color-bg); }

.experience { background: var(--color-bg-alt); }

.contact { background: var(--color-bg); }



/* ---------- Buttons ---------- */

.btn {

  display: inline-flex;

  align-items: center;

  justify-content: center;

  gap: 8px;

  padding: 13px 26px;

  border-radius: var(--radius-sm);

  font-weight: 600;

  font-size: 0.95rem;

  border: 1px solid transparent;

  transition: transform var(--dur-fast) var(--ease), background var(--dur-fast) var(--ease), border-color var(--dur-fast) var(--ease);

  white-space: nowrap;

}

.btn--primary {

  background: linear-gradient(135deg, var(--color-blue), var(--color-blue-dim));

  color: #fff;

}

.btn--primary:hover { transform: translateY(-2px); background: linear-gradient(135deg, #4c8bfa, var(--color-blue)); }

.btn--outline {

  background: transparent;

  border-color: var(--color-border-strong);

  color: var(--color-text);

}

.btn--outline:hover { border-color: var(--color-orange); color: var(--color-orange); transform: translateY(-2px); }

.btn--small { padding: 9px 16px; font-size: 0.85rem; }

.btn--block { width: 100%; }



/* ============================================================

   NAVBAR

   ============================================================ */

.navbar {

  position: sticky;

  top: 0;

  z-index: 500;

  background: rgba(9, 12, 18, 0.75);

  backdrop-filter: blur(14px);

  -webkit-backdrop-filter: blur(14px);

  border-bottom: 1px solid var(--color-border);

  transition: border-color var(--dur-fast) var(--ease);

}

.navbar__inner {

  max-width: var(--max-width);

  margin: 0 auto;

  padding: 16px 24px;

  display: flex;

  align-items: center;

  justify-content: space-between;

}

.navbar__brand {

  font-family: var(--font-display);

  font-weight: 700;

  font-size: 1.2rem;

  letter-spacing: -0.02em;

}

.navbar__brand span { color: var(--color-orange); }



.navbar__list {

  display: flex;

  gap: 30px;

}

.nav-link {

  position: relative;

  font-size: 0.92rem;

  font-weight: 500;

  color: var(--color-text-muted);

  padding: 4px 0;

  transition: color var(--dur-fast) var(--ease);

}

.nav-link::after {

  content: '';

  position: absolute;

  left: 0;

  bottom: -4px;

  width: 0;

  height: 2px;

  background: var(--color-orange);

  transition: width var(--dur-fast) var(--ease);

}

.nav-link:hover { color: var(--color-text); }

.nav-link:hover::after { width: 100%; }

.nav-link.active-link { color: var(--color-blue); }

.nav-link.active-link::after { width: 100%; background: var(--color-blue); }



.navbar__toggle {

  display: none;

  flex-direction: column;

  justify-content: center;

  gap: 5px;

  width: 34px;

  height: 34px;

  background: none;

  border: none;

  padding: 0;

}

.navbar__toggle span {

  display: block;

  height: 2px;

  width: 100%;

  background: var(--color-text);

  border-radius: 2px;

  transition: transform var(--dur-fast) var(--ease), opacity var(--dur-fast) var(--ease);

}

.navbar__toggle.is-open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }

.navbar__toggle.is-open span:nth-child(2) { opacity: 0; }

.navbar__toggle.is-open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }



/* ============================================================

   HERO

   ============================================================ */

.hero {

  position: relative;

  min-height: 92vh;

  display: flex;

  align-items: center;

  padding: 60px 0;

  overflow: hidden;

  background:

    radial-gradient(ellipse 700px 500px at 15% 20%, rgba(59, 130, 246, 0.14), transparent 60%),

    radial-gradient(ellipse 600px 500px at 90% 80%, rgba(249, 115, 22, 0.10), transparent 60%),

    var(--color-bg);

}

.hero__inner {

  max-width: var(--max-width);

  margin: 0 auto;

  padding: 0 24px;

  display: grid;

  grid-template-columns: 280px 1fr;

  gap: 64px;

  align-items: center;

}



.hero__photo-wrap {

  width: 280px;

  height: 280px;

  border-radius: 50%;

  padding: 6px;

  background: conic-gradient(from 180deg, var(--color-blue), var(--color-orange), var(--color-blue));

  animation: rotate-glow 10s linear infinite;

  justify-self: center;

}

.hero__photo {

  width: 100%;

  height: 100%;

  border-radius: 50%;

  object-fit: cover;

  border: 4px solid var(--color-bg);

  display: block;

}

@keyframes rotate-glow {

  to { transform: rotate(360deg); }

}

@media (prefers-reduced-motion: reduce) {

  .hero__photo-wrap { animation: none; }

}



.hero__eyebrow {

  color: var(--color-orange);

  font-weight: 600;

  font-size: 1rem;

  margin-bottom: 6px;

}

.hero__name {

  font-size: clamp(2.4rem, 5vw, 3.6rem);

  font-weight: 700;

  letter-spacing: -0.02em;

}

.hero__role {

  font-family: var(--font-display);

  font-size: clamp(1.1rem, 2vw, 1.4rem);

  color: var(--color-blue);

  font-weight: 500;

  margin-top: 6px;

}

.hero__intro {

  margin-top: 20px;

  max-width: 520px;

  color: var(--color-text-muted);

  font-size: 1.05rem;

}

.hero__actions {

  margin-top: 32px;

  display: flex;

  gap: 16px;

  flex-wrap: wrap;

}

.hero__socials {

  margin-top: 34px;

  display: flex;

  gap: 22px;

}

.social-link {

  display: flex;

  align-items: center;

  gap: 8px;

  color: var(--color-text-muted);

  font-size: 0.9rem;

  font-weight: 500;

  transition: color var(--dur-fast) var(--ease), transform var(--dur-fast) var(--ease);

}

.social-link:hover { color: var(--color-orange); transform: translateY(-2px); }



.hero__scroll-cue {

  position: absolute;

  bottom: 28px;

  left: 50%;

  transform: translateX(-50%);

  width: 26px;

  height: 42px;

  border: 2px solid var(--color-border-strong);

  border-radius: 20px;

}

.hero__scroll-cue span {

  display: block;

  width: 4px;

  height: 8px;

  margin: 7px auto 0;

  background: var(--color-orange);

  border-radius: 3px;

  animation: scroll-cue 1.8s ease-in-out infinite;

}

@keyframes scroll-cue {

  0%, 100% { transform: translateY(0); opacity: 1; }

  60% { transform: translateY(12px); opacity: 0.2; }

}

@media (prefers-reduced-motion: reduce) {

  .hero__scroll-cue span { animation: none; }

}



/* ============================================================

   ABOUT

   ============================================================ */

.about__grid {

  display: grid;

  grid-template-columns: repeat(2, 1fr);

  gap: 24px;

}

.about__block {

  background: var(--color-surface);

  border: 1px solid var(--color-border);

  border-radius: var(--radius-md);

  padding: 28px;

  transition: border-color var(--dur-fast) var(--ease), transform var(--dur-fast) var(--ease);

}

.about__block:hover {

  border-color: var(--color-border-strong);

  transform: translateY(-3px);

}

.about__block h3 {

  font-size: 1.05rem;

  font-weight: 600;

  color: var(--color-blue);

  margin-bottom: 10px;

}

.about__block p {

  color: var(--color-text-muted);

  font-size: 0.97rem;

}



/* ============================================================

   SKILLS MARQUEE

   ============================================================ */

.marquee {

  width: 100%;

  overflow: hidden;

  padding: 10px 0;

  mask-image: linear-gradient(90deg, transparent, #000 6%, #000 94%, transparent);

  -webkit-mask-image: linear-gradient(90deg, transparent, #000 6%, #000 94%, transparent);

}

.marquee__track {

  display: flex;

  width: max-content;

  animation: marquee-scroll 32s linear infinite;

}

.marquee.is-paused .marquee__track { animation-play-state: paused; }



.marquee__list {

  display: flex;

  gap: 18px;

  padding-right: 18px;

}

@keyframes marquee-scroll {

  from { transform: translateX(0); }

  to { transform: translateX(-50%); }

}

@media (prefers-reduced-motion: reduce) {

  .marquee__track { animation-duration: 90s; }

}



.skill-chip {

  display: flex;

  align-items: center;

  gap: 12px;

  background: var(--color-surface);

  border: 1px solid var(--color-border);

  border-radius: 999px;

  padding: 12px 22px;

  white-space: nowrap;

  transition: border-color var(--dur-fast) var(--ease);

}

.skill-chip img { filter: saturate(1); }

.skill-chip span { font-weight: 500; font-size: 0.95rem; color: var(--color-text); }

.marquee:hover .skill-chip { border-color: var(--color-border-strong); }



/* ============================================================

   PROJECTS

   ============================================================ */

.projects__grid {

  display: grid;

  grid-template-columns: repeat(2, 1fr);

  gap: 28px;

}

.project-card {

  background: var(--color-surface);

  border: 1px solid var(--color-border);

  border-radius: var(--radius-lg);

  overflow: hidden;

  transition: transform var(--dur-med) var(--ease), border-color var(--dur-fast) var(--ease), box-shadow var(--dur-med) var(--ease);

}

.project-card:hover {

  transform: translateY(-6px);

  border-color: var(--color-border-strong);

  box-shadow: 0 20px 40px -20px rgba(0, 0, 0, 0.6);

}

.project-card__media {

  aspect-ratio: 16 / 10;

  overflow: hidden;

  background: var(--color-bg-alt);

}

.project-card__media img {

  width: 100%;

  height: 100%;

  object-fit: cover;

  transition: transform var(--dur-med) var(--ease);

}

.project-card__media img.blogpng {

  width: 100%;

  height: 100%;

  object-fit: contain;

}

.project-card:hover .project-card__media img { transform: scale(1.04); }



.project-card__body { padding: 26px; }

.project-card__body h3 {

  font-size: 1.25rem;

  font-weight: 600;

}

.project-card__body p {

  margin-top: 10px;

  color: var(--color-text-muted);

  font-size: 0.95rem;

}



.tech-badges {

  display: flex;

  flex-wrap: wrap;

  gap: 8px;

  margin-top: 16px;

}

.tech-badges li {

  font-size: 0.78rem;

  font-weight: 600;

  padding: 5px 12px;

  border-radius: 999px;

  background: rgba(59, 130, 246, 0.12);

  color: var(--color-blue);

  border: 1px solid rgba(59, 130, 246, 0.25);

}

.project-card__actions {

  margin-top: 22px;

  display: flex;

  gap: 12px;

}



/* ============================================================

   BLOG

   ============================================================ */

.blog__grid {

  display: grid;

  grid-template-columns: repeat(3, 1fr);

  gap: 24px;

}

.blog-card {

  background: var(--color-surface);

  border: 1px solid var(--color-border);

  border-radius: var(--radius-md);

  padding: 24px;

  transition: transform var(--dur-fast) var(--ease), border-color var(--dur-fast) var(--ease);

}

.blog-card:hover { transform: translateY(-4px); border-color: var(--color-border-strong); }

.blog-card__date {

  font-size: 0.8rem;

  color: var(--color-orange);

  font-weight: 600;

}

.blog-card h3 {

  margin-top: 10px;

  font-size: 1.05rem;

  font-weight: 600;

}

.blog-card p {

  margin-top: 8px;

  color: var(--color-text-muted);

  font-size: 0.9rem;

}

.blog-card__link {

  display: inline-block;

  margin-top: 16px;

  font-size: 0.88rem;

  font-weight: 600;

  color: var(--color-blue);

  border-bottom: 1px solid transparent;

  transition: border-color var(--dur-fast) var(--ease);

}

.blog-card__link:hover { border-color: var(--color-blue); }



/* ============================================================

   TIMELINE (Education / Experience)

   ============================================================ */

.timeline {

  position: relative;

  max-width: 720px;

  padding-left: 28px;

  border-left: 2px solid var(--color-border);

}

.timeline__item {

  position: relative;

  padding-bottom: 40px;

}

.timeline__item:last-child { padding-bottom: 0; }

.timeline__dot {

  position: absolute;

  left: -35px;

  top: 4px;

  width: 12px;

  height: 12px;

  border-radius: 50%;

  background: var(--color-bg);

  border: 2px solid var(--color-orange);

}

.timeline__period {

  font-size: 0.82rem;

  font-weight: 600;

  color: var(--color-orange);

  letter-spacing: 0.02em;

}

.timeline__content h3 {

  margin-top: 6px;

  font-size: 1.1rem;

  font-weight: 600;

}

.timeline__org {

  margin-top: 4px;

  color: var(--color-blue);

  font-size: 0.92rem;

  font-weight: 500;

}

.timeline__content p:last-child {

  margin-top: 10px;

  color: var(--color-text-muted);

  font-size: 0.95rem;

}



/* ============================================================

   CONTACT

   ============================================================ */

.contact__grid {

  display: grid;

  grid-template-columns:  1fr;

  gap: 48px;

}

.contact__info {

  display: flex;

  flex-direction: column;

  gap: 20px;

}

.contact__item {

  display: flex;

  align-items: center;

  gap: 14px;

  color: var(--color-text-muted);

  font-size: 0.98rem;

  padding: 16px 18px;

  background: var(--color-surface);

  border: 1px solid var(--color-border);

  border-radius: var(--radius-sm);

  transition: border-color var(--dur-fast) var(--ease), color var(--dur-fast) var(--ease);

}

.contact__item svg { color: var(--color-blue); flex-shrink: 0; }

.contact__item:hover { border-color: var(--color-orange); color: var(--color-text); }



.contact__form {

  background: var(--color-surface);

  border: 1px solid var(--color-border);

  border-radius: var(--radius-lg);

  padding: 32px;

}

.form-field { margin-bottom: 18px; }

.form-field label {

  display: block;

  margin-bottom: 8px;

  font-size: 0.88rem;

  font-weight: 500;

  color: var(--color-text-muted);

}

.form-field input,

.form-field textarea {

  width: 100%;

  background: var(--color-bg-alt);

  border: 1px solid var(--color-border);

  border-radius: var(--radius-sm);

  padding: 12px 14px;

  color: var(--color-text);

  font-size: 0.95rem;

  resize: vertical;

  transition: border-color var(--dur-fast) var(--ease);

}

.form-field input:focus,

.form-field textarea:focus {

  outline: none;

  border-color: var(--color-blue);

}

.form-status {

  margin-top: 14px;

  font-size: 0.88rem;

  color: var(--color-orange);

  min-height: 1.2em;

}



/* ============================================================

   FOOTER

   ============================================================ */

.footer {

  border-top: 1px solid var(--color-border);

  padding: 28px 0;

}

.footer__inner {

  display: flex;

  align-items: center;

  justify-content: space-between;

  flex-wrap: wrap;

  gap: 12px;

}

.footer p {

  color: var(--color-text-faint);

  font-size: 0.85rem;

}

.footer__socials { display: flex; gap: 20px; }

.footer__socials a {

  color: var(--color-text-faint);

  font-size: 0.85rem;

  transition: color var(--dur-fast) var(--ease);

}

.footer__socials a:hover { color: var(--color-orange); }



/* ============================================================

   BACK TO TOP

   ============================================================ */

.back-to-top {

  position: fixed;

  right: 24px;

  bottom: 24px;

  width: 44px;

  height: 44px;

  border-radius: 50%;

  border: 1px solid var(--color-border-strong);

  background: var(--color-surface);

  color: var(--color-text);

  display: flex;

  align-items: center;

  justify-content: center;

  opacity: 0;

  pointer-events: none;

  transform: translateY(10px);

  transition: opacity var(--dur-fast) var(--ease), transform var(--dur-fast) var(--ease), border-color var(--dur-fast) var(--ease);

  z-index: 400;

}

.back-to-top.is-visible { opacity: 1; pointer-events: auto; transform: translateY(0); }

.back-to-top:hover { border-color: var(--color-orange); color: var(--color-orange); }



/* ============================================================

   SCROLL REVEAL ANIMATIONS

   ============================================================ */

[data-animate] {

  opacity: 0;

  transition: opacity var(--dur-med) var(--ease), transform var(--dur-med) var(--ease);

}

[data-animate="fade-in"] { transform: translateY(14px); }

[data-animate="slide-up"] { transform: translateY(28px); }

[data-animate].is-visible { opacity: 1; transform: translateY(0); }



@media (prefers-reduced-motion: reduce) {

  [data-animate] { opacity: 1; transform: none; transition: none; }

}



/* ============================================================

   RESPONSIVE

   ============================================================ */

@media (max-width: 960px) {

  .hero__inner { grid-template-columns: 1fr; text-align: center; }

  .hero__photo-wrap { width: 220px; height: 220px; }

  .hero__intro { margin-left: auto; margin-right: auto; }

  .hero__actions, .hero__socials { justify-content: center; }



  .about__grid { grid-template-columns: 1fr; }

  .projects__grid { grid-template-columns: 1fr; }

  .blog__grid { grid-template-columns: repeat(2, 1fr); }

  .contact__grid { grid-template-columns: 1fr; }

}



@media (max-width: 760px) {

  .navbar__nav {

    position: fixed;

    top: 65px;

    left: 0;

    right: 0;

    background: var(--color-bg-alt);

    border-bottom: 1px solid var(--color-border);

    max-height: 0;

    overflow: hidden;

    transition: max-height var(--dur-med) var(--ease);

  }

  .navbar__nav.is-open { max-height: 480px; }

  .navbar__list {

    flex-direction: column;

    gap: 0;

    padding: 8px 24px 20px;

  }

  .navbar__list li { border-bottom: 1px solid var(--color-border); }

  .navbar__list li:last-child { border-bottom: none; }

  .nav-link { display: block; padding: 14px 0; }

  .nav-link::after { display: none; }

  .navbar__toggle { display: flex; }



  .about, .skills, .projects, .blog, .education, .experience, .contact { padding: 64px 0; }

  .blog__grid { grid-template-columns: 1fr; }

  .hero { min-height: auto; padding-top: 100px; padding-bottom: 80px; }

}



@media (max-width: 480px) {

  .hero__photo-wrap { width: 170px; height: 170px; }

  .hero__actions { flex-direction: column; width: 100%; }

  .hero__actions .btn { width: 100%; }

  .contact__form { padding: 22px; }

}

.form-status.error { color: #f97316; }
.form-status.success { color: #22c55e; }
</style>

</head>

<body>



<a class="skip-link" href="#main">Skip to content</a>



<!-- ============ NAVBAR ============ -->

<header class="navbar" id="navbar">

  <div class="navbar__inner">

    <a href="#home" class="navbar__brand">Yahya<span>Tourabi</span></a>



    <nav class="navbar__nav" id="navMenu">

      <ul class="navbar__list">

        <li><a href="#home" class="nav-link active-link">Home</a></li>

        <li><a href="#about" class="nav-link">About</a></li>

        <li><a href="#skills" class="nav-link">Skills</a></li>

        <li><a href="#projects" class="nav-link">Projects</a></li>

        <li><a href="#education" class="nav-link">Education</a></li>

        <li><a href="#experience" class="nav-link">Experience</a></li>

        <li><a href="#contact" class="nav-link">Contact</a></li>

      </ul>

    </nav>



    <button class="navbar__toggle" id="navToggle" aria-label="Open navigation menu" aria-expanded="false" aria-controls="navMenu">

      <span></span><span></span><span></span>

    </button>

  </div>

</header>



<main id="main">



  <!-- ============ HERO ============ -->

  <section class="hero" id="home">

    <div class="hero__inner">

      <div  class="hero__photo-wrap" data-animate="fade-in">

        <img src="/portfolio/public/images/me.jpg" alt="Portrait of Yahya Tourabi " class="hero__photo" >

      </div>



      <div class="hero__content" data-animate="slide-up">

        <p class="hero__eyebrow">Hello, I'm</p>

        <h1 class="hero__name">Yahya Tourabi</h1>

        <p class="hero__role">Full Stack Developer</p>

        <p class="hero__intro">

          I design and build complete web applications — from responsive interfaces

          to the servers and databases behind them. I care about clean code,

          fast performance and interfaces people enjoy using.

        </p>



        <div class="hero__actions">

          <a href="#projects" class="btn btn--primary">View My Projects</a>

          <a href="#contact" class="btn btn--outline">Contact Me</a>

        </div>



        <div class="hero__socials">

          <a href="https://github.com/yahiatourabi58-hash" target="\_blank" rel="noopener noreferrer" aria-label="GitHub profile" class="social-link">

            <svg viewBox="0 0 24 24" width="22" height="22" aria-hidden="true"><path fill="currentColor" d="M12 .5C5.65.5.5 5.66.5 12.03c0 5.1 3.29 9.42 7.86 10.95.58.1.79-.25.79-.56 0-.27-.01-1.17-.02-2.12-3.2.7-3.88-1.36-3.88-1.36-.52-1.34-1.28-1.7-1.28-1.7-1.05-.72.08-.71.08-.71 1.16.08 1.77 1.2 1.77 1.2 1.03 1.77 2.7 1.26 3.36.96.1-.75.4-1.26.73-1.55-2.56-.29-5.25-1.28-5.25-5.71 0-1.26.45-2.29 1.19-3.09-.12-.29-.52-1.47.11-3.06 0 0 .97-.31 3.18 1.18a11.1 11.1 0 0 1 5.79 0c2.2-1.49 3.17-1.18 3.17-1.18.63 1.59.24 2.77.12 3.06.74.8 1.19 1.83 1.19 3.09 0 4.44-2.7 5.42-5.27 5.7.42.36.78 1.07.78 2.17 0 1.57-.01 2.83-.01 3.22 0 .31.21.67.8.56A10.53 10.53 0 0 0 23.5 12.03C23.5 5.66 18.35.5 12 .5Z"/></svg>

            <span>GitHub</span>

          </a>

          <a href="https://www.linkedin.com/in/yahya-tourabi/" target="\_blank" rel="noopener noreferrer" aria-label="LinkedIn profile" class="social-link">

            <svg viewBox="0 0 24 24" width="22" height="22" aria-hidden="true"><path fill="currentColor" d="M20.45 20.45h-3.56v-5.57c0-1.33-.02-3.04-1.85-3.04-1.86 0-2.14 1.45-2.14 2.94v5.67H9.34V9h3.41v1.56h.05c.47-.9 1.63-1.85 3.36-1.85 3.6 0 4.27 2.37 4.27 5.45v6.29ZM5.34 7.43a2.07 2.07 0 1 1 0-4.13 2.07 2.07 0 0 1 0 4.13ZM7.12 20.45H3.56V9h3.56v11.45Z"/></svg>

            <span>LinkedIn</span>

          </a>

        </div>

      </div>

    </div>

    <a href="#about" class="hero__scroll-cue" aria-label="Scroll to About section"><span></span></a>

  </section>



  <!-- ============ ABOUT ============ -->

  <section class="about" id="about">

    <div class="section__inner">

      <div class="section__heading" data-animate="fade-in">

        <h2>About Me</h2>

        <p class="section__lede">A little about who I am and how I got here.</p>

      </div>



      <div class="about__grid">

        <div class="about__block" data-animate="fade-in">

          <h3>Introduction</h3>

          <p>

            I'm Yahya, a 20-year-old developer from Tangier,Morocco.&#x20;

            I started my journey in web development because

            I enjoy solving problems and building things from scratch.

            I'm currently developing my skills in both front-end and back-end development,

             with the goal of becoming a Full Stack Developer.

          </p>

        </div>



        <div class="about__block" data-animate="fade-in">

          <h3>My Journey</h3>

          <p>

            I started learning web development last year, beginning

             with the fundamentals and gradually discovering different technologies

            and tools. Since then, I've been learning by practicing, building projects,

             and trying to understand how things work rather than just copying code.

              Every project gives me a chance to improve my skills and learn something new.

          </p>

        </div>



        <div class="about__block" data-animate="fade-in">

          <h3>Interests</h3>

          <p>

            Outside of coding, I enjoy problem solving, traveling, doing sports,

             and gaming from time to time. I also like discovering new technologies&#x20;

             and learning new ways to build better and more useful applications.

          </p>

        </div>



        <div class="about__block" data-animate="fade-in">

          <h3>Goals</h3>

          <p>

            My main goal is to become a skilled Full Stack Developer and keep improving

            my technical skills. I also want to build a project that I'm proud of and turn it

            into something successful and useful for people. For me, the goal is not just

            to learn technologies, but to use them to create real projects.

          </p>

        </div>

      </div>

    </div>

  </section>



  <!-- ============ SKILLS ============ -->

  <section class="skills" id="skills">

    <div class="section__inner">

      <div class="section__heading" data-animate="fade-in">

        <h2>Skills</h2>

        <p class="section__lede">Technologies I work with, day to day.</p>

      </div>

    </div>



    <div class="marquee" id="marquee">

      <div class="marquee__track" id="marqueeTrack">

        <ul class="marquee__list" id="marqueeList">

          <li class="skill-chip"><img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/html5/html5-original.svg" alt="HTML" width="34" height="34" loading="lazy"><span>HTML</span></li>

          <li class="skill-chip"><img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/css3/css3-original.svg" alt="CSS" width="34" height="34" loading="lazy"><span>CSS</span></li>

          <li class="skill-chip"><img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/javascript/javascript-original.svg" alt="JavaScript" width="34" height="34" loading="lazy"><span>JavaScript</span></li>

          <li class="skill-chip"><img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/bootstrap/bootstrap-original.svg" alt="Bootstrap" width="34" height="34" loading="lazy"><span>Bootstrap</span></li>

          <li class="skill-chip"><img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/tailwindcss/tailwindcss-original.svg" alt="Tailwind CSS" width="34" height="34" loading="lazy"><span>Tailwind CSS</span></li>

          <li class="skill-chip"><img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/react/react-original.svg" alt="React.js" width="34" height="34" loading="lazy"><span>React.js</span></li>

          <li class="skill-chip"><img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/laravel/laravel-original.svg" alt="Laravel" width="34" height="34" loading="lazy"><span>Laravel</span></li>

          <li class="skill-chip"><img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/python/python-original.svg" alt="Python" width="34" height="34" loading="lazy"><span>Python</span></li>

          <li class="skill-chip"><img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/c/c-original.svg" alt="C" width="34" height="34" loading="lazy"><span>C</span></li>

          <li class="skill-chip"><img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/git/git-original.svg" alt="Git" width="34" height="34" loading="lazy"><span>Git</span></li>

          <li class="skill-chip"><img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/figma/figma-original.svg" alt="Figma" width="34" height="34" loading="lazy"><span>Figma</span></li>

        </ul>

      </div>

    </div>

  </section>



  <!-- ============ PROJECTS ============ -->

  <section class="projects" id="projects">

    <div class="section__inner">

      <div class="section__heading" data-animate="fade-in">

        <h2>Projects</h2>

        <p class="section__lede">A couple of things I've built recently.</p>

      </div>



      <div class="projects__grid">

                <article class="project-card" data-animate="fade-in">

          <div class="project-card__media">

            <img src="/images/me.jpg" alt="Screenshot of some agile exercices" loading="lazy" class="blogpng">

          </div>

          <div class="project-card__body">

            <h3>Agile exercices</h3>

            <p>Une collection d’exercices et de questions couvrant les notions essentielles du module Approche Agile, conçue pour faciliter la révision et la préparation aux examens de l’OFPPT.</p>

          </div>

        </article>



        <article class="project-card" data-animate="fade-in">

          <div class="project-card__media">

            <img src="/portfolio/public/images/blog.jpg" alt="Screenshot of the Blog Post project" loading="lazy" class="blogpng">

          </div>

          <div class="project-card__body">

            <h3>Blog, Post, Dashboard...</h3>

            <p>A clean, readable blog layout built to practice semantic structure, responsive typography and vanilla JavaScript interactions.</p>

            <ul class="tech-badges">

              <li>HTML</li>

              <li>CSS</li>

              <li>JavaScript</li>

            </ul>

            <div class="project-card__actions">

              <a href="https://github.com/yahiatourabi58-hash/blog-post" target="\_blank" rel="noopener noreferrer" class="btn btn--small btn--outline">GitHub</a>

              <a href="#" target="\_blank" rel="noopener noreferrer" class="btn btn--small btn--primary">Live Demo</a>

            </div>

          </div>

        </article>

        <article>



        </article>



        <article class="project-card" data-animate="fade-in">

          <div class="project-card__media">

            <img src="/portfolio/public/images/weather.jpg" alt="Screenshot of the Weather App project" loading="lazy" width="1200" height="750">

          </div>

          <div class="project-card__body">

            <h3>Weather App</h3>

            <p>A weather lookup app that fetches live forecast data from a public API and renders it in a simple, responsive interface.</p>

            <ul class="tech-badges">

              <li>HTML</li>

              <li>CSS</li>

              <li>JavaScript</li>

            </ul>

            <div class="project-card__actions">

              <a href="https://github.com/yahiatourabi58-hash/weather-app" target="\_blank" rel="noopener noreferrer" class="btn btn--small btn--outline">GitHub</a>

              <a href="#" target="\_blank" rel="noopener noreferrer" class="btn btn--small btn--primary">Live Demo</a>

            </div>

          </div>

        </article>



      </div>

    </div>

  </section>



  <!-- ============ EDUCATION ============ -->

  <section class="education" id="education">

    <div class="section__inner">

      <div class="section__heading" data-animate="fade-in">

        <h2>Education</h2>

        <p class="section__lede">My academic background.</p>

      </div>



      <ol class="timeline">

        <li class="timeline__item" data-animate="fade-in">

          <div class="timeline__dot"></div>

          <div class="timeline__content">

            <p class="timeline__period">2024</p>

            <h3>Baccalaureate — Science Physics and Chemistry</h3>

            <p class="timeline__org">Lycée Sidi Driss, Tangier, Morocco</p>

            <p>Completed my Baccalaureate in Science Physics and Chemistry in 2024,&#x20;

              which gave me a strong foundation in scientific thinking, problem solving,

               and analytical skills.</p>

          </div>

        </li>

        <li class="timeline__item" data-animate="fade-in">

          <div class="timeline__dot"></div>

          <div class="timeline__content">

            <p class="timeline__period">2025 — Present</p>

            <h3>Digital Development — Full Stack</h3>

            <p class="timeline__org">ISTA NTIC, Tangier, Morocco — OFPPT</p>

            <p>Currently studying Digital Development at OFPPT, specializing in&#x20;

              Full Stack development. I'm developing my skills in front-end and back-end

               technologies and working on practical projects as part of my training.</p>

          </div>

        </li>

      </ol>

    </div>

  </section>



 <!-- ============ EXPERIENCE ============ -->

<section class="experience" id="experience">

  <div class="section__inner">

    <div class="section__heading" data-animate="fade-in">

      <h2>Experience</h2>

      <p class="section__lede">My professional journey & upcoming roles.</p>

    </div>



    <ol class="timeline">

      <li class="timeline__item" data-animate="fade-in">

        <div class="timeline__dot"></div>

        <div class="timeline__content">

          <p class="timeline__period">Stage (1 Month)</p>

          <h3>Full-Stack Developer Intern</h3>

          <p class="timeline__org">L'entreprise CODERS </p>

          <p>Preparing to work on web development projects, database integration, and feature updates using PHP and modern frontend tools.</p>

        </div>

      </li>

    </ol>

  </div>

</section>

  <!-- ============ CONTACT ============ -->

  <section class="contact" id="contact">

    <div class="section__inner">

      <div class="section__heading" data-animate="fade-in">

        <h2>Contact</h2>

        <p class="section__lede">Have a project in mind, or just want to say hello?</p>

      </div>



      <div class="contact__grid">

        <div class="contact__info" data-animate="fade-in">

          <a href="mailto:yahyatourabi627@gmail.com" class="contact__item">

            <svg viewBox="0 0 24 24" width="22" height="22" aria-hidden="true"><path fill="currentColor" d="M2 5.5A1.5 1.5 0 0 1 3.5 4h17A1.5 1.5 0 0 1 22 5.5v13a1.5 1.5 0 0 1-1.5 1.5h-17A1.5 1.5 0 0 1 2 18.5v-13Zm2.2.5 7.3 5.8a.75.75 0 0 0 .93 0L19.8 6H4.2Z"/></svg>

            <span>yahyatourabi627@gmail.com</span>

          </a>

          <a href="https://github.com/yahiatourabi58-hash" target="\_blank" rel="noopener noreferrer" class="contact__item">

            <svg viewBox="0 0 24 24" width="22" height="22" aria-hidden="true"><path fill="currentColor" d="M12 .5C5.65.5.5 5.66.5 12.03c0 5.1 3.29 9.42 7.86 10.95.58.1.79-.25.79-.56 0-.27-.01-1.17-.02-2.12-3.2.7-3.88-1.36-3.88-1.36-.52-1.34-1.28-1.7-1.28-1.7-1.05-.72.08-.71.08-.71 1.16.08 1.77 1.2 1.77 1.2 1.03 1.77 2.7 1.26 3.36.96.1-.75.4-1.26.73-1.55-2.56-.29-5.25-1.28-5.25-5.71 0-1.26.45-2.29 1.19-3.09-.12-.29-.52-1.47.11-3.06 0 0 .97-.31 3.18 1.18a11.1 11.1 0 0 1 5.79 0c2.2-1.49 3.17-1.18 3.17-1.18.63 1.59.24 2.77.12 3.06.74.8 1.19 1.83 1.19 3.09 0 4.44-2.7 5.42-5.27 5.7.42.36.78 1.07.78 2.17 0 1.57-.01 2.83-.01 3.22 0 .31.21.67.8.56A10.53 10.53 0 0 0 23.5 12.03C23.5 5.66 18.35.5 12 .5Z"/></svg>

            <span>github.com/yahiatourabi58-hash</span>

          </a>

          <a href="https://www.linkedin.com/in/yahya-tourabi/" target="\_blank" rel="noopener noreferrer" class="contact__item">

            <svg viewBox="0 0 24 24" width="22" height="22" aria-hidden="true"><path fill="currentColor" d="M20.45 20.45h-3.56v-5.57c0-1.33-.02-3.04-1.85-3.04-1.86 0-2.14 1.45-2.14 2.94v5.67H9.34V9h3.41v1.56h.05c.47-.9 1.63-1.85 3.36-1.85 3.6 0 4.27 2.37 4.27 5.45v6.29ZM5.34 7.43a2.07 2.07 0 1 1 0-4.13 2.07 2.07 0 0 1 0 4.13ZM7.12 20.45H3.56V9h3.56v11.45Z"/></svg>

            <span>linkedin.com/in/yahya-tourabi</span>

          </a>

        </div>



        <form class="contact__form" id="contactForm" data-animate="fade-in" method="post" action="#contact">

          <div class="form-field">

            <label for="name">Name</label>

            <input type="text" id="name" name="name" autocomplete="name" value="<?= htmlspecialchars($nameValue, ENT_QUOTES, 'UTF-8') ?>" required>

          </div>

          <div class="form-field">

            <label for="email">Email</label>

            <input type="email" id="email" name="email" autocomplete="email" value="<?= htmlspecialchars($emailValue, ENT_QUOTES, 'UTF-8') ?>" required>

          </div>

          <div class="form-field">

            <label for="message">Message</label>

            <textarea id="message" name="message" rows="5" required><?= htmlspecialchars($messageValue, ENT_QUOTES, 'UTF-8') ?></textarea>

          </div>

          <button type="submit" name="contact_submit" value="1" class="btn btn--primary btn--block">Send Message</button>

          <p class="form-status <?= htmlspecialchars($formStatusType, ENT_QUOTES, 'UTF-8') ?>" id="formStatus" role="status" aria-live="polite"><?= htmlspecialchars($formStatus, ENT_QUOTES, 'UTF-8') ?></p>

        </form>

      </div>

    </div>

  </section>



</main>



<footer class="footer">

  <div class="section__inner footer__inner">

    <p>&copy; <span id="year"></span> Yahya Tourabi. All rights reserved.</p>

    <div class="footer__socials">

      <a href="https://github.com/yahiatourabi58-hash" target="\_blank" rel="noopener noreferrer" aria-label="GitHub">GitHub</a>

      <a href="https://www.linkedin.com/in/yahya-tourabi/" target="\_blank" rel="noopener noreferrer" aria-label="LinkedIn">LinkedIn</a>

    </div>

  </div>

</footer>



<button class="back-to-top" id="backToTop" aria-label="Back to top">

  <svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><path fill="currentColor" d="m12 6-7 7 1.41 1.41L11 9.83V19h2V9.83l4.59 4.58L19 12l-7-7Z"/></svg>

</button>



<script>
/* ============================================================
   Full Stack Developer Portfolio — inline JavaScript
   ============================================================ */
document.addEventListener('DOMContentLoaded', () => {
  initMobileMenu();
  initSmoothScroll();
  initActiveNavLink();
  initMarquee();
  initScrollReveal();
  initBackToTop();
  initYear();
});

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
  menu.querySelectorAll('.nav-link').forEach((link) => {
    link.addEventListener('click', () => {
      menu.classList.remove('is-open');
      toggle.classList.remove('is-open');
      toggle.setAttribute('aria-expanded', 'false');
    });
  });
}

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

function initActiveNavLink() {
  const sections = document.querySelectorAll('main section[id]');
  const navLinks = document.querySelectorAll('.nav-link');
  if (!sections.length || !navLinks.length) return;
  const setActive = (id) => {
    navLinks.forEach((link) => {
      link.classList.toggle('active-link', link.getAttribute('href') === `#${id}`);
    });
  };
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) setActive(entry.target.id);
    });
  }, { rootMargin: '-45% 0px -50% 0px', threshold: 0 });
  sections.forEach((section) => observer.observe(section));
}

function initMarquee() {
  const marquee = document.getElementById('marquee');
  const track = document.getElementById('marqueeTrack');
  const list = document.getElementById('marqueeList');
  if (!marquee || !track || !list) return;
  const clone = list.cloneNode(true);
  clone.setAttribute('aria-hidden', 'true');
  track.appendChild(clone);
  marquee.addEventListener('mouseenter', () => marquee.classList.add('is-paused'));
  marquee.addEventListener('mouseleave', () => marquee.classList.remove('is-paused'));
  marquee.addEventListener('focusin', () => marquee.classList.add('is-paused'));
  marquee.addEventListener('focusout', () => marquee.classList.remove('is-paused'));
}

function initScrollReveal() {
  const items = document.querySelectorAll('[data-animate]');
  if (!items.length) return;
  if (!('IntersectionObserver' in window)) {
    items.forEach((item) => item.classList.add('is-visible'));
    return;
  }
  const observer = new IntersectionObserver((entries, obs) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        obs.unobserve(entry.target);
      }
    });
  }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });
  items.forEach((item) => observer.observe(item));
}

function initBackToTop() {
  const button = document.getElementById('backToTop');
  if (!button) return;
  window.addEventListener('scroll', () => {
    button.classList.toggle('is-visible', window.scrollY > 500);
  });
  button.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
}

function initYear() {
  const yearEl = document.getElementById('year');
  if (yearEl) yearEl.textContent = new Date().getFullYear();
}

</script>

</body>

</html>
