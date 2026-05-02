<!-- Post Tags -->
<?php if (has_tag()) : ?>
<div class="mt-12 flex flex-wrap gap-3">
    <span class="kufi font-black text-xs text-gray-400 uppercase self-center ml-2">الوسوم:</span>
    <?php
    $tags = get_the_tags();
    foreach($tags as $tag) {
        echo '<a href="'.get_tag_link($tag->term_id).'" class="bg-gray-50 text-gray-600 hover:bg-primary hover:text-white px-4 py-2 rounded-xl text-sm font-bold kufi transition-all duration-300 border border-gray-100 hover:border-primary hover:shadow-lg hover:shadow-primary/20"># ' . $tag->name . '</a>';
    }
    ?>
</div>
<?php endif; ?>

<!-- Social Share Floating/Bottom -->
<div class="mt-12 p-8 bg-gray-900 rounded-[2.5rem] text-white flex flex-col md:flex-row items-center justify-between gap-6 shadow-2xl">
    <div class="text-center md:text-right">
        <h4 class="kufi font-black text-xl mb-1">هل أعجبك المقال؟</h4>
        <p class="text-gray-400 text-xs kufi font-bold">شارك المحتوى مع أصدقائك عبر شبكات التواصل</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="w-12 h-12 flex items-center justify-center rounded-2xl bg-white/10 hover:bg-[#3b5998] transition-all group">
            <i class="ri-facebook-fill text-xl group-hover:scale-110 transition-transform"></i>
        </a>
        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="w-12 h-12 flex items-center justify-center rounded-2xl bg-white/10 hover:bg-black transition-all group">
            <i class="ri-twitter-x-fill text-xl group-hover:scale-110 transition-transform"></i>
        </a>
        <a href="https://wa.me/?text=<?php echo urlencode(get_the_title() . ' ' . get_permalink()); ?>" target="_blank" class="w-12 h-12 flex items-center justify-center rounded-2xl bg-white/10 hover:bg-[#25d366] transition-all group">
            <i class="ri-whatsapp-line text-xl group-hover:scale-110 transition-transform"></i>
        </a>
        <a href="https://t.me/share/url?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="w-12 h-12 flex items-center justify-center rounded-2xl bg-white/10 hover:bg-[#0088cc] transition-all group">
            <i class="ri-telegram-fill text-xl group-hover:scale-110 transition-transform"></i>
        </a>
    </div>
</div>

<!-- Enhanced Author Box -->
<?php if (sports_news_get_opt('show_author_box', true)) : ?>
<div class="mt-16 bg-white border border-gray-100 rounded-[2.5rem] p-8 md:p-10 shadow-sm relative overflow-hidden group">
    <div class="absolute -top-10 -left-10 w-40 h-40 bg-gray-50 rounded-full group-hover:scale-110 transition-transform duration-700 opacity-50"></div>
    <div class="relative z-10 flex flex-col md:flex-row gap-8 items-center md:items-start text-center md:text-right">
        <div class="w-24 h-24 md:w-32 md:h-32 rounded-3xl overflow-hidden shadow-xl ring-4 ring-white flex-shrink-0">
            <?php echo get_avatar(get_the_author_meta('ID'), 128, '', '', array('class' => 'w-full h-full object-cover')); ?>
        </div>
        <div class="flex-grow">
            <span class="inline-block bg-primary/10 text-primary text-[10px] font-black px-3 py-1 rounded-lg uppercase kufi mb-3">عن كاتب المقال</span>
            <h3 class="text-2xl font-black text-gray-900 kufi mb-4"><?php the_author(); ?></h3>
            <p class="text-gray-500 text-sm leading-relaxed mb-6 max-w-2xl">
                <?php echo get_the_author_meta('description') ?: 'محرر ومحلل رياضي متخصص في تغطية أهم الأحداث والكواليس الرياضية عبر منصتنا، يسعى دائماً لتقديم محتوى هادف وتحليلات دقيقة.'; ?>
            </p>
            <div class="flex flex-wrap justify-center md:justify-start gap-4">
                <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" class="bg-gray-900 text-white px-8 py-3 rounded-2xl text-xs font-black kufi hover:bg-primary transition-all shadow-lg shadow-gray-200">
                    معرض المقالات <i class="ri-arrow-left-line mr-2"></i>
                </a>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
