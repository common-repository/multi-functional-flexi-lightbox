<?php
add_action('admin_init', 'arv_lb_options_init' );
add_action('admin_menu', 'arv_lb_options_add_page');

// Init plugin options to white list our options
function arv_lb_options_init(){
	register_setting( 'arv_lb_opt_group', 'arv_lb', 'arv_lb_options_val' );
//delete_option('arv_lb');
}


// Add menu page
function arv_lb_options_add_page() {
	add_menu_page('Arevico Settings', 'MF-LightBox', 'manage_options', 'arv_fb', 'arv_lb_options_do_page');
}
// This function sets default options for an array
function defaulter($arr_opt,$reset=false){
	$defs = array("delay"=>0,"display_on_page"=>"1","display_on_post"=>"1","message"=>"<p>Here you can put your links, ads, opt-in form, facebook like button!</p>","title"=>"",'width'=>"300","height"=>"120"
	,"show_once"=>"-1","exc"=>"[no_lb]");
	$checkboxes = array("display_on_post","display_on_page","show_once");
	
	$k_defs=array_keys($defs);
	

	foreach ($k_defs as $opt){
		/*_____________________________________*/
		if (in_array($opt,$checkboxes) && $arr_opt[$opt]==""){
			$arr_opt[$opt]=-1;
		}
		if ( (!isset($arr_opt[$opt])) || ($arr_opt[$opt]=="") ){
			$arr_opt[$opt]=$defs[$opt];
		}
		/*_____ _____ ______ ______ ______ ______ _____*/

	} return $arr_opt;
}
// Draw the menu page itself
function arv_lb_options_do_page() {
	?>
	<div class="wrap">
	<?php if( isset($_GET['settings-updated']) ) { ?>
    <div id="message" class="updated">
        <p><strong><?php _e('Settings saved.') ?></strong></p>
    </div>
	<?php } ?>

	<h2>Options</h2>
		<form method="post" action="options.php" id="fl">
			<?php settings_fields('arv_lb_opt_group'); ?>
			<?php $options = defaulter(get_option('arv_lb'));?>

			<table class="form-table">
				<tr valign="top"><th scope="row">Show Once per Visitor:</th>
					<td><input name="arv_lb[show_once]" type="checkbox" value="1" <?php checked('1', $options['show_once']); ?> /></td>
				</tr>

				<tr valign="top"><th scope="row">Show on:</th>
					<td>
					<input name="arv_lb[display_on_page]" type="checkbox" value="1" <?php checked('1', $options['display_on_page']); ?> /> On Page &nbsp;&nbsp;&nbsp;&nbsp;
					<input name="arv_lb[display_on_post]" type="checkbox" value="1" <?php checked('1', $options['display_on_post']); ?> /> On Post
					</td>
				</tr>
	
				<tr valign="top"><th scope="row">Delay (miliseconds):</th>
					<td><input type="text" name="arv_lb[delay]" value="<?php echo $options['delay']; ?>" /></td>
				</tr>
				<tr valign="top"><th scope="row">Title:</th>
					<td><input type="text" name="arv_lb[title]" value="<?php echo $options['title']; ?>" /></td>
				</tr>
				<tr valign="top"><th scope="row">Message:</th>
					<td><textarea name="arv_lb[message]" rows="5"><?php echo htmlentities($options['message']); ?></textarea></td>
				</tr>
				<tr valign="top"><th scope="row">Width: (in pixels)</th>
					<td><input type="text" name="arv_lb[width]" value="<?php echo $options['width']; ?>" /></td>
				</tr>
				<tr valign="top"><th scope="row">Height: (in pixels)</th>
					<td><input type="text" name="arv_lb[height]" value="<?php echo $options['height']; ?>" /></td>
				</tr>
				<tr valign="top"><th scope="row">Exclude Shortcode:</th>
					<td><input type="text" name="arv_lb[exc]" value="<?php echo $options['exc']; ?>" /></td>
				</tr>
			</table>
			<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />

			</p>

		</form>
	</div>
	<?php
}

// 	tize and validate input. Accepts an array, return a sanitized array.
function arv_lb_options_val($input) {
	// Our first value is either 0 or 1
	return $input;
}

?>