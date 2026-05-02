<?php
if (!defined('ABSPATH')) exit;

// Get stories count - try Redux first, then database directly
$count = sports_news_get_opt('stories_count', null);
if ($count === null || $count === '' || $count === false) {
    // Fallback: try to get from WordPress options directly
    $redux_options = get_option('sports_news_opt');
    if (is_array($redux_options) && isset($redux_options['stories_count'])) {
        $count = $redux_options['stories_count'];
    } else {
        $count = 4; // Default
    }
}
$count = intval($count);

// Debug info (add ?debug_stories=1 to URL to see)
if (isset($_GET['debug_stories']) && current_user_can('manage_options')) {
    echo '<!-- Stories Count: ' . $count . ' -->';
}
$category = sports_news_get_opt('stories_category', '');

$args = [
    'post_type'      => 'post',
    'posts_per_page' => $count,
    'post_status'    => 'publish',
    'ignore_sticky_posts' => true,
    'meta_query' => [
        [
            'key'     => '_thumbnail_id',
            'compare' => 'EXISTS'
        ]
    ]
];

if (!empty($category)) {
    $args['cat'] = $category;
}

$stories = new WP_Query($args);

if (isset($_GET['debug_stories']) && current_user_can('manage_options')) {
    echo '<pre style="background:#000; color:#0f0; padding:20px; direction:ltr; text-align:left;">';
    echo 'Stories Count: ' . $count . "\n";
    echo 'Stories Category: ' . $category . "\n";
    echo 'Found Posts: ' . $stories->found_posts . "\n";
    echo '</pre>';
}

if ($stories->have_posts()) :
    $more_url = get_permalink(get_option('page_for_posts'));
    if (!$more_url) {
        $more_url = home_url('/');
    }
?>
<div class="stories-section py-6 md:py-8 overflow-hidden bg-transparent border-b border-gray-100">
    <div class="container mx-auto px-4">
        <div class="flex items-center gap-4 md:gap-6">
            <button type="button"
                    class="stories-nav stories-prev w-10 h-10 rounded-full bg-white border border-gray-200 shadow-sm flex items-center justify-center text-gray-700 hover:text-primary hover:border-primary transition-colors"
                    aria-label="<?php esc_attr_e('Previous stories', 'drama-mojaz-theme'); ?>">
                <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M15 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </button>

            <div class="stories-wrapper flex gap-4 md:gap-6 overflow-x-auto no-scrollbar pb-2 flex-1">
            <?php 
            $story_index = 0;
            while ($stories->have_posts()) : $stories->the_post(); 
                $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
                $author_name = get_the_author();
                $author_avatar = get_avatar_url(get_the_author_meta('ID'), ['size' => 64]);
                $post_time = human_time_diff(get_the_time('U'), current_time('timestamp', 0)) . ' ' . 'منذ';
            ?>
                <div class="story-item flex-shrink-0 cursor-pointer group" 
                     data-index="<?php echo $story_index; ?>"
                     data-image="<?php echo esc_url($thumbnail_url); ?>"
                     data-author="<?php echo esc_attr($author_name); ?>"
                     data-avatar="<?php echo esc_url($author_avatar); ?>"
                     data-time="<?php echo esc_attr($post_time); ?>"
                     data-title="<?php the_title_attribute(); ?>"
                     data-url="<?php the_permalink(); ?>">
                    
                    <div class="relative w-16 h-16 md:w-20 md:h-20 flex-shrink-0 group-hover:scale-105 transition-transform duration-300 ease-out cursor-pointer">
                        <div class="w-full h-full rounded-full flex items-center justify-center border-2 border-primary shadow-[0_0_0_3px_rgba(255,255,255,0.9)]">
                            <div class="w-full h-full rounded-full bg-white p-0.5">
                                <img src="<?php the_post_thumbnail_url('thumbnail'); ?>"
                                     class="w-full h-full object-cover rounded-full"
                                     loading="lazy"
                                     alt="<?php the_title_attribute(); ?>">
                            </div>
                        </div>

                         <!-- Premium Live Indicator -->
                       <?php if ( get_post_meta(get_the_ID(), 'is_live', true) ) : ?>
                            <div class="absolute -bottom-1 left-1/2 -translate-x-1/2 bg-primary text-white text-[8px] font-black px-2 py-0.5 rounded-md z-20 border-2 border-white shadow-lg animate-pulse flex items-center gap-1">
                                <span class="w-1 h-1 bg-white rounded-full"></span>
                                <span class="leading-none tracking-tighter">LIVE</span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <p class="text-[11px] md:text-xs mt-2 text-center text-gray-900 font-bold kufi line-clamp-1 w-16 md:w-20 leading-tight group-hover:text-primary transition-colors">
                        <?php the_title(); ?>
                    </p>
                </div>
            <?php 
                $story_index++;
            endwhile; 
            ?>
            </div>

            <button type="button"
                    class="stories-nav stories-next w-10 h-10 rounded-full bg-white border border-gray-200 shadow-sm flex items-center justify-center text-gray-700 hover:text-primary hover:border-primary transition-colors"
                    aria-label="<?php esc_attr_e('Next stories', 'drama-mojaz-theme'); ?>">
                <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </button>
            <a href="<?php echo esc_url($more_url); ?>"
               class="inline-flex items-center justify-center h-10 px-6 rounded-xl border font-bold kufi text-sm md:text-base transition-colors"
               style="border-color: var(--primary); color: var(--primary); background-color: #fff;">
                المزيد
            </a>
        </div>
    </div>
</div>

<!-- Story Viewer Modal Moved to Footer -->


<script>
document.addEventListener('DOMContentLoaded', function () {
    var wrapper = document.querySelector('.stories-wrapper');
    if (!wrapper) return;
    var prevBtn = document.querySelector('.stories-prev');
    var nextBtn = document.querySelector('.stories-next');
    var scrollStep = function () {
        return wrapper.clientWidth * 0.7;
    };
    var isRTL = getComputedStyle(wrapper).direction === 'rtl';
    if (prevBtn) {
        prevBtn.addEventListener('click', function () {
            var delta = scrollStep();
            wrapper.scrollBy({ left: isRTL ? delta : -delta, behavior: 'smooth' });
        });
    }
    if (nextBtn) {
        nextBtn.addEventListener('click', function () {
            var delta = scrollStep();
            wrapper.scrollBy({ left: isRTL ? -delta : delta, behavior: 'smooth' });
        });
    }
});
</script>

<?php
wp_reset_postdata();
else :
    // Debug: If no stories found, output a visible message for admins
    if (current_user_can('manage_options')) {
        echo '<div style="background:red;color:white;padding:20px;text-align:center;">No stories found. Check if posts have featured images or if the category is correct.</div>';
    }
endif;
