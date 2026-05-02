<?php
/**
 * Redux Options Helper Functions
 * Apply all Redux settings to the theme
 */

if (!defined('ABSPATH')) exit;

// ============================================
// Apply Custom Colors
// ============================================
function sports_news_custom_colors() {
    $primary = sports_news_get_opt('primary_color', '#E31B23');
    $secondary = sports_news_get_opt('secondary_color', '#000000');
    
    echo '<style id="sports-news-custom-colors">
        :root {
            --primary: ' . esc_attr($primary) . ';
            --secondary: ' . esc_attr($secondary) . ';
        }
    </style>';
}
add_action('wp_head', 'sports_news_custom_colors', 5);

// ============================================
// Apply Custom CSS
// ============================================
function sports_news_custom_css() {
    $custom_css = sports_news_get_opt('custom_css', '');
    if (!empty($custom_css)) {
        echo '<style id="sports-news-custom-css">' . wp_strip_all_tags($custom_css) . '</style>';
    }
}
add_action('wp_head', 'sports_news_custom_css', 100);

// ============================================
// Apply Custom JS
// ============================================
function sports_news_custom_js() {
    $custom_js = sports_news_get_opt('custom_js', '');
    if (!empty($custom_js)) {
        echo '<script id="sports-news-custom-js">' . $custom_js . '</script>';
    }
}
add_action('wp_footer', 'sports_news_custom_js', 100);

// ============================================
// Apply Header Code
// ============================================
function sports_news_header_code() {
    $header_code = sports_news_get_opt('header_code', '');
    if (!empty($header_code)) {
        echo $header_code;
    }
}
add_action('wp_head', 'sports_news_header_code', 999);

// ============================================
// Apply Footer Code
// ============================================
function sports_news_footer_code() {
    $footer_code = sports_news_get_opt('footer_code', '');
    if (!empty($footer_code)) {
        echo $footer_code;
    }
}
add_action('wp_footer', 'sports_news_footer_code', 999);

// ============================================
// Apply Google Analytics
// ============================================
function sports_news_google_analytics() {
    $ga_code = sports_news_get_opt('google_analytics', '');
    if (!empty($ga_code)) {
        echo $ga_code;
    }
}
add_action('wp_head', 'sports_news_google_analytics', 10);

// ============================================
// Favicon handling removed - WordPress Site Icon (4.3+) should be used instead
// ============================================

// ============================================
// Apply SEO Meta Tags
// ============================================
function sports_news_seo_meta() {
    // Only add meta tags if Rank Math is not active
    if (class_exists('RankMath') || defined('RANK_MATH_VERSION')) {
        return;
    }
    
    $meta_title = sports_news_get_opt('site_meta_title', '');
    $meta_desc = sports_news_get_opt('site_meta_description', '');
    $meta_keywords = sports_news_get_opt('site_meta_keywords', '');
    $og_image = sports_news_get_opt('og_image');
    
    if (!empty($meta_title) && is_front_page()) {
        echo '<meta name="title" content="' . esc_attr($meta_title) . '">';
    }
    if (!empty($meta_desc) && is_front_page()) {
        echo '<meta name="description" content="' . esc_attr($meta_desc) . '">';
    }
    if (!empty($meta_keywords)) {
        echo '<meta name="keywords" content="' . esc_attr($meta_keywords) . '">';
    }
    if (!empty($og_image['url'])) {
        echo '<meta property="og:image" content="' . esc_url($og_image['url']) . '">';
    }
}
add_action('wp_head', 'sports_news_seo_meta', 1);

// ============================================
// Disable XML-RPC if enabled
// ============================================
if (sports_news_get_opt('disable_xmlrpc', true)) {
    add_filter('xmlrpc_enabled', '__return_false');
}

// ============================================
// Hide WordPress Version
// ============================================
if (sports_news_get_opt('hide_wp_version', true)) {
    // remove_action('wp_head', 'wp_generator'); // Removed: Plugin territory
    add_filter('the_generator', '__return_empty_string');
}

// ============================================
// Disable File Editing
// ============================================
if (sports_news_get_opt('disable_file_editing', false)) {
    define('DISALLOW_FILE_EDIT', true);
}

