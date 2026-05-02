<?php
/**
 * Sports News Theme Functions
 *
 * @package Drama_Mojaz_Theme
 * @since 1.0.0
 *
 * Copyright (c) 2024 Drama Mojaz. All rights reserved.
 * 
 * Drama Mojaz Theme is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * Drama Mojaz Theme is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Drama Mojaz Theme.  If not, see <http://www.gnu.org/licenses/>.
 */

if (!defined('ABSPATH')) exit;

// Load Redux Framework Configuration
if (file_exists(get_template_directory() . '/inc/redux-config.php')) {
    require_once get_template_directory() . '/inc/redux-config.php';
}

// Load Redux Helper Functions
if (file_exists(get_template_directory() . '/inc/redux-helpers.php')) {
    require_once get_template_directory() . '/inc/redux-helpers.php';
}

// Load Notification System
if (file_exists(get_template_directory() . '/inc/notifications.php')) {
    require_once get_template_directory() . '/inc/notifications.php';
}

// Load Menu Icons Management
if (file_exists(get_template_directory() . '/inc/nav-menus.php')) {
    require_once get_template_directory() . '/inc/nav-menus.php';
}

// Load Shortcodes
if (file_exists(get_template_directory() . '/inc/shortcodes.php')) {
    require_once get_template_directory() . '/inc/shortcodes.php';
}

// Load Custom Widgets
if (file_exists(get_template_directory() . '/inc/widgets.php')) {
    require_once get_template_directory() . '/inc/widgets.php';
}


function sports_news_get_opt($key, $default = '') {
    global $sports_news_opt;
    
    // If Redux options are not loaded, try to get them directly from the database
    if (!isset($sports_news_opt) || empty($sports_news_opt)) {
        // Use direct database query to avoid potential hooks recursion
        global $wpdb;
        $option_value = $wpdb->get_var($wpdb->prepare("SELECT option_value FROM {$wpdb->options} WHERE option_name = %s LIMIT 1", 'sports_news_opt'));
        if ($option_value !== null) {
            $sports_news_opt = maybe_unserialize($option_value);
        } else {
            $sports_news_opt = array();
        }
    }
    
    if (isset($sports_news_opt[$key])) {
        // Redux media fields return an array
        if (is_array($sports_news_opt[$key]) && isset($sports_news_opt[$key]['url'])) {
            return $sports_news_opt[$key]['url'];
        }
        // Handle boolean values properly
        if ($sports_news_opt[$key] === '0' || $sports_news_opt[$key] === 0 || $sports_news_opt[$key] === false || $sports_news_opt[$key] === 'false') {
            return false;
        }
        return $sports_news_opt[$key];
    }
    
    return $default;
}

function sports_news_setup() {
    load_theme_textdomain('drama-mojaz-theme', get_template_directory() . '/languages');

    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('automatic-feed-links');
    
    // Elementor compatibility
    add_theme_support('elementor');
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
    
    register_nav_menus(array(
        'primary' => 'القائمة الرئيسية',
        'top_bar' => 'قائمة الشريط العلوي',
        'footer' => 'قائمة الفوتر',
        'footer_secondary' => 'قائمة الفوتر الثانوية',
        'footer_third' => 'قائمة الفوتر الثالثة'
    ));

    // Register editor style
    add_editor_style('assets/css/editor-style.css');
}


add_action('after_setup_theme', 'sports_news_setup');

function colorize_title_words($title) {
    $colored_words = get_option('colored_words', '');
    if (!empty($colored_words)) {
        $words_to_color = explode(',', $colored_words);
        foreach ($words_to_color as $word) {
            $word = trim($word);
            if (!empty($word)) {
                $title = str_replace($word, '<span class="text-red-500">' . $word . '</span>', $title);
            }
        }
    }
    return $title;
}
add_filter('the_title', 'colorize_title_words');

// Add resource hints for better performance
function sports_news_resource_hints($urls, $relation_type) {
    if ($relation_type === 'preconnect') {
        $urls[] = 'https://cdnjs.cloudflare.com';
        $urls[] = 'https://pagead2.googlesyndication.com'; // For AdSense
        $urls[] = 'https://googleads.g.doubleclick.net'; // For AdSense
    }
    if ($relation_type === 'dns-prefetch') {
        $urls[] = 'https://www.google-analytics.com';
        $urls[] = 'https://www.googletagmanager.com';
    }
    return $urls;
}
add_filter('wp_resource_hints', 'sports_news_resource_hints', 10, 2);

// Add critical CSS inline for faster rendering
function sports_news_add_critical_css() {
    $critical_css_file = get_template_directory() . '/assets/css/critical.css';
    if (file_exists($critical_css_file)) {
        $critical_css = file_get_contents($critical_css_file);
        // Minify CSS slightly
        $critical_css = preg_replace('/\s+/', ' ', $critical_css);
        $critical_css = preg_replace('/\s*{\s*/', '{', $critical_css);
        $critical_css = preg_replace('/\s*}\s*/', '}', $critical_css);
        $critical_css = preg_replace('/;\s*/', ';', $critical_css);
        $critical_css = trim($critical_css);
        
        echo '<style id="critical-css">' . $critical_css . '</style>';
    }
}
add_action('wp_head', 'sports_news_add_critical_css', 1);

