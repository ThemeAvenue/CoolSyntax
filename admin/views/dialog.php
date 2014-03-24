<div style="display: none;">
	<form id="coolsyntax-dialog" action="#">
		<table class="wpcs-dialog-table" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td>
					<div class="wpcs-lang-select">
						<label for="cs-language" class="label"><?php _e( 'Choose Language', 'coolsyntax' ); ?></label>
						<select id="cs-language" name="cs-lang" data-orig-value="default" data-value="default">
							<option value="markup">Markup</option>
							<option value="css">CSS</option>
							<option value="javascript">JavaScript</option>
							<option value="java">Java</option>
							<option value="php">PHP</option>
							<option value="coffeescript">CoffeeScript</option>
							<option value="scss">Sass (Scss)</option>
							<option value="bash">Bash</option>
							<option value="c">C</option>
							<option value="c++">C++</option>
							<option value="python">Python</option>
							<option value="sql">SQL</option>
							<option value="groov">Groov</option>
							<option value="http">HTTP</option>
							<option value="ruby">Ruby</option>
							<option value="gherkin">Gherkin</option>
							<option value="csharp">C#</option>
							<option value="go">Go</option>
						</select>
					</div>
				</td>
				<td>
					<div class="wpcs-lang-favorite">
						<div class="label"><?php _e( 'Favorites', 'coolsyntax' ); ?>:</div>
						<button title="php">PHP</button> <button title="javascript">JavaScript</button>
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