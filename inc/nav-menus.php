<?php
/**
 * Menu Icons Management
 * Adds icon support to WordPress navigation menus
 *
 * @package Drama_Mojaz_Theme
 */

if (!defined('ABSPATH')) exit;

/**
 * Add menu icon fields to menu item settings
 */
function sports_news_add_menu_icon_field($item_id, $item, $depth, $args) {
    // Get saved icon
    $icon_class = get_post_meta($item_id, '_menu_item_icon', true);
    $icon_image = get_post_meta($item_id, '_menu_item_icon_image', true);
    ?>
    <div class="field-icon-wrapper" style="background: #f0f6fc; padding: 12px; margin-top: 12px; border-radius: 8px;">
        <h4 style="margin: 0 0 12px 0; font-size: 13px; color: #1d2327;"><?php _e('إعدادات الأيقونة', 'drama-mojaz-theme'); ?></h4>
        
        <!-- Remix Icon Field -->
        <p class="field-icon description description-wide" style="margin: 0 0 10px 0;">
            <label for="edit-menu-item-icon-<?php echo $item_id; ?>">
                <?php _e('أيقونة Remix Icon', 'drama-mojaz-theme'); ?><br />
                <input type="text" 
                       id="edit-menu-item-icon-<?php echo $item_id; ?>" 
                       class="widefat code edit-menu-item-icon" 
                       name="menu-item-icon[<?php echo $item_id; ?>]" 
                       value="<?php echo esc_attr($icon_class); ?>" 
                       placeholder="ri-home-line" />
                <span class="description">
                    <?php _e('أدخل اسم أيقونة (مثال: ri-home-line)', 'drama-mojaz-theme'); ?>
                    <a href="https://remixicon.com/" target="_blank" style="color: #2271b1;">
                        <?php _e('عرض جميع الأيقونات', 'drama-mojaz-theme'); ?>
                    </a>
                </span>
            </label>
        </p>
        
        <!-- Icon Image Field -->
        <p class="field-icon-image description description-wide" style="margin: 0;">
            <label for="edit-menu-item-icon-image-<?php echo $item_id; ?>">
                <?php _e('أو ارفع صورة أيقونة', 'drama-mojaz-theme'); ?><br />
                <input type="hidden" 
                       id="edit-menu-item-icon-image-<?php echo $item_id; ?>" 
                       class="widefat edit-menu-item-icon-image" 
                       name="menu-item-icon-image[<?php echo $item_id; ?>]" 
                       value="<?php echo esc_attr($icon_image); ?>" />
                
                <div class="icon-image-preview-wrapper" style="margin-top: 8px;">
                    <?php if ($icon_image) : ?>
                        <img src="<?php echo esc_url($icon_image); ?>" class="icon-image-preview" style="max-width: 50px; max-height: 50px; margin-bottom: 8px; border: 1px solid #ddd; padding: 2px;">
                    <?php endif; ?>
                </div>
                
                <button type="button" class="button upload-icon-image-btn" data-item-id="<?php echo $item_id; ?>">
                    <?php _e('اختر صورة', 'drama-mojaz-theme'); ?>
                </button>
                <button type="button" class="button remove-icon-image-btn" data-item-id="<?php echo $item_id; ?>" style="margin-right: 5px; <?php echo $icon_image ? '' : 'display: none;'; ?>">
                    <?php _e('إزالة الصورة', 'drama-mojaz-theme'); ?>
                </button>
                
                <span class="description" style="display: block; margin-top: 5px;">
                    <?php _e('يفضل استخدام صورة بخلفية شفافة (PNG, SVG)', 'drama-mojaz-theme'); ?>
                </span>
            </label>
        </p>
    </div>
    <?php
}
add_action('wp_nav_menu_item_custom_fields', 'sports_news_add_menu_icon_field', 10, 4);

/**
 * Save menu icon fields
 */
function sports_news_save_menu_icon_field($menu_id, $menu_item_db_id) {
    // Save Remix Icon
    if (isset($_POST['menu-item-icon'][$menu_item_db_id])) {
        $icon_class = sanitize_text_field($_POST['menu-item-icon'][$menu_item_db_id]);
        update_post_meta($menu_item_db_id, '_menu_item_icon', $icon_class);
    }
    
    // Save Icon Image
    if (isset($_POST['menu-item-icon-image'][$menu_item_db_id])) {
        $icon_image = esc_url_raw($_POST['menu-item-icon-image'][$menu_item_db_id]);
        update_post_meta($menu_item_db_id, '_menu_item_icon_image', $icon_image);
    }
}
add_action('wp_update_nav_menu_item', 'sports_news_save_menu_icon_field', 10, 2);

/**
 * Add icon to menu item output
 * DISABLED - Menu icons removed from frontend
 */
// function sports_news_add_icon_to_menu_item($item_output, $item, $depth, $args) {
//     // Get icon data
//     $icon_class = get_post_meta($item->ID, '_menu_item_icon', true);
//     $icon_image = get_post_meta($item->ID, '_menu_item_icon_image', true);
//     
//     $icon_html = '';
//     
//     // Priority: Image icon > Remix Icon
//     if (!empty($icon_image)) {
//         // Use image icon
//         $icon_html = '<img src="' . esc_url($icon_image) . '" class="menu-item-icon-img" alt="" style="width: 18px; height: 18px; margin-left: 6px; vertical-align: middle; object-fit: contain;"> ';
//     } elseif (!empty($icon_class)) {
//         // Use Remix Icon
//         $icon_html = '<i class="' . esc_attr($icon_class) . ' menu-item-icon"></i> ';
//     }
//     
//     // If icon is set, add it to the output
//     if (!empty($icon_html)) {
//         $item_output = preg_replace('/(<a[^>]*>)/', '$1' . $icon_html, $item_output);
//     }
//     
//     return $item_output;
// }
// add_filter('walker_nav_menu_start_el', 'sports_news_add_icon_to_menu_item', 10, 4);