// Optimize images
function sports_news_optimize_images() {
    // Enable WebP support
    add_filter('wp_image_editors', 'sports_news_prefer_webp_editor');
    
    // Optimize image quality
    add_filter('jpeg_quality', function($quality) {
        return 80; // Optimal quality for web
    });
    
    // Add WebP support
    add_action('wp_enqueue_scripts', function() {
        wp_add_inline_script('jquery', '
        // Detect WebP support
        function supportsWebP() {
            return !![].map && document.createElement("canvas").toDataURL("image/webp").indexOf("data:image/webp") == 0;
        }
        
        if (supportsWebP()) {
            document.documentElement.classList.add("webp");
        } else {
            document.documentElement.classList.add("no-webp");
        }
        ');
    });
}

function sports_news_prefer_webp_editor($editors) {
    array_unshift($editors, 'WP_Image_Editor_Imagick');
    return $editors;
}

// Add image lazy loading attributes
function sports_news_add_image_lazy_loading($content) {
    // Add loading="lazy" and decoding="async" safely without duplicating the <img tag.
    $content = preg_replace('/<img\b(?![^>]*\bloading=)/i', '<img loading="lazy"', $content);
    $content = preg_replace('/<img\b(?![^>]*\bdecoding=)/i', '<img decoding="async"', $content);
    
    // Remove loading="lazy" from images in the header (above the fold content)
    if (is_front_page() || is_home()) {
        // For critical images on front page, we may want to eager load them
        $content = preg_replace('/<img[^>]*loading="lazy"[^>]*class="[^>]*header[^>]*"[^>]*>/i', '$0', $content);
    }
    
    return $content;
}


add_filter('the_content', 'sports_news_add_image_lazy_loading', 20);
add_filter('post_thumbnail_html', 'sports_news_add_image_lazy_loading', 20);
add_filter('widget_text', 'sports_news_add_image_lazy_loading', 20);

// Add image dimensions to prevent layout shift - Optimized
function sports_news_add_image_dimensions($content) {
    // Add explicit width and height to images to prevent layout shift
    // We avoid attachment_url_to_postid as it is too heavy
    $content = preg_replace_callback('/<img[^>]*src=[\"\']([^\"\']*)[^>]*>/i', function($matches) {
        $img_tag = $matches[0];
        $src = $matches[1];
        
        // Check if width/height already exist
        if (strpos($img_tag, 'width=') !== false && strpos($img_tag, 'height=') !== false) {
            return $img_tag;
        }
        
        // Instead of DB query, use standard aspect ratios or check if it's a known size
        // If we really need exact dimensions, we should rely on WP's native filters which run earlier
        
        // Add default dimensions if completely missing to prevent massive CLS
        if (strpos($img_tag, 'width=') === false && strpos($img_tag, 'height=') === false) {
             // Fallback to a common aspect ratio (16:9) to Reserve Space
             $img_tag = str_replace('<img', '<img width="600" height="338" style="height:auto;aspect-ratio:16/9;"', $img_tag);
        }
        
        return $img_tag;
    }, $content);
    
    return $content;
}

// Add image dimension filter
add_filter('the_content', 'sports_news_add_image_dimensions', 19); // Run before lazy loading
add_filter('post_thumbnail_html', 'sports_news_add_image_dimensions', 19);

// Add WebP support for images
function sports_news_add_webp_support($sources, $size_array, $image_src, $image_meta, $attachment_id) {
    if (!is_array($image_meta) || empty($image_meta['sizes'])) {
        return $sources;
    }
    
    $upload_dir = wp_get_upload_dir();
    $upload_baseurl = $upload_dir['baseurl'];
    
    foreach ($sources as $key => $source) {
        $file_path = parse_url($source['url'], PHP_URL_PATH);
        $file_path = str_replace($upload_baseurl, $upload_dir['basedir'], $file_path);
        
        // Check if WebP version exists
        $webp_path = preg_replace('/\.[^.]+$/','',$file_path) . '.webp';
        if (file_exists($webp_path)) {
            $webp_url = preg_replace('/\.[^.]+$/','',$source['url']) . '.webp';
            $sources[$key . '-webp'] = array(
                'url' => $webp_url,
                'descriptor' => $source['descriptor'],
                'value' => $source['value'],
            );
        }
    }
    
    return $sources;
}


add_filter('wp_calculate_image_srcset', 'sports_news_add_webp_support', 10, 5);



// Optimize image sizes
function sports_news_image_sizes() {
    // Add custom image sizes for different contexts
    add_image_size('sports_news_featured', 800, 450, true); // Featured posts
    add_image_size('sports_news_thumbnail', 300, 200, true); // Thumbnails
    add_image_size('sports_news_hero', 1200, 600, true); // Hero images
    
    // Set the default image size
    update_option('image_default_size', 'large');
}

// Add srcset attributes for responsive images
function sports_news_responsive_images($attr, $attachment) {
    // Add sizes attribute for responsive images
    if (empty($attr['sizes'])) {
        $attr['sizes'] = '(max-width: 768px) 100vw, (max-width: 1024px) 50vw, 33vw';
    }
    return $attr;
}

// Initialize image optimizations
add_action('after_setup_theme', 'sports_news_optimize_images');
add_action('after_setup_theme', 'sports_news_image_sizes');
add_filter('wp_get_attachment_image_attributes', 'sports_news_responsive_images', 10, 2);

// Preload LCP Image
// Calculate LCP Image early (on 'wp' hook) to avoid WP_Query in wp_head
function sports_news_calculate_lcp_image() {
    global $sports_news_lcp_url;
    $sports_news_lcp_url = '';
    
    // For Single Posts: Preload Featured Image
    if (is_single() && has_post_thumbnail()) {
        $sports_news_lcp_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
    } 
    // For Homepage: Preload Hero Image
    elseif (is_front_page() || is_home()) {
        if (function_exists('sports_news_get_opt') && sports_news_get_opt('show_hero', true) !== false) {
            $hero_category = sports_news_get_opt('hero_category', '');
            $args = array(
                'posts_per_page' => 1,
                'no_found_rows' => true,
                'ignore_sticky_posts' => false
            );
            
            if (!empty($hero_category)) {
                $args['cat'] = $hero_category;
            }
            
            // Run the query safely here, outside of wp_head
            $hero_query = new WP_Query($args);
            
            if ($hero_query->have_posts()) {
                while ($hero_query->have_posts()) {
                    $hero_query->the_post();
                    if (has_post_thumbnail()) {
                        $sports_news_lcp_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
                    }
                }
                wp_reset_postdata();
            }
        }
    }
}
add_action('wp', 'sports_news_calculate_lcp_image');

// Output the preload link in wp_head
function sports_news_preload_lcp_image() {
    global $sports_news_lcp_url;
    if (!empty($sports_news_lcp_url)) {
        echo '<link rel="preload" as="image" href="' . esc_url($sports_news_lcp_url) . '">' . "\n";
    }
}
add_action('wp_head', 'sports_news_preload_lcp_image', 5);


function sports_news_scripts() {
    // Get theme version for cache busting
    $theme_version = wp_get_theme()->get('Version') ?: '1.0.0';
    
    // Critical CSS - Load first
    wp_enqueue_style('sports-news-fonts', get_template_directory_uri() . '/assets/css/fonts.css', array(), $theme_version);
    wp_enqueue_style('sports-news-style', get_stylesheet_uri(), array(), $theme_version);
    wp_enqueue_style('sports-news-main', get_template_directory_uri() . '/assets/css/main.css', array('sports-news-style'), $theme_version);
    // Static utilities layer (compiled CSS) to preserve layout without requiring Tailwind tooling at runtime.
    wp_enqueue_style('sports-news-utilities', get_template_directory_uri() . '/assets/css/style.min.css', array('sports-news-main'), $theme_version);
    
    // Theme Style (CSS Replacement for Tailwind)
    wp_enqueue_style('theme-style', get_template_directory_uri() . '/assets/css/tailwind-replacement.css', array('sports-news-utilities'), $theme_version);

    wp_enqueue_style('sports-news-custom-design', get_template_directory_uri() . '/assets/css/custom-design.css', array('theme-style'), $theme_version);
    wp_enqueue_style('sports-news-custom-styles', get_template_directory_uri() . '/assets/css/custom-styles.css', array('theme-style'), $theme_version);

    
    // Enhanced Breaking News Ticker CSS
    wp_enqueue_style('sports-news-ticker', get_template_directory_uri() . '/assets/css/ticker.css', array('sports-news-main'), $theme_version);
    
    // Stories Viewer CSS
    wp_enqueue_style('sports-news-stories', get_template_directory_uri() . '/assets/css/stories-viewer.css', array('sports-news-main'), $theme_version);
    
    // Dynamic Colors CSS
    wp_enqueue_style('sports-news-colors', get_template_directory_uri() . '/assets/css/dynamic-colors.css', array('sports-news-main'), $theme_version);
    
    // Theme Scripts
    wp_enqueue_script('sports-news-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), $theme_version, true);
    // Localize script to pass AJAX URL to JavaScript
    wp_localize_script('sports-news-main', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('load_more_stories_nonce')
    ));
    wp_enqueue_script('sports-news-stories', get_template_directory_uri() . '/assets/js/stories-viewer.js', array('jquery'), $theme_version, true);

    // Footer Assets
    wp_enqueue_style('sports-news-footer', get_template_directory_uri() . '/assets/css/footer.css', array('sports-news-main'), $theme_version);
    wp_enqueue_script('sports-news-footer', get_template_directory_uri() . '/assets/js/footer.js', array('jquery'), $theme_version, true);

    // Header Assets - Load last to override all other styles
    wp_enqueue_style('sports-news-header', get_template_directory_uri() . '/assets/css/header.css', array('sports-news-custom-styles'), $theme_version);
    wp_enqueue_script('sports-news-header', get_template_directory_uri() . '/assets/js/header.js', array('jquery'), $theme_version, true);
    
    // Localize ajax_url for header.js
    wp_localize_script('sports-news-header', 'sports_news_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('sports_news_nonce')
    ));
    // Check for theme style option
    $theme_style = sports_news_get_opt('theme_style', 'default');
    
    // Enqueue speed theme CSS if selected
    if ($theme_style === 'speed') {
        wp_enqueue_style('speed-theme', get_template_directory_uri() . '/assets/css/speed-theme.css', array('sports-news-colors'), $theme_version);
    }
    
    // Inject dynamic colors from Redux options
    $primary = sports_news_get_opt('primary_color', '#E31B23');
    $secondary = sports_news_get_opt('secondary_color', '#000000');
    $primary_rgb = implode(', ', sscanf($primary, "#%02x%02x%02x"));
    $secondary_rgb = implode(', ', sscanf($secondary, "#%02x%02x%02x"));
    
    // Header and Footer colors
    $header_bg = sports_news_get_opt('header_bg_color', '#ffffff');
    $header_text = sports_news_get_opt('header_text_color', '#000000');
    $header_top_bar_bg = sports_news_get_opt('header_top_bar_bg', '#f8f9fa');
    $footer_bg = sports_news_get_opt('footer_bg_color', '#1a1a1a');
    $footer_text = sports_news_get_opt('footer_text_color', '#ffffff');
    $footer_heading = sports_news_get_opt('footer_heading_color', '#ffffff');
    $footer_bottom_bg = sports_news_get_opt('footer_bottom_bg', '#000000');
    
    $dynamic_css = ":root{--primary:{$primary};--primary-rgb:{$primary_rgb};--secondary:{$secondary};--secondary-rgb:{$secondary_rgb};--primary-50:rgba({$primary_rgb},0.05);--primary-10:rgba({$primary_rgb},0.1);--primary-20:rgba({$primary_rgb},0.2);--primary-90:rgba({$primary_rgb},0.9);--header-bg:{$header_bg};--header-text:{$header_text};--header-top-bar-bg:{$header_top_bar_bg};--footer-bg:{$footer_bg};--footer-text:{$footer_text};--footer-heading:{$footer_heading};--footer-bottom-bg:{$footer_bottom_bg};}";
    
    // Apply top-bar colors
    $dynamic_css .= ".top-bar{background-color:var(--header-top-bar-bg) !important;color:var(--header-bg) !important;}";
    $dynamic_css .= ".top-bar a,.top-bar span,.top-bar i{color:var(--header-bg) !important;}";
    
    // Apply main header colors
    $dynamic_css .= ".main-header{background-color:var(--header-bg) !important;color:var(--header-text) !important;}";
    $dynamic_css .= ".main-header a,.main-header button,.main-header i{color:var(--header-text) !important;}";
    
    // Apply nav-bar colors (menu-menu-header)
    $dynamic_css .= ".nav-bar{background-color:var(--header-bg) !important;}";
    $dynamic_css .= ".nav-bar .nav-menu,.nav-bar .nav-menu a,.nav-bar .nav-menu li{color:var(--header-text) !important;}";
    $dynamic_css .= ".nav-bar .menu-item a{color:var(--header-text) !important;}";
    
    // Apply footer-wrapper colors
    $dynamic_css .= ".footer-wrapper{background-color:var(--footer-bg) !important;color:var(--footer-text) !important;}";
    $dynamic_css .= ".footer-wrapper a{color:var(--footer-text) !important;}";
    $dynamic_css .= ".footer-wrapper h1,.footer-wrapper h2,.footer-wrapper h3,.footer-wrapper h4,.footer-wrapper h5,.footer-wrapper h6{color:var(--footer-heading) !important;}";
    $dynamic_css .= ".footer-wrapper .footer-section-title{color:var(--footer-heading) !important;}";

    
    wp_add_inline_style('sports-news-colors', $dynamic_css);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'sports_news_scripts');

// Inline Critical CSS

