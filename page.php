<?php
/**
 * The template for displaying all pages
 */

get_header(); ?>

<?php get_template_part('template-parts/page/common-styles'); ?>

<?php
if (have_posts()) : 
    while (have_posts()) : the_post();
        $page_layout = sports_news_get_opt('page_layout_design', 'design-1');
        if (!$page_layout) $page_layout = 'design-1';
        
        get_template_part('template-parts/page/' . $page_layout);
    endwhile;
endif;
?>

<?php get_footer(); ?>
