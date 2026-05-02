<?php
/**
 * Custom Sidebar Widgets for Drama Mojaz Theme
 * 
 * This file registers the unified premium sidebar and defines custom widgets
 * that mirror the original hardcoded design.
 */

if (!defined('ABSPATH')) exit;

/**
 * Register Unified Premium Sidebar
 */
function dm_register_sidebars() {
    register_sidebar(array(
        'name'          => 'Unified Premium Sidebar',
        'id'            => 'sidebar-1',
        'description'   => 'The main sidebar for the theme. Add premium widgets here.',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title sr-only">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'dm_register_sidebars');

/**
 * Register All Custom Widgets
 */
function dm_register_custom_widgets() {
    if (sports_news_get_opt('enable_widget_ad', true)) register_widget('DM_Ad_Widget');
    if (sports_news_get_opt('enable_widget_trending', true)) register_widget('DM_Trending_Posts_Widget');
    if (sports_news_get_opt('enable_widget_categories', true)) register_widget('DM_Categories_Widget');
    if (sports_news_get_opt('enable_widget_social', true)) register_widget('DM_Social_Hub_Widget');
    if (sports_news_get_opt('enable_widget_whatsapp', true)) register_widget('DM_WhatsApp_CTA_Widget');
    if (sports_news_get_opt('enable_widget_search', true)) register_widget('DM_Search_Widget');
    if (sports_news_get_opt('enable_widget_author', true)) register_widget('DM_Author_Box_Widget');
    if (sports_news_get_opt('enable_widget_weather', true)) register_widget('DM_Weather_Widget');
    if (sports_news_get_opt('enable_widget_quote', true)) register_widget('DM_Quote_Widget');
    if (sports_news_get_opt('enable_widget_calendar', true)) register_widget('DM_Calendar_Widget');
    if (sports_news_get_opt('enable_widget_newsletter', true)) register_widget('DM_Newsletter_Widget');
}
add_action('widgets_init', 'dm_register_custom_widgets');

/**
 * 1. Advertisement Block Widget
 */
class DM_Ad_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct('dm_ad_widget', 'DM: Advertisement Block', array('description' => 'Premium advertisement block.'));
    }

    public function widget($args, $instance) {
        $ad_code = sports_news_get_opt('sidebar_ad_code');
        if (!$ad_code) return;

        echo $args['before_widget'];
        ?>
        <div class="bg-medium border border-medium p-3 rounded-[2rem] overflow-hidden shadow-inner flex flex-col items-center justify-center min-h-[250px] group relative">
            <span class="absolute top-3 right-5 text-[8px] font-black kufi text-medium uppercase tracking-widest">مساحة إعلانية</span>
            <?php echo $ad_code; ?>
        </div>
        <?php
        echo $args['after_widget'];
    }

    public function form($instance) {
        echo '<p>Configure ad code in Theme Options > Sidebar Ad settings.</p>';
    }
}

/**
 * 2. Trending Posts Widget
 */
class DM_Trending_Posts_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct('dm_trending_posts_widget', 'DM: Trending Posts', array('description' => 'Displays posts ordered by comment count.'));
    }

    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : 'الأكثر قراءة';
        $count = !empty($instance['count']) ? absint($instance['count']) : 4;

        echo $args['before_widget'];
        ?>
        <div class="bg-light border border-medium p-8 md:p-10 relative overflow-hidden text-right rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.02)]">
            <div class="absolute -top-10 -left-10 w-40 h-40 bg-primary/2 rounded-full blur-3xl"></div>
            
            <div class="flex items-center gap-4 mb-12 relative z-10">
                <div class="w-2.5 h-10 bg-dark rounded-full shadow-lg"></div>
                <h2 class="kufi text-2xl md:text-3xl font-black theme-text-dark tracking-tight"><?php echo esc_html($title); ?></h2>
            </div>
            
            <div class="space-y-12 relative z-10">
                <?php
                $trending = new WP_Query(array('posts_per_page' => $count, 'orderby' => 'comment_count'));
                $rank = 1;
                if ($trending->have_posts()) :
                    while ($trending->have_posts()) : $trending->the_post();
                    ?>
                    <div class="flex items-start gap-4 md:gap-5 group cursor-pointer border-b border-gray-50 last:border-0 pb-8 last:pb-0" onclick="window.location='<?php the_permalink(); ?>'">
                        <div class="relative flex-shrink-0 pt-1">
                            <span class="text-4xl md:text-5xl font-black text-medium group-hover:text-primary transition-all duration-700 italic leading-none select-none inline-block">
                                <?php echo sprintf('%02d', $rank++); ?>
                            </span>
                        </div>
                        
                        <div class="flex-grow flex items-start gap-4 min-w-0">
                            <div class="flex-grow min-w-0">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="text-[8px] font-black kufi text-primary uppercase bg-primary/5 px-2 py-1 rounded-lg border border-primary/10">تريند</span>
                                    <span class="text-[9px] font-bold text-medium kufi"><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ' . 'منذ'; ?></span>
                                </div>
                                <h3 class="kufi font-black text-sm md:text-base leading-[1.6] theme-text-dark group-hover:text-primary transition-colors line-clamp-2">
                                    <?php the_title(); ?>
                                </h3>
                            </div>

                            <div class="w-16 h-16 md:w-20 md:h-20 rounded-2xl overflow-hidden flex-shrink-0 relative shadow-lg group-hover:shadow-primary/20 transition-all duration-500">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('thumbnail', array('class' => 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-700')); ?>
                                <?php else : ?>
                                    <div class="w-full h-full bg-medium flex items-center justify-center">
                                        <i class="ri-image-2-line text-medium text-xl"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            </div>
                        </div>
                    </div>
                    <?php 
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </div>
        <?php
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : 'الأكثر قراءة';
        $count = !empty($instance['count']) ? absint($instance['count']) : 4;
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">Title:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('count')); ?>">Number of posts:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('count')); ?>" name="<?php echo esc_attr($this->get_field_name('count')); ?>" type="number" value="<?php echo esc_attr($count); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['count'] = (!empty($new_instance['count'])) ? absint($new_instance['count']) : 4;
        return $instance;
    }
}

