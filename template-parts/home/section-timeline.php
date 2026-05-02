<?php
/**
 * Template part for the Timeline section on the homepage
 */

if (!sports_news_get_opt('show_timeline', true)) {
    return;
}

$timeline_category      = sports_news_get_opt('timeline_category', '');
$timeline_category_link = !empty($timeline_category) ? get_category_link($timeline_category) : get_permalink(get_option('page_for_posts'));
$timeline_title         = sports_news_get_opt('timeline_title', 'آخر الأحداث');

$timeline_count = (int) sports_news_get_opt('timeline_count', 4);
if ($timeline_count < 3) {
    $timeline_count = 3;
} elseif ($timeline_count > 8) {
    $timeline_count = 8;
}

$timeline_posts_args = array(
    'posts_per_page'      => $timeline_count,
    'post_status'         => 'publish',
    'ignore_sticky_posts' => 1,
);

if (!empty($timeline_category)) {
    $timeline_posts_args['cat'] = (int) $timeline_category;
}

$timeline_posts = new WP_Query($timeline_posts_args);
?>
<section class="timeline-infographic-section">
    <div class="container mx-auto px-4">
        <div class="timeline-infographic-header">
            <div class="editorial-section-heading section-title-bar">
                <h2 class="kufi editorial-section-title timeline-infographic-title">
                    <i class="ri-time-line" aria-hidden="true"></i>
                    <span><?php echo esc_html($timeline_title); ?></span>
                </h2>
                <a href="<?php echo esc_url($timeline_category_link); ?>" class="editorial-section-more kufi" aria-label="<?php echo esc_attr($timeline_title); ?>">
                    <span><?php esc_html_e('عرض الكل', 'drama-mojaz-theme'); ?></span>
                    <i class="ri-arrow-left-line" aria-hidden="true"></i>
                </a>
            </div>
        </div>

        <?php if ($timeline_posts->have_posts()) : ?>
            <div class="timeline-infographic-grid">
                <?php while ($timeline_posts->have_posts()) : $timeline_posts->the_post(); ?>
                    <?php
                    $post_categories = get_the_category();
                    $timeline_badge  = !empty($post_categories) ? $post_categories[0]->name : __('عام', 'drama-mojaz-theme');
                    ?>
                    <article class="timeline-infographic-card">
                        <a href="<?php the_permalink(); ?>" class="timeline-infographic-card-link">
                            <div class="timeline-infographic-media">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium_large', array('class' => 'timeline-infographic-thumb', 'loading' => 'lazy')); ?>
                                <?php else : ?>
                                    <div class="timeline-infographic-placeholder"><i class="ri-image-line"></i></div>
                                <?php endif; ?>
                                <span class="timeline-infographic-category"><?php echo esc_html($timeline_badge); ?></span>
                            </div>
                            <div class="timeline-infographic-content">
                                <h3 class="kufi timeline-infographic-card-title"><?php the_title(); ?></h3>
                            </div>
                        </a>
                    </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        <?php else : ?>
            <div class="timeline-infographic-empty">
                <i class="ri-time-line" aria-hidden="true"></i>
                <p><?php esc_html_e('لا توجد أخبار متاحة الآن.', 'drama-mojaz-theme'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</section>