function sports_news_deferred_styles() {
        $template_dir = get_template_directory_uri();
        
        // Preload non-critical CSS
        echo '<link rel="preload" href="' . $template_dir . '/assets/css/tablet.css" as="style" onload="this.onload=null;this.rel=\'stylesheet\';" media="(min-width: 768px) and (max-width: 1023px)" />';
        echo '<link rel="preload" href="' . $template_dir . '/assets/css/mobile.css" as="style" onload="this.onload=null;this.rel=\'stylesheet\';" media="(max-width: 1023px)" />';
        
        // Preload Remix Icons (CDN)
        echo '<link rel="preload" href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" as="style" onload="this.onload=null;this.rel=\'stylesheet\';" />';
        
        // Fallback for older browsers
        echo '<noscript>';
        echo '<link rel="stylesheet" href="' . $template_dir . '/assets/css/tablet.css" media="(min-width: 768px) and (max-width: 1023px)" />';
        echo '<link rel="stylesheet" href="' . $template_dir . '/assets/css/mobile.css" media="(max-width: 1023px)" />';
        echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" />';
        echo '</noscript>';
}
add_action('wp_head', 'sports_news_deferred_styles', 100);
// Tailwind stylesheet loading removed.
// Theme styling now relies on main.css + tailwind-replacement.css + custom styles.

// Elementor compatibility functions
function elementor_theme_support() {
    add_theme_support('elementor');
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
    add_theme_support('custom-header');
    add_theme_support('custom-background');
}
add_action('after_setup_theme', 'elementor_theme_support');



// Rank Math SEO compatibility
function rank_math_seo_compatibility() {
    // Ensure Rank Math is properly integrated
    if (!class_exists('RankMath\\Pro\\Pro')) {
        // Add theme support for Rank Math if not using Pro version
        if (class_exists('RankMath') || defined('RANK_MATH_VERSION')) {
            // Add any specific theme compatibility for Rank Math
            add_filter('rank_math/frontend/remove_credit', '__return_true');
        }
    }
    
    // If Rank Math is active, ensure theme doesn't add conflicting meta tags
    if (class_exists('RankMath') || defined('RANK_MATH_VERSION')) {
        // Remove the theme's custom SEO meta function to prevent conflicts
        // remove_action('wp_head', 'sports_news_seo_meta', 1);
    }
}
add_action('after_setup_theme', 'rank_math_seo_compatibility');

// Optimized WordPress clean up and SEO compatibility
function sports_news_cleanup_and_seo() {
    // Remove persistent WordPress version
    // remove_action('wp_head', 'wp_generator');
    
    // Remove unnecessary header links
    // remove_action('wp_head', 'rsd_link');
    // remove_action('wp_head', 'wlwmanifest_link');
    // remove_action('wp_head', 'index_rel_link');
    // remove_action('wp_head', 'parent_post_rel_link', 10, 0);
    // remove_action('wp_head', 'start_post_rel_link', 10, 0);
    // remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    // remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
    
    // Disable emojis (optional, but good for performance)
    // remove_action('wp_head', 'print_emoji_detection_script', 7);
    // remove_action('wp_print_styles', 'print_emoji_styles');
    add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
    add_filter('wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2);
    
    // Rank Math specific compatibility
    // Rank Math handles canonicals and other SEO tags, so we ensure WP doesn't duplicate them
    if (class_exists('RankMath') || defined('RANK_MATH_VERSION')) {
        // remove_action('wp_head', 'rel_canonical');
        // remove_action('wp_head', 'wp_oembed_add_discovery_links');
    }
}
add_action('init', 'sports_news_cleanup_and_seo');

// Helper to disable emojis in TinyMCE
function disable_emojis_tinymce($plugins) {
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    }
    return array();
}

// Helper to remove emoji DNS prefetch
function disable_emojis_remove_dns_prefetch($urls, $relation_type) {
    if ('dns-prefetch' == $relation_type) {
        $emoji_svg_url = 'https://s.w.org/images/core/emoji/';
        $urls = array_diff($urls, array($emoji_svg_url));
    }
    return $urls;
}

// Site Kit by Google compatibility
function sitekit_theme_compatibility() {
    // Add theme support for Site Kit features
    add_theme_support('google-site-kit');
    
    // Ensure proper integration with Site Kit
    if (class_exists('Google\\Site_Kit\\Plugin')) {
        // Add filters to enhance compatibility
        add_filter('googlesitekit_show_admin_bar_menu', '__return_true');
        add_filter('googlesitekit_auto_calculate_adsense_estimated_revenue', '__return_true');
    }
}
add_action('after_setup_theme', 'sitekit_theme_compatibility');

// Allow Site Kit to manage meta tags
function sitekit_manage_meta_tags() {
    if (class_exists('Google\\Site_Kit\\Plugin')) {
        // Only remove theme SEO meta if Rank Math is not active
        // If Rank Math is active, it should handle SEO instead
        if (!class_exists('RankMath')) {
            // Ensure Site Kit can manage meta tags properly
            // remove_action('wp_head', 'sports_news_seo_meta', 1);
        }
        
        // Add compatibility for Schema markup if enabled in theme
        if (sports_news_get_opt('enable_schema', true)) {
            add_filter('googlesitekit_amp_schema_org_object', function($data) {
                // Enhance schema data with theme-specific properties
                return $data;
            });
        }
    }
}
add_action('init', 'sitekit_manage_meta_tags');

// Google AdSense Integration
function google_adsense_setup() {
    if (sports_news_get_opt('adsense_enabled', false)) {
        // Add AdSense publisher ID to header if available
        add_action('wp_head', 'google_adsense_header_code', 1);
        
        // If using auto ads, add the script
        if (sports_news_get_opt('adsense_auto_ads', true)) {
            add_action('wp_head', 'google_adsense_auto_script', 2);
        }
    }
}
add_action('after_setup_theme', 'google_adsense_setup');

function google_adsense_header_code() {
    $publisher_id = sports_news_get_opt('adsense_publisher_id', '');
    if (!empty($publisher_id)) {
        echo '<meta name="google-adsense-platform-account" content="' . esc_attr($publisher_id) . '">
';
        // Add Google AdSense verification meta tag
        echo '<meta name="google-site-verification" content="ads-' . esc_attr($publisher_id) . '">
';
    }
}

function google_adsense_auto_script() {
    $publisher_id = sports_news_get_opt('adsense_publisher_id', '');
    $custom_code = sports_news_get_opt('adsense_ad_code', '');
    
    if (!empty($custom_code)) {
        // Use custom AdSense code if provided
        echo '<!-- Google AdSense Custom Code -->
';
        echo $custom_code . "\n";
    } elseif (!empty($publisher_id)) {
        // Use default auto ads implementation
        echo '<!-- Google AdSense Auto Ads -->
';
        echo '<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=' . esc_attr($publisher_id) . '" crossorigin="anonymous"></script>\n';
        echo '<!-- Enable page-level ads -->
';
        echo '<script>(adsbygoogle = window.adsbygoogle || []).push({google_ad_client: "' . esc_attr($publisher_id) . '", enable_page_level_ads: true});</script>\n';
    }
}

// Function to display AdSense ad units in theme
function display_adsense_ad($slot_id, $ad_style = '') {
    $publisher_id = sports_news_get_opt('adsense_publisher_id', '');
    if (sports_news_get_opt('adsense_enabled', false) && !empty($publisher_id)) {
        $ad_code = '<div class="adsense-unit">
';
        $ad_code .= '<ins class="adsbygoogle"
';
        $ad_code .= '     style="display:block; ' . esc_attr($ad_style) . '"
';
        $ad_code .= '     data-ad-client="' . esc_attr($publisher_id) . '"
';
        $ad_code .= '     data-ad-slot="' . esc_attr($slot_id) . '">
';
        $ad_code .= '</ins>
';
        $ad_code .= '<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
';
        $ad_code .= '</div>';
        
        return $ad_code;
    }
    return '';
}

class Sports_News_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = array()) {
        if ($depth === 0) {
            // Level 1: Main Dropdown Box
            $output .= '<ul class="sub-menu absolute top-full right-0 mt-4 w-56 bg-white border border-gray-100 rounded-2xl shadow-[0_15px_45px_rgba(0,0,0,0.1)] py-3 flex flex-col opacity-0 translate-y-4 invisible group-hover:opacity-100 group-hover:translate-y-0 group-hover:visible transition-all duration-300 z-[100] border-t-2 border-t-primary group-[.hover]/main:opacity-100 group-[.hover]/main:translate-y-0 group-[.hover]/main:visible">';
        } else {
            // Level 2+: Nested Accordion (Dropdown inside the box)
            $output .= '<ul class="sub-menu flex flex-col pr-0 max-h-0 overflow-hidden group-hover:max-h-96 opacity-0 group-hover:opacity-100 transition-all duration-500 ease-in-out bg-gray-50/50 rounded-xl mt-1 mx-2 group-[.hover]:max-h-96 group-[.hover]:opacity-100 group-[.expanded]:max-h-96 group-[.expanded]:opacity-100">';
        }
    }

    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $is_active = in_array('current-menu-item', $classes) || in_array('current-menu-ancestor', $classes);
        $has_children = in_array('menu-item-has-children', $classes);

        if ($depth === 0) {
            $output .= '<li class="relative group h-20 flex items-center group/main ' . implode(' ', $classes) . '">';
            $active_class = $is_active ? 'text-primary' : 'text-secondary';
            $output .= '<a href="' . $item->url . '" class="kufi font-bold text-[13px] ' . $active_class . ' hover:text-primary transition-all px-4 h-10 flex items-center rounded-xl hover:bg-gray-50 relative group/link">';
            $output .= $item->title;
            if ($has_children) $output .= '<i class="ri-arrow-down-s-line mr-1 text-gray-400 group-hover:text-primary transition-colors"></i>';
            if ($is_active) {
                $output .= '<span class="absolute bottom-0 left-4 right-4 h-1 bg-primary rounded-t-full shadow-[0_-4px_10px_rgba(227,27,35,0.3)]"></span>';
            } else {
                $output .= '<span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-1 bg-primary rounded-t-full transition-all duration-300 group-hover:w-[calc(100%-32px)]"></span>';
            }
            $output .= '</a>';
        } else {
            $active_class = $is_active ? 'text-primary bg-primary/10' : 'text-gray-700';
            
            // Re-apply 'group' class and ensure menu classes are present for JS targeting
            $output .= '<li class="px-2 py-0.5 ' . ($has_children ? 'group menu-item-has-children' : '') . ' ' . implode(' ', $classes) . '">';
            $output .= '<a href="' . $item->url . '" class="kufi text-[15px] font-bold ' . $active_class . ' hover:bg-primary/5 hover:text-primary px-4 py-3 rounded-xl block transition-all flex items-center justify-between group/sublink relative">';
            
            if ($has_children) {
                 $output .= '<span class="relative z-10">' . $item->title . '</span>';
                 $output .= '<i class="ri-arrow-down-s-line text-[18px] opacity-40 transition-transform group-hover:rotate-180 group-[.hover]:rotate-180"></i>';
            } else {
                 $output .= '<span class="relative z-10 w-full text-center">' . $item->title . '</span>';
            }
            $output .= '</a>';
        }
    }

    function end_el(&$output, $item, $depth = 0, $args = array()) {
        $output .= '</li>';
    }
}

