<?php

$stag_shortcodes['button'] = array(
	'no_preview' => true,
	'params' => array(
		'url' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Button URL', 'stag' ),
			'desc' => __( 'Add the button\'s url e.g. http://example.com', 'stag' )
		),
		'style' => array(
			'type' => 'select',
			'label' => __( 'Button Style', 'stag' ),
			'desc' => __( 'Select the button\'s style, ie the button\'s colour', 'stag' ),
			'options' => array(
				'grey' => __( 'Grey', 'stag' ),
				'black' => __( 'Black', 'stag' ),
				'green' => __( 'Green', 'stag' ),
				'light-blue' => __( 'Light Blue', 'stag' ),
				'blue' => __( 'Blue', 'stag' ),
				'red' => __( 'Red', 'stag' ),
				'orange' => __( 'Orange', 'stag' ),
				'purple' => __( 'Purple', 'stag' )
			)
		),
		'size' => array(
			'type' => 'select',
			'label' => __( 'Button Size', 'stag' ),
			'desc' => __( 'Select the button\'s size', 'stag' ),
			'options' => array(
				'small' => __( 'Small', 'stag' ),
				'medium' => __( 'Medium', 'stag' ),
				'large' => __( 'Large', 'stag' )
			)
		),
		'type' => array(
			'type' => 'select',
			'label' => __( 'Button Type', 'stag' ),
			'desc' => __( 'Select the button\'s type', 'stag' ),
			'options' => array(
				'round' => __( 'Round', 'stag' ),
				'square' => __( 'Square', 'stag' )
			)
		),
		'target' => array(
			'type' => 'select',
			'label' => __( 'Button Target', 'stag' ),
			'desc' => __( '_self = open in same window. _blank = open in new window', 'stag' ),
			'options' => array(
				'_self' => __( '_self', 'stag' ),
				'_blank' => __( '_blank', 'stag' )
			)
		),
		'content' => array(
			'std' => 'Button Text',
			'type' => 'text',
			'label' => __( 'Button\'s Text', 'stag' ),
			'desc' => __( 'Add the button\'s text', 'stag' ),
		)
	),
	'shortcode' => '[stag_button url="{{url}}" style="{{style}}" size="{{size}}" type="{{type}}" target="{{target}}"]{{content}}[/stag_button]',
	'popup_title' => __('Insert Button Shortcode', 'stag')
);


$stag_shortcodes['alert'] = array(
	'no_preview' => true,
	'params' => array(
		'style' => array(
			'type' => 'select',
			'label' => __('Alert Style', 'stag'),
			'desc' => __('Select the alert\'s style, ie the alert colour', 'stag'),
			'options' => array(
				'white' => __( 'White', 'stag' ),
				'grey' => __( 'Grey', 'stag' ),
				'red' => __( 'Red', 'stag' ),
				'yellow' => __( 'Yellow', 'stag' ),
				'green' => __( 'Green', 'stag' ),
				'blue' => __( 'Blue', 'stag' )
			)
		),
		'content' => array(
			'std' => 'Your Alert!',
			'type' => 'textarea',
			'label' => __('Alert Text', 'stag'),
			'desc' => __('Add the alert\'s text', 'stag')
		)
	),
	'shortcode' => '[stag_alert style="{{style}}"]{{content}}[/stag_alert]',
	'popup_title' => __('Insert Alert Shortcode', 'stag')
);

$stag_shortcodes['toggle'] = array(
	'no_preview' => true,
	'params' => array(
		'title' => array(
			'type' => 'text',
			'label' => __('Toggle Content Title', 'stag'),
			'desc' => __('Add the title that will go above the toggle content', 'stag'),
			'std' => 'Title'
		),
		'content' => array(
			'std' => 'Content',
			'type' => 'textarea',
			'label' => __('Toggle Content', 'stag'),
			'desc' => __('Add the toggle content. Will accept HTML', 'stag'),
		),
		'state' => array(
			'type' => 'select',
			'label' => __('Toggle State', 'stag'),
			'desc' => __('Select the state of the toggle on page load', 'stag'),
			'options' => array(
				'open' => __( 'Open', 'stag' ),
				'closed' => __( 'Closed', 'stag' )
			)
		),
	),
	'shortcode' => '[stag_toggle title="{{title}}" state="{{state}}"]{{content}}[/stag_toggle]',
	'popup_title' => __('Insert Toggle Content Shortcode', 'stag')
);

