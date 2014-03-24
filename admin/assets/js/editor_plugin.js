(function($) {
	tinymce.create(
		'tinymce.plugins.myPlugin', {
			/**
			 * @param tinymce.Editor editor
			 * @param string url
			 */
			init: function(ed, url) {
				/**
				 *  register a new button
				 */

				///////////////////////////////////////////////////////////////////////////
				// http://www.tinymce.com/wiki.php/Tutorial:Migration_guide_from_3.x //
				///////////////////////////////////////////////////////////////////////////
				ed.addButton(
					'coolsyntax_button', {
						cmd: 'my_plugin_button_cmd',
						title: ed.getLang('myPlugin.buttonTitle', 'Add Code'),
						image: url + '/button.png',
						onPostRender: function() {
							var ctrl = this;

							///////////////////////////////////////
							// Allow editing of selection //
							///////////////////////////////////////
							ed.on('NodeChange', function(e) {
								// console.log(e.element);
								ctrl.active(e.element.nodeName == 'PRE');
								if(e.element.nodeName == 'PRE') {
									console.log(e.element);
									// e.element.className += ' pre-active';
									// $(e.element).addClass('active');
								}
								else {
									e.element.classList.remove('pre-active');
									// e.element.removeClass('active');
								}
							});
						}
					}
				);

				/**
				 * and a new command
				 */

				ed.addCommand(
					'my_plugin_button_cmd',
					function() {
						// triggers the thickbox
						var width = jQuery(window).width(),
							H = jQuery(window).height(),
							W = (720 < width) ? 720 : width;
						W = W - 80;
						H = H - 84;
						tb_show('Insert Code', '#TB_inline?width=' + W + '&height=400&inlineId=coolsyntax-dialog');
					}
				);

			}
		});

	// register plugin
	tinymce.PluginManager.add('coolsyntax', tinymce.plugins.myPlugin);

})();