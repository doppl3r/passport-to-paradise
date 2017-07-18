<?php
class Ptp_Admin {
	
	//add interaction within the plugin page
	public function add_actions_to_menu(){
		add_action( 'admin_menu', array( $this, 'add_admin_menu_page' ) ); /* Add admin menu and page */
		add_action( 'admin_head', array( $this, 'ptp_admin_register_scripts' ) ); /* Add custom css sheet to this page */
		//add hooks for jquery functionality
		add_action( 'wp_ajax_add_user', array( $this, 'add_user' ) );
		add_action( 'wp_ajax_update_user', array( $this, 'update_user' ) );
		add_action( 'wp_ajax_delete_user', array( $this, 'delete_user' ) );
	}

	//Set the title, nav text, capability, url address, class function, and icon 
	public function add_admin_menu_page() {
		add_menu_page('Passport to Paradise', 'Passport', 'manage_options', 'passport-to-paradise', array( $this, 'ptp_render' ), 'dashicons-palmtree');
	}

	//register scripts
	public function ptp_admin_register_scripts() {
		//only register and enqueue files on the plugin admin page
		if (strpos($_SERVER["REQUEST_URI"], "passport-to-paradise") !== false){
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
		};
	}

	// load HTML from database
	public function ptp_render(){
		echo '
			<div class="ptp-admin-body">
				<h1>Passport to Paradise</h1>
				<div class="row">
					<div class="col-sm-8">
						<div class="ptp-content">
							<div class="ptp-list">
								<div class="row">
									<div class="col-sm-6"><strong>Name:</strong></div>
									<div class="col-sm-6"><strong>Points:</strong></div>
								</div>';
								global $wpdb;
								foreach ( $wpdb->get_results("SELECT * FROM wp_ptp_table;") as $key => $row) {
		echo 						'<div class="row">' . 
										'<div class="col-sm-6 item">' . $row->name . '</div>' . 
										'<div class="col-sm-6 item">' . $row->points . '</div>' . 
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
								<button id="add_user" class="btn btn-primary"><i class="material-icons">person_add</i></button>
							</form>
							<iframe name="hiddenFrame" width="0" height="0" border="0" style="display: none;"></iframe>
						</div>
					</div>
				</div>
			</div>
		';
	}

	//add new user when called from an ajax action. ex: $.post(ajaxurl, { 'action': 'add_user' ... });
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

	//update user when called from an ajax action
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

	//delete user when called from an ajax action
	public function delete_user(){
		global $wpdb;
		$name = strval( $_POST['name'] );
		$wpdb->delete('wp_ptp_table', //specify table
		array( 'name' => $name )); //where (all matching names)
		echo "deleted";
		wp_die();
	}
}