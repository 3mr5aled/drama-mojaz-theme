document.addEventListener('DOMContentLoaded', function () {
    // Search Functionality
    const searchBtn = document.getElementById('headerSearchBtn');
    const mobileSearchBtn = document.getElementById('mobileSearchBtn');
    const mobileSearch = document.getElementById('mobileSearch');
    const closeSearch = document.getElementById('closeSearch');
    const searchInput = document.getElementById('searchInputField');

    function openSearch(e) {
        if (e) e.preventDefault();
        if (mobileSearch) {
            mobileSearch.classList.add('active');
            mobileSearch.classList.remove('hidden');
        }
        // Focus after transition
        setTimeout(() => {
            if (searchInput) searchInput.focus();
        }, 100);
    }

    function closeSearchPanel() {
        if (mobileSearch) {
            mobileSearch.classList.remove('active');
            setTimeout(() => {
                mobileSearch.classList.add('hidden');
            }, 300);
        }
    }

    if (searchBtn) searchBtn.addEventListener('click', openSearch);
    if (mobileSearchBtn) mobileSearchBtn.addEventListener('click', openSearch);
    if (closeSearch) closeSearch.addEventListener('click', closeSearchPanel);

    if (mobileSearch) {
        mobileSearch.addEventListener('click', function (e) {
            if (e.target === this || e.target.id === 'mobileSearchOverlay') {
                closeSearchPanel();
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && mobileSearch.classList.contains('active')) {
                closeSearchPanel();
            }
        });
    }

    // Breaking News Ticker
    const tickerTrack = document.querySelector('.ticker-track');
    const tickerContainer = document.querySelector('.ticker-container');
    const pauseBtn = document.querySelector('.ticker-pause-btn');

    if (tickerTrack && tickerContainer) {
        let isPlaying = true;
        let speed = parseInt(tickerContainer.getAttribute('data-ticker-speed') || '60');
        let hoverPause = false;

        if (speed) {
            tickerTrack.style.setProperty('--ticker-speed', speed + 's');
        }

        if (pauseBtn) {
            pauseBtn.addEventListener('click', function (e) {
                e.preventDefault();
                isPlaying = !isPlaying;
                tickerTrack.style.animationPlayState = isPlaying ? 'running' : 'paused';
                pauseBtn.innerHTML = isPlaying ? '<i class="ri-pause-mini-line text-lg"></i>' : '<i class="ri-play-mini-line text-lg"></i>';
                pauseBtn.setAttribute('aria-label', isPlaying ? 'إيقاف' : 'تشغيل');
            });
        }

        if (hoverPause) {
            tickerContainer.addEventListener('mouseenter', function () {
                tickerTrack.style.animationPlayState = 'paused';
            });

            tickerContainer.addEventListener('mouseleave', function () {
                if (isPlaying) {
                    tickerTrack.style.animationPlayState = 'running';
                }
            });
        }

        const tickerItems = document.querySelectorAll('.ticker-item');
        tickerItems.forEach(item => {
            if (item.getAttribute('href')) {
                item.style.cursor = 'pointer';
                item.addEventListener('click', function (e) {
                    if (e.button === 0) {
                        window.location.href = this.getAttribute('href');
                    }
                });
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.code === 'Space' && e.target === document.body) {
                if (pauseBtn) {
                    e.preventDefault();
                    pauseBtn.click();
                }
            }
        });
    }

    // Notifications & User Menu
    const notificationsBtn = document.getElementById('headerNotificationsBtn');
    const notificationsDropdown = document.getElementById('headerNotificationsDropdown');
    const notificationsList = document.getElementById('notificationsList');
    const notificationCountBadge = document.getElementById('notificationCountBadge');
    const notificationCountText = document.getElementById('notificationCountText');
    const userMenuBtn = document.getElementById('headerUserBtn');
    const userMenu = document.querySelector('.account-menu'); // Using class for consistency

    const ajaxUrl = sports_news_params.ajax_url; // Assuming localized

    if (notificationsBtn && notificationsDropdown) {
        notificationsBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            const isVisible = notificationsDropdown.classList.contains('opacity-100');

            if (isVisible) {
                notificationsDropdown.classList.remove('opacity-100', 'visible');
                notificationsDropdown.classList.add('opacity-0', 'invisible');
            } else {
                notificationsDropdown.classList.remove('opacity-0', 'invisible');
                notificationsDropdown.classList.add('opacity-100', 'visible');
            }
        });
    }

    if (userMenuBtn && userMenu) {
        userMenuBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            e.preventDefault();
            const group = userMenuBtn.closest('.group');
            if (group) {
                // If using the hover implementation, we might not need toggle, 
                // but if we want click support on mobile/desktop:
                group.classList.toggle('clicked');
            }
        });
    }

    document.addEventListener('click', function (e) {
        if (notificationsBtn && notificationsDropdown && !notificationsBtn.contains(e.target) && !notificationsDropdown.contains(e.target)) {
            notificationsDropdown.classList.remove('opacity-100', 'visible');
            notificationsDropdown.classList.add('opacity-0', 'invisible');
        }
    });

    // Mobile Menu
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    const mobileMenuPanel = document.getElementById('mobileMenuPanel');
    const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
    const closeMenuBtn = document.getElementById('closeMenu');

    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            mobileMenu.classList.remove('hidden');
            setTimeout(() => {
                mobileMenu.classList.add('active');
            }, 10);
            document.body.style.overflow = 'hidden';
        });
    }

    const closeMobileMenu = function () {
        if (mobileMenu) {
            mobileMenu.classList.remove('active');
            document.body.style.overflow = '';
            setTimeout(() => {
                if (!mobileMenu.classList.contains('active')) {
                    mobileMenu.classList.add('hidden');
                }
            }, 500);
        }
    };

    if (closeMenuBtn) closeMenuBtn.addEventListener('click', closeMobileMenu);
    if (mobileMenuOverlay) mobileMenuOverlay.addEventListener('click', closeMobileMenu);

    // Submenu click support for mobile
    const menuItemsWithChildren = document.querySelectorAll('.menu-item-has-children > a');
    menuItemsWithChildren.forEach(item => {
        item.addEventListener('click', function (e) {
            if (window.innerWidth < 992) {
                e.preventDefault();
                this.parentElement.classList.toggle('hover');
            }
        });
    });
});
