<?php
function get_coolsyntax_languages() {

	$languages = array(
		'markup'       => 'Markup',
		'css'          => 'CSS',
		'javascript'   => 'JavaScript',
		'java'         => 'Java',
		'php'          => 'PHP',
		'coffeescript' => 'CoffeeScript',
		'scss'         => 'Sass (Scss)',
		'bash'         => 'Bash',
		'c'            => 'C',
		'c++'          => 'C++',
		'python'       => 'Python',
		'sql'          => 'SQL',
		'groov'        => 'Groov',
		'http'         => 'HTTP',
		'ruby'         => 'Ruby',
		'gherkin'      => 'Gherkin',
		'csharp'       => 'C#',
		'go'           => 'Go',
	);

	return apply_filters( 'coolsyntax_languages', $languages );

}

function coolsyntax_get_plugin_options() {

	$plugins = array(
		'line_highlight'    => __( 'Line Highlight', 'coolsyntax' ),
		'line_numbers'      => __( 'Line Numbers', 'coolsyntax' ),
		'show_invisibles'   => __( 'Show Invisibles', 'coolsyntax' ),
		'autolinker'        => __( 'Autolinker', 'coolsyntax' ),
		'webplateform_docs' => __( 'WebPlatform Docs', 'coolsyntax' ),
		'file_highlight'    => __( 'File Highlight', 'coolsyntax' ),
	);

	$options = array(
		array(
			'id'      => 'coolsyntax_general',
			'title'   => __('General Settings', 'coolsyntax'),
			'options' => array(
				array(
					'id'    => 'theme',
					'title' => __( 'Theme', 'coolsyntax' ),
					'desc'  => __( 'How should the highlighted code look like?', 'coolsyntax' ),
					'type'  => 'dropdown',
					'opts'  => array(
						'prism'    => __( 'Prism', 'coolsyntax' ),
						'coy'      => __( 'Coy', 'coolsyntax' ),
						'dark'     => __( 'Dark', 'coolsyntax' ),
						'funky'    => __( 'Funky', 'coolsyntax' ),
						'okaidia'  => __( 'Okaidia', 'coolsyntax' ),
						'tomorrow' => __( 'Tomorrow', 'coolsyntax' ),
						'twilight' => __( 'Twilight', 'coolsyntax' ),
					)
				),
				array(
					'id'    => 'plugins',
					'title' => __( 'Plugins', 'coolsyntax' ),
					'desc'  => __( 'This is if you need extra features.', 'coolsyntax' ),
					'type'  => 'checkbox',
					'opts'  => apply_filters( 'coolsyntax_prism_plugins_list', $plugins )
				),
				array(
					'id'    => 'favorite',
					'title' => __( 'Favorite Language', 'coolsyntax' ),
					'desc'  => __( 'We\'ll add shortcuts to your favorite languages.', 'coolsyntax' ),
					'type'  => 'checkbox',
					'opts'  => get_coolsyntax_languages()
				),
			),
		),		
	);

	$options = apply_filters( 'coolsyntax_edit_plugin_options', $options );

	return $options;
}