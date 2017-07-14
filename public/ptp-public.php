<?php
class Ptp_Public {
	private $plugin_name;
	private $version;

	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}
	public function ptp_admin_register_scripts() {
		wp_register_style('passport-to-paradise-styles', plugin_dir_url(__FILE__) . 'css/stylesheet.css');
		wp_enqueue_style('passport-to-paradise-styles');

		wp_register_script('passport-to-paradise-scripts', plugin_dir_url(__FILE__) . 'js/scripts.js');
		wp_enqueue_script('passport-to-paradise-scripts');
	}
}
