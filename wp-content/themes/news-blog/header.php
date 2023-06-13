<?php
/**
* Theme Header
* This is the template that displays all of the <head> section and everything up until <div id="content">
* @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
* @package Best_Shop
* DOCTYPE hook 
* @hooked news_blog_doctype
*/
do_action( 'news_blog_doctype' );
?>
<head itemscope itemtype="https://schema.org/WebSite">
<?php 
    /**
     * Before wp_head
     * 
     * @hooked news_blog_head
    */
    do_action( 'news_blog_before_wp_head' );
	wp_head(); 
    ?>
</head>

<body <?php body_class(); ?> itemscope itemtype="https://schema.org/WebPage">
    
<?php wp_body_open();
    /**
     * Before Header
     * 
     * @hooked news_blog_page_start 
    */
    do_action( 'news_blog_before_header' );

	/**
	 * Header
	 */
    
    
    
    $news_blog_header_layout = news_blog_get_header_style();
            
    //if header layout is customizer or empty, get customizer setting
    if ($news_blog_header_layout === 'customizer-setting' || $news_blog_header_layout === '' ) {
        $news_blog_header_layout = news_blog_get_setting('header_layout');
    }
        
    //if woocommerce not installed, set layout to default
    if (!class_exists('WooCommerce') && $news_blog_header_layout === 'woocommerce-bar' ) {
        $news_blog_header_layout = 'default';
    }
    
    ?>
    
		<header id="masthead" class="site-header style-one 
        <?php if ($news_blog_header_layout==='transparent-header') { 
            echo esc_attr($news_blog_header_layout); 
        } if($news_blog_header_layout==='woocommerce-bar'){
            echo esc_attr(" header-no-border "); 
        }
        if ($news_blog_header_layout==='woocommerce-bar'){
            echo esc_attr(' hide-menu-cart ');
        }
                                     
        ?>"
        itemscope itemtype="https://schema.org/WPHeader">
            
            <?php if(news_blog_get_setting('enable_top_bar')): ?>
            
            <div class="top-bar-menu">
                <div class="container">
                    <div class="left-menu">
                                    
                    <?php                        
                        
                        if(news_blog_get_setting('top_bar_left_content') === 'menu') {
                            
                            wp_nav_menu( array( 'container_class' => 'top-bar-menu', 
                                                'theme_location'  =>  'top-bar-left-menu', 
                                                'depth' =>  1,
                                            ) );
                            
                        } elseif(news_blog_get_setting('top_bar_left_content') === 'contacts'){
                        ?><ul>
                        <?php if (news_blog_get_setting('phone_number')!=''): ?>
                        <li><?php echo esc_html(news_blog_get_setting('phone_title')).esc_html(news_blog_get_setting('phone_number')) ; ?></li>
                        <?php endif; ?>  
                        
                        <?php if (news_blog_get_setting('address')!=''): ?>
                        <li><?php echo esc_html(news_blog_get_setting('address_title')).esc_html(news_blog_get_setting('address')) ; ?></li>
                        <?php endif; ?> 
                        
                        <?php if (news_blog_get_setting('mail_description')!=''): ?>
                        <li><?php echo esc_html(news_blog_get_setting('mail_title')).esc_html(news_blog_get_setting('mail_description')) ; ?></li>
                        <?php endif; ?>   
                        
                        </ul><?php
                        } elseif(news_blog_get_setting('top_bar_left_content') === 'text')  {
                            ?><ul><li><?php echo esc_html((news_blog_get_setting('top_bar_left_text')) ); ?></li></ul><?php    
                        } elseif(news_blog_get_setting('top_bar_left_content') === 'datetime')  {
                        ?>
                          <span class="header-date-time">
                          <li><span class="header-date"><?php
                              echo esc_html(date_i18n('D. M jS, Y ', strtotime(current_time("Y-m-d"))) );
                          ?>
                          </span>
                          <span id="time" class="time"></span>
                          </li>
                          </span>                         
                        <?php
                        }
                        ?>
                        
                    </div>
                    
                    <div class="right-menu">
                    <?php
                     if(news_blog_get_setting('top_bar_right_content') === 'menu') {
                      wp_nav_menu( array( 'container_class' => 'top-bar-menu', 
                                        'theme_location' =>  'top-bar-right-menu', 
                                        'depth' =>  1,
                                      ) );                         
                     } elseif(news_blog_get_setting('top_bar_right_content') === 'social'){
                         
                         news_blog_social_links( true );
                         
                     } elseif(news_blog_get_setting('top_bar_right_content') === 'menu_social'){
                         
                       wp_nav_menu( array( 'container_class' => 'top-bar-menu', 
                                        'theme_location' =>  'top-bar-right-menu', 
                                        'depth' =>  1,
                                      ) );
                         
                        news_blog_social_links( true );
                         
                     } 

                    ?>
                    </div>
                    
                </div>
            </div>
            
            <?php endif; /* end top bar*/ ?> 
                         
			<div class=" <?php if(news_blog_get_setting('menu_layout') === 'default' ) { echo 'main-menu-wrap'; } else { echo 'burger-banner'; } ?> ">
                <div class="container">
				<div class="header-wrapper">
					<?php 
					/**
					 * Site Branding 
					*/
					news_blog_site_branding();           
					?>
					<div class="nav-wrap">
                        <?php if(news_blog_get_setting('menu_layout') === 'default' ) { ?>
						<div class="header-left">
							<?php 
							/**
							 * Primary navigation 
							*/
							news_blog_primary_navigation(); 
							?>
						</div>
						<div class="header-right">
							<?php
							/**
							 * Header Search 
							*/ 
							news_blog_header_search();
							?>
						</div>
                        <?php } else { ?>
                        <div class="banner header-right">
                            <?php the_widget( 'WP_Widget_Media_Image', 'url='.news_blog_get_setting('header_banner_img')); ?>
                        </div>
                        <?php } ?>
                        
					</div><!-- #site-navigation -->
				</div>
                </div>
			</div>
            
            <?php
            if(news_blog_get_setting('menu_layout') === 'full_width' ) {
            ?>
            
            <!--Burger header-->
            <div class="burger main-menu-wrap">
            <div class="container">
            <div class="header-wrapper">
            <div class="nav-wrap">
                <div class="header-left">
                    <div class="vertical-center menu-home-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 6.453l9 8.375v9.172h-6v-6h-6v6h-6v-9.172l9-8.375zm12 5.695l-12-11.148-12 11.133 1.361 1.465 10.639-9.868 10.639 9.883 1.361-1.465z"/></svg>
                    <span><?php esc_html_e('Home','news-blog'); ?></span>
                    </div>
                    <?php 
                    /**
                     * Primary navigation 
                    */
                    news_blog_primary_navigation(); 
                    ?>
                </div>
                <div class="header-right">
                    <?php
                    /**
                     * Header Search 
                    */ 
                    news_blog_header_search();
                    ?>
                </div>
            </div>
            </div>
            </div>
            </div>
            <!-- #site-navigation -->            
            
			<?php
            }
                
			/**
			 * Mobile navigation
			 */
			news_blog_mobile_navigation(); 
			

        if (class_exists('WooCommerce') && $news_blog_header_layout === 'woocommerce-bar') { 
        ?>
            <div class="woocommerce-bar">
            <nav>
            <div class="container"> 
            <?php
                news_blog_product_category_list();      
                news_blog_product_search();
                news_blog_cart_wishlist_myacc();    
            ?>           
            </div>
            </nav> 
            </div>
        <?php 

        }
            
        ?>
            
		</header><!-- #masthead -->
    

     <?php
    
    /**
	 * * @hooked news_blog_primary_page_header - 10
	*/
	do_action( 'news_blog_before_posts_content' );
    
    
    