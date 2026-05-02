<?php
/**
 * Redux Framework Configuration
 * Complete Theme Control Panel
 */

if (!defined('ABSPATH')) exit;

if (!class_exists('Redux')) {
    return;
}

// Redux Configuration
$opt_name = 'sports_news_opt';

$args = array(
    'opt_name' => $opt_name,
    'display_name' => 'إعدادات القالب',
    'display_version' => '1.1.0',
    'menu_type' => 'menu',
    'allow_sub_menu' => true,
    'menu_title' => 'إعدادات القالب',
    'page_title' => 'لوحة تحكم القالب الرياضي',
    'google_api_key' => '',
    'google_update_weekly' => false,
    'async_typography' => false,
    'admin_bar' => true,
    'admin_bar_icon' => 'dashicons-admin-settings',
    'admin_bar_priority' => 50,
    'global_variable' => 'sports_news_opt',
    'dev_mode' => false,
    'update_notice' => false,
    'customizer' => true,
    'page_priority' => 2,
    'page_parent' => 'themes.php',
    'page_permissions' => 'manage_options',
    'menu_icon' => 'dashicons-admin-generic',
    'last_tab' => '',
    'page_icon' => 'icon-themes',
    'page_slug' => 'sports_news_options',
    'save_defaults' => true,
    'default_show' => false,
    'default_mark' => '',
    'show_import_export' => true,
    'transient_time' => 60 * MINUTE_IN_SECONDS,
    'output' => true,
    'output_tag' => true,
    'database' => '',
    'use_cdn' => false,
    'admin_search' => true,
);

Redux::setArgs($opt_name, $args);

// ============================================
// SECTION 1: General Settings
// ============================================
Redux::setSection($opt_name, array(
    'title' => 'الإعدادات العامة',
    'id' => 'general',
    'icon' => 'el el-cog',
    'fields' => array(
        array(
            'id' => 'site_logo',
            'type' => 'media',
            'title' => 'شعار الموقع',
            'subtitle' => 'قم برفع شعار موقعك',
            'default' => array('url' => ''),
        ),
        array(
            'id' => 'site_favicon',
            'type' => 'media',
            'title' => 'أيقونة الموقع (Favicon)',
            'subtitle' => 'أيقونة تظهر في تبويب المتصفح',
            'default' => array('url' => ''),
        ),
        array(
            'id' => 'primary_color',
            'type' => 'color',
            'title' => 'اللون الأساسي',
            'subtitle' => 'اللون الرئيسي للموقع',
            'default' => '#0C192F',
            'validate' => 'color',
        ),
        array(
            'id' => 'secondary_color',
            'type' => 'color',
            'title' => 'اللون الثانوي',
            'subtitle' => 'اللون الثانوي للموقع',
            'default' => '#000000',
            'validate' => 'color',
        ),
    )
));

// ============================================
// SECTION 2: Header Settings
// ============================================
Redux::setSection($opt_name, array(
    'title' => 'إعدادات الهيدر',
    'id' => 'header',
    'icon' => 'el el-website',
    'fields' => array(
        array(
            'id' => 'show_top_bar',
            'type' => 'switch',
            'title' => 'عرض الشريط العلوي',
            'default' => true,
        ),
        array(
            'id' => 'show_top_bar_date',
            'type' => 'switch',
            'title' => 'عرض التاريخ في الشريط العلوي',
            'default' => true,
            'required' => array('show_top_bar', '=', true),
        ),
        array(
            'id' => 'top_bar_menu',
            'type' => 'select',
            'data' => 'menus',
            'title' => 'قائمة الشريط العلوي',
            'subtitle' => 'اختر القائمة التي ستظهر بدلاً من اللغات.',
            'default' => '',
            'required' => array('show_top_bar', '=', true),
        ),
        array(
            'id' => 'header_main_menu',
            'type' => 'select',
            'data' => 'menus',
            'title' => 'القائمة الرئيسية',
            'subtitle' => 'اختر القائمة الرئيسية للموقع. اتركها فارغة لاستخدام القائمة الافتراضية "Primary".',
            'default' => '',
        ),
        array(
            'id' => 'top_bar_text',
            'type' => 'text',
            'title' => 'نص الشريط العلوي',
            'default' => 'مرحباً بكم في موقعنا الرياضي',
            'required' => array('show_top_bar', '=', true),
        ),
        array(
            'id' => 'show_search',
            'type' => 'switch',
            'title' => 'عرض البحث',
            'default' => true,
        ),

        array(
            'id' => 'header_sticky',
            'type' => 'switch',
            'title' => 'تثبيت الهيدر عند التمرير',
            'default' => true,
        ),
        array(
            'id' => 'header_bg_color',
            'type' => 'color',
            'title' => 'لون خلفية الهيدر',
            'subtitle' => 'اختر لون الخلفية للهيدر',
            'default' => '#ffffff',
            'transparent' => false,
        ),
        array(
            'id' => 'header_text_color',
            'type' => 'color',
            'title' => 'لون النصوص في الهيدر',
            'subtitle' => 'اختر لون النصوص والروابط في الهيدر',
            'default' => '#000000',
            'transparent' => false,
        ),
        array(
            'id' => 'header_top_bar_bg',
            'type' => 'color',
            'title' => 'لون خلفية الشريط العلوي',
            'subtitle' => 'اختر لون خلفية الشريط العلوي في الهيدر',
            'default' => '#0c192f',
            'transparent' => false,
            'required' => array('show_top_bar', '=', true),
        ),
        // Header Icons Section
        array(
            'id' => 'header_icons_section',
            'type' => 'section',
            'title' => 'أيقونات الهيدر',
            'subtitle' => 'إعدادات أيقونات التحكم في الهيدر',
            'indent' => true,
        ),
        array(
            'id' => 'show_header_search',
            'type' => 'switch',
            'title' => 'عرض أيقونة البحث',
            'default' => true,
        ),
        array(
            'id' => 'show_header_notifications',
            'type' => 'switch',
            'title' => 'عرض أيقونة الإشعارات',
            'default' => true,
        ),
        array(
            'id' => 'show_header_account',
            'type' => 'switch',
            'title' => 'عرض أيقونة الحساب',
            'default' => true,
        ),

    )
));


