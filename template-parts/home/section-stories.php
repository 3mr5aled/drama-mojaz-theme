<?php
/**
 * Template part for the Stories section on the homepage
 */

if ((is_front_page() || is_home() || defined('DM_SHORTCODE')) && sports_news_get_opt('show_stories', true)) :
     get_template_part('inc/stories');
endif;
