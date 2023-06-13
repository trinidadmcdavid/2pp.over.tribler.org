<?php 
/**
 * Woocommerce hooks and functions
 * 
 * @link https://docs.woothemes.com/document/third-party-custom-theme-compatibility/
 *
 * @package Best_Shop
 */

 /**
 * Woocommerce related hooks
*/
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_sidebar',             'woocommerce_get_sidebar', 10 );
add_filter( 'woocommerce_show_page_title' ,     '__return_false' );

/**
 * Declare Woocommerce Support
*/
function news_blog_woocommerce_support() {
    global $woocommerce;
    
    add_theme_support( 'woocommerce' );
    
    if( version_compare( $woocommerce->version, '3.0', ">=" ) ) {
        add_theme_support( 'wc-product-gallery-zoom' );
        add_theme_support( 'wc-product-gallery-lightbox' );
        add_theme_support( 'wc-product-gallery-slider' );
    }
}
add_action( 'after_setup_theme', 'news_blog_woocommerce_support');

/**
 * Before Content
 * Wraps all WooCommerce content in wrappers which match the theme markup
*/
function news_blog_wc_wrapper(){    
    ?>
    <div id="primary" class="content-area">
        <div class="container">
            <div class="page-grid">
                <div id="main" class="site-main">
    <?php
}
add_action( 'woocommerce_before_main_content', 'news_blog_wc_wrapper' );

/**
 * After Content
 * Closes the wrapping divs
*/
function news_blog_wc_wrapper_end(){ ?>
                </div>
            </div>
        </div>
    </div>
    <?php 
}
add_action( 'woocommerce_after_main_content', 'news_blog_wc_wrapper_end' );


if (!function_exists('news_blog_cart_link')) {

    function news_blog_cart_link() {
        ?>	
        <a class="cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" data-tooltip="<?php esc_attr_e('Cart', 'news-blog'); ?>" title="<?php esc_attr_e('Cart', 'news-blog'); ?>">
            <?php echo news_blog_social_icons_svg_list( 'cart' ); ?><span class="count"><?php if(WC()->cart) { echo wp_kses_data(WC()->cart->get_cart_contents_count()); } ?></span></i>
            <div class="amount-cart"><?php if(WC()->cart) { echo wp_kses_data(WC()->cart->get_cart_subtotal()); }; ?></div> 
        </a>
        <?php
    }

}

if (!function_exists('news_blog_header_add_to_cart_fragment')) {
    add_filter('woocommerce_add_to_cart_fragments', 'news_blog_header_add_to_cart_fragment');

    function news_blog_header_add_to_cart_fragment($fragments) {
        ob_start();

        news_blog_cart_link();

        $fragments['a.cart-contents'] = ob_get_clean();

        return $fragments;
    }

}


function news_blog_cart_wishlist_myacc(){
    
        ?>
        <div class="header-woo-icon-container">
        <?php

        if (class_exists('WooCommerce')) {
        ?>		
        <div class="woocommerce-bar-icons">
            <div class="header-my-account">
                <div class="header-login"> 
                    <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" data-tooltip="<?php esc_attr_e('My Account', 'news-blog'); ?>" title="<?php esc_attr_e('My Account', 'news-blog'); ?>">
                        <?php echo news_blog_social_icons_svg_list( 'my-account' ); ?>
                    </a>
                </div>
            </div>
        </div>
        <?php } // end my account



        if (function_exists('YITH_WCWL')) {
            $wishlist_url = YITH_WCWL()->get_wishlist_url();
        ?>
        <div class="woocommerce-bar-icons">
            <div class="header-wishlist">
                <a href="<?php echo esc_url($wishlist_url); ?>" data-tooltip="<?php esc_attr_e('Wishlist', 'news-blog'); ?>" title="<?php esc_attr_e('Wishlist', 'news-blog'); ?>">
                    <?php echo news_blog_social_icons_svg_list( 'wishlist' ); ?>
                </a>
            </div>
        </div>
        <?php
        } //wishlist


        if (function_exists('yith_woocompare_constructor') ) {
            global $yith_woocompare;
            ?>
            <div class="woocommerce-bar-icons">
                <div class="header-compare product">
                    <a class="compare added" rel="nofollow" href="<?php if(!empty($yith_woocompare->obj) && method_exists($yith_woocompare->obj, 'view_table_url')) { echo esc_url($yith_woocompare->obj->view_table_url()); } ?>" data-tooltip="<?php esc_attr_e('Compare', 'news-blog'); ?>" title="<?php esc_attr_e('Compare', 'news-blog'); ?>">
                        <?php echo news_blog_social_icons_svg_list( 'sync' ); ?>
                    </a>
                </div>
            </div>
            <?php
        } //end compare


        if (class_exists('WooCommerce')) {
        ?>	
        <div class="woocommerce-bar-icons">
            <div class="header-cart">
                <div class="header-cart-block">
                    <div class="header-cart-inner">                       

                        <?php news_blog_cart_link(); ?>

                        <ul class="site-header-cart menu list-unstyled text-center">
                            <li>
                                <?php the_widget('WC_Widget_Cart', 'title='); ?>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    <?php } //end cart ?>

    </div> <!-- end woo icon-container -->

<?php
}

function news_blog_product_search(){

    ?>
      <div class="product-search-form">
          <form method="get" action="<?php echo esc_url(home_url('/')); ?>">
              <input type="hidden" name="post_type" value="product" />
              <input class="header-search-input" name="s" type="text" placeholder="<?php esc_attr_e('Search products...', 'news-blog'); ?>"/>
              <select class="header-search-select" name="product_cat">
                  <option value=""><?php esc_html_e('All Categories', 'news-blog'); ?></option> 
                  <?php
                  $categories = get_categories('taxonomy=product_cat');
                  foreach ($categories as $category) {
                      $option = '<option value="' . esc_attr($category->category_nicename) . '">';
                      $option .= esc_html($category->cat_name);
                      $option .= ' <span>(' . absint($category->category_count) . ')</span>';
                      $option .= '</option>';
                      echo $option; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                  }
                  ?>
              </select>
              <button class="header-search-button" type="submit"><?php echo news_blog_social_icons_svg_list( 'search' ); ?></button>
          </form>
      </div>
    <?php
    
}


function news_blog_product_category_list (){
    ?>
      <div class="produt-category-navigation">                
          <ul class="categories-menu">
                <li class="categories-menu-item">
                    <a class="categories-menu-first" href="#">                        
                        <?php 
                                  echo news_blog_social_icons_svg_list( 'list' );
                                    
                                  echo esc_html(news_blog_get_setting('woo_category_title')); 
                        ?>
                    </a>
                    <ul class="categories-dropdown-menu dropdown-menu">
                        <?php
                        $categories = get_categories('taxonomy=product_cat');
                        foreach ($categories as $category) {
                              $category_link = '#';
                              if (isset($category->cat_ID)) {
                                $category_link = get_category_link($category->cat_ID);
                              }
                              if (isset($category->category_nicename)) {
                                $option = '<li class="menu-item ' . esc_attr($category->category_nicename) . '">';
                              }
                              if (isset($category_link)) {
                                $option .= '<a href="' . esc_url($category_link) . '" class="nav-link">';
                              }
                              if (isset($category->cat_name)) {
                                $option .= esc_html($category->cat_name);
                              }
                              $option .= '</a>';
                              $option .= '</li>';
                              echo $option; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

                        }
                        ?>
                    </ul>
                </li>
              </ul> 
          </div>
<?php
}