// ============================================
// SECTION 3: Homepage Sections
// ============================================
Redux::setSection($opt_name, array(
    'title' => 'أقسام الصفحة الرئيسية',
    'id' => 'homepage',
    'icon' => 'el el-home',
    'fields' => array(
        array(
            'id' => 'home_shortcodes_info',
            'type' => 'info',
            'style' => 'info',
            'title' => 'الأكواد المختصرة (Shortcodes)',
            'icon' => 'el el-info-circle',
'desc' => 'يمكنك استخدام هذه الأكواد لعرض أي قسم في أي صفحة:<br><br>' .
                     '<b>الرئيسية كاملة بالترتيب المختار أدناه:</b> [dm_homepage]<br>' .
                     '<b>البانر الرئيسي Hero:</b> [dm_hero]<br>' .
                     '<b>الفيديوهات:</b> [dm_videos]<br>' .
                     '<b>القصص Stories:</b> [dm_stories]<br>' .
                     '<b>الأقسام المتقدمة:</b> [dm_advanced]<br>' .
                     '<b>المزيد من الأخبار Compact:</b> [dm_compact]<br>' .
                     '<b>الأكثر قراءة Trending:</b> [dm_trending]<br>' .
                     '<b>قصص مميزة Zigzag:</b> [dm_zigzag]<br>' .
                     '<b>آخر الأحداث Timeline:</b> [dm_timeline]<br>' .
                     '<b>قسم شبكة [dm_grid_a] :A</b><br>' .
                     '<b>قسم شبكة [dm_grid_b] :B</b><br>' .
                     '<b>قسم الأقسام الثلاثة [dm_grid_c] :C</b>'
        ),
        array(
            'id' => 'home_sections_order',
            'type' => 'sortable',
            'title' => 'ترتيب أقسام الصفحة الرئيسية',
            'subtitle' => 'اسحب وأفلت لإعادة ترتيب الأقسام. يمكنك أيضاً استخدام الكود المختصر [dm_homepage] لعرض نفس الترتيب في أي صفحة.',
'options' => array(
                'hero' => 'قسم الواجهة Hero',
                'advanced' => 'قسم الأحدث (مع التابات)',
                'videos' => 'قسم الفيديوهات',
                'compact' => 'المزيد من الأخبار',
                'trending' => 'الأكثر قراءة',
                'zigzag' => 'قصص مميزة',
                'timeline' => 'آخر الأحداث',
                'stories' => 'القصص (Stories)',
                'grid_a' => 'قسم شبكة A (بدون تصنيف)',
                'grid_b' => 'قسم شبكة B (مع تصنيف)',
                'grid_c' => 'قسم أقسام ثلاثة C (3 أعمدة)',
            ),
            'label' => true,
            'default' => array(
                'enabled' => array(
                    'stories' => 'القصص (Stories)',
                    'hero' => 'قسم الواجهة Hero',
                    'advanced' => 'قسم الأحدث (مع التابات)',
                    'videos' => 'قسم الفيديوهات',
                    'grid_a' => 'قسم شبكة A (بدون تصنيف)',
                    'grid_b' => 'قسم شبكة B (مع تصنيف)',
                    'grid_c' => 'قسم أقسام ثلاثة C (3 أعمدة)',
                    'compact' => 'المزيد من الأخبار',
                    'trending' => 'الأكثر قراءة',
                    'zigzag' => 'قصص مميزة',
                    'timeline' => 'آخر الأحداث',
                ),
                'disabled' => array()
            )
        ),
    )
));

// Stories Section
Redux::setSection($opt_name, array(
    'title' => 'إعدادات القصص Stories',
    'id' => 'stories_settings',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'show_stories',
            'type' => 'switch',
            'title' => 'تفعيل قسم القصص',
            'default' => true,
        ),
        array(
            'id' => 'stories_count',
            'type' => 'slider',
            'title' => 'عدد القصص المعروضة',
            'default' => 4,
            'min' => 1,
            'max' => 20,
            'step' => 1,
            'required' => array('show_stories', '=', true),
        ),
        array(
            'id' => 'stories_category',
            'type' => 'select',
            'title' => 'تصنيف القصص',
            'data' => 'categories',
            'args' => array('orderby' => 'name', 'order' => 'ASC'),
            'default' => '',
            'placeholder' => 'اختر تصنيف (اتركه فارغاً لعرض آخر المقالات)...',
            'required' => array('show_stories', '=', true),
        ),
    )
));



// Hero Section
Redux::setSection($opt_name, array(
    'title' => 'قسم Hero',
    'id' => 'hero_section',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'show_hero',
            'type' => 'switch',
            'title' => 'عرض قسم Hero',
            'default' => true,
        ),
        array(
            'id' => 'hero_post_count',
            'type' => 'slider',
            'title' => 'عدد المقالات في Hero',
            'default' => 4,
            'min' => 3,
            'max' => 6,
            'step' => 1,
            'required' => array('show_hero', '=', true),
        ),
        array(
            'id' => 'hero_category',
            'type' => 'select',
            'title' => 'تصنيف قسم Hero',
            'data' => 'categories',
            'args' => array('orderby' => 'name', 'order' => 'ASC'),
            'default' => '',
            'placeholder' => 'اختر تصنيف...',
            'required' => array('show_hero', '=', true),
        ),
    )
));

// Videos Section
Redux::setSection($opt_name, array(
    'title' => 'قسم الفيديوهات',
    'id' => 'videos_section',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'show_videos',
            'type' => 'switch',
            'title' => 'عرض قسم الفيديوهات',
            'default' => true,
        ),
        array(
            'id' => 'videos_title',
            'type' => 'text',
            'title' => 'عنوان القسم',
            'default' => 'فيديو',
            'required' => array('show_videos', '=', true),
        ),
        array(
            'id' => 'videos_count',
            'type' => 'slider',
            'title' => 'عدد الفيديوهات',
            'default' => 5,
            'min' => 3,
            'max' => 50,
            'step' => 1,
            'required' => array('show_videos', '=', true),
        ),
        array(
            'id' => 'videos_category',
            'type' => 'select',
            'title' => 'تصنيف الفيديوهات',
            'data' => 'categories',
            'args' => array('orderby' => 'name', 'order' => 'ASC'),
            'default' => '',
            'placeholder' => 'اختر تصنيف...',
            'required' => array('show_videos', '=', true),
        ),
    )
));

// Compact Grid
Redux::setSection($opt_name, array(
    'title' => 'المزيد من الأخبار',
    'id' => 'compact_section',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'show_compact',
            'type' => 'switch',
            'title' => 'عرض قسم المزيد من الأخبار',
            'default' => true,
        ),
        array(
            'id' => 'compact_title',
            'type' => 'text',
            'title' => 'عنوان القسم',
            'default' => 'المزيد من الأخبار',
            'required' => array('show_compact', '=', true),
        ),
        array(
            'id' => 'compact_count',
            'type' => 'slider',
            'title' => 'عدد المقالات',
            'default' => 8,
            'min' => 4,
            'max' => 12,
            'step' => 1,
            'required' => array('show_compact', '=', true),
        ),
        array(
            'id' => 'compact_category',
            'type' => 'select',
            'title' => 'تصنيف المزيد من الأخبار',
            'data' => 'categories',
            'args' => array('orderby' => 'name', 'order' => 'ASC'),
            'default' => '',
            'placeholder' => 'اختر تصنيف...',
            'required' => array('show_compact', '=', true),
        ),
    )
));

// Grid A Section
Redux::setSection($opt_name, array(
    'title' => 'قسم Grid A',
    'id' => 'grid_a_section',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'show_grid_a',
            'type' => 'switch',
            'title' => 'عرض قسم Grid A',
            'default' => true,
        ),
        array(
            'id' => 'grid_a_title',
            'type' => 'text',
            'title' => 'عنوان القسم',
            'default' => 'منوعات',
            'required' => array('show_grid_a', '=', true),
        ),
        array(
            'id' => 'grid_a_count',
            'type' => 'slider',
            'title' => 'عدد المقالات',
            'default' => 4,
            'min' => 4,
            'max' => 12,
            'step' => 4,
            'required' => array('show_grid_a', '=', true),
        ),
        array(
            'id' => 'grid_a_category',
            'type' => 'select',
            'title' => 'تصنيف القسم',
            'data' => 'categories',
            'args' => array('orderby' => 'name', 'order' => 'ASC'),
            'default' => '',
            'placeholder' => 'اختر تصنيف...',
            'required' => array('show_grid_a', '=', true),
        ),
    )
));

