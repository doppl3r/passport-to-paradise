<?php
/**
 * @package Passport_To_Paradise
 * @version 0.1
 */
/*
Plugin Name: Passport to Paradise
Plugin URI: https://wordpress.org/plugins/passport-to-paradise
Description: This plugin allows users to quickly view their Passport to Paradise reward points. Special users are able to edit a full list of rewards.
Version: 0.1
Author: Jacob DeBenedetto
Author URI: http://doppl3r.com
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: passport-to-paradise
Passport to Paradise is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
Passport to Paradise is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with Passport to Paradise. If not, see {License URI}.
*/

//prevent direct access to wordpress files
if ( ! defined( 'WPINC' ) ) { die; }

//establish database table on activation
function activate_ptp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/ptp-activator.php';
	Ptp_Activator::activate();
}

//change plugin state when deactivated
function deactivate_ptp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/ptp-deactivator.php';
	Ptp_Deactivator::deactivate();
}

//register the activate and deactivate functions
register_activation_hook( __FILE__, 'activate_ptp' );
register_deactivation_hook( __FILE__, 'deactivate_ptp' );

//Add shortcode that returns a specific user's score
function ptp_shortcode($atts) {
	global $wpdb;
	extract(shortcode_atts(array('name' => 'please specify name' ), $atts));
	foreach( $wpdb->get_results("SELECT * FROM wp_ptp_table;") as $key => $row) {
		if (strtolower($name) == strtolower($row->name)) $name = $row->points;
	}
	return $name;
}
add_shortcode('ptp', 'ptp_shortcode');

//add the admin page if user has permission
if (is_admin()){
    require_once('admin/ptp-admin.php'); 
    $admin_page_var = new Ptp_Admin();
    $admin_page_var->add_actions_to_menu();
}