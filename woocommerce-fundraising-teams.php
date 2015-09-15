<?php
/**
 * Plugin Name: WooCommerce Fundraising Teams
 * Plugin URI: http://themichaelvieth.com
 * Description: Create and manage teams and team fundraising through Woocommerce.
 * Version: 1.0
 * Author: Michael Vieth
 * Author URI: http://themichaelvieth.com
 * License: GPL2
 */

// include 'admin-functions.php';

defined('ABSPATH') or die("No script kiddies please!");

/*************************
 ******** INSTALL ********
 *************************/

// Check WooCommerce Dependencies
if ( ! class_exists( 'WC_CPInstallCheck' ) ) {
  class WC_CPInstallCheck {
		static function install() {
			if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
				// Deactivate the plugin
				deactivate_plugins(__FILE__);
				$error_message = __('This plugin requires <a href="https://wordpress.org/plugins/woocommerce/" target="_blank">WooCommerce</a> plugin to be active! Please click the link above ot download', 'woocommerce');
				die($error_message);
			}
		}
	}
}
register_activation_hook( __FILE__, array('WC_CPInstallCheck', 'install') );



// Register Admin Styles
if ( is_admin() ){ 
	add_action( 'wp_enqueue_scripts', 'register_admin_styles' );
	add_action( 'admin_menu', 'register_admin_menu' );
	add_action('admin_menu', 'register_submenu_page');

}





/*************************
 ******** STYLES *********
 *************************/

// Stylesheets
function register_admin_styles() {
	wp_register_style( 'woocommerce-fundraising-teams', plugins_url( 'woocommerce-fundraising-teams/styles.css' ) );
	wp_enqueue_style( 'woocommerce-fundraising-teams' );
}





/*************************
 ********* MENUS *********
 *************************/

function register_admin_menu() {
	
	$page_title	= 'Teams';
	$menu_title	= 'Teams';
	$capability	= 'manage_options';
	$menu_slug	= 'woocommerce-fundraising-teams/woocommerce-fundraising-teams-admin.php';
	$function	= '';
	$icon_url	= plugins_url( 'woocommerce-fundraising-teams/img/dash.png' );
	$position	= 6;

	add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
}


function register_submenu_page() {
	
	$parent_slug = 'woocommerce-fundraising-teams/woocommerce-fundraising-teams-admin.php';
	$page_title = 'All Teams';
	$menu_title = 'All Teams';
	$capability = 'manage_options';
	$menu 		= 'my-custom-submenu-page';
	$function 	= 'submenu_page_func';

	add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
}

function submenu_page_func() {
	
	echo '<div class="wrap"><div id="icon-tools" class="icon32"></div>';
		echo '<h2>My Custom Submenu Page</h2>';
	echo '</div>';

}