$stag_shortcodes['columns'] = array(
	'params' => array(),
	'shortcode' => ' {{child_shortcode}} ', // as there is no wrapper shortcode
	'popup_title' => __('Insert Columns Shortcode', 'stag'),
	'no_preview' => true,
	
	// child shortcode is clonable & sortable
	'child_shortcode' => array(
		'params' => array(
			'column' => array(
				'type' => 'select',
				'label' => __('Column Type', 'stag'),
				'desc' => __('Select the type, ie width of the column.', 'stag'),
				'options' => array(
					'stag_one_third' => __( 'One Third', 'stag' ),
					'stag_one_third_last' => __( 'One Third Last', 'stag' ),
					'stag_two_third' => __( 'Two Thirds', 'stag' ),
					'stag_two_third_last' => __( 'Two Thirds Last', 'stag' ),
					'stag_one_half' => __( 'One Half', 'stag' ),
					'stag_one_half_last' => __( 'One Half Last', 'stag' ),
					'stag_one_fourth' => __( 'One Fourth', 'stag' ),
					'stag_one_fourth_last' => __( 'One Fourth Last', 'stag' ),
					'stag_three_fourth' => __( 'Three Fourth', 'stag' ),
					'stag_three_fourth_last' => __( 'Three Fourth Last', 'stag' ),
					'stag_one_fifth' => __( 'One Fifth', 'stag' ),
					'stag_one_fifth_last' => __( 'One Fifth Last', 'stag' ),
					'stag_two_fifth' => __( 'Two Fifth', 'stag' ),
					'stag_two_fifth_last' => __( 'Two Fifth Last', 'stag' ),
					'stag_three_fifth' => __( 'Three Fifth', 'stag' ),
					'stag_three_fifth_last' => __( 'Three Fifth Last', 'stag' ),
					'stag_four_fifth' => __( 'Four Fifth', 'stag' ),
					'stag_four_fifth_last' => __( 'Four Fifth Last', 'stag' ),
					'stag_one_sixth' => __( 'One Sixth', 'stag' ),
					'stag_one_sixth_last' => __( 'One Sixth Last', 'stag' ),
					'stag_five_sixth' => __( 'Five Sixth', 'stag' ),
					'stag_five_sixth_last' => __( 'Five Sixth Last', 'stag' )
				)
			),
			'content' => array(
				'std' => '',
				'type' => 'textarea',
				'label' => __('Column Content', 'stag'),
				'desc' => __('Add the column content.', 'stag'),
			)
		),
		'shortcode' => '[{{column}}]{{content}}[/{{column}}] ',
		'clone_button' => __('Add Column', 'stag')
	)
);

$stag_shortcodes['divider'] = array(
	'no_preview' => true,
	'params' => array(
		'style' => array(
			'type' => 'select',
			'label' => __( 'Divider', 'stag' ),
			'desc' => __( 'Select the style of the Divider', 'stag' ),
			'options' => array(
				'plain' => __( 'Plain', 'stag' ),
				'strong' => __( 'Strong', 'stag' ),
				'double' => __( 'Double', 'stag' ),
				'dashed' => __( 'Dashed', 'stag' ),
				'dotted' => __( 'Dotted', 'stag' )
				)
			),
		),
	'shortcode' => '[stag_divider style="{{style}}"]',
	'popup_title' => __( 'Insert Divider', 'stag' )
);

$stag_shortcodes['intro'] = array(
	'no_preview' => true,
	'params' => array(
		'content' => array(
			'type' => 'textarea',
			'label' => __( 'Intro Text', 'stag' ),
			'desc' => __( 'Enter the intro text.', 'stag' ),
			'std' => 'Intro Text'
		),
	),
	'shortcode' => '[stag_intro]{{content}}[/stag_intro]',
	'popup_title' => __( 'Insert Author Shortcode', 'stag' )
);