/**
 * 3. Categories Highlight Widget
 */
class DM_Categories_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct('dm_categories_widget', 'DM: Categories Highlight', array('description' => 'Displays top categories by post count.'));
    }

    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : 'مواضيع تهمك';
        $count = !empty($instance['count']) ? absint($instance['count']) : 8;

        echo $args['before_widget'];
        ?>
        <div class="bg-light border border-medium p-8 md:p-10 rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.02)]">
            <div class="flex items-center gap-4 mb-10">
                <div class="w-2.5 h-10 bg-primary rounded-full shadow-lg shadow-primary/20"></div>
                <h2 class="kufi text-2xl md:text-3xl font-black text-dark tracking-tight"><?php echo esc_html($title); ?></h2>
            </div>
            
            <div class="flex flex-wrap gap-3">
                <?php
                $categories = get_categories(array('orderby' => 'count', 'order' => 'DESC', 'number' => $count));
                foreach ($categories as $cat) :
                ?>
                <a href="<?php echo get_category_link($cat->term_id); ?>" class="group flex items-center gap-3 bg-medium hover:bg-primary px-5 py-3 rounded-2xl transition-all duration-500 border border-medium">
                    <span class="text-xs font-black kufi text-light group-hover:text-white transition-colors"><?php echo esc_html($cat->name); ?></span>
                    <span class="bg-white/80 text-[9px] font-black px-2 py-1 rounded-lg text-primary shadow-sm"><?php echo esc_html($cat->count); ?></span>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : 'مواضيع تهمك';
        $count = !empty($instance['count']) ? absint($instance['count']) : 8;
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">Title:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('count')); ?>">Number of categories:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('count')); ?>" name="<?php echo esc_attr($this->get_field_name('count')); ?>" type="number" value="<?php echo esc_attr($count); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['count'] = (!empty($new_instance['count'])) ? absint($new_instance['count']) : 8;
        return $instance;
    }
}

/**
 * 4. Social Media Hub Widget
 */
class DM_Social_Hub_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct('dm_social_hub_widget', 'DM: Social Media Hub', array('description' => 'Displays social media links with counters.'));
    }

    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : 'نبض الملاعب';
        $subtitle = !empty($instance['subtitle']) ? $instance['subtitle'] : 'كن أول من يعلم في كل مكان';

        echo $args['before_widget'];
        ?>
        <div class="bg-secondary p-10 text-white relative overflow-hidden rounded-[3rem] shadow-2xl shadow-secondary/20">
            <div class="absolute top-0 right-0 w-full h-full bg-[radial-gradient(circle_at_20%_20%,rgba(227,27,35,0.15),transparent_60%)]"></div>
            <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-primary/20 rounded-full blur-[100px]"></div>
            
            <div class="relative z-10">
                <div class="text-center mb-12">
                    <h2 class="kufi text-3xl font-black tracking-tight mb-4 text-white"><?php echo esc_html($title); ?></h2>
                    <div class="flex items-center justify-center gap-2 text-primary">
                        <span class="w-8 h-1 bg-primary rounded-full"></span>
                        <i class="ri-heart-pulse-fill text-2xl"></i>
                        <span class="w-8 h-1 bg-primary rounded-full"></span>
                    </div>
                    <p class="text-white/40 text-[10px] font-black kufi uppercase tracking-[0.2em] mt-6"><?php echo esc_html($subtitle); ?></p>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <?php 
                    $socials = [
                        ['id' => 'facebook_url', 'l' => 'فيسبوك', 'i' => 'ri-facebook-circle-fill', 's' => '250K'],
                        ['id' => 'twitter_url', 'l' => 'تويتر X', 'i' => 'ri-twitter-x-fill', 's' => '120K'],
                        ['id' => 'instagram_url', 'l' => 'إنستقرام', 'i' => 'ri-instagram-fill', 's' => '90K'],
                        ['id' => 'tiktok_url', 'l' => 'تيك توك', 'i' => 'ri-tiktok-fill', 's' => '400K'],
                    ];
                    foreach ($socials as $s) :
                        $url = sports_news_get_opt($s['id'], '#');
                    ?>
                    <a href="<?php echo esc_url($url); ?>" class="group flex flex-col p-6 bg-white/5 border border-white/10 rounded-[2rem] hover:bg-primary transition-all duration-500 hover:-translate-y-2 relative overflow-hidden" aria-label="<?php echo esc_attr($s['l']); ?>">
                        <div class="absolute -bottom-4 -right-4 text-6xl text-white/5 group-hover:text-white/10 transition-colors">
                            <i class="<?php echo esc_attr($s['i']); ?>"></i>
                        </div>
                        <i class="<?php echo esc_attr($s['i']); ?> text-3xl mb-4 text-primary group-hover:text-white transition-colors"></i>
                        <span class="text-xl font-black mb-1"><?php echo esc_html($s['s']); ?></span>
                        <span class="text-[9px] font-black kufi uppercase tracking-widest text-white/40 group-hover:text-white/80"><?php echo esc_html($s['l']); ?></span>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : 'نبض الملاعب';
        $subtitle = !empty($instance['subtitle']) ? $instance['subtitle'] : 'كن أول من يعلم في كل مكان';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">Title:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('subtitle')); ?>">Subtitle:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('subtitle')); ?>" name="<?php echo esc_attr($this->get_field_name('subtitle')); ?>" type="text" value="<?php echo esc_attr($subtitle); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['subtitle'] = (!empty($new_instance['subtitle'])) ? strip_tags($new_instance['subtitle']) : '';
        return $instance;
    }
}