/**
 * Premium Comment Callback
 */
function sports_news_comment_callback($comment, $args, $depth) {
    $tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
    ?>
    <<?php echo $tag; ?> <?php comment_class( empty( $args['has_children'] ) ? 'mb-10 last:mb-0' : 'mb-6' ); ?> id="comment-<?php comment_ID(); ?>">
        <div class="flex gap-4 relative">
            <!-- Visual Thread Line for nested comments -->
            <?php if ($depth > 1) : ?>
                <div class="absolute -right-6 top-0 bottom-0 w-px bg-gray-200"></div>
            <?php endif; ?>

            <div class="flex-shrink-0 relative z-10">
                <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl overflow-hidden shadow-sm border-2 border-white ring-1 ring-gray-100">
                    <?php echo get_avatar($comment, 56, '', '', array('class' => 'w-full h-full object-cover')); ?>
                </div>
            </div>

            <div class="flex-grow group">
                <div class="bg-white rounded-2xl p-5 md:p-6 shadow-sm border border-gray-100 hover:border-primary/20 hover:shadow-md transition-all duration-300 relative">
                    <!-- Approved Badge -->
                    <?php if ($comment->user_id == get_the_author_meta('ID')) : ?>
                        <span class="absolute top-4 left-4 bg-primary/10 text-primary text-[9px] font-black px-2 py-0.5 rounded-md kufi uppercase">الكاتب</span>
                    <?php endif; ?>

                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <span class="block font-bold kufi text-gray-900 text-sm md:text-base mb-1"><?php comment_author(); ?></span>
                            <div class="flex items-center gap-2 text-[10px] text-gray-400">
                                <i class="ri-history-line"></i>
                                <span><?php printf('%1$s في %2$s', get_comment_date(), get_comment_time()); ?></span>
                            </div>
                        </div>
                        <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                            <?php
                            comment_reply_link(array_merge($args, array(
                                'reply_text' => '<i class="ri-reply-fill ml-1"></i> رد',
                                'depth'      => $depth,
                                'max_depth'  => $args['max_depth'],
                                'before'     => '<span class="text-xs font-bold text-primary kufi flex items-center bg-primary/5 px-3 py-1 rounded-lg hover:bg-primary hover:text-white transition-all">',
                                'after'      => '</span>'
                            )));
                            ?>
                        </div>
                    </div>

                    <?php if ($comment->comment_approved == '0') : ?>
                        <div class="flex items-center gap-2 bg-orange-50 text-orange-600 px-3 py-2 rounded-lg text-[10px] kufi mb-4">
                            <i class="ri-error-warning-line"></i>
                            <em>تعليقك في انتظار المراجعة حالياً.</em>
                        </div>
                    <?php endif; ?>

                    <div class="text-gray-700 leading-relaxed text-sm md:text-base post-content-style">
                        <?php comment_text(); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php
}

class Sports_News_Walker_Mobile_Nav_Menu extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = array()) {
        $output .= '<ul class="mobile-sub-menu hidden flex-col gap-2 pr-4 py-2 bg-gray-50/50 rounded-xl mt-1">';
    }

    function end_lvl(&$output, $depth = 0, $args = array()) {
        $output .= '</ul>';
    }

    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $is_active = in_array('current-menu-item', $classes) || in_array('current-menu-ancestor', $classes);
        $has_children = in_array('menu-item-has-children', $classes);

        $output .= '<li class="mobile-nav-item ' . ($has_children ? 'menu-item-has-children' : '') . ' border-b border-gray-50 last:border-0">';
        
        $active_class = $is_active ? 'text-primary' : 'text-secondary';
        $output .= '<a href="' . $item->url . '" class="kufi font-black text-base ' . $active_class . ' py-4 flex items-center justify-between group">';
        $output .= '<span>' . $item->title . '</span>';
        
        if ($has_children) {
            $output .= '<button class="submenu-toggle p-2 -ml-2 text-gray-400 hover:text-primary transition-all" aria-label="Toggle Submenu">';
            $output .= '<i class="ri-add-line text-lg transition-transform duration-300"></i>';
            $output .= '</button>';
        } else {
            $output .= '<i class="ri-arrow-left-s-line text-gray-200 group-hover:text-primary transition-all"></i>';
        }
        
        $output .= '</a>';
    }

    function end_el(&$output, $item, $depth = 0, $args = array()) {
        $output .= '</li>';
    }
}

class Sports_News_Walker_Footer_Nav_Menu extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        $output .= '<li><a href="' . $item->url . '" class="text-gray-400 hover:text-white transition-colors">' . $item->title . '</a></li>';
    }
}

// Add custom body class
function sports_news_body_classes($classes) {
    // Check for theme style option and add speed theme class if selected
    $theme_style = sports_news_get_opt('theme_style', 'default');
    if ($theme_style === 'speed') {
        $classes[] = 'speed-theme';
    }
    return $classes;
}
add_filter('body_class', 'sports_news_body_classes');

/**
 * Custom Login Page Helpers
 */
function sports_news_get_login_page_url($args = array()) {
    $defaults = array(
        'redirect_to' => home_url('/'),
    );
    $args = wp_parse_args($args, $defaults);

    // حاول العثور على صفحة تستخدم قالب "page-login.php"
    $login_page = get_pages(array(
        'meta_key'   => '_wp_page_template',
        'meta_value' => 'page-login.php',
        'number'     => 1,
    ));

    // إذا لم يتم العثور على الصفحة باستخدام القالب، حاول البحث باستخدام_slug
    if (empty($login_page)) {
        $login_page = get_page_by_path('login'); // البحث عن صفحة باسم login
        if (!$login_page) {
            // البحث عن صفحة باسم تسجيل-الدخول (الترجمة العربية)
            $login_page = get_page_by_path('تسجيل-الدخول');
        }
    }

    if (!empty($login_page) && !is_wp_error($login_page)) {
        // التأكد من أن $login_page هو مصفوفة أو كائن
        if (is_object($login_page)) {
            $url = get_permalink($login_page->ID);
        } else {
            $url = get_permalink($login_page[0]->ID);
        }
    } else {
        // احتياطي: wp-login.php
        $url = wp_login_url();
    }

    if (!empty($args['redirect_to'])) {
        $url = add_query_arg('redirect_to', rawurlencode($args['redirect_to']), $url);
    }

    return $url;
}

// Hook to create login page on theme activation
function sports_news_create_login_page() {
    global $wpdb;
    
    // Check if login page already exists
    $login_page = get_page_by_path('login');
    
    if (!$login_page) {
        $login_page = get_page_by_path('تسجيل-الدخول');
    }
    
    if (!$login_page) {
        // Check for page with the template
        $pages = get_pages(array(
            'meta_key'   => '_wp_page_template',
            'meta_value' => 'page-login.php',
            'number'     => 1,
        ));
        
        if (empty($pages)) {
            // Create the login page if it doesn't exist
            $page_data = array(
                'post_title'     => 'تسجيل الدخول',
                'post_content'   => 'صفحة تسجيل الدخول المخصصة',
                'post_status'    => 'publish',
                'post_type'      => 'page',
                'post_author'    => 1,
                'post_name'      => 'login',
            );
            
            $page_id = wp_insert_post($page_data);
            
            if ($page_id) {
                // Assign the login template to the page
                update_post_meta($page_id, '_wp_page_template', 'page-login.php');
                
                // Flush rewrite rules to make the page accessible
                flush_rewrite_rules();
            }
        } else {
            // If page exists but doesn't have the correct template, set it
            $page_id = $pages[0]->ID;
            $current_template = get_post_meta($page_id, '_wp_page_template', true);
            if ($current_template !== 'page-login.php') {
                update_post_meta($page_id, '_wp_page_template', 'page-login.php');
                flush_rewrite_rules();
            }
        }
    } else {
        // If page exists but doesn't have the correct template, set it
        $page_id = $login_page->ID;
        $current_template = get_post_meta($page_id, '_wp_page_template', true);
        if ($current_template !== 'page-login.php') {
            update_post_meta($page_id, '_wp_page_template', 'page-login.php');
            flush_rewrite_rules();
        }
    }
}

// Hook into theme setup to create login page
add_action('after_switch_theme', 'sports_news_create_login_page');

// Flush rewrite rules on theme activation to ensure proper page recognition
function sports_news_flush_rewrite_rules() {
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'sports_news_flush_rewrite_rules');

