<?php
class Ptp_Admin {
	public function add_actions_to_menu(){
		add_action( 'admin_menu', array( $this, 'add_admin_menu_page' ) ); /* Add admin menu and page */
		add_action( 'admin_head', array( $this, 'ptp_admin_register_scripts' ) ); /* Add custom css sheet to this page */
	}
	public function add_admin_menu_page() {
		add_menu_page('Passport to Paradise', 'Passport', 'manage_options', 'passport-to-paradise', array( $this, 'ptp_render' ), 'dashicons-palmtree');
	}
	public function ptp_admin_register_scripts() {
		wp_register_style('bootstrap.min.css', plugin_dir_url(__FILE__) . 'css/bootstrap.min.css');
		wp_register_style('ptp.css', plugin_dir_url(__FILE__) . 'css/stylesheet.css');
		wp_enqueue_style('bootstrap.min.css');
		wp_enqueue_style('ptp.css');

		wp_register_script('tether.min.js', plugin_dir_url(__FILE__) . 'js/tether.min.js');
		wp_register_script('bootstrap.min.js', plugin_dir_url(__FILE__) . 'js/bootstrap.min.js');
		wp_register_script('ptp.js', plugin_dir_url(__FILE__) . 'js/scripts.js');
		wp_enqueue_script('tether.min.js');
		wp_enqueue_script('bootstrap.min.js');
		wp_enqueue_script('ptp.js');
	}
	public function ptp_render(){ 
		//$this->add_new_user("Jake",9000);
		//$this->update_user_points("Jake",9005);
		echo '
			<div class="ptp-admin-body">
				<h1>Passport to Paradise</h1>
				<div class="ptp-admin-wrapper">
					<h3>Names</h3>';
						global $wpdb;
						$nameColumn = $wpdb->get_results("SELECT name FROM wp_ptp_table");
						$pointsColumn = $wpdb->get_results("SELECT points FROM wp_ptp_table");
						foreach ($nameColumn as $nameRow) {
					echo 	'<div class="row">' . 
								'<div class="col-sm-6">' . $nameRow->name . '</div>' . 
								'<div class="col-sm-6">' . $nameRow->name . '</div>' . 
							'</div>';
						}
			echo '</div>
			</div>
		';
	}
	public function add_new_user($name, $points = 0){
		global $wpdb;
		$wpdb->insert('wp_ptp_table', array(
			'name' => $name,
			'points' => $points,
		));
	}
	public function update_user_points($name, $points){
		global $wpdb;
		$wpdb->update('wp_ptp_table', //specify table
		array( 'points' => $points ), //update points
		array( 'name' => $name )); //where (all matching names)
	}
	public function delete_user($name){
		global $wpdb;
		$wpdb->delete('wp_ptp_table', //specify table
		array( 'name' => $name )); //where (all matching names)
	}
}
