<?php
/**
 * Page Design 2: Focused Layout (Centered, No Sidebar)
 */
?>
<div class="bg-white min-h-screen pb-24">
    <!-- Clean Minimalist Header -->
    <div class="pt-20 pb-16">
        <div class="container mx-auto px-4">
            <?php if (sports_news_get_opt('page_show_breadcrumb', true)) : ?>
            <nav class="flex items-center justify-center text-[10px] text-gray-400 mb-8 kufi font-bold uppercase tracking-[0.2em] opacity-60">
                <a href="<?php echo esc_url(home_url()); ?>" class="hover:text-primary transition">الرئيسية</a>
                <span class="mx-3">/</span>
                <span><?php the_title(); ?></span>
            </nav>
            <?php endif; ?>

            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-4xl md:text-6xl font-black kufi text-gray-900 leading-tight mb-8">
                    <?php the_title(); ?>
                </h1>
                
                <?php if (has_excerpt()) : ?>
                    <div class="text-gray-500 font-medium text-lg md:text-xl leading-relaxed kufi opacity-70">
                        <?php the_excerpt(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                
                <?php if (has_post_thumbnail()) : ?>
                    <div class="mb-16 rounded-[2.5rem] overflow-hidden shadow-2xl shadow-gray-200/50">
                        <?php the_post_thumbnail('full', array('class' => 'w-full h-auto')); ?>
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
                <div class="mt-24 pt-10 border-t border-gray-100 flex justify-center items-center">
                    <div class="flex items-center gap-6">
                        <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest kufi">شارك هذه الصفحة</span>
                        <div class="flex gap-4">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="text-gray-400 hover:text-[#1877F2] transition-colors"><i class="ri-facebook-box-fill text-2xl"></i></a>
                            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="text-gray-400 hover:text-black transition-colors"><i class="ri-twitter-x-fill text-2xl"></i></a>
                            <a href="https://wa.me/?text=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="text-gray-400 hover:text-primary transition-colors"><i class="ri-whatsapp-fill text-2xl"></i></a>
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
