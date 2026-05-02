<?php
/**
 * Design 2: Clean Wide Layout (No Sidebar + Centered Content)
 */
?>
<div class="bg-white pb-20">
    <!-- Clean Header -->
    <div class="container mx-auto px-4 pt-12">
        <div class="max-w-3xl mx-auto text-center">
            <!-- Breadcrumbs Simplified -->
            <nav class="flex items-center justify-center text-[10px] text-gray-400 mb-6 kufi font-bold uppercase tracking-widest gap-2">
                <a href="<?php echo esc_url(home_url()); ?>" class="hover:text-primary transition">الرئيسية</a>
                <span class="opacity-30">/</span>
                <?php
                $categories = get_the_category();
                if (!empty($categories)) : ?>
                    <a href="<?php echo get_category_link($categories[0]->term_id); ?>" class="hover:text-primary transition"><?php echo esc_html($categories[0]->name); ?></a>
                <?php endif; ?>
            </nav>

            <h1 class="text-3xl md:text-5xl font-black kufi text-gray-900 leading-tight mb-8">
                <?php the_title(); ?>
            </h1>

            <div class="flex items-center justify-center gap-6 text-gray-400 kufi font-bold text-[10px] md:text-xs">
                 <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded-full overflow-hidden ring-2 ring-gray-100">
                        <?php echo get_avatar(get_the_author_meta('ID'), 24); ?>
                    </div>
                    <span class="text-gray-600"><?php the_author(); ?></span>
                </div>
                <div class="flex items-center gap-1.5">
                    <i class="ri-calendar-line"></i>
                    <?php echo get_the_date('j F Y'); ?>
                </div>
                <div class="flex items-center gap-1.5">
                    <i class="ri-time-line"></i>
                    <?php echo sports_news_reading_time(); ?>
                </div>
            </div>
        </div>

        <div class="max-w-5xl mx-auto mt-12">
             <!-- Featured Image - Seamless -->
            <?php if (has_post_thumbnail()) : ?>
            <div class="rounded-[2rem] overflow-hidden shadow-2xl shadow-gray-200/50">
                <?php the_post_thumbnail('full', array('class' => 'w-full h-auto')); ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="container mx-auto px-4 mt-16">
        <div class="max-w-3xl mx-auto">
            <?php while (have_posts()) : the_post(); ?>
            <main id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php if (sports_news_get_opt('show_audio_player', true)) : ?>
                <?php get_template_part('template-parts/post/content-player'); ?>
                <?php endif; ?>

                <!-- Article Content - Focused Typography -->
                <div class="prose prose-xl max-w-none text-gray-800 arabic-content !text-xl" id="articleContent">
                    <?php 
                    the_content(); 
                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . esc_html__('Pages:', 'drama-mojaz-theme'),
                        'after'  => '</div>',
                    ));
                    ?>
                </div>

                <?php get_template_part('template-parts/post/content-footer'); ?>
            </main>

            <!-- Related & Comments also Centered -->
            <div class="mt-24">
                <?php get_template_part('template-parts/post/content-related'); ?>
                <?php get_template_part('template-parts/post/content-comments'); ?>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>
