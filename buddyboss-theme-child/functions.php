<?php
/**
 * @package BuddyBoss Child
 * The parent theme functions are located at /buddyboss-theme/inc/theme/functions.php
 * Add your own functions at the bottom of this file.
 */


/****************************** THEME SETUP ******************************/

/**
 * Sets up theme for translation
 *
 * @since BuddyBoss Child 1.0.0
 */
function buddyboss_theme_child_languages()
{
  /**
   * Makes child theme available for translation.
   * Translations can be added into the /languages/ directory.
   */

  // Translate text from the PARENT theme.
  load_theme_textdomain( 'buddyboss-theme', get_stylesheet_directory() . '/languages' );

  // Translate text from the CHILD theme only.
  // Change 'buddyboss-theme' instances in all child theme files to 'buddyboss-theme-child'.
  // load_theme_textdomain( 'buddyboss-theme-child', get_stylesheet_directory() . '/languages' );

}
add_action( 'after_setup_theme', 'buddyboss_theme_child_languages' );

/**
 * Enqueues scripts and styles for child theme front-end.
 *
 * @since Boss Child Theme  1.0.0
 */
function buddyboss_theme_child_scripts_styles()
{
  /**
   * Scripts and Styles loaded by the parent theme can be unloaded if needed
   * using wp_deregister_script or wp_deregister_style.
   *
   * See the WordPress Codex for more information about those functions:
   * http://codex.wordpress.org/Function_Reference/wp_deregister_script
   * http://codex.wordpress.org/Function_Reference/wp_deregister_style
   **/

  // Styles
  wp_enqueue_style( 'buddyboss-child-css', get_stylesheet_directory_uri().'/assets/css/custom.css', '', '1.0.0' );

  // Javascript
  wp_enqueue_script( 'buddyboss-child-js', get_stylesheet_directory_uri().'/assets/js/custom.js', '', '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'buddyboss_theme_child_scripts_styles', 9999 );





/****************************** CUSTOM FUNCTIONS ******************************/

// Add your own custom functions here

/**
 * When a user is logged in, tell WordPress to use 'page' on front page of the site
 * @param string $value
 *
 * @return string
 */
function buddydev_set_page_as_front_for_loggedin_user( $value ) {
	if ( is_user_logged_in() ) {
		$value = 'page';//page is set as front page
	}

	return $value;
}
add_filter( 'pre_option_show_on_front', 'buddydev_set_page_as_front_for_loggedin_user' );

/**
 * For logged in users, set our static page to act as home page
 *
 * @param $value
 *
 * @return int
 */
function buddydev_set_context_based_page_on_front( $value ) {

	if( ! is_user_logged_in() ) {
		return $value;
	}

	//for logged in user, use page id 9
	return 86362;//change with your own page id.
}

add_filter( 'pre_option_page_on_front', 'buddydev_set_context_based_page_on_front' );
/**
End custom theme home page for logged in members
 */




// Login Page Title, remove WP and add front page degault OG FB Share image

add_filter('login_title', 'custom_login_title', 99);
function custom_login_title($origtitle) { 
    return get_bloginfo('name');
}

add_filter('og_image_init', 'my_og_image_init');
function my_og_image_init($images)
{
    if ( is_front_page() || is_home() ) {
        $images[] = 'https://gilbert.myhuub.com/wp-content/uploads/2021/04/sample1-2.png';
    }
    return $images;
}




/**
 * Block wp-admin access for non-admins
 */
function ace_block_wp_admin() {
	if ( is_admin() && ! current_user_can( 'administrator' ) && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
		wp_safe_redirect( home_url() );
		exit;
	}
}
add_action( 'admin_init', 'ace_block_wp_admin' );


// User Session time

add_filter( 'auth_cookie_expiration', 'extend_login_session' );
function extend_login_session( $expire ) {
  return 2419200; // 4 Weeks
}

?>