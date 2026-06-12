// main.js - site-wide JS

document.addEventListener('DOMContentLoaded', () => {
    // Mobile nav toggle
    const navToggle = document.querySelector('.nav-toggle');
    const mobileNav = document.querySelector('#mobile-nav');

    if (navToggle && mobileNav) {
        navToggle.addEventListener('click', () => {
            const expanded = navToggle.getAttribute('aria-expanded') === 'true';
            navToggle.setAttribute('aria-expanded', String(!expanded));
            mobileNav.classList.toggle('active');
        });
    }

    // Close nav when clicking a link (mobile)
    if (mobileNav) {
        mobileNav.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => {
                mobileNav.classList.remove('active');
                if (navToggle) {
                    navToggle.setAttribute('aria-expanded', 'false');
                }
            });
        });
    }
});
document.addEventListener('DOMContentLoaded', () => {

    const reveals = document.querySelectorAll('.reveal');

    const revealOnScroll = () => {

        reveals.forEach(element => {

            const elementTop = element.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;

            if (elementTop < windowHeight - 100) {
                element.classList.add('active');
            }

        });

    };

    revealOnScroll();

    window.addEventListener('scroll', revealOnScroll);

});