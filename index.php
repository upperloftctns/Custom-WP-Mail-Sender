<?php 

/*
 * Plugin Name: Custom WordPress Mail Sender (CWMS)
 * Description: Change the WordPress mail sender name and email to a custom one.
 * Version: 1.0.0
 * Author: Upperloft Creations
 * Author URI: https://upperloftcreations.com
 */

// Don't call the file directly
if ( !defined( 'ABSPATH' ) ) exit;


/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */
function cwms_mail_load_textdomain() {
  load_plugin_textdomain( 'cwms-mail', false, basename( dirname( __FILE__ ) ) . '/languages' ); 
}

add_action( 'init', 'cwms_mail_load_textdomain' );

function cwms_mail_sender_register() {
	add_settings_section('cwms_mail_sender_section', __('CWMS Options', 'cwms-mail'), 'cwms_mail_sender_text', 'cwms_mail_sender');

	add_settings_field('cwms_mail_sender_id', __('CWMS Name','cwms-mail'), 'cwms_mail_sender_function', 'cwms_mail_sender',  'cwms_mail_sender_section');

	register_setting('cwms_mail_sender_section', 'cwms_mail_sender_id');

	add_settings_field('cwms_mail_sender_email_id', __('CWMS Email', 'cwms-mail'), 'cwms_mail_sender_email', 'cwms_mail_sender',  'cwms_mail_sender_section');

	register_setting('cwms_mail_sender_section', 'cwms_mail_sender_email_id');

}
add_action('admin_init', 'cwms_mail_sender_register');



function cwms_mail_sender_function(){

	printf('<input name="cwms_mail_sender_id" type="text" class="regular-text" value="%s" placeholder="CWMS Mail Name"/>', get_option('cwms_mail_sender_id'));

}
function cwms_mail_sender_email() {
	printf('<input name="cwms_mail_sender_email_id" type="email" class="regular-text" value="%s" placeholder="something@example.com"/>', get_option('cwms_mail_sender_email_id'));


}

function cwms_mail_sender_text() {

	printf('%s Use a custom mail sender name and email here %s', '<p>', '</p>');

}



function cwms_mail_sender_menu() {
	add_menu_page(__('CWMS Options', 'cwms-mail'), __('CWMS', 'cwms-mail'), 'manage_options', 'cwms_mail_sender', 'cwms_mail_sender_output', 'dashicons-email');


}
add_action('admin_menu', 'cwms_mail_sender_menu');



function cwms_mail_sender_output(){
?>	
	<?php settings_errors();?>
	<form action="options.php" method="POST">
		<?php do_settings_sections('cwms_mail_sender');?>
		<?php settings_fields('cwms_mail_sender_section');?>
		<?php submit_button();?>
	</form>
<?php }








// Change the default sender email address
add_filter('wp_mail_from', 'cb_new_mail_from');
add_filter('wp_mail_from_name', 'cb_new_mail_from_name');
 
function cb_new_mail_from($old) {
	return get_option('cwms_mail_sender_email_id');
}
function cb_new_mail_from_name($old) {
	return get_option('cwms_mail_sender_id');
}