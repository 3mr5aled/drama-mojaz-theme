<?php
/**
 * Template part for Section Grid C (3 Columns, Triple Sections)
 * Layout: 3 Columns side-by-side. Each column: 1 Large Post + 2 Small Horizontal Posts.
 */

$has_grid_c_cats = false;
for ($j = 1; $j <= 3; $j++) {
    if (!empty(sports_news_get_opt('grid_c_cat_' . $j))) {
        $has_grid_c_cats = true;
        break;
    }
}
if (sports_news_get_opt('show_grid_c', true) && $has_grid_c_cats) : ?>
<section class="py-12 md:py-16 bg-white section-grid-c">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-10">
            <?php
            for ($i = 1; $i <= 3; $i++) :
                $col_cat = sports_news_get_opt('grid_c_cat_' . $i, '');
                if (empty($col_cat)) continue; // Skip if no category assigned

                $col_title = sports_news_get_opt('grid_c_title_' . $i, ($i == 1 ? 'صحة' : ($i == 2 ? 'تكنولوجيا' : 'فن')));
                $col_link = !empty($col_cat) ? get_category_link($col_cat) : '#';

                // Query 3 posts for this column
                $args = array(
                    'posts_per_page' => 3,
                    'post_status'    => 'publish',
                    'ignore_sticky_posts' => true
                );
                if (!empty($col_cat)) {
                    $args['cat'] = $col_cat;
                }
                $query = new WP_Query($args);
                ?>
                
                <div class="section-column">
                    <!-- Column Header -->
                    <div class="grid-c-column-header">
                        <a href="<?php echo esc_url($col_link); ?>" class="grid-c-header-link" aria-label="<?php echo esc_attr($col_title); ?>">
                            <h2 class="kufi grid-c-header-title">
                                <span><?php echo esc_html($col_title); ?></span>
                                <span class="grid-c-header-dots" aria-hidden="true">&gt;&gt;&gt;</span>
                            </h2>
                        </a>
                    </div>

                    <?php if ($query->have_posts()) : $count = 0; ?>
                        <div class="flex flex-col gap-8 grid-c-posts">
                            <?php while ($query->have_posts()) : $query->the_post(); $count++; ?>
                                <?php if ($count === 1) : ?>
                                    <!-- Large Post -->
                                    <article class="group grid-c-featured-post">
                                        <a href="<?php the_permalink(); ?>" class="block grid-c-featured-link">
                                            <div class="relative aspect-[16/10] overflow-hidden rounded-xl shadow-sm grid-c-featured-media">
                                                <?php if (has_post_thumbnail()) : ?>
                                                    <?php the_post_thumbnail('medium_large', array(
                                                        'class' => 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-110',
                                                        'loading' => 'lazy'
                                                    )); ?>
                                                <?php else : ?>
                                                    <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                                        <i class="ri-image-line text-5xl text-gray-300"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <h3 class="kufi text-xl md:text-2xl font-black text-gray-900 leading-tight line-clamp-2 transition-colors grid-c-featured-title">
                                                <?php the_title(); ?>
                                            </h3>
                                        </a>
                                    </article>
                                <?php else : ?>
                                    <!-- Small Horizontal Post -->
                                    <article class="group flex gap-5 items-center">
                                        <div class="flex-1 order-2">
                                            <h4 class="kufi text-base md:text-lg font-bold text-gray-900 leading-snug line-clamp-2 group-hover:text-red-600 transition-colors text-left rtl:text-right">
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </h4>
                                        </div>
                                        <div class="w-28 h-20 md:w-36 md:h-24 shrink-0 overflow-hidden rounded-lg order-1 shadow-sm">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php if (has_post_thumbnail()) : ?>
                                                    <?php the_post_thumbnail('medium', array(
                                                        'class' => 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-110'
                                                    )); ?>
                                                <?php else : ?>
                                                    <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                                        <i class="ri-image-line text-2xl text-gray-300"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </a>
                                        </div>
                                    </article>
                                <?php endif; ?>
                            <?php endwhile; wp_reset_postdata(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</section>
<?php endif; ?>
