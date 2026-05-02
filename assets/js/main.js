// Optimize JavaScript loading with immediate execution after DOM is ready
(function () {
    'use strict';

    // Use requestIdleCallback for non-critical operations
    function runWhenIdle(callback) {
        if ('requestIdleCallback' in window) {
            requestIdleCallback(callback);
        } else if ('setTimeout' in window) {
            setTimeout(callback, 1);
        } else {
            callback();
        }
    }

    // Debounce function to limit execution frequency
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Throttle function to limit execution frequency
    function throttle(func, limit) {
        let inThrottle;
        return function () {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        }
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeApp);
    } else {
        initializeApp();
    }

    function initializeApp() {
        // ============================================
        // Header Dropdowns Setup
        // ============================================

        // Defined from header.php
        const notificationsBtn = document.getElementById('headerNotificationsBtn');
        const notificationsDropdown = document.getElementById('headerNotificationsDropdown');
        const userMenuBtn = document.getElementById('headerUserBtn');
        const userMenu = document.getElementById('headerUserMenu');

        // Mobile Menu Toggle - Direct targeting for better feel
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        const closeMenu = document.getElementById('closeMenu');
        const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');

        // Combined Dropdown and Menu Logic
        if (notificationsBtn && notificationsDropdown) {
            notificationsBtn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                notificationsDropdown.classList.toggle('show');
                if (userMenu) userMenu.classList.remove('show');
            });
        }

        // Account menu functionality moved to header.php to avoid conflicts

        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.remove('hidden');
                // Close any other open menus first
                if (mobileSearch) mobileSearch.classList.add('hidden');

                setTimeout(() => {
                    mobileMenu.classList.add('active');
                    document.body.style.overflow = 'hidden';
                    // Focus first focusable element in menu
                    const firstFocusable = mobileMenu.querySelector('a, button, input');
                    if (firstFocusable) firstFocusable.focus();
                }, 10);
            });
        }

        const closeMobileMenu = () => {
            if (mobileMenu) {
                mobileMenu.classList.remove('active');
                document.body.style.overflow = '';
                setTimeout(() => {
                    mobileMenu.classList.add('hidden');
                    // Return focus to menu button
                    if (mobileMenuBtn) mobileMenuBtn.focus();
                }, 500);
            }
        };

        if (closeMenu) closeMenu.addEventListener('click', closeMobileMenu);
        if (mobileMenuOverlay) mobileMenuOverlay.addEventListener('click', closeMobileMenu);

        // Mobile Submenu Toggling
        if (mobileMenu) {
            mobileMenu.addEventListener('click', (e) => {
                const toggleBtn = e.target.closest('.submenu-toggle');
                if (toggleBtn) {
                    e.preventDefault();
                    e.stopPropagation();
                    const parentItem = toggleBtn.closest('.mobile-nav-item');
                    const subMenu = parentItem.querySelector('.mobile-sub-menu');
                    const icon = toggleBtn.querySelector('i');

                    if (subMenu) {
                        const isHidden = subMenu.classList.contains('hidden');
                        if (isHidden) {
                            subMenu.classList.remove('hidden');
                            subMenu.classList.add('flex');
                            icon.classList.replace('ri-add-line', 'ri-subtract-line');
                            icon.style.transform = 'rotate(180deg)';
                        } else {
                            subMenu.classList.add('hidden');
                            subMenu.classList.remove('flex');
                            icon.classList.replace('ri-subtract-line', 'ri-add-line');
                            icon.style.transform = 'rotate(0deg)';
                        }
                    }
                }
            });
        }

        // Mobile Search Toggle
        const mobileSearchBtn = document.getElementById('mobileSearchBtn');
        const mobileSearch = document.getElementById('mobileSearch');
        const closeSearch = document.getElementById('closeSearch');
        const mobileSearchOverlay = document.getElementById('mobileSearchOverlay');

        if (mobileSearchBtn && mobileSearch) {
            mobileSearchBtn.addEventListener('click', () => {
                mobileSearch.classList.remove('hidden');
                // Close menu if open
                if (mobileMenu) closeMobileMenu();

                setTimeout(() => {
                    mobileSearch.classList.add('active');
                    const input = mobileSearch.querySelector('input');
                    if (input) input.focus();
                }, 10);
            });
        }

        const closeMobileSearch = () => {
            if (mobileSearch) {
                mobileSearch.classList.remove('active');
                setTimeout(() => mobileSearch.classList.add('hidden'), 500);
            }
        };

        if (closeSearch) closeSearch.addEventListener('click', closeMobileSearch);
        if (mobileSearchOverlay) mobileSearchOverlay.addEventListener('click', closeMobileSearch);

        // Global click to close dropdowns
        document.addEventListener('click', (e) => {
            if (notificationsDropdown && !notificationsBtn.contains(e.target) && !notificationsDropdown.contains(e.target)) {
                notificationsDropdown.classList.remove('show');
            }
            if (userMenu && !userMenuBtn.contains(e.target) && !userMenu.contains(e.target)) {
                userMenu.classList.remove('show');
            }
        });

        // Optimize for mobile touch events
        if ('ontouchstart' in window || navigator.maxTouchPoints) {
            // Add touch target optimization
            runWhenIdle(function () {
                const touchTargets = document.querySelectorAll('a, button, input');
                touchTargets.forEach(target => {
                    if (!target.classList.contains('touch-target')) {
                        target.classList.add('touch-target');
                    }
                });

                // Optimize for mobile scrolling
                document.body.style.overflowX = 'hidden';
            });
        }

        // Lazy load images for mobile performance
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                            img.removeAttribute('data-src');
                            // Remove from observer to improve performance
                            observer.unobserve(img);
                        }
                        // Preload next image if available
                        if (img.dataset.srcset) {
                            img.srcset = img.dataset.srcset;
                            img.removeAttribute('data-srcset');
                        }
                    }
                });
            }, {
                // Only observe in viewport + 100px buffer
                rootMargin: '100px 0px 100px 0px'
            });

            // Observe all images with data-src attribute
            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }

        // Match Filtering Logic - Use event delegation with reflow optimization
        document.addEventListener('click', function (e) {
            const btn = e.target.closest('[id$="Btn"]');
            if (btn && btn.id in {
                'allMatchesBtn': 1,
                'footballBtn': 1,
                'basketballBtn': 1
            }) {
                const matchFilters = {
                    'allMatchesBtn': 'match-item',
                    'footballBtn': 'match-football',
                    'basketballBtn': 'match-basketball'
                };

                // Batch DOM operations to minimize reflows
                const buttons = document.querySelectorAll('[id$="Btn"]');
                buttons.forEach(b => {
                    b.classList.remove('bg-primary', 'text-white');
                    b.classList.add('bg-white', 'border', 'border-gray-200', 'hover:bg-gray-50');
                });

                btn.classList.add('bg-primary', 'text-white');
                btn.classList.remove('bg-white', 'border', 'border-gray-200', 'hover:bg-gray-50');

                // Filter items with optimized reflow handling
                const filterClass = matchFilters[btn.id];
                const items = document.querySelectorAll('.match-item');

                // Create document fragment to batch DOM changes
                const fragment = document.createDocumentFragment();

                items.forEach(item => {
                    if (filterClass === 'match-item' || item.classList.contains(filterClass)) {
                        item.classList.remove('hidden');
                    } else {
                        item.classList.add('hidden');
                    }
                    fragment.appendChild(item);
                });

                // Apply all changes at once to minimize reflows
                document.querySelector('.matches-container')?.appendChild(fragment);
            }
        });

        // Header Match Schedule Tabs/Slider
        (function initHeaderMatchesStrip() {
            const strip = document.querySelector('.dm-matches-strip');
            if (!strip) return;

            const tabs = strip.querySelectorAll('.dm-matches-tab');
            const panels = strip.querySelectorAll('.dm-matches-panel');
            const arrows = strip.querySelectorAll('.dm-matches-arrow');

            const activateTab = (tabKey) => {
                tabs.forEach((tab) => {
                    const isActive = tab.dataset.tab === tabKey;
                    tab.classList.toggle('is-active', isActive);
                    tab.setAttribute('aria-selected', isActive ? 'true' : 'false');
                });

                panels.forEach((panel) => {
                    panel.classList.toggle('is-active', panel.dataset.panel === tabKey);
                });
            };

            tabs.forEach((tab) => {
                tab.addEventListener('click', () => activateTab(tab.dataset.tab));
            });

            arrows.forEach((arrow) => {
                arrow.addEventListener('click', () => {
                    const activePanel = strip.querySelector('.dm-matches-panel.is-active .dm-matches-track');
                    if (!activePanel) return;
                    const card = activePanel.querySelector('.dm-match-card');
                    const step = card ? card.getBoundingClientRect().width + 12 : 300;
                    
                    // In RTL, "next" arrow (left pointing) needs to scroll into the negative direction.  
                    // `dir="rtl"` reverses the scroll axis.
                    const direction = arrow.dataset.dir === 'next' ? -1 : 1;
                    activePanel.scrollBy({ left: direction * step, behavior: 'smooth' });
                });
            });
        })();

        // News Tabs Logic - Use event delegation
        document.addEventListener('click', function (e) {
            const tabBtn = e.target.closest('.tab-btn');
            if (tabBtn) {
                const tabBtns = document.querySelectorAll('.tab-btn');
                tabBtns.forEach(b => {
                    b.classList.remove('bg-primary', 'text-white', 'shadow-xl', 'shadow-primary/20', 'active');
                    b.classList.add('text-gray-400', 'hover:bg-gray-50');
                });
                tabBtn.classList.add('bg-primary', 'text-white', 'shadow-xl', 'shadow-primary/20', 'active');
                tabBtn.classList.remove('text-gray-400', 'hover:bg-gray-50');

                // Switch content
                const targetTab = tabBtn.dataset.tab;
                document.querySelectorAll('.news-tab-content').forEach(content => {
                    if (content.id === `tab-${targetTab}`) {
                        content.classList.remove('hidden');
                    } else {
                        content.classList.add('hidden');
                    }
                });
            }
        });

        // Admin Login Modal
        document.addEventListener('click', function (e) {
            if (e.target.closest('#closeLoginModal')) {
                const adminLoginModal = document.getElementById('adminLoginModal');
                if (adminLoginModal) adminLoginModal.classList.add('hidden');
            } else if (e.target.closest('[onclick*="showAdminLoginModal"]')) {
                const adminLoginModal = document.getElementById('adminLoginModal');
                if (adminLoginModal) adminLoginModal.classList.remove('hidden');
            }
        });

        window.showAdminLoginModal = function () {
            const adminLoginModal = document.getElementById('adminLoginModal');
            if (adminLoginModal) adminLoginModal.classList.remove('hidden');
        };

        // Load More Stories Button - Handle each tab separately
        document.addEventListener('click', function (e) {
            const loadMoreBtn = e.target.closest('.load-more-stories-btn');
            if (loadMoreBtn) {
                handleLoadMore(loadMoreBtn);
            }
        });

        // Load More Posts Button for Advanced Tabs - Handle each tab separately
        document.addEventListener('click', function (e) {
            const loadMoreBtn = e.target.closest('.load-more-posts-btn');
            if (loadMoreBtn) {
                handleLoadMore(loadMoreBtn);
            }
        });

        // Generic function to handle load more functionality for any tab
        function handleLoadMore(button) {
            // First, let's identify which tab container this button belongs to
            // Look for the closest tab content container
            let tabContent = button.closest('.news-tab-content');

            // If button is not inside a specific tab content, we need to determine the active tab
            if (!tabContent) {
                // Try to find which tab is currently active
                const activeTab = document.querySelector('.tab-btn.active');
                if (activeTab && activeTab.dataset.tab) {
                    const activeTabId = activeTab.dataset.tab;
                    tabContent = document.getElementById(`tab-${activeTabId}`);
                } else {
                    // As fallback, check if button has data attributes specifying the tab
                    const tabTypeFromButton = button.getAttribute('data-tab-type');
                    if (tabTypeFromButton) {
                        tabContent = document.getElementById(`tab-${tabTypeFromButton}`);
                    }
                }
            }

            // Get tab type and category
            let tabType = 'latest';
            let category = '';

            if (tabContent && tabContent.id) {
                // Extract tab type from container ID (e.g., 'tab-latest' -> 'latest')
                tabType = tabContent.id.replace('tab-', '');
                // Get category from the tab content's data attribute
                category = tabContent.getAttribute('data-category') || tabContent.getAttribute('data-cat-id') || '';
            }

            // Get current page and posts per page from button's data attributes
            const currentPage = parseInt(button.getAttribute('data-current-page') || button.getAttribute('data-page') || '1');
            const postsPerPage = parseInt(button.getAttribute('data-posts-per-page') || '6');
            const nextPage = currentPage + 1;

            // Show loading state
            button.disabled = true;
            button.classList.add('opacity-70', 'cursor-not-allowed');
            const originalText = button.textContent;
            button.textContent = 'جاري التحميل...';

            // Send AJAX request
            const xhr = new XMLHttpRequest();
            xhr.open('POST', ajax_object.ajax_url, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        try {
                            const response = JSON.parse(xhr.responseText);

                            if (response.success && response.html) {
                                // Append new posts to the appropriate container
                                if (tabContent) {
                                    tabContent.insertAdjacentHTML('beforeend', response.html);
                                }

                                // Update page number on button
                                button.setAttribute('data-current-page', nextPage);
                                button.setAttribute('data-page', nextPage);

                                // Hide button if no more posts
                                if (!response.has_more) {
                                    button.style.display = 'none';
                                }
                            } else {
                                console.error('Error loading more posts:', response);
                                // Even if there's an error, check if we should hide the button based on response
                                if (response && response.hasOwnProperty('has_more') && response.has_more === false) {
                                    button.style.display = 'none';
                                }
                            }
                        } catch (e) {
                            console.error('Error parsing response:', e);
                            console.log('Raw response:', xhr.responseText);
                        }
                    } else {
                        console.error('AJAX request failed:', xhr.status, xhr.statusText);
                    }

                    // Always restore button state
                    button.disabled = false;
                    button.classList.remove('opacity-70', 'cursor-not-allowed');
                    button.textContent = originalText;
                }
            };

            // Send request with necessary data
            const requestData = 'action=load_more_stories' +
                '&page=' + nextPage +
                '&posts_per_page=' + postsPerPage +
                '&category=' + encodeURIComponent(category) +
                '&tab_type=' + encodeURIComponent(tabType) +
                '&nonce=' + encodeURIComponent(ajax_object.nonce);

            xhr.send(requestData);
        }

        // League Dropdown (if exists in index.php)
        document.addEventListener('click', function (e) {
            const btn = document.getElementById('leagueDropdownBtn');
            const menu = document.getElementById('leagueDropdown');
            if (btn && menu) {
                if (btn.contains(e.target)) {
                    menu.classList.toggle('hidden');
                } else if (!menu.contains(e.target)) {
                    menu.classList.add('hidden');
                }
            }
        });

        // ============================================
        // Enhanced Breaking News Ticker System
        // ============================================
        class BreakingNewsTicker {
            constructor(container) {
                this.container = container;
                this.track = container.querySelector('.ticker-track');
                this.pauseBtn = container.querySelector('.ticker-pause-btn');
                this.isManuallyPaused = false;
                this.isHovering = false;
                this.animationFrameId = null;
                this.position = 0;
                this.speed = parseFloat(container.dataset.tickerSpeed) || 60;

                if (this.track && this.pauseBtn) {
                    this.init();
                }
            }

            init() {
                // Setup pause button
                this.pauseBtn.addEventListener('click', (e) => this.togglePause(e));

                // Enhance ticker items with accessibility
                this.setupTickerItems();

                // Start animation
                this.updateState();
            }

            setupTickerItems() {
                const items = this.track.querySelectorAll('.ticker-item');
                items.forEach((item, index) => {
                    item.setAttribute('role', 'link');
                    item.setAttribute('tabindex', index === 0 ? '0' : '-1');

                    // Add click analytics
                    item.addEventListener('click', (e) => {
                        this.trackNewsClick(item.textContent, item.href);
                    });

                    // Add keyboard navigation
                    item.addEventListener('keydown', (e) => {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            item.click();
                        }
                    });
                });
            }

            togglePause(e) {
                e.preventDefault();
                this.isManuallyPaused = !this.isManuallyPaused;

                // Update button state
                if (this.isManuallyPaused) {
                    this.pauseBtn.classList.add('active');
                    this.pauseBtn.setAttribute('aria-label', 'تشغيل');
                    this.pauseBtn.innerHTML = '<i class="ri-play-mini-line text-lg"></i>';
                } else {
                    this.pauseBtn.classList.remove('active');
                    this.pauseBtn.setAttribute('aria-label', 'إيقاف');
                    this.pauseBtn.innerHTML = '<i class="ri-pause-mini-line text-lg"></i>';
                }

                this.updateState();
            }

            updateState() {
                if (this.isManuallyPaused) {
                    this.container.classList.add('paused');
                    this.track.style.animationPlayState = 'paused';
                } else {
                    this.container.classList.remove('paused');
                    this.track.style.animationPlayState = 'running';
                }
            }

            trackNewsClick(title, url) {
                // Track click in analytics if available
                if (window.gtag) {
                    gtag('event', 'breaking_news_click', {
                        'news_title': title,
                        'news_url': url
                    });
                }
            }
        }

        // Initialize enhanced ticker
        const tickerContainer = document.querySelector('.ticker-container');
        if (tickerContainer) {
            new BreakingNewsTicker(tickerContainer);
        }

        // Legacy ticker support (for backward compatibility)
        function initNewsTicker() {
            const ticker = document.querySelector('.ticker');
            if (!ticker) return;

            // Clone ticker content for seamless loop
            const tickerContent = ticker.innerHTML;
            ticker.innerHTML = tickerContent + tickerContent;

            // Calculate animation duration based on content width
            const tickerWidth = ticker.scrollWidth / 2;
            const duration = Math.max(tickerWidth / 50, 10); // Minimum 10s duration
            ticker.style.animationDuration = duration + 's';

            // Start animation
            ticker.style.animationPlayState = 'running';
        }

        // Initialize legacy ticker after a short delay
        setTimeout(initNewsTicker, 100);



        // ============================================
        // Header Sticky Enhancement
        // ============================================
        const mainHeader = document.querySelector('.main-header');
        if (mainHeader && mainHeader.classList.contains('sticky')) {
            let lastScrollTop = 0;
            let scrollTimeout;

            window.addEventListener('scroll', () => {
                clearTimeout(scrollTimeout);

                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

                if (scrollTop > 50) {
                    mainHeader.classList.add('sticky');
                } else {
                    mainHeader.classList.remove('sticky');
                }

                lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
            }, { passive: true });
        }

        // ============================================
        window.addEventListener('resize', throttle(function () {
            // Only run resize operations when necessary
            const videoPlayers = document.querySelectorAll('.main-video-player:not(.hidden)');
            if (videoPlayers.length > 0) {
                // Add resize-specific logic here if needed
            }
        }, 250)); // Throttle resize events to max once every 250ms

        // ============================================
        // Video Player Switching
        // ============================================
        document.addEventListener('click', function (e) {
            const videoItem = e.target.closest('.video-item');
            if (videoItem) {
                const videoIndex = videoItem.getAttribute('data-video-index');
                if (!videoIndex) return;

                const videoItems = document.querySelectorAll('.video-item');
                // Remove active class from all items
                videoItems.forEach(v => {
                    v.classList.remove('bg-white/10');
                    v.classList.add('hover:bg-white/5');
                });

                // Add active class to clicked item
                videoItem.classList.add('bg-white/10');
                videoItem.classList.remove('hover:bg-white/5');

                // Get current visible player to pause it
                const currentPlayer = document.querySelector('.main-video-player:not(.hidden)');
                if (currentPlayer) {
                    // Pause iframe (YouTube/Vimeo)
                    const iframe = currentPlayer.querySelector('iframe');
                    if (iframe) {
                        const currentSrc = iframe.src;
                        iframe.src = '';
                        iframe.src = currentSrc;
                    }
                    // Pause HTML5 video
                    const video = currentPlayer.querySelector('video');
                    if (video) {
                        video.pause();
                    }
                    currentPlayer.classList.add('hidden');
                }

                // Show selected player
                const selectedPlayer = document.querySelector(`[data-player-index="${videoIndex}"]`);
                if (selectedPlayer) {
                    selectedPlayer.classList.remove('hidden');

                    // Play selected video if it's an iframe
                    const iframe = selectedPlayer.querySelector('iframe');
                    if (iframe) {
                        const iframeSrc = iframe.src;
                        iframe.src = iframeSrc; // Reload to ensure play (if autoplay is restricted)
                    }

                    // Play selected HTML5 video
                    const videoElement = selectedPlayer.querySelector('video');
                    if (videoElement) {
                        videoElement.load();
                        videoElement.play().catch(e => console.log('Autoplay prevented:', e));
                    }

                    // Smooth scroll to player on mobile
                    if (window.innerWidth < 1024) {
                        selectedPlayer.scrollIntoView({
                            behavior: 'smooth',
                            block: 'nearest'
                        });
                    }
                }
            }
        });

        // ============================================
        // Reading Progress Bar
        // ============================================
        const progressBar = document.getElementById('readingProgress');
        if (progressBar && document.body.classList.contains('single-post')) {
            const articleContent = document.querySelector('.post-content-style');
            if (articleContent) {
                window.addEventListener('scroll', throttle(function () {
                    const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
                    const height = articleContent.offsetHeight;
                    const offset = articleContent.offsetTop;
                    const scrolled = ((winScroll - offset) / (height - window.innerHeight + offset)) * 100;

                    if (winScroll > offset) {
                        progressBar.style.width = Math.min(scrolled, 100) + "%";
                    } else {
                        progressBar.style.width = "0%";
                    }
                }, 20), { passive: true });
            }
        }

        // ============================================
        // Reading Mode Controls
        // ============================================
        const readingTools = {
            'fontSizePlus': () => sports_news_change_font_size(1),
            'fontSizeMinus': () => sports_news_change_font_size(-1),
            'readingModeLight': () => sports_news_set_reading_mode('light'),
            'readingModeDark': () => sports_news_set_reading_mode('dark'),
            'readingModeSepia': () => sports_news_set_reading_mode('sepia')
        };

        document.addEventListener('click', function (e) {
            const toolBtn = e.target.closest('[id^="reading"]');
            if (toolBtn && toolBtn.id in readingTools) {
                readingTools[toolBtn.id]();
            }
        });

        function sports_news_change_font_size(step) {
            const content = document.querySelector('.post-content-style');
            if (!content) return;
            const style = window.getComputedStyle(content, null).getPropertyValue('font-size');
            const currentSize = parseFloat(style);
            content.style.fontSize = (currentSize + step) + 'px';
        }

        function sports_news_set_reading_mode(mode) {
            const body = document.body;
            body.classList.remove('reading-mode-light', 'reading-mode-dark', 'reading-mode-sepia');
            body.classList.add('reading-mode-' + mode);
            localStorage.setItem('sports_news_reading_mode', mode);
        }

        // Initialize reading mode from localStorage
        const savedMode = localStorage.getItem('sports_news_reading_mode');
        if (savedMode) sports_news_set_reading_mode(savedMode);

        // ============================================
        // Header Interactions
        // ============================================

        // All main interactions have been handled above
        // Script initialized successfully
        console.log('Website initialized with all features enabled');
    }
})();
