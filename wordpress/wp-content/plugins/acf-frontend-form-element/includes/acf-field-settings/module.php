<?php

namespace ACFFrontend\Module;

use  Elementor\Core\Base\Module ;

if ( !defined( 'ABSPATH' ) ) {
    exit;
    // Exit if accessed directly
}

class ACFS_Module extends Module
{
    private  $components = array() ;
    public function get_name()
    {
        return 'acf_field_settings';
    }
    
    public function acfef_render_frontend( $field )
    {
        // bail early if no 'admin_only' setting
        if ( empty($field['only_front']) ) {
            return $field;
        }
        if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
            return $field;
        }
        // return false if is admin (removes field)
        if ( is_admin() ) {
            return false;
        }
        // return
        return $field;
    }
    
    public function acfef_username_disabled( $field )
    {
        // bail early if no 'admin_only' setting
        if ( empty($field['custom_username']) ) {
            return $field;
        }
        // return false if is admin (removes field)
        if ( !$field['value'] ) {
            $field['disabled'] = 0;
        }
        // return
        return $field;
    }
    
    public function acfef_repeater_row_author( $field )
    {
        if ( empty($field['filter_row_edit']) ) {
            return $field;
        }
        global  $post ;
        if ( !isset( $post->post_type ) || $post->post_type == 'acf-field-group' ) {
            return $field;
        }
        $row_author_field = [
            'prefix'        => 'acf',
            'name'          => 'row_author',
            '_name'         => 'row_author',
            'key'           => 'acfef_row_author',
            'type'          => 'text',
            'required'      => '0',
            'instructions'  => '',
            'default_value' => 'user_' . get_current_user_id(),
            'wrapper'       => [
            'width' => '',
            'class' => 'acf-hidden',
            'id'    => '',
        ],
            'maxlength'     => '',
            'label'         => '',
            'parent'        => $field['key'],
        ];
        acf_add_local_field( $row_author_field );
        $field['sub_fields'][] = $row_author_field;
        return $field;
    }
    
    public function acfef_frontend_setting( $field )
    {
        acf_render_field_setting( $field, array(
            'label'        => __( 'Show Only On Frontend' ),
            'instructions' => 'Lets you hide the field on the backend to avoid duplicate fields.',
            'name'         => 'only_front',
            'type'         => 'true_false',
            'ui'           => 1,
        ), true );
    }
    
    public function acfef_price_field( $field )
    {
        acf_render_field_setting( $field, array(
            'label'        => __( 'Set as product price' ),
            'instructions' => 'Save value as product price.',
            'name'         => 'custom_price',
            'type'         => 'true_false',
            'ui'           => 1,
        ) );
        acf_render_field_setting( $field, array(
            'label'        => __( 'Set as sale price' ),
            'instructions' => 'Save value as product price.',
            'name'         => 'custom_sale_price',
            'type'         => 'true_false',
            'ui'           => 1,
        ) );
    }
    
    public function acfef_true_false_field( $field )
    {
        acf_render_field_setting( $field, array(
            'label'        => __( 'Set as product sold individually option' ),
            'instructions' => 'Save value as product sold individually option.',
            'name'         => 'custom_sold_ind',
            'type'         => 'true_false',
            'ui'           => 1,
        ) );
    }
    
    public function acfef_add_edit_field( $field )
    {
    }
    
    public function acfef_title_field( $field )
    {
        acf_render_field_setting( $field, array(
            'label'        => __( 'Set as post title' ),
            'instructions' => 'Save value as post title.',
            'name'         => 'custom_title',
            'type'         => 'true_false',
            'ui'           => 1,
        ) );
        acf_render_field_setting( $field, array(
            'label'        => __( 'Set as post slug' ),
            'instructions' => 'Save value as post slug.',
            'name'         => 'custom_slug',
            'type'         => 'true_false',
            'ui'           => 1,
        ) );
        acf_render_field_setting( $field, array(
            'label'        => __( 'Set as username' ),
            'instructions' => 'Save value as user login name.',
            'name'         => 'custom_username',
            'type'         => 'true_false',
            'ui'           => 1,
        ) );
        acf_render_field_setting( $field, array(
            'label'        => __( 'Set as product sku' ),
            'instructions' => 'Save value as product sku.',
            'name'         => 'custom_sku',
            'type'         => 'true_false',
            'ui'           => 1,
        ) );
        acf_render_field_setting( $field, array(
            'label'        => __( 'Read only' ),
            'instructions' => 'Prevent users from changing the data.',
            'name'         => 'readonly',
            'type'         => 'true_false',
            'ui'           => 1,
        ) );
    }
    
    public function acfef_password_field( $field )
    {
        acf_render_field_setting( $field, array(
            'label'        => __( 'Set as user password' ),
            'instructions' => 'Save value as user login password.',
            'name'         => 'custom_password',
            'type'         => 'true_false',
            'ui'           => 1,
        ) );
        acf_render_field_setting( $field, array(
            'label'        => __( 'Set as password confirm' ),
            'instructions' => 'Save value as user login password.',
            'name'         => 'custom_password_confirm',
            'type'         => 'true_false',
            'ui'           => 1,
        ) );
    }
    
    public function acfef_email_field( $field )
    {
        acf_render_field_setting( $field, array(
            'label'        => __( 'User Email' ),
            'instructions' => 'Save value as user email.',
            'name'         => 'custom_email',
            'type'         => 'true_false',
            'ui'           => 1,
        ) );
        acf_render_field_setting( $field, array(
            'label'        => __( 'Comment Author Email' ),
            'instructions' => 'Save value as comment author email.',
            'name'         => 'custom_author_email',
            'type'         => 'true_false',
            'ui'           => 1,
        ) );
        acf_render_field_setting( $field, array(
            'label'        => __( 'Read only' ),
            'instructions' => 'Prevent users from changing the data.',
            'name'         => 'readonly',
            'type'         => 'true_false',
            'ui'           => 1,
        ) );
    }
    
    public function acfef_content_field( $field )
    {
        acf_render_field_setting( $field, array(
            'label'        => __( 'Set as post content' ),
            'instructions' => 'Save value as post content.',
            'name'         => 'custom_content',
            'type'         => 'true_false',
            'ui'           => 1,
        ) );
    }
    
    public function acfef_excerpt_field( $field )
    {
        acf_render_field_setting( $field, array(
            'label'        => __( 'Set as post excerpt' ),
            'instructions' => 'Save value as post excerpt.',
            'name'         => 'custom_excerpt',
            'type'         => 'true_false',
            'ui'           => 1,
        ) );
        acf_render_field_setting( $field, array(
            'label'        => __( 'Set as user bio' ),
            'instructions' => 'Save value as user bio.',
            'name'         => 'custom_user_bio',
            'type'         => 'true_false',
            'ui'           => 1,
        ) );
        acf_render_field_setting( $field, array(
            'label'        => __( 'Read only' ),
            'instructions' => 'Prevent users from changing the data.',
            'name'         => 'readonly',
            'type'         => 'true_false',
            'ui'           => 1,
        ) );
    }
    
    public function acfef_file_folders_setting( $field )
    {
        acf_render_field_setting( $field, array(
            'label'         => __( 'Happy Files Folder', 'acf' ),
            'instructions'  => __( 'Limit the media library choice to specific Happy Files Categories', 'acf' ),
            'type'          => 'radio',
            'name'          => 'happy_files_folder',
            'layout'        => 'horizontal',
            'default_value' => 'all',
            'choices'       => acfef_get_image_folders(),
        ) );
    }
    
    public function acfef_gallery_field( $field )
    {
        acf_render_field_setting( $field, array(
            'label' => __( 'Set as product gallery' ),
            'name'  => 'custom_product_gallery',
            'type'  => 'true_false',
            'ui'    => 1,
        ) );
    }
    
    public function acfef_image_field( $field )
    {
        acf_render_field_setting( $field, array(
            'label'        => __( 'Set as post image' ),
            'instructions' => 'Save value as post featured image.',
            'name'         => 'custom_featured_image',
            'type'         => 'true_false',
            'ui'           => 1,
        ) );
    }
    
    public function acfef_repeater_field( $field )
    {
        acf_render_field_setting( $field, array(
            'label'        => __( 'Limit Row Edit to', 'acf-frontend-form-element' ),
            'instructions' => '',
            'type'         => 'select',
            'name'         => 'filter_row_edit',
            'instructions' => __( 'Save data to the rows and filter the rows based on that data. Brought to you by ACF Frontend.', 'acf-frontend-form-element' ),
            'choices'      => [
            'author' => __( 'Author of the Row', 'acf-frontend-form-element' ),
        ],
            'multiple'     => 1,
            'ui'           => 1,
            'allow_null'   => 1,
        ) );
    }
    
    private function acfef_is_custom( $field )
    {
        foreach ( $field as $key => $value ) {
            if ( 'custom_' == substr( $key, 0, 7 ) && $value == 1 ) {
                return true;
            }
        }
        return false;
    }
    
    public function acfef_load_text_value( $value, $post_id, $field )
    {
        if ( !$this->acfef_is_custom( $field ) ) {
            return $value;
        }
        
        if ( $post_id ) {
            $edit_post = get_post( $post_id );
            
            if ( $edit_post ) {
                if ( isset( $field['custom_title'] ) && $field['custom_title'] == 1 ) {
                    $value = $edit_post->post_title;
                }
                if ( isset( $field['custom_sku'] ) && $field['custom_sku'] == 1 ) {
                    $value = get_post_meta( $post_id, '_sku', true );
                }
            } elseif ( strpos( $post_id, 'user' ) !== false ) {
                $user_id = explode( '_', $post_id )[1];
                $edit_user = get_user_by( 'ID', $user_id );
                
                if ( $edit_user ) {
                    if ( isset( $field['custom_username'] ) && $field['custom_username'] == 1 ) {
                        $value = $edit_user->user_login;
                    }
                    if ( isset( $field['custom_first_name'] ) && $field['custom_first_name'] == 1 ) {
                        $value = get_user_meta( $user_id, 'first_name', true );
                    }
                    if ( isset( $field['custom_last_name'] ) && $field['custom_last_name'] == 1 ) {
                        $value = get_user_meta( $user_id, 'last_name', true );
                    }
                    if ( isset( $field['custom_nickname'] ) && $field['custom_nickname'] == 1 ) {
                        $value = get_user_meta( $user_id, 'nickname', true );
                    }
                }
            
            } elseif ( $post_id == 'options' ) {
                if ( isset( $field['custom_site_title'] ) && $field['custom_site_title'] == 1 ) {
                    $value = get_option( 'blogname' );
                }
                if ( isset( $field['custom_site_tagline'] ) && $field['custom_site_tagline'] == 1 ) {
                    $value = get_option( 'blogdescription' );
                }
            } elseif ( strpos( $post_id, 'term' ) !== false ) {
                $term_id = explode( '_', $post_id )[1];
                $edit_term = get_term( $term_id );
                if ( !is_wp_error( $edit_term ) ) {
                    if ( isset( $field['custom_term_name'] ) && $field['custom_term_name'] == 1 ) {
                        $value = $edit_term->name;
                    }
                }
            } elseif ( strpos( $post_id, 'comment' ) !== false ) {
                $current_user = wp_get_current_user();
                if ( $current_user !== 0 ) {
                    if ( isset( $field['custom_author'] ) && $field['custom_author'] == 1 ) {
                        $value = esc_html( $current_user->display_name );
                    }
                }
            }
        
        }
        
        return $value;
    }
    
    public function acfef_load_email_value( $value, $post_id, $field )
    {
        if ( !$this->acfef_is_custom( $field ) ) {
            return $value;
        }
        if ( $post_id ) {
            
            if ( strpos( $post_id, 'user' ) !== false ) {
                $user_id = explode( '_', $post_id )[1];
                $edit_user = get_user_by( 'ID', $user_id );
                if ( $edit_user ) {
                    if ( isset( $field['custom_email'] ) && $field['custom_email'] == 1 ) {
                        $value = esc_html( $edit_user->user_email );
                    }
                }
            } elseif ( strpos( $post_id, 'comment' ) !== false ) {
                $current_user = wp_get_current_user();
                if ( $current_user !== 0 ) {
                    if ( isset( $field['custom_author_email'] ) && $field['custom_author_email'] == 1 ) {
                        $value = esc_html( $current_user->user_email );
                    }
                }
            }
        
        }
        return $value;
    }
    
    public function acfef_load_textarea_value( $value, $post_id, $field )
    {
        if ( !$this->acfef_is_custom( $field ) ) {
            return $value;
        }
        
        if ( $post_id ) {
            $edit_post = get_post( $post_id );
            
            if ( $edit_post ) {
                if ( isset( $field['custom_excerpt'] ) && $field['custom_excerpt'] == 1 ) {
                    $value = $edit_post->post_excerpt;
                }
            } elseif ( strpos( $post_id, 'user' ) !== false ) {
                $user_id = explode( '_', $post_id )[1];
                $edit_user = get_user_by( 'ID', $user_id );
                if ( $edit_user ) {
                    if ( isset( $field['custom_user_bio'] ) && $field['custom_user_bio'] == 1 ) {
                        $value = get_user_meta( $user_id, 'description', true );
                    }
                }
            }
        
        }
        
        return $value;
    }
    
    public function acfef_load_wysiwyg_value( $value, $post_id, $field )
    {
        if ( !$this->acfef_is_custom( $field ) ) {
            return $value;
        }
        
        if ( $post_id ) {
            $edit_post = get_post( $post_id );
            if ( !is_wp_error( $edit_post ) ) {
                if ( isset( $field['custom_content'] ) && $field['custom_content'] == 1 ) {
                    $value = $edit_post->post_content;
                }
            }
        }
        
        return $value;
    }
    
    public function acfef_load_image_value( $value, $post_id, $field )
    {
        if ( !$this->acfef_is_custom( $field ) ) {
            return $value;
        }
        
        if ( $post_id ) {
            $edit_post = get_post( $post_id );
            
            if ( $edit_post ) {
                if ( isset( $field['custom_featured_image'] ) && $field['custom_featured_image'] == 1 ) {
                    $value = get_post_meta( $post_id, '_thumbnail_id', true );
                }
            } elseif ( $post_id == 'options' ) {
                if ( isset( $field['custom_site_logo'] ) && $field['custom_site_logo'] == 1 ) {
                    $value = get_theme_mod( 'custom_logo' );
                }
            }
        
        }
        
        return $value;
    }
    
    public function acfef_load_number_value( $value, $post_id, $field )
    {
        if ( !$this->acfef_is_custom( $field ) ) {
            return $value;
        }
        
        if ( $post_id ) {
            $edit_post = get_post( $post_id );
            
            if ( !is_wp_error( $edit_post ) ) {
                if ( isset( $field['custom_price'] ) && $field['custom_price'] == 1 ) {
                    $value = get_post_meta( $post_id, '_regular_price', true );
                }
                if ( isset( $field['custom_sale_price'] ) && $field['custom_sale_price'] == 1 ) {
                    $value = get_post_meta( $post_id, '_sale_price', true );
                }
                if ( isset( $field['custom_stock_quantity'] ) && $field['custom_stock_quantity'] == 1 ) {
                    $value = get_post_meta( $post_id, '_stock', true );
                }
                if ( isset( $field['custom_low_stock'] ) && $field['custom_low_stock'] == 1 ) {
                    $value = get_post_meta( $post_id, '_low_stock_amount', true );
                }
            }
        
        }
        
        return $value;
    }
    
    public function acfef_load_truefalse_value( $value, $post_id, $field )
    {
        if ( !$this->acfef_is_custom( $field ) ) {
            return $value;
        }
        
        if ( $post_id ) {
            $edit_post = get_post( $post_id );
            
            if ( !is_wp_error( $edit_post ) ) {
                if ( isset( $field['custom_manage_stock'] ) && $field['custom_manage_stock'] == 1 ) {
                    
                    if ( get_post_meta( $post_id, '_manage_stock', true ) == 'yes' ) {
                        $value = true;
                    } else {
                        $value = false;
                    }
                
                }
                if ( isset( $field['custom_sold_ind'] ) && $field['custom_sold_ind'] == 1 ) {
                    
                    if ( get_post_meta( $post_id, '_sold_individually', true ) == 'yes' ) {
                        $value = true;
                    } else {
                        $value = false;
                    }
                
                }
            }
        
        }
        
        return $value;
    }
    
    public function acfef_load_gallery_value( $value, $post_id, $field )
    {
        if ( !$this->acfef_is_custom( $field ) ) {
            return $value;
        }
        
        if ( $post_id ) {
            $edit_post = get_post( $post_id );
            if ( !is_wp_error( $edit_post ) ) {
                if ( isset( $field['custom_product_gallery'] ) && $field['custom_product_gallery'] == 1 ) {
                    $value = explode( ',', get_post_meta( $post_id, '_product_image_gallery', true ) );
                }
            }
        }
        
        return $value;
    }
    
    public function acfef_load_select_value( $value, $post_id, $field )
    {
        if ( !$this->acfef_is_custom( $field ) ) {
            return $value;
        }
        
        if ( $post_id ) {
            $edit_post = get_post( $post_id );
            
            if ( !is_wp_error( $edit_post ) ) {
                if ( isset( $field['custom_stock_status'] ) && $field['custom_stock_status'] == 1 ) {
                    $value = get_post_meta( $post_id, '_stock_status', true );
                }
                if ( isset( $field['custom_backorders'] ) && $field['custom_backorders'] == 1 ) {
                    $value = get_post_meta( $post_id, '_backorders', true );
                }
            } elseif ( strpos( $post_id, 'user' ) !== false ) {
                $user_id = explode( '_', $post_id )[1];
                $edit_user = get_user_by( 'ID', $user_id );
                if ( $edit_user ) {
                    if ( isset( $field['custom_user_role'] ) && $field['custom_user_role'] == 1 ) {
                        $value = $edit_user->role;
                    }
                }
            }
        
        }
        
        return $value;
    }
    
    public function acfef_load_radio_value( $value, $post_id, $field )
    {
        if ( !$this->acfef_is_custom( $field ) ) {
            return $value;
        }
        
        if ( strpos( $post_id, 'user' ) !== false ) {
            $user_id = explode( '_', $post_id )[1];
            $edit_user = get_user_by( 'ID', $user_id );
            if ( $edit_user ) {
                if ( isset( $field['custom_display_name'] ) && $field['custom_display_name'] == 1 ) {
                    $value = $edit_user->display_name;
                }
            }
        }
        
        return $value;
    }
    
    public function acfef_add_post_button( $field )
    {
        
        if ( isset( $field['add_post'] ) && $field['add_post'] == 1 ) {
            $post_types = acf_get_pretty_post_types();
            ?>
			<div class="margin-top-10 acf-actions">
				<a class="acf-button button button-primary" href="#" title="Add Post" data-name="add"><?php 
            echo  'Add Post' ;
            ?></a>
			</div>
			
		<?php 
        }
    
    }
    
    /* 	public function acfef_add_post_option( $field ){
    		if( isset( $field['add_post'] ) && $field['add_post'] == 1 ) : ?>
    			<div class="acf-actions -hover">
    				<a href="#" class="acf-icon -plus acf-js-tooltip small" data-name="add" title="Add Post"></a>
    			</div>
    		<?php endif;
    	} */
    public function acfef_before_repeater_field( $field )
    {
        if ( empty($field['filter_row_edit']) || is_admin() ) {
            return;
        }
        ob_start();
    }
    
    public function acfef_after_repeater_field( $field )
    {
        if ( empty($field['filter_row_edit']) || is_admin() ) {
            return;
        }
        $repeater = ob_get_contents();
        ob_end_clean();
        $rows = htmlentities( $repeater );
        $before = preg_split( '{' . htmlentities( '<tbody>' ) . '}', $rows );
        $after = preg_split( '{' . htmlentities( '</tbody>' ) . '}', $before[1] );
        $rows = preg_split( '{' . htmlentities( '</tr>' ) . '}', $after[0], 0 );
        $rows_display = '';
        $subtract = 0;
        foreach ( $rows as $index => $row ) {
            
            if ( $index + 2 == count( $rows ) ) {
                $rows_display .= $row;
                continue;
            } elseif ( is_user_logged_in() ) {
                
                if ( strpos( $row, 'user_' . get_current_user_id() ) !== false ) {
                    
                    if ( $subtract > 0 ) {
                        $new_index = $index - $subtract;
                        $row = str_replace( 'row-' . $index, 'row-' . $new_index, $row );
                        $row = str_replace( '<span>' . $index, '<span>' . $new_index, $row );
                    }
                    
                    $rows_display .= $row;
                    $rows_display .= htmlentities( '</tr>' );
                } else {
                    $subtract++;
                }
            
            }
        
        }
        $output = $before[0] . htmlentities( '<tbody>' ) . $rows_display . htmlentities( '</tbody>' ) . $after[1];
        echo  html_entity_decode( $output ) ;
    }
    
    public function load_payment_option_values( $value, $post_id, $field )
    {
        if ( $post_id !== 'acfef_options' ) {
            return $value;
        }
        return get_option( $field['key'] );
    }
    
    public function update_payment_option_values( $value, $post_id, $field )
    {
        if ( $post_id !== 'acfef_options' ) {
            return $value;
        }
        update_option( $field['key'], $value );
        return;
    }
    
    public function acfef_update_text_value( $value, $post_id, $field )
    {
        if ( !$this->acfef_is_custom( $field ) ) {
            return $value;
        }
        $edit_post = get_post( $post_id );
        
        if ( $edit_post ) {
            $post_to_edit = [
                'ID' => $post_id,
            ];
            
            if ( isset( $field['custom_title'] ) && $field['custom_title'] == 1 ) {
                $post_to_edit['post_title'] = sanitize_text_field( $value );
                if ( isset( $_POST['_acf_post_id'] ) && $_POST['_acf_post_id'] == 'new_post' ) {
                    $post_to_edit['post_name'] = sanitize_title( $value );
                }
            }
            
            if ( isset( $field['custom_slug'] ) && $field['custom_slug'] == 1 ) {
                $post_to_edit['post_name'] = sanitize_title( $value );
            }
            remove_filter(
                'acf/update_value/type=text',
                [ $this, 'acfef_update_text_value' ],
                9,
                3
            );
            wp_update_post( $post_to_edit );
            add_filter(
                'acf/update_value/type=text',
                [ $this, 'acfef_update_text_value' ],
                9,
                3
            );
            if ( isset( $field['custom_sku'] ) && $field['custom_sku'] == 1 ) {
                update_post_meta( $post_id, '_sku', $value );
            }
        } elseif ( strpos( $post_id, 'user_' ) !== false ) {
            $user_id = explode( '_', $post_id )[1];
            $user_object = get_user_by( 'ID', $user_id );
            $user_to_edit = [
                'ID' => $user_id,
            ];
            if ( !isset( $_POST['acfef_registered_user'] ) ) {
                
                if ( isset( $field['custom_username'] ) && $field['custom_username'] == 1 ) {
                    if ( $user_object->user_login == $value ) {
                        return;
                    }
                    $current_user = wp_get_current_user();
                    
                    if ( $current_user->ID == $user_id ) {
                        wp_clear_auth_cookie();
                        $_POST['log_back_in'] = $user_id;
                    }
                    
                    global  $wpdb ;
                    $wpdb->update( $wpdb->users, array(
                        'user_login' => $value,
                    ), [
                        'ID' => $user_id,
                    ] );
                }
            
            }
            if ( isset( $field['custom_first_name'] ) && $field['custom_first_name'] == 1 ) {
                $user_to_edit['first_name'] = $value;
            }
            if ( isset( $field['custom_last_name'] ) && $field['custom_last_name'] == 1 ) {
                $user_to_edit['last_name'] = $value;
            }
            if ( isset( $field['custom_nickname'] ) && $field['custom_nickname'] == 1 ) {
                $user_to_edit['nickname'] = $value;
            }
            
            if ( isset( $field['custom_display_name'] ) && $field['custom_display_name'] == 1 ) {
                $user_to_edit['display_name'] = $value;
                $_POST['custom_display_name'] = 1;
            }
            
            wp_update_user( $user_to_edit );
        } elseif ( $post_id == 'options' ) {
            if ( isset( $field['custom_site_title'] ) && $field['custom_site_title'] == 1 ) {
                update_option( 'blogname', $value );
            }
            if ( isset( $field['custom_site_tagline'] ) && $field['custom_site_tagline'] == 1 ) {
                update_option( 'blogdescription', $value );
            }
        } elseif ( strpos( $post_id, 'term' ) !== false ) {
            $term_id = explode( '_', $post_id )[1];
            $edit_term = get_term( $term_id );
            if ( !is_wp_error( $edit_term ) ) {
                if ( isset( $field['custom_term_name'] ) && $field['custom_term_name'] == 1 ) {
                    wp_update_term( $term_id, $edit_term->taxonomy, [
                        'name' => $value,
                    ] );
                }
            }
        } elseif ( strpos( $post_id, 'comment' ) !== false ) {
            $comment_id = explode( '_', $post_id )[1];
            $comment_to_edit = [
                'comment_ID' => $comment_id,
            ];
            if ( isset( $field['custom_author'] ) && $field['custom_author'] == 1 ) {
                $comment_to_edit['comment_author'] = esc_attr( $value );
            }
            wp_update_comment( $comment_to_edit );
        }
        
        unset( $_POST['acf'][$field['key']] );
        return;
    }
    
    public function acfef_update_password_value( $value, $post_id, $field )
    {
        if ( !$this->acfef_is_custom( $field ) ) {
            return $value;
        }
        if ( $value = '' ) {
            return;
        }
        
        if ( strpos( $post_id, 'user_' ) !== false ) {
            $user_id = explode( '_', $post_id )[1];
            $user_to_edit = [
                'ID' => $user_id,
            ];
            if ( isset( $field['custom_password'] ) && $field['custom_password'] == 1 ) {
                $user_to_edit['user_pass'] = $value;
            }
            wp_update_user( $user_to_edit );
        }
        
        unset( $_POST['acf'][$field['key']] );
        return;
    }
    
    public function acfef_update_email_value( $value, $post_id, $field )
    {
        if ( !$this->acfef_is_custom( $field ) ) {
            return $value;
        }
        
        if ( strpos( $post_id, 'user_' ) !== false ) {
            $user_id = explode( '_', $post_id )[1];
            $user_to_edit = [
                'ID' => $user_id,
            ];
            if ( isset( $field['custom_email'] ) && $field['custom_email'] == 1 ) {
                $user_to_edit['user_email'] = esc_attr( $value );
            }
            wp_update_user( $user_to_edit );
        } elseif ( strpos( $post_id, 'comment' ) !== false ) {
            $comment_id = explode( '_', $post_id )[1];
            $comment_to_edit = [
                'comment_ID' => $comment_id,
            ];
            if ( isset( $field['custom_author_email'] ) && $field['custom_author_email'] == 1 ) {
                $comment_to_edit['comment_author_email'] = esc_attr( $value );
            }
            wp_update_comment( $comment_to_edit );
        }
        
        unset( $_POST['acf'][$field['key']] );
        return;
    }
    
    public function acfef_update_textarea_value( $value, $post_id, $field )
    {
        if ( !$this->acfef_is_custom( $field ) ) {
            return $value;
        }
        $edit_post = get_post( $post_id );
        
        if ( $edit_post ) {
            $post_to_edit = [
                'ID' => $post_id,
            ];
            if ( isset( $field['custom_excerpt'] ) && $field['custom_excerpt'] == 1 ) {
                $post_to_edit['post_excerpt'] = $value;
            }
            remove_filter(
                'acf/update_value/type=textarea',
                [ $this, 'acfef_update_textarea_value' ],
                9,
                3
            );
            wp_update_post( $post_to_edit );
            add_filter(
                'acf/update_value/type=textarea',
                [ $this, 'acfef_update_textarea_value' ],
                9,
                3
            );
        } elseif ( strpos( $post_id, 'user_' ) !== false ) {
            $user_id = explode( '_', $post_id )[1];
            $user_to_edit = [
                'ID' => $user_id,
            ];
            if ( isset( $field['custom_user_bio'] ) ) {
                $user_to_edit['description'] = $value;
            }
            wp_update_user( $user_to_edit );
        } elseif ( strpos( $post_id, 'comment' ) !== false ) {
            $comment_id = explode( '_', $post_id )[1];
            $comment_to_edit = [
                'comment_ID' => $comment_id,
            ];
            if ( isset( $field['custom_comment'] ) && $field['custom_comment'] == 1 ) {
                $comment_to_edit['comment_content'] = esc_attr( $value );
            }
            wp_update_comment( $comment_to_edit );
        }
        
        unset( $_POST['acf'][$field['key']] );
        return;
    }
    
    public function acfef_update_wysiwyg_value( $value, $post_id, $field )
    {
        if ( !$this->acfef_is_custom( $field ) ) {
            return $value;
        }
        $edit_post = get_post( $post_id );
        
        if ( $edit_post ) {
            $post_to_edit = [
                'ID' => $post_id,
            ];
            if ( isset( $field['custom_content'] ) && $field['custom_content'] == 1 ) {
                $post_to_edit['post_content'] = $value;
            }
            remove_filter(
                'acf/update_value/type=wysiwyg',
                [ $this, 'acfef_update_wysiwyg_value' ],
                9,
                3
            );
            wp_update_post( $post_to_edit );
            add_filter(
                'acf/update_value/type=wysiwyg',
                [ $this, 'acfef_update_wysiwyg_value' ],
                9,
                3
            );
        }
        
        unset( $_POST['acf'][$field['key']] );
        return;
    }
    
    public function acfef_update_image_value( $value, $post_id, $field )
    {
        if ( !$this->acfef_is_custom( $field ) ) {
            return $value;
        }
        $edit_post = get_post( $post_id );
        
        if ( $edit_post ) {
            if ( isset( $field['custom_featured_image'] ) && $field['custom_featured_image'] == 1 ) {
                update_post_meta( $post_id, '_thumbnail_id', $value );
            }
        } elseif ( $post_id == 'options' ) {
            if ( isset( $field['custom_site_logo'] ) && $field['custom_site_logo'] == 1 ) {
                set_theme_mod( 'custom_logo', $value );
            }
        }
        
        unset( $_POST['acf'][$field['key']] );
        return;
    }
    
    public function acfef_update_number_value( $value, $post_id, $field )
    {
        if ( !$this->acfef_is_custom( $field ) ) {
            return $value;
        }
        $edit_post = get_post( $post_id );
        
        if ( $edit_post ) {
            
            if ( isset( $field['custom_price'] ) && $field['custom_price'] == 1 ) {
                update_post_meta( $post_id, '_regular_price', $value );
                $sale_price = get_post_meta( $post_id, '_sale_price', true );
                if ( !isset( $sale_price ) || $sale_price == '' ) {
                    update_post_meta( $post_id, '_price', $value );
                }
            }
            
            
            if ( isset( $field['custom_sale_price'] ) && $field['custom_sale_price'] == 1 ) {
                update_post_meta( $post_id, '_sale_price', $value );
                update_post_meta( $post_id, '_price', $value );
            }
            
            if ( isset( $field['custom_stock_quantity'] ) && $field['custom_stock_quantity'] == 1 ) {
                update_post_meta( $post_id, '_stock', $value );
            }
            if ( isset( $field['custom_low_stock'] ) && $field['custom_low_stock'] == 1 ) {
                update_post_meta( $post_id, '_low_stock_amount', $value );
            }
        }
        
        unset( $_POST['acf'][$field['key']] );
        return;
    }
    
    public function acfef_update_truefalse_value( $value, $post_id, $field )
    {
        if ( !$this->acfef_is_custom( $field ) ) {
            return $value;
        }
        $edit_post = get_post( $post_id );
        
        if ( $edit_post ) {
            if ( isset( $field['custom_sold_ind'] ) && $field['custom_sold_ind'] == 1 ) {
                
                if ( $value == 1 ) {
                    update_post_meta( $post_id, '_sold_individually', 'yes' );
                } else {
                    update_post_meta( $post_id, '_sold_individually', 'no' );
                }
            
            }
            if ( isset( $field['custom_manage_stock'] ) && $field['custom_manage_stock'] == 1 ) {
                
                if ( $value == 1 ) {
                    update_post_meta( $post_id, '_manage_stock', 'yes' );
                } else {
                    update_post_meta( $post_id, '_manage_stock', 'no' );
                }
            
            }
        }
        
        unset( $_POST['acf'][$field['key']] );
        return;
    }
    
    public function acfef_update_gallery_value( $value, $post_id, $field )
    {
        if ( !$this->acfef_is_custom( $field ) ) {
            return $value;
        }
        
        if ( $post_id ) {
            $edit_post = get_post( $post_id );
            if ( !is_wp_error( $edit_post ) ) {
                
                if ( isset( $field['custom_product_gallery'] ) && $field['custom_product_gallery'] == 1 ) {
                    $product_images = $value;
                    if ( is_array( $product_images ) ) {
                        $product_images = implode( ',', $product_images );
                    }
                    update_post_meta( $post_id, '_product_image_gallery', $product_images );
                }
            
            }
        }
        
        unset( $_POST['acf'][$field['key']] );
        return;
    }
    
    public function acfef_update_select_value( $value, $post_id, $field )
    {
        if ( !$this->acfef_is_custom( $field ) ) {
            return $value;
        }
        
        if ( $post_id ) {
            $edit_post = get_post( $post_id );
            
            if ( !is_wp_error( $edit_post ) ) {
                if ( isset( $field['custom_backorders'] ) && $field['custom_backorders'] == 1 ) {
                    update_post_meta( $post_id, '_backorders', $value );
                }
                if ( isset( $field['custom_stock_status'] ) && $field['custom_stock_status'] == 1 ) {
                    update_post_meta( $post_id, '_stock_status', $value );
                }
            } elseif ( strpos( $post_id, 'user' ) !== false ) {
                $user_id = explode( '_', $post_id )[1];
                $edit_user = get_user_by( 'ID', $user_id );
                
                if ( $edit_user ) {
                    if ( isset( $field['custom_user_role'] ) && $field['custom_user_role'] == 1 ) {
                        $user_to_edit['role'] = $value;
                    }
                    wp_update_user( $user_to_edit );
                }
            
            }
        
        }
        
        unset( $_POST['acf'][$field['key']] );
        return;
    }
    
    public function acfef_update_radio_value( $value, $post_id, $field )
    {
        if ( !$this->acfef_is_custom( $field ) ) {
            return $value;
        }
        
        if ( strpos( $post_id, 'user_' ) !== false ) {
            $user_id = explode( '_', $post_id )[1];
            $user_to_edit = [
                'ID' => $user_id,
            ];
            if ( isset( $field['custom_display_name'] ) && $field['custom_display_name'] == 1 ) {
                $user_to_edit['display_name'] = $value;
            }
            wp_update_user( $user_to_edit );
        }
        
        unset( $_POST['acf'][$field['key']] );
        return;
    }
    
    public function acfef_update_repeater_value( $value, $post_id, $field )
    {
        if ( empty($field['filter_row_edit']) || is_admin() ) {
            return $value;
        }
        
        if ( !empty($value) ) {
            $rows = [];
            $value = array_values( $value );
            $old_value = (int) acf_get_metadata( $post_id, $field['name'] );
            $value_rows = count( $value );
            // remove acfcloneindex
            if ( isset( $value['acfcloneindex'] ) ) {
                unset( $value['acfcloneindex'] );
            }
            $new_value = 0;
            // loop through rows
            for ( $i = 0 ;  $i < $old_value ;  $i++ ) {
                $row_author = acf_get_metadata( $post_id, $field['name'] . '_' . $i . '_row_author' );
                
                if ( !empty($value[$new_value]) && (!$row_author || $row_author == $value[$new_value]['acfef_row_author']) && $row_author != 'user_0' ) {
                    $rows[] = $value[$new_value];
                    $new_value++;
                } else {
                    $rows = $this->add_row(
                        $rows,
                        $i,
                        $field,
                        $post_id
                    );
                }
            
            }
            // remove old rows
            if ( $value_rows > $new_value ) {
                // loop
                for ( $i = $new_value ;  $i < $value_rows ;  $i++ ) {
                    $rows[] = $value[$i];
                }
            }
        }
        
        return $rows;
    }
    
    public function add_row(
        $rows,
        $i = 0,
        $field,
        $post_id
    )
    {
        // bail early if no layout reference
        if ( !is_array( $rows ) ) {
            return false;
        }
        // bail early if no layout
        if ( empty($field['sub_fields']) ) {
            return false;
        }
        $new_row = [];
        // loop
        foreach ( $field['sub_fields'] as $sub_field ) {
            $sub_field['name'] = "{$field['name']}_{$i}_{$sub_field['name']}";
            // value
            $value = acf_get_metadata( $post_id, $sub_field['name'] );
            $new_row[$sub_field['key']] = $value;
        }
        $rows[] = $new_row;
        return $rows;
    }
    
    public function acfef_before_save_post( $post_id )
    {
        if ( !isset( $_POST['acf'] ) ) {
            return $post_id;
        }
        $form = false;
        
        if ( isset( $_POST['_acf_form'] ) ) {
            // Load registered form using id.
            $form = acf()->form_front->get_form( $_POST['_acf_form'] );
            // Fallback to encrypted JSON.
            if ( !$form ) {
                $form = json_decode( acf_decrypt( $_POST['_acf_form'] ), true );
            }
        }
        
        $edit_post = get_post( $post_id );
        
        if ( $edit_post ) {
            $post_to_edit = [
                'ID' => $post_id,
            ];
            if ( isset( $form['post_status'] ) ) {
                $post_to_edit['post_status'] = $form['post_status'];
            }
            if ( isset( $_POST['acfef_save_draft'] ) ) {
                $post_to_edit['post_status'] = 'draft';
            }
            
            if ( isset( $form['new_post_terms'] ) && $form['new_post_terms'] != '' ) {
                $new_terms = $form['new_post_terms'];
                if ( is_string( $new_terms ) ) {
                    $new_terms = explode( ',', $new_terms );
                }
                if ( is_array( $new_terms ) ) {
                    foreach ( $new_terms as $term_id ) {
                        $term = get_term( $term_id );
                        if ( $term ) {
                            wp_set_object_terms(
                                $post_id,
                                $term->term_id,
                                $term->taxonomy,
                                true
                            );
                        }
                    }
                }
            }
            
            if ( isset( $_POST['_acf_element_id'] ) ) {
                update_post_meta( $post_id, 'acfef_form_source', $_POST['_acf_element_id'] );
            }
            $featured_image = get_post_meta( $post_id, '_thumbnail_id', true );
            if ( empty($featured_image) && isset( $form ) && !empty($form['featured_image']) ) {
                update_post_meta( $post_id, '_thumbnail_id', $form['featured_image'] );
            }
            
            if ( isset( $form ) && !empty($form['title_structure']) && empty($edit_post->post_title) ) {
                $post_to_edit['post_title'] = acfef_shortcode( $form['title_structure'], $post_id );
                $post_to_edit['post_title'] = acfef_get_post_match_value( $post_to_edit['post_title'], $post_id );
            }
            
            remove_action(
                'acf/save_post',
                [ $this, 'acfef_before_save_post' ],
                9,
                1
            );
            $post_id = wp_update_post( $post_to_edit );
            add_action(
                'acf/save_post',
                [ $this, 'acfef_before_save_post' ],
                9,
                1
            );
        }
        
        return $post_id;
    }
    
    public function acfef_after_save_post( $post_id )
    {
        if ( !isset( $_POST['acf'] ) ) {
            return $post_id;
        }
        $form = false;
        
        if ( isset( $_POST['_acf_form'] ) ) {
            // Load registered form using id.
            $form = acf()->form_front->get_form( $_POST['_acf_form'] );
            // Fallback to encrypted JSON.
            if ( !$form ) {
                $form = json_decode( acf_decrypt( $_POST['_acf_form'] ), true );
            }
        }
        
        
        if ( strpos( $post_id, 'user_' ) !== false ) {
            $user_id = explode( 'user_', $post_id )[1];
            $user_to_edit = get_user_by( 'ID', $user_id );
            if ( isset( $form['user_manager'] ) ) {
                update_user_meta( $user_id, 'acfef_manager', $form['user_manager'] );
            }
            
            if ( isset( $form['display_name'] ) ) {
                if ( $form['display_name'] == 'default' || isset( $_POST['custom_display_name'] ) ) {
                    return $post_id;
                }
                switch ( $form['display_name'] ) {
                    case 'user_login':
                        $display_name = $user_to_edit->user_login;
                        break;
                    case 'user_email':
                        $display_name = $user_to_edit->user_email;
                        break;
                    case 'first_name':
                        $display_name = $user_to_edit->first_name;
                        break;
                    case 'last_name':
                        $display_name = $user_to_edit->last_name;
                        break;
                    case 'nickname':
                        $display_name = $user_to_edit->nickname;
                        break;
                    case 'first_last':
                        $display_name = $user_to_edit->first_name . ' ' . $user_to_edit->last_name;
                        break;
                }
                if ( isset( $display_name ) ) {
                    wp_update_user( [
                        'ID'           => $user_id,
                        'display_name' => $display_name,
                    ] );
                }
            }
        
        }
        
        return $post_id;
    }
    
    public function acfef_exclude_groups( $field_group )
    {
        
        if ( !isset( $field_group['acfef_group'] ) ) {
            return $field_group;
        } elseif ( is_admin() ) {
            global  $acfef_settings ;
            
            if ( function_exists( 'get_current_screen' ) ) {
                $current_screen = get_current_screen();
                
                if ( isset( $current_screen->post_type ) && $current_screen->post_type == 'acfef_payment' ) {
                    return $field_group;
                } elseif ( isset( $current_screen->id ) && $current_screen->id == $acfef_settings ) {
                    return $field_group;
                } else {
                    return false;
                }
            
            }
        
        }
        
        $field_group['fields'] = [];
        return $field_group;
    }
    
    public function acfef_skip_validation()
    {
        if ( isset( $_POST['acfef_save_draft'] ) ) {
            acf_reset_validation_errors();
        }
    }
    
    public function acfef_validate_useremail(
        $is_valid,
        $value,
        $field,
        $input
    )
    {
        if ( !isset( $_POST['_acf_post_id'] ) || strpos( $_POST['_acf_post_id'], 'user' ) === false ) {
            return true;
        }
        
        if ( isset( $field['custom_email'] ) && $field['custom_email'] == 1 ) {
            if ( $field['required'] == 0 && $value == '' ) {
                return true;
            }
            
            if ( email_exists( $value ) ) {
                $user_id = explode( 'user_', $_POST['_acf_post_id'] );
                
                if ( $user_id[1] ) {
                    $user_to_edit = get_user_by( 'ID', $user_id[1] );
                    if ( $user_to_edit && $user_to_edit->user_email == $value ) {
                        return true;
                    }
                }
                
                return sprintf( __( 'The email %s is already assigned to an existing account. Please try a different email or login to your account', 'acf-frontend-form-element' ), $value );
            }
        
        }
        
        return true;
    }
    
    public function acfef_validate_username(
        $is_valid,
        $value,
        $field,
        $input
    )
    {
        if ( !isset( $_POST['_acf_post_id'] ) || strpos( $_POST['_acf_post_id'], 'user' ) === false ) {
            return true;
        }
        if ( isset( $_POST['_acf_main_action'] ) && $_POST['_acf_main_action'] == 'edit_user' && $field['required'] == 0 && $value == '' ) {
            return true;
        }
        $user_id = explode( '_', $_POST['_acf_post_id'] )[1];
        $user_to_edit = get_user_by( 'ID', $user_id );
        
        if ( isset( $field['custom_username'] ) && $field['custom_username'] == 1 ) {
            
            if ( username_exists( $value ) ) {
                if ( $user_to_edit && $user_to_edit->user_login == $value ) {
                    return true;
                }
                return __( 'The username ' . $value . ' is taken. Please try a different username', 'acf-frontend-form-element' );
            }
            
            if ( !validate_username( $value ) ) {
                return __( 'The username contains illegal characters. Please enter only latin letters, numbers, @, -, . and _', 'acf-frontend-form-element' );
            }
        }
        
        return true;
    }
    
    public function acfef_validate_password(
        $is_valid,
        $value,
        $field,
        $input
    )
    {
        if ( !isset( $_POST['_acf_post_id'] ) || strpos( $_POST['_acf_post_id'], 'user' ) === false ) {
            return true;
        }
        if ( isset( $field['custom_password_confirm'] ) && $field['custom_password_confirm'] == 1 ) {
            if ( $_POST['acf'][$_POST['custom_password']] != $value ) {
                return __( 'The passwords do not match', 'acf-frontend-form-element' );
            }
        }
        
        if ( isset( $field['custom_password'] ) && $field['custom_password'] == 1 ) {
            if ( isset( $_POST['custom_password_confirm'] ) && $_POST['acf'][$_POST['custom_password_confirm']] != $value ) {
                return __( 'The passwords do not match', 'acf-frontend-form-element' );
            }
            
            if ( (int) esc_attr( $_POST['password-strength'] ) < (int) esc_attr( $_POST['required-strength'] ) ) {
                if ( $field['required'] == 0 && $value == '' ) {
                    return true;
                }
                return __( 'The password is too weak. Please make it stronger.', 'acf-frontend-form-element' );
            }
        
        }
        
        return true;
    }
    
    function happy_files_folder( $query )
    {
        if ( empty($_POST['query']['_acfuploader']) ) {
            return $query;
        }
        // load field
        $field = acf_get_field( $_POST['query']['_acfuploader'] );
        if ( !$field ) {
            return $query;
        }
        if ( !isset( $field['happy_files_folder'] ) || $field['happy_files_folder'] == 'all' ) {
            return $query;
        }
        
        if ( isset( $query['tax_query'] ) ) {
            $tax_query = $query['tax_query'];
        } else {
            $tax_query = [];
        }
        
        $tax_query[] = array(
            'taxonomy' => 'happyfiles_category',
            'field'    => 'name',
            'terms'    => $field['happy_files_folder'],
        );
        $query['tax_query'] = $tax_query;
        return $query;
    }
    
    public function acfef_render_text_field( $field )
    {
        if ( isset( $field['custom_username'] ) && $field['custom_username'] == 1 ) {
            echo  '<input type="hidden" name="custom_username" value="' . $field['key'] . '"/>' ;
        }
    }
    
    public function acfef_render_password_field( $field )
    {
        
        if ( isset( $field['custom_password'] ) && $field['custom_password'] == 1 ) {
            echo  '<input type="hidden" name="custom_password" value="' . $field['key'] . '"/>' ;
            
            if ( isset( $field['password_strength'] ) ) {
                echo  '<span id="password-strength"></span>' ;
                echo  '<input type="hidden" value="' . $field['password_strength'] . '" name="required-strength"/>' ;
                echo  '<input class="password-strength" type="hidden" value="" name="password-strength"/>' ;
            }
        
        }
        
        if ( isset( $field['custom_password_confirm'] ) && $field['custom_password_confirm'] == 1 ) {
            echo  '<input type="hidden" name="custom_password_confirm" value="' . $field['key'] . '"/>' ;
        }
    }
    
    public function acfef_render_email_field( $field )
    {
        if ( isset( $field['custom_email'] ) && $field['custom_email'] == 1 ) {
            echo  '<input type="hidden" name="custom_email" value="' . $field['key'] . '"/>' ;
        }
    }
    
    public function acfef_render_select_field( $field )
    {
        if ( isset( $field['custom_user_role'] ) && $field['custom_user_role'] == 1 ) {
            echo  '<input type="hidden" name="custom_user_role" value="' . $field['key'] . '"/>' ;
        }
    }
    
    public function acfef_recaptcha_enqueue_scripts()
    {
        wp_enqueue_script(
            'acfef-recaptcha',
            ACFEF_URL . '/includes/acf-field-settings/assets/js/recaptcha.js',
            array( 'jquery' ),
            '4.1'
        );
    }
    
    public function acfef_fields_enqueue_scripts()
    {
        wp_enqueue_style( 'dashicons' );
        /* wp_enqueue_style( 'acfef-fields', ACFEF_URL . '/includes/acf-field-settings/assets/css/fields.css', array(), '4.1.2' );
        		wp_enqueue_script( 'acfef-fields', ACFEF_URL . '/includes/acf-field-settings/assets/js/fields.js', array('jquery', 'acf-input' ), '4.1.2', true ); */
    }
    
    public function __construct()
    {
        add_action( 'acf/enqueue_scripts', [ $this, 'acfef_fields_enqueue_scripts' ] );
        add_filter( 'acf/prepare_field', [ $this, 'acfef_render_frontend' ] );
        add_filter( 'acf/prepare_field', [ $this, 'acfef_username_disabled' ] );
        add_filter( 'acf/load_field', [ $this, 'acfef_repeater_row_author' ] );
        //Add field settings by type
        add_action( 'acf/render_field_settings', [ $this, 'acfef_frontend_setting' ] );
        add_action( 'acf/render_field_settings/type=text', [ $this, 'acfef_title_field' ] );
        //add_action( 'acf/render_field_settings/type=post_object',  [ $this, 'acfef_add_edit_field' ] );
        //add_action( 'acf/render_field_settings/type=relationship',  [ $this, 'acfef_add_edit_field' ] );
        
        if ( class_exists( 'woocommerce' ) ) {
            add_action( 'acf/render_field_settings/type=number', [ $this, 'acfef_price_field' ] );
            add_action( 'acf/render_field_settings/type=true_false', [ $this, 'acfef_true_false_field' ] );
            add_action( 'acf/render_field_settings/type=gallery', [ $this, 'acfef_gallery_field' ] );
        }
        
        add_action( 'acf/render_field_settings/type=email', [ $this, 'acfef_email_field' ] );
        add_action( 'acf/render_field_settings/type=password', [ $this, 'acfef_password_field' ] );
        add_action( 'acf/render_field_settings/type=textarea', [ $this, 'acfef_content_field' ] );
        add_action( 'acf/render_field_settings/type=wysiwyg', [ $this, 'acfef_content_field' ] );
        add_action( 'acf/render_field_settings/type=textarea', [ $this, 'acfef_excerpt_field' ] );
        add_action( 'acf/render_field_settings/type=image', [ $this, 'acfef_image_field' ] );
        add_action( 'acf/render_field_settings/type=repeater', [ $this, 'acfef_repeater_field' ], 5 );
        //Load field value by type
        add_filter(
            'acf/load_value/type=text',
            [ $this, 'acfef_load_text_value' ],
            10,
            3
        );
        add_filter(
            'acf/load_value/type=textarea',
            [ $this, 'acfef_load_textarea_value' ],
            10,
            3
        );
        add_filter(
            'acf/load_value/type=email',
            [ $this, 'acfef_load_email_value' ],
            10,
            3
        );
        add_filter(
            'acf/load_value/type=number',
            [ $this, 'acfef_load_number_value' ],
            10,
            3
        );
        add_filter(
            'acf/load_value/type=image',
            [ $this, 'acfef_load_image_value' ],
            10,
            3
        );
        add_filter(
            'acf/load_value/type=wysiwyg',
            [ $this, 'acfef_load_wysiwyg_value' ],
            10,
            3
        );
        add_filter(
            'acf/load_value/type=true_false',
            [ $this, 'acfef_load_truefalse_value' ],
            10,
            3
        );
        add_filter(
            'acf/load_value/type=gallery',
            [ $this, 'acfef_load_gallery_value' ],
            10,
            3
        );
        add_filter(
            'acf/load_value/type=select',
            [ $this, 'acfef_load_select_value' ],
            10,
            3
        );
        add_filter(
            'acf/load_value/type=radio',
            [ $this, 'acfef_load_radio_value' ],
            10,
            3
        );
        //add_action( 'acf/render_field/type=relationship',  [ $this, 'acfef_add_post_button' ], 10);
        //add_action( 'acf/render_field/type=post_object',  [ $this, 'acfef_add_post_option' ], 8);
        add_action( 'acf/render_field/type=repeater', [ $this, 'acfef_before_repeater_field' ], 8 );
        add_action( 'acf/render_field/type=repeater', [ $this, 'acfef_after_repeater_field' ], 10 );
        add_action(
            'acf/save_post',
            [ $this, 'acfef_before_save_post' ],
            9,
            1
        );
        add_action(
            'acf/save_post',
            [ $this, 'acfef_after_save_post' ],
            10,
            1
        );
        add_filter(
            'acf/load_value',
            [ $this, 'load_payment_option_values' ],
            10,
            3
        );
        add_filter(
            'acf/update_value',
            [ $this, 'update_payment_option_values' ],
            9,
            3
        );
        add_filter(
            'acf/update_value/type=text',
            [ $this, 'acfef_update_text_value' ],
            9,
            3
        );
        add_filter(
            'acf/update_value/type=true_false',
            [ $this, 'acfef_update_truefalse_value' ],
            9,
            3
        );
        add_filter(
            'acf/update_value/type=textarea',
            [ $this, 'acfef_update_textarea_value' ],
            9,
            3
        );
        add_filter(
            'acf/update_value/type=wysiwyg',
            [ $this, 'acfef_update_wysiwyg_value' ],
            9,
            3
        );
        add_filter(
            'acf/update_value/type=image',
            [ $this, 'acfef_update_image_value' ],
            9,
            3
        );
        add_filter(
            'acf/update_value/type=gallery',
            [ $this, 'acfef_update_gallery_value' ],
            9,
            3
        );
        add_filter(
            'acf/update_value/type=password',
            [ $this, 'acfef_update_password_value' ],
            9,
            3
        );
        add_filter(
            'acf/update_value/type=email',
            [ $this, 'acfef_update_email_value' ],
            9,
            3
        );
        add_filter(
            'acf/update_value/type=number',
            [ $this, 'acfef_update_number_value' ],
            9,
            3
        );
        add_filter(
            'acf/update_value/type=select',
            [ $this, 'acfef_update_select_value' ],
            9,
            3
        );
        add_filter(
            'acf/update_value/type=radio',
            [ $this, 'acfef_update_radio_value' ],
            9,
            3
        );
        add_filter(
            'acf/update_value/type=repeater',
            [ $this, 'acfef_update_repeater_value' ],
            9,
            3
        );
        add_filter( 'acf/load_field_group', [ $this, 'acfef_exclude_groups' ] );
        // Render extra input by field type
        add_action( 'acf/render_field/type=text', [ $this, 'acfef_render_text_field' ] );
        add_action( 'acf/render_field/type=password', [ $this, 'acfef_render_password_field' ] );
        add_action( 'acf/render_field/type=email', [ $this, 'acfef_render_email_field' ] );
        add_action( 'acf/render_field/type=select', [ $this, 'acfef_render_select_field' ] );
        add_action( 'acf/validate_save_post', [ $this, 'acfef_skip_validation' ] );
        add_filter(
            'acf/validate_value/type=email',
            [ $this, 'acfef_validate_useremail' ],
            10,
            4
        );
        add_filter(
            'acf/validate_value/type=text',
            [ $this, 'acfef_validate_username' ],
            10,
            4
        );
        add_filter(
            'acf/validate_value/type=password',
            [ $this, 'acfef_validate_password' ],
            10,
            4
        );
        
        if ( defined( 'HAPPYFILES_VERSION' ) ) {
            add_action( 'acf/render_field_settings/type=image', [ $this, 'acfef_file_folders_setting' ] );
            add_action( 'acf/render_field_settings/type=file', [ $this, 'acfef_file_folders_setting' ] );
            add_action( 'acf/render_field_settings/type=gallery', [ $this, 'acfef_file_folders_setting' ] );
            add_filter( 'ajax_query_attachments_args', [ $this, 'happy_files_folder' ] );
        }
    
    }

}