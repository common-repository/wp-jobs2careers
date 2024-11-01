<?php
/*
Plugin Name: WP Talroo
Plugin URI: https://www.skipthedrive.com/wp-talroo-plugin/
Description: Connect to the Talroo API and display jobs on your site.
Version: 2.4
Author: Pete Metz
Author URI: https://www.skipthedrive.com
License: GPL2
License URL: https://www.gnu.org/licenses/gpl-2.0.html
*/

defined( 'ABSPATH' ) or die( 'No scripts please' );

/******************
* Globals and constants
*******************/

define( 'j2c_no_pages_error', 'You have no pages created. You must create a page to display your jobs on.' );
define( 'j2c_no_page_selected', 'You must select a page to display jobs on.' );
define( 'j2c_no_api_key', 'You must enter a valid Talroo Publisher ID.' );
define( 'j2c_no_publisher_password', 'You must enter your Talroo Publisher Password.' );
define( 'j2c_logo_attribution_declined', 'You must agree to display Talroo attribution on your jobs page.' );
define( 'j2c_default_jobs_page', '--- Select Page ---' );
define( 'j2c_version', '2.4' );

$j2c_database_settings_array = get_option( 'j2c_admin_options' ); // All plugin DB settings

/******************
* Files to include
*******************/

include( 'admin/j2c-admin.php' );
include( 'display/j2c-job-display.php' );
include( 'load-control/j2c-enqueue.php' );
include( 'error-handling/j2c-error-handling.php' );

/******************
* Hooks
*******************/

add_action( 'init', 'j2c_jobs_per_page' ); // Try 'upgrader_process_complete' with lower priority or different hook
add_action( 'admin_menu', 'j2c_settings_menu' ); // Create admin settings and form
add_filter( 'the_content', 'j2c_job_display' ); // Display jobs
add_action( 'wp_enqueue_scripts', 'j2c_enqueue', 9999 ); // High priority to ensure loading after theme
add_action( 'admin_enqueue_scripts', 'j2c_admin_style' ); //Style for admin section
add_action( 'admin_notices', 'j2c_renamed_to_talroo'); //Give message for plugin renaming to Talroo

/******************
* Initialize DB
*******************/

register_activation_hook( __FILE__, 'j2c_set_default_db_values' );

function j2c_set_default_db_values () {

	global $j2c_database_settings_array;
	
	if ( ! $j2c_database_settings_array ) { // If the option isn't present, set defaults
		$j2c_db_array = array(
			'j2c_publisher_id' => '',
			'j2c_publisher_password' => '',	
			'j2c_logo_attribution' => false,
			'j2c_display_page' => j2c_default_jobs_page,
			'j2c_keywords_placeholder' => 'Enter keyword(s)',
			'j2c_default_location' => '',
			'j2c_location_placeholder' => 'Enter location',
			'j2c_jobs_per_page' => 10,	
		);
		add_option( 'j2c_admin_options', $j2c_db_array );
	} 
}

function j2c_jobs_per_page () {

	global $j2c_database_settings_array;
	
	if ( ! isset( $j2c_database_settings_array['j2c_jobs_per_page'] ) ) {	
		$j2c_publisher_id = $j2c_database_settings_array['j2c_publisher_id'];
		$j2c_publisher_password = $j2c_database_settings_array['j2c_publisher_password'];
		$j2c_logo_attribution = $j2c_database_settings_array['j2c_logo_attribution'];
		$j2c_display_page = $j2c_database_settings_array['j2c_display_page'];
		$j2c_keywords_placeholder = $j2c_database_settings_array['j2c_keywords_placeholder'];
		$j2c_default_location = $j2c_database_settings_array['j2c_default_location'];
		$j2c_location_placeholder = $j2c_database_settings_array['j2c_location_placeholder'];
		$j2c_jobs_per_page = 10;

		update_option( 'j2c_admin_options', array(
			'j2c_publisher_id' => $j2c_publisher_id, 
			'j2c_publisher_password' => $j2c_publisher_password,
			'j2c_logo_attribution' => $j2c_logo_attribution, 
			'j2c_display_page' => $j2c_display_page, 	
			'j2c_keywords_placeholder' => $j2c_keywords_placeholder, 
			'j2c_default_location' => $j2c_default_location, 
			'j2c_location_placeholder' => $j2c_location_placeholder,
			'j2c_jobs_per_page' => $j2c_jobs_per_page,
		) );
	}
}

function j2c_renamed_to_talroo () {

	global $j2c_database_settings_array;

	if ( ! isset( $j2c_database_settings_array['j2c_renamed_to_talroo'] ) ) {

		?>
		<div class = "notice notice-success is-dismissible"> 
		<p><?php _e ( 'NOTE: The plugin WP Jobs2Careers has been renamed to WP Talroo.', 'wp-talroo'); ?></p>
		</div>
		<?php

		$j2c_publisher_id = $j2c_database_settings_array['j2c_publisher_id'];
		$j2c_publisher_password = $j2c_database_settings_array['j2c_publisher_password'];
		$j2c_logo_attribution = $j2c_database_settings_array['j2c_logo_attribution'];
		$j2c_display_page = $j2c_database_settings_array['j2c_display_page'];
		$j2c_keywords_placeholder = $j2c_database_settings_array['j2c_keywords_placeholder'];
		$j2c_default_location = $j2c_database_settings_array['j2c_default_location'];
		$j2c_location_placeholder = $j2c_database_settings_array['j2c_location_placeholder'];
		$j2c_jobs_per_page = $j2c_database_settings_array['j2c_jobs_per_page'];
		$j2c_renamed_to_talroo = true;

		update_option( 'j2c_admin_options', array(
			'j2c_publisher_id' => $j2c_publisher_id, 
			'j2c_publisher_password' => $j2c_publisher_password,
			'j2c_logo_attribution' => $j2c_logo_attribution, 
			'j2c_display_page' => $j2c_display_page, 	
			'j2c_keywords_placeholder' => $j2c_keywords_placeholder, 
			'j2c_default_location' => $j2c_default_location, 
			'j2c_location_placeholder' => $j2c_location_placeholder,
			'j2c_jobs_per_page' => $j2c_jobs_per_page,
			'j2c_renamed_to_talroo' => $j2c_renamed_to_talroo,
		) );
	}	

}


?>