// Grid B Section
Redux::setSection($opt_name, array(
    'title' => 'قسم Grid B',
    'id' => 'grid_b_section',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'show_grid_b',
            'type' => 'switch',
            'title' => 'عرض قسم Grid B',
            'default' => true,
        ),
        array(
            'id' => 'grid_b_title',
            'type' => 'text',
            'title' => 'عنوان القسم',
            'default' => 'حوارات العين الإخبارية',
            'required' => array('show_grid_b', '=', true),
        ),
        array(
            'id' => 'grid_b_count',
            'type' => 'slider',
            'title' => 'عدد المقالات',
            'default' => 4,
            'min' => 4,
            'max' => 12,
            'step' => 4,
            'required' => array('show_grid_b', '=', true),
        ),
        array(
            'id' => 'grid_b_category',
            'type' => 'select',
            'title' => 'تصنيف القسم',
            'data' => 'categories',
            'args' => array('orderby' => 'name', 'order' => 'ASC'),
            'default' => '',
            'placeholder' => 'اختر تصنيف...',
            'required' => array('show_grid_b', '=', true),
        ),
    )
));

// Grid C Section (Triple Columns)
Redux::setSection($opt_name, array(
    'title' => 'قسم 3 أقسام (Grid C)',
    'id' => 'grid_c_section',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'show_grid_c',
            'type' => 'switch',
            'title' => 'عرض قسم Grid C',
            'default' => true,
        ),
        // Column 1
        array(
            'id' => 'grid_c_title_1',
            'type' => 'text',
            'title' => 'عنوان العمود الأول',
            'default' => 'صحة',
            'required' => array('show_grid_c', '=', true),
        ),
        array(
            'id' => 'grid_c_cat_1',
            'type' => 'select',
            'title' => 'تصنيف العمود الأول',
            'data' => 'categories',
            'required' => array('show_grid_c', '=', true),
        ),
        // Column 2
        array(
            'id' => 'grid_c_title_2',
            'type' => 'text',
            'title' => 'عنوان العمود الثاني',
            'default' => 'تكنولوجيا',
            'required' => array('show_grid_c', '=', true),
        ),
        array(
            'id' => 'grid_c_cat_2',
            'type' => 'select',
            'title' => 'تصنيف العمود الثاني',
            'data' => 'categories',
            'required' => array('show_grid_c', '=', true),
        ),
        // Column 3
        array(
            'id' => 'grid_c_title_3',
            'type' => 'text',
            'title' => 'عنوان العمود الثالث',
            'default' => 'فن',
            'required' => array('show_grid_c', '=', true),
        ),
        array(
            'id' => 'grid_c_cat_3',
            'type' => 'select',
            'title' => 'تصنيف العمود الثالث',
            'data' => 'categories',
            'required' => array('show_grid_c', '=', true),
        ),
    )
));



// Trending Section
Redux::setSection($opt_name, array(
    'title' => 'الأكثر قراءة',
    'id' => 'trending_section',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'show_trending',
            'type' => 'switch',
            'title' => 'عرض قسم الأكثر قراءة',
            'default' => true,
        ),
        array(
            'id' => 'trending_title',
            'type' => 'text',
            'title' => 'عنوان القسم',
            'default' => 'الأكثر قراءة',
            'required' => array('show_trending', '=', true),
        ),
        array(
            'id' => 'trending_count',
            'type' => 'slider',
            'title' => 'عدد المقالات',
            'default' => 5,
            'min' => 3,
            'max' => 10,
            'step' => 1,
            'required' => array('show_trending', '=', true),
        ),
        array(
            'id' => 'trending_category',
            'type' => 'select',
            'title' => 'تصنيف الأكثر قراءة',
            'data' => 'categories',
            'args' => array('orderby' => 'name', 'order' => 'ASC'),
            'default' => '',
            'placeholder' => 'اختر تصنيف...',
            'required' => array('show_trending', '=', true),
        ),
    )
));

// Zigzag Section
Redux::setSection($opt_name, array(
    'title' => 'قصص مميزة (Zigzag)',
    'id' => 'zigzag_section',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'show_zigzag',
            'type' => 'switch',
            'title' => 'عرض قسم القصص المميزة',
            'default' => true,
        ),
        array(
            'id' => 'zigzag_title',
            'type' => 'text',
            'title' => 'عنوان القسم',
            'default' => 'قصص مميزة',
            'required' => array('show_zigzag', '=', true),
        ),
        array(
            'id' => 'zigzag_count',
            'type' => 'slider',
            'title' => 'عدد القصص',
            'default' => 3,
            'min' => 2,
            'max' => 6,
            'step' => 1,
            'required' => array('show_zigzag', '=', true),
        ),
        array(
            'id' => 'zigzag_category',
            'type' => 'select',
            'title' => 'تصنيف القصص المميزة',
            'data' => 'categories',
            'args' => array('orderby' => 'name', 'order' => 'ASC'),
            'default' => '',
            'placeholder' => 'اختر تصنيف...',
            'required' => array('show_zigzag', '=', true),
        ),
    )
));


// Timeline Section
Redux::setSection($opt_name, array(
    'title' => 'آخر الأحداث (Timeline)',
    'id' => 'timeline_section',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'show_timeline',
            'type' => 'switch',
            'title' => 'عرض قسم آخر الأحداث',
            'default' => true,
        ),
        array(
            'id' => 'timeline_title',
            'type' => 'text',
            'title' => 'عنوان القسم',
            'default' => 'آخر الأحداث',
            'required' => array('show_timeline', '=', true),
        ),
        array(
            'id' => 'timeline_count',
            'type' => 'slider',
            'title' => 'عدد الأحداث',
            'default' => 4,
            'min' => 3,
            'max' => 8,
            'step' => 1,
            'required' => array('show_timeline', '=', true),
        ),
        array(
            'id' => 'timeline_category',
            'type' => 'select',
            'title' => 'تصنيف آخر الأحداث',
            'data' => 'categories',
            'args' => array('orderby' => 'name', 'order' => 'ASC'),
            'default' => '',
            'placeholder' => 'اختر تصنيف...',
            'required' => array('show_timeline', '=', true),
        ),
    )
));




