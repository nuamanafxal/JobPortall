<?php
namespace ACFFrontend\Module\Actions;

use ACFFrontend\Plugin;
use ACFFrontend\Module\ACFEF_Module;
use ACFFrontend\Module\Classes\ActionBase;
use ACFFrontend\Module\Widgets;
use Elementor\Controls_Manager;
use ElementorPro\Modules\QueryControl\Module as Query_Module;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class ActionPost extends ActionBase {
	
	public function get_name() {
		return 'post';
	}

	public function get_label() {
		return __( 'Post', 'acf-frontend-form-element' );
	}

	public function get_fields_display( $form_field, $local_field ){
		$field_appearance = isset( $form_field[ 'field_taxonomy_appearance' ] ) ? $form_field[ 'field_taxonomy_appearance' ] : 'checkbox';
		$field_add_term = isset( $form_field[ 'field_add_term' ] ) ? $form_field[ 'field_add_term' ] : 0;

		switch( $form_field[ 'field_type' ] ){
			case 'title':
				$local_field[ 'type' ] = 'text';
				$local_field[ 'custom_title' ] = true;
			break;
			case 'content':
				$local_field[ 'type' ] = 'wysiwyg';
				$local_field[ 'custom_content' ] = true;
			break;
			case 'featured_image':
				$local_field[ 'type' ] = 'image';
				$local_field[ 'custom_featured_image' ] = true;
			break;
			case 'excerpt':
				$local_field[ 'type' ] = 'textarea';
				$local_field[ 'custom_excerpt' ] = true;
			break;
			case 'taxonomy':
				$taxonomy = isset( $form_field[ 'field_taxonomy' ] ) ? $form_field[ 'field_taxonomy' ] : 'category';
				$local_field[ 'type' ] = 'taxonomy';
				$local_field[ 'taxonomy' ] = $taxonomy;
				$local_field[ 'field_type' ] = $field_appearance;
				$local_field[ 'allow_null' ] = 0;
				$local_field[ 'add_term' ] = $field_add_term;
				$local_field[ 'load_terms' ] = 1;
				$local_field[ 'save_terms' ] = 1;
				$local_field[ 'custom_taxonomy' ] = true;
			break;
			case 'categories':
				$local_field[ 'type' ] = 'taxonomy';
				$local_field[ 'taxonomy' ] = 'category';
				$local_field[ 'field_type' ] = $field_appearance;
				$local_field[ 'allow_null' ] = 0;
				$local_field[ 'add_term' ] = $field_add_term;
				$local_field[ 'load_terms' ] = 1;
				$local_field[ 'save_terms' ] = 1;
				$local_field[ 'custom_taxonomy' ] = true;
			break;
			case 'tags':
				$local_field[ 'type' ] = 'taxonomy';
				$local_field[ 'taxonomy' ] = 'post_tag';
				$local_field[ 'field_type' ] = $field_appearance;
				$local_field[ 'allow_null' ] = 0;
				$local_field[ 'add_term' ] = $field_add_term;
				$local_field[ 'load_terms' ] = 1;
				$local_field[ 'save_terms' ] = 1;
				$local_field[ 'custom_taxonomy' ] = true;
			break;

		}
		return $local_field;
	}
	

	public function register_settings_section( $widget ) {		
						
		$widget->start_controls_section(
			'section_edit_post',
			[
				'label' => $this->get_label(),
				'tab' => Controls_Manager::TAB_CONTENT,
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'main_action',
							'operator' => 'in',
							'value' => [ 'new_post', 'edit_post' ],
						],	
						
					],
				],
			]
		);
				
		$widget->add_control(
			'post_settings',
			[
				'label' => __( 'Post Settings', 'acf-frontend-form-element' ),
				'type' => \Elementor\Controls_Manager::HEADING,
			]
		);

		$widget->add_control(
			'default_featured_image',
			[
				'label' => __( 'Default Featured Image', 'acf-frontend-form-element' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
			]
		);
		

		$this->action_controls( $widget );		
		
		$widget->add_control(
			'show_delete_button',
			[
				'label' => __( 'Delete Post Option', 'acf-frontend-form-element' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'acf-frontend-form-element' ),
				'label_off' => __( 'No','acf-frontend-form-element' ),
				'return_value' => 'true',
				'condition' => [
					'main_action' => 'edit_post',
				],
			]
		);
		
		$widget->add_control(
			'delete_button_text',
			[
				'label' => __( 'Delete Button Text', 'acf-frontend-form-element' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Delete', 'acf-frontend-form-element' ),
				'placeholder' => __( 'Delete', 'acf-frontend-form-element' ),
				'condition' => [
					'main_action' => 'edit_post',
					'show_delete_button' => 'true',
				],
			]
		);
		$widget->add_control(
			'delete_button_icon',
			[
				'label' => __( 'Delete Button Icon', 'acf-frontend-form-element' ),
				'type' => Controls_Manager::ICONS,
				'condition' => [
					'main_action' => 'edit_post',
					'show_delete_button' => 'true',
				],
			]
		);
	
		$widget->add_control(
			'confirm_delete_message',
			[
				'label' => __( 'Confirm Delete Message', 'acf-frontend-form-element' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'The post will be deleted. Are you sure?', 'acf-frontend-form-element' ),
				'placeholder' => __( 'The post will be deleted. Are you sure?', 'acf-frontend-form-element' ),
				'condition' => [
					'main_action' => 'edit_post',
					'show_delete_button' => 'true',
				],
			]
		);
		$widget->add_control(
			'force_delete',
			[
				'label' => __( 'Force Delete', 'acf-frontend-form-element' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'true',
				'return_value' => 'true',
				'description' => __( 'Whether or not to completely delete the posts right away.' ),
				'condition' => [
					'main_action' => 'edit_post',
					'show_delete_button' => 'true',
				],
			]
		);
		$widget->add_control(
			'delete_redirect',
			[
				'label' => __( 'Redirect After Delete', 'acf-frontend-form-element' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'custom_url',
				'options' => [
					'current'  => __( 'Reload Current Url', 'acf-frontend-form-element' ),
					'custom_url' => __( 'Custom Url', 'acf-frontend-form-element' ),
					'referer_url' => __( 'Referer', 'acf-frontend-form-element' ),
				],
				'condition' => [
					'main_action' => 'edit_post',
					'show_delete_button' => 'true',
				],
			]
		);
		
		$widget->add_control(
			'redirect_after_delete',
			[
				'label' => __( 'Custom URL', 'acf-frontend-form-element' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'Enter Url Here', 'acf-frontend-form-element' ),
				'show_external' => false,
				'dynamic' => [
					'active' => true,
				],			
				'condition' => [
					'main_action' => 'edit_post',
					'show_delete_button' => 'true',
					'delete_redirect' => 'custom_url',
				],	
			]
		);

			
		$widget->add_control(
			'post_settings_end',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);
				
		$widget->end_controls_section();
	}
	
	public function action_controls( $widget, $step = false ){
		$condition = [
			'main_action' => [ 'edit_post', 'new_post' ],
		];
		if( $step ){
			$condition = [
				'main_action' => [ 'edit_post', 'new_post' ],
				'field_type' => 'step',
				'overwrite_settings' => 'true',
			];
		}
		$widget->add_control(
			'new_post_status',
			[
				'label' => __( 'Post Status', 'acf-frontend-form-element' ),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'default' => 'publish',
				'options' => [
					'draft' => __( 'Draft', 'acf-frontend-form-element' ),
					'private' => __( 'Private', 'acf-frontend-form-element' ),
					'pending' => __( 'Pending Review', 'acf-frontend-form-element' ),
					'publish'  => __( 'Published', 'acf-frontend-form-element' ),
				],
				'condition' => $condition
			]
		);		
		$condition[ 'main_action' ] = 'edit_post';

		$widget->add_control(
			'post_to_edit',
			[
				'label' => __( 'Post To Edit', 'acf-frontend-form-element' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'current_post',
				'options' => [
					'current_post'  => __( 'Current Post', 'acf-frontend-form-element' ),
					'url_query' => __( 'Url Query', 'acf-frontend-form-element' ),
					'select_post' => __( 'Select Post', 'acf-frontend-form-element' ),
				],
				'condition' => $condition,
			]
		);
		$condition[ 'post_to_edit' ] = 'url_query';
		$widget->add_control(
			'url_query_post',
			[
				'label' => __( 'URL Query', 'acf-frontend-form-element' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'post_id', 'acf-frontend-form-element' ),
				'default' => __( 'post_id', 'acf-frontend-form-element' ),
				'required' => true,
				'description' => __( 'Enter the URL query parameter containing the id of the post you want to edit', 'acf-frontend-form-element' ),
				'condition' => $condition,
			]
		);	
		$condition[ 'post_to_edit' ] = 'select_post';
		if( ! class_exists( 'ElementorPro\Modules\QueryControl\Module' ) ){
			$widget->add_control(
				'post_select',
				[
					'label' => __( 'Post', 'acf-frontend-form-element' ),
					'type' => Controls_Manager::TEXT,
					'placeholder' => __( '18', 'acf-frontend-form-element' ),
					'description' => __( 'Enter the post ID', 'acf-frontend-form-element' ),
					'condition' => $condition,
				]
			);		
		}else{
			$widget->add_control(
				'post_select',
				[
					'label' => __( 'Post', 'acf-frontend-form-element' ),
					'type' => Query_Module::QUERY_CONTROL_ID,
					'options' => [
						'' => 0,
					],
					'label_block' => true,
					'autocomplete' => [
						'object' => Query_Module::QUERY_OBJECT_POST,
						'display' => 'detailed',
						'query' => [
							'post_type' => 'any',
							'post_status' => 'any',
						],
					],
					'default' => 0,
					'condition' => $condition,
				]
			);
		}
	
		unset( $condition[ 'post_to_edit' ] );
		$condition[ 'main_action' ] = 'new_post';

		$post_type_choices = acfef_get_post_type_choices();    
		
		$widget->add_control(
			'new_post_type',
			[
				'label' => __( 'New Post Type', 'acf-frontend-form-element' ),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'default' => 'post',
				'options' => $post_type_choices,
				'condition' => $condition,
			]
		);
		$widget->add_control(
			'new_post_terms',
			[
				'label' => __( 'New Post Terms', 'acf-frontend-form-element' ),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'default' => 'post',
				'options' => [
					'current_term'  => __( 'Current Term', 'acf-frontend-form-element' ),
					'select_terms' => __( 'Select Term', 'acf-frontend-form-element' ),
				],
				'condition' => $condition,
			]
		);

		$condition[ 'new_post_terms' ] = 'select_terms';
		if( ! class_exists( 'ElementorPro\Modules\QueryControl\Module' ) ){
			$widget->add_control(
				'new_terms_select',
				[
					'label' => __( 'Terms', 'acf-frontend-form-element' ),
					'type' => Controls_Manager::TEXT,
					'placeholder' => __( '18, 12, 11', 'acf-frontend-form-element' ),
					'description' => __( 'Enter the a comma-seperated list of term ids', 'acf-frontend-form-element' ),
					'condition' => $condition,
				]
			);		
		}else{		
			$widget->add_control(
				'new_terms_select',
				[
					'label' => __( 'Terms', 'acf-frontend-form-element' ),
					'type' => Query_Module::QUERY_CONTROL_ID,
					'label_block' => true,
					'autocomplete' => [
						'object' => Query_Module::QUERY_OBJECT_TAX,
						'display' => 'detailed',
					],		
					'multiple' => true,
					'condition' => $condition,
				]
			);
		}
		
		unset( $condition[ 'new_post_terms' ] );
		$widget->add_control(
			'saved_drafts',
			[
				'label' => __( 'Show Saved Drafts Selection', 'acf-frontend-form-element' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'acf-frontend-form-element' ),
				'label_off' => __( 'No','acf-frontend-form-element' ),
				'return_value' => 'true',
				'condition' => $condition,
				'seperator' => 'before',
			]
		);
		$condition[ 'saved_drafts' ] = 'true';
		$widget->add_control(
			'saved_drafts_label',
			[
				'label' => __( 'Edit Draft Text', 'acf-frontend-form-element' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Edit a draft', 'acf-frontend-form-element' ),
				'placeholder' => __( 'Edit a draft', 'acf-frontend-form-element' ),
				'condition' => $condition,
			]
		);		
		$widget->add_control(
			'saved_drafts_new',
			[
				'label' => __( 'New Draft Text', 'acf-frontend-form-element' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '&mdash; New Post &mdash;', 'acf-frontend-form-element' ),
				'placeholder' => __( '&mdash; New Post &mdash;', 'acf-frontend-form-element' ),
				'condition' => $condition,
			]
		);
		unset( $condition[ 'saved_drafts' ] );
		$condition[ 'new_post_status' ] = [ 'publish', 'pending' ];
		$widget->add_control(
			'save_progress_button',
			[
				'label' => __( 'Save As Draft Option', 'acf-frontend-form-element' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'acf-frontend-form-element' ),
				'label_off' => __( 'No','acf-frontend-form-element' ),
				'return_value' => 'true',
				'condition' => $condition,
			]
		);
		$condition[ 'save_progress_button' ] = 'true';
		$widget->add_control(
			'saved_draft_text',
			[
				'label' => __( 'Save Draft Text', 'acf-frontend-form-element' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Save as Draft', 'acf-frontend-form-element' ),
				'placeholder' => __( 'save as Draft', 'acf-frontend-form-element' ),
				'dynamic' => [
					'active' => true,
				],				
				'condition' => $condition,
			]
		);
		$widget->add_control(
			'saved_draft_desc',
			[
				'label' => __( 'Save Draft Description', 'acf-frontend-form-element' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Want to finish later?', 'acf-frontend-form-element' ),
				'dynamic' => [
					'active' => true,
				],				
				'condition' => $condition,
			]
		);
		/* $widget->add_control(
			'saved_draft_message',
			[
				'label' => __( 'Draft Saved Message', 'acf-frontend-form-element' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'Draft Saved', 'acf-frontend-form-element' ),
				'placeholder' => __( 'Draft Saved', 'acf-frontend-form-element' ),
				'dynamic' => [
					'active' => true,
				],
			]
		); */

	}

	/* public function duplicate( $post_id, $settings, $step = false ){
		$post_to_duplicate = get_post( $post_id );
		$post_to_duplicate = get_object_vars( $post_to_duplicate );
		
		if( $post_to_duplicate ){
			$post_to_duplicate[ 'ID' ] = 0;
			$new_post_id = wp_insert_post( $post_to_duplicate );
			if( $new_post_id ){
				return $new_post_id;
			}
		}
	} */
		
}
