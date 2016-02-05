<?php

add_action('admin_init', 'ninja_forms_register_tab_upload_settings');
function ninja_forms_register_tab_upload_settings(){
	$args = array(
		'name' => 'Upload Settings',
		'page' => 'ninja-forms-uploads',
		'display_function' => '',
		'save_function' => 'ninja_forms_save_upload_settings',
		'tab_reload' => true,
	);
	if( function_exists( 'ninja_forms_register_tab' ) ){
		ninja_forms_register_tab('upload_settings', $args);
	}
}

add_action( 'admin_init', 'ninja_forms_register_upload_settings_metabox');
function ninja_forms_register_upload_settings_metabox(){
	$args = array(
		'page' => 'ninja-forms-uploads',
		'tab' => 'upload_settings',
		'slug' => 'upload_settings',
		'title' => __('Upload Settings', 'ninja-forms'),
		'settings' => array(
			array(
				'name' => 'max_file_size',
				'type' => 'text',
				'label' => __( 'Max File Size (in MB)', 'ninja-forms' ),
				'desc' => '',
			),
			array(
				'name' => 'upload_error',
				'type' => 'text',
				'label' => __('File upload error message', 'ninja-forms'),
				'desc' => '',
			),
			array(
				'name' => 'adv_settings',
				'type' => '',
				'display_function' => 'ninja_forms_upload_settings_adv',
			),
		),
	);
	if( function_exists( 'ninja_forms_register_tab_metabox' ) ){
		ninja_forms_register_tab_metabox($args);
	}
}

function ninja_forms_upload_settings_adv(){

	$plugin_settings = get_option("ninja_forms_settings");

	if(isset($plugin_settings['base_upload_dir'])){
		$base_upload_dir = stripslashes($plugin_settings['base_upload_dir']);
	}else{	
		$base_upload_dir = wp_upload_dir();
		$base_upload_dir = $base_upload_dir['basedir'];
		$plugin_settings['base_upload_dir'] = $base_upload_dir;
		update_option( 'ninja_forms_settings', $plugin_settings );
	}	

	if(isset($plugin_settings['base_upload_url'])){
		$base_upload_url = stripslashes($plugin_settings['base_upload_url']);
	}else{
		$base_upload_url = wp_upload_dir();
		$base_upload_url = $base_upload_url['baseurl'];
		$plugin_settings['base_upload_url'] = $base_upload_url;
		update_option( 'ninja_forms_settings', 'ninja-forms' );
	}

	if(isset($plugin_settings['custom_upload_dir'])){
		$custom_upload_dir = stripslashes($plugin_settings['custom_upload_dir']);
	}else{
		$custom_upload_dir = '';
	}

	if(isset($plugin_settings['max_filesize'])){
		$max_filesize = $plugin_settings['max_filesize'];
	}else{
		$max_filesize = '';
	}



?>
	<div class="">
		<h4><?php _e('Custom Directory', 'ninja-forms');?> <img id="" class='ninja-forms-help-text' src="<?php echo NINJA_FORMS_URL;?>/images/question-ico.gif" title=""></h4>
		<label for="">
			<input type="text" class="widefat code" name="custom_upload_dir" id="" value="<?php echo $custom_upload_dir;?>" />
		</label>
		<span class="howto">
			<?php _e( 'If you want to create dynamic directories, you can put folder names in this box. You can use the following shortcodes, please include a slash at the beginning and a trailing slash', 'ninja-forms' );?>:<br /><br />
			<?php _e( 'For example: /custom/director/structure/', 'ninja-forms' );?><br><br>
			<li>%formtitle% - <?php _e('Puts in the title of the current form without any spaces', 'ninja-forms');?></li>
			<li>%username% - <?php _e('Puts in the user\'s username if they are logged in', 'ninja-forms');?>.</li>
			<li>%date% - <?php _e('Puts in the date in yyyy-mm-dd (1998-05-23) format', 'ninja-forms');?>.</li>
			<li>%month% - <?php _e('Puts in the month in mm (04) format', 'ninja-forms');?>.</li>
			<li>%day% - <?php _e('Puts in the day in dd (20) format', 'ninja-forms');?>.</li>
			<li>%year% - <?php _e('Puts in the year in yyyy (2011) format', 'ninja-forms');?>.</li>
			<li>For Example: /%formtitle%/%month%/%year%/ &nbsp;&nbsp;&nbsp; would be &nbsp;&nbsp;&nbsp; /MyFormTitle/04/2012/</li>
		</span>

		<h4><?php _e('Full Directory', 'ninja-forms');?> <img id="" class='ninja-forms-help-text' src="<?php echo NINJA_FORMS_URL;?>/images/question-ico.gif" title=""></h4>
			<span class="code"><?php echo $base_upload_dir;?><b><?php echo $custom_upload_dir;?></b></span>
		<br />
	</div>
<?php
}

function ninja_forms_save_upload_settings( $data ){
	$plugin_settings = get_option( 'ninja_forms_settings' );
	foreach( $data as $key => $val ){
		$plugin_settings[$key] = $val;
	}
	update_option( 'ninja_forms_settings', $plugin_settings );
	$update_msg = __( 'Settings Saved', 'ninja-forms' );
	return $update_msg;
}