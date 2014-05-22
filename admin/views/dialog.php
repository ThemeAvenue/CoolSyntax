<?php
/**
 * Get values
 */
$favorites = coolsyntax_get_option( 'favorite', array() );
$languages = get_coolsyntax_languages();
?>
<div style="display: none;">
	<form id="coolsyntax-dialog" action="#">
		<table class="wpcs-dialog-table" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td>
					<div class="wpcs-lang-select">
						<label for="cs-language" class="label"><?php _e( 'Choose Language', 'coolsyntax' ); ?></label>
						<select id="cs-language" name="cs-lang" data-orig-value="default" data-value="default">
							<?php
							if( is_array( $languages ) && !empty( $languages ) ) {
								foreach( $languages as $language => $label ) {
									echo "<option value='$language'>$label</option>";
								}
							}
							?>
						</select>
					</div>
				</td>
				<td>
					<div class="wpcs-lang-favorite">
						<div class="label"><?php _e( 'Favorites', 'coolsyntax' ); ?>:</div>
						<?php
						foreach( $favorites as $key => $favorite ):
							if( !isset( $languages[$favorite] ) )
								continue; ?>
						
							<button title="<?php echo $favorite; ?>"><?php echo $languages[$favorite]; ?></button>

						<?php endforeach; ?>
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<textarea class="wpcs-textarea" id="cs-code" name="cs-code" rows="10" placeholder="Paste your code here, or type it in manually."></textarea>
				</td>
			</tr>
		</table>

		<div>
			<div style="float: left">
				<input type="button" class="button-secondary" id="cancel" name="cancel" value="<?php _e( 'Cancel', 'coolsyntax' ); ?>" onclick="self.parent.tb_remove();return false" />
			</div>

			<div style="float: right">
				<input type="submit" class="wpcs-insert-code button-primary" id="insert" name="insert" value="<?php _e( 'Insert', 'coolsyntax' ); ?>" />
			</div>
		</div>
	</form>
</div>