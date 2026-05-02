<?php
/**
 * Template part for the Videos section on the homepage
 */

if (!sports_news_get_opt('show_videos', true)) {
    return;
}

$videos_count = (int) sports_news_get_opt('videos_count', 4);
if ($videos_count < 1) {
    $videos_count = 1;
} elseif ($videos_count > 12) {
    $videos_count = 12;
}

$videos_category = sports_news_get_opt('videos_category', '');
$videos_query_args = array(
    'posts_per_page' => $videos_count,
    'post_status'    => 'publish',
);

if (!empty($videos_category)) {
    $videos_query_args['cat'] = (int) $videos_category;
}

$videos_query = new WP_Query($videos_query_args);
$videos_link  = !empty($videos_category) ? get_category_link((int) $videos_category) : get_permalink(get_option('page_for_posts'));
?>
<section class="video-gallery-section">
    <div class="container mx-auto px-4">
        <div class="video-gallery-header">
            <div class="editorial-section-heading section-title-bar">
                <h2 class="kufi editorial-section-title">
                    <i class="ri-movie-2-line" aria-hidden="true"></i>
                    <span><?php echo esc_html(sports_news_get_opt('videos_title', 'فيديو')); ?></span>
                </h2>
                <a class="editorial-section-more kufi" href="<?php echo esc_url($videos_link); ?>">
                    <span><?php esc_html_e('عرض الكل', 'drama-mojaz-theme'); ?></span>
                    <i class="ri-arrow-left-line" aria-hidden="true"></i>
                </a>
            </div>
        </div>

        <?php if ($videos_query->have_posts()) : ?>
            <?php $videos_query->the_post(); ?>
            <?php global $post; ?>
            <?php $featured_post = $post; ?>
            <?php $featured_categories = get_the_category($featured_post->ID); ?>
            <?php $has_list = $videos_query->have_posts(); ?>

            <div class="video-gallery-layout <?php echo $has_list ? 'has-list' : 'is-single'; ?>">
                <?php if ($has_list) : ?>
                    <div class="video-gallery-list">
                        <?php while ($videos_query->have_posts()) : $videos_query->the_post(); ?>
                            <?php $item_categories = get_the_category(); ?>
                            <article class="video-gallery-list-item">
                                <a class="video-gallery-list-link" href="<?php the_permalink(); ?>">
                                    <div class="video-gallery-list-media">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <?php the_post_thumbnail('thumbnail', array('class' => 'video-gallery-list-thumb', 'loading' => 'lazy')); ?>
                                        <?php else : ?>
                                            <div class="video-gallery-list-placeholder"><i class="ri-video-off-line"></i></div>
                                        <?php endif; ?>
                                        <span class="video-list-play"><i class="ri-play-fill"></i></span>
                                    </div>

                                    <div class="video-gallery-list-content">
                                        <?php if (!empty($item_categories)) : ?>
                                            <span class="video-gallery-list-category kufi"><?php echo esc_html($item_categories[0]->name); ?></span>
                                        <?php endif; ?>
                                        <h3 class="kufi"><?php the_title(); ?></h3>
                                        <div class="video-gallery-meta">
                                            <?php if (sports_news_get_opt('show_post_views', true)) : ?>
                                                <span><i class="ri-eye-line"></i> <?php echo sports_news_get_post_views(get_the_ID()); ?> <?php esc_html_e('مشاهدة', 'drama-mojaz-theme'); ?></span>
                                            <?php endif; ?>
                                            <span><i class="ri-user-3-line"></i> <?php the_author(); ?></span>
                                        </div>
                                    </div>
                                </a>
                            </article>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>

                <?php setup_postdata($featured_post); ?>
                <article class="video-gallery-featured">
                    <a class="video-gallery-featured-link" href="<?php the_permalink(); ?>">
                        <div class="video-gallery-featured-media">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('large', array('class' => 'video-gallery-featured-thumb', 'loading' => 'lazy')); ?>
                            <?php else : ?>
                                <div class="video-gallery-featured-placeholder"><i class="ri-video-off-line"></i></div>
                            <?php endif; ?>

                            <span class="video-featured-play"><i class="ri-play-fill"></i></span>
                            <?php if (!empty($featured_categories)) : ?>
                                <span class="video-featured-category kufi"><?php echo esc_html($featured_categories[0]->name); ?></span>
                            <?php endif; ?>
                            <span class="video-gallery-featured-overlay" aria-hidden="true"></span>
                        </div>

                        <div class="video-gallery-featured-content">
                            <h3 class="kufi"><?php the_title(); ?></h3>
                            <div class="video-gallery-meta">
                                <span><i class="ri-calendar-check-line"></i> <?php echo esc_html(get_the_date('j F Y')); ?></span>
                                <?php if (sports_news_get_opt('show_post_views', true)) : ?>
                                    <span><i class="ri-eye-line"></i> <?php echo sports_news_get_post_views(get_the_ID()); ?> <?php esc_html_e('مشاهدة', 'drama-mojaz-theme'); ?></span>
                                <?php endif; ?>
                                <span><i class="ri-user-3-line"></i> <?php the_author(); ?></span>
                            </div>
                        </div>
                    </a>
                </article>
            </div>

            <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <div class="video-gallery-empty">
                <i class="ri-video-off-line"></i>
                <p><?php esc_html_e('لا توجد فيديوهات متاحة حاليا', 'drama-mojaz-theme'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</section>
