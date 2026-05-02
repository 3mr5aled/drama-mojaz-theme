<!-- Archive Hero Header - Immersive Design -->
<div class="bg-white border-b border-gray-100 mb-12 py-16 overflow-hidden relative">
    <!-- Abstract Background Elements -->
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary/2 rounded-full -mr-64 -mt-64 blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-[300px] h-[300px] bg-secondary/2 rounded-full -ml-32 -mb-32 blur-3xl"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <nav class="flex items-center justify-center text-[10px] md:text-xs text-gray-400 mb-8 kufi font-bold uppercase tracking-widest">
                <a href="<?php echo esc_url(home_url()); ?>" class="hover:text-primary transition flex items-center gap-1">
                    <i class="ri-home-4-line"></i> الرئيسية
                </a>
                <span class="mx-3 opacity-30">/</span>
                <span class="text-primary"><?php
                if (is_category()) echo 'قسم';
                elseif (is_tag()) echo 'وسم';
                elseif (is_author()) echo 'الكاتب';
                elseif (is_search()) echo 'البحث';
                else echo 'الأرشيف';
                ?></span>
            </nav>
            
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-black kufi text-gray-900 leading-tight mb-6">
                <?php
                if (is_category()) single_cat_title();
                elseif (is_tag()) echo '#' . single_tag_title('', false);
                elseif (is_author()) echo get_the_author();
                elseif (is_search()) echo get_search_query();
                else echo 'آخر الأخبار';
                ?>
            </h1>
            
            <?php if (category_description() || is_tag() || is_author()) : ?>
                <div class="max-w-2xl mx-auto">
                    <div class="text-gray-500 text-base md:text-lg leading-relaxed kufi opacity-80">
                        <?php 
                        if (is_author()) {
                            echo get_the_author_meta('description') ?: 'تصفح أحدث المقالات والتحليلات بقلم ' . get_the_author();
                        } else {
                            echo category_description() ?: 'نقدم لكم تغطية شاملة وحصرية لكافة المستجدات والأحداث في هذا القسم لحظة بلحظة.'; 
                        }
                        ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="flex items-center justify-center gap-8 mt-10">
                <div class="flex flex-col items-center">
                    <span class="text-3xl font-black text-gray-900 mb-1"><?php echo $wp_query->found_posts; ?></span>
                    <span class="text-[10px] text-gray-400 kufi font-bold uppercase tracking-wider">مقال متاح</span>
                </div>
                <div class="w-px h-10 bg-gray-100"></div>
                <div class="flex flex-col items-center">
                    <span class="text-3xl font-black text-gray-900 mb-1"><?php echo date('Y'); ?></span>
                    <span class="text-[10px] text-gray-400 kufi font-bold uppercase tracking-wider">تغطية مستمرة</span>
                </div>
            </div>
        </div>
    </div>
</div>