// ============================================
// Post Views Counter
// ============================================
function sports_news_set_post_views($post_id) {
    if (!sports_news_get_opt('enable_post_views', true)) return;
    
    $count_admin = sports_news_get_opt('count_admin_views', false);
    if (!$count_admin && current_user_can('manage_options')) return;
    
    $count_key = 'post_views_count';
    $count = get_post_meta($post_id, $count_key, true);
    if ($count == '') {
        $count = 0;
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '0');
    } else {
        $count++;
        update_post_meta($post_id, $count_key, $count);
    }
}

function sports_news_track_post_views($post_id) {
    if (!is_single()) return;
    if (empty($post_id)) {
        global $post;
        $post_id = $post->ID;
    }
    sports_news_set_post_views($post_id);
}
add_action('wp_head', 'sports_news_track_post_views');

function sports_news_get_post_views($post_id) {
    $count_key = 'post_views_count';
    $count = get_post_meta($post_id, $count_key, true);
    if ($count == '') {
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '0');
        return "0";
    }
    return $count;
}

// ============================================
// Reading Time Calculator
// ============================================
function sports_news_reading_time($post_id = null) {
    if (!sports_news_get_opt('enable_reading_time', true)) return '';
    
    if (!$post_id) {
        global $post;
        $post_id = $post->ID;
    }
    
    $content = get_post_field('post_content', $post_id);
    $word_count = str_word_count(strip_tags($content));
    $reading_speed = sports_news_get_opt('reading_speed', 200);
    $reading_time = ceil($word_count / $reading_speed);
    $text = sports_news_get_opt('reading_time_text', 'دقائق قراءة');
    
    return $reading_time . ' ' . $text;
}

// ============================================
// Maintenance Mode
// ============================================
function sports_news_maintenance_mode() {
    if (!sports_news_get_opt('enable_maintenance', false)) return;
    if (current_user_can('manage_options')) return;
    
    $title = sports_news_get_opt('maintenance_title', 'الموقع قيد الصيانة');
    $message = sports_news_get_opt('maintenance_message', 'نعمل حالياً على تحسين الموقع. سنعود قريباً!');
    
    wp_die(
        '<h1>' . esc_html($title) . '</h1><p>' . wp_kses_post($message) . '</p>',
        esc_html($title),
        array('response' => 503)
    );
}
add_action('get_header', 'sports_news_maintenance_mode');

// ============================================
// Apply Container Width
// ============================================
function sports_news_container_width() {
    $width = sports_news_get_opt('container_width', 1320);
    $border_radius = sports_news_get_opt('border_radius', 24);
    
    echo '<style id="sports-news-layout">
        .container {
            max-width: ' . intval($width) . 'px;
        }
        .rounded-2xl, .rounded-3xl {
            border-radius: ' . intval($border_radius) . 'px;
        }
    </style>';
}
add_action('wp_head', 'sports_news_container_width', 20);

// ============================================
// Archive Posts Per Page
// ============================================
function sports_news_archive_posts_per_page($query) {
    if (!is_admin() && $query->is_main_query() && (is_category() || is_tag() || is_archive())) {
        $posts_per_page = sports_news_get_opt('archive_posts_per_page', 12);
        $query->set('posts_per_page', $posts_per_page);
    }
}
add_action('pre_get_posts', 'sports_news_archive_posts_per_page');

// ============================================
// Custom Excerpt Length
// ============================================
function sports_news_excerpt_length($length) {
    if (is_archive() && sports_news_get_opt('archive_show_excerpt', true)) {
        return sports_news_get_opt('archive_excerpt_length', 20);
    }
    return $length;
}
add_filter('excerpt_length', 'sports_news_excerpt_length', 999);

// ============================================
// Comments Per Page
// ============================================
function sports_news_comments_per_page() {
    $comments_per_page = sports_news_get_opt('comments_per_page', 10);
    return $comments_per_page;
}
add_filter('option_comments_per_page', 'sports_news_comments_per_page');

// ============================================
// Lazy Loading
// ============================================
if (sports_news_get_opt('enable_lazy_load', true)) {
    add_filter('wp_lazy_loading_enabled', '__return_true');
}

