<?php
/**
 * Plugin Name: WooCommerce Team Fundraiser
 * Plugin URI: http://themichaelvieth.com
 * Description: Create and manage teams and team fundraising through Woocommerce.
 * Version: 1.0
 * Author: Rob Korobkin
 * Author URI: http://themichaelvieth.com
 * License: GPL2
 */

defined('ABSPATH') or die("No script kiddies please!");


// admin stuff
if ( is_admin() ){ // admin actions
	add_action( 'admin_menu', 'woo_teams_admin_menu' );
	add_action( 'admin_init', 'register_wtsettings' );
}


// Stylesheets
add_action( 'wp_enqueue_scripts', 'register_wcft_styles' );
function register_wcft_styles() {
	wp_register_style( 'woocommerce-teams', plugins_url( 'woocommerce-teams/styles.css' ) );
	wp_enqueue_style( 'woocommerce-teams' );
}


// create custom admin menu item
function woo_teams_admin_menu(){

	//create new top-level menu
	add_submenu_page('woocommerce', 'Woo Team Fundraiser', 'Woo Team Fundraiser', 'administrator', __FILE__, 'woo_fundraising_teams_admin_page');

	//call register settings function
	add_action( 'admin_init', 'register_wtSettings' );

}

function woo_fundraising_teams_admin_page(){

	global $wooTeamFundraiserFields;

	foreach($wooTeamFundraiserFields as $f){
		$pluginState[$f] = esc_attr( get_option($f) );
	}
	

	echo 	'	<style type="text/css">
					#wooteams-adminform 			{ }
					#wooteams-adminform td 			{ padding-bottom: 10px; vertical-align: top; padding-right: 10px; }
					#wooteams-adminform .tInput 	{ width: 300px; }
					#wooteams-adminform textarea 	{ height: 100px; width: 300px; }
				</style>
	
				<form style="padding: 30px;" id="wooteams-adminform" method="post" action="options.php">';
				
	settings_fields( 'wooteams-settings-group' );
	do_settings_sections( 'wooteams-settings-group' );	
			
	$checked = ($pluginState['wcft-allowUserSubmittedTeamFundraiser'] == "on") ? "checked" : "";
	$requireChecked = ($pluginState['wcft-requireTeamSelection'] == "on") ? "checked" : "";
				
	echo			'<h2>Woocommerce Team Settings</h2>
					<table>
						<tr>
							<td><label for="allowUserSubmitted">Allow User Submitted TeamFundraiser</label></td>
							<td><input type="checkbox" name="wcft-allowUserSubmittedTeamFundraiser" id="allowUserSubmitted" ' . $checked  . ' /></td>
						</tr>
						<tr>
							<td><label for="requireTeamSelection">Require Team Selection</label></td>
							<td><input type="checkbox" name="wcft-requireTeamSelection" 
								id="requireTeamSelection" ' . $requireChecked  . ' />
							</td>
						</tr>
						<tr>
							<td><label for="barGraphColor">Bar Graph Color (hex)</label></td>						
							<td><input type="text" name="wcft-barGraphColor" id="barGraphColor" class="tInput" 
										value="' . $pluginState['wcft-barGraphColor'] . '"
										placeholder="#00ff00" /></td>
						</tr>
						<tr>
							<td><label for="barGraphScale">Bar Graph Scale ($/px)</label></td>						
							<td><input type="text" name="wcft-barGraphScale" id="barGraphScale" class="tInput" 
										value="' . $pluginState['wcft-barGraphScale'] . '"
										placeholder="10"/></td>
						</tr>
						<tr>
							<td><label for="teamList">TeamFundraiser (team 1, team 2 etc.)</label></td>
							<td><textarea name="wcft-teamList" id="teamList">' . 
									$pluginState['wcft-teamList'] . 
								'</textarea></td>
						</tr>
					</table>';
					submit_button();
	echo 		'</form>';

}
