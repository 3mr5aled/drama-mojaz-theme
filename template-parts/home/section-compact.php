<?php
/**
 * Template part for the Compact Grid section on the homepage
 */

if (sports_news_get_opt('show_compact', true) !== false) : ?>
<!-- Compact Grid Section -->
<section class="py-12 md:py-16 bg-white compact-editorial-section">
    <div class="container mx-auto px-4">
        <!-- Section Header -->
        <?php 
        $compact_category = sports_news_get_opt('compact_category', '');
        $compact_category_link = !empty($compact_category) ? get_category_link($compact_category) : get_permalink(get_option('page_for_posts'));
        ?>
        <div class="compact-editorial-header section-title-bar">
            <h2 class="kufi"><?php echo sports_news_get_opt('compact_title', 'Ø§Ù„Ù…Ø²ÙŠØ¯ Ù…Ù† Ø§Ù„Ø£Ø®Ø¨Ø§Ø±'); ?></h2>
            <a href="<?php echo esc_url($compact_category_link); ?>" class="editorial-section-more kufi" aria-label="<?php esc_attr_e('More news', 'drama-mojaz-theme'); ?>">
                <span><?php esc_html_e("\u{0639}\u{0631}\u{0636} \u{0627}\u{0644}\u{0643}\u{0644}", 'drama-mojaz-theme'); ?></span>
                <i class="ri-arrow-left-line" aria-hidden="true"></i>
            </a>
        </div>

        <?php
        $compact_count = (int) sports_news_get_opt('compact_count', 8);
        $compact_category = sports_news_get_opt('compact_category', '');
        $more_posts_args = array(
            'posts_per_page' => $compact_count,
            'post_status' => 'publish',
        );
        if (!empty($compact_category)) {
            $more_posts_args['cat'] = $compact_category;
        }
        $more_posts = new WP_Query($more_posts_args);
        
        if ($more_posts->have_posts()) :
        ?>
        
        <?php
        $counter = 0;
        $featured_posts = array();
        $list_posts = array();
        
        while ($more_posts->have_posts() && $counter < $compact_count) : $more_posts->the_post();
            if ($counter < 2) {
                $featured_posts[] = get_post();
            } else {
                $list_posts[] = get_post();
            }
            $counter++;
        endwhile;
        wp_reset_postdata();
        ?>

        <!-- Top Row: 2 Featured Posts -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8 mb-6 md:mb-8 compact-editorial-featured-grid">
            <?php 
            global $post;
            foreach ($featured_posts as $compact_post) : $post = $compact_post; setup_postdata($post); ?>
            <article class="group compact-editorial-card compact-editorial-card-featured">
                <a href="<?php the_permalink(); ?>" class="block compact-editorial-card-link">
                    <!-- Image -->
                    <div class="relative aspect-[16/10] overflow-hidden mb-4 compact-editorial-media">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('medium_large', array(
                                'class' => 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-105',
                                'loading' => 'lazy'
                            )); ?>
                        <?php else : ?>
                            <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                <i class="ri-image-line text-3xl text-gray-300"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Content -->
                    <div class="compact-editorial-content">
                        <h3 class="text-gray-900 font-black kufi text-base md:text-lg leading-tight line-clamp-2 group-hover:text-primary transition-colors compact-editorial-title">
                            <?php the_title(); ?>
                        </h3>
                    </div>
                </a>
            </article>
            <?php endforeach; wp_reset_postdata(); ?>
        </div>

        <!-- Bottom Row: 3 Horizontal Posts -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8 compact-editorial-list-grid">
            <?php 
            global $post;
            foreach ($list_posts as $compact_post) : $post = $compact_post; setup_postdata($post); ?>
            <article class="group">
                <a href="<?php the_permalink(); ?>" class="flex flex-row-reverse gap-3 items-center">
                    <!-- Image (Right Side) -->
                    <div class="flex-shrink-0 w-20 h-20 md:w-24 md:h-24 overflow-hidden rounded-sm bg-transparent">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('thumbnail', array(
                                'class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-105',
                                'loading' => 'lazy'
                            )); ?>
                        <?php else : ?>
                            <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                <i class="ri-image-line text-xl text-gray-300"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Content (Left Side) -->
                    <div class="flex-1 text-right">
                        <h3 class="text-gray-900 font-bold kufi text-sm md:text-base leading-tight line-clamp-2 group-hover:text-primary transition-colors">
                            <?php the_title(); ?>
                        </h3>
                    </div>
                </a>
            </article>
            <?php endforeach; wp_reset_postdata(); ?>
        </div>
        
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>

