<?php
/**
 * Page Design 1: Classic Layout (Sidebar + Boxed)
 */
?>
<div class="bg-gray-50/50 min-h-screen pb-24">
    <!-- Page Hero Area -->
    <div class="bg-white border-b border-gray-100 mb-12 pt-12 pb-16">
        <div class="container mx-auto px-4">
            <?php if (sports_news_get_opt('page_show_breadcrumb', true)) : ?>
            <nav class="flex items-center justify-center text-[10px] md:text-xs text-gray-400 mb-10 kufi font-bold uppercase tracking-widest">
                <a href="<?php echo esc_url(home_url()); ?>" class="hover:text-primary transition flex items-center gap-1">
                    <i class="ri-home-4-line"></i> الرئيسية
                </a>
                <span class="mx-3 opacity-30">/</span>
                <span class="text-primary"><?php the_title(); ?></span>
            </nav>
            <?php endif; ?>

            <div class="max-w-4xl mx-auto text-center">
                <div class="inline-flex items-center gap-2 bg-gray-900 text-white text-[9px] md:text-[10px] font-black px-4 py-2 rounded-xl uppercase kufi mb-8 tracking-widest shadow-xl">
                    <i class="ri-file-text-line text-primary"></i> صفحة داخلية
                </div>

                <h1 class="text-4xl md:text-5xl lg:text-7xl font-black kufi text-gray-900 leading-[1.2] mb-8 tracking-tight">
                    <?php the_title(); ?>
                </h1>

                <?php if (has_excerpt()) : ?>
                    <div class="max-w-2xl mx-auto text-gray-500 font-bold text-base md:text-xl leading-relaxed kufi opacity-80 italic">
                        <?php the_excerpt(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 relative z-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            <main class="lg:col-span-8">

                <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-[3rem] shadow-[0_10px_40px_rgba(0,0,0,0.03)] border border-gray-100 overflow-hidden'); ?>>
                    
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="relative group overflow-hidden">
                            <div class="w-full">
                                <?php the_post_thumbnail('full', array('class' => 'w-full h-auto object-cover transition-transform duration-1000 group-hover:scale-110')); ?>
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent"></div>
                        </div>
                    <?php endif; ?>

                    <div class="p-8 md:p-14">
                        <div class="prose prose-xl max-w-none text-gray-800 arabic-content">
                            <?php 
                            the_content(); 
                            wp_link_pages(array(
                                'before' => '<div class="page-links">' . esc_html__('Pages:', 'drama-mojaz-theme'),
                                'after'  => '</div>',
                            ));
                            ?>
                        </div>

                        <?php if (sports_news_get_opt('page_show_share', true)) : ?>
                        <div class="mt-20 pt-10 border-t border-gray-50 flex flex-col md:flex-row justify-between items-center gap-8">
                            <div class="flex items-center gap-5">
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest kufi">انشر هذه الصفحة:</span>
                                <div class="flex gap-3">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-[#1877F2] hover:text-white hover:-translate-y-1 transition-all duration-300 shadow-sm"><i class="ri-facebook-fill text-xl"></i></a>
                                    <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-black hover:text-white hover:-translate-y-1 transition-all duration-300 shadow-sm"><i class="ri-twitter-x-fill text-xl"></i></a>
                                    <a href="https://wa.me/?text=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-primary hover:text-white hover:-translate-y-1 transition-all duration-300 shadow-sm"><i class="ri-whatsapp-line text-xl"></i></a>
                                </div>
                            </div>
                            <div class="flex flex-col items-end">
                                <span class="text-[9px] font-black text-gray-300 uppercase tracking-widest kufi mb-1">تاريخ المراجعة</span>
                                <span class="text-xs font-black text-primary kufi"><?php the_modified_date('j F Y'); ?></span>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php
                        if ( comments_open() || get_comments_number() ) :
                            echo '<div class="mt-24 pt-16 border-t border-gray-100">';
                            comments_template();
                            echo '</div>';
                        endif;
                        ?>
                    </div>
                </article>

            </main>

            <aside class="lg:col-span-4">
                <div class="sticky top-28">
                    <?php get_sidebar(); ?>
                </div>
            </aside>

        </div>
    </div>
</div>
