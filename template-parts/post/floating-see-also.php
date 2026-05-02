<?php
/**
 * Floating See Also widget (single posts only)
 */

if (!is_single()) {
    return;
}

$current_post_id = (int) get_queried_object_id();
if ($current_post_id <= 0 || get_post_type($current_post_id) !== 'post') {
    return;
}

$floating_see_also_args = array(
    'post_type'           => 'post',
    'post_status'         => 'publish',
    'posts_per_page'      => 1,
    'ignore_sticky_posts' => true,
    'post__not_in'        => array($current_post_id),
    'fields'              => 'ids',
    'no_found_rows'       => true,
);

$floating_categories = get_the_category($current_post_id);
if (!empty($floating_categories)) {
    $floating_see_also_args['category__in'] = wp_list_pluck($floating_categories, 'term_id');
}

$floating_see_also_ids = get_posts($floating_see_also_args);

// Fallback: if no post in same category, fetch latest post.
if (empty($floating_see_also_ids)) {
    unset($floating_see_also_args['category__in']);
    $floating_see_also_ids = get_posts($floating_see_also_args);
}

if (empty($floating_see_also_ids)) {
    return;
}

$floating_post_id = (int) $floating_see_also_ids[0];
if ($floating_post_id <= 0 || $floating_post_id === $current_post_id) {
    return;
}
$floating_see_also_post_categories = get_the_category($floating_post_id);
$floating_permalink = get_permalink($floating_post_id);
$floating_title = get_the_title($floating_post_id);
$floating_date = get_the_date('j F, Y', $floating_post_id);
?>
<aside id="floatingSeeAlso" class="floating-see-also" aria-label="<?php esc_attr_e('See also', 'drama-mojaz-theme'); ?>">
    <div class="floating-see-also__head">
        <button id="floatingSeeAlsoClose" class="floating-see-also__close" type="button" aria-label="<?php esc_attr_e('Close', 'drama-mojaz-theme'); ?>">&times;</button>
        <h3 class="kufi floating-see-also__title">شاهد أيضًا</h3>
    </div>

    <article class="floating-see-also__card">
        <a href="<?php echo esc_url($floating_permalink); ?>" class="floating-see-also__thumb-link" aria-label="<?php echo esc_attr($floating_title); ?>">
            <?php if (has_post_thumbnail($floating_post_id)) : ?>
                <?php echo get_the_post_thumbnail($floating_post_id, 'medium', array('class' => 'floating-see-also__thumb')); ?>
            <?php else : ?>
                <div class="floating-see-also__thumb floating-see-also__thumb--placeholder"></div>
            <?php endif; ?>
            <span class="floating-see-also__stars" aria-hidden="true">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
            <?php if (!empty($floating_see_also_post_categories)) : ?>
                <span class="floating-see-also__badge kufi"><?php echo esc_html($floating_see_also_post_categories[0]->name); ?></span>
            <?php endif; ?>
        </a>

        <h4 class="kufi floating-see-also__post-title">
            <a href="<?php echo esc_url($floating_permalink); ?>"><?php echo esc_html($floating_title); ?></a>
        </h4>

        <div class="floating-see-also__meta">
            <i class="ri-time-line" aria-hidden="true"></i>
            <span><?php echo esc_html($floating_date); ?></span>
        </div>
    </article>
</aside>
