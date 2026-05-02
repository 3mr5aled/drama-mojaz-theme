<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Drama_Mojaz_Theme
 * 
 * Drama Mojaz Theme is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="theme-color" content="<?php echo sports_news_get_opt('primary_color', '#E31B23'); ?>">
    
    <link rel="dns-prefetch" href="//pagead2.googlesyndication.com">
    <link rel="dns-prefetch" href="//googleads.g.doubleclick.net">
    <link rel="dns-prefetch" href="//www.google-analytics.com">
    <link rel="dns-prefetch" href="//www.googletagmanager.com">
    
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    
    <!-- STRIP 1: Top Bar -->
    <div class="top-bar kufi">
        <div class="container mx-auto px-4 top-bar-inner">
            <!-- Right: Date & Language -->
            <div class="top-bar-right">
                <?php if (sports_news_get_opt('show_top_bar_date', true)) : ?>
                <span class="top-bar-time">
                    <i class="ri-calendar-line"></i>
                    <?php echo date_i18n(get_option('date_format')); ?>
                </span>
                <?php endif; ?>
                <div class="top-bar-langs">
                    <?php
                    $top_bar_menu = sports_news_get_opt('top_bar_menu');
                    if ($top_bar_menu) {
                        wp_nav_menu(array(
                            'theme_location' => 'top_bar',
                            'container' => false,
                            'menu_class' => 'flex gap-4 list-none m-0 p-0',
                            'depth' => 1,
                            'fallback_cb' => false,
                            'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>'
                        ));
                    }
                    // No fallback - menu controlled via Redux only
                    ?>
                </div>
            </div>
            <!-- Left: Socials -->
            <div class="top-bar-socials">
                <?php if ($fb = sports_news_get_opt('facebook_url')) : ?><a href="<?php echo esc_url($fb); ?>"><i class="ri-facebook-circle-fill"></i></a><?php endif; ?>
                <?php if ($x = sports_news_get_opt('twitter_url')) : ?><a href="<?php echo esc_url($x); ?>"><i class="ri-twitter-x-fill"></i></a><?php endif; ?>
                <?php if ($ig = sports_news_get_opt('instagram_url')) : ?><a href="<?php echo esc_url($ig); ?>"><i class="ri-instagram-fill"></i></a><?php endif; ?>
                <?php if ($yt = sports_news_get_opt('youtube_url')) : ?><a href="<?php echo esc_url($yt); ?>"><i class="ri-youtube-fill"></i></a><?php endif; ?>
                <?php if ($whatsapp = sports_news_get_opt('whatsapp_url')) : ?><a href="<?php echo esc_url($whatsapp); ?>"><i class="ri-whatsapp-fill"></i></a><?php endif; ?>
            </div>
        </div>
    </div>

    <!-- STRIP 2: Main Header (Logo & Advertisement/Controls) -->
    <header class="main-header">
        <div class="container mx-auto px-4 header-inner">
                 <!-- Mobile Menu Toggle -->
                 <button class="md:hidden text-2xl text-gray-700" id="mobileMenuBtn">
                     <i class="ri-menu-line"></i>
                 </button>
            <!-- Logo area (Right) -->
            <div class="header-logo">
                <a href="<?php echo esc_url(home_url()); ?>">
                    <?php if ($logo = sports_news_get_opt('site_logo')) : ?>
                        <img src="<?php echo esc_url($logo); ?>" alt="<?php bloginfo('name'); ?>">
                    <?php else : ?>
                        <span class="text-3xl font-black text-primary"><?php bloginfo('name'); ?></span>
                    <?php endif; ?>
                </a>
            </div>

            <!-- Center: Advertisement Area (Hidden on mobile, placeholder for now) -->
            <div class="header-ad-area hidden lg:block flex-grow px-8 text-center">
                 <?php if (sports_news_get_opt('header_ad_code')) : ?>
                     <?php echo sports_news_get_opt('header_ad_code'); ?>
                 <?php endif; ?>
            </div>

            <!-- Left: Controls -->
            <div class="header-controls">

                <!-- Desktop Controls -->
                <div class="hidden md:flex items-center gap-4">
               
                <!-- Search Icon (if enabled) -->
                <?php if (sports_news_get_opt('show_header_search', true)) : ?>
                <button class="header-icon" id="desktopSearchBtn" aria-label="البحث">
                    <i class="ri-search-2-line"></i>
                </button>
                <?php endif; ?>

                
               
               <!-- Notifications Dropdown (if enabled) -->
               <?php if (sports_news_get_opt('show_header_notifications', true)) : ?>
                    <div class="relative hidden md:block">
                        <?php
                        $notification_count = sports_news_get_notification_count();
                        ?>
                        <button class="w-10 h-10 flex items-center justify-center bg-white hover:bg-blue-50 border border-gray-200 hover:border-blue-300 rounded-lg transition-all duration-200 relative shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2" id="headerNotificationsBtn" aria-label="الإشعارات">
                            <i class="ri-notification-3-line text-lg"></i>
                            <span id="notificationCountBadge" class="absolute -top-1 -right-1 w-3 h-3 bg-primary rounded-full text-xs flex items-center justify-center text-white font-bold <?php echo ($notification_count > 0) ? '' : 'hidden'; ?>">
                                <?php if ($notification_count > 0) echo min($notification_count, 9) . ($notification_count > 9 ? '+' : ''); ?>
                            </span>
                        </button>
                        <div class="absolute left-0 top-full mt-2 w-96 max-w-[90vw] bg-white border border-gray-200 rounded-xl shadow-xl opacity-0 invisible transition-all duration-200 z-50 max-h-[80vh] overflow-y-auto text-start" id="headerNotificationsDropdown">
                            <div class="py-2">
                                <div class="px-4 py-3 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                                    <div class="flex items-center justify-between">
                                        <h4 class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                                            <i class="ri-notification-3-line text-blue-600"></i>
                                            الإشعارات
                                        </h4>
                                        <span id="notificationCountText" class="text-xs text-blue-600 font-medium <?php echo ($notification_count > 0) ? '' : 'hidden'; ?>">
                                            <?php echo $notification_count; ?> جديدة
                                        </span>
                                    </div>
                                </div>
                                <div class="divide-y divide-gray-100" id="notificationsList">
                                    <?php
                                    $notification_query = sports_news_get_recent_posts(3);
                                    if ($notification_query->have_posts()) :
                                        $colors = ['bg-primary', 'bg-primary/80', 'bg-primary/60'];
                                        $i = 0;
                                        while ($notification_query->have_posts()) : $notification_query->the_post();
                                            $color = $colors[$i % count($colors)];
                                            $time_diff = human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago';
                                    ?>
                                    <a href="<?php the_permalink(); ?>" class="block px-4 py-3 hover:bg-blue-50 transition-colors group border-b border-gray-50 last:border-b-0">
                                        <div class="flex flex-row items-center gap-3">
                                            <?php if (has_post_thumbnail()) : ?>
                                                <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'); ?>" alt="<?php the_title(); ?>" class="w-12 h-12 rounded-lg object-cover flex-shrink-0 shadow-sm">
                                            <?php else : ?>
                                                <div class="w-12 h-12 bg-gradient-to-br <?php echo $color; ?> rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm">
                                                    <i class="ri-file-text-line text-white text-lg"></i>
                                                </div>
                                            <?php endif; ?>
                                            <div class="flex-1 min-w-0">
                                                <h5 class="text-sm font-bold text-gray-900 line-clamp-2 group-hover:text-blue-600 transition-colors leading-snug"><bdi><?php the_title(); ?></bdi></h5>
                                                <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                                    <i class="ri-time-line text-gray-400"></i>
                                                    <span><?php echo $time_diff; ?></span>
                                                </p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div class="w-2 h-2 <?php echo $color; ?> rounded-full"></div>
                                            </div>
                                        </div>
                                    </a>
                                    <?php
                                        $i++;
                                        endwhile;
                                        wp_reset_postdata();
                                    else:
                                    ?>
                                    <div class="px-4 py-3 text-sm text-gray-500 text-center no-notifications">
                                        لا توجد إشعارات جديدة
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="px-4 py-3 border-t border-gray-100 bg-gray-50">
                                    <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center gap-2 transition-colors">
                                        <i class="ri-arrow-right-line"></i>
                                        عرض جميع الإشعارات
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; // End show_header_notifications ?>

                    <!-- Account / Login Area (if enabled) -->
                    <?php if (sports_news_get_opt('show_header_account', true)) : ?>
                        <?php if (is_user_logged_in()) : $current_user = wp_get_current_user(); ?>
                            <div class="relative group z-50">
                                <button class="account-btn" id="headerUserBtn">
                                    <i class="ri-user-smile-line text-lg"></i>
                                    <span class="hidden sm:inline text-sm font-bold truncate max-w-[80px]">
                                        <?php echo esc_html($current_user->display_name); ?>
                                    </span>
                                    <i class="ri-arrow-down-s-line text-xs transition-transform duration-300 group-hover:rotate-180"></i>
                                </button>
                                <!-- User Dropdown -->
                                 <div class="account-menu">
                                    <div class="px-3 py-2 border-b border-gray-100 mb-1">
                                        <span class="block text-xs text-gray-500">مرحباً بك</span>
                                        <span class="block text-sm font-bold text-gray-900 truncate"><?php echo esc_html($current_user->display_name); ?></span>
                                    </div>
                                    <a href="<?php echo get_edit_user_link(); ?>" class="account-menu-item">
                                        <i class="ri-user-settings-line"></i>
                                        <span>إعدادات الحساب</span>
                                    </a>
                                    <a href="<?php echo wp_logout_url(home_url()); ?>" class="account-menu-item text-red-600 hover:bg-red-50">
                                        <i class="ri-logout-box-line"></i>
                                        <span>تسجيل الخروج</span>
                                    </a>
                                </div>
                            </div>
                        <?php else : ?>
                            <!-- Login Button (Guest) -->
                            <div class="flex items-center gap-2">
                                <a href="<?php echo wp_login_url(); ?>" class="account-btn hover:shadow-lg">
                                    <i class="ri-login-circle-line"></i>
                                    <span class="font-bold text-sm">الحساب</span>
                                </a>
                            </div>
                        <?php endif; ?>
                    <?php endif; // End show_header_account ?>
                </div>
                
                 <!-- Mobile Search Trigger -->
                 <button class="md:hidden header-icon" id="mobileSearchBtn">
                     <i class="ri-search-2-line"></i>
                 </button>
                 
            
            </div>
        </div>
    </header>

    

    <!-- STRIP 3: Navigation Bar -->
    <div class="nav-bar kufi hidden lg:block">
        <div class="container mx-auto px-4">
            <?php
            if (has_nav_menu('primary')) :
                // check if redux overriding main menu
                $main_menu_id = sports_news_get_opt('header_main_menu');
                
                $args = array(
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'nav-menu',
                    'fallback_cb' => false,
                    'walker' => new Sports_News_Walker_Nav_Menu()
                );

                if ($main_menu_id && $main_menu_id != 'default') {
                    $args['menu'] = $main_menu_id;
                    // If specifying 'menu', theme_location is ignored for retrieving the term, 
                    // but we might keep it or remove it. WP uses 'menu' priority if set.
                }

                wp_nav_menu($args);
            else :
                // Show message when no menu is assigned
                echo '<div class="nav-menu-empty" style="text-align: center; padding: 20px; color: #666;">';
                echo '<p style="margin: 0;">' . __('لم يتم تعيين قائمة. يرجى إنشاء قائمة من ', 'drama-mojaz-theme') . '</p>';
                echo '<a href="' . admin_url('nav-menus.php') . '" style="color: var(--primary); font-weight: 600;">' . __('المظهر > قوائم', 'drama-mojaz-theme') . '</a>';
                echo '</div>';
            endif;
            ?>
        </div>
    </div>

    <!-- Universal Search Overlay (Centered Spotlight) -->
    <div id="mobileSearch" class="search-overlay" role="dialog" aria-modal="true" aria-label="البحث">
        <div class="search-backdrop" id="mobileSearchOverlay"></div>
        
        <div class="search-panel-wrapper">
            <div class="search-panel" id="mobileSearchPanel">
                <div class="search-content" style="position: relative;">
                    <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                        <i class="ri-search-2-line search-icon-input"></i>
                        <input type="text" 
                               name="s" 
                               id="searchInputField"
                               placeholder="عن ماذا تبحث؟..." 
                               class="search-input kufi" 
                               autocomplete="off">
                        <button type="submit" class="hidden"></button>
                    </form>
                </div>
            </div>
            
            <!-- Close Button (Below panel) -->
            <button id="closeSearch" class="search-close-btn-centered" aria-label="إغلاق">
                <div class="close-icon-circle">
                    <i class="ri-close-line"></i>
                </div>
                <span class="text-sm font-bold text-gray-400 mt-2">إغلاق (ESC)</span>
            </button>
        </div>
    </div>

    

    

    <!-- Mobile Navigation Overlay -->
    <div id="mobileMenu" class="fixed inset-0 z-[100] hidden" role="dialog" aria-modal="true" aria-label="القائمة الرئيسية">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity duration-300" id="mobileMenuOverlay"></div>
        <div class="absolute left-0 top-0 bottom-0 w-[85%] max-w-sm bg-white shadow-2xl transform -translate-x-full transition-transform duration-500 ease-out flex flex-col" id="mobileMenuPanel">
            <!-- Header for Menu -->
            <div class="px-6 md:px-8 py-6 md:py-8 flex justify-between items-center border-b border-gray-200 bg-gray-50">
                 <span class="text-xl md:text-2xl font-black kufi tracking-tight text-gray-900">
                     <span class="text-primary"><?php bloginfo('name'); ?></span>
                 </span>
                 <button id="closeMenu" class="w-12 h-12 bg-white rounded-lg flex items-center justify-center hover:bg-primary/10 hover:text-primary transition-all duration-200 touch-target shadow-sm" aria-label="إغلاق القائمة">
                     <i class="ri-close-line text-2xl"></i>
                 </button>
            </div>
            
            <nav class="flex-grow overflow-y-auto px-6 md:px-8 py-8 md:py-10 scroll-smooth">
                <?php
                if (has_nav_menu('primary')) :
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'container' => false,
                        'menu_class' => 'flex flex-col gap-1',
                        'fallback_cb' => false,
                        'items_wrap' => '<ul class="%2$s">%3$s</ul>',
                        'walker' => new Sports_News_Walker_Mobile_Nav_Menu()
                    ));
                else :
                    echo '<div class="p-6 text-center text-gray-500 font-bold kufi">يرجى تعيين القائمة من لوحة التحكم</div>';
                endif;
                ?>
            </nav>

            <div class="p-6 md:p-8 border-t border-gray-50">
                <div class="grid grid-cols-3 gap-3">
                    <?php if ($fb_url = sports_news_get_opt('facebook_url')) : ?>
                    <a href="<?php echo esc_url($fb_url); ?>" target="_blank" class="w-full h-12 rounded-xl bg-gray-50 flex items-center justify-center text-xl hover:bg-primary hover:text-white transition-all touch-target" aria-label="فيسبوك"><i class="ri-facebook-fill"></i></a>
                    <?php endif; ?>
                    <?php if ($tw_url = sports_news_get_opt('twitter_url')) : ?>
                    <a href="<?php echo esc_url($tw_url); ?>" target="_blank" class="w-full h-12 rounded-xl bg-gray-50 flex items-center justify-center text-xl hover:bg-black hover:text-white transition-all touch-target" aria-label="تويتر"><i class="ri-twitter-x-fill"></i></a>
                    <?php endif; ?>
                    <?php if ($yt_url = sports_news_get_opt('youtube_url')) : ?>
                    <a href="<?php echo esc_url($yt_url); ?>" target="_blank" class="w-full h-12 rounded-xl bg-gray-50 flex items-center justify-center text-xl hover:bg-red-500 hover:text-white transition-all touch-target" aria-label="يوتيوب"><i class="ri-youtube-fill"></i></a>
                    <?php endif; ?>
                    <?php if ($tt_url = sports_news_get_opt('tiktok_url')) : ?>
                    <a href="<?php echo esc_url($tt_url); ?>" target="_blank" class="w-full h-12 rounded-xl bg-gray-50 flex items-center justify-center text-xl hover:bg-black hover:text-white transition-all touch-target" aria-label="تيك توك"><i class="ri-tiktok-fill"></i></a>
                    <?php endif; ?>
                    <?php if ($li_url = sports_news_get_opt('linkedin_url')) : ?>
                    <a href="<?php echo esc_url($li_url); ?>" target="_blank" class="w-full h-12 rounded-xl bg-gray-50 flex items-center justify-center text-xl hover:bg-[#0077B5] hover:text-white transition-all touch-target" aria-label="لينكدإن"><i class="ri-linkedin-box-fill"></i></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Breaking News Ticker - Premium Design -->
    <?php if (sports_news_get_opt('enable_breaking_news', true)) : ?>
    
    
    <div class="ticker-container" 
         data-ticker-speed="<?php echo sports_news_get_opt('breaking_news_speed', 60); ?>"
         data-ticker-items="<?php echo sports_news_get_opt('breaking_news_count', 8); ?>">
        <div class="container mx-auto px-4">
            <div class="flex items-center gap-0 h-12 overflow-hidden relative">
                
                <!-- Breaking News Label -->
                <div class="ticker-label">
                    <div class="ticker-label-dot"></div>
                    <span class="ticker-label-text">
                        <?php echo sports_news_get_opt('breaking_news_label', 'عاجل'); ?>
                    </span>
                </div>
                
                <!-- Ticker Content -->
                <div class="flex-grow overflow-hidden relative h-full flex items-center ticker-mask">
                    <div class="ticker-track whitespace-nowrap flex items-center gap-12 pr-4" 
                         style="--ticker-speed: <?php echo sports_news_get_opt('breaking_news_speed', 60); ?>s">
                        <?php
                        function sports_news_ticker_items($query) {
                            if (!$query->have_posts()) return;
                            
                            $index = 0;
                            while ($query->have_posts()) : $query->the_post();
                                $index++;
                                $title = get_the_title();
                                $title = strlen($title) > 100 ? substr($title, 0, 100) . '...' : $title;
                                $permalink = get_permalink();
                                
                                echo '<a href="' . esc_url($permalink) . '" ' 
                                    . 'class="ticker-item" '
                                    . 'title="' . esc_attr(get_the_title()) . '" '
                                    . 'data-index="' . $index . '">'
                                    . '<i class="ri-arrow-right-s-line"></i>'
                                    . '<span>' . esc_html($title) . '</span>'
                                    . '</a>';
                                echo '<span class="ticker-separator"></span>';
                            endwhile;
                        }

                        $breaking_count = sports_news_get_opt('breaking_news_count', 8);
                        $breaking_query = new WP_Query(array(
                            'posts_per_page' => $breaking_count,
                            'post_status' => 'publish',
                            'orderby' => 'date',
                            'order' => 'DESC'
                        ));
                        
                        if ($breaking_query->have_posts()) :
                            // Duplicate content 4 times for seamless loop on large screens
                            for ($i = 0; $i < 4; $i++) {
                                sports_news_ticker_items($breaking_query);
                                $breaking_query->rewind_posts();
                            }
                            wp_reset_postdata();
                        else:
                            echo '<span class="ticker-item">أهلاً بكم في المنصة الرياضية رقم 1 في الشرق الأوسط...</span>';
                        endif;
                        ?>
                    </div>
                </div>

                <!-- Controls -->
                <div class="ticker-controls">
                    <button class="ticker-pause-btn ticker-control-btn" 
                            aria-label="إيقاف/تشغيل"
                            title="إيقاف تشغيل البرنامج">
                        <i class="ri-pause-mini-line text-lg"></i>
                    </button>
                    <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" 
                       class="ticker-control-btn" 
                       aria-label="عرض الكل"
                       title="عرض جميع الأخبار">
                        <i class="ri-menu-unfold-line text-lg"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Header Advertisement -->
    <?php if (sports_news_get_opt('enable_header_ad') && sports_news_get_opt('header_ad_code')) : ?>
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-center overflow-hidden rounded-xl shadow-sm border border-gray-200 bg-white p-2 min-h-[100px] border-dashed border-2">
            <?php echo sports_news_get_opt('header_ad_code'); ?>
        </div>
    </div>
    <?php endif; ?>

    