// ============================================
// Weather Settings
Redux::setSection($opt_name, array(
    'title' => 'إعدادات الطقس',
    'id' => 'weather_settings',
    'icon' => 'el el-cloud',
    'fields' => array(
        array(
            'id' => 'weather_api_key',
            'type' => 'text',
            'title' => 'OpenWeatherMap API Key',
            'subtitle' => 'احصل على مفتاح API مجاني من openweathermap.org',
            'default' => '',
        ),
        array(
            'id' => 'weather_default_city',
            'type' => 'text',
            'title' => 'المدينة الافتراضية',
            'default' => 'Cairo,EG',
        ),
        array(
            'id' => 'weather_units',
            'type' => 'button_set',
            'title' => 'وحدات القياس',
            'options' => array(
                'metric' => 'درجة مئوية (°C)',
                'imperial' => 'فهرنهايت (°F)',
            ),
            'default' => 'metric',
        ),
    )
));

// Widget Controls
Redux::setSection($opt_name, array(
    'title' => 'التحكم في الودجات',
    'id' => 'widget_controls',
    'icon' => 'el el-grid-3x3',
    'fields' => array(
        array(
            'id' => 'enable_widget_ad',
            'type' => 'switch',
            'title' => 'إعلان الشريط الجانبي',
            'default' => true,
        ),
        array(
            'id' => 'enable_widget_trending',
            'type' => 'switch',
            'title' => 'الأكثر قراءة (Trending)',
            'default' => true,
        ),
        array(
            'id' => 'enable_widget_categories',
            'type' => 'switch',
            'title' => 'تصنيفات مميزة',
            'default' => true,
        ),
        array(
            'id' => 'enable_widget_social',
            'type' => 'switch',
            'title' => 'نبض الملاعب (Social)',
            'default' => true,
        ),
        array(
            'id' => 'enable_widget_whatsapp',
            'type' => 'switch',
            'title' => 'قناة واتساب',
            'default' => true,
        ),
        array(
            'id' => 'enable_widget_search',
            'type' => 'switch',
            'title' => 'البحث المتقدم',
            'default' => true,
        ),
        array(
            'id' => 'enable_widget_author',
            'type' => 'switch',
            'title' => 'صندوق الكاتب',
            'default' => true,
        ),
        array(
            'id' => 'enable_widget_weather',
            'type' => 'switch',
            'title' => 'حالة الطقس',
            'default' => true,
        ),
        array(
            'id' => 'enable_widget_quote',
            'type' => 'switch',
            'title' => 'اقتباس رياضي',
            'default' => true,
        ),
        array(
            'id' => 'enable_widget_calendar',
            'type' => 'switch',
            'title' => 'التقويم الرياضي',
            'default' => true,
        ),
        array(
            'id' => 'enable_widget_newsletter',
            'type' => 'switch',
            'title' => 'النشرة البريدية',
            'default' => true,
        ),
    )
));

// ============================================
// SECTION 4: Sidebar Settings
// ============================================
Redux::setSection($opt_name, array(
    'title' => 'إعدادات الشريط الجانبي',
    'id' => 'sidebar',
    'icon' => 'el el-align-left',
    'fields' => array(
        array(
            'id' => 'show_sidebar',
            'type' => 'switch',
            'title' => 'عرض الشريط الجانبي',
            'default' => true,
        ),
        array(
            'id' => 'sidebar_position',
            'type' => 'button_set',
            'title' => 'موقع الشريط الجانبي',
            'options' => array(
                'left' => 'يسار',
                'right' => 'يمين',
            ),
            'default' => 'left',
            'required' => array('show_sidebar', '=', true),
        ),
        array(
            'id' => 'show_popular_posts',
            'type' => 'switch',
            'title' => 'عرض المقالات الشائعة',
            'default' => true,
            'required' => array('show_sidebar', '=', true),
        ),
        array(
            'id' => 'show_newsletter',
            'type' => 'switch',
            'title' => 'عرض النشرة البريدية',
            'default' => true,
            'required' => array('show_sidebar', '=', true),
        ),
        array(
            'id' => 'show_social_hub',
            'type' => 'switch',
            'title' => 'عرض روابط التواصل الاجتماعي',
            'default' => true,
            'required' => array('show_sidebar', '=', true),
        ),
    )
));

// ============================================
// SECTION 5: Footer Settings
// ============================================
Redux::setSection($opt_name, array(
    'title' => 'إعدادات الفوتر',
    'id' => 'footer',
    'icon' => 'el el-website-alt',
    'fields' => array(
        array(
            'id' => 'footer_logo',
            'type' => 'media',
            'title' => 'شعار الفوتر',
            'default' => array('url' => ''),
        ),
        array(
            'id' => 'footer_about',
            'type' => 'textarea',
            'title' => 'نبذة عن الموقع',
            'default' => 'موقعك الرياضي الأول للأخبار والتحليلات',
        ),

        array(
            'id' => 'footer_copyright',
            'type' => 'text',
            'title' => 'نص حقوق النشر',
            'default' => '© 2024 جميع الحقوق محفوظة',
        ),
        array(
            'id' => 'show_footer_newsletter',
            'type' => 'switch',
            'title' => 'عرض النشرة البريدية في الفوتر',
            'default' => true,
        ),
        
        // --- Top Section Controls ---
        array(
            'id' => 'footer_newsletter_title',
            'type' => 'text',
            'title' => 'عنوان النشرة البريدية',
            'default' => 'اشترك في النشرة الإخبارية لدينا لمتابعة كل المستجدات وقت حدوثها',
        ),
        // --- Column 1 (Sections) ---
        array(
            'id' => 'section_divider_1',
            'type' => 'section',
            'title' => 'إعدادات العمود الأول (الأقسام)',
            'indent' => true,
        ),
        array(
            'id' => 'footer_col1_title',
            'type' => 'text',
            'title' => 'عنوان العمود الأول',
            'default' => 'الأقسام',
        ),
        array(
            'id' => 'footer_col1_menu',
            'type' => 'select',
            'data' => 'menus',
            'title' => 'قائمة العمود الأول',
            'subtitle' => 'اختر القائمة التي تريد عرضها هنا. اتركها "Default" لاستخدام القائمة المسندة إلى "قائمة الفوتر" في الووردبريس.',
            'default' => '',
        ),

        // --- Column 2 (Sports) ---
        array(
            'id' => 'section_divider_2',
            'type' => 'section',
            'title' => 'إعدادات العمود الثاني (رياضة)',
            'indent' => true,
        ),
        array(
            'id' => 'footer_col2_title',
            'type' => 'text',
            'title' => 'عنوان العمود الثاني',
            'default' => 'رياضة',
        ),
        array(
            'id' => 'footer_col2_menu',
            'type' => 'select',
            'data' => 'menus',
            'title' => 'قائمة العمود الثاني',
            'subtitle' => 'اختر القائمة للعمود الثاني.',
            'default' => '',
        ),

        // --- Column 3 (Community) ---
        array(
            'id' => 'section_divider_3',
            'type' => 'section',
            'title' => 'إعدادات العمود الثالث (مجتمع)',
            'indent' => true,
        ),
        array(
            'id' => 'footer_col3_title',
            'type' => 'text',
            'title' => 'عنوان العمود الثالث',
            'default' => 'مجتمع',
        ),
        array(
            'id' => 'footer_col3_menu',
            'type' => 'select',
            'data' => 'menus',
            'title' => 'قائمة العمود الثالث',
            'subtitle' => 'اختر القائمة للعمود الثالث.',
            'default' => '',
        ),
    )
));