/**
 * 5. WhatsApp Call-To-Action Widget
 */
class DM_WhatsApp_CTA_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct('dm_whatsapp_cta_widget', 'DM: WhatsApp CTA', array('description' => 'WhatsApp channel call to action.'));
    }

    public function widget($args, $instance) {
        $url = !empty($instance['url']) ? $instance['url'] : '#';
        $title = !empty($instance['title']) ? $instance['title'] : 'انضم لقناتنا';
        $subtitle = !empty($instance['subtitle']) ? $instance['subtitle'] : 'على واتساب';

        echo $args['before_widget'];
        ?>
        <a href="<?php echo esc_url($url); ?>" class="flex items-center justify-between p-6 bg-[#111827] rounded-3xl hover:bg-[#111827] transition-all group/wa">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 flex items-center justify-center rounded-2xl bg-white/10 hover:bg-[#25d366] transition-all group">
                    <i class="ri-whatsapp-line text-white"></i>
                </div>
                <div class="text-right">
                    <span class="block text-white font-black kufi text-sm leading-none mb-1"><?php echo esc_html($title); ?></span>
                    <span class="block text-white/70 text-[10px] font-bold"><?php echo esc_html($subtitle); ?></span>
                </div>
            </div>
            <i class="ri-arrow-left-s-line text-white text-2xl group-hover/wa:-translate-x-2 transition-transform"></i>
        </a>
        <?php
        echo $args['after_widget'];
    }

    public function form($instance) {
        $url = !empty($instance['url']) ? $instance['url'] : '#';
        $title = !empty($instance['title']) ? $instance['title'] : 'انضم لقناتنا';
        $subtitle = !empty($instance['subtitle']) ? $instance['subtitle'] : 'على واتساب';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('url')); ?>">URL:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('url')); ?>" name="<?php echo esc_attr($this->get_field_name('url')); ?>" type="text" value="<?php echo esc_attr($url); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">Title:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('subtitle')); ?>">Subtitle:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('subtitle')); ?>" name="<?php echo esc_attr($this->get_field_name('subtitle')); ?>" type="text" value="<?php echo esc_attr($subtitle); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['url'] = (!empty($new_instance['url'])) ? esc_url($new_instance['url']) : '#';
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['subtitle'] = (!empty($new_instance['subtitle'])) ? strip_tags($new_instance['subtitle']) : '';
        return $instance;
    }
}

/**
 * 6. Premium Search Widget
 */
