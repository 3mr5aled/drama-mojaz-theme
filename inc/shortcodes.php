<?php
/**
 * Shortcodes for homepage sections
 */

if (!defined('ABSPATH')) exit;

/**
 * Helper to render a template part and return its output
 */
function dm_render_section($section) {
    if (!defined('DM_SHORTCODE')) {
        define('DM_SHORTCODE', true);
    }
    ob_start();
    get_template_part('template-parts/home/section', $section);
    return ob_get_clean();
}

// [dm_stories]
add_shortcode('dm_stories', function() {
    return dm_render_section('stories');
});

// [dm_hero]
add_shortcode('dm_hero', function() {
    return dm_render_section('hero');
});

// [dm_advanced]
add_shortcode('dm_advanced', function() {
    return dm_render_section('advanced');
});

// [dm_videos]
add_shortcode('dm_videos', function() {
    return dm_render_section('videos');
});

// [dm_compact]
add_shortcode('dm_compact', function() {
    return dm_render_section('compact');
});

// [dm_trending]
add_shortcode('dm_trending', function() {
    return dm_render_section('trending');
});

// [dm_zigzag]
add_shortcode('dm_zigzag', function() {
    return dm_render_section('zigzag');
});

// [dm_overlay]
add_shortcode('dm_overlay', function() {
    return dm_render_section('overlay');
});

// [dm_timeline]
add_shortcode('dm_timeline', function() {
    return dm_render_section('timeline');
});

/**
 * [dm_homepage] - Renders all homepage sections in the order defined in Theme Options
 */
add_shortcode('dm_homepage', function() {
    $home_sections = sports_news_get_opt('home_sections_order');
    $enabled_sections = array();
    
    if (is_array($home_sections)) {
        if (isset($home_sections['enabled']) && is_array($home_sections['enabled'])) {
            $enabled_sections = array_keys($home_sections['enabled']);
        } else {
            $enabled_sections = array_keys($home_sections);
        }
    }
    
    $whitelist = array('stories','hero','advanced','videos','compact','trending','zigzag','overlay','timeline');
    $enabled_sections = array_values(array_intersect($enabled_sections, $whitelist));
    
    if (empty($enabled_sections)) {
        $enabled_sections = $whitelist;
    }
    
    ob_start();
    foreach ($enabled_sections as $__sec) {
        $__sec = trim($__sec);
        $template_slug = str_replace('_', '-', $__sec);
        if ($template_slug === 'Advanced') {
            $template_slug = 'advanced';
        }
        get_template_part('template-parts/home/section', $template_slug);
    }
    return ob_get_clean();
});