// ============================================
// SECTION 6: Social Media
// ============================================
Redux::setSection($opt_name, array(
    'title' => 'روابط التواصل الاجتماعي',
    'id' => 'social',
    'icon' => 'el el-share',
    'fields' => array(
        array(
            'id' => 'facebook_url',
            'type' => 'text',
            'title' => 'رابط Facebook',
            'default' => '',
            'validate' => 'url',
        ),
        array(
            'id' => 'twitter_url',
            'type' => 'text',
            'title' => 'رابط Twitter/X',
            'default' => '',
            'validate' => 'url',
        ),
        array(
            'id' => 'instagram_url',
            'type' => 'text',
            'title' => 'رابط Instagram',
            'default' => '',
            'validate' => 'url',
        ),
        array(
            'id' => 'youtube_url',
            'type' => 'text',
            'title' => 'رابط YouTube',
            'default' => '',
            'validate' => 'url',
        ),
        array(
            'id' => 'tiktok_url',
            'type' => 'text',
            'title' => 'رابط TikTok',
            'default' => '',
            'validate' => 'url',
        ),
        array(
            'id' => 'linkedin_url',
            'type' => 'text',
            'title' => 'رابط LinkedIn',
            'default' => '',
            'validate' => 'url',
        ),
        array(
            'id' => 'whatsapp_url',
            'type' => 'text',
            'title' => 'رابط WhatsApp',
            'default' => '',
            'validate' => 'url',
        ),
   
    )
));

// ============================================
// SECTION 10: SEO Settings
// ============================================
Redux::setSection($opt_name, array(
    'title' => 'إعدادات SEO',
    'id' => 'seo',
    'icon' => 'el el-search',
    'fields' => array(
        array('id' => 'site_meta_title', 'type' => 'text', 'title' => 'عنوان الموقع (Meta Title)', 'subtitle' => 'يظهر في نتائج البحث'),
        array('id' => 'site_meta_description', 'type' => 'textarea', 'title' => 'وصف الموقع (Meta Description)'),
        array('id' => 'site_meta_keywords', 'type' => 'text', 'title' => 'الكلمات المفتاحية'),
        array('id' => 'og_image', 'type' => 'media', 'title' => 'صورة المشاركة (Open Graph)'),
        array('id' => 'enable_breadcrumbs', 'type' => 'switch', 'title' => 'تفعيل مسار التنقل', 'default' => true),
        array('id' => 'enable_schema', 'type' => 'switch', 'title' => 'تفعيل Schema Markup', 'default' => true),
    )
));

// ============================================
// SECTION 11: Ads Management
// ============================================
Redux::setSection($opt_name, array('title' => 'إدارة الإعلانات', 'id' => 'ads', 'icon' => 'el el-bullhorn'));

// Google AdSense Settings
Redux::setSection($opt_name, array(
    'title' => 'إعدادات Google AdSense', 'id' => 'adsense_settings', 'subsection' => true,
    'fields' => array(
        array('id' => 'adsense_enabled', 'type' => 'switch', 'title' => 'تفعيل Google AdSense', 'subtitle' => 'تفعيل نظام AdSense على الموقع', 'default' => false),
        array('id' => 'adsense_publisher_id', 'type' => 'text', 'title' => 'رقم الناشر (Publisher ID)', 'subtitle' => 'رقم الناشر الخاص بك من حساب AdSense', 'required' => array('adsense_enabled', '=', true)),
        array('id' => 'adsense_auto_ads', 'type' => 'switch', 'title' => 'تفعيل الإعلانات التلقائية', 'default' => true, 'required' => array('adsense_enabled', '=', true)),
        array('id' => 'adsense_ad_code', 'type' => 'textarea', 'title' => 'كود AdSense مخصص', 'subtitle' => 'استخدم هذا إذا كنت ترغب في استخدام كود مخصص بدلاً من الإعلانات التلقائية', 'required' => array('adsense_enabled', '=', true)),
    )
));

Redux::setSection($opt_name, array(
    'title' => 'إعلانات الهيدر', 'id' => 'header_ads', 'subsection' => true,
    'fields' => array(
        array('id' => 'enable_header_ad', 'type' => 'switch', 'title' => 'تفعيل إعلان الهيدر', 'default' => false),
        array('id' => 'header_ad_code', 'type' => 'ace_editor', 'title' => 'كود الإعلان', 'mode' => 'html', 'theme' => 'monokai', 'required' => array('enable_header_ad', '=', true)),
    )
));
Redux::setSection($opt_name, array(
    'title' => 'إعلانات الشريط الجانبي', 'id' => 'sidebar_ads', 'subsection' => true,
    'fields' => array(
        array('id' => 'enable_sidebar_ad', 'type' => 'switch', 'title' => 'تفعيل إعلان الشريط الجانبي', 'default' => false),
        array('id' => 'sidebar_ad_code', 'type' => 'ace_editor', 'title' => 'كود الإعلان', 'mode' => 'html', 'theme' => 'monokai', 'required' => array('enable_sidebar_ad', '=', true)),
    )
));

// ============================================
// SECTION 12: Single Post Settings
// ============================================
Redux::setSection($opt_name, array(
    'title' => 'إعدادات المقال الفردي', 'id' => 'single_post', 'icon' => 'el el-file-edit',
    'fields' => array(
        array('id' => 'show_post_author', 'type' => 'switch', 'title' => 'عرض معلومات الكاتب', 'default' => true),
        array('id' => 'show_post_date', 'type' => 'switch', 'title' => 'عرض تاريخ النشر', 'default' => true),
        array('id' => 'show_post_views', 'type' => 'switch', 'title' => 'عرض عدد المشاهدات', 'default' => true),
        array('id' => 'show_post_tags', 'type' => 'switch', 'title' => 'عرض الوسوم', 'default' => true),
        array('id' => 'show_post_share', 'type' => 'switch', 'title' => 'عرض أزرار المشاركة', 'default' => true),
        array('id' => 'show_related_posts', 'type' => 'switch', 'title' => 'عرض المقالات ذات الصلة', 'default' => true),
        array('id' => 'related_posts_count', 'type' => 'slider', 'title' => 'عدد المقالات ذات الصلة', 'default' => 3, 'min' => 2, 'max' => 6, 'required' => array('show_related_posts', '=', true)),
        array('id' => 'show_author_box', 'type' => 'switch', 'title' => 'عرض صندوق معلومات الكاتب', 'default' => true),
        array('id' => 'enable_comments', 'type' => 'switch', 'title' => 'تفعيل التعليقات', 'default' => true),
    )
));

// ============================================
// SECTION 13: Archive Pages
// ============================================
Redux::setSection($opt_name, array(
    'title' => 'صفحات الأرشيف', 'id' => 'archive', 'icon' => 'el el-folder-open',
    'fields' => array(
        array('id' => 'archive_posts_per_page', 'type' => 'slider', 'title' => 'عدد المقالات في الصفحة', 'default' => 12, 'min' => 6, 'max' => 24, 'step' => 3),
        array('id' => 'archive_show_excerpt', 'type' => 'switch', 'title' => 'عرض مقتطف من المقال', 'default' => true),
        array('id' => 'archive_excerpt_length', 'type' => 'slider', 'title' => 'طول المقتطف (كلمات)', 'default' => 20, 'min' => 10, 'max' => 50, 'step' => 5),
    )
));