class DM_Search_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct('dm_search_widget', 'DM: Premium Search', array('description' => 'A beautifully designed search bar for the sidebar.'));
    }

    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';

        echo $args['before_widget'];
        ?>
        <div class="bg-secondary p-8 md:p-10 rounded-[3rem] shadow-2xl shadow-secondary/20 relative overflow-hidden group/search-block">
            <!-- Background Decoration -->
            <div class="absolute top-0 right-0 w-full h-full bg-[radial-gradient(circle_at_80%_20%,rgba(227,27,35,0.1),transparent_50%)]"></div>
            <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-primary/10 rounded-full blur-2xl group-hover/search-block:bg-primary/20 transition-all duration-700"></div>

            <div class="relative z-10">
                <?php if ($title) : ?>
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-1.5 h-8 bg-primary rounded-full shadow-[0_0_15px_rgba(227,27,35,0.5)]"></div>
                        <h2 class="kufi text-xl md:text-2xl font-black text-white tracking-tight"><?php echo esc_html($title); ?></h2>
                    </div>
                <?php endif; ?>
                
                <form role="search" method="get" class="relative" action="<?php echo esc_url(home_url('/')); ?>">
                    <div class="relative flex items-center">
                        <input type="search" 
                               class="w-full bg-white/5 border border-white/10 focus:border-primary/50 focus:ring-8 focus:ring-primary/5 rounded-[1.5rem] py-5 pr-16 pl-14 kufi font-bold text-white text-sm placeholder:text-white/30 transition-all duration-500 outline-none backdrop-blur-sm text-right" 
                               placeholder="عما تبحث اليوم؟" 
                               value="<?php echo get_search_query(); ?>" 
                               name="s" />
                        
                        <div class="absolute right-5 flex items-center justify-center pointer-events-none">
                            <i class="ri-search-eye-line text-2xl text-primary opacity-80 group-focus-within/search-block:opacity-100 transition-opacity"></i>
                        </div>
                        
                        <button type="submit" class="absolute left-3 w-11 h-11 bg-primary hover:bg-primary-dark text-white rounded-2xl flex items-center justify-center transition-all duration-300 hover:scale-105 active:scale-95 shadow-lg shadow-primary/30">
                            <i class="ri-arrow-left-line text-xl"></i>
                        </button>
                    </div>
                </form>

                <div class="mt-6 flex items-center gap-3 overflow-x-auto no-scrollbar pb-2">
                    <span class="text-[10px] font-black kufi text-white/40 uppercase tracking-widest whitespace-nowrap">مقترح:</span>
                    <?php
                    $tags = get_tags(array('orderby' => 'count', 'order' => 'DESC', 'number' => 3));
                    if ($tags) :
                        foreach ($tags as $tag) :
                        ?>
                            <a href="<?php echo get_tag_link($tag->term_id); ?>" class="text-[9px] font-bold kufi text-white/60 hover:text-primary transition-colors whitespace-nowrap bg-white/5 px-3 py-1.5 rounded-lg border border-white/5 hover:border-primary/30">
                                #<?php echo esc_html($tag->name); ?>
                            </a>
                        <?php 
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
        </div>
        <?php
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">Title (Optional):</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }
}

/**
 * 7. Premium Author Box Widget
 */
class DM_Author_Box_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct('dm_author_box_widget', 'DM: Author Box', array('description' => 'Displays author information with a premium design.'));
    }

    public function widget($args, $instance) {
        // Find author ID
        $author_id = 0;
        if (is_single()) {
            global $post;
            $author_id = $post->post_author;
        } else {
            // Fallback to the first administrator or a specific ID if provided
            $admin_users = get_users(array('role' => 'Administrator', 'number' => 1));
            if (!empty($admin_users)) {
                $author_id = $admin_users[0]->ID;
            }
        }

        if (!$author_id) return;

        $user_data = get_userdata($author_id);
        $display_name = $user_data->display_name;
        $description = get_user_meta($author_id, 'description', true);
        $post_count = count_user_posts($author_id);
        $author_url = get_author_posts_url($author_id);

        echo $args['before_widget'];
        ?>
        <div class="bg-light border border-medium p-7 md:p-9 rounded-[2.5rem] shadow-[0_24px_56px_rgba(0,0,0,0.04)] relative overflow-hidden group/author">
            <!-- Decorative Element -->
            <div class="absolute -top-14 -right-14 w-40 h-40 bg-primary/10 rounded-full blur-3xl group-hover/author:bg-primary/20 transition-all duration-700"></div>
            <div class="absolute -bottom-16 -left-16 w-40 h-40 bg-dark/5 rounded-full blur-3xl"></div>
            
            <div class="relative z-10 flex flex-col items-center text-center">
                <!-- Avatar with Premium Ring -->
                <div class="relative mb-5">
                    <div class="w-28 h-28 rounded-[2rem] overflow-hidden border-[5px] border-white shadow-[0_16px_35px_rgba(0,0,0,0.16)] rotate-2 group-hover/author:rotate-0 transition-transform duration-500">
                        <?php echo get_avatar($author_id, 150, '', '', array('class' => 'w-full h-full object-cover')); ?>
                    </div>
                      <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 bg-primary text-white px-6 py-2.5 rounded-2xl flex items-center gap-2 shadow-2xl shadow-primary/30 border border-white/20 whitespace-nowrap scale-90 group-hover:scale-100 transition-all duration-500">
                        <i class="ri-verified-badge-fill text-xl"></i>
                        <span class="text-xs font-black kufi uppercase tracking-widest">كاتب مؤكد</span>
                    </div>
                </div>

                <h3 class="kufi font-black text-2xl mb-3 theme-text-dark leading-tight tracking-tight">
                    <?php echo esc_html($display_name); ?>
                </h3>

                <?php if ($description) : ?>
                    <p class="text-medium text-xs leading-[1.9] mb-6 line-clamp-3 italic bg-white/80 border border-gray-100 rounded-2xl px-4 py-3 w-full">
                        "<?php echo esc_html($description); ?>"
                    </p>
                <?php endif; ?>

                <!-- Stats Grid -->
                <div class="grid grid-cols-2 gap-3 w-full mb-7">
                    <div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">
                        <span class="block text-primary font-black text-2xl leading-none mb-2"><?php echo esc_html($post_count); ?></span>
                        <span class="text-[10px] font-black kufi text-medium">مقال</span>
                    </div>
                    <div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">
                        <span class="block text-primary font-black text-2xl leading-none mb-2">5.0</span>
                        <span class="text-[10px] font-black kufi text-medium">التقييم</span>
                    </div>
                </div>

                <a href="<?php echo esc_url($author_url); ?>" class="w-full bg-dark hover:bg-primary text-white text-[11px] font-black kufi py-4 rounded-2xl border border-dark/20 transition-all duration-500 flex items-center justify-center gap-2 group/btn shadow-[0_12px_24px_rgba(17,24,39,0.25)] hover:shadow-[0_12px_24px_rgba(227,27,35,0.25)]">
                    شاهد كافة المقالات
                    <i class="ri-arrow-left-up-line transition-transform group-hover/btn:-translate-y-1 group-hover/btn:-translate-x-1"></i>
                </a>
            </div>
        </div>
        <?php
        echo $args['after_widget'];
    }

    public function form($instance) {
        echo '<p>Displays the current post author on single pages, or primary administrator on other pages.</p>';
    }
}

