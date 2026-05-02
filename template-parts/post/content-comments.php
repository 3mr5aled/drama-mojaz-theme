<!-- Comments Section -->
<?php if (sports_news_get_opt('enable_comments', true)) : ?>
<div class="mt-20 pt-10 border-t border-gray-100">
    <?php
    if (comments_open() || get_comments_number()) :
        comments_template();
    endif;
    ?>
</div>
<?php endif; ?>
