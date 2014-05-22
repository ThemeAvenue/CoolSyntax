<?php
/**
 * Plugin dashboard.
 *
 * @package   CoolSyntax
 * @author    ThemeAvenue <web@themeavenue.net>
 * @license   GPL-2.0+
 * @link      http://themeavenue.net
 * @copyright 2014 ThemeAvenue
 */
?>

<div class="wrap">  
	<div class="icon32" id="icon-options-general"></div>  
	<h2><?php _e( 'CoolSyntax Settings', 'coolsyntax' ); ?></h2>

	<form action="options.php" method="post">
		<?php
		settings_fields( $this->plugin_slug . '_options' );
		do_settings_sections( $this->plugin_slug . '_options' ); 
		?>
		<p class="submit">  
			<input name="Submit" type="submit" class="button-primary" id="coolsyntax-options-submit" value="<?php esc_attr_e( 'Save','wpas' ); ?>" />  
		</p>  
		  
	</form>  
</div>