/**
 * Add menu icon column to menu items list
 */
function sports_news_add_menu_icon_column($columns) {
    $columns['menu_icon'] = __('الأيقونة', 'drama-mojaz-theme');
    return $columns;
}
add_filter('manage_nav-menus_columns', 'sports_news_add_menu_icon_column', 99);

/**
 * Display icon in menu items list
 */
function sports_news_display_menu_icon_column($output, $item_id, $item) {
    $icon_class = get_post_meta($item_id, '_menu_item_icon', true);
    $icon_image = get_post_meta($item_id, '_menu_item_icon_image', true);
    
    if (!empty($icon_image)) {
        // Show image icon
        $output .= '<span class="menu-icon-preview"><img src="' . esc_url($icon_image) . '" style="width: 24px; height: 24px; object-fit: contain; vertical-align: middle;"></span>';
    } elseif (!empty($icon_class)) {
        // Show Remix Icon
        $output .= '<span class="menu-icon-preview" style="font-size: 20px; color: #666;"><i class="' . esc_attr($icon_class) . '"></i></span>';
    } else {
        $output .= '<span class="menu-icon-preview" style="color: #999; font-style: italic;">-</span>';
    }
    return $output;
}
add_filter('manage_nav-menus_custom_column', 'sports_news_display_menu_icon_column', 10, 3);

/**
 * Add CSS for menu icons in admin
 */
function sports_news_menu_icons_admin_css() {
    $screen = get_current_screen();
    if ($screen && $screen->base === 'nav-menus') {
        ?>
        <style>
            .field-icon-wrapper {
                margin-top: 12px !important;
                border-radius: 8px;
                border: 1px solid #c5d9ed;
            }
            .field-icon {
                margin: 0 0 10px 0 !important;
            }
            .field-icon label {
                font-weight: 500;
            }
            .field-icon input {
                margin-top: 5px;
                direction: ltr;
            }
            .field-icon .description {
                font-size: 12px;
                color: #666;
                margin-top: 5px;
                display: block;
            }
            .icon-image-preview-wrapper img {
                border: 2px solid #ddd;
                padding: 4px;
                background: #fff;
                border-radius: 4px;
            }
            .menu-icon-preview {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 30px;
                height: 30px;
            }
            .menu-item-icon {
                margin-left: 6px;
                vertical-align: middle;
            }
        </style>
        <?php
    }
}
add_action('admin_head', 'sports_news_menu_icons_admin_css');

/**
 * Add media uploader script
 */
function sports_news_menu_icons_admin_script($hook) {
    if ($hook !== 'nav-menus.php') return;
    
    // Enqueue WordPress media uploader
    wp_enqueue_media();
    ?>
    <script>
    jQuery(document).ready(function($) {
        var mediaUploader;
        
        // Upload icon image
        $(document).on('click', '.upload-icon-image-btn', function(e) {
            e.preventDefault();
            var itemId = $(this).data('item-id');
            var $button = $(this);
            var $wrapper = $button.closest('.field-icon-image');
            var $previewWrapper = $wrapper.find('.icon-image-preview-wrapper');
            var $input = $wrapper.find('.edit-menu-item-icon-image');
            var $removeBtn = $wrapper.find('.remove-icon-image-btn');
            
            // If media uploader exists, open it
            if (mediaUploader) {
                mediaUploader.open();
                return;
            }
            
            // Create media uploader
            mediaUploader = wp.media({
                title: '<?php _e("اختر صورة الأيقونة", "drama-mojaz-theme"); ?>',
                button: {
                    text: '<?php _e("استخدام هذه الصورة", "drama-mojaz-theme"); ?>'
                },
                multiple: false,
                library: {
                    type: ['image']
                }
            });
            
            // When image selected
            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                var imageUrl = attachment.url;
                
                // Update input
                $input.val(imageUrl);
                
                // Update preview
                $previewWrapper.html('<img src="' + imageUrl + '" class="icon-image-preview" style="max-width: 50px; max-height: 50px; margin-bottom: 8px; border: 1px solid #ddd; padding: 2px;">');
                
                // Show remove button
                $removeBtn.show();
            });
            
            mediaUploader.open();
        });
        
        // Remove icon image
        $(document).on('click', '.remove-icon-image-btn', function(e) {
            e.preventDefault();
            var $button = $(this);
            var $wrapper = $button.closest('.field-icon-image');
            var $previewWrapper = $wrapper.find('.icon-image-preview-wrapper');
            var $input = $wrapper.find('.edit-menu-item-icon-image');
            
            // Clear input
            $input.val('');
            
            // Remove preview
            $previewWrapper.empty();
            
            // Hide remove button
            $button.hide();
        });
        
        // Add icon preview on input
        $(document).on('input', '.edit-menu-item-icon', function() {
            const $input = $(this);
            const iconClass = $input.val().trim();
            let $preview = $input.siblings('.icon-preview');
            
            if (!$preview.length) {
                $preview = $('<span class="icon-preview" style="display: inline-block; margin-right: 10px; font-size: 20px; vertical-align: middle; color: #666;"></span>');
                $input.before($preview);
            }
            
            if (iconClass) {
                $preview.html('<i class="' + iconClass + '"></i>');
            } else {
                $preview.empty();
            }
        });
        
        // Trigger preview on page load
        $('.edit-menu-item-icon').trigger('input');
    });
    </script>
    <?php
}
add_action('admin_footer', 'sports_news_menu_icons_admin_script');
