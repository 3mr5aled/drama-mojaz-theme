<?php
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area mt-20 pt-12 border-t-2 border-gray-100">
    <!-- Comments Header & Count -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12">
        <h2 class="comments-title text-3xl font-black kufi flex items-center gap-4 text-gray-900">
            <span class="w-12 h-12 bg-primary text-white rounded-2xl flex items-center justify-center shadow-lg shadow-primary/20">
                <i class="ri-chat-smile-3-line"></i>
            </span>
            <span>آراء القرّاء <span class="text-primary/50 text-xl font-medium">(<?php echo get_comments_number(); ?>)</span></span>
        </h2>
        
        <!-- Sorting/Filter Placeholder -->
        <div class="flex items-center gap-2 text-xs font-bold kufi text-gray-400">
            <span class="text-gray-900">ترتيب حسب:</span>
            <button class="bg-gray-100 px-3 py-1.5 rounded-lg text-primary">الأحدث</button>
            <button class="px-3 py-1.5 rounded-lg hover:bg-gray-50 transition">الأقدم</button>
        </div>
    </div>

    <!-- Community Guidelines Banner -->
    <div class="bg-blue-50/50 border border-blue-100 rounded-3xl p-6 mb-12 flex items-start gap-4">
        <div class="text-blue-500 text-2xl mt-1">
            <i class="ri-information-fill"></i>
        </div>
        <div>
            <h4 class="font-bold kufi text-blue-900 mb-1">قواعد النقاش</h4>
            <p class="text-blue-800/70 text-sm leading-relaxed">
                نحن نشجع النقاش البناء والرياضي. يرجى تجنب الإساءة أو التعليقات الخارجة عن الموضوع لضمان بيئة آمنة للجميع.
            </p>
        </div>
    </div>

    <!-- Comments List -->
    <?php if (have_comments()) : ?>
        <ul class="comment-list space-y-8 mb-16">
            <?php
            wp_list_comments(array(
                'style'       => 'ul',
                'short_ping'  => true,
                'avatar_size' => 64,
                'callback'    => 'sports_news_comment_callback'
            ));
            ?>
        </ul>

        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
            <nav class="comment-navigation pb-12" role="navigation">
                <div class="flex justify-center gap-3">
                    <?php 
                    paginate_comments_links(array(
                        'prev_text' => '<i class="ri-arrow-right-s-line"></i>',
                        'next_text' => '<i class="ri-arrow-left-s-line"></i>',
                        'type'      => 'plain'
                    )); 
                    ?>
                </div>
            </nav>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Comment Form Section -->
    <div class="bg-gray-50 rounded-[2.5rem] p-8 md:p-12 border border-gray-100">
        <?php
        $commenter = wp_get_current_commenter();
        $req = get_option('require_name_email');
        $aria_req = ($req ? " aria-required='true'" : '');

        $fields = array(
            'author' => '<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">' .
                        '<div class="relative group">' .
                        '<label for="author" class="block text-xs font-bold kufi text-gray-500 mb-2 mr-1">الاسم بالكامل *</label>' .
                        '<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' class="w-full bg-white px-6 py-4 rounded-2xl border border-gray-200 focus:border-primary focus:ring-4 focus:ring-primary/5 outline-none transition-all duration-300" />' .
                        '<i class="ri-user-line absolute left-6 top-[3.2rem] text-gray-300 group-focus-within:text-primary transition-colors"></i>' .
                        '</div>',
            'email'  => '<div class="relative group">' .
                        '<label for="email" class="block text-xs font-bold kufi text-gray-500 mb-2 mr-1">البريد الإلكتروني *</label>' .
                        '<input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' class="w-full bg-white px-6 py-4 rounded-2xl border border-gray-200 focus:border-primary focus:ring-4 focus:ring-primary/5 outline-none transition-all duration-300" />' .
                        '<i class="ri-mail-line absolute left-6 top-[3.2rem] text-gray-300 group-focus-within:text-primary transition-colors"></i>' .
                        '</div>' .
                        '</div>',
        );

        comment_form(array(
            'fields'               => $fields,
            'comment_field'        => '<div class="relative group mb-8">' .
                                      '<label for="comment" class="block text-xs font-bold kufi text-gray-500 mb-2 mr-1">ماذا يدور في ذهنك؟ *</label>' .
                                      '<textarea id="comment" name="comment" cols="45" rows="6" aria-required="true" class="w-full bg-white px-6 py-5 rounded-[2rem] border border-gray-200 focus:border-primary focus:ring-4 focus:ring-primary/5 outline-none transition-all duration-300 resize-none"></textarea>' .
                                      '<i class="ri-chat-1-line absolute left-6 top-[3.2rem] text-gray-300 group-focus-within:text-primary transition-colors"></i>' .
                                      '</div>',
            'must_log_in'          => '<div class="bg-red-50 text-red-700 p-6 rounded-3xl mb-8 flex items-center gap-4"><i class="ri-lock-2-line text-2xl"></i><span>يجب عليك <a href="' . wp_login_url(get_permalink()) . '" class="font-black underline">تسجيل الدخول</a> للتعليق.</span></div>',
            'logged_in_as'         => '<div class="flex items-center gap-4 mb-8 bg-white p-4 rounded-2xl border border-gray-100 shadow-sm">' . 
                                      get_avatar(get_current_user_id(), 40, '', '', array('class' => 'rounded-xl')) .
                                      '<div><span class="block text-xs font-bold kufi text-gray-900 border-b border-gray-100 mb-1 pb-1">أهلاً بك، ' . $user_identity . '</span><a href="' . wp_logout_url(get_permalink()) . '" class="text-[10px] text-red-500 font-bold hover:underline">تسجيل الخروج؟</a></div>' .
                                      '</div>',
            'comment_notes_before' => '',
            'title_reply'          => 'اترك بصمتك على هذا الخبر',
            'title_reply_to'       => 'الرد على %s',
            'cancel_reply_link'    => 'تجاهل الرد',
            'label_submit'         => 'إرسال التعليق الآن',
            'class_submit'         => 'bg-primary hover:bg-secondary text-white px-10 py-5 rounded-2xl font-black kufi transition-all duration-300 cursor-pointer shadow-xl shadow-primary/20 hover:shadow-secondary/20 hover:-translate-y-1 block w-full md:w-auto',
            'submit_field'         => '<div class="form-submit">%1$s %2$s</div>',
            'title_reply_before'   => '<h3 id="reply-title" class="text-2xl font-black kufi text-gray-900 mb-8 flex items-center gap-3">',
            'title_reply_after'    => '</h3>',
        ));
        ?>
    </div>
</div>
