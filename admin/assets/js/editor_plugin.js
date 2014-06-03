(function ($) {
	tinymce.create(
		'tinymce.plugins.coolSyntax', {
			/**
			 * @param tinymce.Editor editor
			 * @param string url
			 */
			init: function (ed, url) {
				/**
				 *  register a new button
				 */

				///////////////////////////////////////////////////////////////////////////
				// http://www.tinymce.com/wiki.php/Tutorial:Migration_guide_from_3.x //
				///////////////////////////////////////////////////////////////////////////
				ed.addButton(
					'coolsyntax_button', {
						cmd: 'my_plugin_button_cmd',
						title: ed.getLang('coolSyntax.buttonTitle', 'Add Code'),
						image: url + '/button.png',
						onPostRender: function () {
							var ctrl = this;

							///////////////////////////////////////
							// Allow editing of selection //
							///////////////////////////////////////
							if (window.tinyMCE) {

								var version = tinymce.majorVersion;

								if (version < 4) {
									/* Old 3.0 API */
									ed.onNodeChange.add(function (ed, cm, node) {
										console.log(e.element);
									});
									ed.onNodeChange.add(function (ed, cm, n) {
										active = ed.formatter.match('my_plugin_button_cmd');
										ctrl = ed.cm.get('coolsyntax_button').setActive(active);
									});

								} else {
									/* New 4.0 API */
									ed.on('NodeChange', function (e) {
										ctrl.active(e.element.nodeName == 'CODE');
										if (e.element.nodeName == 'CODE') {
											if (e.element.parentNode.className !== ' pre-active') {
												ed.dom.removeClass(ed.dom.select('PRE'), 'pre-active');
												e.element.parentNode.className += ' pre-active';
											}
											
											// @TODO: retrieve the code as string and insert into textarea (http://www.tinymce.com/wiki.php/api4:method.tinymce.dom.DOMUtils.getOuterHTML)
											console.log(e.element.parentNode);
											console.log(ed.selection.getNode());

											/*var node = ed.selection.select(ed.dom.select('PRE')[0]);
											var nodeOuterHTML = ed.selection.getContent({
												format: 'text'
											});
											var textarea = document.getElementById('cs-code');
											textarea.value = nodeOuterHTML;*/

											// @TODO: Refresh the auto resize
											// textarea.trigger('autosize.resize');
										} else {
											// @TODO: remove class .pre-active from all nodes (http://www.tinymce.com/wiki.php/api4:method.tinymce.dom.DOMUtils.removeClass)
											ed.dom.removeClass(ed.dom.select('PRE'), 'pre-active');
										}
									});
								}
							}
						}
					}
				);

				/**
				 * and a new command
				 */

				ed.addCommand(
					'my_plugin_button_cmd',
					function () {
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
	tinymce.PluginManager.add('coolsyntax', tinymce.plugins.coolSyntax);

})();