/**
 * 8. Premium Weather Widget (High-End Mockup/Configurable)
 */
class DM_Weather_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct('dm_weather_widget', 'DM: Premium Weather', array('description' => 'A visually stunning weather display with live OpenWeatherMap integration.'));
    }

    private function fetch_weather_data($city) {
        $api_key = sports_news_get_opt('weather_api_key');
        if (!$api_key) return array('error' => 'API Key Missing');

        $units = sports_news_get_opt('weather_units', 'metric');
        $transient_key = 'dm_weather_' . md5($city . $units);
        $cached_data = get_transient($transient_key);

        if ($cached_data !== false) {
            return $cached_data;
        }

        // Fetch current weather
        $url = sprintf(
            'https://api.openweathermap.org/data/2.5/weather?q=%s&units=%s&appid=%s&lang=ar',
            urlencode($city),
            $units,
            $api_key
        );

        $response = wp_remote_get($url, array('timeout' => 10));
        if (is_wp_error($response)) {
            return array('error' => $response->get_error_message());
        }

        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        
        if (!$data || !isset($data['cod']) || $data['cod'] != 200) {
            $msg = isset($data['message']) ? $data['message'] : 'Unknown API Error';
            return array('error' => $msg);
        }

        set_transient($transient_key, $data, HOUR_IN_SECONDS);
        return $data;
    }

    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $default_city = sports_news_get_opt('weather_default_city', 'Cairo,EG');
        $city = !empty($instance['location']) ? $instance['location'] : $default_city;
        $units = sports_news_get_opt('weather_units', 'metric');
        $unit_symbol = ($units === 'metric') ? '°C' : '°F';
        
        $weather = $this->fetch_weather_data($city);

        echo $args['before_widget'];
        
        if ($title) : ?>
            <div class="flex items-center gap-4 mb-8">
                <div class="w-1.5 h-8 bg-primary rounded-full shadow-[0_0_15px_rgba(227,27,35,0.5)]"></div>
                <h2 class="kufi text-xl md:text-2xl font-black text-dark tracking-tight"><?php echo esc_html($title); ?></h2>
            </div>
        <?php endif;

        if (isset($weather['error'])) : ?>
            <div class="bg-light border border-medium p-8 rounded-[2.5rem] text-center shadow-sm">
                <div class="w-16 h-16 bg-primary/5 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="ri-cloud-off-line text-3xl text-primary"></i>
                </div>
                <p class="text-sm font-black kufi theme-text-dark mb-2">عذراً، تعذر جلب بيانات الطقس</p>
                <?php if (current_user_can('manage_options')) : ?>
                    <div class="mt-4 p-3 bg-red-50 text-red-600 text-[10px] rounded-xl border border-red-100 font-bold">
                        Error: <?php echo esc_html($weather['error']); ?>
                    </div>
                <?php else : ?>
                    <p class="text-[10px] text-medium leading-relaxed">يرجى المحاولة مرة أخرى لاحقاً.</p>
                <?php endif; ?>
            </div>
        <?php else: 
            $temp = round($weather['main']['temp']);
            $desc = $weather['weather'][0]['description'];
            $icon_code = $weather['weather'][0]['icon'];
            $city_name = $weather['name'];
            $humidity = $weather['main']['humidity'];
            $wind_speed = round($weather['wind']['speed'], 1);
            
            // Map OWM icons to Remix Icons
            $icon_map = [
                '01' => 'ri-sun-fill',
                '02' => 'ri-sun-cloudy-fill',
                '03' => 'ri-cloudy-fill',
                '04' => 'ri-cloudy-2-fill',
                '09' => 'ri-showers-fill',
                '10' => 'ri-rainy-fill',
                '11' => 'ri-thunderstorms-fill',
                '13' => 'ri-snowy-fill',
                '50' => 'ri-mist-fill'
            ];
            $base_icon = substr($icon_code, 0, 2);
            $ri_icon = isset($icon_map[$base_icon]) ? $icon_map[$base_icon] : 'ri-cloud-fill';
        ?>
        <div class="relative group/weather overflow-hidden rounded-[3rem] aspect-square md:aspect-auto shadow-2xl shadow-primary/5">
            <!-- Animated Background Gradient -->
            <?php 
                $gradient = 'from-[#4facfe] to-[#00f2fe]'; // Default Clear/Mild
                if ($base_icon == '01') $gradient = 'from-[#ff9a9e] via-[#fecfef] to-[#ff9a9e]'; // Clear Sky
                if (in_array($base_icon, ['02', '03', '04'])) $gradient = 'from-[#a1c4fd] to-[#c2e9fb]'; // Cloudy
                if (in_array($base_icon, ['09', '10', '11'])) $gradient = 'from-[#667eea] to-[#764ba2]'; // Rainy/Storm
                if ($base_icon == '13') $gradient = 'from-[#e6e9f0] to-[#eef1f5]'; // Snow
            ?>
            <div class="absolute inset-0 bg-gradient-to-br <?php echo $gradient; ?> bg-[length:200%_200%] animate-gradient-slow opacity-90"></div>
            
            <!-- Glass Overlay -->
            <div class="absolute inset-0 bg-white/10 backdrop-blur-md border border-white/20 m-3 rounded-[2.2rem]"></div>
            
            <div class="relative z-10 p-10 flex flex-col h-full text-dark">
                <div class="flex items-start justify-between mb-8">
                    <div>
                        <div class="flex items-center gap-2 mb-2 bg-black/5 self-start px-3 py-1 rounded-full backdrop-blur-sm">
                            <i class="ri-map-pin-2-fill text-[10px] text-primary"></i>
                            <span class="text-[10px] font-black kufi uppercase tracking-widest"><?php echo esc_html($city_name); ?></span>
                        </div>
                        <h3 class="kufi font-black text-2xl leading-tight text-slate-800"><?php echo esc_html($desc); ?></h3>
                    </div>
                    <div class="relative">
                        <i class="<?php echo $ri_icon; ?> text-6xl text-white drop-shadow-2xl"></i>
                    </div>
                </div>

                <div class="flex items-baseline gap-2 mb-10">
                    <span class="text-7xl font-black tracking-tighter text-slate-900"><?php echo esc_html($temp); ?></span>
                    <span class="text-4xl font-light opacity-40 text-slate-900"><?php echo esc_html($unit_symbol); ?></span>
                </div>

                <div class="grid grid-cols-2 gap-4 bg-white/30 p-5 rounded-3xl border border-white/40 backdrop-blur-xl">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-2xl bg-white/50 flex items-center justify-center text-primary shadow-sm">
                            <i class="ri-water-percent-line text-xl"></i>
                        </div>
                        <div>
                            <span class="block text-[9px] font-black kufi opacity-50 text-slate-800">الرطوبة</span>
                            <span class="block text-sm font-bold text-slate-900"><?php echo esc_html($humidity); ?>%</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-2xl bg-white/50 flex items-center justify-center text-primary shadow-sm">
                            <i class="ri-windy-line text-xl"></i>
                        </div>
                        <div>
                            <span class="block text-[9px] font-black kufi opacity-50 text-slate-800">الرياح</span>
                            <span class="block text-sm font-bold text-slate-900"><?php echo esc_html($wind_speed); ?> <?php echo ($units === 'metric') ? 'كم/س' : 'ميل/س'; ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif;
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $location = !empty($instance['location']) ? $instance['location'] : '';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">Widget Title (Optional):</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('location')); ?>">City Name (e.g., London,UK or Cairo):</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('location')); ?>" name="<?php echo esc_attr($this->get_field_name('location')); ?>" type="text" value="<?php echo esc_attr($location); ?>" placeholder="Leave blank for default city">
            <small>Uses the default city from Theme Options if empty.</small>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['location'] = (!empty($new_instance['location'])) ? strip_tags($new_instance['location']) : '';
        return $instance;
    }
}

