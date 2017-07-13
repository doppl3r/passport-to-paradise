<?php
	add_action( 'admin_menu', 'my_admin_menu' ); /* Add admin menu and page */
	add_action( 'admin_head', 'ptp_admin_register_scripts' ); /* Add custom css sheet to this page */
	
	function my_admin_menu() {
		add_menu_page('Passport to Paradise', 'Passport', 'manage_options', 'passport-to-paradise', 'ptp_admin_page', 'dashicons-palmtree');
	}
	function ptp_admin_register_scripts() {
		wp_register_style('passport-to-paradise-styles', plugin_dir_url(__FILE__) . 'css/stylesheet.css');
		wp_enqueue_style('passport-to-paradise-styles');

		wp_register_script('passport-to-paradise-scripts', plugin_dir_url(__FILE__) . 'js/scripts.js');
		wp_enqueue_script('passport-to-paradise-scripts');
	}
	function ptp_admin_page(){ 
		echo '
			<div class="ptp-admin-body">
				<h1>Passport to Paradise</h1>
				<div class="ptp-admin-wrapper">
					<h3>Coming soon</h3>
				</div>
			</div>
		';
	}
?>