// ============================================
// SECTION: Search Settings
// ============================================
Redux::setSection($opt_name, array(
    'title' => 'إعدادات البحث',
    'id' => 'search_settings_section',
    'icon' => 'el el-search',
    'fields' => array(
        array(
            'id' => 'search_placeholder',
            'type' => 'text',
            'title' => 'نص البحث (Placeholder)',
            'default' => 'ابحث عن مواضيع، أخبار، أو مقالات...',
        ),
        array(
            'id' => 'search_posts_per_page',
            'type' => 'slider',
            'title' => 'عدد نتائج البحث في الصفحة',
            'default' => 12,
            'min' => 4,
            'max' => 24,
            'step' => 1,
        ),
        array(
            'id' => 'search_include_pages',
            'type' => 'switch',
            'title' => 'تضمين الصفحات في نتائج البحث',
            'default' => false,
        ),
        array(
            'id' => 'search_live_ajax',
            'type' => 'switch',
            'title' => 'تفعيل البحث المباشر (Ajax Search)',
            'default' => true,
        ),
        array(
            'id' => 'search_no_results_text',
            'type' => 'textarea',
            'title' => 'رسالة عند عدم وجود نتائج',
            'default' => 'عذراً، لم نتمكن من العثور على نتائج تطابق بحثك. جرب كلمات مفتاحية أخرى.',
        ),
    )
));

// ============================================
// SECTION 14: Newsletter Settings
// ============================================
Redux::setSection($opt_name, array(
    'title' => 'إعدادات النشرة البريدية', 'id' => 'newsletter', 'icon' => 'el el-envelope',
    'fields' => array(
        array('id' => 'show_footer_newsletter', 'type' => 'switch', 'title' => 'عرض النشرة البريدية', 'default' => true),
        array('id' => 'newsletter_title', 'type' => 'text', 'title' => 'عنوان النشرة', 'default' => 'اشترك في نشرتنا البريدية'),
        array('id' => 'newsletter_description', 'type' => 'textarea', 'title' => 'وصف النشرة', 'default' => 'احصل على آخر الأخبار مباشرة في بريدك الإلكتروني'),
    )
));

// ============================================
// SECTION 15: Breaking News Ticker
// ============================================
Redux::setSection($opt_name, array(
    'title' => 'شريط الأخبار العاجلة', 'id' => 'breaking_news', 'icon' => 'el el-fire',
    'fields' => array(
        array('id' => 'enable_breaking_news', 'type' => 'switch', 'title' => 'تفعيل شريط الأخبار العاجلة', 'default' => true),
        array('id' => 'breaking_news_label', 'type' => 'text', 'title' => 'نص التسمية', 'default' => 'عاجل', 'required' => array('enable_breaking_news', '=', true)),
        array('id' => 'breaking_news_count', 'type' => 'slider', 'title' => 'عدد الأخبار', 'default' => 8, 'min' => 5, 'max' => 15, 'required' => array('enable_breaking_news', '=', true)),
        array('id' => 'breaking_news_speed', 'type' => 'slider', 'title' => 'سرعة الحركة (ثانية)', 'default' => 30, 'min' => 10, 'max' => 60, 'step' => 5, 'required' => array('enable_breaking_news', '=', true)),
    )
));

// ============================================
// SECTION 16: Maintenance Mode
// ============================================
Redux::setSection($opt_name, array(
    'title' => 'وضع الصيانة', 'id' => 'maintenance', 'icon' => 'el el-wrench-alt',
    'fields' => array(
        array('id' => 'enable_maintenance', 'type' => 'switch', 'title' => 'تفعيل وضع الصيانة', 'subtitle' => 'سيظهر الموقع في وضع الصيانة للزوار', 'default' => false),
        array('id' => 'maintenance_title', 'type' => 'text', 'title' => 'عنوان صفحة الصيانة', 'default' => 'الموقع قيد الصيانة', 'required' => array('enable_maintenance', '=', true)),
        array('id' => 'maintenance_message', 'type' => 'editor', 'title' => 'رسالة الصيانة', 'default' => 'نعمل حالياً على تحسين الموقع. سنعود قريباً!', 'required' => array('enable_maintenance', '=', true)),
    )
));



// ============================================
// SECTION 17: Import/Export
// ============================================
Redux::setSection($opt_name, array(
    'title' => 'استيراد/تصدير', 'id' => 'import_export', 'icon' => 'el el-refresh',
    'fields' => array(
        array('id' => 'import_export', 'type' => 'import_export', 'title' => 'استيراد وتصدير الإعدادات', 'full_width' => false),
    )
));

// ============================================
// SECTION 7: Typography
// ============================================
Redux::setSection($opt_name, array(
    'title' => 'الخطوط والطباعة',
    'id' => 'typography',
    'icon' => 'el el-fontsize',
    'fields' => array(
        array(
            'id' => 'body_font',
            'type' => 'typography',
            'title' => 'خط النصوص الأساسي',
            'google' => true,
            'font-backup' => true,
            'all_styles' => true,
            'units' => 'px',
            'default' => array(
                'font-family' => 'Noto Naskh Arabic',
                'font-size' => '16px',
            ),
        ),
        array(
            'id' => 'heading_font',
            'type' => 'typography',
            'title' => 'خط العناوين',
            'google' => true,
            'font-backup' => true,
            'all_styles' => true,
            'units' => 'px',
            'default' => array(
                'font-family' => 'Noto Kufi Arabic',
                'font-weight' => '700',
            ),
        ),
    )
));

// ============================================
// SECTION 8: Performance
// ============================================
Redux::setSection($opt_name, array(
    'title' => 'الأداء والتحسين',
    'id' => 'performance',
    'icon' => 'el el-dashboard',
    'fields' => array(
        array(
            'id' => 'enable_lazy_load',
            'type' => 'switch',
            'title' => 'تفعيل Lazy Loading للصور',
            'default' => true,
        ),
        array(
            'id' => 'enable_minify',
            'type' => 'switch',
            'title' => 'ضغط ملفات CSS و JS',
            'default' => false,
        ),
        array(
            'id' => 'enable_cache',
            'type' => 'switch',
            'title' => 'تفعيل الكاش',
            'default' => true,
        ),
    )
));

// ============================================
// SECTION 9: Advanced
// ============================================
Redux::setSection($opt_name, array(
    'title' => 'إعدادات متقدمة',
    'id' => 'advanced',
    'icon' => 'el el-wrench',
    'fields' => array(
        array(
            'id' => 'custom_css',
            'type' => 'ace_editor',
            'title' => 'CSS مخصص',
            'subtitle' => 'أضف أكواد CSS الخاصة بك',
            'mode' => 'css',
            'theme' => 'monokai',
            'default' => '',
        ),
        array(
            'id' => 'custom_js',
            'type' => 'ace_editor',
            'title' => 'JavaScript مخصص',
            'subtitle' => 'أضف أكواد JavaScript الخاصة بك',
            'mode' => 'javascript',
            'theme' => 'monokai',
            'default' => '',
        ),
        array(
            'id' => 'google_analytics',
            'type' => 'textarea',
            'title' => 'كود Google Analytics',
            'subtitle' => 'الصق كود التتبع هنا',
            'default' => '',
        ),
    )
));

