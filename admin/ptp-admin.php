<?php
class Ptp_Admin {
	public function add_actions_to_menu(){
		add_action( 'admin_menu', array( $this, 'add_admin_menu_page' ) ); /* Add admin menu and page */
		add_action( 'admin_head', array( $this, 'ptp_admin_register_scripts' ) ); /* Add custom css sheet to this page */
	}
	public function add_admin_menu_page() {
		add_menu_page('Passport to Paradise', 'Passport', 'manage_options', 'passport-to-paradise', array( $this, 'ptp_admin_page_html' ), 'dashicons-palmtree');
	}
	public function ptp_admin_register_scripts() {
		wp_register_style('passport-to-paradise-styles', plugin_dir_url(__FILE__) . 'css/stylesheet.css');
		wp_enqueue_style('passport-to-paradise-styles');

		wp_register_script('passport-to-paradise-scripts', plugin_dir_url(__FILE__) . 'js/scripts.js');
		wp_enqueue_script('passport-to-paradise-scripts');
	}
	public function ptp_admin_page_html(){ 
		echo '
			<div class="ptp-admin-body">
				<h1>Passport to Paradise</h1>
				<div class="ptp-admin-wrapper">
					<h3>Coming soon</h3>
				</div>
			</div>
		';
	}
}
