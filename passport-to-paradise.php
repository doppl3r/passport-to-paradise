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
//take action for activation or deactivation of plugins
function activate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-plugin-name-activator.php';
	Plugin_Name_Activator::activate();
}
function deactivate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-plugin-name-deactivator.php';
	Plugin_Name_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_plugin_name' );
register_deactivation_hook( __FILE__, 'deactivate_plugin_name' );

if (is_admin()){
    require_once('admin/ptp-admin.php'); 
    $admin_page_var = new Ptp_Admin();
    $admin_page_var->add_actions_to_menu();
}