// ============================================
// SECTION 18: Layout & Design
// ============================================
Redux::setSection($opt_name, array(
    'title' => 'التخطيط والتصميم', 'id' => 'layout_design', 'icon' => 'el el-screen',
    'fields' => array(
        array('id' => 'site_layout', 'type' => 'button_set', 'title' => 'تخطيط الموقع', 'options' => array('boxed' => 'محدود', 'full' => 'كامل العرض'), 'default' => 'full'),
        array('id' => 'container_width', 'type' => 'slider', 'title' => 'عرض الحاوية (px)', 'default' => 1320, 'min' => 1140, 'max' => 1920, 'step' => 60),
        array('id' => 'border_radius', 'type' => 'slider', 'title' => 'انحناء الحواف (px)', 'default' => 24, 'min' => 0, 'max' => 50, 'step' => 2),
        array('id' => 'theme_style', 'type' => 'button_set', 'title' => 'نمط التصميم', 'options' => array('default' => 'افتراضي', 'speed' => 'السرعة'), 'default' => 'default'),
    )
));

// SECTION 19: Comments System
Redux::setSection($opt_name, array(
    'title' => 'نظام التعليقات', 'id' => 'comments_system', 'icon' => 'el el-comment',
    'fields' => array(
        array('id' => 'comments_system_type', 'type' => 'button_set', 'title' => 'نوع نظام التعليقات', 'options' => array('wordpress' => 'WordPress', 'disqus' => 'Disqus'), 'default' => 'wordpress'),
        array('id' => 'disqus_shortname', 'type' => 'text', 'title' => 'Disqus Shortname', 'required' => array('comments_system_type', '=', 'disqus')),
        array('id' => 'comments_per_page', 'type' => 'slider', 'title' => 'عدد التعليقات في الصفحة', 'default' => 10, 'min' => 5, 'max' => 50, 'step' => 5),
    )
));

// SECTION 20: 404 Page
Redux::setSection($opt_name, array(
    'title' => 'صفحة 404', 'id' => 'page_404', 'icon' => 'el el-error',
    'fields' => array(
        array('id' => '404_title', 'type' => 'text', 'title' => 'عنوان صفحة 404', 'default' => 'الصفحة غير موجودة'),
        array('id' => '404_message', 'type' => 'editor', 'title' => 'رسالة صفحة 404', 'default' => 'عذراً، الصفحة التي تبحث عنها غير موجودة.'),
        array('id' => 'show_404_search', 'type' => 'switch', 'title' => 'عرض البحث في صفحة 404', 'default' => true),
    )
));

// SECTION 20.4: Footer Settings
Redux::setSection($opt_name, array(
    'title' => 'إعدادات الفوتر',
    'id' => 'footer_settings',
    'icon' => 'el el-website',
    'fields' => array(
        array(
            'id' => 'footer_bg_color',
            'type' => 'color',
            'title' => 'لون خلفية الفوتر',
            'subtitle' => 'اختر لون الخلفية للفوتر',
            'default' => '#1a1a1a',
            'transparent' => false,
        ),
        array(
            'id' => 'footer_text_color',
            'type' => 'color',
            'title' => 'لون النصوص في الفوتر',
            'subtitle' => 'اختر لون النصوص والروابط في الفوتر',
            'default' => '#ffffff',
            'transparent' => false,
        ),
        array(
            'id' => 'footer_heading_color',
            'type' => 'color',
            'title' => 'لون العناوين في الفوتر',
            'subtitle' => 'اختر لون العناوين في الفوتر',
            'default' => '#ffffff',
            'transparent' => false,
        ),
        array(
            'id' => 'footer_bottom_bg',
            'type' => 'color',
            'title' => 'لون خلفية الشريط السفلي',
            'subtitle' => 'اختر لون خلفية الشريط السفلي في الفوتر',
            'default' => '#000000',
            'transparent' => false,
        ),
    )
));

// SECTION 20.5: Article Settings
Redux::setSection($opt_name, array(
    'title' => 'إعدادات المقالات',
    'id' => 'article_settings',
    'icon' => 'el el-file-edit',
    'fields' => array(
        array(
            'id'       => 'post_layout_design',
            'type'     => 'image_select',
            'title'    => 'تصميم صفحة المقال',
            'subtitle' => 'اختر التصميم المفضل لعرض المقالات الفردية.',
            'options'  => array(
                'design-1' => array(
                    'alt'   => 'تصميم كلاسيكي',
                    'img'   => ReduxFramework::$_url . 'assets/img/1col.png',
                    'title' => 'كلاسيكي (مع شريط جانبي)'
                ),
                'design-2' => array(
                    'alt'   => 'تصميم نظيف',
                    'img'   => ReduxFramework::$_url . 'assets/img/1c.png',
                    'title' => 'نظيف (بدون شريط جانبي)'
                ),
                'design-3' => array(
                    'alt'   => 'تصميم عصري',
                    'img'   => ReduxFramework::$_url . 'assets/img/2cl.png',
                    'title' => 'عصري (صورة خلفية للعنوان)'
                ),
            ),
            'default'  => 'design-1'
        ),
        array(
            'id' => 'show_audio_player',
            'type' => 'switch',
            'title' => 'عرض زر "استمع للمقال"',
            'subtitle' => 'تفعيل أو تعطيل مشغل الصوت في المقالات.',
            'default' => true,
        ),
        array(
            'id' => 'audio_player_api_key',
            'type' => 'text',
            'title' => 'مفتاح API الخاص بـ ResponsiveVoice',
            'subtitle' => 'أدخل مفتاح الـ API الخاص بك من موقع ResponsiveVoice للحصول على أفضل أداء.',
            'default' => 'Oynxp8Hd',
            'required' => array('show_audio_player', '=', true),
        ),
        array(
            'id' => 'show_author_box',
            'type' => 'switch',
            'title' => 'عرض صندوق الكاتب',
            'default' => true,
        ),
        array(
            'id' => 'show_related_posts',
            'type' => 'switch',
            'title' => 'عرض المقالات ذات الصلة',
            'default' => true,
        ),
        array(
            'id' => 'related_posts_count',
            'type' => 'slider',
            'title' => 'عدد المقالات ذات الصلة',
            'default' => 3,
            'min' => 2,
            'max' => 6,
            'step' => 1,
            'required' => array('show_related_posts', '=', true),
        ),
    )
));