/**
 * 9. Premium Random Quote Widget
 */
class DM_Quote_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct('dm_quote_widget', 'DM: Random Quote', array('description' => 'A beautifully styled quote widget.'));
    }

    public function widget($args, $instance) {
        $quotes = [
            ['q' => 'المستحيل ليس حقيقة، إنه مجرد رأي.', 'a' => 'محمد علي كلاي'],
            ['q' => 'الفوز ليس كل شيء، لكن الرغبة في الفوز هي كل شيء.', 'a' => 'فينس لومباردي'],
            ['q' => 'أنا لا أخسر أبداً، إما أن أفوز أو أتعلم.', 'a' => 'نيلسون مانديلا'],
            ['q' => 'الموهبة تفوز بالمباريات، لكن العمل الجماعي يفوز بالبطولات.', 'a' => 'مايكل جوردان'],
        ];
        $random = $quotes[array_rand($quotes)];
        
        $quote_text = !empty($instance['quote']) ? $instance['quote'] : $random['q'];
        $author_text = !empty($instance['author']) ? $instance['author'] : $random['a'];

        echo $args['before_widget'];
        ?>
        <div class="relative group/quote overflow-hidden rounded-[3rem] bg-secondary p-12 text-center shadow-2xl shadow-secondary/20">
            <!-- Animated Background Accent -->
            <div class="absolute -top-24 -left-24 w-64 h-64 bg-primary/10 rounded-full blur-[80px] group-hover/quote:scale-150 transition-transform duration-1000"></div>
            
            <div class="relative z-10 flex flex-col items-center">
                <div class="w-16 h-16 bg-white/5 rounded-2xl flex items-center justify-center mb-10 border border-white/10 rotate-6 group-hover/quote:rotate-0 transition-transform duration-500">
                    <i class="ri-double-quotes-r text-3xl text-primary drop-shadow-[0_0_8px_rgba(227,27,35,0.4)]"></i>
                </div>
                
                <h3 class="kufi font-black text-xl md:text-2xl text-white leading-[1.8] mb-10 relative">
                    <span class="relative z-10"><?php echo esc_html($quote_text); ?></span>
                    <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 w-12 h-1 bg-primary/30 rounded-full"></div>
                </h3>
                
                <div class="flex items-center gap-4">
                    <span class="w-4 h-px bg-white/20"></span>
                    <span class="text-[10px] font-black kufi text-primary uppercase tracking-[0.3em]"><?php echo esc_html($author_text); ?></span>
                    <span class="w-4 h-px bg-white/20"></span>
                </div>
            </div>
        </div>
        <?php
        echo $args['after_widget'];
    }

    public function form($instance) {
        $quote = !empty($instance['quote']) ? $instance['quote'] : '';
        $author = !empty($instance['author']) ? $instance['author'] : '';
        ?>
        <p>Leave blank for random sport quotes.</p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('quote')); ?>">Specific Quote:</label>
            <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('quote')); ?>" name="<?php echo esc_attr($this->get_field_name('quote')); ?>"><?php echo esc_textarea($quote); ?></textarea>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('author')); ?>">Author:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('author')); ?>" name="<?php echo esc_attr($this->get_field_name('author')); ?>" type="text" value="<?php echo esc_attr($author); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['quote'] = (!empty($new_instance['quote'])) ? strip_tags($new_instance['quote']) : '';
        $instance['author'] = (!empty($new_instance['author'])) ? strip_tags($new_instance['author']) : '';
        return $instance;
    }
}

