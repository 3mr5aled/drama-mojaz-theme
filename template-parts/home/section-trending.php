<?php
/**
 * Template part for the Trending section on the homepage - Sports Layout
 */

if (!sports_news_get_opt('show_trending', true)) {
    return;
}
?>
<section class="trending-mosaic-section">
    <div class="container mx-auto px-4">
        <div class="trending-mosaic-header section-title-bar">
            <h2 class="kufi">
                <i class="ri-football-line trending-icon"></i>
                <span><?php echo sports_news_get_opt('trending_title', 'Ø§Ù„Ø£ÙƒØ«Ø± Ù‚Ø±Ø§Ø¡Ø©'); ?></span>
            </h2>
            <?php 
            $trending_category = sports_news_get_opt('trending_category', '');
            $trending_category_link = !empty($trending_category) ? get_category_link($trending_category) : get_permalink(get_option('page_for_posts'));
            ?>
            <a class="editorial-section-more kufi" href="<?php echo esc_url($trending_category_link); ?>">
                <span><?php esc_html_e("\u{0639}\u{0631}\u{0636} \u{0627}\u{0644}\u{0643}\u{0644}", 'drama-mojaz-theme'); ?></span>
                <i class="ri-arrow-left-line" aria-hidden="true"></i>
            </a>
        </div>

        <?php
        $trending_count = (int) sports_news_get_opt('trending_count', 5);
        if ($trending_count < 3) {
            $trending_count = 3;
        } elseif ($trending_count > 10) {
            $trending_count = 10;
        }

        $trending_posts_args = array(
            'posts_per_page' => $trending_count,
            'meta_key' => 'post_views_count',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
            'post_status' => 'publish'
        );

        $trending_category = sports_news_get_opt('trending_category', '');
        if (!empty($trending_category)) {
            $trending_posts_args['cat'] = intval($trending_category);
        }

        $trending_posts = new WP_Query($trending_posts_args);

        if ($trending_posts->have_posts()) :
            global $post;
            $posts = array();
            while ($trending_posts->have_posts()) {
                $trending_posts->the_post();
                $posts[] = get_post();
            }
            wp_reset_postdata();
        ?>

        <div class="trending-mosaic-desktop">
            <div class="trending-col trending-col-featured">
                <?php if (isset($posts[0])) : $post = $posts[0]; setup_postdata($post); ?>
                <article class="trending-card trending-card-featured">
                    <a href="<?php the_permalink(); ?>">
                        <div class="trending-card-media">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('large', array('class' => 'trending-thumb')); ?>
                            <?php else : ?>
                                <div class="trending-placeholder"><i class="ri-image-line"></i></div>
                            <?php endif; ?>
                        </div>
                        <div class="trending-overlay-title">
                            <h3 class="kufi"><?php the_title(); ?></h3>
                        </div>
                    </a>
                </article>
                <?php endif; ?>
            </div>

            <div class="trending-col trending-col-middle">
                <?php for ($i = 1; $i < 3 && isset($posts[$i]); $i++) : $post = $posts[$i]; setup_postdata($post); ?>
                <article class="trending-card trending-card-middle">
                    <a href="<?php the_permalink(); ?>">
                        <div class="trending-card-media">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium_large', array('class' => 'trending-thumb')); ?>
                            <?php else : ?>
                                <div class="trending-placeholder"><i class="ri-image-line"></i></div>
                            <?php endif; ?>
                        </div>
                        <div class="trending-overlay-title">
                            <h3 class="kufi"><?php the_title(); ?></h3>
                        </div>
                    </a>
                </article>
                <?php endfor; ?>
            </div>

            <div class="trending-col trending-col-list">
                <?php for ($i = 3; $i < $trending_count && isset($posts[$i]); $i++) : $post = $posts[$i]; setup_postdata($post); ?>
                <article class="trending-card trending-card-list">
                    <a href="<?php the_permalink(); ?>">
                        <div class="trending-list-title-wrap">
                            <h3 class="kufi"><?php the_title(); ?></h3>
                        </div>
                        <div class="trending-list-media">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium', array('class' => 'trending-thumb')); ?>
                            <?php else : ?>
                                <div class="trending-placeholder"><i class="ri-image-line"></i></div>
                            <?php endif; ?>
                        </div>
                    </a>
                </article>
                <?php endfor; ?>
            </div>
        </div>

        <div class="trending-mosaic-mobile">
            <?php foreach ($posts as $index => $trending_post) :
                if ($index >= $trending_count) {
                    break;
                }
                $post = $trending_post;
                setup_postdata($post);
            ?>
            <article class="trending-mobile-item <?php echo ($index === 0) ? 'featured' : ''; ?>">
                <a href="<?php the_permalink(); ?>">
                    <div class="trending-mobile-media">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('large', array('class' => 'trending-thumb')); ?>
                        <?php else : ?>
                            <div class="trending-placeholder"><i class="ri-image-line"></i></div>
                        <?php endif; ?>
                    </div>
                    <div class="trending-mobile-title"><h3 class="kufi"><?php the_title(); ?></h3></div>
                </a>
            </article>
            <?php endforeach; ?>
        </div>

        <?php 
        wp_reset_postdata(); 
        else : 
        ?>
        <div class="trending-empty">
            <i class="ri-article-line"></i>
            <p>Ù„Ø§ ØªÙˆØ¬Ø¯ Ù…Ù‚Ø§Ù„Ø§Øª ÙÙŠ Ù‡Ø°Ø§ Ø§Ù„ØªØµÙ†ÙŠÙ</p>
        </div>
        <?php endif; ?>
    </div>
</section>
