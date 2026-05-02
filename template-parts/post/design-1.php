<?php
/**
 * Design 1: Classic Layout (Sidebar + Boxed Content)
 */
?>
<div class="bg-gray-50/50 pb-16">
    <!-- Post Hero Area - Immersive Header -->
    <div class="bg-white border-b border-gray-100 mb-8 pt-8">
        <div class="container mx-auto px-4">
            <!-- Breadcrumbs -->
            <nav class="flex items-center text-[10px] md:text-xs text-gray-400 mb-8 kufi font-bold uppercase tracking-wider">
                <a href="<?php echo esc_url(home_url()); ?>" class="hover:text-primary transition flex items-center gap-1">
                    <i class="ri-home-4-line"></i> الرئيسية
                </a>
                <span class="mx-3 opacity-30">/</span>
                <?php
                $categories = get_the_category();
                if (!empty($categories)) :
                    echo '<a href="' . get_category_link($categories[0]->term_id) . '" class="hover:text-primary transition">' . esc_html($categories[0]->name) . '</a>';
                    echo '<span class="mx-3 opacity-30">/</span>';
                endif;
                ?>
                <span class="text-gray-300 line-clamp-1 truncate max-w-[200px]"><?php the_title(); ?></span>
            </nav>

            <div class="max-w-4xl mx-auto text-center mb-10">
                <?php if (!empty($categories)) : ?>
                    <a href="<?php echo get_category_link($categories[0]->term_id); ?>" class="inline-flex items-center gap-2 bg-primary/10 text-primary text-[10px] md:text-xs font-black px-4 py-2 rounded-full uppercase kufi mb-6 hover:bg-primary hover:text-white transition-all duration-300">
                        <i class="ri-bookmark-3-fill"></i>
                        <?php echo esc_html($categories[0]->name); ?>
                    </a>
                <?php endif; ?>

                <h1 class="text-3xl md:text-4xl lg:text-5xl font-black kufi text-gray-900 leading-[1.3] mb-8">
                    <?php the_title(); ?>
                </h1>

                <div class="flex flex-wrap items-center justify-center gap-6 text-gray-500 kufi font-bold text-xs">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full overflow-hidden ring-2 ring-gray-100">
                            <?php echo get_avatar(get_the_author_meta('ID'), 32); ?>
                        </div>
                        <span class="text-gray-900"><?php the_author(); ?></span>
                    </div>
                    <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                    <div class="flex items-center gap-1.5">
                        <i class="ri-calendar-check-line text-primary"></i>
                        <?php echo get_the_date('j F Y'); ?>
                    </div>
                    <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                    <div class="flex items-center gap-1.5">
                        <i class="ri-time-line text-primary"></i>
                        <?php echo sports_news_reading_time(); ?>
                    </div>
                    <?php if (sports_news_get_opt('show_post_views', true)) : ?>
                        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                        <div class="flex items-center gap-1.5">
                            <i class="ri-eye-line text-primary"></i>
                            <?php echo sports_news_get_post_views(get_the_ID()); ?> مشاهدة
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <!-- Main Content -->
            <main class="lg:col-span-8">
                <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-3xl shadow-[0_10px_40px_rgba(0,0,0,0.03)] border border-gray-100 overflow-hidden'); ?>>
                    <!-- Featured Image Area -->
                    <?php if (has_post_thumbnail()) : ?>
                    <div class="relative group overflow-hidden">
                        <div class="w-full">
                            <?php the_post_thumbnail('large', array('class' => 'w-full h-auto object-cover transition-transform duration-1000 group-hover:scale-110')); ?>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent"></div>
                    </div>
                    <?php endif; ?>

                    <div class="p-6 md:p-10">
                        <?php if (sports_news_get_opt('show_audio_player', true)) : ?>
                        <?php get_template_part('template-parts/post/content-player'); ?>
                        <?php endif; ?>

                        <!-- Article Content - Premium Typography -->
                        <div class="prose prose-lg max-w-none text-gray-800 arabic-content" id="articleContent">
                            <?php 
                            the_content(); 
                            wp_link_pages(array(
                                'before' => '<div class="page-links">' . esc_html__('Pages:', 'drama-mojaz-theme'),
                                'after'  => '</div>',
                            ));
                            ?>
                        </div>

                        <?php get_template_part('template-parts/post/content-footer'); ?>
                    </div>
                </article>

                <?php get_template_part('template-parts/post/content-related'); ?>
                <?php get_template_part('template-parts/post/content-comments'); ?>
                <?php endwhile; ?>
            </main>

            <!-- Sidebar -->
            <div class="lg:col-span-4 mt-12 lg:mt-0">
                <div class="sticky top-24">
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
