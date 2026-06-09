/**
 * counter.js — Sabaya Luxury
 * Animated number counters for Dashboard & Statistics KPI cards.
 *
 * Usage:
 *   <span class="counter" data-count="1234">0</span>
 *   <span class="counter" data-count="15000.00" data-decimals="2" data-separator=" " data-decimal-sep=",">0</span>
 *
 * Attributes:
 *   data-count        — target number (required)
 *   data-decimals     — decimal places to display (default: 0)
 *   data-separator    — thousands separator character (default: '')
 *   data-decimal-sep  — decimal separator character (default: '.')
 *   data-suffix       — text appended after the number (default: '')
 *   data-duration     — animation duration in ms (default: 1800)
 *
 * Dependencies: none (vanilla JS, IntersectionObserver)
 */

(function () {
  'use strict';

  /* ── Easing ────────────────────────────────────────── */
  /** Ease-out quad: fast start, smooth deceleration */
  function easeOutQuad(t) {
    return t * (2 - t);
  }

  /* ── Format number ─────────────────────────────────── */
  function formatNumber(value, decimals, thousandsSep, decimalSep) {
    const fixed = value.toFixed(decimals);
    if (thousandsSep === '' && decimalSep === '.') return fixed;

    const parts = fixed.split('.');
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousandsSep);
    return decimals > 0 ? parts.join(decimalSep) : parts[0];
  }

  /* ── Animate one counter element ───────────────────── */
  function animateCounter(el) {
    const target      = parseFloat(el.dataset.count)   || 0;
    const decimals    = parseInt(el.dataset.decimals,  10) || 0;
    const separator   = el.dataset.separator   !== undefined ? el.dataset.separator   : '';
    const decimalSep  = el.dataset.decimalSep  !== undefined ? el.dataset.decimalSep  : '.';
    const suffix      = el.dataset.suffix      !== undefined ? el.dataset.suffix      : '';
    const duration    = parseInt(el.dataset.duration,  10) || 1800;

    /* Clamp duration between 1200 ms and 2500 ms */
    const clampedDuration = Math.min(Math.max(duration, 1200), 2500);

    let startTime = null;

    function step(timestamp) {
      if (!startTime) startTime = timestamp;
      const elapsed  = timestamp - startTime;
      const progress = Math.min(elapsed / clampedDuration, 1);
      const eased    = easeOutQuad(progress);
      const current  = eased * target;

      el.textContent = formatNumber(current, decimals, separator, decimalSep) + suffix;

      /* Keep aria-label accurate throughout animation */
      el.setAttribute('aria-label', formatNumber(target, decimals, separator, decimalSep) + suffix);

      if (progress < 1) {
        requestAnimationFrame(step);
      } else {
        /* Ensure exact final value */
        el.textContent = formatNumber(target, decimals, separator, decimalSep) + suffix;
      }
    }

    requestAnimationFrame(step);
  }

  /* ── IntersectionObserver setup ────────────────────── */
  function initCounters() {
    const counters = document.querySelectorAll('.counter[data-count]');
    if (!counters.length) return;

    /* Fallback: no IntersectionObserver support → run immediately */
    if (!('IntersectionObserver' in window)) {
      counters.forEach(animateCounter);
      return;
    }

    const observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            animateCounter(entry.target);
            observer.unobserve(entry.target); /* Run only once */
          }
        });
      },
      {
        threshold: 0.25 /* Trigger when 25 % of card is visible */
      }
    );

    counters.forEach(function (el) {
      /* Set aria-label to final value for screen readers */
      const target     = parseFloat(el.dataset.count)  || 0;
      const decimals   = parseInt(el.dataset.decimals, 10) || 0;
      const separator  = el.dataset.separator  !== undefined ? el.dataset.separator  : '';
      const decimalSep = el.dataset.decimalSep !== undefined ? el.dataset.decimalSep : '.';
      const suffix     = el.dataset.suffix     !== undefined ? el.dataset.suffix     : '';

      el.setAttribute('aria-label', formatNumber(target, decimals, separator, decimalSep) + suffix);
      el.setAttribute('aria-live', 'off'); /* Prevent screen-reader chatter during animation */

      /* Show "0" as the pre-animation state */
      el.textContent = formatNumber(0, decimals, separator, decimalSep) + suffix;

      observer.observe(el);
    });
  }

  /* ── Boot ───────────────────────────────────────────── */
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCounters);
  } else {
    initCounters();
  }
})();