// Also flush rewrite rules when the login page is accessed and not working properly
function sports_news_maybe_flush_rewrite_rules() {
    // Check if we're trying to access a login page but it's not working properly
    if (is_admin() || defined('DOING_AJAX')) {
        return;
    }
    
    // Check if the current page might be intended as a login page
    if (is_page() && (get_the_title() === 'تسجيل الدخول' || get_page_template_slug() === 'page-login.php' || is_page('login'))) {
        // Add a temporary rewrite rule for the login page
        add_action('init', function() {
            add_rewrite_rule('^login/?', 'index.php?pagename=login', 'top');
        }, 999); // Late priority to override other rules
        flush_rewrite_rules();
    }
}
add_action('wp', 'sports_news_maybe_flush_rewrite_rules');

// Redirect default WordPress login to our custom login page
function sports_news_login_url_redirect($login_url, $redirect) {
    $custom_login_page_url = sports_news_get_login_page_url();
    
    // If we have a custom login page, use it instead of default wp-login.php
    if (strpos($custom_login_page_url, 'wp-login.php') === false) {
        if (!empty($redirect)) {
            $login_url = add_query_arg('redirect_to', $redirect, $custom_login_page_url);
        } else {
            $login_url = $custom_login_page_url;
        }
    }
    
    return $login_url;
}
add_filter('login_url', 'sports_news_login_url_redirect', 20, 2);

// Redirect wp-login.php access to our custom login page
function sports_news_redirect_wp_login() {
    $current_url = $_SERVER['REQUEST_URI'];
    
    // Check if we're accessing wp-login.php
    if (strpos($current_url, 'wp-login.php') !== false) {
        // Allow POST requests (login submissions) to process normally
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return;
        }
        
        // Allow logout action to process normally
        if (isset($_GET['action']) && $_GET['action'] === 'logout') {
            return;
        }
        
        // Allow lost password action
        if (isset($_GET['action']) && $_GET['action'] === 'lostpassword') {
            return;
        }
        
        // Allow password reset action
        if (isset($_GET['action']) && $_GET['action'] === 'rp') {
            return;
        }
        
        // Allow confirm action for password reset
        if (isset($_GET['action']) && $_GET['action'] === 'confirmaction') {
            return;
        }
        
        // For all other GET requests to wp-login.php, redirect to custom login page
        $custom_login_url = sports_news_get_login_page_url();
        
        if (!strpos($custom_login_url, 'wp-login.php')) {
            $redirect_to = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : '';
            if (!empty($redirect_to)) {
                $custom_login_url = add_query_arg('redirect_to', $redirect_to, $custom_login_url);
            }
            
            wp_redirect($custom_login_url);
            exit;
        }
    }
}
add_action('init', 'sports_news_redirect_wp_login');

// Handle custom login page redirect if accessed directly
function sports_news_login_page_redirect() {
    // Check if we're on the login page template directly
    if (is_page() && get_page_template_slug(get_the_ID()) === 'page-login.php') {
        // If user is already logged in, redirect to home
        if (is_user_logged_in()) {
            wp_redirect(home_url('/'));
            exit;
        }
    }
}
add_action('template_redirect', 'sports_news_login_page_redirect');

// Ensure proper login form action handling
function sports_news_login_form_defaults($defaults) {
    // Check if we're on our custom login page
    if (is_page_template('page-login.php')) {
        $defaults['redirect'] = isset($_GET['redirect_to']) ? esc_url_raw($_GET['redirect_to']) : home_url('/');
    }
    return $defaults;
}
add_filter('login_form_defaults', 'sports_news_login_form_defaults');

// Handle login errors for custom login page
function sports_news_login_failed($username) {
    // Check if the login failure came from our custom login page
    $referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
    $login_page_url = sports_news_get_login_page_url();
    
    if (strpos($referrer, 'login') !== false || strpos($login_page_url, str_replace(home_url(), '', $referrer)) !== false) {
        $redirect_to = isset($_REQUEST['redirect_to']) ? $_REQUEST['redirect_to'] : home_url('/');
        
        // Validate redirect_to to ensure it's a local URL
        if (!empty($redirect_to) && !wp_http_validate_url($redirect_to)) {
            $redirect_to = home_url('/');
        }
        
        $login_page = sports_news_get_login_page_url();
        
        $redirect_with_error = add_query_arg(array(
            'login' => 'failed',
            'redirect_to' => urlencode($redirect_to)
        ), $login_page);
        
        wp_redirect($redirect_with_error);
        exit;
    }
}
add_action('wp_login_failed', 'sports_news_login_failed');

// Process login redirect for custom login page
function sports_news_login_redirect($redirect_to, $request, $user) {
    // Check if the login came from our custom login page
    if (isset($_SERVER['HTTP_REFERER'])) {
        $referrer = $_SERVER['HTTP_REFERER'];
        $login_page_url = sports_news_get_login_page_url();
        
        if (strpos($referrer, 'login') !== false || strpos($login_page_url, str_replace(home_url(), '', $referrer)) !== false) {
            // Validate redirect_to to ensure it's a local URL
            if (!empty($redirect_to) && !wp_http_validate_url($redirect_to)) {
                $redirect_to = home_url('/');
            }
            
            // If no specific redirect was requested, go to home page
            if (empty($redirect_to) || $redirect_to === admin_url() || strpos($redirect_to, 'wp-admin') !== false) {
                return home_url('/');
            }
        }
    }
    
    return $redirect_to;
}
add_filter('login_redirect', 'sports_news_login_redirect', 10, 3);

// Handle logout redirect to custom login page with logged out message
function sports_news_logout_redirect() {
    // Check if this is a logout action and we're on the login page
    if (isset($_GET['action']) && $_GET['action'] === 'logout') {
        $redirect_to = isset($_REQUEST['redirect_to']) ? $_REQUEST['redirect_to'] : '';
        $login_page_url = sports_news_get_login_page_url();
        
        // Add logged out parameter to indicate successful logout
        $redirect_url = add_query_arg('loggedout', 'true', $login_page_url);
        
        // Add redirect_to if it was specified
        if (!empty($redirect_to)) {
            $redirect_url = add_query_arg('redirect_to', urlencode($redirect_to), $redirect_url);
        }
        
        wp_redirect($redirect_url);
        exit;
    }
}

// Alternative logout handling for when the login_form_logout hook doesn't work
function sports_news_handle_logout() {
    // Check if logout action is being requested directly
    if (isset($_GET['action']) && $_GET['action'] === 'logout') {
        // Verify nonce for security
        $redirect_to = isset($_REQUEST['redirect_to']) ? $_REQUEST['redirect_to'] : '';
        
        // Perform the actual logout
        wp_logout();
        
        $login_page_url = sports_news_get_login_page_url();
        
        // Add logged out parameter to indicate successful logout
        $redirect_url = add_query_arg('loggedout', 'true', $login_page_url);
        
        // Add redirect_to if it was specified
        if (!empty($redirect_to)) {
            $redirect_url = add_query_arg('redirect_to', urlencode($redirect_to), $redirect_url);
        }
        
        wp_redirect($redirect_url);
        exit;
    }
}

// Hook into init action to handle logout before headers are sent
add_action('init', 'sports_news_handle_logout');
add_action('login_form_logout', 'sports_news_logout_redirect');


/**
 * Function to get the forgot password page URL
 */
function sports_news_get_forgot_password_url($args = array()) {
    $defaults = array(
        'redirect_to' => home_url('/'),
    );
    $args = wp_parse_args($args, $defaults);

    // Try to find a page using the "page-forgot-password.php" template
    $forgot_password_page = get_pages(array(
        'meta_key'   => '_wp_page_template',
        'meta_value' => 'page-forgot-password.php',
        'number'     => 1,
    ));

    // If not found using template, try searching by slug
    if (empty($forgot_password_page)) {
        $forgot_password_page = get_page_by_path('forgot-password'); // Search for page named forgot-password
        if (!$forgot_password_page) {
            // Search for page with Arabic name
            $forgot_password_page = get_page_by_path('نسيت-كلمة-المرور');
        }
    }

    if (!empty($forgot_password_page) && !is_wp_error($forgot_password_page)) {
        // Ensure $forgot_password_page is an object
        if (is_object($forgot_password_page)) {
            $url = get_permalink($forgot_password_page->ID);
        } else {
            $url = get_permalink($forgot_password_page[0]->ID);
        }
    } else {
        // Fallback: wp-login.php lostpassword
        $url = wp_lostpassword_url();
    }

    if (!empty($args['redirect_to'])) {
        $url = add_query_arg('redirect_to', rawurlencode($args['redirect_to']), $url);
    }

    return $url;
}

// Hook to create forgot password page on theme activation
function sports_news_create_forgot_password_page() {
    // Check if forgot password page already exists
    $forgot_password_page = get_page_by_path('forgot-password');
    
    if (!$forgot_password_page) {
        $forgot_password_page = get_page_by_path('نسيت-كلمة-المرور');
    }
    
    if (!$forgot_password_page) {
        // Check for page with the template
        $pages = get_pages(array(
            'meta_key'   => '_wp_page_template',
            'meta_value' => 'page-forgot-password.php',
            'number'     => 1,
        ));
        
        if (empty($pages)) {
            // Create the forgot password page if it doesn't exist
            $page_data = array(
                'post_title'     => 'نسيت كلمة المرور',
                'post_content'   => 'صفحة استعادة كلمة المرور المخصصة',
                'post_status'    => 'publish',
                'post_type'      => 'page',
                'post_author'    => 1,
                'post_name'      => 'forgot-password',
            );
            
            $page_id = wp_insert_post($page_data);
            
            if ($page_id) {
                // Assign the forgot password template to the page
                update_post_meta($page_id, '_wp_page_template', 'page-forgot-password.php');
                
                // Flush rewrite rules to make the page accessible
                flush_rewrite_rules();
            }
        } else {
            // If page exists but doesn't have the correct template, set it
            $page_id = $pages[0]->ID;
            $current_template = get_post_meta($page_id, '_wp_page_template', true);
            if ($current_template !== 'page-forgot-password.php') {
                update_post_meta($page_id, '_wp_page_template', 'page-forgot-password.php');
                flush_rewrite_rules();
            }
        }
    } else {
        // If page exists but doesn't have the correct template, set it
        $page_id = $forgot_password_page->ID;
        $current_template = get_post_meta($page_id, '_wp_page_template', true);
        if ($current_template !== 'page-forgot-password.php') {
            update_post_meta($page_id, '_wp_page_template', 'page-forgot-password.php');
            flush_rewrite_rules();
        }
    }
}

