<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Drama_Mojaz_Theme
 * 
 * Drama Mojaz Theme is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 */

get_header(); ?>

<?php
// Helper function to check if a post contains video content
if (!function_exists('has_video_content')) {
    function has_video_content($post_id = null) {
        if (!$post_id) {
            $post_id = get_the_ID();
        }

        $post_content = get_the_content(null, false, $post_id);

        // Check for embedded video URLs in content
        $video_patterns = array(
            '/youtube\\.com\\/watch\\?v=([a-zA-Z0-9_-]{11})/',
            '/youtu\\.be\\/([a-zA-Z0-9_-]{11})/',
            '/vimeo\\.com\\/(\\d+)/',
        );

        foreach ($video_patterns as $pattern) {
            if (preg_match($pattern, $post_content, $matches)) {
                // Extract video ID for YouTube
                if (strpos($pattern, 'youtube') !== false || strpos($pattern, 'youtu.be') !== false) {
                    $video_id = isset($matches[1]) ? $matches[1] : '';
                    return 'https://www.youtube.com/embed/' . $video_id;
                } elseif (strpos($pattern, 'vimeo') !== false) {
                    $video_id = isset($matches[1]) ? $matches[1] : '';
                    return 'https://player.vimeo.com/video/' . $video_id;
                }
            }
        }

        // Check for video shortcode
        if (has_shortcode($post_content, 'video')) {
            return get_video_from_shortcode($post_content);
        }

        return false;
    }
}

// Extract video from shortcode
if (!function_exists('get_video_from_shortcode')) {
    function get_video_from_shortcode($content) {
        $pattern = get_shortcode_regex(array('video'));
        if (preg_match('/' . $pattern . '/s', $content, $matches)) {
            preg_match('/src=["\\\']([^"\\\']*)["\\\']/', $matches[0], $src_matches);
            if (isset($src_matches[1])) {
                return $src_matches[1];
            }
        }
        return false;
    }
}

// Display video player HTML
if (!function_exists('display_video_player')) {
    function display_video_player($video_url, $class = '') {
        if (empty($video_url)) {
            return;
        }

        // Use WordPress oEmbed to get the player HTML
        $embed_code = wp_oembed_get($video_url);

        if ($embed_code) {
            // Wrap in a container div for styling and compliance
            echo '<div class="video-embed-container ' . esc_attr($class) . '">';
            echo $embed_code;
            echo '</div>';
        } else {
            // Fallback for direct video links (mp4)
            $allowed_exts = array('mp4', 'webm', 'ogv');
            $ext = pathinfo($video_url, PATHINFO_EXTENSION);

            if (in_array(strtolower($ext), $allowed_exts, true)) {
                echo '<video class="' . esc_attr($class) . '" controls><source src="' . esc_url($video_url) . '" type="video/' . esc_attr($ext) . '">Your browser does not support the video tag.</video>';
            }
        }
    }
}

// Determine dynamic home sections order from Redux Sortable with optimized code
$home_sections = sports_news_get_opt('home_sections_order');
$enabled_sections = array();

if (is_array($home_sections)) {
    if (isset($home_sections['enabled']) && is_array($home_sections['enabled'])) {
        $enabled_sections = array_keys($home_sections['enabled']);
    } else {
        // Simplified logic to determine if it's a flat numeric array
        $enabled_sections = array_keys($home_sections);
    }
}

// Whitelist and keep order
$whitelist = ['hero', 'advanced', 'videos', 'compact', 'trending', 'zigzag', 'timeline', 'stories', 'grid_a', 'grid_b', 'grid_c'];

$enabled_sections = array_values(array_intersect($enabled_sections, $whitelist));

// Fallback to default order if empty after filtering
if (empty($enabled_sections)) :
    $enabled_sections = $whitelist;
endif;

// Force stories to be above hero mandatory
if (in_array('stories', $enabled_sections) && in_array('hero', $enabled_sections)) {
    $enabled_sections = array_values(array_diff($enabled_sections, ['stories']));
    $hero_pos = array_search('hero', $enabled_sections);
    array_splice($enabled_sections, $hero_pos, 0, 'stories');
}

// Force compact, grid_a, grid_b and grid_c to follow videos if videos section is enabled
if (in_array('videos', $enabled_sections)) {
    $enabled_sections = array_diff($enabled_sections, ['compact', 'grid_a', 'grid_b', 'grid_c']);
    $enabled_sections = array_values($enabled_sections); // Re-index
    $videos_pos = array_search('videos', $enabled_sections);
    array_splice($enabled_sections, $videos_pos + 1, 0, ['compact', 'grid_a', 'grid_b', 'grid_c']);
}

// Section order is now determined by Redux sortable or whitelist defaults.
$section_template_map = array(
    'hero' => 'hero',
    'advanced' => 'advanced',
    'videos' => 'videos',
    'compact' => 'compact',
    'trending' => 'trending',
    'zigzag' => 'zigzag',
    'timeline' => 'timeline',
    'stories' => 'stories',
    'grid_a' => 'grid-a',
    'grid_b' => 'grid-b',
    'grid_c' => 'grid-c',
);
?>
<main id="primary" class="home-page-layout editorial-home-shell" role="main">
<?php foreach ($enabled_sections as $__sec) : ?>
    <?php
    $__sec = trim($__sec);
    if (!isset($section_template_map[$__sec])) {
        continue;
    }
    $template_slug = $section_template_map[$__sec];
    $template_file = "template-parts/home/section-{$template_slug}.php";
    if (!locate_template($template_file, false, false)) {
        continue;
    }
    ?>
    <div class="home-section-block home-section-<?php echo esc_attr($template_slug); ?>" data-home-section="<?php echo esc_attr($__sec); ?>">
        <?php get_template_part('template-parts/home/section', $template_slug); ?>
    </div>
<?php endforeach; ?>
</main>
<?php get_footer(); ?>