// SECTION 20.6: Archive Settings
Redux::setSection($opt_name, array(
    'title' => 'إعدادات الأرشيف',
    'id' => 'archive_settings',
    'icon' => 'el el-folder-open',
    'fields' => array(
        array(
            'id'       => 'archive_layout_design',
            'type'     => 'image_select',
            'title'    => 'تصميم صفحة الأرشيف',
            'subtitle' => 'اختر التصميم المفضل لعرض صفحات الأقسام والوسوم والأرشيف.',
            'options'  => array(
                'design-1' => array(
                    'alt'   => 'شبكة كلاسيكية',
                    'img'   => ReduxFramework::$_url . 'assets/img/2cl.png',
                    'title' => 'شبكة (مع شريط جانبي)'
                ),
                'design-2' => array(
                    'alt'   => 'قائمة مودرن',
                    'img'   => ReduxFramework::$_url . 'assets/img/1col.png',
                    'title' => 'قائمة (مع شريط جانبي)'
                ),
                'design-3' => array(
                    'alt'   => 'ماسونري كامل',
                    'img'   => ReduxFramework::$_url . 'assets/img/3cl.png',
                    'title' => 'ماسونري (بدون شريط جانبي)'
                ),
            ),
            'default'  => 'design-1'
        ),
        array(
            'id' => 'archive_show_excerpt',
            'type' => 'switch',
            'title' => 'عرض مقتطف المقال',
            'default' => true,
        ),
        array(
            'id' => 'archive_posts_per_page',
            'type' => 'slider',
            'title' => 'عدد المقالات في الصفحة',
            'default' => 10,
            'min' => 4,
            'max' => 20,
            'step' => 1,
        ),
    )
));

// SECTION 20.7: Page Settings
Redux::setSection($opt_name, array(
    'title' => 'إعدادات الصفحات',
    'id' => 'page_settings',
    'icon' => 'el el-file',
    'fields' => array(
        array(
            'id'       => 'page_layout_design',
            'type'     => 'image_select',
            'title'    => 'تصميم الصفحات الداخلية',
            'subtitle' => 'اختر التصميم المفضل لعرض الصفحات المستقلة.',
            'options'  => array(
                'design-1' => array(
                    'alt'   => 'كلاسيكي مع شريط جانبي',
                    'img'   => ReduxFramework::$_url . 'assets/img/2cl.png',
                    'title' => 'كلاسيكي (مع شريط جانبي)'
                ),
                'design-2' => array(
                    'alt'   => 'بسيط وبدون شريط جانبي',
                    'img'   => ReduxFramework::$_url . 'assets/img/1c.png',
                    'title' => 'متمركز (بدون شريط جانبي)'
                ),
                'design-3' => array(
                    'alt'   => 'تصميم متميز مع صورة هيرو',
                    'img'   => ReduxFramework::$_url . 'assets/img/2cl.png',
                    'title' => 'متميز (هيرو + بدون شريط)'
                ),
            ),
            'default'  => 'design-1'
        ),
        array(
            'id' => 'page_show_breadcrumb',
            'type' => 'switch',
            'title' => 'عرض مسار التصفح (Breadcrumb)',
            'default' => true,
        ),
        array(
            'id' => 'page_show_share',
            'type' => 'switch',
            'title' => 'عرض أزرار المشاركة',
            'default' => true,
        ),
    )
));

// SECTION 21: Reading Time
Redux::setSection($opt_name, array(
    'title' => 'وقت القراءة', 'id' => 'reading_time', 'icon' => 'el el-time',
    'fields' => array(
        array('id' => 'enable_reading_time', 'type' => 'switch', 'title' => 'عرض وقت القراءة', 'default' => true),
        array('id' => 'reading_speed', 'type' => 'slider', 'title' => 'سرعة القراءة (كلمة/دقيقة)', 'default' => 200, 'min' => 150, 'max' => 300, 'step' => 10),
    )
));

// SECTION 22: Post Views Counter
Redux::setSection($opt_name, array(
    'title' => 'عداد المشاهدات', 'id' => 'post_views', 'icon' => 'el el-eye-open',
    'fields' => array(
        array('id' => 'enable_post_views', 'type' => 'switch', 'title' => 'تفعيل عداد المشاهدات', 'default' => true),
        array('id' => 'count_admin_views', 'type' => 'switch', 'title' => 'حساب مشاهدات المدراء', 'default' => false),
    )
));

// SECTION 23: Share Buttons
Redux::setSection($opt_name, array(
    'title' => 'أزرار المشاركة', 'id' => 'share_buttons', 'icon' => 'el el-share-alt',
    'fields' => array(
        array('id' => 'share_facebook', 'type' => 'switch', 'title' => 'Facebook', 'default' => true),
        array('id' => 'share_twitter', 'type' => 'switch', 'title' => 'Twitter/X', 'default' => true),
        array('id' => 'share_whatsapp', 'type' => 'switch', 'title' => 'WhatsApp', 'default' => true),
        array('id' => 'share_telegram', 'type' => 'switch', 'title' => 'Telegram', 'default' => true),
        array('id' => 'share_email', 'type' => 'switch', 'title' => 'Email', 'default' => true),
    )
));

// SECTION 24: Security Settings
Redux::setSection($opt_name, array(
    'title' => 'إعدادات الأمان', 'id' => 'security', 'icon' => 'el el-lock',
    'fields' => array(
        array('id' => 'disable_xmlrpc', 'type' => 'switch', 'title' => 'تعطيل XML-RPC', 'default' => true),
        array('id' => 'hide_wp_version', 'type' => 'switch', 'title' => 'إخفاء نسخة WordPress', 'default' => true),
        array('id' => 'disable_file_editing', 'type' => 'switch', 'title' => 'تعطيل تحرير الملفات', 'default' => false),
    )
));

// SECTION 25: Custom Post Types
Redux::setSection($opt_name, array(
    'title' => 'أنواع المحتوى المخصصة', 'id' => 'custom_post_types', 'icon' => 'el el-list-alt',
    'fields' => array(
        array('id' => 'enable_portfolio', 'type' => 'switch', 'title' => 'تفعيل Portfolio', 'default' => false),
        array('id' => 'enable_testimonials', 'type' => 'switch', 'title' => 'تفعيل Testimonials', 'default' => false),
        array('id' => 'enable_players', 'type' => 'switch', 'title' => 'تفعيل Players', 'default' => false),
    )
));

// SECTION 26: Email Notifications
Redux::setSection($opt_name, array(
    'title' => 'إشعارات البريد', 'id' => 'email_notifications', 'icon' => 'el el-envelope-alt',
    'fields' => array(
        array('id' => 'admin_email', 'type' => 'text', 'title' => 'بريد المدير', 'validate' => 'email', 'default' => get_option('admin_email')),
        array('id' => 'notify_new_comment', 'type' => 'switch', 'title' => 'إشعار عند تعليق جديد', 'default' => true),
        array('id' => 'notify_new_user', 'type' => 'switch', 'title' => 'إشعار عند مستخدم جديد', 'default' => true),
    )
));

// SECTION 27: Developer Tools
Redux::setSection($opt_name, array(
    'title' => 'أدوات المطورين', 'id' => 'developer', 'icon' => 'el el-cog-alt',
    'fields' => array(
        array('id' => 'enable_debug_mode', 'type' => 'switch', 'title' => 'تفعيل وضع التطوير', 'default' => false),
        array('id' => 'show_template_hints', 'type' => 'switch', 'title' => 'عرض أسماء القوالب', 'default' => false),
    )
));



