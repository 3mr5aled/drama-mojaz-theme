<?php
/**
 * Design 3: Modern Hero Layout (Full Width Featured Image + Title Overlay)
 */
?>
<div class="bg-gray-50/30 pb-16">
    <!-- Immersive Hero Area -->
    <div class="relative w-full h-[60vh] md:h-[75vh] overflow-hidden bg-gray-900">
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('full', array('class' => 'w-full h-full object-cover scale-105 blur-[2px] opacity-60 animate-slow-zoom')); ?>
            <style>
                @keyframes slow-zoom {
                    from { transform: scale(1.05); }
                    to { transform: scale(1.15); }
                }
                .animate-slow-zoom { animation: slow-zoom 20s infinite alternate ease-in-out; }
            </style>
        <?php endif; ?>

        <!-- Content Overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent flex items-end">
            <div class="container mx-auto px-4 pb-16 md:pb-24">
                <div class="max-w-4xl">
                    <!-- Category Badge -->
                    <?php
                    $categories = get_the_category();
                    if (!empty($categories)) : ?>
                        <a href="<?php echo get_category_link($categories[0]->term_id); ?>" class="inline-block bg-primary text-white text-[10px] font-black px-4 py-1.5 rounded-full uppercase kufi mb-6 hover:bg-white hover:text-primary transition-all duration-300">
                            <?php echo esc_html($categories[0]->name); ?>
                        </a>
                    <?php endif; ?>

                    <h1 class="text-4xl md:text-6xl font-black kufi text-white leading-tight mb-8 drop-shadow-2xl">
                        <?php the_title(); ?>
                    </h1>

                    <div class="flex flex-wrap items-center gap-6 text-white/80 kufi font-bold text-xs">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-white/20">
                                <?php echo get_avatar(get_the_author_meta('ID'), 40); ?>
                            </div>
                            <span class="text-white"><?php the_author(); ?></span>
                        </div>
                        <span class="w-1.5 h-1.5 bg-primary rounded-full"></span>
                        <div class="flex items-center gap-1.5">
                            <i class="ri-calendar-check-fill text-primary"></i>
                            <?php echo get_the_date('j F Y'); ?>
                        </div>
                        <span class="w-1.5 h-1.5 bg-white/20 rounded-full"></span>
                        <div class="flex items-center gap-1.5">
                            <i class="ri-fire-fill text-primary"></i>
                            <?php echo sports_news_get_post_views(get_the_ID()); ?> مشاهدة
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Breadcrumbs Overlayed Bar -->
    <div class="bg-black/5 backdrop-blur-md border-b border-gray-100 py-4">
        <div class="container mx-auto px-4">
            <nav class="flex items-center text-[10px] text-gray-400 kufi font-bold uppercase">
                <a href="<?php echo esc_url(home_url()); ?>" class="hover:text-primary transition flex items-center gap-1">
                    <i class="ri-home-fill"></i> الرئيسية
                </a>
                <span class="mx-3 opacity-30">/</span>
                <span class="text-gray-900 truncate"><?php the_title(); ?></span>
            </nav>
        </div>
    </div>

    <div class="container mx-auto px-4 mt-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <!-- Main Content -->
            <main class="lg:col-span-8">
                <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-[3rem] p-6 md:p-12 shadow-xl shadow-gray-200/50 border border-gray-100'); ?>>
                    <?php if (sports_news_get_opt('show_audio_player', true)) : ?>
                    <?php get_template_part('template-parts/post/content-player'); ?>
                    <?php endif; ?>

                    <div class="prose prose-xl max-w-none text-gray-800 arabic-content" id="articleContent">
                        <?php 
                        the_content(); 
                        wp_link_pages(array(
                            'before' => '<div class="page-links">' . esc_html__('Pages:', 'drama-mojaz-theme'),
                            'after'  => '</div>',
                        ));
                        ?>
                    </div>

                    <?php get_template_part('template-parts/post/content-footer'); ?>
                </article>

                <?php get_template_part('template-parts/post/content-related'); ?>
                <?php get_template_part('template-parts/post/content-comments'); ?>
                <?php endwhile; ?>
            </main>

            <!-- Sidebar -->
            <div class="lg:col-span-4 lg:mt-0">
                <div class="sticky top-24">
                     <!-- Featured Sidebar Decoration -->
                     <div class="bg-gray-900 rounded-[2.5rem] p-8 mb-8 text-white relative overflow-hidden group">
                        <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-primary/20 rounded-full blur-3xl group-hover:bg-primary/40 transition-all"></div>
                        <h4 class="kufi font-black text-xl mb-4 relative z-10">تحليل المباراة</h4>
                        <p class="text-white/60 text-xs kufi leading-relaxed relative z-10">تابع أدق التفاصيل والتحليلات الخاصة بهذا المقال من خلال شريطنا الجانبي المخصص.</p>
                     </div>
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
