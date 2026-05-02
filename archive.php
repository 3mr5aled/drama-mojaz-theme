<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Drama_Mojaz_Theme
 * 
 * Drama Mojaz Theme is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 */

get_header(); ?>
<?php 
// Only show archive header on search pages
if (is_search()) {
    get_template_part('template-parts/archive/header'); 
}
?>

<?php 
// Show category title and hero section on category pages
if (is_category()) {
    $current_cat = get_queried_object();
    ?>
    <section class="bg-gray-100 py-8 md:py-12">
        <div class="container mx-auto px-4">
            <h1 class="kufi text-2xl md:text-3xl lg:text-4xl font-black text-gray-800 text-right">
                <?php echo esc_html($current_cat->name); ?>
            </h1>
        </div>
    </section>
    <?php
    get_template_part('template-parts/home/section-hero'); 
}
?>
<?php
$archive_layout = sports_news_get_opt('archive_layout_design', 'design-1');
get_template_part('template-parts/archive/' . $archive_layout);
?>


<?php get_footer(); ?>
