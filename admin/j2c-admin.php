<?php

function j2c_admin_settings() { // Set up and display admin settings

	global $j2c_database_settings_array;
	
	_e( '<h2>WP Talroo</h2>' ); 

	$j2c_publisher_id = $j2c_database_settings_array['j2c_publisher_id'];
	$j2c_publisher_password = $j2c_database_settings_array['j2c_publisher_password'];
	$j2c_logo_attribution = $j2c_database_settings_array['j2c_logo_attribution'];
	$j2c_display_page = $j2c_database_settings_array['j2c_display_page'];
	$j2c_keywords_placeholder = $j2c_database_settings_array['j2c_keywords_placeholder'];
	$j2c_default_location = $j2c_database_settings_array['j2c_default_location'];
	$j2c_location_placeholder = $j2c_database_settings_array['j2c_location_placeholder'];
	$j2c_jobs_per_page = $j2c_database_settings_array['j2c_jobs_per_page'];
	
	if ( isset( $_POST['j2c_hidden'] ) ) {
		if ( 'y' == $_POST['j2c_hidden'] ) // If options were changed, save settings
		{
			$j2c_publisher_id = esc_attr( $_POST['j2c_publisher_id'] );
			$j2c_publisher_password = esc_attr( $_POST['j2c_publisher_password'] );
			
			// I need this since unchecked checkboxes do not get passed in forms
			if ( isset( $_POST['j2c_logo_attribution'] ) ) {
				$j2c_logo_attribution = esc_attr( $_POST['j2c_logo_attribution'] );
			} else {
				$j2c_logo_attribution = '';
			}
			
			$j2c_display_page = $_POST['j2c_display_page'];
			$j2c_keywords_placeholder = esc_attr( $_POST['j2c_keywords_placeholder'] );
			$j2c_default_location = esc_attr( $_POST['j2c_default_location'] );
			$j2c_location_placeholder = esc_attr( $_POST['j2c_location_placeholder'] );
			$j2c_jobs_per_page = esc_attr( $_POST['j2c_jobs_per_page'] );

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
	
			$j2c_database_settings_array = get_option( 'j2c_admin_options' );  // update global DB variable
		
			?>
			<div class="updated"><p><strong><?php _e( 'Settings saved' ); ?></strong></p></div>
			<?php

		}
	}

	j2c_are_api_and_attribution_correct();
	j2c_check_for_pages(); // If no pages exist (or one is not selected), give error

	?>
	
	<!-- Display form in admin section -->
	<div class="wrap">
		<form name="j2c_form" class="j2c-admin-form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
			<input type="hidden" name="j2c_hidden" value="y" />
			
			<hr />
				
			<div><?php _e( '<h3>Publisher & Page Settings</h3>' ); ?></div>
			
			<div class="j2c-right-left-div-wrapper">
				<div class="j2c-admin-left-div">
					<label class="description" for="j2c_publisher_id"><?php _e( 'Publisher ID: ' ); ?></label>
				</div>	
				<div  class="j2c-admin-right-div">
					<input type="text" id="j2c_publisher_id" name="j2c_publisher_id" class="j2c-api-key-text" value="<?php echo stripslashes($j2c_publisher_id); ?>" maxlength="100" placeholder="Enter Publisher ID" />
				</div>	
			</div>
			
			<div class="j2c-right-left-div-wrapper">
				<div class="j2c-admin-left-div">
					<label class="description" for="j2c_publisher_password"><?php _e( 'Publisher Password: ' ); ?></label>
				</div>	
				<div  class="j2c-admin-right-div">
					<input type="text" id="j2c_publisher_password" name="j2c_publisher_password" class="j2c-publisher-password" value="<?php echo stripslashes($j2c_publisher_password); ?>" maxlength="100" placeholder="Enter Publisher Password" />
					<p class="description"><?php _e( "NOTE – Sometimes a newly created Talroo API feed will have a blank space preceding the password. Do not copy the blank space as part of the password." ); ?></p>
					<p class="description"><?php _e( "To register for a Talroo publisher account, go <a href='https://www.talroo.com/partners/job-publishers/' target='_blank'>here</a>." ); ?></p>
					<p class="description"><?php _e( "Information on where to find your publisher ID and password can be found <a href='https://www.skipthedrive.com/wp-talroo-plugin/#id' target='_blank'>here</a>." ); ?></p>
				</div>	
			</div>

			<div class="j2c-right-left-div-wrapper">
				<div class="j2c-admin-left-div">
					<label class="description" for="j2c_logo_attribution"><?php _e( 'Attribution:' ); ?></label>
				</div>
				<div  class="j2c-admin-right-div">
					<?php 

					if ($j2c_logo_attribution) {
						$j2c_attribution_checked_state = 'checked';
					} else {
						$j2c_attribution_checked_state = '';	
					}
						
					echo "<input type='checkbox' id='j2c_logo_attribution' name='j2c_logo_attribution' " . $j2c_attribution_checked_state . " >";

					?>
					<span class="description"><?php _e( "I agree to display Talroo attribution under the search results." ); ?></span>
				</div>
			</div>			

			<div class="j2c-right-left-div-wrapper">
				<div class="j2c-admin-left-div">
					<label class="description" for="j2c_display_page"><?php _e( 'Page to display jobs on:' ); ?></label>
				</div>
				<div  class="j2c-admin-right-div">
					<?php 
				
					if ( get_pages() ) { // Default is no page selected
						echo "<select id='j2c_display_page' name='j2c_display_page'>";
				
						if ( j2c_default_jobs_page == $j2c_display_page ) {
							$j2c_selected = 'selected';
						} else {
							$j2c_selected = '';
						}
				
						echo "<option value='" . j2c_default_jobs_page . "' $j2c_selected />" . j2c_default_jobs_page . "</option>";
				
						foreach ( get_pages() as $j2c_page_list ) {
							if ( $j2c_page_list->ID == $j2c_display_page ) { // Set which option is selected
								$j2c_selected = 'selected';
							} else {
								$j2c_selected = '';
							}	
							echo "<option value='$j2c_page_list->ID' $j2c_selected />$j2c_page_list->post_title</option>";
						}
						?>
						</select>
						<?php 
					} else { // No pages found, so display error msg
						echo "<p class='description'>" . j2c_no_pages_error. "</p>";
					}	
					?>
				</div>
			</div>
			
			<hr />
				
			<div><?php _e('<h3>Job Search Settings</h3>' ); ?></div>
			
			<div class="j2c-right-left-div-wrapper">
				<div class="j2c-admin-left-div">
					<label class="description" for="j2c_default_location"><?php _e('Only search this location:'); ?></label>
				</div>	
				<div class="j2c-admin-right-div">
					<input type="text" id="j2c_default_location" name="j2c_default_location" class="j2c_default_location" value="<?php echo stripslashes($j2c_default_location) ?>" maxlength="100" />
					<p class="description">If this is set, this will be the only location searched and the location field will be hidden from users. Enter zip code, city, state, or city-state combination. Leave blank to allow users to search by location. <a href="https://www.skipthedrive.com/wp-talroo-plugin/#location"  target="_blank">More info</a></p>	
				</div>
			</div>
									
			<hr />				

			<div><?php _e( '<h3>Display Settings</h3>' ); ?></div>
			
			<div class="j2c-right-left-div-wrapper">	
				<div class="j2c-admin-left-div">
					<label class="description" for="j2c_keywords_placeholder"><?php _e( 'Placeholder for keyword(s):' ); ?></label>
				</div>	
				<div class="j2c-admin-right-div">	
					<input type="text" id="j2c_keywords_placeholder" name="j2c_keywords_placeholder" value="<?php echo stripslashes( $j2c_keywords_placeholder ) ?>" maxlength="100" />
				</div>
			</div>				
			
			<div class="j2c-right-left-div-wrapper">	
				<div class="j2c-admin-left-div">
					<label class="description" for="j2c_location_placeholder"><?php _e( 'Placeholder for location:' ); ?></label>
				</div>	
				<div class="j2c-admin-right-div">	
					<input type="text" id="j2c_location_placeholder" name="j2c_location_placeholder" value="<?php echo stripslashes( $j2c_location_placeholder ) ?>" maxlength="100" />
						<p class="description">Placeholder text will be displayed if field is blank. The placeholder is not a value, rather, an example of what users should enter (i.e. <strong>enter keywords</strong>).</p>
				</div>
			</div>	

			<div class="j2c-right-left-div-wrapper">	
				<div class="j2c-admin-left-div">
					<label class="description" for="j2c_jobs_per_page"><?php _e( 'Job results per page:' ); ?></label>
				</div>	
				<div class="j2c-admin-right-div">	
					<input type="number" id="j2c_jobs_per_page" name="j2c_jobs_per_page" value="<?php echo stripslashes( $j2c_jobs_per_page ) ?>" min="1" max="50" step="1" required />
				</div>
			</div>	

			<hr />	
				
			<div class="j2c-admin-left-div">	
				<?php submit_button(); ?>
			</div> 
					
		</form>
	</div>
	<?php
}

