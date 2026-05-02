<?php
/**
 * Unified Sidebar Template - Ultimate Premium Design (Widgetized)
 */
?>
<?php if (sports_news_get_opt('show_sidebar', true)) : ?>
<aside class="space-y-10 md:space-y-14 animate-fade-left">

    <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
        <div class="dynamic-sidebar-widgets space-y-12">
            <?php dynamic_sidebar( 'sidebar-1' ); ?>
        </div>
    <?php endif; ?>

</aside>
<?php endif; ?>
