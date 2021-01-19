<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( function_exists('acf_add_local_field') ):

acf_add_local_field(
	array(
		'key' => 'acfef_row_author',
		'label' => __( 'Row Author', 'acf-frontend-form-element' ),
		'name' => 'acfef_row_author',
		'type' => 'text',
	)
);	

endif;

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_acfef_payments',
	'title' => __( 'Payments', 'acf-frontend-form-element' ),
	'acfef_group' => 1,
	'fields' => array(
			array(
				'key' => 'acfef_payment_external_id',
				'label' => __( 'External Id', 'acf-frontend-form-element' ),
				'name' => 'acfef_payment_external_id',
				'type' => 'text',
				'readonly' => '1',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '71',
					'class' => '',
					'id' => '',
				),
			),
			array(
				'key' => 'acfef_payment_user',
				'label' => __( 'User', 'acf-frontend-form-element' ),
				'name' => 'acfef_payment_user',
				'type' => 'text',
				'readonly' => '1',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '71',
					'class' => '',
					'id' => '',
				),
				'role' => '',
				'allow_null' => 0,
				'multiple' => 0,
				'return_format' => 'id',
			),
			array(
				'key' => 'acfef_payment_currency',
				'label' => __( 'Currency', 'acf-frontend-form-element' ),
				'name' => 'acfef_payment_currency',
				'type' => 'text',
				'readonly' => '1',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '30',
					'class' => '',
					'id' => '',
				),
			),
			array(
				'key' => 'acfef_payment_amount',
				'label' => __( 'Amount Charged', 'acf-frontend-form-element' ),
				'name' => 'acfef_payment_amount',
				'type' => 'text',
				'readonly' => '1',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '20',
					'class' => '',
					'id' => '',
				),
				'only_front' => 0,
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
			),			
			array(
				'key' => 'acfef_payment_value',
				'label' => __( 'Post Submissions', 'acf-frontend-form-element' ),
				'name' => 'acfef_payment_value',
				'type' => 'text',
				'readonly' => '1',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '20',
					'class' => '',
					'id' => '',
				),
				'only_front' => 0,
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
			),
			array(
				'key' => 'acfef_payment_method',
				'label' => __( 'Processor', 'acf-frontend-form-element' ),
				'name' => 'acfef_payment_method',
				'type' => 'text',
				'instructions' => '',
				'readonly' => '1',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '31',
					'class' => '',
					'id' => '',
				),
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'acfef_payment',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'seamless',
		'label_placement' => 'left',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'description' => '',
	)
);


endif;