<?php
/**
 * The template for displaying search forms
 */
?>

<form role="search" method="get" class="search-form relative group" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div class="relative flex items-center">
        <!-- Icon -->
        <div class="absolute right-4 text-gray-400 group-focus-within:text-primary transition-colors duration-300">
            <i class="ri-search-2-line text-lg"></i>
        </div>
        
        <!-- Input Field -->
        <input type="search" 
               class="search-field w-full bg-gray-50 border-2 border-transparent focus:border-primary/20 focus:bg-white rounded-2xl py-4 pr-12 pl-4 text-sm font-bold kufi text-secondary placeholder-gray-400 outline-none transition-all duration-300 shadow-sm focus:shadow-xl focus:shadow-primary/5" 
               placeholder="<?php echo esc_attr_x( 'ابحث عن الأخبار أو المباريات...', 'placeholder', 'drama-mojaz-theme' ); ?>" 
               value="<?php echo get_search_query(); ?>" 
               name="s" />

        <!-- Submit Button (Hidden but functional for accessibility/enter key) -->
        <button type="submit" class="hidden"><?php echo esc_html_x( 'بحث', 'submit button', 'drama-mojaz-theme' ); ?></button>
    </div>
</form>
