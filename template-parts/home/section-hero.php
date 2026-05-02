<?php
/**
 * Template part for the Hero section on the homepage and category pages
 */

// Show on homepage if enabled, or always show on category pages
$show_on_home = sports_news_get_opt('show_hero', true);
$is_category_page = is_category();

if ($show_on_home || $is_category_page) :
    $hero_post_count = sports_news_get_opt('hero_post_count', 6);

    // If on category page, use current category
    if ($is_category_page) {
        $current_cat = get_queried_object();
        $hero_category = $current_cat->term_id;
    } else {
        $hero_category = sports_news_get_opt('hero_category', '');
    }

    $hero_query_args = array('posts_per_page' => $hero_post_count);
    if (!empty($hero_category)) :
        $hero_query_args['cat'] = $hero_category;
    endif;
    $hero_query = new WP_Query($hero_query_args);
    $hero_posts = array();
    if ($hero_query->have_posts()) :
        while ($hero_query->have_posts()) : $hero_query->the_post();
            $hero_posts[] = get_the_ID();
        endwhile;
        wp_reset_postdata();
    endif;

    if (!empty($hero_posts)) :
        $main_post_id = $hero_posts[0];
        $side_post_ids = array_slice($hero_posts, 1);

        // Ensure we have enough posts to fill the slider cards
        $target_side_count = 4;
        if (count($side_post_ids) < $target_side_count) {
            $fill_needed = $target_side_count - count($side_post_ids);
            if ($fill_needed > 0) {
                $fill_args = array(
                    'posts_per_page' => $fill_needed,
                    'post__not_in' => array_unique(array_merge($hero_posts, $side_post_ids)),
                );
                if (!empty($hero_category)) {
                    $fill_args['cat'] = $hero_category;
                }
                $fill_query = new WP_Query($fill_args);
                if ($fill_query->have_posts()) :
                    while ($fill_query->have_posts()) : $fill_query->the_post();
                        $side_post_ids[] = get_the_ID();
                    endwhile;
                    wp_reset_postdata();
                endif;
            }
        }

        // If still not enough (e.g., category is sparse), fall back to latest posts site-wide
        if (count($side_post_ids) < $target_side_count) {
            $fill_needed = $target_side_count - count($side_post_ids);
            if ($fill_needed > 0) {
                $fallback_args = array(
                    'posts_per_page' => $fill_needed,
                    'post__not_in' => array_unique(array_merge($hero_posts, $side_post_ids)),
                );
                $fallback_query = new WP_Query($fallback_args);
                if ($fallback_query->have_posts()) :
                    while ($fallback_query->have_posts()) : $fallback_query->the_post();
                        $side_post_ids[] = get_the_ID();
                    endwhile;
                    wp_reset_postdata();
                endif;
            }
        }

        $slider_post_ids = array_slice(array_merge(array($main_post_id), $side_post_ids), 0, 4);
?>
<section class="hero-section hero-v2">
    <div class="container mx-auto px-4">
        <div class="hero-v2-slider" dir="rtl">
            <?php foreach ($slider_post_ids as $idx => $post_id) : setup_postdata($GLOBALS['post'] = get_post($post_id)); ?>
                <article class="hero-v2-card">
                    <a href="<?php the_permalink(); ?>" class="hero-v2-card-link">
                        <div class="hero-v2-card-media">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('large', array('class' => 'hero-v2-card-img', 'loading' => 'lazy')); ?>
                            <?php else : ?>
                                <div class="hero-v2-card-placeholder"></div>
                            <?php endif; ?>
                            <div class="hero-v2-card-overlay"></div>
                            <div class="hero-v2-card-body">
                                <?php
                                $categories = get_the_category();
                                $badge_class = ($idx === 0) ? 'badge-purple' : (($idx === 1) ? 'badge-green' : (($idx === 2) ? 'badge-blue' : 'badge-orange'));
                                if (!empty($categories)) :
                                    echo '<span class="hero-v2-card-badge ' . esc_attr($badge_class) . '">' . esc_html($categories[0]->name) . '</span>';
                                endif;
                                ?>
                                <h3 class="hero-v2-card-title kufi"><?php the_title(); ?></h3>
                                <div class="hero-v2-card-meta">
                                    <span>By <?php the_author(); ?></span>
                                    <span><?php echo rand(8, 60); ?> Views</span>
                                    <span><?php echo esc_html(get_the_date()); ?></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </article>
            <?php endforeach; wp_reset_postdata(); ?>
        </div>
    </div>
</section>

<?php
    endif;
endif;
?>
