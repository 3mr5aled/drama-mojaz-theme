<!-- Related Posts - Premium Grid -->
<?php if (sports_news_get_opt('show_related_posts', true)) : ?>
<div class="mt-20">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-2xl font-black kufi flex items-center gap-3">
        <span class="w-3 h-8 bg-primary rounded-full shadow-[0_0_15px_rgba(227,27,35,0.3)]"></span>
            <span>أخبار قد تهمك</span>
        </h2>
        <?php
        $categories = get_the_category();
        if (!empty($categories)) : ?>
        <a href="<?php echo get_category_link($categories[0]->term_id); ?>" class="text-xs font-black kufi text-primary hover:underline">عرض المزيد</a>
        <?php endif; ?>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
        <?php
        $related_count = sports_news_get_opt('related_posts_count', 3);
        $related = new WP_Query(array(
            'posts_per_page' => $related_count,
            'post__not_in' => array(get_the_ID()),
            'orderby' => 'rand'
        ));
        while ($related->have_posts()) : $related->the_post();
        ?>
        <div class="bg-white rounded-[2rem] shadow-sm hover:shadow-xl transition-all duration-500 border border-gray-50 flex flex-col h-full group overflow-hidden">
            <div class="relative overflow-hidden aspect-[16/10]">
                <?php if (has_post_thumbnail()) : ?>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('medium', array('class' => 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-110')); ?>
                    </a>
                <?php endif; ?>
                <div class="absolute top-4 left-4">
                    <span class="bg-white/90 backdrop-blur-md text-gray-900 text-[9px] font-black px-3 py-1.5 rounded-full kufi shadow-sm">
                        <?php echo sports_news_reading_time(); ?>
                    </span>
                </div>
            </div>
            <div class="p-6 flex flex-col flex-grow">
                <h3 class="kufi font-black text-sm leading-relaxed line-clamp-2 hover:text-primary transition-colors mb-4 flex-grow">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h3>
                <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                    <span class="text-[10px] text-gray-400 font-bold kufi">
                        <?php echo get_the_date(); ?>
                    </span>
                    <a href="<?php the_permalink(); ?>" class="text-primary text-[10px] font-black kufi flex items-center gap-1 group/btn">
                        <i class="ri-arrow-left-s-line group-hover:-translate-x-1 transition-transform"></i> المزيد
                    </a>
                </div>
            </div>
        </div>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>
</div>
<?php endif; ?>
