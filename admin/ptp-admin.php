<?php
class Ptp_Admin {
	public function add_actions_to_menu(){
		add_action( 'admin_menu', array( $this, 'add_admin_menu_page' ) ); /* Add admin menu and page */
		add_action( 'admin_head', array( $this, 'ptp_admin_register_scripts' ) ); /* Add custom css sheet to this page */
		//add hooks for jquery functionality
		add_action( 'wp_ajax_add_user', array( $this, 'add_user' ) );
		add_action( 'wp_ajax_update_user', array( $this, 'update_user' ) );
		add_action( 'wp_ajax_delete_user', array( $this, 'delete_user' ) );
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
		wp_register_script('ptp.js', plugin_dir_url(__FILE__) . 'js/ptp.js');
		wp_enqueue_script('tether.min.js');
		wp_enqueue_script('bootstrap.min.js');
		wp_enqueue_script('ptp.js');
	}
	public function ptp_render(){
		echo '
			<div class="ptp-admin-body">
				<h1>Passport to Paradise</h1>
				<div class="row">
					<div class="col-sm-8">
						<div class="ptp-content">
							<h3>Names</h3>
							<div class="ptp-list">';
								global $wpdb;
								$nameColumn = $wpdb->get_results("SELECT name FROM wp_ptp_table");
								$pointsColumn = $wpdb->get_results("SELECT points FROM wp_ptp_table");
								foreach ($nameColumn as $key => $nameRow) {
		echo 						'<div class="row">' . 
										'<div class="col-sm-6">' . $nameRow->name . '</div>' . 
										'<div class="col-sm-6">' . $pointsColumn[$key]->points . '</div>' . 
									'</div>';
								}
		echo '				</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="ptp-content">
							<h3>Add User</h3>
							<form method="post" target="hiddenFrame">
								<input id="new_user_name" type="text" placeholder="Full Name" required>
								<input id="new_user_points" type="number" placeholder="Points">
								<button id="add_user" class="btn btn-primary"><i class="material-icons">group_add</i></button>
							</form>
							<iframe name="hiddenFrame" width="0" height="0" border="0" style="display: none;"></iframe>
						</div>
					</div>
				</div>
			</div>
		';
	}
	public function add_user() {
		global $wpdb; // this is how you get access to the database
		$name = strval( $_POST['name'] );
		$points = intval( $_POST['points'] );
		$wpdb->insert('wp_ptp_table', array(
			'name' => $name,
			'points' => $points,
		));
		echo "added";
		wp_die();
	}
	public function update_user(){
		global $wpdb;
		$name = strval( $_POST['name'] );
		$points = intval( $_POST['points'] );
		$wpdb->update('wp_ptp_table', //specify table
		array( 'points' => $points ), //update points
		array( 'name' => $name )); //where (all matching names)
		echo "updated";
		wp_die();
	}
	public function delete_user(){
		global $wpdb;
		$name = strval( $_POST['name'] );
		$wpdb->delete('wp_ptp_table', //specify table
		array( 'name' => $name )); //where (all matching names)
		echo "deleted";
		wp_die();
	}
}