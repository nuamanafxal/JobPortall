<?php 


Kirki::add_config( 'html2wp_options', array(
	'capability'    => 'edit_theme_options',
	'option_type'   => 'theme_mod',
) );


//adding panel
Kirki::add_panel( 'panel_id', array(
    'priority'    => 10,
    'title'       => esc_html__( 'Header Settings', 'kirki' ),
    'description' => esc_html__( 'Header and Layout', 'kirki' ),
) );

//secion inside panel fro layout
Kirki::add_section( 'header_layout_settings', array(
    'title'          => esc_html__( 'Layout', 'kirki' ),
    'description'    => esc_html__( 'Manage Header Layout.', 'kirki' ),
    'panel'          => 'panel_id',
    'priority'       => 160,
) );


//general section for menu background
Kirki::add_section( 'menu_settings', array(
    'title'          => esc_html__( 'Menu Settings', 'kirki' ),
    'description'    => esc_html__( 'My Menu Layout and Settings', 'kirki' ),
    'panel'          => 'panel_id',
    'priority'       => 160,
) );


//general section for typography
Kirki::add_section( 'typography_settings', array(
    'title'          => esc_html__( 'Typography', 'kirki' ),
    'description'    => esc_html__( 'Text style and options', 'kirki' ),
    'priority'       => 160,
) );



//background setting adding field fro header color change
Kirki::add_field( 'html2wp_options', [
	'type'        => 'background',
	'settings'    => 'background_setting',
	'label'       => esc_html__( 'Background Control', 'kirki' ),
	'description' => esc_html__( 'Background conrols are pretty complex - but extremely useful if properly used.', 'kirki' ),
	'section'     => 'header_layout_settings',
	'default'     => [
		'background-color'      => 'rgba(20,20,20,.8)',
		'background-image'      => '',
		'background-repeat'     => 'repeat',
		'background-position'   => 'center center',
		'background-size'       => 'cover',
		'background-attachment' => 'scroll',
	],
	'transport'   => 'auto',
	'output'      => [
		[
			'element' => '#header',
		],
	],
] );


//menu background
//background setting adding field fro menu baclground
Kirki::add_field( 'html2wp_options', [
	'type'        => 'background',
	'settings'    => 'menu_setting',
	'label'       => esc_html__( 'typography Background', 'kirki' ),
	'description' => esc_html__( '', 'kirki' ),
	'section'     => 'menu_settings',
	'default'     => [
		'background-color'      => 'rgba(20,20,20,.8)',
		'background-image'      => '',
		'background-repeat'     => 'repeat',
		'background-position'   => 'center center',
		'background-size'       => 'cover',
		'background-attachment' => 'scroll',
	],
	'transport'   => 'auto',
	'output'      => [
		[
			'element' => 'body',
		],
	],
] );



//field for typography

Kirki::add_field( 'html2wp_options', [
	'type'        => 'typography',
	'settings'    => 'heading_setting',
	'label'       => esc_html__( 'Headings', 'kirki' ),
	'section'     => 'typography_settings',
	'default'     => [
		'font-family'    => 'Roboto',
		'variant'        => 'regular',
		'font-size'      => '14px',
		'line-height'    => '1.5',
		'letter-spacing' => '0',
		'color'          => '#333333',
		'text-transform' => 'none',
		'text-align'     => 'left',
    ],
    
    'choices' => [
        'fonts' => [
            'google'   => [ 'popularity', 50 ],
            'standard' => [
                'Georgia,Times,"Times New Roman",serif',
                'Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif',
            ],
        ],
    ],

	'priority'    => 10,
	'transport'   => 'auto',
	'output'      => [
		[
			'element' => 'h1, h2, h3, h4, h5',
		],
	],
] );



?>