<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Drama_Mojaz_Theme
 */
?>

<!-- Main Footer -->
<footer class="footer-wrapper pt-16 pb-8">
    <div class="footer-container">
        
        <!-- Top Section: Newsletter -->
        <div class="footer-top-border">
            <div class="flex flex-col lg:flex-row justify-center items-center gap-8 footer-top-flex">
                
                <!-- Newsletter -->
                <div class="w-full lg:w-2/3">
                    <div class="footer-newsletter-card">
                        <div class="newsletter-icon-wrap">
                            <i class="ri-mail-send-line"></i>
                        </div>
                        <div class="flex-grow w-full">
                            <h3 class="newsletter-title"><?php echo wp_kses_post(sports_news_get_opt('footer_newsletter_title', 'اشترك في النشرة الإخبارية لمتابعة كل المستجدات وقت حدوثها')); ?></h3>
                            <form class="newsletter-form-modern">
                                <div class="relative w-full">
                                    <input type="email" placeholder="أدخل بريدك الإلكتروني" class="newsletter-input-modern">
                                    <button type="submit" class="newsletter-btn-modern">إرسال</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Main Content -->
        <div class="footer-grid mb-16">
            
            <!-- Column 1 (Rightmost): Logo & Socials -->
             <div class="footer-col-main col-span-5 flex flex-col space-y-8 items-center lg:items-start text-center lg:text-right">
                 <!-- Logo -->
                 <a href="<?php echo esc_url(home_url()); ?>" class="footer-logo-wrap group">
                     <?php if ($footer_logo = sports_news_get_opt('footer_logo')) : ?>
                        <img src="<?php echo esc_url($footer_logo); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="footer-logo-img">
                    <?php else: ?>
                        <div class="brand-text-logo">
                            <span class="dot-red">.</span><?php bloginfo('name'); ?>
                        </div>
                    <?php endif; ?>
                </a>

                <!-- About Text -->
                <div class="footer-about-text">
                    <?php echo wp_kses_post(sports_news_get_opt('footer_about', 'موقعك الرياضي الأول للأخبار والتحليلات')); ?>
                </div>
                
                <!-- Socials -->
                 <div class="flex flex-wrap gap-3 justify-center lg:justify-start w-full">
                    <?php
                    $social_links = array(
                        'facebook_url' => 'ri-facebook-fill',
                        'twitter_url' => 'ri-twitter-x-fill',
                        'instagram_url' => 'ri-instagram-line',
                        'youtube_url' => 'ri-youtube-fill',
                        'tiktok_url' => 'ri-tiktok-fill',
                        'whatsapp_url' => 'ri-whatsapp-fill',
                    );
                    
                    foreach ($social_links as $key => $icon) :
                        if ($url = sports_news_get_opt($key)) :
                    ?>
                        <a href="<?php echo esc_url($url); ?>" class="social-icon" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr(str_replace('_url', '', $key)); ?>">
                            <i class="<?php echo esc_attr($icon); ?>"></i>
                        </a>
                    <?php endif; endforeach; ?>
                </div>
            </div>

            <!-- Column 2: Sections -->
            <div class="footer-links-col footer-links-col-1 col-span-2 text-center lg:text-right">
                <?php if (sports_news_get_opt('footer_col1_menu') != 'default' || has_nav_menu('footer')) : ?>
                <h4 class="footer-section-title"><?php echo esc_html(sports_news_get_opt('footer_col1_title', 'الأقسام')); ?></h4>
                <?php endif; ?>
                <div class="flex flex-col gap-2 items-center lg:items-start">
                    <?php
                    $col1_menu = sports_news_get_opt('footer_col1_menu');
                    if ($col1_menu && $col1_menu != 'default') {
                        wp_nav_menu(array(
                            'theme_location' => 'footer_col1',
                            'container' => false,
                            'menu_class' => 'footer-menu-list',
                            'fallback_cb' => false,
                            'depth' => 1,
                        ));
                    } elseif (has_nav_menu('footer')) {
                        wp_nav_menu(array(
                            'theme_location' => 'footer',
                            'container' => false,
                            'menu_class' => 'footer-menu-list',
                            'fallback_cb' => false,
                            'depth' => 1,
                        ));
                    }
                    ?>
                </div>
            </div>

            <!-- Column 3: Sports -->
            <div class="footer-links-col footer-links-col-2 col-span-2 text-center lg:text-right">
                 <?php if (sports_news_get_opt('footer_col2_menu') != 'default' || has_nav_menu('footer_secondary')) : ?>
                 <h4 class="footer-section-title"><?php echo esc_html(sports_news_get_opt('footer_col2_title', 'رياضة')); ?></h4>
                 <?php endif; ?>
                 <div class="flex flex-col gap-2 items-center lg:items-start">
                     <?php
                     $col2_menu = sports_news_get_opt('footer_col2_menu');
                     if ($col2_menu && $col2_menu != 'default') {
                        wp_nav_menu(array(
                            'theme_location' => 'footer_col2',
                            'container' => false,
                            'menu_class' => 'footer-menu-list',
                            'fallback_cb' => false,
                            'depth' => 1,
                        ));
                     } elseif (has_nav_menu('footer_secondary')) {
                        wp_nav_menu(array(
                            'theme_location' => 'footer_secondary',
                            'container' => false,
                            'menu_class' => 'footer-menu-list',
                             'fallback_cb' => false,
                            'depth' => 1,
                        ));
                     }
                    ?>
                </div>
            </div>

            <!-- Column 4: Community -->
             <div class="footer-links-col footer-links-col-3 col-span-3 text-center lg:text-right">
                 <?php if (sports_news_get_opt('footer_col3_menu') != 'default' || has_nav_menu('footer_third')) : ?>
                 <h4 class="footer-section-title"><?php echo esc_html(sports_news_get_opt('footer_col3_title', 'مجتمع')); ?></h4>
                 <?php endif; ?>
                 <div class="flex flex-col gap-2 items-center lg:items-start">
                     <?php
                     $col3_menu = sports_news_get_opt('footer_col3_menu');
                     if ($col3_menu && $col3_menu != 'default') {
                        wp_nav_menu(array(
                            'theme_location' => 'footer_col3',
                            'container' => false,
                            'menu_class' => 'footer-menu-list',
                            'fallback_cb' => false,
                            'depth' => 1,
                        ));
                     } elseif (has_nav_menu('footer_third')) {
                        wp_nav_menu(array(
                            'theme_location' => 'footer_third',
                            'container' => false,
                            'menu_class' => 'footer-menu-list',
                             'fallback_cb' => false,
                            'depth' => 1,
                        ));
                     }
                    ?>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="copyright-bar flex flex-col lg:flex-row justify-between items-center gap-6">
            <div class="text-center lg:text-left order-2 lg:order-1">
                <?php echo wp_kses_post(sports_news_get_opt('footer_copyright', 'جميع الحقوق محفوظة © ' . date('Y'))); ?>
            </div>
            <div class="flex flex-wrap justify-center gap-6 order-1 lg:order-2 footer-legal-links">
                 <a href="<?php echo esc_url(home_url('/about-us')); ?>">من نحن</a>
                 <a href="<?php echo esc_url(home_url('/advertise')); ?>">أعلن معنا</a>
                 <a href="<?php echo esc_url(home_url('/contact')); ?>">اتصل بنا</a>
                 <a href="<?php echo esc_url(home_url('/privacy-policy')); ?>">سياسة الخصوصية</a>
            </div>
        </div>
    </div>
