<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Drama_Mojaz_Theme
 * 
 * Drama Mojaz Theme is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 */

get_header(); ?>

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-white flex items-center justify-center py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto text-center">
            <!-- 404 Icon -->
            <div class="mb-8 relative">
                <span class="text-9xl md:text-[12rem] font-black text-primary opacity-20 select-none">404</span>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                    <i class="ri-error-warning-line text-6xl md:text-7xl text-primary animate-pulse"></i>
                </div>
            </div>
            
            <!-- Title -->
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-black kufi text-gray-900 mb-4 md:mb-6">
                <?php echo sports_news_get_opt('404_title', 'الصفحة غير موجودة'); ?>
            </h1>
            
            <!-- Message -->
            <div class="text-gray-600 text-base md:text-lg mb-8 md:mb-12 leading-relaxed max-w-xl mx-auto">
                <?php echo wpautop(sports_news_get_opt('404_message', 'عذراً، الصفحة التي تبحث عنها غير موجودة أو تم نقلها إلى موقع آخر.')); ?>
            </div>
            
            <!-- Search Form -->
            <?php if (sports_news_get_opt('show_404_search', true)) : ?>
            <div class="max-w-md mx-auto mb-8 md:mb-12">
                <?php get_search_form(); ?>
            </div>
            <?php endif; ?>
            
            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="<?php echo esc_url(home_url()); ?>" class="inline-flex items-center gap-2 bg-primary text-white px-8 py-4 rounded-2xl font-bold kufi hover:bg-secondary transition-all shadow-lg shadow-primary/20 hover:shadow-secondary/20 hover:-translate-y-1">
                    <i class="ri-home-line text-xl"></i>
                    العودة للرئيسية
                </a>
                <button onclick="history.back()" class="inline-flex items-center gap-2 bg-gray-100 text-gray-900 px-8 py-4 rounded-2xl font-bold kufi hover:bg-gray-200 transition-all">
                    <i class="ri-arrow-right-line text-xl"></i>
                    الصفحة السابقة
                </button>
            </div>
            
            <!-- Popular Posts -->
            <div class="mt-16 md:mt-20">
                <h2 class="text-xl md:text-2xl font-black kufi text-gray-900 mb-6 md:mb-8">قد تكون مهتماً بـ</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <?php
                    $popular = new WP_Query(array('posts_per_page' => 3, 'orderby' => 'comment_count'));
                    while ($popular->have_posts()) : $popular->the_post();
                    ?>
                    <article class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all group">
                        <a href="<?php the_permalink(); ?>" class="block">
                            <div class="relative aspect-video overflow-hidden">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium', array('class' => 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-700')); ?>
                                <?php else : ?>
                                    <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                        <i class="ri-image-line text-4xl text-gray-300"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="p-4">
                                <h3 class="font-bold kufi text-sm md:text-base leading-tight line-clamp-2 group-hover:text-primary transition-colors">
                                    <?php the_title(); ?>
                                </h3>
                                <div class="flex items-center gap-2 text-gray-400 text-xs mt-2">
                                    <i class="ri-time-line"></i>
                                    <span><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' منذ'; ?></span>
                                </div>
                            </div>
                        </a>
                    </article>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
