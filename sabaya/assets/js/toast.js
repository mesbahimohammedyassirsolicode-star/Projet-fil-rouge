

(function (global) {
    'use strict';

    /* ── Configuration ─────────────────────────────────────── */
    var DURATION     = 3000; // ms — matches CSS @keyframes toast-progress
    var FADE_DELAY   = 400;  // ms — matches CSS toast-fade-out duration
    var CONTAINER_ID = 'toast-container';

    var ICONS = {
        success: '<i class="fas fa-check" aria-hidden="true"></i>',
        error:   '<i class="fas fa-times" aria-hidden="true"></i>'
    };

    var LABELS = {
        success: 'Succès',
        error:   'Erreur'
    };

    /* ── Get / create container ─────────────────────────────── */
    function getContainer() {
        var el = document.getElementById(CONTAINER_ID);
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
        setTimeout(function () {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, FADE_DELAY);
    }

    /* ── Show a toast ───────────────────────────────────────── */
    function show(message, type, title) {
        type  = (type === 'error') ? 'error' : 'success';
        title = title || LABELS[type];

        var container = getContainer();

        /* Build element */
        var toast = document.createElement('div');
        toast.className  = 'toast toast--' + type;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-atomic', 'true');
        toast.setAttribute('tabindex', '0');

        toast.innerHTML  =
            '<div class="toast__icon">' + ICONS[type] + '</div>' +
            '<div class="toast__body">' +
                '<span class="toast__title">' + _escape(title) + '</span>' +
                '<span class="toast__message">' + _escape(message) + '</span>' +
            '</div>' +
            '<button class="toast__close" aria-label="Fermer la notification">&#x2715;</button>' +
            '<div class="toast__progress" aria-hidden="true"></div>';

        container.appendChild(toast);

        /* Auto-dismiss after DURATION */
        var timerId = setTimeout(function () {
            dismiss(toast, timerId);
        }, DURATION);

        /* Click anywhere on toast to dismiss */
        toast.addEventListener('click', function () {
            dismiss(toast, timerId);
        });

        /* Keyboard dismiss — Enter or Escape while focused */
        toast.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === 'Escape') {
                dismiss(toast, timerId);
            }
        });

        /* Close button (stop click bubbling already handled above) */
        var closeBtn = toast.querySelector('.toast__close');
        if (closeBtn) {
            closeBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                dismiss(toast, timerId);
            });
        }

        return toast;
    }

    /* ── HTML-escape helper ─────────────────────────────────── */
    function _escape(str) {
        var d = document.createElement('div');
        d.appendChild(document.createTextNode(String(str)));
        return d.innerHTML;
    }

    /* ── Public API ─────────────────────────────────────────── */
    var SabayaToast = {
        show: show,
        success: function (message, title) { return show(message, 'success', title); },
        error:   function (message, title) { return show(message, 'error',   title); }
    };

    /* ── Auto-fire flash messages injected by PHP ───────────── */
    document.addEventListener('DOMContentLoaded', function () {
        var container = document.getElementById(CONTAINER_ID);
        if (!container) return;

        var msg   = container.getAttribute('data-flash-message');
        var type  = container.getAttribute('data-flash-type')  || 'success';
        var title = container.getAttribute('data-flash-title') || '';

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