function j2c_settings_menu() {

	
	add_options_page( 'WP Talroo', 'WP Talroo', 'manage_options', 'wp-talroo', 'j2c_admin_settings' );
}

function j2c_check_for_pages() { // Check that there are published pages to choose from
	
	if ( ! get_pages() ) {
		?>
		<div class="notice"><p><?php _e( 'Talroo Notice: ' . j2c_no_pages_error ); ?></p></div>
		<?php
	} else {
		j2c_is_page_selected();
	}		

}

function j2c_are_api_and_attribution_correct() {
	
	global $j2c_database_settings_array;
	
	$j2c_publisher_id = $j2c_database_settings_array['j2c_publisher_id'];
	$j2c_publisher_password = $j2c_database_settings_array['j2c_publisher_password'];	
	$j2c_logo_attribution = $j2c_database_settings_array['j2c_logo_attribution'];
	
	if ( ( ! $j2c_publisher_id ) ) {	
		?>
		<div class="notice"><p><?php _e( j2c_no_api_key ) ?></p></div>
		<?php
	}
	
	if ( ( ! $j2c_publisher_password ) ) {	
		?>
		<div class="notice"><p><?php _e( j2c_no_publisher_password ) ?></p></div>
		<?php
	}
	
	if ( ( ! $j2c_logo_attribution ) ) {	
		?>
		<div class="notice"><p><?php _e( j2c_logo_attribution_declined ) ?></p></div>
		<?php
	}


}

function j2c_is_page_selected() {
	
	global $j2c_database_settings_array;
	$j2c_jobs_page_user_selected = null;
	
	$j2c_display_page = $j2c_database_settings_array['j2c_display_page'];
	
	if ( isset( $_POST['j2c_display_page'] ) ) {
		$j2c_jobs_page_user_selected = $_POST['j2c_display_page'];
	}
	
	if ( ( j2c_default_jobs_page == $j2c_display_page ) || ( j2c_default_jobs_page == $j2c_jobs_page_user_selected ) ) {	
		?>
		<div class="notice"><p><?php _e( j2c_no_page_selected ) ?></p></div>
		<?php
	}

}

?>