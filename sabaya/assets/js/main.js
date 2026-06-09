// main.js - site-wide JS

document.addEventListener('DOMContentLoaded', function () {
    // Mobile nav toggle
    var navToggle = document.querySelector('.nav-toggle');
    var mobileNav = document.querySelector('#mobile-nav');

    if (navToggle && mobileNav) {
        navToggle.addEventListener('click', function () {
            var expanded = navToggle.getAttribute('aria-expanded') === 'true';
            navToggle.setAttribute('aria-expanded', String(!expanded));
            mobileNav.classList.toggle('active');
        });
    }

    // Close nav when clicking a link (mobile)
    if (mobileNav) {
        mobileNav.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
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