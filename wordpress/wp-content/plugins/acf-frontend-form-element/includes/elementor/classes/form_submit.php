<?php

namespace ACFFrontend\Module\Classes;

use  ACFFrontend\Plugin ;
use  ACFFrontend\Module\ACFEF_Module ;
use  ACFFrontend\Module\Widgets ;

if ( !defined( 'ABSPATH' ) ) {
    exit;
    // Exit if accessed directly.
}

class FormSubmit
{
    public function __construct()
    {
        add_action(
            'acf/submit_form',
            [ $this, 'acfef_return_ajax_submit' ],
            10,
            2
        );
        add_action( 'wp_footer', [ $this, 'form_message' ] );
        add_action( 'acf/validate_save_post', [ $this, 'validate_save_post' ], 1 );
        add_filter(
            'acf/pre_save_post',
            [ $this, 'on_submit' ],
            10,
            1
        );
        add_action(
            'acf/save_post',
            [ $this, 'after_save' ],
            20,
            1
        );
        add_action(
            'wp',
            [ $this, 'delete_post' ],
            10,
            1
        );
        add_action(
            'elementor/editor/after_save',
            [ $this, 'acfef_save_fields' ],
            10,
            2
        );
    }
    
    public function acfef_save_fields( $post_id, $editor_data )
    {
        $args = [
            'post_id'     => $post_id,
            'widget_name' => [
            'acf_ele_form',
            'edit_post',
            'edit_term',
            'new_term',
            'new_post',
            'edit_product',
            'new_product',
            'new_comment',
            'edit_user',
            'new_user',
            'edit_options'
        ],
        ];
        $this->iterate_data( $editor_data, $args );
    }
    
    public function iterate_data( $data_container, $args = array() )
    {
        
        if ( isset( $data_container['elType'] ) ) {
            if ( !empty($data_container['elements']) ) {
                $data_container['elements'] = $this->iterate_data( $data_container['elements'], $args );
            }
            if ( empty($data_container['widgetType']) || !in_array( $data_container['widgetType'], $args['widget_name'] ) ) {
                return $data_container;
            }
            return $this->save_widget_fields( $data_container, $args );
        }
        
        if ( is_array( $data_container ) ) {
            foreach ( $data_container as $element_key => $element_value ) {
                $element_data = $this->iterate_data( $data_container[$element_key], $args );
                if ( null === $element_data ) {
                    continue;
                }
                $data_container[$element_key] = $element_data;
            }
        }
        return $data_container;
    }
    
