<?php
/**
 * Archive Design 2: Modern List + Sidebar
 */
?>
<div class="container mx-auto px-4 pb-24">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        <!-- Posts List -->
        <div class="lg:col-span-8">
            <div class="flex flex-col gap-8">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-500 group flex flex-col md:flex-row h-full md:h-64">
                    <!-- Image Wrapper -->
                    <div class="relative w-full md:w-2/5 h-48 md:h-full overflow-hidden">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('large', array('class' => 'w-full h-full object-cover transition duration-1000 group-hover:scale-110')); ?>
                        <?php else: ?>
                            <div class="w-full h-full bg-gray-50 flex items-center justify-center">
                                <i class="ri-image-2-line text-5xl text-gray-200"></i>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Reading Time Overlay -->
                        <div class="absolute bottom-4 right-4 z-10">
                            <span class="bg-black/60 backdrop-blur-md text-white text-[9px] font-black px-3 py-1.5 rounded-lg kufi">
                                <i class="ri-time-line"></i> <?php echo sports_news_reading_time(); ?>
                            </span>
                        </div>
                    </div>
                    
                    <!-- Content Wrapper -->
                    <div class="p-6 md:p-8 flex flex-col flex-grow justify-center">
                        <div class="flex items-center gap-3 mb-4">
                            <?php
                            $categories = get_the_category();
                            if (!empty($categories)) echo '<a href="'.get_category_link($categories[0]->term_id).'" class="text-primary text-[10px] font-black uppercase kufi hover:underline">' . esc_html($categories[0]->name) . '</a>';
                            ?>
                            <span class="w-1 h-1 bg-gray-200 rounded-full"></span>
                            <span class="text-[10px] text-gray-400 font-bold kufi"><?php echo get_the_date(); ?></span>
                        </div>
                        
                        <h2 class="text-xl md:text-2xl font-black kufi text-gray-900 mb-4 line-clamp-2 leading-tight group-hover:text-primary transition-colors">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        
                        <?php if (sports_news_get_opt('archive_show_excerpt', true)) : ?>
                        <p class="text-gray-500 text-sm line-clamp-2 leading-relaxed mb-6 kufi opacity-80 hidden md:block">
                            <?php echo wp_trim_words(get_the_excerpt(), 25); ?>
                        </p>
                        <?php endif; ?>
                        
                        <div class="mt-auto flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="text-[11px] text-gray-400 font-bold kufi">بواسطة: </span>
                                <span class="text-[11px] text-gray-900 font-black kufi"><?php the_author(); ?></span>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="text-gray-900 hover:text-primary transition-colors">
                                <i class="ri-arrow-left-circle-fill text-3xl"></i>
                            </a>
                        </div>
                    </div>
                </article>
                <?php endwhile; else : ?>
                <div class="py-24 text-center bg-white rounded-[3rem] shadow-sm border border-dashed border-gray-100">
                    <h2 class="text-3xl font-black text-gray-900 mb-4 kufi">لا توجد نتائج</h2>
                </div>
                <?php endif; ?>
            </div>

            <?php get_template_part('template-parts/archive/pagination'); ?>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-4 mt-16 lg:mt-0">
            <div class="sticky top-24">
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>
</div>
