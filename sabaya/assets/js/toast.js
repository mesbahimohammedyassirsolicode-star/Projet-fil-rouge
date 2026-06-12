

(function (global) {
    'use strict';

    /* ── Configuration ─────────────────────────────────────── */
    const DURATION     = 3000; // ms — matches CSS @keyframes toast-progress
    const FADE_DELAY   = 400;  // ms — matches CSS toast-fade-out duration
    const CONTAINER_ID = 'toast-container';

    const ICONS = {
        success: '<i class="fas fa-check" aria-hidden="true"></i>',
        error:   '<i class="fas fa-times" aria-hidden="true"></i>'
    };

    const LABELS = {
        success: 'Succès',
        error:   'Erreur'
    };

    /* ── Get / create container ─────────────────────────────── */
    function getContainer() {
        let el = document.getElementById(CONTAINER_ID);
        if (!el) {
            el = document.createElement('div');
            el.id = CONTAINER_ID;
            el.setAttribute('aria-live', 'polite');
            el.setAttribute('aria-atomic', 'false');
            document.body.appendChild(el);
        }
        return el;
    }

    /* ── Dismiss a toast ────────────────────────────────────── */
    function dismiss(toast, timerId) {
        if (toast.classList.contains('is-hiding')) return;
        clearTimeout(timerId);
        toast.classList.add('is-hiding');
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, FADE_DELAY);
    }

    /* ── Show a toast ───────────────────────────────────────── */
    function show(message, type, title) {
        type  = (type === 'error') ? 'error' : 'success';
        title = title || LABELS[type];

        const container = getContainer();

        /* Build element */
        const toast = document.createElement('div');
        toast.className  = `toast toast--${type}`;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-atomic', 'true');
        toast.setAttribute('tabindex', '0');

        toast.innerHTML  = `
            <div class="toast__icon">${ICONS[type]}</div>
            <div class="toast__body">
                <span class="toast__title">${_escape(title)}</span>
                <span class="toast__message">${_escape(message)}</span>
            </div>
            <button class="toast__close" aria-label="Fermer la notification">&#x2715;</button>
            <div class="toast__progress" aria-hidden="true"></div>
        `.trim();

        container.appendChild(toast);

        /* Auto-dismiss after DURATION */
        const timerId = setTimeout(() => {
            dismiss(toast, timerId);
        }, DURATION);

        /* Click anywhere on toast to dismiss */
        toast.addEventListener('click', () => {
            dismiss(toast, timerId);
        });

        /* Keyboard dismiss — Enter or Escape while focused */
        toast.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === 'Escape') {
                dismiss(toast, timerId);
            }
        });

        /* Close button (stop click bubbling already handled above) */
        const closeBtn = toast.querySelector('.toast__close');
        if (closeBtn) {
            closeBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                dismiss(toast, timerId);
            });
        }

        return toast;
    }

    /* ── HTML-escape helper ─────────────────────────────────── */
    function _escape(str) {
        const d = document.createElement('div');
        d.appendChild(document.createTextNode(String(str)));
        return d.innerHTML;
    }

    /* ── Public API ─────────────────────────────────────────── */
    const SabayaToast = {
        show,
        success(message, title) { return show(message, 'success', title); },
        error(message, title) { return show(message, 'error',   title); }
    };

    /* ── Auto-fire flash messages injected by PHP ───────────── */
    document.addEventListener('DOMContentLoaded', () => {
        const container = document.getElementById(CONTAINER_ID);
        if (!container) return;

        const msg   = container.getAttribute('data-flash-message');
        const type  = container.getAttribute('data-flash-type')  || 'success';
        const title = container.getAttribute('data-flash-title') || '';

        if (msg) {
            SabayaToast.show(msg, type, title || undefined);
            /* Clean attributes so refreshing the page doesn't re-fire */
            container.removeAttribute('data-flash-message');
            container.removeAttribute('data-flash-type');
            container.removeAttribute('data-flash-title');
        }
    });

    /* ── Expose globally ────────────────────────────────────── */
    global.SabayaToast = SabayaToast;

}(window));