// Hook into theme setup to create forgot password page
add_action('after_switch_theme', 'sports_news_create_forgot_password_page');

// Redirect default WordPress lost password to our custom forgot password page
function sports_news_lostpassword_url_redirect($lostpassword_url, $redirect) {
    $custom_forgot_password_page_url = sports_news_get_forgot_password_url();
    
    // If we have a custom forgot password page, use it instead of default wp-login.php
    if (strpos($custom_forgot_password_page_url, 'wp-login.php') === false) {
        if (!empty($redirect)) {
            $lostpassword_url = add_query_arg('redirect_to', $redirect, $custom_forgot_password_page_url);
        } else {
            $lostpassword_url = $custom_forgot_password_page_url;
        }
    }
    
    return $lostpassword_url;
}
add_filter('lostpassword_url', 'sports_news_lostpassword_url_redirect', 20, 2);

// Redirect wp-login.php lostpassword action to our custom forgot password page
function sports_news_redirect_wp_lostpassword() {
    $current_url = $_SERVER['REQUEST_URI'];
    
    // Check if we're accessing wp-login.php with lostpassword action
    if (strpos($current_url, 'wp-login.php') !== false && isset($_GET['action']) && $_GET['action'] === 'lostpassword') {
        // For GET requests to wp-login.php?action=lostpassword, redirect to custom forgot password page
        $custom_forgot_password_url = sports_news_get_forgot_password_url();
        
        if (!strpos($custom_forgot_password_url, 'wp-login.php')) {
            $redirect_to = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : '';
            if (!empty($redirect_to)) {
                $custom_forgot_password_url = add_query_arg('redirect_to', $redirect_to, $custom_forgot_password_url);
            }
            
            wp_redirect($custom_forgot_password_url);
            exit;
        }
    }
}
add_action('init', 'sports_news_redirect_wp_lostpassword');




// Hook to create password reset page on theme activation
function sports_news_create_reset_password_page() {
    // Check if reset password page already exists
    $reset_password_page = get_page_by_path('reset-password');
    
    if (!$reset_password_page) {
        $reset_password_page = get_page_by_path('اعادة-تعيين-كلمة-المرور');
    }
    
    if (!$reset_password_page) {
        // Check for page with the template
        $pages = get_pages(array(
            'meta_key'   => '_wp_page_template',
            'meta_value' => 'page-reset-password.php',
            'number'     => 1,
        ));
        
        if (empty($pages)) {
            // Create the reset password page if it doesn't exist
            $page_data = array(
                'post_title'     => 'إعادة تعيين كلمة المرور',
                'post_content'   => 'صفحة إعادة تعيين كلمة المرور المخصصة',
                'post_status'    => 'publish',
                'post_type'      => 'page',
                'post_author'    => 1,
                'post_name'      => 'reset-password',
            );
            
            $page_id = wp_insert_post($page_data);
            
            if ($page_id) {
                // Assign the reset password template to the page
                update_post_meta($page_id, '_wp_page_template', 'page-reset-password.php');
                
                // Flush rewrite rules to make the page accessible
                flush_rewrite_rules();
            }
        } else {
            // If page exists but doesn't have the correct template, set it
            $page_id = $pages[0]->ID;
            $current_template = get_post_meta($page_id, '_wp_page_template', true);
            if ($current_template !== 'page-reset-password.php') {
                update_post_meta($page_id, '_wp_page_template', 'page-reset-password.php');
                flush_rewrite_rules();
            }
        }
    } else {
        // If page exists but doesn't have the correct template, set it
        $page_id = $reset_password_page->ID;
        $current_template = get_post_meta($page_id, '_wp_page_template', true);
        if ($current_template !== 'page-reset-password.php') {
            update_post_meta($page_id, '_wp_page_template', 'page-reset-password.php');
            flush_rewrite_rules();
        }
    }
}

// Hook into theme setup to create reset password page
add_action('after_switch_theme', 'sports_news_create_reset_password_page');

// Redirect password reset action to our custom page
function sports_news_reset_password_redirect() {
    $requested_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'login';
    
    if ('rp' === $requested_action) {
        $custom_reset_page_url = sports_news_get_reset_password_url();
        
        if (!empty($custom_reset_page_url) && strpos($custom_reset_page_url, 'wp-login.php') === false) {
            $key = isset($_GET['key']) ? sanitize_text_field($_GET['key']) : '';
            $login = isset($_GET['login']) ? sanitize_text_field($_GET['login']) : '';
            
            $redirect_url = add_query_arg(array(
                'action' => 'rp',
                'key' => $key,
                'login' => $login
            ), $custom_reset_page_url);
            
            wp_redirect($redirect_url);
            exit;
        }
    }
}
add_action('login_init', 'sports_news_reset_password_redirect');

/**
 * Function to get the reset password page URL
 */
function sports_news_get_reset_password_url($args = array()) {
    $defaults = array(
        'redirect_to' => home_url('/'),
    );
    $args = wp_parse_args($args, $defaults);

    // Try to find a page using the "page-reset-password.php" template
    $reset_password_page = get_pages(array(
        'meta_key'   => '_wp_page_template',
        'meta_value' => 'page-reset-password.php',
        'number'     => 1,
    ));

    // If not found using template, try searching by slug
    if (empty($reset_password_page)) {
        $reset_password_page = get_page_by_path('reset-password'); // Search for page named reset-password
        if (!$reset_password_page) {
            // Search for page with Arabic name
            $reset_password_page = get_page_by_path('اعادة-تعيين-كلمة-المرور');
        }
    }

    if (!empty($reset_password_page) && !is_wp_error($reset_password_page)) {
        // Ensure $reset_password_page is an object
        if (is_object($reset_password_page)) {
            $url = get_permalink($reset_password_page->ID);
        } else {
            $url = get_permalink($reset_password_page[0]->ID);
        }
    } else {
        // Fallback: wp-login.php resetpass
        $url = network_home_url('wp-login.php?action=rp', 'login');
    }

    if (!empty($args['redirect_to'])) {
        $url = add_query_arg('redirect_to', rawurlencode($args['redirect_to']), $url);
    }

    return $url;
}

// Function to improve email delivery in local environments
function sports_news_wp_mail_from($email) {
    // Use the site domain as the sender email
    $home_url = home_url();
    $parsed_url = parse_url($home_url);
    $domain = isset($parsed_url['host']) ? $parsed_url['host'] : 'localhost';
    
    return 'noreply@' . $domain;
}

function sports_news_wp_mail_from_name($name) {
    // Use the site name as the sender name
    return get_bloginfo('name');
}

// Add filters to improve email delivery
add_filter('wp_mail_from', 'sports_news_wp_mail_from');
add_filter('wp_mail_from_name', 'sports_news_wp_mail_from_name');

// For local development environments, we might need to configure SMTP
// This is a fallback for cases where wp_mail doesn't work properly
add_action('phpmailer_init', 'sports_news_config_smtp');
function sports_news_config_smtp($phpmailer) {
    // Only configure SMTP for local environments like XAMPP
    if (stristr($_SERVER['HTTP_HOST'], 'localhost') || 
        stristr($_SERVER['HTTP_HOST'], '127.0.0.1') || 
        stristr($_SERVER['HTTP_HOST'], 'ahmed1')) {
        
        $phpmailer->isSMTP();
        $phpmailer->Host       = 'localhost';
        $phpmailer->SMTPAuth   = false; // No authentication needed for local mail server
        $phpmailer->Port       = 25; // Default SMTP port
        $phpmailer->SMTPSecure = false; // No encryption for local
        $phpmailer->From       = 'noreply@' . $_SERVER['HTTP_HOST'];
        $phpmailer->FromName   = get_bloginfo('name');
    }
}


// Hook to create new password page on theme activation
function sports_news_create_new_password_page() {
    // Check if new password page already exists
    $new_password_page = get_page_by_path('new-password');
    
    if (!$new_password_page) {
        $new_password_page = get_page_by_path('كلمة-مرور-جديدة');
    }
    
    if (!$new_password_page) {
        // Check for page with the template
        $pages = get_pages(array(
            'meta_key'   => '_wp_page_template',
            'meta_value' => 'page-new-password.php',
            'number'     => 1,
        ));
        
        if (empty($pages)) {
            // Create the new password page if it doesn't exist
            $page_data = array(
                'post_title'     => 'كلمة مرور جديدة',
                'post_content'   => 'صفحة تغيير كلمة المرور للمستخدم',
                'post_status'    => 'publish',
                'post_type'      => 'page',
                'post_author'    => 1,
                'post_name'      => 'new-password',
            );
            
            $page_id = wp_insert_post($page_data);
            
            if ($page_id) {
                // Assign the new password template to the page
                update_post_meta($page_id, '_wp_page_template', 'page-new-password.php');
                
                // Flush rewrite rules to make the page accessible
                flush_rewrite_rules();
            }
        } else {
            // If page exists but doesn't have the correct template, set it
            $page_id = $pages[0]->ID;
            $current_template = get_post_meta($page_id, '_wp_page_template', true);
            if ($current_template !== 'page-new-password.php') {
                update_post_meta($page_id, '_wp_page_template', 'page-new-password.php');
                flush_rewrite_rules();
            }
        }
    } else {
        // If page exists but doesn't have the correct template, set it
        $page_id = $new_password_page->ID;
        $current_template = get_post_meta($page_id, '_wp_page_template', true);
        if ($current_template !== 'page-new-password.php') {
            update_post_meta($page_id, '_wp_page_template', 'page-new-password.php');
            flush_rewrite_rules();
        }
    }
}

