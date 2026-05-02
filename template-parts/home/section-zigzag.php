<?php
/**
 * Template part for the Zigzag section on the homepage
 */

if (!sports_news_get_opt('show_zigzag', true)) {
    return;
}

$zigzag_category = sports_news_get_opt('zigzag_category', '');
$zigzag_count = (int) sports_news_get_opt('zigzag_count', 6);
if ($zigzag_count < 2) {
    $zigzag_count = 2;
} elseif ($zigzag_count > 12) {
    $zigzag_count = 12;
}

$zigzag_posts_args = array(
    'posts_per_page' => $zigzag_count,
    'post_status' => 'publish',
    'meta_query' => array(
        array(
            'key' => '_thumbnail_id',
            'compare' => 'EXISTS',
        ),
    ),
);

if (!empty($zigzag_category)) {
    $zigzag_posts_args['cat'] = (int) $zigzag_category;
}

$zigzag_posts = new WP_Query($zigzag_posts_args);
?>
<section class="zigzag-photo-section">
    <div class="container mx-auto px-4">
        <div class="zigzag-photo-header section-title-bar">
            <h2 class="kufi">
                <i class="ri-image-line" aria-hidden="true"></i>
                <span><?php echo esc_html(sports_news_get_opt('zigzag_title', 'Ù‚ØµØµ Ù…Ù…ÙŠØ²Ø©')); ?></span>
            </h2>
            <?php $zigzag_category_link = !empty($zigzag_category) ? get_category_link((int) $zigzag_category) : get_permalink(get_option('page_for_posts')); ?>
            <a class="editorial-section-more kufi" href="<?php echo esc_url($zigzag_category_link); ?>">
                <span><?php esc_html_e("\u{0639}\u{0631}\u{0636} \u{0627}\u{0644}\u{0643}\u{0644}", 'drama-mojaz-theme'); ?></span>
                <i class="ri-arrow-left-line" aria-hidden="true"></i>
            </a>
        </div>

        <?php if ($zigzag_posts->have_posts()) : ?>
            <?php
            $posts = array();
            while ($zigzag_posts->have_posts()) {
                $zigzag_posts->the_post();
                $posts[] = get_post();
            }
            wp_reset_postdata();
            ?>

            <div class="zigzag-featured-grid">
                <div class="zigzag-top-row">
                    <?php for ($i = 0; $i < 2 && isset($posts[$i]); $i++) : ?>
                        <?php $post = $posts[$i]; setup_postdata($post); ?>
                        <article class="zigzag-card zigzag-card-lg">
                            <a href="<?php the_permalink(); ?>">
                                <div class="zigzag-card-media">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('large', array('class' => 'zigzag-thumb', 'loading' => 'lazy')); ?>
                                    <?php else : ?>
                                        <div class="zigzag-placeholder"><i class="ri-image-line"></i></div>
                                    <?php endif; ?>
                                </div>
                                <span class="zigzag-card-icon"><i class="ri-camera-2-fill"></i></span>
                                <?php $categories = get_the_category(); ?>
                                <?php if (!empty($categories)) : ?>
                                    <span class="zigzag-card-category kufi"><?php echo esc_html($categories[0]->name); ?></span>
                                <?php endif; ?>
                                <div class="zigzag-card-title zigzag-card-title-lg">
                                    <h3 class="kufi"><?php the_title(); ?></h3>
                                </div>
                            </a>
                        </article>
                    <?php endfor; ?>
                </div>

                <div class="zigzag-bottom-row">
                    <?php for ($i = 2; $i < $zigzag_count && isset($posts[$i]); $i++) : ?>
                        <?php $post = $posts[$i]; setup_postdata($post); ?>
                        <article class="zigzag-card zigzag-card-sm">
                            <a href="<?php the_permalink(); ?>">
                                <div class="zigzag-card-media">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('medium_large', array('class' => 'zigzag-thumb', 'loading' => 'lazy')); ?>
                                    <?php else : ?>
                                        <div class="zigzag-placeholder"><i class="ri-image-line"></i></div>
                                    <?php endif; ?>
                                </div>
                                <span class="zigzag-card-icon"><i class="ri-camera-2-fill"></i></span>
                                <?php $categories = get_the_category(); ?>
                                <?php if (!empty($categories)) : ?>
                                    <span class="zigzag-card-category kufi"><?php echo esc_html($categories[0]->name); ?></span>
                                <?php endif; ?>
                                <div class="zigzag-card-title zigzag-card-title-sm">
                                    <h3 class="kufi"><?php the_title(); ?></h3>
                                </div>
                            </a>
                        </article>
                    <?php endfor; ?>
                </div>
            </div>
            <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <div class="zigzag-empty">
                <i class="ri-article-line"></i>
                <p>Ù„Ø§ ØªÙˆØ¬Ø¯ Ù‚ØµØµ Ù…ØªØ§Ø­Ø© ÙÙŠ Ù‡Ø°Ø§ Ø§Ù„Ù‚Ø³Ù… Ø­Ø§Ù„ÙŠØ§Ù‹.</p>
            </div>
        <?php endif; ?>
    </div>
</section>
