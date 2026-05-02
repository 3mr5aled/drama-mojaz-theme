<?php
/**
 * Archive Design 3: Masonry Full Width (No Sidebar)
 */
?>
<div class="container mx-auto px-4 pb-24">
    <!-- Masonry/Grid Full Width -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article class="bg-white rounded-3xl shadow-sm hover:shadow-2xl transition-all duration-700 group flex flex-col border border-gray-50 overflow-hidden h-full">
            <!-- Image Area -->
            <div class="relative aspect-square overflow-hidden">
                <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('medium_large', array('class' => 'w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110')); ?>
                <?php else: ?>
                    <div class="w-full h-full bg-gray-50 flex items-center justify-center">
                        <i class="ri-image-line text-4xl text-gray-200"></i>
                    </div>
                <?php endif; ?>
                
                <!-- Category Floating -->
                <div class="absolute top-4 left-4">
                    <?php
                    $categories = get_the_category();
                    if (!empty($categories)) echo '<a href="'.get_category_link($categories[0]->term_id).'" class="bg-primary text-white text-[8px] font-black px-3 py-1.5 rounded-full uppercase kufi shadow-lg">' . esc_html($categories[0]->name) . '</a>';
                    ?>
                </div>
                
                <!-- Date Overlay -->
                <div class="absolute bottom-0 inset-x-0 h-2/3 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex items-end p-6 translate-y-2 group-hover:translate-y-0 transition-transform duration-500">
                    <span class="text-white/80 text-[10px] font-bold kufi flex items-center gap-2">
                        <i class="ri-calendar-line text-primary"></i> <?php echo get_the_date(); ?>
                    </span>
                </div>
            </div>
            
            <!-- Content Area -->
            <div class="p-6 flex flex-col flex-grow">
                <h2 class="text-lg font-black kufi text-gray-900 mb-4 line-clamp-3 leading-[1.6] group-hover:text-primary transition-colors">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h2>
                
                <div class="mt-auto pt-4 border-t border-gray-50 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <?php echo get_avatar(get_the_author_meta('ID'), 24, '', '', array('class' => 'w-6 h-6 rounded-full border border-gray-200')); ?>
                        <span class="text-[10px] text-gray-500 font-bold kufi"><?php the_author(); ?></span>
                    </div>
                    <span class="text-[10px] text-primary font-black kufi opacity-0 group-hover:opacity-100 transition-opacity">
                        المزيد <i class="ri-arrow-left-s-line"></i>
                    </span>
                </div>
            </div>
        </article>
        <?php endwhile; else : ?>
        <div class="col-span-full py-24 text-center">
            <h2 class="text-3xl font-black text-gray-900 kufi">عفواً، لا توجد مقالات</h2>
        </div>
        <?php endif; ?>
    </div>

    <?php get_template_part('template-parts/archive/pagination'); ?>
</div>