    public function save_widget_fields( $widget, $args )
    {
        $module = ACFEF_Module::instance();
        $settings = $widget['settings'];
        $wg_id = $widget['id'];
        
        if ( $widget['widgetType'] != 'acf_ele_form' ) {
            $settings['main_action'] = $widget['widgetType'];
        } else {
            if ( !isset( $settings['main_action'] ) ) {
                $settings['main_action'] = 'edit_post';
            }
        }
        
        
        if ( !empty($settings['fields_selection']) ) {
            $exclude = [
                'ACF_field_groups',
                'ACF_fields',
                'default_fields',
                'step',
                'message'
            ];
            switch ( $settings['main_action'] ) {
                case 'new_post':
                case 'edit_post':
                    $action = $module->get_main_actions( 'post' );
                    break;
                case 'new_user':
                case 'edit_user':
                    $action = $module->get_main_actions( 'user' );
                    break;
                case 'edit_term':
                    $action = $module->get_main_actions( 'term' );
                    break;
                case 'edit_options':
                    $action = $module->get_main_actions( 'options' );
                    break;
                case 'new_comment':
                    $action = $module->get_main_actions( 'comment' );
                    break;
                case 'new_product':
                case 'edit_product':
                    $action = $module->get_main_actions( 'product' );
                    break;
            }
            if ( isset( $action ) ) {
                foreach ( $settings['fields_selection'] as $form_field ) {
                    if ( empty($form_field['field_type']) || in_array( $form_field['field_type'], $exclude ) ) {
                        continue;
                    }
                    $local_field = [];
                    
                    if ( $form_field['field_type'] == 'taxonomy' ) {
                        $taxonomy = ( isset( $form_field['field_taxonomy'] ) ? $form_field['field_taxonomy'] : 'category' );
                        $field_key = 'acfef_' . $wg_id . '_' . $taxonomy;
                    } else {
                        $field_key = 'acfef_' . $wg_id . '_' . $form_field['field_type'];
                    }
                    
                    $local_field = acf_get_field( $field_key );
                    if ( empty($local_field) ) {
                        $local_field = [
                            'name' => $field_key,
                            'key'  => $field_key,
                        ];
                    }
                    if ( isset( $settings['__dynamic__'] ) ) {
                        $form_field = $this->acfef_parse_tags( $form_field );
                    }
                    $default_value = ( isset( $form_field['field_default_value'] ) ? $form_field['field_default_value'] : '' );
                    
                    if ( strpos( $default_value, '[$' ) !== 'false' ) {
                        $data_default = acfef_get_field_names( $default_value );
                        $default_value = acfef_get_code_value( $default_value, false, true );
                    }
                    
                    if ( !empty($form_field['default_featured_image']['id']) ) {
                        $default_value = $form_field['default_featured_image']['id'];
                    }
                    $local_field = array_merge( $local_field, [
                        'required'      => ( isset( $form_field['field_required'] ) ? $form_field['field_required'] : 0 ),
                        'instructions'  => ( isset( $form_field['field_instruction'] ) ? $form_field['field_instruction'] : '' ),
                        'wrapper'       => [
                        'class' => 'elementor-repeater-item-' . $form_field['_id'],
                    ],
                        'placeholder'   => ( isset( $form_field['field_placeholder'] ) ? $form_field['field_placeholder'] : '' ),
                        'default_value' => $default_value,
                        'disabled'      => ( isset( $form_field['field_disabled'] ) ? $form_field['field_disabled'] : 0 ),
                        'readonly'      => ( isset( $form_field['field_readonly'] ) ? $form_field['field_disabled'] : 0 ),
                    ] );
                    
                    if ( isset( $data_default ) ) {
                        $local_field['wrapper']['data-default'] = $data_default;
                        $local_field['wrapper']['data-dynamic_value'] = $default_value;
                    }
                    
                    if ( isset( $form_field['field_hidden'] ) && $form_field['field_hidden'] ) {
                        $local_field['wrapper']['class'] = 'acf-hidden';
                    }
                    $field_label = ucwords( str_replace( '_', ' ', $form_field['field_type'] ) );
                    $local_field['label'] = ( isset( $form_field['field_label'] ) ? $form_field['field_label'] : $field_label );
                    $form_args = Widgets\ACF_Frontend_Form_Widget::get_post_id( $settings, [], $wg_id );
                    $edit_id = ( isset( $form_args['post_id'] ) ? $form_args['post_id'] : false );
                    $local_field = $action->get_fields_display(
                        $form_field,
                        $local_field,
                        $edit_id,
                        $wg_id
                    );
                    if ( isset( $local_field['type'] ) ) {
                        
                        if ( $local_field['type'] == 'password' ) {
                            $local_field['password_strength'] = ( isset( $form_field['password_strength'] ) ? $form_field['password_strength'] : 3 );
                            $password_strength = true;
                        }
                    
                    }
                    if ( isset( $local_field['label'] ) ) {
                        if ( isset( $form_field['field_label_on'] ) && !$form_field['field_label_on'] ) {
                            $local_field['label'] = '';
                        }
                    }
                    acf_update_field( $local_field );
                }
            }
        }
        
        return $widget;
    }
    
    public function acfef_parse_tags( $settings )
    {
        $dynamic_tags = $settings['__dynamic__'];
        foreach ( $dynamic_tags as $control_name => $tag ) {
            $tag_value = \Elementor\Plugin::$instance->dynamic_tags->parse_tags_text( $tag, $settings, [ \Elementor\Plugin::$instance->dynamic_tags, 'get_tag_data_content' ] );
            $settings[$control_name] = $tag_value;
        }
        return $settings;
    }
    
    public function acfef_return_ajax_submit( $form, $post_id )
    {
        // fix "prescription" post type creation
        
        if ( isset( $form['ajax_submit'] ) ) {
            $update_message = $form['update_message'];
            if ( strpos( $update_message, '[$' ) !== 'false' ) {
                $update_message = acfef_get_code_value( $update_message, $post_id );
            }
            wp_send_json_success( array(
                'post_id'        => $post_id,
                'update_message' => $update_message,
            ) );
            exit;
        }
    
    }
    
    public function form_message()
    {
        $message = '';
        
        if ( !isset( $_GET['step'] ) && isset( $_GET['updated'] ) && $_GET['updated'] !== 'true' ) {
            $widget = $this->get_the_widget();
            if ( !$widget ) {
                return;
            }
            $form_id = explode( '_', $_GET['updated'] );
            $widget_id = $form_id[0];
            $post_id = $form_id[1];
            $settings = $widget->get_settings_for_display();
            if ( $settings['show_success_message'] == 'true' ) {
                
                if ( isset( $settings['update_message'] ) ) {
                    $update_message = $settings['update_message'];
                    if ( strpos( $update_message, '[$' ) !== 'false' ) {
                        $update_message = acfef_get_code_value( $update_message, $post_id );
                    }
                    $message = '<div id="acfef-message" class="elementor-' . $post_id . '">
								<div class="elementor-element elementor-element-' . $widget_id . '">
									<div class="acf-notice -success acf-success-message -dismiss"><p class="success-msg">' . $update_message . '</p><a  class="acfef-dismiss close-msg acf-notice-dismiss acf-icon -cancel"></a></div>
								</div>
								</div>';
                }
            
            }
        }
        
        echo  $message ;
    }
    