// Hook into theme setup to create new password page
add_action('after_switch_theme', 'sports_news_create_new_password_page');

/**
 * Function to get the new password page URL
 */
function sports_news_get_new_password_url() {
    // Try to find a page using the "page-new-password.php" template
    $new_password_page = get_pages(array(
        'meta_key'   => '_wp_page_template',
        'meta_value' => 'page-new-password.php',
        'number'     => 1,
    ));

    // If not found using template, try searching by slug
    if (empty($new_password_page)) {
        $new_password_page = get_page_by_path('new-password'); // Search for page named new-password
        if (!$new_password_page) {
            // Search for page with Arabic name
            $new_password_page = get_page_by_path('كلمة-مرور-جديدة');
        }
    }

    if (!empty($new_password_page) && !is_wp_error($new_password_page)) {
        // Ensure $new_password_page is an object
        if (is_object($new_password_page)) {
            return get_permalink($new_password_page->ID);
        } else {
            return get_permalink($new_password_page[0]->ID);
        }
    } else {
        // Fallback: return profile edit page or account page if available
        if (is_user_logged_in()) {
            return admin_url('profile.php');
        } else {
            return wp_login_url();
        }
    }
}

// Plugin activation AJAX handler
function sports_news_activate_plugin() {
    // Verify nonce for security.
    check_ajax_referer('activate_plugins_nonce', 'nonce');
    
    // Check user capabilities
    if (!current_user_can('activate_plugins')) {
        wp_die('You do not have sufficient permissions to activate plugins');
    }
    
    $plugin_name = sanitize_key(wp_unslash($_POST['plugin_name'] ?? ''));
    
    // Map user-friendly plugin names to actual plugin file paths
    $plugin_map = array(
        'elementor' => 'elementor/elementor.php',
        'rank-math' => 'seo-by-rank-math/rank-math.php',
        'google-site-kit' => 'google-site-kit/google-site-kit.php',
        'adsense' => 'wp-google-adsense/google-adsense.php', // Common AdSense plugin file path
        'redux-framework' => 'redux-framework/redux-framework.php' // Correct Redux Framework path
    );
    
    if (isset($plugin_map[$plugin_name])) {
        $plugin_file = $plugin_map[$plugin_name];
        
        // Check if plugin exists
        if (!file_exists(WP_PLUGIN_DIR . '/' . $plugin_file)) {
            wp_send_json_error(array(
                'message' => 'الإضافة غير مثبتة على الموقع. يرجى تثبيتها أولاً.'
            ));
        }
        
        // Check if plugin is already active
        if (is_plugin_active($plugin_file)) {
            wp_send_json_success(array(
                'message' => 'الإضافة مفعّلة بالفعل.'
            ));
        }
        
        // Activate the plugin
        $result = activate_plugin($plugin_file);
        
        if (is_wp_error($result)) {
            wp_send_json_error(array(
                'message' => 'فشل تفعيل الإضافة: ' . $result->get_error_message()
            ));
        } else {
            wp_send_json_success(array(
                'message' => 'تم تفعيل الإضافة بنجاح!'
            ));
        }
    } else {
        wp_send_json_error(array(
            'message' => 'اسم الإضافة غير معروف.'
        ));
    }
}

// Plugin activation should only be available to logged-in admins.
add_action('wp_ajax_activate_plugin', 'sports_news_activate_plugin');

// Add plugin activation menu
function sports_news_add_plugin_activation_menu() {
    add_theme_page(
        'تفعيل الإضافات',
        'تفعيل الإضافات',
        'manage_options',
        'sports-news-plugins',
        'sports_news_plugin_activation_page'
    );
}
add_action('admin_menu', 'sports_news_add_plugin_activation_menu');


/**
 * قائمة الإضافات المطلوبة للقالب
 */
function sports_news_required_plugins() {
    return [
        'elementor' => [
            'name'  => 'Elementor',
            'slug'  => 'elementor',
            'file'  => 'elementor/elementor.php',
            'desc'  => 'أداة بناء الصفحات',
            'color' => '#3a3a98',
            'icon'  => 'E',
        ],
        'rank-math' => [
            'name'  => 'Rank Math SEO',
            'slug'  => 'seo-by-rank-math',
            'file'  => 'seo-by-rank-math/rank-math.php',
            'desc'  => 'تحسين محركات البحث',
            'color' => '#f60',
            'icon'  => 'R',
        ],
        'site-kit' => [
            'name'  => 'Site Kit by Google',
            'slug'  => 'google-site-kit',
            'file'  => 'google-site-kit/google-site-kit.php',
            'desc'  => 'Analytics و AdSense',
            'color' => '#4285f4',
            'icon'  => 'G',
        ],
        'redux' => [
            'name'  => 'Redux Framework',
            'slug'  => 'redux-framework',
            'file'  => 'redux-framework/redux-framework.php',
            'desc'  => 'إطار إعدادات القالب',
            'color' => '#dd3333',
            'icon'  => 'R',
        ],
    ];
}


/**
 * تثبيت إضافة من مستودع ووردبريس
 */
function sports_news_install_plugin($slug) {
    if (!current_user_can('install_plugins')) {
        return new WP_Error('permission_denied', 'ليس لديك صلاحية لتثبيت الإضافات.');
    }

    require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
    require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';

    // Force WP_Filesystem to be initialized
    // Note: WP_Filesystem is used here for plugin installation operations, which is an approved use case
    if (!WP_Filesystem()) {
        return new WP_Error('fs_error', 'تعذر الوصول إلى نظام الملفات.');
    }

    $api = plugins_api('plugin_information', [
        'slug'   => $slug,
        'fields' => ['sections' => false],
    ]);

    if (is_wp_error($api)) {
        return $api;
    }

    $skin = new Automatic_Upgrader_Skin();
    $upgrader = new Plugin_Upgrader($skin);
    
    $result = $upgrader->install($api->download_link);

    if (is_wp_error($result)) {
        return $result;
    } elseif (!$result) {
        return new WP_Error('install_failed', 'فشل التثبيت لسبب غير معروف.');
    }

    return true;
}


/**
 * صفحة الإدارة
 */
function sports_news_plugin_activation_page() {

    if (!current_user_can('manage_options')) {
        wp_die('غير مصرح لك بالدخول');
    }

    require_once ABSPATH . 'wp-admin/includes/plugin.php';
    $plugins = sports_news_required_plugins();
    
    // Refresh plugins list
    if (!function_exists('get_plugins')) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }
    wp_clean_plugins_cache();
    $installed_plugins = get_plugins();

    /* ===== معالجة الطلبات ===== */
    if (isset($_POST['sn_action'], $_POST['sn_plugin']) && check_admin_referer('sn_plugins_nonce')) {

        $key = sanitize_text_field($_POST['sn_plugin']);
        $action = sanitize_text_field($_POST['sn_action']);

        if (isset($plugins[$key])) {
            $plugin = $plugins[$key];

            if ($action === 'install') {
                $result = sports_news_install_plugin($plugin['slug']);
                if (is_wp_error($result)) {
                    $msg = 'فشل تثبيت الإضافة: ' . $result->get_error_message();
                    $msg_type = 'error';
                } else {
                    $msg = 'تم تثبيت الإضافة بنجاح. جاري التفعيل...';
                    $msg_type = 'success';
                    
                    // Activate immediately after install
                    wp_clean_plugins_cache();
                    $activate = activate_plugin($plugin['file']);
                    if (!is_wp_error($activate)) {
                        $msg .= ' وتم التفعيل!';
                    }
                }
            }

            if ($action === 'activate') {
                if (file_exists(WP_PLUGIN_DIR . '/' . $plugin['file'])) {
                    $result = activate_plugin($plugin['file']);
                    if (is_wp_error($result)) {
                        $msg = 'فشل تفعيل الإضافة: ' . $result->get_error_message();
                        $msg_type = 'error';
                    } else {
                        $msg = 'تم تفعيل الإضافة بنجاح';
                        $msg_type = 'success';
                    }
                } else {
                     $msg = 'ملف الإضافة غير موجود. حاول إعادة التثبيت.';
                     $msg_type = 'error';
                }
            }

            if ($action === 'deactivate') {
                deactivate_plugins($plugin['file']);
                $msg = 'تم إلغاء تفعيل الإضافة بنجاح';
                $msg_type = 'success';
            }
            
            // Refresh
            wp_clean_plugins_cache();
            $installed_plugins = get_plugins();

            echo '<div class="notice notice-' . $msg_type . ' is-dismissible"><p>' . esc_html($msg) . '</p></div>';
        }
    }
    ?>

    <div class="wrap">
        <h1>تثبيت وتفعيل الإضافات</h1>
        <p>الإضافات الأساسية لتشغيل القالب بكفاءة</p>

        <div class="card" style="max-width:900px;padding:20px;">
            <div style="display:flex;flex-direction:column;">
                <?php foreach ($plugins as $key => $plugin): 
                    $exists = isset($installed_plugins[$plugin['file']]);
                    $active = $exists && is_plugin_active($plugin['file']);
                    
                    // Specific check for Redux if path might vary
                    if ($key === 'redux' && !$exists) {
                         if (isset($installed_plugins['redux-framework/ReduxCore/framework.php'])) {
                             $exists = true;
                             $active = is_plugin_active('redux-framework/ReduxCore/framework.php');
                         }
                    }
                ?>
                
                <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 0;border-bottom:1px solid #eee;">
                    <!-- Plugin Info -->
                    <div style="display:flex;align-items:center;gap:12px;">
                        <div style="width:32px;height:32px;background:<?php echo esc_attr($plugin['color']); ?>;color:#fff;border-radius:6px;display:flex;align-items:center;justify-content:center;font-weight:bold;">
                            <?php echo esc_html($plugin['icon']); ?>
                        </div>
                        <div>
                            <strong><?php echo esc_html($plugin['name']); ?></strong><br>
                            <small><?php echo esc_html($plugin['desc']); ?></small>
                        </div>
                    </div>

                    <!-- Actions Form: Separate form for EACH plugin -->
                    <div>
                        <form method="post" style="margin:0;">
                            <?php wp_nonce_field('sn_plugins_nonce'); ?>
                            <input type="hidden" name="sn_plugin" value="<?php echo esc_attr($key); ?>">
                            
                            <?php if (!$exists): ?>
                                <button class="button button-primary" name="sn_action" value="install">
                                    تثبيت
                                </button>
                            <?php elseif (!$active): ?>
                                <button class="button button-primary" name="sn_action" value="activate">
                                    تفعيل
                                </button>
                            <?php else: ?>
                                <button class="button button-secondary" name="sn_action" value="deactivate">
                                    إلغاء التفعيل
                                </button>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php
}

