<?php

add_action('admin_menu', 'wbh_api_admin_menu');
function wbh_api_admin_menu(){
	add_menu_page( 'API Menu', 'API Menu', 'manage_options', 'site-api-options', 'wbh_admin_api_setting' );
}

function wbh_admin_api_setting(){
	?>
	<div class="wrap">
		<h2><?php echo get_admin_page_title() ?></h2>

		<form action="options.php" method="POST">
			<?php
				settings_fields( 'wbh_autoupload_field_group' );    
				do_settings_sections( 'wbh_adminmenu_page' ); 
				submit_button();
			?>
		</form>
		<hr>
		<p><label for="datestring">Date format example - 01.01.2010 (dd.mm.yyyy)</label></p>
		<input type="text" id="datestring" placeholder="Date" name="datestring">
		<button id="generateBlog" class="button button-primary">Generate tracks</button>
	</div>
	<?php
}

/**
 * Регистрируем настройки.
 */
add_action('admin_init', 'wbh_autoupload_settings');
function wbh_autoupload_settings(){

	register_setting( 'wbh_autoupload_field_group', 'wbh_is_autoupload', 'wbh_sanitize_callback' );

	register_setting( 'wbh_autoupload_field_group', 'wbh_startdate', 'wbh_sanitize_callback_2' );

	add_settings_section( 'wbh_settings_section', 'Settings', '', 'wbh_adminmenu_page' ); 

	add_settings_field('wbh_settings_field', 'Automatic tracks generator', 'wbh_fill_settings_field', 'wbh_adminmenu_page', 'wbh_settings_section' );
}



function wbh_fill_settings_field(){
	$val = get_option('wbh_is_autoupload');
	$wbh_start = get_option('wbh_startdate');
	?>
	<label><input type="checkbox" name="wbh_is_autoupload" value="1" <?php checked( 1, $val ) ?> /> </label>
	<label for="startdate"><p>Start Date (dd.mm.yyyy)</p></label>
	<input type="text" id="startdate" placeholder="Date" name="wbh_startdate" value="<?php echo($wbh_start) ?>">
	<?php
}


function wbh_sanitize_callback( $options ){ 
	
	$val = intval( $val );

	return $options;
}

function wbh_sanitize_callback_2( $options ){ 
	
	return $options;
}