    public function validate_save_post()
    {
        if ( !isset( $_POST['_acf_element_id'] ) ) {
            return;
        }
        if ( get_option( $_POST['_acf_element_id'] . '_updated' ) ) {
            return;
        }
        $widget = $this->get_the_widget();
        $settings = $widget->get_settings_for_display();
        $module = ACFEF_Module::instance();
        
        if ( isset( $_POST['_acf_step_action'] ) ) {
            $main_action = $_POST['_acf_step_action'];
        } else {
            $main_action = $_POST['_acf_main_action'];
        }
        
        if ( !$main_action ) {
            return;
        }
        $this->get_core_fields( $main_action, $settings );
    }
    
    public function get_core_fields( $main_action, $settings )
    {
        $module = ACFEF_Module::instance();
        $wg_id = $_POST['_acf_element_id'];
        $custom_fields = [
            'default_fields',
            'ACF_fields',
            'ACF_field_groups',
            'step',
            'message'
        ];
        foreach ( $settings['fields_selection'] as $key => $form_field ) {
            if ( in_array( $form_field, $custom_fields ) ) {
                continue;
            }
            $local_field = array(
                'name' => $wg_id . '_' . $form_field['field_type'],
                'key'  => $wg_id . '_' . $form_field['field_type'],
            );
            if ( acf_get_field( $local_field['key'] ) ) {
                continue;
            }
            if ( !isset( $_POST['acfef_save_draft'] ) ) {
                $local_field['required'] = $form_field['field_required'];
            }
            if ( $main_action == 'new_post' || $main_action == 'edit_post' ) {
                $action = $module->get_main_actions( 'post' );
            }
            if ( $main_action == 'new_user' || $main_action == 'edit_user' ) {
                $action = $module->get_main_actions( 'user' );
            }
            if ( $main_action == 'edit_term' ) {
                $action = $module->get_main_actions( 'term' );
            }
            
            if ( isset( $action ) ) {
                $local_field = $action->get_fields_display( $form_field, $local_field );
                acf_add_local_field( $local_field );
            }
        
        }
    }
    
    public function on_submit( $post_id )
    {
        
        if ( isset( $_POST['prev_step'] ) ) {
            wp_safe_redirect( $_POST['prev_step_link'] );
            exit;
        }
        
        if ( !isset( $_POST['_acf_element_id'] ) ) {
            return $post_id;
        }
        $widget = $this->get_the_widget();
        $settings = $widget->get_settings_for_display();
        $module = ACFEF_Module::instance();
        $actions = $module->get_main_actions();
        $step = false;
        
        if ( isset( $_POST['_acf_step_action'] ) ) {
            $main_action = $_POST['_acf_step_action'];
        } else {
            $main_action = $_POST['_acf_main_action'];
        }
        
        
        if ( isset( $_POST['_acf_step_index'] ) ) {
            $step_index = $_POST['_acf_step_index'];
            $steps = array_filter( $settings['fields_selection'], [ $this, 'get_steps' ] );
            $steps = array_values( $steps );
            $steps = array_merge( $settings['first_step'], $steps );
            $step = $steps[$step_index];
            
            if ( $main_action == 'continue' ) {
                do_action(
                    'acfef/on_submit',
                    $settings,
                    $widget->get_id(),
                    $post_id
                );
                return $post_id;
            }
        
        }
        
        if ( !$main_action ) {
            return;
        }
        
        if ( $main_action == 'new_user' ) {
            $user_action = $module->get_main_actions( 'user' );
            $post_id = $user_action->run( $post_id, $settings, $step );
        }
        
        do_action(
            'acfef/on_submit',
            $settings,
            $widget->get_id(),
            $post_id
        );
        return $post_id;
    }
    
    public function get_steps( $field )
    {
        if ( $field['field_type'] == 'step' ) {
            return true;
        }
        return false;
    }
    
