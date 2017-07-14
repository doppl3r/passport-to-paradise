<?php
class Ptp_Activator {
	public static function activate() {
		global $wpdb;
		$version = get_option( 'my_plugin_version', '1.0' );
		$charset_collate = $wpdb->get_charset_collate();
		$table_name = $wpdb->prefix . 'ptp_table';

		$sql = "CREATE TABLE $table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			views smallint(5) NOT NULL,
			clicks smallint(5) NOT NULL,
			UNIQUE KEY id (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		
		if ( version_compare( $version, '2.0' ) < 0 ) {
			$sql = "CREATE TABLE $table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			views smallint(5) NOT NULL,
			clicks smallint(5) NOT NULL,
			blog_id smallint(5) NOT NULL,
			UNIQUE KEY id (id)
			) $charset_collate;";
			dbDelta( $sql );
		
			update_option( 'my_plugin_version', '2.0' );
		}
	}
}