// Add resource hints for third-party scripts
function sports_news_add_third_party_resource_hints() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
    echo '<link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>' . "\n";
}

/**
 * AJAX Handler for loading more stories
 */
function sports_news_load_more_stories() {
    // Verify nonce.
    check_ajax_referer('load_more_stories_nonce', 'nonce');
    
    // Get parameters from the request
    $page = isset($_POST['page']) ? max(1, absint($_POST['page'])) : 1;
    $posts_per_page = isset($_POST['posts_per_page']) ? absint($_POST['posts_per_page']) : 6;
    $posts_per_page = min(max($posts_per_page, 1), 12);
    $category = isset($_POST['category']) ? absint($_POST['category']) : 0;
    $tab_type = sanitize_text_field($_POST['tab_type'] ?? 'latest'); // latest, popular, commented
    
    // Set up query arguments based on tab type
    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => $posts_per_page,
        'paged' => $page,
        'meta_query' => array(
            array(
                'key' => '_thumbnail_id',
                'compare' => 'EXISTS'
            )
        ),
        // Need to count total posts to determine if there are more
        'no_found_rows' => false, // Important: set to false to get found_posts
    );
    
    // Add category filter if specified
    if ($category > 0) {
        $args['cat'] = $category;
    }
    
    // Modify query based on tab type
    switch ($tab_type) {
        case 'popular':
            $args['orderby'] = 'comment_count';
            $args['order'] = 'DESC';
            break;
        case 'commented':
            $args['orderby'] = 'comment_count';
            $args['order'] = 'DESC';
            break;
        case 'latest':
        default:
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
            break;
    }
    
    $query = new WP_Query($args);
    
    $response = array(
        'success' => false,
        'html' => '',
        'has_more' => false,
        'current_page' => $page,
        'posts_per_page' => $posts_per_page,
    );
    
    if ($query->have_posts()) {
        ob_start();
        
        while ($query->have_posts()) {
            $query->the_post();
            $categories = get_the_category();
            $category_name = !empty($categories) ? esc_html($categories[0]->name) : '';
            $author_name = get_the_author();
            $avatar = get_avatar(get_the_author_meta('ID'), 32);
            $post_thumbnail = has_post_thumbnail() ? get_the_post_thumbnail(get_the_ID(), 'medium', array('class' => 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-700', 'loading' => 'lazy')) : '';
            
            // Generate the post HTML
            echo '<article class="bg-white rounded-[2.5rem] shadow-sm p-4 md:p-6 group hover:shadow-xl hover:shadow-gray-200/50 transition-all duration-500 border border-transparent hover:border-gray-100 flex flex-col md:flex-row gap-8">';
            echo '<div class="md:w-64 h-48 flex-shrink-0 relative overflow-hidden rounded-[2rem] shadow-md">';
            if ($post_thumbnail) {
                echo $post_thumbnail;
            }
            echo '<div class="absolute top-4 right-4">';
            if (!empty($categories)) {
                echo '<span class="bg-white/90 backdrop-blur-md text-primary text-[9px] font-black px-3 py-1.5 rounded-lg shadow-sm">';
                echo $category_name;
                echo '</span>';
            }
            echo '</div>';
            echo '</div>';
            echo '<div class="flex flex-col justify-center py-2 min-w-0">';
            echo '<div class="flex items-center gap-4 text-[10px] text-gray-400 font-bold mb-4 uppercase tracking-wider">';
            echo '<span class="flex items-center gap-1.5"><i class="ri-calendar-line text-primary"></i> ' . esc_html(get_the_date()) . '</span>';
            echo '<span class="flex items-center gap-1.5"><i class="ri-time-line text-primary"></i> 4 دقائق</span>';
            echo '</div>';
            echo '<h3 class="kufi font-black text-xl md:text-2xl mb-4 leading-snug group-hover:text-primary transition-colors line-clamp-2">';
            echo '<a href="' . esc_url(get_permalink()) . '">' . esc_html(get_the_title()) . '</a>';
            echo '</h3>';
            echo '<p class="text-gray-500 text-sm leading-relaxed line-clamp-2 mb-6 opacity-80">' . esc_html(wp_trim_words(get_the_excerpt(), 25)) . '</p>';
            echo '<div class="flex items-center justify-between">';
            echo '<div class="flex items-center gap-3">';
            echo '<div class="w-8 h-8 rounded-xl overflow-hidden shadow-sm border border-gray-100">';
            echo $avatar;
            echo '</div>';
            echo '<span class="text-xs font-black kufi text-gray-900">' . esc_html($author_name) . '</span>';
            echo '</div>';
            echo '<div class="flex items-center gap-4 opacity-0 group-hover:opacity-100 transition-opacity translate-x-4 group-hover:translate-x-0">';
            echo '<span class="text-[10px] text-gray-400 font-bold flex items-center gap-1">';
            echo '<i class="ri-message-3-line text-primary"></i>';
            echo get_comments_number('0', '1', '%');
            echo '</span>';
            echo '<i class="ri-arrow-left-line text-primary"></i>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</article>';
        }
        
        $response['html'] = ob_get_clean();
        $response['success'] = true;
        
        // Properly determine if there are more posts to load
        // Calculate if we have more posts by comparing total posts with what we've shown so far
        $total_posts = $query->found_posts;
        $posts_already_shown = $posts_per_page * $page;
        $response['has_more'] = $posts_already_shown < $total_posts;
        $response['total_posts'] = $total_posts;
        $response['posts_already_shown'] = $posts_already_shown;
    } else {
        // No posts found, so definitely no more
        $response['has_more'] = false;
    }
    
    wp_reset_postdata();
    wp_send_json($response);
}

// Register AJAX actions for loading more stories
add_action('wp_ajax_load_more_stories', 'sports_news_load_more_stories');
add_action('wp_ajax_nopriv_load_more_stories', 'sports_news_load_more_stories');

function drama_mojaz_pagination($query = null) {
    global $wp_query;
    $query = $query ? $query : $wp_query;
    $big = 999999999; // need an unlikely integer

    $pages = paginate_links(array(
        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $query->max_num_pages,
        'type' => 'array',
        'prev_text' => __('Previous', 'drama-mojaz-theme'),
        'next_text' => __('Next', 'drama-mojaz-theme'),
    ));

    if (is_array($pages)) {
        $paged = (get_query_var('paged') == 0) ? 1 : get_query_var('paged');
        echo '<div class="page-numbers">';
        foreach ($pages as $page) {
            echo $page;
        }
        echo '</div>';
    }
}

function translate_pagination_text($translated_text, $text, $domain) {
    if ($domain === 'drama-mojaz-theme') {
        switch ($text) {
            case 'Previous':
                return 'السابق';
            case 'Next':
                return 'التالي';
        }
    }
    return $translated_text;
}
add_filter('gettext', 'translate_pagination_text', 20, 3);


/**
 * Register Block Patterns
 */
function sports_news_register_block_patterns() {
    if (function_exists('register_block_pattern')) {
        register_block_pattern(
            'drama-mojaz/premium-quote',
            array(
                'title'       => __('Premium Sports Quote', 'drama-mojaz-theme'),
                'description' => _x('A styled quote for sports news.', 'Block pattern description', 'drama-mojaz-theme'),
                'content'     => "<!-- wp:quote {\"className\":\"is-style-plain\"} -->\n<blockquote class=\"wp-block-quote is-style-plain\"><p>هذا النص يمثل اقتباساً رياضياً مميزاً بتصميمه الحديث.</p><cite>اسم الرياضي</cite></blockquote>\n<!-- /wp:quote -->",
                'categories'  => array('text'),
            )
        );
    }

    if (function_exists('register_block_style')) {
        register_block_style(
            'core/quote',
            array(
                'name'  => 'premium-border',
                'label' => __('Premium Border', 'drama-mojaz-theme'),
            )
        );
    }
}
add_action('init', 'sports_news_register_block_patterns');
