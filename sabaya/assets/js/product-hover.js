

    /**
     * Trigger a heart-pulse animation on the given element.
     * Removes the class once the animation ends to allow re-trigger.
     * @param {Element} el - the element to animate (or a parent containing it)
     */
    function triggerPulse(el) {
        if (!el) return;
        el.classList.remove('pulse');
        // Force reflow to allow re-triggering the animation
        void el.offsetWidth; // eslint-disable-line no-void
        el.classList.add('pulse');
        el.addEventListener('animationend', function handler() {
            el.classList.remove('pulse');
            el.removeEventListener('animationend', handler);
        });
    }

    /* ── Wishlist icon buttons ──────────────────────────────── */

    /**
     * Attach pulse behaviour to all wishlist icon elements.
     * Targets:
     *  - .pd-btn-wishlist  (product-details page)
     *  - .wishlist-icon-btn (generic icon button)
     */
    function initWishlistPulse() {
        // Product details page — wishlist button
        var wishlistBtns = document.querySelectorAll(
            '.pd-btn-wishlist, .wishlist-icon-btn, [data-wishlist-pulse]'
        );

        wishlistBtns.forEach(function (btn) {
            btn.addEventListener('click', function () {
                triggerPulse(btn);
            });

            // Keyboard accessibility — also pulse on Enter/Space
            btn.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    triggerPulse(btn);
                }
            });
        });
    }

    /* ── Card overlay keyboard accessibility ─────────────────── */

    /**
     * Ensure product-card-overlay is visible when a button inside
     * the card gains keyboard focus (via :focus-within — CSS handles
     * the visual, but we ensure screen-reader semantics stay correct).
     */
    function initCardFocusVisibility() {
        var cards = document.querySelectorAll('.product-card');

        cards.forEach(function (card) {
            var overlay = card.querySelector('.product-card-overlay');
            if (!overlay) return;

            // When focus enters the overlay, mark it visible for AT
            overlay.addEventListener('focusin', function () {
                overlay.setAttribute('aria-hidden', 'false');
            });

            overlay.addEventListener('focusout', function (e) {
                if (!overlay.contains(e.relatedTarget)) {
                    overlay.setAttribute('aria-hidden', 'true');
                }
            });
        });
    }

    /* ── Init ────────────────────────────────────────────────── */

    document.addEventListener('DOMContentLoaded', function () {
        initWishlistPulse();
        initCardFocusVisibility();
    });


