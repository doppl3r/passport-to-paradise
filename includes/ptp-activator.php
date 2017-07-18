<?php
class Ptp_Activator {
	public static function activate() {
		global $wpdb;
		$version = get_option( 'my_plugin_version', '1.0' ); /* change to update colum */
		$charset_collate = $wpdb->get_charset_collate(); /* ex: utf8mb4_unicode */
		$table_name = $wpdb->prefix . 'ptp_table'; /* set table name for columns */

		//create name and types columns for the first time
		$sql = "CREATE TABLE $table_name ( 
			id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
			name VARCHAR(50) NOT NULL, 
			points INT(6) NOT NULL,
			PRIMARY KEY (id)
		) $charset_collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		
		//update with new columns
		if ( version_compare( $version, '2.0' ) < 0 ) {
			$sql = "CREATE TABLE $table_name ( 
				id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
				name VARCHAR(50) NOT NULL, 
				points INT(6) NOT NULL,
				PRIMARY KEY (id)
			) $charset_collate;";
			dbDelta( $sql );
			update_option( 'my_plugin_version', '2.0' );
		}
	}
}
