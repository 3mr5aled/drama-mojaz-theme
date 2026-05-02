/**
 * Font preconnect optimization for mobile performance
 */
(function() {
    'use strict';
    
    // Preconnect to external font domains for faster loading
    function addPreconnectLinks() {
        // Create and add preconnect link for Google Fonts
        const googleFontsPreconnect = document.createElement('link');
        googleFontsPreconnect.rel = 'preconnect';
        googleFontsPreconnect.href = 'https://fonts.googleapis.com';
        document.head.appendChild(googleFontsPreconnect);
        
        const googleFontsPreconnect2 = document.createElement('link');
        googleFontsPreconnect2.rel = 'preconnect';
        googleFontsPreconnect2.href = 'https://fonts.gstatic.com';
        googleFontsPreconnect2.crossOrigin = 'anonymous';
        document.head.appendChild(googleFontsPreconnect2);
        
        // Create and add preconnect link for CDN
        const cdnPreconnect = document.createElement('link');
        cdnPreconnect.rel = 'preconnect';
        cdnPreconnect.href = 'https://cdnjs.cloudflare.com';
        document.head.appendChild(cdnPreconnect);
    }
    
    // Add preconnect links when DOM is loaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', addPreconnectLinks);
    } else {
        addPreconnectLinks();
    }
})();