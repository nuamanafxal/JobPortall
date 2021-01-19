<?php
namespace ACFFrontend\Module\Actions;

use ACFFrontend\Plugin;
use ACFFrontend\Module;
use ACFFrontend\Module\Classes\ActionBase;
use ACFFrontend\Module\Widgets;
use Elementor\Controls_Manager;
use ElementorPro\Modules\QueryControl\Module as Query_Module;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class ActionUser extends ActionBase {
	
	public function get_name() {
		return 'user';
	}

	public function get_label() {
		return __( 'User', 'acf-frontend-form-element' );
	}

	public function get_fields_display( $form_field, $local_field, $post_id = '' ){
		switch( $form_field[ 'field_type' ] ){
			case 'username':
				$local_field[ 'type' ] = 'text';
				$local_field[ 'disabled' ] = isset( $form_field[ 'allow_edit' ] ) ? ! $form_field[ 'allow_edit' ] : 1;
				$local_field[ 'custom_username' ] = true;
			break;
			case 'password':
				$local_field[ 'type' ] = 'password';
				$local_field[ 'custom_password' ] = true;
			break;				
			case 'confirm_password':
				$local_field[ 'type' ] = 'password';
				if( isset( $local_field[ 'wrapper' ][ 'class' ] ) ){
					$local_field[ 'wrapper' ][ 'class' ] .= ' acfef_password_confirm';
				}else{
					$local_field[ 'wrapper' ][ 'class' ] = 'acfef_password_confirm';
				}
				$local_field[ 'custom_password_confirm' ] = true;
			break;			
			case 'email':
				$local_field[ 'type' ] = 'email';
				$local_field[ 'custom_email' ] = true;
			break;
			case 'first_name':
				$local_field[ 'type' ] = 'text';
				$local_field[ 'custom_first_name' ] = true;
			break;
			case 'last_name':
				$local_field[ 'type' ] = 'text';
				$local_field[ 'custom_last_name' ] = true;
			break;					
			case 'nickname':
				$local_field[ 'type' ] = 'text';
				$local_field[ 'custom_nickname' ] = true;
			break;				
			case 'display_name':
				$local_field[ 'type' ] = 'text';
				$local_field[ 'custom_display_name' ] = true;
				if( strpos( $post_id, 'user_' ) !== false ){
					$user_id = explode( '_', $post_id )[1];
					$edit_user = get_user_by( 'ID', $user_id );
					if( $edit_user ){
						$choices = [ 
							$edit_user->user_login,
							$edit_user->user_email,
							$edit_user->first_name,
							$edit_user->last_name,
							$edit_user->first_name . ' ' . $edit_user->last_name,
							$edit_user->nickname,	
						];
						$local_field[ 'choices' ] = [];
						foreach( $choices as $choice ){
							$local_field[ 'choices' ][ $choice ] = $choice; 
						}
						$local_field[ 'type' ] = 'radio';
						$local_field[ 'other_choice' ] = true;
						$local_field[ 'default_value' ] = $edit_user->display_name;
						$local_field[ 'value' ] = $edit_user->display_name;
					}
				}
			break;			
			case 'bio':
				$local_field[ 'type' ] = 'textarea';
				$local_field[ 'custom_user_bio' ] = true;
			break;
			case 'role':
				$roles = [];
				if( isset( $form_field[ 'role_field_options' ] ) ){
					foreach( $form_field[ 'role_field_options' ] as $role_option ){
						$roles[ $role_option ] = ucwords( $role_option );
					}
				}
				$local_field[ 'type' ] = 'select';
				$local_field[ 'choices' ] = $roles;
				$local_field[ 'default_value' ] = isset( $form_field[ 'default_role' ] ) ? $form_field[ 'default_role' ] : 'subscriber';
				$local_field[ 'custom_user_role' ] = true;
			break;
			
		}
		return $local_field;
	}
	

	public function register_settings_section( $widget ) {
		
					
		$widget->start_controls_section(
			'section_edit_user',
			[
				'label' => $this->get_label(),
				'tab' => Controls_Manager::TAB_CONTENT,
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'main_action',
							'operator' => 'in',
							'value' => [ 'new_user', 'edit_user' ],
						],	
						
					],
				],
			]
		);
		
		$widget->add_control(
			'user_settings',
			[
				'label' => __( 'User Settings', 'acf-frontend-form-element' ),
				'type' => \Elementor\Controls_Manager::HEADING,
			]
		);

		$this->action_controls( $widget );
				
		$widget->end_controls_section();
	}
	
	
	public function action_controls( $widget, $step = false ){
		$condition = [
			'main_action' => 'edit_user',
		];
		if( $step ){
			$condition[ 'field_type' ] = 'step';
			$condition[ 'overwrite_settings' ] = 'true';
		}

		$widget->add_control(
			'user_to_edit',
			[
				'label' => __( 'User To Edit', 'acf-frontend-form-element' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'current_user',
				'options' => [
					'current_user'  => __( 'Current User', 'acf-frontend-form-element' ),
					'url_query' => __( 'URL Query', 'acf-frontend-form-element' ),
					'select_user' => __( 'Select User', 'acf-frontend-form-element' ),
				],
				'condition' => $condition,
			]
		);
		$condition[ 'user_to_edit' ] = 'url_query';
		$widget->add_control(
			'url_query_user',
			[
				'label' => __( 'URL Query', 'acf-frontend-form-element' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'user_id', 'acf-frontend-form-element' ),
				'default' => __( 'user_id', 'acf-frontend-form-element' ),
				'description' => __( 'Enter the URL query parameter containing the id of the user you want to edit', 'acf-frontend-form-element' ),
				'condition' => $condition,
			]
		);	
		$condition[ 'user_to_edit' ] = 'select_user';
		if( ! class_exists( 'ElementorPro\Modules\QueryControl\Module' ) ){		
			$widget->add_control(
				'user_select',
				[
					'label' => __( 'User', 'acf-frontend-form-element' ),
					'type' => Controls_Manager::TEXT,
					'placeholder' => __( '18', 'acf-frontend-form-element' ),
					'default' => get_current_user_id(),
					'description' => __( 'Enter user id', 'acf-frontend-form-element' ),
					'condition' => $condition,
				]
			);		
		}else{			
			$widget->add_control(
				'user_select',
				[
					'label' => __( 'User', 'acf-frontend-form-element' ),
					'label_block' => true,
					'type' => Query_Module::QUERY_CONTROL_ID,
					'autocomplete' => [
						'object' => Query_Module::QUERY_OBJECT_USER,
						'display' => 'detailed',
					],				
					'default' => get_current_user_id(),
					'condition' => $condition,
				]
			);
		}

		unset( $condition[ 'user_to_edit' ] );
		$condition[ 'main_action' ] = 'new_user';

		$widget->add_control(
			'username_default',
			[
				'label' => __( 'Default Username', 'acf-frontend-form-element' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'generate',
				'options' => [
					'generate' => __( 'Generate Random Number', 'acf-frontend-form-element' ),
					'id' => __( 'Generate From ID', 'acf-frontend-form-element' )
				],
				'description' => __( 'Will be overwritten if your form has a "Username" field', 'acf-frontend-form-element' ),
				'condition' => $condition,
			]
		);
		$widget->add_control(
			'username_prefix',
			[
				'label' => __( 'Username Prefix', 'acf-frontend-form-element' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'user_',
				'description' => __( 'Please enter only lowercase latin letters, numbers, @, -, . and _', 'acf-frontend-form-element' ),
				'condition' => $condition,
			]
		);
		$widget->add_control(
			'username_suffix',
			[
				'label' => __( 'Username Suffix', 'acf-frontend-form-element' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => __( 'Please enter only lowercase latin letters, numbers, @, -, . and _', 'acf-frontend-form-element' ),
				'condition' => $condition,
			]
		);
		$widget->add_control(
			'display_name_default',
			[
				'label' => __( 'Default Display Name', 'acf-frontend-form-element' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'user_login',
				'options' => [
					'default' => __( 'Default', 'acf-frontend-form-element' ),
					'user_login' => __( 'Username', 'acf-frontend-form-element' ),
					'user_email' => __( 'Email', 'acf-frontend-form-element' ),
					'first_name' => __( 'First Name', 'acf-frontend-form-element' ),
					'last_name' => __( 'Last Name', 'acf-frontend-form-element' ),
					'first_last' => __( 'First and Last Name', 'acf-frontend-form-element' ),
					'nickname' => __( 'Nickname', 'acf-frontend-form-element' ),
				],
				'description' => __( 'Will be overwritten if your form has a "Display Name" field', 'acf-frontend-form-element' ),
				'condition' => $condition,
			]
		);

		$widget->add_control(
			'new_user_role',
			[
				'label' => __( 'New User Role', 'acf-frontend-form-element' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'label_block' => true,
				'default' => 'subscriber',
				'options' => acfef_get_user_roles( [ 'administrator' ] ),
				'condition' => $condition,
			]
		);
		
		$widget->add_control(
			'hide_admin_bar',
			[
				'label' => __( 'Hide WordPress Admin Area?', 'acf-frontend-form-element' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Hide', 'acf-frontend-form-element' ),
				'label_off' => __( 'Show','acf-frontend-form-element' ),
				'return_value' => 'true',
				'condition' => $condition,
			]
		);
		
		$widget->add_control(
			'login_user',
			[
				'label' => __( 'Log in as new user?', 'acf-frontend-form-element' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'acf-frontend-form-element' ),
				'label_off' => __( 'No','acf-frontend-form-element' ),
				'return_value' => 'true',
				'condition' => $condition,			
			]
		);			
		
		$condition[ 'main_action' ] = [ 'new_user', 'edit_user' ];

		$widget->add_control(
			'user_manager',
			[
				'label' => __( 'Managing User', 'acf-frontend-form-element' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none' => __( 'No Manager','acf-frontend-form-element' ),
					'current_user' => __( 'Current User','acf-frontend-form-element' ),
					//'current_author' => __( 'Current Post Author','acf-frontend-form-element' ),
					'select_user' => __( 'Select User','acf-frontend-form-element' ),
				],
				'description' => __( 'Who will be in charge of editing this user\'s data?', 'acf-frontend-form-element' ),
				'condition' => $condition,
			]
		);
		$condition[ 'user_manager' ] = 'select_user';
		if( ! class_exists( 'ElementorPro\Modules\QueryControl\Module' ) ){		
			$widget->add_control(
				'manager_select',
				[
					'label' => __( 'User', 'acf-frontend-form-element' ),
					'type' => Controls_Manager::TEXT,
					'placeholder' => __( '18', 'acf-frontend-form-element' ),
					'default' => get_current_user_id(),
					'description' => __( 'Enter user id', 'acf-frontend-form-element' ),
					'condition' => $condition,
				]
			);		
		}else{			
			$widget->add_control(
				'manager_select',
				[
					'label' => __( 'User', 'acf-frontend-form-element' ),
					'label_block' => true,
					'type' => Query_Module::QUERY_CONTROL_ID,
					'autocomplete' => [
						'object' => Query_Module::QUERY_OBJECT_USER,
						'display' => 'detailed',
					],				
					'default' => get_current_user_id(),
					'condition' => $condition,
				]
			);
		}
		
	}
		
	public function run( $post_id, $settings, $step = false ){
		if( 'edit_user' == $settings[ 'main_action' ] || $post_id != 'user_0' ) return $post_id; 
		
		$username_generated = false;
		$user_to_insert = [];								 
		
		if( 'new_user' == $settings[ 'main_action' ] ){
			
			if( isset( $_POST[ 'custom_username' ] ) ){ 
				$user_to_insert[ 'user_login' ] = $_POST[ 'acf' ][ $_POST[ 'custom_username' ] ];	
				unset( $_POST[ 'acf' ][ $_POST[ 'custom_username' ] ] );		
			}else{
				$prefix = sanitize_title( $settings[ 'username_prefix' ] );
				$suffix = sanitize_title( $settings[ 'username_suffix' ] );
				$user_to_insert[ 'user_login' ] = $this->acfef_generate_username( $prefix, $suffix );
				$username_generated = true;
			}

			if( isset( $_POST[ 'custom_email' ] ) ){ 
				$user_to_insert[ 'user_email' ] = $_POST[ 'acf' ][ $_POST[ 'custom_email' ] ];	
				unset( $_POST[ 'acf' ][ $_POST[ 'custom_email' ] ] );
			}

			if( isset( $_POST[ 'custom_password' ] ) ){ 
				$user_to_insert[ 'user_pass' ] = $_POST[ 'acf' ][ $_POST[ 'custom_password' ] ];
				unset( $_POST[ 'acf' ][ $_POST[ 'custom_password' ] ] );
				if( isset( $_POST[ 'custom_password_confirm' ] ) ){
					unset( $_POST[ 'acf' ][ $_POST[ 'custom_password_confirm' ] ] );
				}
			}else{
				$user_to_insert[ 'user_pass' ] = wp_generate_password();
			}	
			
			$user_to_insert[ 'role' ] = $settings[ 'new_user_role' ];
			$user_to_insert[ 'show_admin_bar_front' ] = $settings[ 'hide_admin_bar' ];

			if( isset( $_POST[ 'custom_user_role' ] ) ){ 
				$user_to_insert[ 'role' ] = $_POST[ 'acf' ][ $_POST[ 'custom_user_role' ] ];	
				unset( $_POST[ 'acf' ][ $_POST[ 'custom_user_role' ] ] );				
			}
			
			$user_to_insert = apply_filters( 'acfef/user_fields_save', $user_to_insert, $settings );
			
			$user_id = wp_insert_user( $user_to_insert );  

			if( $username_generated && $settings[ 'username_default' ] == 'id' ){
				$prefix = sanitize_title( $settings[ 'username_prefix' ] );
				$suffix = sanitize_title( $settings[ 'username_suffix' ] );
				$new_username = sprintf( '%s%s%s', $prefix, $user_id, $suffix );
				if ( ! username_exists( $new_username ) ) {
					global $wpdb;
					$wpdb->update( $wpdb->users, array( 'user_login' => $new_username ), [ 'ID' => $user_id ] );
					update_user_meta( $user_id, 'nickname', $new_username );
					wp_update_user( [ 'ID' => $user_id, 'display_name' => $new_username ] );
				}
				
			}

			if ( ! is_wp_error( $user_id ) ) {
				update_user_meta( $user_id, 'hide_admin_area', $settings[ 'hide_admin_bar' ] );
				if( isset( $_POST[ '_acf_element_id' ] ) ){
					update_user_meta( $user_id, 'acfef_form_source', $_POST[ '_acf_element_id' ] );
				}
				if( $settings[ 'login_user' ] ){
					$user_login = $user_to_insert[ 'user_login' ];
					wp_set_current_user( $user_id, $user_login );
					wp_set_auth_cookie( $user_id );
				}
				$_POST[ 'acfef_registered_user' ] = 1;
				return 'user_' . $user_id;
			}else{	
				return '-1';
			}
		}
	}  
	
	public function acfef_generate_username( $prefix, $suffix ) {	
		static $i;
		if ( null === $i ) {
			$i = 1;
		} else {
			$i ++;
		}
		$new_username = sprintf( '%s%s%s', $prefix, $i, $suffix );
		if ( ! username_exists( $new_username ) ) {
			return $new_username;
		} else {
			return $this->acfef_generate_username( $prefix, $suffix );
		}
	}
	
}
