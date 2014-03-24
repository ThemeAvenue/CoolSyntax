<?php
function coolsyntax_output_option( $option ) {

	$current 	= wpbp_get_option( $option['name'] );
	$field_type = $option['type'];
	$prefix 	= 'coolsyntax';
	
	switch( $field_type ):

		case 'text': ?>
			<input type="text" name="<?php echo $option['group'].'['.$option['name'].']'; ?>" id="<?php echo $prefix . '_' . $option['name']; ?>" value="<?php echo $current; ?>" class="regular-text" />
			<?php if( isset($option['desc']) && $option['desc'] != '' ): ?><p class="description"><?php echo $option['desc']; ?></p><?php endif; ?>
		<?php break;

		case 'license': ?>
			<input type="text" name="<?php echo $option['group'].'['.$option['name'].']'; ?>" id="<?php echo $prefix . '_' . $option['name']; ?>" value="<?php echo $current; ?>" class="tav-license regular-text" placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx" /> <input type="button" id="tav-check-license" class="button-secondary" value="<?php _e( 'Check', 'wpbp' ); ?>">
			<?php if( isset($option['desc']) && $option['desc'] != '' ): ?><p class="description"><?php echo $option['desc']; ?></p><?php endif; ?>
			<div style="display: none;">
				<div id="tav-license-status-empty"><p class="tav-license-status"><?php _e( 'You did not enter your Envato purchase code.', 'wpbp' ); ?></p></div>
				<div id="tav-license-status-error"><p class="tav-license-status"><?php _e( 'Validation of your Envato purchase code failed.', 'wpbp' ); ?></p></div>
				<div id="tav-license-status-ajaxfail"><p class="tav-license-status"><?php _e( 'We were not able to check your Envato purchase code. Please try again later.', 'wpbp' ); ?></p></div>
			</div>
		<?php break;

		case 'smalltext': ?>
			<input type="text" name="<?php echo $option['group'].'['.$option['name'].']'; ?>" id="<?php echo $prefix . '_' . $option['name']; ?>" value="<?php echo $current; ?>" class="small-text" />
			<?php if( isset($option['desc']) && $option['desc'] != '' ): ?><p class="description"><?php echo $option['desc']; ?></p><?php endif; ?>
		<?php break;

		case 'file_upload': ?>
			<input type="text" class="regular-text tav-file-upload" name="<?php echo $option['group'].'['.$option['name'].']'; ?>" id="<?php echo $prefix . '_' . $option['name']; ?>" value="<?php echo $current; ?>" /> 
			<input class="button tav-file-upload-button" id="<?php echo $prefix . '_' . $option['name']; ?>_upload" value="<?php _e( 'Upload', 'wpbp' ); ?>" type="button" data-tav-uploader-title="<?php _e( 'Select a file', 'wpbp' ); ?>" data-tav-uploader-button-text="<?php _e( 'Insert', 'wpbp' ); ?>">
			<?php if( isset($option['desc']) && $option['desc'] != '' ): ?><p class="description"><?php echo $option['desc']; ?></p><?php endif; ?>
		<?php break;

		case 'image_upload': ?>
			<input type="text" class="regular-text tav-file-upload" name="<?php echo $option['group'].'['.$option['name'].']'; ?>" id="<?php echo $prefix . '_' . $option['name']; ?>" value="<?php echo $current; ?>" /> 
			<input class="button tav-file-upload-button" id="<?php echo $prefix . '_' . $option['name']; ?>_upload" value="<?php _e( 'Upload', 'wpbp' ); ?>" type="button" data-tav-uploader-title="<?php _e( 'Select a file', 'wpbp' ); ?>" data-tav-uploader-button-text="<?php _e( 'Insert', 'wpbp' ); ?>">
			<?php if( isset($option['desc']) && $option['desc'] != '' ): ?><p class="description"><?php echo $option['desc']; ?></p><?php endif; ?>
			<?php if( '' != $current ): ?><br/><br/><img src="<?php echo $current; ?>" /><?php endif; ?>

		<?php break;

		case 'numeric': ?>
			<input type="text" name="<?php echo $option['group'].'['.$option['name'].']'; ?>" id="<?php echo $prefix . '_' . $option['name']; ?>" value="<?php echo $current; ?>" class="small-text" pattern="^(0|[1-9][0-9]*)$" />
			<?php if( isset($option['desc']) && $option['desc'] != '' ): ?><p class="description"><?php echo $option['desc']; ?></p><?php endif; ?>
		<?php break;

		case 'colorpicker': ?>
			<input type="text" id="<?php echo $prefix . '_' . $option['name']; ?>" name="<?php echo $option['group'].'['.$option['name'].']'; ?>" class="tav-colorpicker" value="<?php echo $current; ?>" />
			<?php if( isset($option['desc']) && $option['desc'] != '' ): ?><p class="description"><?php echo $option['desc']; ?></p><?php endif; ?>
		<?php break;

		case 'email':
			$value = get_option($prefix.$option['name'], ''); ?>
			<input type="email" name="<?php echo $option['group'].'['.$option['name'].']'; ?>" id="<?php echo $prefix . '_' . $option['name']; ?>" value="<?php echo $current; ?>" class="regular-text" />
			<?php if( isset($option['desc']) && $option['desc'] != '' ): ?><p class="description"><?php echo $option['desc']; ?></p><?php endif; ?>
		<?php break;

		case 'radio':
			$value = get_option($prefix.$option['name'], array()); ?>
			<?php foreach( $option['options'] as $val => $choice ):
				if( $val == $current )
					$selected = 'checked';
				else
					$selected = ''; ?>
				<label for="<?php echo $prefix.$option['name'].$choice; ?>">
					<input type="radio" name="<?php echo $option['group'].'['.$option['name'].']'; ?>" value="<?php echo $val; ?>" id="<?php echo $prefix.$option['name'].$choice; ?>" <?php echo $selected; ?> />
					<?php echo $choice; ?>
				</label>
				<br class="n2_clear"/>
			<?php endforeach; ?>
			<?php if( isset($option['desc']) && $option['desc'] != '' ): ?><p class="description"><?php echo $option['desc']; ?></p><?php endif; ?>
		<?php break;

		case 'checkbox':
			$value = get_option($prefix.$option['name'], array()); ?>
			<?php foreach( $option['options'] as $val => $choice ):
				if( is_array( $current ) && in_array( $val, $current ) )
					$selected = 'checked="checked"';
				else
					$selected = ''; ?>
				<label for="<?php echo $prefix.$option['name'].$choice; ?>">
					<input type="checkbox" name="<?php echo $option['group'].'['.$option['name'].']'; ?>[]" value="<?php echo $val; ?>" id="<?php echo $prefix.$option['name'].$choice; ?>" <?php echo $selected; ?> />
					<?php echo $choice; ?>
				</label>
				<br class="n2_clear"/>
			<?php endforeach; ?>
			<?php if( isset($option['desc']) && $option['desc'] != '' ): ?><p class="description"><?php echo $option['desc']; ?></p><?php endif; ?>
		<?php break;

		case 'dropdown': ?>
			<label for="<?php echo $prefix . '_' . $option['name']; ?>">
				<select name="<?php echo $option['group'].'['.$option['name'].']'; ?>" id="<?php echo $prefix . '_' . $option['name']; ?>">

					<?php foreach( $option['options'] as $val => $choice ):
					if( $val == $current )
						$selected = 'selected="selected"';
					else
						$selected = ''; ?>
					<option value="<?php echo $val; ?>" <?php echo $selected; ?>><?php echo $choice; ?></option>

				<?php endforeach; ?>

				</select>
			</label>
			<?php if( isset($option['desc']) && $option['desc'] != '' ): ?><p class="description"><?php echo $option['desc']; ?></p><?php endif; ?>
		<?php break;

		case 'textarea':
			if( !$current && isset($option['std']) ) { $current = $option['std']; } ?>
			<textarea name="<?php echo $option['group'].'['.$option['name'].']'; ?>" id="<?php echo $prefix . '_' . $option['name']; ?>" rows="8" cols="70"><?php echo $current; ?></textarea>
			<?php if( isset($option['desc']) && $option['desc'] != '' ): ?><p class="description"><?php echo $option['desc']; ?></p><?php endif; ?>
		<?php break;

		case 'wysiwyg': ?>
			<?php wp_editor( $current, $option['group'].'['.$option['name'].']', array('media_buttons' => false) ); ?>
			<?php if( isset($option['desc']) && $option['desc'] != '' ): ?><p class="description"><?php echo $option['desc']; ?></p><?php endif; ?>
		<?php break;

		case 'button_color': ?>
		<div id="btn-color">
			<button type="button" class="btn btn-default">Default</button>
			<button type="button" class="btn btn-primary">Blue</button>
			<button type="button" class="btn btn-success">Green</button>
			<button type="button" class="btn btn-info">Cyan</button>
			<button type="button" class="btn btn-warning">Orange</button>
			<button type="button" class="btn btn-danger">Red</button>
			<button type="button" class="btn btn-link">Link</button>
		</div>
		<?php break;

	endswitch;
}