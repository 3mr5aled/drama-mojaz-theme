<?php
/**
 * Page Design 3: Premium Layout (Hero Image + Focused)
 */
?>
<div class="bg-gray-50/30 min-h-screen pb-24">
    <!-- Immersive Page Hero -->
    <div class="relative w-full h-[50vh] min-h-[400px] overflow-hidden bg-gray-900 flex items-center justify-center text-center">
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('full', array('class' => 'absolute inset-0 w-full h-full object-cover opacity-40 scale-105 blur-[1px]')); ?>
        <?php endif; ?>
        
        <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/20 to-gray-50/30"></div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-4xl mx-auto">
                <?php if (sports_news_get_opt('page_show_breadcrumb', true)) : ?>
                <nav class="flex items-center justify-center text-[10px] text-white/60 mb-8 kufi font-bold uppercase tracking-[0.3em]">
                    <a href="<?php echo esc_url(home_url()); ?>" class="hover:text-primary transition">الرئيسية</a>
                    <span class="mx-4 opacity-30">/</span>
                    <span class="text-white"><?php the_title(); ?></span>
                </nav>
                <?php endif; ?>

                <h1 class="text-5xl md:text-7xl font-black kufi text-white leading-tight mb-8 drop-shadow-2xl">
                    <?php the_title(); ?>
                </h1>

                <div class="w-20 h-1.5 bg-primary mx-auto rounded-full shadow-lg shadow-primary/40"></div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 -mt-20 relative z-20">
        <div class="max-w-4xl mx-auto">

            <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-[3.5rem] shadow-2xl shadow-gray-200/50 p-10 md:p-20 border border-white'); ?>>
                
                <?php if (has_excerpt()) : ?>
                    <div class="mb-12 pb-12 border-b border-gray-100 text-gray-500 font-bold text-xl md:text-2xl leading-relaxed kufi text-center">
                        <?php the_excerpt(); ?>
                    </div>
                <?php endif; ?>

                <div class="prose prose-xl max-w-none text-gray-800 arabic-content !text-xl">
                    <?php 
                    the_content(); 
                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . esc_html__('Pages:', 'drama-mojaz-theme'),
                        'after'  => '</div>',
                    ));
                    ?>
                </div>

                <?php if (sports_news_get_opt('page_show_share', true)) : ?>
                <div class="mt-20 pt-10 border-t border-gray-50 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <span class="w-10 h-10 rounded-full bg-gray-50 border border-gray-100 flex items-center justify-center text-primary">
                            <i class="ri-share-forward-line"></i>
                        </span>
                        <div class="flex gap-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-[#1877F2] hover:text-white transition-all"><i class="ri-facebook-fill"></i></a>
                            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-black hover:text-white transition-all"><i class="ri-twitter-x-fill"></i></a>
                            <a href="https://wa.me/?text=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-primary hover:text-white transition-all"><i class="ri-whatsapp-line"></i></a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <?php
                if ( comments_open() || get_comments_number() ) :
                    echo '<div class="mt-20">';
                    comments_template();
                    echo '</div>';
                endif;
                ?>
            </article>

        </div>
    </div>
</div>