    public function after_save( $post_id )
    {
        if ( !isset( $_POST['_acf_element_id'] ) ) {
            return $post_id;
        }
        $widget = $this->get_the_widget();
        $settings = $widget->get_settings_for_display();
        $module = ACFEF_Module::instance();
        $step = $last_step = false;
        
        if ( isset( $_POST['_acf_step_action'] ) ) {
            $main_action = $_POST['_acf_step_action'];
        } else {
            $main_action = $_POST['_acf_main_action'];
        }
        
        if ( isset( $last_step ) && $last_step == true && $settings['redirect'] != 'current' ) {
            return $post_id;
        }
        if ( strpos( $main_action, 'new_' ) !== false ) {
            $new_content = true;
        }
        if ( $step || isset( $new_content ) && $settings['redirect'] == 'current' && $settings['redirect_action'] == 'edit' ) {
            $this->reload_page( $post_id, $settings, [
                'step' => $step,
                'last' => $last_step,
            ] );
        }
        
        if ( isset( $_POST['log_back_in'] ) ) {
            $user_id = $_POST['log_back_in'];
            $user_object = get_user_by( 'ID', $user_id );
            
            if ( $user_object ) {
                wp_set_current_user( $user_id, $user_object->user_login );
                wp_set_auth_cookie( $user_id );
                do_action( 'wp_login', $user_object->user_login, $user_object );
            }
        
        }
        
        return $post_id;
    }
    
    public function reload_page( $post_id, $settings, $step = false )
    {
        $query_args = [];
        
        if ( isset( $_POST['_acf_step_action'] ) ) {
            $step_index = $_POST['_acf_step_index'];
            $main_action = $_POST['_acf_step_action'];
            
            if ( $step['last'] ) {
                $step_index = 1;
                
                if ( $settings['redirect'] == 'current' ) {
                    $query_args = [
                        'post_id',
                        'product_id',
                        'user_id',
                        'modal',
                        'form_id',
                        'step'
                    ];
                    $redirect_url = remove_query_arg( $query_args );
                    wp_safe_redirect( $redirect_url );
                    exit;
                } else {
                    return $post_id;
                }
            
            } else {
                $step_index = $step_index + 2;
            }
            
            $query_args = [
                'step' => $step_index,
            ];
        } else {
            $main_action = $_POST['_acf_main_action'];
            $current_post_id = $_POST['_acf_screen_id'];
            $wg_id = $_POST['_acf_element_id'];
            $query_args = [
                'updated' => $wg_id . '_' . $current_post_id,
            ];
        }
        
        if ( $main_action == 'new_post' ) {
            $query_args['post_id'] = $post_id;
        }
        if ( $main_action == 'new_product' ) {
            $query_args['product_id'] = $post_id;
        }
        if ( $main_action == 'new_user' && strpos( $post_id, 'user' ) !== false ) {
            $query_args['user_id'] = explode( '_', $post_id )[1];
        }
        if ( isset( $_POST['_acf_modal'] ) && $_POST['_acf_modal'] == 1 ) {
            $query_args['modal'] = true;
        }
        if ( isset( $_POST['_acf_element_id'] ) ) {
            $query_args['form_id'] = $_POST['_acf_element_id'];
        }
        // Redirect user back to the form page, with proper new $_GET parameters.
        $redirect_url = add_query_arg( $query_args, wp_get_referer() );
        wp_safe_redirect( $redirect_url );
        exit;
    }
    
    public function delete_post()
    {
        if ( !isset( $_POST['_acf_element_id'] ) || !isset( $_POST['delete_post'] ) ) {
            return;
        }
        $widget = $this->get_the_widget();
        $settings = $widget->get_settings_for_display();
        
        if ( $settings ) {
            
            if ( isset( $settings['force_delete'] ) && $settings['force_delete'] == 'true' || isset( $settings['force_delete_product'] ) && $settings['force_delete_product'] == 'true' ) {
                $deleted = wp_delete_post( $_POST['delete_post'], true );
            } else {
                $deleted = wp_trash_post( $_POST['delete_post'] );
            }
            
            
            if ( $deleted ) {
                wp_safe_redirect( $_POST['redirect_url'] );
                exit;
            }
        
        }
    
    }
    
    protected function get_the_widget()
    {
        
        if ( isset( $_POST['_acf_element_id'] ) ) {
            $widget_id = $_POST['_acf_element_id'];
            $post_id = $_POST['_acf_screen_id'];
        } elseif ( isset( $_GET['updated'] ) ) {
            $form_id = explode( '_', $_GET['updated'] );
            $widget_id = $form_id[0];
            $post_id = $form_id[1];
        } else {
            return false;
        }
        
        
        if ( isset( $post_id ) ) {
            $elementor = Plugin::instance()->elementor();
            $document = $elementor->documents->get( $post_id );
            $module = ACFEF_Module::instance();
            if ( $document ) {
                $form = $module->find_element_recursive( $document->get_elements_data(), $widget_id );
            }
            
            if ( !empty($form['templateID']) ) {
                $template = $elementor->documents->get( $form['templateID'] );
                
                if ( $template ) {
                    $global_meta = $template->get_elements_data();
                    $form = $global_meta[0];
                }
            
            }
            
            if ( !$form ) {
                return false;
            }
            $widget = $elementor->elements_manager->create_element_instance( $form );
            return $widget;
        }
    
    }

}
new FormSubmit();