// ============================================
// Apply Typography
// ============================================
function sports_news_typography() {
    $body_font = sports_news_get_opt('body_font');
    $heading_font = sports_news_get_opt('heading_font');
    
    $css = '';
    
    if (!empty($body_font['font-family'])) {
        $css .= 'body { font-family: "' . esc_attr($body_font['font-family']) . '", sans-serif; }';
    }
    if (!empty($body_font['font-size'])) {
        $css .= 'body { font-size: ' . esc_attr($body_font['font-size']) . '; }';
    }
    if (!empty($heading_font['font-family'])) {
        $css .= 'h1, h2, h3, h4, h5, h6, .kufi { font-family: "' . esc_attr($heading_font['font-family']) . '", sans-serif; }';
    }
    
    if (!empty($css)) {
        echo '<style id="sports-news-typography">' . $css . '</style>';
    }
}
add_action('wp_head', 'sports_news_typography', 15);

// ============================================
// Breadcrumbs
// ============================================
function sports_news_breadcrumbs() {
    if (!sports_news_get_opt('enable_breadcrumbs', true)) return '';
    
    if (is_front_page()) return '';
    
    $output = '<nav class="breadcrumbs text-sm text-gray-600 mb-6">';
    $output .= '<a href="' . home_url('/') . '" class="hover:text-primary">الرئيسية</a>';
    
    if (is_category() || is_single()) {
        $output .= ' / ';
        if (is_single()) {
            $category = get_the_category();
            if ($category) {
                $output .= '<a href="' . get_category_link($category[0]->term_id) . '">' . $category[0]->name . '</a>';
                $output .= ' / <span class="text-gray-900">' . get_the_title() . '</span>';
            }
        } else {
            $output .= '<span class="text-gray-900">' . single_cat_title('', false) . '</span>';
        }
    } elseif (is_page()) {
        $output .= ' / <span class="text-gray-900">' . get_the_title() . '</span>';
    } elseif (is_search()) {
        $output .= ' / <span class="text-gray-900">نتائج البحث عن: ' . get_search_query() . '</span>';
    } elseif (is_404()) {
        $output .= ' / <span class="text-gray-900">404</span>';
    }
    
    $output .= '</nav>';
    return $output;
}

// ============================================
// Share Buttons HTML
// ============================================
function sports_news_share_buttons() {
    if (!sports_news_get_opt('show_post_share', true)) return '';
    
    $url = urlencode(get_permalink());
    $title = urlencode(get_the_title());
    
    $output = '<div class="share-buttons flex items-center gap-3 flex-wrap">';
    $output .= '<span class="text-sm font-bold text-gray-700">شارك:</span>';
    
    if (sports_news_get_opt('share_facebook', true)) {
        $output .= '<a href="https://www.facebook.com/sharer/sharer.php?u=' . $url . '" target="_blank" class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center hover:scale-110 transition-transform"><i class="ri-facebook-fill"></i></a>';
    }
    if (sports_news_get_opt('share_twitter', true)) {
        $output .= '<a href="https://twitter.com/intent/tweet?url=' . $url . '&text=' . $title . '" target="_blank" class="w-10 h-10 bg-black text-white rounded-full flex items-center justify-center hover:scale-110 transition-transform"><i class="ri-twitter-x-fill"></i></a>';
    }
    if (sports_news_get_opt('share_whatsapp', true)) {
        $output .= '<a href="https://wa.me/?text=' . $title . '%20' . $url . '" target="_blank" class="w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center hover:scale-110 transition-transform"><i class="ri-whatsapp-fill"></i></a>';
    }
    if (sports_news_get_opt('share_telegram', true)) {
        $output .= '<a href="https://t.me/share/url?url=' . $url . '&text=' . $title . '" target="_blank" class="w-10 h-10 bg-blue-500 text-white rounded-full flex items-center justify-center hover:scale-110 transition-transform"><i class="ri-telegram-fill"></i></a>';
    }
    if (sports_news_get_opt('share_email', true)) {
        $output .= '<a href="mailto:?subject=' . $title . '&body=' . $url . '" class="w-10 h-10 bg-gray-600 text-white rounded-full flex items-center justify-center hover:scale-110 transition-transform"><i class="ri-mail-fill"></i></a>';
    }
    
    $output .= '</div>';
    return $output;
}

// Google AdSense Helper Functions
function sports_news_adsense_enabled() {
    return sports_news_get_opt('adsense_enabled', false);
}

function sports_news_adsense_publisher_id() {
    return sports_news_get_opt('adsense_publisher_id', '');
}

function sports_news_adsense_display_ad($slot_id, $ad_style = '') {
    if (sports_news_adsense_enabled()) {
        return display_adsense_ad($slot_id, $ad_style);
    }
    return '';
}
