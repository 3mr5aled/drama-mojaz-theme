/**
 * Footer Scripts
 */
(function () {
    'use strict';

    const initFooterScripts = function () {
        const closeLogin = document.getElementById('closeLoginModal');
        const loginModal = document.getElementById('adminLoginModal');
        const backToTopButton = document.getElementById('backToTopButton');
        const floatingSeeAlso = document.getElementById('floatingSeeAlso');
        const floatingSeeAlsoClose = document.getElementById('floatingSeeAlsoClose');

        if (closeLogin && loginModal) {
            closeLogin.addEventListener('click', function () {
                loginModal.classList.add('hidden');
            });
        }

        if (backToTopButton) {
            const toggleBackToTopButton = function () {
                if (window.pageYOffset > 300) {
                    backToTopButton.classList.add('is-visible');
                    backToTopButton.classList.add('show');
                } else {
                    backToTopButton.classList.remove('is-visible');
                    backToTopButton.classList.remove('show');
                }
            };

            toggleBackToTopButton();
            window.addEventListener('scroll', toggleBackToTopButton, { passive: true });

            backToTopButton.addEventListener('click', function () {
                const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                window.scrollTo({
                    top: 0,
                    behavior: prefersReducedMotion ? 'auto' : 'smooth'
                });
            });
        }

        if (floatingSeeAlso) {
            floatingSeeAlso.classList.add('is-visible');

            if (floatingSeeAlsoClose) {
                floatingSeeAlsoClose.addEventListener('click', function () {
                    floatingSeeAlso.classList.remove('is-visible');
                    floatingSeeAlso.classList.add('is-closed');
                });
            }
        }
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initFooterScripts);
    } else {
        initFooterScripts();
    }
})();