/**
 * 10. Premium Calendar Widget
 */
class DM_Calendar_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct('dm_calendar_widget', 'DM: Premium Calendar', array('description' => 'A stylized WordPress calendar.'));
    }

    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : 'أجندة المباريات';

        echo $args['before_widget'];
        ?>
        <div class="bg-light border border-medium p-7 md:p-9 rounded-[2.5rem] shadow-[0_20px_55px_rgba(0,0,0,0.04)] relative overflow-hidden group/cal premium-calendar-wrap">
            <div class="absolute top-0 right-0 w-36 h-36 bg-primary/5 rounded-full blur-3xl -mr-20 -mt-20"></div>
            
            <div class="flex items-center justify-between mb-8 relative z-10">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-[0_10px_20px_rgba(0,0,0,0.08)] border border-gray-100 group-hover/cal:scale-110 transition-transform">
                        <i class="ri-calendar-event-line text-2xl text-primary"></i>
                    </div>
                    <h2 class="kufi text-xl md:text-2xl font-black theme-text-dark tracking-tight"><?php echo esc_html($title); ?></h2>
                </div>
            </div>
            
            <div class="premium-calendar-inner relative z-10">
                <?php get_calendar(); ?>
            </div>

            <style>
                .premium-calendar-wrap {
                    background-image: linear-gradient(180deg, rgba(255,255,255,0.75), rgba(255,255,255,0.96));
                }
                .premium-calendar-inner table {
                    width: 100%;
                    border-collapse: separate;
                    border-spacing: 8px;
                    position: relative;
                }
                .premium-calendar-inner th {
                    font-family: 'Tajawal', sans-serif;
                    font-size: 11px;
                    font-weight: 900;
                    color: #9ca3af;
                    padding-bottom: 14px;
                    text-transform: uppercase;
                    letter-spacing: 0.08em;
                }
                .premium-calendar-inner td { 
                    text-align: center; 
                    padding: 0;
                    font-family: 'Tajawal', sans-serif; 
                    font-weight: 800; 
                    font-size: 14px; 
                    color: #111827;
                    background: #ffffff;
                    border-radius: 14px;
                    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                    border: 1px solid #e5e7eb;
                    width: 44px;
                    height: 44px;
                }
                .premium-calendar-inner td a {
                    display: flex;
                    width: 100%;
                    height: 100%;
                    align-items: center;
                    justify-content: center;
                    color: inherit;
                    border-radius: inherit;
                }
                .premium-calendar-inner td:hover:not(.pad) { 
                    background: #fff7f7;
                    color: #E31B23; 
                    transform: translateY(-3px);
                    box-shadow: 0 10px 20px rgba(227, 27, 35, 0.12);
                    border-color: rgba(227, 27, 35, 0.25);
                }
                .premium-calendar-inner #today { 
                    background: #E31B23; 
                    color: white; 
                    border-color: #E31B23;
                    box-shadow: 0 10px 24px rgba(227, 27, 35, 0.35);
                    transform: scale(1.04);
                }
                .premium-calendar-inner caption { 
                    font-family: 'Tajawal', sans-serif; 
                    font-weight: 900; 
                    font-size: 20px;
                    margin-bottom: 18px;
                    color: #111827;
                    text-align: right;
                    display: block;
                    letter-spacing: -0.01em;
                }
                .premium-calendar-inner nav { 
                    display: flex; 
                    justify-content: space-between; 
                    margin-top: 16px;
                    padding-top: 14px;
                    border-top: 1px dashed #d1d5db;
                    font-size: 11px;
                    font-weight: 900;
                }
                .premium-calendar-inner nav a { 
                    color: #E31B23;
                    display: flex;
                    align-items: center;
                    gap: 5px;
                    padding: 6px 10px;
                    border-radius: 999px;
                    background: #fff1f2;
                    transition: all 0.25s ease;
                }
                .premium-calendar-inner nav a:hover {
                    background: #E31B23;
                    color: #fff;
                }
                .premium-calendar-inner .pad { background: transparent; border: none; }
                @media (max-width: 480px) {
                    .premium-calendar-inner table { border-spacing: 6px; }
                    .premium-calendar-inner td {
                        width: 38px;
                        height: 38px;
                        font-size: 13px;
                    }
                    .premium-calendar-inner caption {
                        font-size: 18px;
                    }
                }
            </style>
        </div>
        <?php
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : 'تقويم الفعاليات';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">Title:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }
}

