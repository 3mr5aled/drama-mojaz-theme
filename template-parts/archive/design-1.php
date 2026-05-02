<?php
/**
 * Archive Design 1: Premium Grid + Sidebar
 */
?>
<div class="container mx-auto px-4 pb-24">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        <!-- Posts List -->
        <div class="lg:col-span-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-10">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article class="bg-white rounded-[2rem] shadow-[0_10px_40px_rgba(0,0,0,0.02)] border border-gray-100 overflow-hidden hover:shadow-[0_20px_50px_rgba(0,0,0,0.08)] hover:-translate-y-2 transition-all duration-500 group flex flex-col h-full">
                    <!-- Image Wrapper -->
                    <div class="relative aspect-[16/10] overflow-hidden">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('medium_large', array('class' => 'w-full h-full object-cover transition duration-1000 group-hover:scale-110')); ?>
                        <?php else: ?>
                            <div class="w-full h-full bg-gray-50 flex items-center justify-center">
                                <i class="ri-image-2-line text-5xl text-gray-200"></i>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Premium Category Badge -->
                        <div class="absolute top-5 right-5 z-10">
                            <?php
                            $categories = get_the_category();
                            if (!empty($categories)) echo '<a href="'.get_category_link($categories[0]->term_id).'" class="bg-white/95 backdrop-blur-md text-gray-900 text-[9px] font-black px-4 py-2 rounded-xl uppercase kufi shadow-xl hover:bg-primary hover:text-white transition-all">' . esc_html($categories[0]->name) . '</a>';
                            ?>
                        </div>
                    </div>
                    
                    <!-- Content Wrapper -->
                    <div class="p-8 flex flex-col flex-grow">
                        <div class="flex items-center gap-4 text-[10px] text-gray-400 mb-5 kufi font-bold uppercase tracking-widest">
                            <span class="flex items-center gap-1.5"><i class="ri-calendar-check-line text-primary"></i> <?php echo get_the_date(); ?></span>
                            <span class="w-1 h-1 bg-gray-200 rounded-full"></span>
                            <span class="flex items-center gap-1.5"><i class="ri-time-line text-primary"></i> <?php echo sports_news_reading_time(); ?></span>
                        </div>
                        
                        <h2 class="text-xl md:text-2xl font-black kufi text-gray-900 mb-4 line-clamp-2 leading-[1.5] group-hover:text-primary transition-colors">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        
                        <?php if (sports_news_get_opt('archive_show_excerpt', true)) : ?>
                        <p class="text-gray-500 text-sm line-clamp-2 leading-relaxed mb-8 kufi opacity-80">
                            <?php echo wp_trim_words(get_the_excerpt(), 22); ?>
                        </p>
                        <?php endif; ?>
                        
                        <div class="mt-auto pt-6 border-t border-gray-50 flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-center overflow-hidden">
                                     <?php echo get_avatar(get_the_author_meta('ID'), 32); ?>
                                </div>
                                <span class="text-[11px] text-gray-900 font-bold kufi"><?php the_author(); ?></span>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="group/btn inline-flex items-center gap-2 text-primary text-xs font-black kufi">
                                اقرأ الآن <i class="ri-arrow-left-line group-hover:-translate-x-1.5 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </article>
                <?php endwhile; else : ?>
                <div class="col-span-full py-24 text-center bg-white rounded-[3rem] shadow-sm border border-dashed border-gray-100">
                    <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-8">
                        <i class="ri-search-eye-line text-5xl text-gray-200"></i>
                    </div>
                    <h2 class="text-3xl font-black text-gray-900 mb-4 kufi">لا توجد نتائج هنا</h2>
                    <p class="text-gray-500 max-w-sm mx-auto mb-10 leading-relaxed">عذراً، لم نتمكن من العثور على أي مقالات في هذا القسم حالياً. جرب البحث عن شيء آخر.</p>
                    <a href="<?php echo esc_url(home_url()); ?>" class="inline-flex items-center gap-3 px-10 py-4 bg-gray-900 text-white rounded-2xl shadow-xl hover:bg-primary transition-all font-black kufi group">
                        <i class="ri-home-4-line"></i> العودة للرئيسية
                    </a>
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
