<?php get_header(); ?>

<?php
$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
$author_id = $curauth->ID;
?>

<!-- Author Identity Header - Cinematic Design -->
<div class="bg-white border-b border-gray-100 py-20 md:py-24 mb-16 relative overflow-hidden">
    <!-- Abstract Background Elements -->
    <div class="absolute top-0 left-0 w-[600px] h-[600px] bg-primary/2 rounded-full -ml-32 -mt-32 blur-3xl opacity-50"></div>
    <div class="absolute bottom-0 right-0 w-[400px] h-[400px] bg-secondary/2 rounded-full -mr-20 -mb-20 blur-3xl opacity-50"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col lg:flex-row items-center lg:items-center gap-12 lg:gap-20">
                <!-- Avatar Section -->
                <div class="relative group">
                    <div class="w-40 h-40 md:w-56 md:h-56 lg:w-64 lg:h-64 rounded-[3rem] overflow-hidden shadow-2xl border-8 border-white group-hover:rotate-1 transition-all duration-700 bg-gray-50">
                        <?php echo get_avatar($author_id, 300, '', '', array('class' => 'w-full h-full object-cover grayscale-[0.2] transition-all duration-700 group-hover:grayscale-0 group-hover:scale-110')); ?>
                    </div>
                    <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 bg-primary text-white px-6 py-2.5 rounded-2xl flex items-center gap-2 shadow-2xl shadow-primary/30 border border-white/20 whitespace-nowrap scale-90 group-hover:scale-100 transition-all duration-500">
                        <i class="ri-verified-badge-fill text-xl"></i>
                        <span class="text-xs font-black kufi uppercase tracking-widest">كاتب مؤكد</span>
                    </div>
                </div>
                <!-- Info Section -->
                <div class="flex-grow text-center lg:text-right">
                    <div class="flex flex-col items-center lg:items-start gap-4 mb-6">
                        <span class="bg-gray-900 text-white text-[10px] md:text-xs font-black px-5 py-2 rounded-xl kufi uppercase tracking-[0.2em] shadow-xl">
                            عضو الفريق التحريري
                        </span>
                        <h1 class="text-4xl md:text-6xl lg:text-7xl font-black kufi text-gray-900 leading-tight tracking-tight">
                            <?php echo $curauth->display_name; ?>
                        </h1>
                    </div>
                    
                    <div class="flex flex-wrap items-center justify-center lg:justify-start gap-5 md:gap-8 text-xs md:text-sm text-gray-400 mb-8 kufi font-bold uppercase tracking-wider">
                        <?php if ($curauth->user_email) : ?>
                        <span class="flex items-center gap-2.5 hover:text-primary transition-colors cursor-pointer"><i class="ri-mail-send-line text-lg text-primary"></i> <?php echo $curauth->user_email; ?></span>
                        <?php endif; ?>
                        <span class="flex items-center gap-2.5"><i class="ri-calendar-event-line text-lg text-primary"></i> منذ <?php echo date('Y', strtotime($curauth->user_registered)); ?></span>
                        <?php if ($curauth->user_url) : ?>
                        <a href="<?php echo $curauth->user_url; ?>" target="_blank" class="flex items-center gap-2.5 hover:text-primary transition-colors">
                            <i class="ri-earth-line text-lg text-primary"></i> الرابط الشخصي
                        </a>
                        <?php endif; ?>
                    </div>

                    <div class="relative mb-10 inline-block text-right">
                        <div class="absolute -right-4 top-0 w-1.5 h-full bg-primary/20 rounded-full overflow-hidden">
                            <div class="w-full h-1/3 bg-primary"></div>
                        </div>
                        <p class="text-gray-500 text-base md:text-xl leading-relaxed kufi opacity-90 max-w-2xl px-2">
                            <?php echo $curauth->description ?: 'يسعى لتقديم رؤية رياضية حيادية ومعمقة لكافة الأحداث الكبرى، مع التركيز على التحليل الفني والخبر الموثوق.'; ?>
                        </p>
                    </div>

                    <!-- Enhanced Stats Row -->
                    <div class="flex flex-wrap justify-center lg:justify-start gap-6">
                        <div class="bg-white/50 backdrop-blur-sm p-4 md:p-6 rounded-[2rem] border border-gray-100 flex items-center gap-6 group hover:border-primary/20 hover:shadow-xl hover:shadow-primary/5 transition-all">
                            <div class="w-14 h-14 rounded-2xl bg-primary/5 text-primary flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-all duration-500 shadow-inner">
                                <i class="ri-ball-pen-line text-2xl"></i>
                            </div>
                            <div class="text-right">
                                <span class="block text-3xl font-black text-gray-900 leading-none mb-1"><?php echo count_user_posts($author_id); ?></span>
                                <span class="block text-[10px] text-gray-400 font-black uppercase kufi tracking-widest">مقال منشور</span>
                            </div>
                        </div>
                        
                        <div class="bg-white/50 backdrop-blur-sm p-4 md:p-6 rounded-[2rem] border border-gray-100 flex items-center gap-6 group hover:border-secondary/20 hover:shadow-xl hover:shadow-secondary/5 transition-all">
                            <div class="w-14 h-14 rounded-2xl bg-primary/5 text-primary flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-all duration-500 shadow-inner">
                                <i class="ri-eye-line text-2xl"></i>
                            </div>
                            <div class="text-right">
                                <span class="block text-3xl font-black text-gray-900 leading-none mb-1">125K</span>
                                <span class="block text-[10px] text-gray-400 font-black uppercase kufi tracking-widest">تفاعل إجمالي</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 pb-24">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        <!-- Articles Feed -->
        <main class="lg:col-span-8">
            <div class="flex items-center justify-between mb-12">
                <div class="flex items-center gap-4">
                    <div class="w-2 h-10 bg-gray-900 rounded-full"></div>
                    <h2 class="text-2xl md:text-3xl font-black kufi text-gray-900 leading-tight">
                        كافة المساهمات الفكرية
                    </h2>
                </div>
                <div class="hidden md:flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                    <span class="text-[10px] text-gray-400 font-black kufi uppercase tracking-widest">محدث الآن</span>
                </div>
            </div>

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
                        
                        <p class="text-gray-500 text-sm line-clamp-2 leading-relaxed mb-8 kufi opacity-80">
                            <?php echo wp_trim_words(get_the_excerpt(), 22); ?>
                        </p>
                        
                        <div class="mt-auto pt-6 border-t border-gray-50 flex items-center justify-between">
                            <span class="text-[11px] text-gray-400 font-bold kufi flex items-center gap-2">
                                <i class="ri-quill-pen-line"></i> مقال حصري
                            </span>
                            <a href="<?php the_permalink(); ?>" class="group/btn inline-flex items-center gap-2 text-primary text-xs font-black kufi">
                                اقرأ الآن <i class="ri-arrow-left-line group-hover:-translate-x-1.5 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </article>
                <?php endwhile; wp_reset_postdata(); else : ?>
                <div class="col-span-full py-24 text-center bg-white rounded-[3rem] shadow-sm border border-dashed border-gray-100">
                    <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-8">
                        <i class="ri-chat-delete-line text-5xl text-gray-200"></i>
                    </div>
                    <h2 class="text-3xl font-black text-gray-900 mb-4 kufi">لا يوجد محتوى متاح</h2>
                    <p class="text-gray-500 max-w-sm mx-auto mb-10 leading-relaxed">لم يقم الكاتب بنشر أي مقالات في هذا القسم حالياً.</p>
                </div>
                <?php endif; ?>
            </div>

            <!-- Enhanced Pagination -->
            <div class="mt-20">
                <?php
                echo paginate_links(array(
                    'prev_text' => '<i class="ri-arrow-right-s-line"></i><span>السابق</span>',
                    'next_text' => '<span>التالي</span><i class="ri-arrow-left-s-line"></i>',
                    'type'      => 'list',
                    'class'     => 'premium-pagination'
                ));
                ?>
                <style>
                    .premium-pagination ul { display: flex; justify-content: center; align-items: center; gap: 0.75rem; list-style: none; }
                    .premium-pagination li a, .premium-pagination li span { 
                        display: flex; align-items: center; justify-content: center;
                        min-width: 44px; height: 44px; padding: 0 1rem; border-radius: 1rem;
                        background: white; border: 1px solid #f9fafb;
                        font-family: 'Noto Kufi Arabic', sans-serif;
                        font-weight: 800; font-size: 0.8125rem; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
                        color: #111;
                    }
                    .premium-pagination li span.current { 
                        background: #E31B23; color: white; border-color: #E31B23;
                        box-shadow: 0 10px 15px -3px rgba(227, 27, 35, 0.2);
                    }
                    .premium-pagination li a:hover { 
                        background: #111; color: white; transform: translateY(-3px);
                        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
                    }
                    .premium-pagination li:first-child a, .premium-pagination li:last-child a {
                        gap: 0.5rem; width: auto; font-size: 0.75rem;
                    }
                </style>
            </div>
        </main>

        <!-- Sidebar -->
        <div class="lg:col-span-4 mt-16 lg:mt-0">
            <div class="sticky top-24">
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