$stag_shortcodes['tabs'] = array(
	'params' => array(),
	'no_preview' => true,
	'shortcode' => '[stag_tabs] {{child_shortcode}}  [/stag_tabs]',
	'popup_title' => __( 'Insert Tab Shortcode', 'stag' ),
	'child_shortcode' => array(
		'params' => array(
			'title' => array(
				'std' => 'Title',
				'type' => 'text',
				'label' => __( 'Tab Title', 'stag' ),
				'desc' => __( 'Title of the tab', 'stag' ),
			),
			'content' => array(
		    'std' => 'Tab Content',
		    'type' => 'textarea',
		    'label' => __( 'Tab Content', 'stag' ),
		    'desc' => __( 'Add the tabs content', 'stag' )
			)
		),
		'shortcode' => '[stag_tab title="{{title}}"]{{content}}[/stag_tab]',
		'clone_button' => __( 'Add Tab', 'stag' )
	)
);

$stag_shortcodes['dropcap'] = array(
	'no_preview' => true,
	'params' => array(
		'style' => array(
			'type' => 'select',
			'label' => __('Dropcap Style', 'stag'),
			'desc' => __('Select the dropcap\'s style', 'stag'),
			'options' => array(
				'normal' => __( 'Normal', 'stag' ),
				'squared' => __( 'Squared', 'stag' ),
			)
		),
		'content' => array(
			'std' => 'D',
			'type' => 'text',
			'label' => __( 'Dropcap Text', 'stag' ),
			'desc' => __( 'Enter the dropcap\'s text', 'stag' )
		),
		'size' => array(
			'std' => '50px',
			'type' => 'text',
			'label' => __( 'Font Size', 'stag' ),
			'desc' => __( 'Enter the font\'s size in px, em or %', 'stag' ),
		),
	),
	'shortcode' => '[stag_dropcap font_size="{{size}}" style="{{style}}"]{{content}}[/stag_dropcap]',
	'popup_title' => __( 'Insert Dropcap Shortcode', 'stag' )
);

$stag_shortcodes['image'] = array(
	'no_preview' => true,
	'params' => array(
		'src' => array(
			'std' => '',
			'type' => 'image',
			'label' => __( 'Image', 'stag' ),
			'desc' => __( 'Choose your image', 'stag' )
		),
		'style' => array(
			'type' => 'select',
			'label' => __('Image Filter', 'stag'),
			'desc' => __('Select the CSS3 image filter style', 'stag'),
			'options' => array(
				'no-filter' => __( 'No Filter', 'stag' ),
				'grayscale' => __( 'Grayscale', 'stag' ),
				'sepia' => __( 'Sepia', 'stag' ),
				'blur' => __( 'Blur', 'stag' ),
				'hue-rotate' => __( 'Hue Rotate', 'stag' ),
				'contrast' => __( 'Contrast', 'stag' ),
				'brightness' => __( 'Brightness', 'stag' ),
				'invert' => __( 'Invert', 'stag' ),
			)
		),
		'alignment' => array(
			'type' => 'select',
			'label' => __('Alignment', 'stag'),
			'desc' => __('Choose Image Alignment', 'stag'),
			'options' => array(
				'none' => __( 'None', 'stag' ),
				'left' => __( 'Left', 'stag' ),
				'center' => __( 'Center', 'stag' ),
				'right' => __( 'Right', 'stag' )
			)
		),
		'url' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'URL', 'stag' ),
			'desc' => __( 'Enter the URL where image should be linked (optional)', 'stag' )
		)
	),
	'shortcode' => '[stag_image style="{{style}}" src="{{src}}" alignment="{{alignment}}" url="{{url}}"]',
	'popup_title' => __( 'Insert Image Shortcode', 'stag' )
);


$stag_shortcodes['video'] = array(
	'no_preview' => true,
	'params' => array(
		'src' => array(
			'std' => '',
			'type' => 'video',
			'label' => __( 'Choose Video', 'stag' ),
			'desc' => __( 'Either upload a new video, choose an existing video from your media library or link to a video by URL. <br><br>', 'stag' )
					 . sprintf( __('A list of all shortcode video services can be found on %s.<br>', 'stag' ), '<a target="_blank" href="//codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F">WordPress.org</a>.<br><br>Working examples, in case you want to use an external service:<br><strong>http://vimeo.com/18439821</strong><br/><strong>http://www.youtube.com/watch?v=G0k3kHtyoqc</strong>' )
		)
	),
	'shortcode' => '[stag_video src="{{src}}"]',
	'popup_title' => __( 'Insert Video Shortcode', 'stag' )
);


?>