</footer>

<!-- Modals Preserved -->
<div id="adminLoginModal" class="fixed inset-0 bg-gray-900/80 backdrop-blur-md z-[100] flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-[2rem] w-full max-w-md p-8 md:p-12 shadow-2xl relative overflow-hidden group">
         <button id="closeLoginModal" class="absolute top-8 left-8 w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-red-500 transition-all">
            <i class="ri-close-line text-2xl"></i>
        </button>
        <form action="<?php echo wp_login_url(); ?>" method="post" class="relative z-10 pt-8">
            <div class="space-y-6">
                <input type="text" name="log" class="w-full bg-gray-50 px-6 py-4 rounded-2xl border border-gray-100" placeholder="Username">
                <input type="password" name="pwd" class="w-full bg-gray-50 px-6 py-4 rounded-2xl border border-gray-100" placeholder="Password">
                <button type="submit" class="w-full bg-primary text-white px-8 py-4 rounded-2xl font-bold">تسجيل الدخول</button>
            </div>
        </form>
    </div>
</div>

<!-- Story Viewer Modal -->
<div id="storyViewer" class="kufi hidden fixed inset-0 bg-black z-[99999] flex-col items-center justify-center">
    <button id="deskPrev" class="hidden md:flex"><i class="ri-arrow-right-s-line text-3xl"></i></button>
    <button id="deskNext" class="hidden md:flex"><i class="ri-arrow-left-s-line text-3xl"></i></button>

    <div class="story-container relative w-full h-full max-w-[450px] md:max-h-[85vh] bg-black overflow-hidden md:rounded-3xl shadow-2xl">
        <div id="storyProgress" class="absolute top-0 left-0 right-0 flex gap-1 p-3 z-[101]"></div>
        <div class="story-header absolute top-0 left-0 right-0 p-6 pt-10 flex items-center justify-between z-[101] bg-gradient-to-b from-black/60 to-transparent">
            <div class="flex items-center gap-3">
                <img id="storyAuthorAvatar" src="" class="w-10 h-10 rounded-full border-2 border-white/20">
                <div>
                    <h4 id="storyAuthorName" class="text-white font-bold text-sm leading-none"></h4>
                    <span id="storyTime" class="text-white/60 text-[10px]"></span>
                </div>
            </div>
            <button id="storyClose" class="w-8 h-8 flex items-center justify-center rounded-full bg-white/10 text-white hover:bg-white/20 transition-all">
                <i class="ri-close-line text-xl"></i>
            </button>
        </div>

        <img id="storyImage" src="" class="w-full h-full object-cover">

        <div class="story-footer absolute bottom-0 left-0 right-0 p-8 pt-12 bg-gradient-to-t from-black/80 to-transparent z-[101]">
            <h3 id="storyTitle" class="text-white font-bold text-lg mb-4 line-clamp-2"></h3>
            <a id="storyLink" href="" class="inline-flex items-center justify-center w-full py-4 bg-white text-black rounded-2xl font-bold hover:bg-primary hover:text-white transition-all">
                شاهد المقال بالكامل
                <i class="ri-arrow-left-line mr-2"></i>
            </a>
        </div>

        <div class="absolute inset-0 flex z-50">
            <div id="storyPrev" class="w-1/3 h-full cursor-pointer"></div>
            <div id="storyNext" class="w-2/3 h-full cursor-pointer"></div>
        </div>
    </div>
</div>

<?php get_template_part('template-parts/post/floating-see-also'); ?>

<button id="backToTopButton" class="back-to-top-btn" type="button" aria-label="<?php esc_attr_e('Back to top', 'drama-mojaz-theme'); ?>">
    <i class="ri-arrow-up-line" aria-hidden="true"></i>
</button>

<?php wp_footer(); ?>

</body>
</html>
