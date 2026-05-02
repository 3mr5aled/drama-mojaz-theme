<?php
/**
 * Template part for Section Grid A
 */

$grid_a_category = sports_news_get_opt('grid_a_category', '');
if (!(sports_news_get_opt('show_grid_a', true) && !empty($grid_a_category))) {
    return;
}

$grid_a_title = sports_news_get_opt('grid_a_title', 'منوعات');
$grid_a_link  = get_category_link($grid_a_category);
$grid_a_count = (int) sports_news_get_opt('grid_a_count', 4);

$args = array(
    'posts_per_page' => $grid_a_count,
    'post_status'    => 'publish',
    'cat'            => $grid_a_category,
);

$grid_a_query = new WP_Query($args);
?>
<section class="py-12 md:py-16 bg-white section-grid-a">
    <div class="container mx-auto px-4">
        <div class="mb-8 relative editorial-section-header-wrap">
            <div class="editorial-section-heading editorial-section-heading-light section-title-bar">
                <h2 class="kufi editorial-section-title editorial-section-title-dark">
                    <i class="ri-layout-grid-line" aria-hidden="true"></i>
                    <span><?php echo esc_html($grid_a_title); ?></span>
                </h2>
                <a href="<?php echo esc_url($grid_a_link); ?>" class="editorial-section-more editorial-section-more-light kufi">
                    <span><?php esc_html_e('عرض الكل', 'drama-mojaz-theme'); ?></span>
                    <i class="ri-arrow-left-line" aria-hidden="true"></i>
                </a>
            </div>
        </div>

        <?php if ($grid_a_query->have_posts()) : ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                <?php while ($grid_a_query->have_posts()) : $grid_a_query->the_post(); ?>
                    <article class="group editorial-grid-card">
                        <a href="<?php the_permalink(); ?>" class="block editorial-grid-link">
                            <div class="relative aspect-[16/10] overflow-hidden rounded-lg mb-4 editorial-grid-media">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium_large', array(
                                        'class'   => 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-105',
                                        'loading' => 'lazy',
                                    )); ?>
                                <?php else : ?>
                                    <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                        <i class="ri-image-line text-4xl text-gray-300"></i>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <h3 class="kufi text-base md:text-lg font-bold text-gray-900 leading-tight line-clamp-2 group-hover:text-red-600 transition-colors editorial-grid-title">
                                <?php the_title(); ?>
                            </h3>
                        </a>
                    </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        <?php endif; ?>
    </div>
</section>
