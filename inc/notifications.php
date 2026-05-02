<?php
/**
 * Notifications Helper Functions
 */

if (!defined('ABSPATH')) exit;

/**
 * Get recent posts for notifications
 *
 * @param int $limit Number of posts to retrieve
 * @return WP_Query
 */
function sports_news_get_recent_posts($limit = 3) {
    return new WP_Query(array(
        'posts_per_page' => $limit,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC'
    ));
}

/**
 * Get notification count (posts in last 24 hours)
 *
 * @return int
 */
function sports_news_get_notification_count() {
    $recent_posts = new WP_Query(array(
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'date_query'     => array(
            array(
                'after' => '24 hours ago'
            )
        ),
        'fields' => 'ids' // Only get IDs for performance
    ));
    
    return $recent_posts->found_posts;
}

/**
 * AJAX Handler for fetching notifications
 */
function sports_news_ajax_get_notifications() {
    // Verify nonce if you implement one in JS, though read-only public data is less critical
    // check_ajax_referer('sports_news_nonce', 'nonce');

    $query = sports_news_get_recent_posts(3);
    $notifications = array();
    $colors = ['bg-primary', 'bg-primary/80', 'bg-primary/60'];
    $i = 0;

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $color = $colors[$i % count($colors)];
            
            // Prepare data
            $notifications[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'permalink' => get_permalink(),
                'time_diff' => human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago',
                'thumbnail' => has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') : '',
                'color' => $color
            );
            $i++;
        }
        wp_reset_postdata();
    }

    $count = sports_news_get_notification_count();

    wp_send_json_success(array(
        'count' => $count,
        'notifications' => $notifications
    ));
}

// Register AJAX hooks
add_action('wp_ajax_sports_news_get_notifications', 'sports_news_ajax_get_notifications');
add_action('wp_ajax_nopriv_sports_news_get_notifications', 'sports_news_ajax_get_notifications');