/**
 * 11. Premium Newsletter/CTA Widget
 */
class DM_Newsletter_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct('dm_newsletter_widget', 'DM: Premium Newsletter', array('description' => 'A high-conversion newsletter subscription block.'));
    }

    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : 'أهم الانفرادات في بريدك';
        $desc = !empty($instance['desc']) ? $instance['desc'] : 'انضم لأكثر من 50,000 مشترك يحصلون على تحليلاتنا الحصرية يومياً.';

        echo $args['before_widget'];
        ?>
        <div class="relative group/news overflow-hidden rounded-[3.5rem] bg-[#0A0A0A] p-10 md:p-12 text-center shadow-2xl shadow-black/40">
            <!-- Animated Background Mesh -->
            <div class="absolute inset-0 opacity-30">
                <div class="absolute top-0 left-0 w-full h-full bg-[radial-gradient(circle_at_0%_0%,rgba(227,27,35,0.15),transparent_50%)]"></div>
                <div class="absolute bottom-0 right-0 w-full h-full bg-[radial-gradient(circle_at_100%_100%,rgba(227,27,35,0.1),transparent_50%)]"></div>
            </div>
            
            <div class="relative z-10 flex flex-col items-center">
                <div class="relative mb-8">
                    <div class="w-20 h-20 bg-primary/10 rounded-3xl rotate-12 group-hover/news:rotate-0 transition-all duration-700 flex items-center justify-center border border-primary/20 backdrop-blur-xl">
                        <i class="ri-mail-open-fill text-4xl text-primary drop-shadow-[0_0_15px_rgba(227,27,35,0.5)]"></i>
                    </div>
                    <div class="absolute -top-2 -right-2 bg-primary text-white text-[8px] font-black kufi px-2 py-1 rounded-full animate-bounce">NEW</div>
                </div>
                
                <h3 class="kufi font-black text-2xl md:text-3xl text-white mb-4 leading-tight tracking-tight">
                    <?php echo esc_html($title); ?>
                </h3>
                
                <p class="text-white/40 text-[11px] font-bold kufi leading-relaxed mb-10 max-w-[240px]">
                    <?php echo esc_html($desc); ?>
                </p>

                <form class="w-full space-y-4">
                    <div class="relative group/input">
                        <input type="email" 
                               placeholder="أدخل بريدك الإلكتروني..." 
                               class="w-full bg-white/5 border border-white/10 rounded-2xl py-5 px-6 kufi font-bold text-white text-sm placeholder:text-white/20 focus:border-primary/50 focus:bg-white/10 transition-all outline-none backdrop-blur-md" 
                               required>
                        <i class="ri-user-star-line absolute left-6 top-1/2 -translate-y-1/2 text-white/10 group-focus-within/input:text-primary transition-colors"></i>
                    </div>
                    
                    <button type="submit" class="w-full relative overflow-hidden bg-primary hover:bg-primary-dark py-5 rounded-2xl font-black kufi text-sm text-white transition-all duration-500 shadow-xl shadow-primary/20 hover:-translate-y-1 group/btn">
                        <span class="relative z-10 flex items-center justify-center gap-3">
                            تأكيد الاشتراك الآن
                            <i class="ri-flashlight-fill animate-pulse"></i>
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover/btn:translate-x-full transition-transform duration-1000"></div>
                    </button>
                </form>
                
                <div class="mt-8 flex items-center gap-2 opacity-30 select-none">
                    <span class="w-8 h-px bg-white/50"></span>
                    <span class="text-[8px] font-black kufi uppercase tracking-[0.4em] text-white">Privacy Guaranteed</span>
                    <span class="w-8 h-px bg-white/50"></span>
                </div>
            </div>
        </div>
        <?php
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : 'اشترك في النشرة';
        $desc = !empty($instance['desc']) ? $instance['desc'] : 'احصل على آخر الأخبار الرياضية مباشرة في بريدك الإلكتروني.';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">Title:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('desc')); ?>">Description:</label>
            <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('desc')); ?>" name="<?php echo esc_attr($this->get_field_name('desc')); ?>"><?php echo esc_textarea($desc); ?></textarea>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['desc'] = (!empty($new_instance['desc'])) ? strip_tags($new_instance['desc']) : '';
        return $instance;
    }
}

