<?php

namespace ACFFrontend\Module\Widgets;

use  ACFFrontend\Plugin ;
use  ACFFrontend\Module\ACFEF_Module ;
use  ACFFrontend\Module\Classes ;
use  Elementor\Controls_Manager ;
use  Elementor\Controls_Stack ;
use  Elementor\Widget_Base ;
use  ElementorPro\Modules\QueryControl\Module as Query_Module ;
use  ACFFrontend\Module\Controls ;
use  Elementor\Group_Control_Typography ;
use  Elementor\Group_Control_Background ;
use  Elementor\Group_Control_Border ;
use  Elementor\Group_Control_Text_Shadow ;
use  Elementor\Group_Control_Box_Shadow ;

if ( !defined( 'ABSPATH' ) ) {
    exit;
    // Exit if accessed directly
}

/**
 * Elementor ACF Frontend Form Widget.
 *
 * Elementor widget that inserts an ACF frontend form into the page.
 *
 * @since 1.0.0
 */
class ACF_Frontend_Form_Widget extends Widget_Base
{
    public  $form_defaults ;
    /**
     * Get widget name.
     *
     * Retrieve acf ele form widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'acf_ele_form';
    }
    
    /**
     * Get widget action.
     *
     * Retrieve acf ele form widget defaults.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget action.
     */
    public function get_form_defaults()
    {
        return [
            'main_action'     => 'all',
            'form_title'      => __( 'Edit Post', 'acf-frontend-form-element' ),
            'submit'          => __( 'Update', 'acf-frontend-form-element' ),
            'success_message' => __( 'Your post has been updated successfully.', 'acf-frontend-form-element' ),
            'field_type'      => 'title',
            'fields'          => [ [
            'field_type'     => 'title',
            'field_label_on' => 'true',
            'field_required' => 'true',
        ], [
            'field_type'     => 'featured_image',
            'field_label_on' => 'true',
            'field_required' => 'true',
        ] ],
        ];
    }
    
    /**
     * Get widget title.
     *
     * Retrieve acf ele form widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return __( 'ACF Frontend Form', 'acf-frontend-form-element' );
    }
    
    /**
     * Get widget icon.
     *
     * Retrieve acf ele form widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'fa fa-wpforms frontend-icon';
    }
    
    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the acf ele form widget belongs to.
     *
     * @since 1.0.0
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories()
    {
        return [ 'acfef-forms' ];
    }
    
    /**
     * Register acf ele form widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls()
    {
        $this->register_form_structure_controls();
        $this->register_steps_controls();
        $this->register_actions_controls();
        $this->main_action_controls_section();
        $this->register_permissions_controls();
        $this->register_display_controls();
        $this->register_limit_controls();
        $this->register_style_tab_controls();
        
        if ( get_option( 'acfef_payments_active' ) && (get_option( 'acfef_stripe_active' ) || get_option( 'acfef_paypal_active' )) ) {
            do_action( 'acfef/content_controls', $this );
            do_action( 'acfef/styles_controls', $this );
        }
    
    }
    
    protected function register_form_structure_controls()
    {
        //get all field group choices
        $field_group_choices = acfef_get_acf_field_group_choices();
        $field_choices = acfef_get_acf_field_choices();
        $this->start_controls_section( 'fields_section', [
            'label' => __( 'Form Structure', 'acf-frontend-form-element' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'form_title', [
            'label'       => __( 'Form Title', 'acf-frontend-form-element' ),
            'label_block' => true,
            'type'        => Controls_Manager::TEXT,
            'default'     => $this->form_defaults['form_title'],
            'placeholder' => $this->form_defaults['form_title'],
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $this->add_control( 'form_id', [
            'label'       => __( 'Form ID', 'acf-frontend-form-element' ),
            'type'        => Controls_Manager::TEXT,
            'placeholder' => sanitize_title( $this->form_defaults['form_title'] ),
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $this->add_control( 'multi_step_promo', [
            'type'            => Controls_Manager::RAW_HTML,
            'raw'             => __( '<p><a target="_blank" href="https://www.frontendform.com/"><b>Go pro</b></a> to unlock multi step forms.</p>', 'acf-frontend-form-element' ),
            'content_classes' => 'acf-fields-note',
        ] );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control( 'field_type', [
            'label'       => __( 'Field Type', 'acf-frontend-form-element' ),
            'type'        => Controls_Manager::SELECT,
            'label_block' => true,
            'default'     => 'ACF_fields',
            'groups'      => $this->get_field_type_options(),
        ] );
        $repeater->add_control( 'field_groups_select', [
            'label'       => __( 'ACF Field Groups', 'acf-frontend-form-element' ),
            'type'        => Controls_Manager::SELECT2,
            'label_block' => true,
            'multiple'    => true,
            'options'     => $field_group_choices,
            'condition'   => [
            'field_type' => 'ACF_field_groups',
        ],
        ] );
        $repeater->add_control( 'fields_select', [
            'label'       => __( 'ACF Fields', 'acf-frontend-form-element' ),
            'type'        => Controls_Manager::SELECT2,
            'label_block' => true,
            'multiple'    => true,
            'options'     => $field_choices,
            'condition'   => [
            'field_type' => 'ACF_fields',
        ],
        ] );
        $repeater->add_control( 'fields_select_exclude', [
            'label'       => __( 'Exclude Specific Fields', 'acf-frontend-form-element' ),
            'type'        => Controls_Manager::SELECT2,
            'label_block' => true,
            'multiple'    => true,
            'options'     => $field_choices,
            'condition'   => [
            'field_type' => [ 'ACF_field_groups' ],
        ],
        ] );
        $repeater->start_controls_tabs( 'field_settings_tabs' );
        $repeater->start_controls_tab( 'field_content_tab', [
            'label'     => __( 'Content', 'acf-frontend-form-element' ),
            'condition' => [
            'field_type!' => [ 'ACF_field_groups', 'ACF_fields', 'step' ],
        ],
        ] );
        $custom_layouts = [
            'ACF_field_groups',
            'ACF_fields',
            'step',
            'message',
            'recaptcha'
        ];
        $text_fields = [
            'term_name',
            'username',
            'email',
            'first_name',
            'last_name',
            'nickname',
            'display_name',
            'bio',
            'title',
            'excerpt',
            'sku',
            'product_title',
            'price',
            'sale_price',
            'description',
            'short_description',
            'comment',
            'author',
            'author_email',
            'site_title',
            'site_tagline'
        ];
        $repeater->add_control( 'field_label_on', [
            'label'        => __( 'Show Label', 'acf-frontend-form-element' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'acf-frontend-form-element' ),
            'label_off'    => __( 'No', 'acf-frontend-form-element' ),
            'return_value' => 'true',
            'default'      => 'true',
            'condition'    => [
            'field_type!' => $custom_layouts,
        ],
        ] );
        $repeater->add_control( 'field_label', [
            'label'       => __( 'Label', 'acf-frontend-form-element' ),
            'type'        => Controls_Manager::TEXT,
            'label_block' => true,
            'placeholder' => __( 'Field Label', 'acf-frontend-form-element' ),
            'dynamic'     => [
            'active' => true,
        ],
            'condition'   => [
            'field_type!'    => $custom_layouts,
            'field_label_on' => 'true',
        ],
        ] );
        $repeater->add_control( 'field_placeholder', [
            'label'       => __( 'Placeholder', 'acf-frontend-form-element' ),
            'type'        => Controls_Manager::TEXT,
            'label_block' => true,
            'placeholder' => __( 'Field Placeholder', 'acf-frontend-form-element' ),
            'dynamic'     => [
            'active' => true,
        ],
            'condition'   => [
            'field_type' => $text_fields,
        ],
        ] );
        $repeater->add_control( 'field_default_value', [
            'label'       => __( 'Default Value', 'acf-frontend-form-element' ),
            'type'        => Controls_Manager::TEXT,
            'label_block' => true,
            'description' => __( 'This will populate a field if no value has been given yet. You can use shortcodes from other text fields. Foe example: [$acf:field_name]', 'acf-frontend-form-element' ),
            'dynamic'     => [
            'active' => true,
        ],
            'condition'   => [
            'field_type' => $text_fields,
        ],
        ] );
        $repeater->add_control( 'default_featured_image', [
            'label'     => __( 'Default Featured Image', 'acf-frontend-form-element' ),
            'type'      => \Elementor\Controls_Manager::MEDIA,
            'condition' => [
            'field_type' => 'featured_image',
        ],
        ] );
        $repeater->add_control( 'field_instruction', [
            'label'       => __( 'Instruction', 'acf-frontend-form-element' ),
            'type'        => Controls_Manager::TEXT,
            'label_block' => true,
            'placeholder' => __( 'Field Instruction', 'acf-frontend-form-element' ),
            'dynamic'     => [
            'active' => true,
        ],
            'condition'   => [
            'field_type!' => $custom_layouts,
        ],
        ] );
        $repeater->add_control( 'field_required', [
            'label'        => __( 'Required', 'acf-frontend-form-element' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'acf-frontend-form-element' ),
            'label_off'    => __( 'No', 'acf-frontend-form-element' ),
            'return_value' => 'true',
            'condition'    => [
            'field_type!' => $custom_layouts,
        ],
        ] );
        $repeater->add_control( 'field_hidden', [
            'label'        => __( 'Hidden', 'acf-frontend-form-element' ),
            'type'         => Controls_Manager::SWITCHER,
            'description'  => __( 'This will hide the field. Useful if used with a default value. Warning: do not hide required field if they do not have a default value!', 'acf-frontend-form-element' ),
            'label_on'     => __( 'Yes', 'acf-frontend-form-element' ),
            'label_off'    => __( 'No', 'acf-frontend-form-element' ),
            'return_value' => 'true',
            'condition'    => [
            'field_type!' => $custom_layouts,
        ],
        ] );
        $repeater->add_control( 'field_disabled', [
            'label'        => __( 'Disabled', 'acf-frontend-form-element' ),
            'type'         => Controls_Manager::SWITCHER,
            'description'  => __( 'This will prevent users from editing the field and the data will not be sent.', 'acf-frontend-form-element' ),
            'label_on'     => __( 'Yes', 'acf-frontend-form-element' ),
            'label_off'    => __( 'No', 'acf-frontend-form-element' ),
            'return_value' => 'true',
            'condition'    => [
            'field_type!' => $custom_layouts,
        ],
        ] );
        $repeater->add_control( 'field_readonly', [
            'label'        => __( 'Readonly', 'acf-frontend-form-element' ),
            'type'         => Controls_Manager::SWITCHER,
            'description'  => __( 'This will prevent users from editing the field.', 'acf-frontend-form-element' ),
            'label_on'     => __( 'Yes', 'acf-frontend-form-element' ),
            'label_off'    => __( 'No', 'acf-frontend-form-element' ),
            'return_value' => 'true',
            'condition'    => [
            'field_type' => $text_fields,
        ],
        ] );
        $repeater->add_control( 'field_message', [
            'label'       => __( 'Message', 'acf-frontend-form-element' ),
            'type'        => \Elementor\Controls_Manager::WYSIWYG,
            'default'     => __( 'You can add here text, images template shortcodes, and more', 'acf-frontend-form-element' ),
            'placeholder' => __( 'Type your message here', 'acf-frontend-form-element' ),
            'condition'   => [
            'field_type' => 'message',
        ],
        ] );
        $repeater->add_control( 'role_field_options', [
            'label'       => __( 'Roles to Choose From', 'acf-frontend-form-element' ),
            'type'        => Controls_Manager::SELECT2,
            'label_block' => true,
            'multiple'    => true,
            'default'     => [ 'subscriber' ],
            'options'     => acfef_get_user_roles(),
            'condition'   => [
            'field_type' => 'role',
        ],
        ] );
        $repeater->add_control( 'default_role', [
            'label'       => __( 'Default Role Option', 'acf-frontend-form-element' ),
            'type'        => Controls_Manager::SELECT2,
            'label_block' => true,
            'default'     => [ 'subscriber' ],
            'options'     => acfef_get_user_roles(),
            'condition'   => [
            'field_type' => 'role',
        ],
        ] );
        $repeater->add_control( 'password_strength', [
            'label'       => __( 'Password Strength', 'acf-frontend-form-element' ),
            'type'        => Controls_Manager::SELECT,
            'label_block' => true,
            'default'     => '3',
            'options'     => [
            '1' => __( 'Very Weak', 'acf-frontend-form-element' ),
            '2' => __( 'Weak', 'acf-frontend-form-element' ),
            '3' => __( 'Medium', 'acf-frontend-form-element' ),
            '4' => __( 'Strong', 'acf-frontend-form-element' ),
        ],
            'condition'   => [
            'field_type' => 'password',
        ],
        ] );
        $repeater->add_control( 'field_taxonomy', [
            'label'       => __( 'Taxonomy', 'acf-frontend-form-element' ),
            'type'        => Controls_Manager::SELECT,
            'label_block' => true,
            'default'     => 'category',
            'options'     => acf_get_taxonomy_labels(),
            'condition'   => [
            'field_type' => 'taxonomy',
        ],
        ] );
        $repeater->add_control( 'field_taxonomy_appearance', [
            'label'     => __( 'Appearance', 'acf-frontend-form-element' ),
            'type'      => Controls_Manager::SELECT,
            'default'   => 'checkbox',
            'groups'    => [
            'multi'  => [
            'label'   => __( 'Multiple Value', 'acf-frontend-form-element' ),
            'options' => [
            'checkbox'     => __( 'Checkboxes', 'acf-frontend-form-element' ),
            'multi_select' => __( 'Multi Select', 'acf-frontend-form-element' ),
        ],
        ],
            'single' => [
            'label'   => __( 'Single Value', 'acf-frontend-form-element' ),
            'options' => [
            'radio'  => __( 'Radio Buttons', 'acf-frontend-form-element' ),
            'select' => __( 'Select', 'acf-frontend-form-element' ),
        ],
        ],
        ],
            'condition' => [
            'field_type' => [
            'taxonomy',
            'categories',
            'tags',
            'product_categories',
            'product_tags'
        ],
        ],
        ] );
        $repeater->add_control( 'field_add_term', [
            'label'        => __( 'Add Term', 'acf-frontend-form-element' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'acf-frontend-form-element' ),
            'label_off'    => __( 'No', 'acf-frontend-form-element' ),
            'return_value' => 'true',
            'condition'    => [
            'field_type' => [
            'taxonomy',
            'categories',
            'tags',
            'product_categories',
            'product_tags'
        ],
        ],
        ] );
        $repeater->add_control( 'set_as_username', [
            'label'        => __( 'Set as username', 'acf-frontend-form-element' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'acf-frontend-form-element' ),
            'label_off'    => __( 'No', 'acf-frontend-form-element' ),
            'return_value' => 'true',
            'condition'    => [
            'field_type' => 'email',
        ],
        ] );
        $repeater->add_control( 'allow_edit', [
            'label'        => __( 'Allow Edit', 'acf-frontend-form-element' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'acf-frontend-form-element' ),
            'label_off'    => __( 'No', 'acf-frontend-form-element' ),
            'description'  => __( 'WARNING: allowing your users to change their username might affect your existing urls and their SEO rating', 'acf-frontend-form-element' ),
            'return_value' => 'true',
            'condition'    => [
            'field_type' => 'username',
        ],
        ] );
        $repeater->add_control( 'ui_on', [
            'label'     => __( 'On Text', 'woocommerce' ),
            'type'      => Controls_Manager::TEXT,
            'default'   => __( 'Yes', 'woocommerce' ),
            'dynamic'   => [
            'active' => true,
        ],
            'condition' => [
            'field_type' => [ 'manage_stock', 'sold_individually' ],
        ],
        ] );
        $repeater->add_control( 'ui_off', [
            'label'     => __( 'Off Text', 'woocommerce' ),
            'type'      => Controls_Manager::TEXT,
            'default'   => __( 'No', 'woocommerce' ),
            'dynamic'   => [
            'active' => true,
        ],
            'condition' => [
            'field_type' => [ 'manage_stock', 'sold_individually' ],
        ],
        ] );
        $repeater->add_control( 'stock_choices', [
            'show_label' => false,
            'type'       => Controls_Manager::RAW_HTML,
            'seperator'  => 'before',
            'raw'        => "<h3>Choices</h3>",
            'condition'  => [
            'field_type' => 'stock_status',
        ],
        ] );
        $repeater->add_control( 'instock', [
            'label'     => __( 'In stock', 'woocommerce' ),
            'type'      => Controls_Manager::TEXT,
            'default'   => __( 'In stock', 'woocommerce' ),
            'dynamic'   => [
            'active' => true,
        ],
            'condition' => [
            'field_type' => 'stock_status',
        ],
        ] );
        $repeater->add_control( 'outofstock', [
            'label'     => __( 'Out of stock', 'woocommerce' ),
            'type'      => Controls_Manager::TEXT,
            'default'   => __( 'Out of stock', 'woocommerce' ),
            'dynamic'   => [
            'active' => true,
        ],
            'condition' => [
            'field_type' => 'stock_status',
        ],
        ] );
        $repeater->add_control( 'backorder', [
            'label'     => __( 'On backorder', 'woocommerce' ),
            'type'      => Controls_Manager::TEXT,
            'default'   => __( 'On backorder', 'woocommerce' ),
            'dynamic'   => [
            'active' => true,
        ],
            'condition' => [
            'field_type' => 'stock_status',
        ],
        ] );
        $repeater->add_control( 'backorder_choices', [
            'show_label' => false,
            'type'       => Controls_Manager::RAW_HTML,
            'seperator'  => 'before',
            'raw'        => "<h4>Choices</h4>",
            'condition'  => [
            'field_type' => 'allow_backorders',
        ],
        ] );
        $repeater->add_control( 'do_not_allow', [
            'label'     => __( 'Do not allow', 'woocommerce' ),
            'type'      => Controls_Manager::TEXT,
            'default'   => __( 'Do not allow', 'woocommerce' ),
            'dynamic'   => [
            'active' => true,
        ],
            'condition' => [
            'field_type' => 'allow_backorders',
        ],
        ] );
        $repeater->add_control( 'notify', [
            'label'     => __( 'Notify', 'woocommerce' ),
            'type'      => Controls_Manager::TEXT,
            'default'   => __( 'Allow, but notify customers', 'woocommerce' ),
            'dynamic'   => [
            'active' => true,
        ],
            'condition' => [
            'field_type' => 'allow_backorders',
        ],
        ] );
        $repeater->add_control( 'allow', [
            'label'     => __( 'Allow', 'woocommerce' ),
            'type'      => Controls_Manager::TEXT,
            'default'   => __( 'Allow', 'woocommerce' ),
            'dynamic'   => [
            'active' => true,
        ],
            'condition' => [
            'field_type' => 'allow_backorders',
        ],
        ] );
        $repeater->add_control( 'recaptcha_version', [
            'label'     => __( 'Version', 'acf-frontend-form-element' ),
            'type'      => Controls_Manager::SELECT,
            'options'   => [
            'v2' => __( 'Version 2', 'acf-frontend-form-element' ),
            'v3' => __( 'Version 3', 'acf-frontend-form-element' ),
        ],
            'default'   => 'v2',
            'condition' => [
            'field_type' => 'recaptcha',
        ],
        ] );
        $repeater->add_control( 'recaptcha_site_key', [
            'label'       => __( 'Site Key', 'acf-frontend-form-element' ),
            'label_block' => true,
            'type'        => Controls_Manager::TEXT,
            'dynamic'     => [
            'active' => true,
        ],
            'default'     => get_option( 'acfef_google_recaptcha_site' ),
            'condition'   => [
            'field_type' => 'recaptcha',
        ],
        ] );
        $repeater->add_control( 'recaptcha_secret_key', [
            'label'       => __( 'Secret Key', 'acf-frontend-form-element' ),
            'label_block' => true,
            'type'        => Controls_Manager::TEXT,
            'dynamic'     => [
            'active' => true,
        ],
            'default'     => get_option( 'acfef_google_recaptcha_secret' ),
            'condition'   => [
            'field_type' => 'recaptcha',
        ],
        ] );
        $repeater->add_control( 'recaptcha_note', [
            'show_label' => false,
            'type'       => \Elementor\Controls_Manager::RAW_HTML,
            'raw'        => '<br>' . __( 'If you don\'t already have a site key and a secret, you may generate them here:', 'acf-frontend-form-element' ) . ' <a href="https://www.google.com/recaptcha/admin"> reCaptcha API Admin </a>',
            'condition'  => [
            'field_type' => 'recaptcha',
        ],
        ] );
        $repeater->add_control( 'recaptcha_v2_note', [
            'show_label' => false,
            'type'       => \Elementor\Controls_Manager::RAW_HTML,
            'raw'        => '<br><br>' . __( 'For reCaptcha v2, you may use the following keys for testing purposes only:', 'acf-frontend-form-element' ) . '<br><br>' . __( 'Site Key', 'acf-frontend-form-element' ) . ' <input type="text" readonly value="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI" /> 
					<br>' . __( 'Secret Key', 'acf-frontend-form-element' ) . ' <input type="text" readonly value="6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe" />',
            'condition'  => [
            'field_type'        => 'recaptcha',
            'recaptcha_version' => 'v2',
        ],
        ] );
        $repeater->end_controls_tab();
        $repeater->start_controls_tab( 'field_style_tab', [
            'label'     => __( 'Style', 'acf-frontend-form-element' ),
            'condition' => [
            'field_type!' => [ 'ACF_field_groups', 'ACF_fields', 'step' ],
        ],
        ] );
        $repeater->add_control( 'recaptcha_theme', [
            'label'     => __( 'Version', 'acf-frontend-form-element' ),
            'type'      => Controls_Manager::SELECT,
            'options'   => [
            'light' => __( 'Light', 'acf-frontend-form-element' ),
            'dark'  => __( 'Dark', 'acf-frontend-form-element' ),
        ],
            'default'   => 'light',
            'condition' => [
            'field_type'        => 'recaptcha',
            'recaptcha_version' => 'v2',
        ],
        ] );
        $repeater->add_control( 'recaptcha_size', [
            'label'     => __( 'Version', 'acf-frontend-form-element' ),
            'type'      => Controls_Manager::SELECT,
            'options'   => [
            'normal'  => __( 'Normal', 'acf-frontend-form-element' ),
            'compact' => __( 'Compact', 'acf-frontend-form-element' ),
        ],
            'default'   => 'normal',
            'condition' => [
            'field_type'        => 'recaptcha',
            'recaptcha_version' => 'v2',
        ],
        ] );
        $repeater->add_control( 'recaptcha_hide_logo', [
            'label'        => __( 'Hide Logo', 'acf-frontend-form-element' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'acf-frontend-form-element' ),
            'label_off'    => __( 'No', 'acf-frontend-form-element' ),
            'return_value' => 'true',
            'condition'    => [
            'field_type'        => 'recaptcha',
            'recaptcha_version' => 'v3',
        ],
        ] );
        $repeater->add_control( 'field_text_color', [
            'label'     => __( 'Text Color', 'elementor-pro' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} {{CURRENT_ITEM}} input'                            => 'color: {{VALUE}};',
            '{{WRAPPER}} {{CURRENT_ITEM}} textarea'                         => 'color: {{VALUE}};',
            '{{WRAPPER}} {{CURRENT_ITEM}} select'                           => 'color: {{VALUE}};',
            '{{WRAPPER}} {{CURRENT_ITEM}} span.select2-selection__rendered' => 'color: {{VALUE}};',
        ],
        ] );
        $repeater->add_control( 'field_placeholder_text_color', [
            'label'     => __( 'Placeholder Text Color', 'elementor-pro' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} {{CURRENT_ITEM}} input::placeholder'    => 'color: {{VALUE}};',
            '{{WRAPPER}} {{CURRENT_ITEM}} textarea::placeholder' => 'color: {{VALUE}};',
            '{{WRAPPER}} {{CURRENT_ITEM}} select::placeholder'   => 'color: {{VALUE}};',
        ],
        ] );
        $repeater->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'field_typography',
            'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} input, {{WRAPPER}} {{CURRENT_ITEM}} textarea, {{WRAPPER}} {{CURRENT_ITEM}} select, {{WRAPPER}} .select2-selection__rendered, {{WRAPPER}} .input-subgroup label',
        ] );
        $repeater->add_control( 'field_background_color', [
            'label'     => __( 'Background Color', 'elementor-pro' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [
            '{{WRAPPER}} {{CURRENT_ITEM}} input'                         => 'background-color: {{VALUE}};',
            '{{WRAPPER}} {{CURRENT_ITEM}} textarea'                      => 'background-color: {{VALUE}};',
            '{{WRAPPER}} {{CURRENT_ITEM}} .acf-input select'             => 'background-color: {{VALUE}};',
            '{{WRAPPER}} {{CURRENT_ITEM}} .acf-input .select2-selection' => 'background-color: {{VALUE}};',
        ],
            'separator' => 'before',
        ] );
        $repeater->add_responsive_control( 'field_text_padding', [
            'label'      => __( 'Padding', 'elementor-pro' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em' ],
            'selectors'  => [
            '{{WRAPPER}} {{CURRENT_ITEM}} input'                         => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            '{{WRAPPER}} {{CURRENT_ITEM}} textarea'                      => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            '{{WRAPPER}} {{CURRENT_ITEM}} .acf-input select'             => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            '{{WRAPPER}} {{CURRENT_ITEM}} .acf-input select *'           => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            '{{WRAPPER}} {{CURRENT_ITEM}} .acf-input .select2-selection' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        $repeater->add_control( 'field_border_color', [
            'label'     => __( 'Border Color', 'elementor-pro' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} {{CURRENT_ITEM}}  input'                        => 'border-color: {{VALUE}};',
            '{{WRAPPER}} {{CURRENT_ITEM}} .acf-input select'             => 'border-color: {{VALUE}};',
            '{{WRAPPER}} {{CURRENT_ITEM}} .acf-input .select2-selection' => 'border-color: {{VALUE}};',
            '{{WRAPPER}} {{CURRENT_ITEM}} .acf-input::before'            => 'border-color: {{VALUE}};',
            '{{WRAPPER}} {{CURRENT_ITEM}} textarea'                      => 'border-color: {{VALUE}};',
        ],
            'separator' => 'before',
        ] );
        $repeater->add_control( 'field_border_width', [
            'label'       => __( 'Border Width', 'elementor-pro' ),
            'type'        => Controls_Manager::DIMENSIONS,
            'placeholder' => '1',
            'size_units'  => [ 'px' ],
            'selectors'   => [
            '{{WRAPPER}} {{CURRENT_ITEM}}  input'                        => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            '{{WRAPPER}} {{CURRENT_ITEM}} .acf-input select'             => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            '{{WRAPPER}} {{CURRENT_ITEM}} .acf-input .select2-selection' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            '{{WRAPPER}} {{CURRENT_ITEM}} .acf-input textarea'           => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        $repeater->add_control( 'field_border_radius', [
            'label'      => __( 'Border Radius', 'elementor-pro' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors'  => [
            '{{WRAPPER}} {{CURRENT_ITEM}}  input'                        => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            '{{WRAPPER}} {{CURRENT_ITEM}} .acf-input select'             => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            '{{WRAPPER}} {{CURRENT_ITEM}} .acf-input .select2-selection' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            '{{WRAPPER}} {{CURRENT_ITEM}} textarea'                      => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        $repeater->add_responsive_control( 'field_width', [
            'label'               => __( 'Width', 'acf-frontend-form-element' ) . ' (%)',
            'type'                => Controls_Manager::NUMBER,
            'min'                 => 30,
            'max'                 => 100,
            'default'             => 100,
            'required'            => true,
            'device_args'         => [
            Controls_Stack::RESPONSIVE_TABLET => [
            'max'      => 100,
            'required' => false,
        ],
            Controls_Stack::RESPONSIVE_MOBILE => [
            'default'  => 100,
            'required' => false,
        ],
        ],
            'min_affected_device' => [
            Controls_Stack::RESPONSIVE_DESKTOP => Controls_Stack::RESPONSIVE_TABLET,
            Controls_Stack::RESPONSIVE_TABLET  => Controls_Stack::RESPONSIVE_TABLET,
        ],
            'selectors'           => [
            'body:not(.rtl) {{WRAPPER}} {{CURRENT_ITEM}}' => 'float: left; clear: none',
            'body.rtl {{WRAPPER}} {{CURRENT_ITEM}}'       => 'float: right; clear: none',
            '{{WRAPPER}} {{CURRENT_ITEM}}'                => 'width: {{VALUE}}%',
        ],
            'condition'           => [
            'field_type!' => [ 'ACF_field_groups', 'ACF_fields', 'step' ],
        ],
        ] );
        $repeater->add_responsive_control( 'field_margin', [
            'label'               => __( 'Margin', 'elementor-pro' ),
            'type'                => Controls_Manager::DIMENSIONS,
            'size_units'          => [ '%', 'px', 'em' ],
            'default'             => [
            'unit'     => '%',
            'top'      => 'o',
            'bottom'   => 'o',
            'left'     => 'o',
            'right'    => 'o',
            'isLinked' => 'false',
        ],
            'isLinked'            => 'false',
            'min_affected_device' => [
            Controls_Stack::RESPONSIVE_DESKTOP => Controls_Stack::RESPONSIVE_TABLET,
            Controls_Stack::RESPONSIVE_TABLET  => Controls_Stack::RESPONSIVE_TABLET,
        ],
            'selectors'           => [
            '{{WRAPPER}} {{CURRENT_ITEM}}' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        $repeater->add_responsive_control( 'field_padding', [
            'label'               => __( 'Padding', 'elementor-pro' ),
            'type'                => Controls_Manager::DIMENSIONS,
            'size_units'          => [ '%', 'px', 'em' ],
            'default'             => [
            'top'      => 'o',
            'bottom'   => 'o',
            'left'     => 'o',
            'right'    => 'o',
            'isLinked' => 'false',
            'unit'     => '%',
        ],
            'min'                 => 0,
            'isLinked'            => 'false',
            'min_affected_device' => [
            Controls_Stack::RESPONSIVE_DESKTOP => Controls_Stack::RESPONSIVE_TABLET,
            Controls_Stack::RESPONSIVE_TABLET  => Controls_Stack::RESPONSIVE_TABLET,
        ],
            'selectors'           => [
            '{{WRAPPER}} {{CURRENT_ITEM}}' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        $repeater->end_controls_tab();
        $repeater->end_controls_tabs();
        $this->add_control( 'fields_selection', [
            'show_label'  => false,
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'title_field' => '<span style="text-transform: capitalize;">{{{ field_type.replace(/_/g, " ") }}}</span>',
            'default'     => $this->form_defaults['fields'],
            'separator'   => 'after',
        ] );
        $this->add_control( 'submit_button_text', [
            'label'       => __( 'Submit Button Text', 'acf-frontend-form-element' ),
            'type'        => Controls_Manager::TEXT,
            'label_block' => true,
            'default'     => $this->form_defaults['submit'],
            'placeholder' => $this->form_defaults['submit'],
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $this->add_control( 'submit_button_desc', [
            'label'       => __( 'Submit Button Description', 'acf-frontend-form-element' ),
            'type'        => Controls_Manager::TEXT,
            'placeholder' => __( 'All done?', 'acf-frontend-form-element' ),
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $this->end_controls_section();
    }
    
    protected function register_step_controls( $repeater, $first = false )
    {
        $repeater->add_control( 'emails_to_send', [
            'label'       => __( 'Step Emails', 'acf-frontend-form-element' ),
            'type'        => Controls_Manager::TEXT,
            'description' => __( 'A comma seperated list of email names to send upon completing this step.', 'acf-frontend-form-element' ),
            'condition'   => [
            'field_type' => 'step',
        ],
        ] );
        $repeater->add_control( 'form_title', [
            'label'       => __( 'Step Title', 'acf-frontend-form-element' ),
            'type'        => Controls_Manager::TEXT,
            'placeholder' => $this->form_defaults['form_title'],
            'dynamic'     => [
            'active' => true,
        ],
            'condition'   => [
            'field_type' => 'step',
        ],
        ] );
        $repeater->add_control( 'step_tab_text', [
            'label'       => __( 'Step Tab Text', 'acf-frontend-form-element' ),
            'type'        => Controls_Manager::TEXT,
            'placeholder' => $this->form_defaults['form_title'],
            'dynamic'     => [
            'active' => true,
        ],
            'condition'   => [
            'field_type' => 'step',
        ],
        ] );
        if ( !$first ) {
            $repeater->add_control( 'prev_button_text', [
                'label'       => __( 'Previous Button', 'acf-frontend-form-element' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'Previous', 'acf-frontend-form-element' ),
                'placeholder' => __( 'Previous', 'acf-frontend-form-element' ),
                'dynamic'     => [
                'active' => true,
            ],
                'condition'   => [
                'field_type' => 'step',
            ],
            ] );
        }
        $repeater->add_control( 'next_button_text', [
            'label'       => __( 'Next Button', 'acf-frontend-form-element' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => __( 'Next', 'acf-frontend-form-element' ),
            'placeholder' => __( 'Next', 'acf-frontend-form-element' ),
            'dynamic'     => [
            'active' => true,
        ],
            'condition'   => [
            'field_type' => 'step',
        ],
        ] );
        $repeater->start_controls_tabs( 'field_step_settings_tabs' );
        $repeater->start_controls_tab( 'field_step_action_tab', [
            'label'     => __( 'Action', 'acf-frontend-form-element' ),
            'condition' => [
            'field_type' => 'step',
        ],
        ] );
        $repeater->add_control( 'overwrite_settings', [
            'label'        => __( 'Custom Action Settings', 'acf-frontend-form-element' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'acf-frontend-form-element' ),
            'label_off'    => __( 'No', 'acf-frontend-form-element' ),
            'return_value' => 'true',
            'condition'    => [
            'field_type' => 'step',
        ],
        ] );
        $this->main_action_control( $repeater );
        $module = ACFEF_Module::instance();
        $post_action = $module->get_main_actions( 'post' );
        $post_action->action_controls( $repeater, true );
        $user_action = $module->get_main_actions( 'user' );
        $user_action->action_controls( $repeater, true );
        $term_action = $module->get_main_actions( 'term' );
        $term_action->action_controls( $repeater, true );
        $repeater->end_controls_tab();
        $repeater->start_controls_tab( 'field_step_permissions_tab', [
            'label'     => __( 'Permmisions', 'acf-frontend-form-element' ),
            'condition' => [
            'field_type' => 'step',
        ],
        ] );
        $repeater->add_control( 'overwrite_permissions_settings', [
            'label'        => __( 'Custom Permmissions Settings', 'acf-frontend-form-element' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'acf-frontend-form-element' ),
            'label_off'    => __( 'No', 'acf-frontend-form-element' ),
            'return_value' => 'true',
            'condition'    => [
            'field_type' => 'step',
        ],
        ] );
        $this->permissions_controls( $repeater, true );
        $repeater->end_controls_tab();
        $repeater->end_controls_tabs();
    }
    
    public function register_steps_controls()
    {
    }
    
    protected function register_actions_controls()
    {
        $this->start_controls_section( 'actions_section', [
            'label' => __( 'Actions', 'acf-frontend-form-element' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );
        $this->main_action_control();
        $this->add_control( 'more_actions_promo', [
            'type'            => Controls_Manager::RAW_HTML,
            'raw'             => __( '<p><a target="_blank" href="https://www.frontendform.com/"><b>Go pro</b></a> to unlock more actions.</p>', 'acf-frontend-form-element' ),
            'content_classes' => 'acf-fields-note',
        ] );
        $this->add_control( 'redirect', [
            'label'   => __( 'Redirect After Submit', 'acf-frontend-form-element' ),
            'type'    => Controls_Manager::SELECT,
            'default' => 'current',
            'options' => [
            'current'     => __( 'Stay on Current Page/Post', 'acf-frontend-form-element' ),
            'custom_url'  => __( 'Custom Url', 'acf-frontend-form-element' ),
            'referer_url' => __( 'Referer', 'acf-frontend-form-element' ),
            'post_url'    => __( 'Post Url', 'acf-frontend-form-element' ),
        ],
        ] );
        $this->add_control( 'redirect_action', [
            'label'     => __( 'After Reload', 'acf-frontend-form-element' ),
            'type'      => Controls_Manager::SELECT,
            'default'   => 'clear',
            'options'   => [
            'clear' => __( 'Clear Form', 'acf-frontend-form-element' ),
            'edit'  => __( 'Edit Form', 'acf-frontend-form-element' ),
        ],
            'condition' => [
            'redirect'    => 'current',
            'main_action' => [ 'new_post', 'new_user', 'new_product' ],
        ],
        ] );
        $this->add_control( 'custom_url', [
            'label'       => __( 'Custom Url', 'acf-frontend-form-element' ),
            'type'        => Controls_Manager::URL,
            'placeholder' => __( 'Enter Url Here', 'acf-frontend-form-element' ),
            'options'     => false,
            'show_label'  => false,
            'condition'   => [
            'redirect' => 'custom_url',
        ],
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control( 'param_key', [
            'label'       => __( 'Key', 'acf-frontend-form-element' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'placeholder' => __( 'page_id', 'acf-frontend-form-element' ),
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $repeater->add_control( 'param_value', [
            'label'       => __( 'Value', 'acf-frontend-form-element' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'placeholder' => __( '18', 'acf-frontend-form-element' ),
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $this->add_control( 'url_parameters', [
            'label'         => __( 'URL Parameters', 'acf-frontend-form-element' ),
            'type'          => Controls_Manager::REPEATER,
            'fields'        => $repeater->get_controls(),
            'prevent_empty' => false,
            'title_field'   => '{{{ param_key }}}',
        ] );
        $this->add_control( 'preview_redirect', [
            'label'        => __( 'Preview Redirect URL', 'acf-frontend-form-element' ),
            'type'         => Controls_Manager::SWITCHER,
            'description'  => 'View the redirect URL structure to confirm all is set.',
            'label_on'     => __( 'Yes', 'acf-frontend-form-element' ),
            'label_off'    => __( 'No', 'acf-frontend-form-element' ),
            'return_value' => 'true',
            'seperator'    => 'after',
        ] );
        $this->add_control( 'show_success_message', [
            'label'        => __( 'Show Success Message', 'acf-frontend-form-element' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'acf-frontend-form-element' ),
            'label_off'    => __( 'No', 'acf-frontend-form-element' ),
            'default'      => 'true',
            'return_value' => 'true',
        ] );
        $this->add_control( 'update_message', [
            'label'       => __( 'Submit Message', 'acf-frontend-form-element' ),
            'type'        => Controls_Manager::TEXTAREA,
            'default'     => $this->form_defaults['success_message'],
            'placeholder' => $this->form_defaults['success_message'],
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $this->end_controls_section();
    }
    
    protected function main_action_controls_section()
    {
        $module = ACFEF_Module::instance();
        $main_actions = $module->get_main_actions();
        $more_actions = $module->get_submit_actions();
        foreach ( $main_actions as $name => $action ) {
            if ( strpos( $this->form_defaults['main_action'], $name ) !== false || $this->form_defaults['main_action'] == 'all' ) {
                $action->register_settings_section( $this );
            }
        }
        foreach ( $more_actions as $action ) {
            $action->register_settings_section( $this );
        }
    }
    
    protected function permissions_controls( $widget, $step = false )
    {
        $condition = [];
        if ( $step ) {
            $condition = [
                'field_type'                     => 'step',
                'overwrite_permissions_settings' => 'true',
            ];
        }
        $widget->add_control( 'not_allowed', [
            'label'       => __( 'No Permissions Message', 'acf-frontend-form-element' ),
            'type'        => Controls_Manager::SELECT,
            'label_block' => true,
            'default'     => 'show_nothing',
            'options'     => [
            'show_nothing'   => __( 'None', 'acf-frontend-form-element' ),
            'show_message'   => __( 'Message', 'acf-frontend-form-element' ),
            'custom_content' => __( 'Custom Content', 'acf-frontend-form-element' ),
        ],
            'condition'   => $condition,
        ] );
        $condition['not_allowed'] = 'show_message';
        $widget->add_control( 'not_allowed_message', [
            'label'       => __( 'Message', 'acf-frontend-form-element' ),
            'type'        => Controls_Manager::TEXTAREA,
            'label_block' => true,
            'rows'        => 4,
            'default'     => __( 'You do not have the proper permissions to view this form', 'acf-frontend-form-element' ),
            'placeholder' => __( 'You do not have the proper permissions to view this form', 'acf-frontend-form-element' ),
            'condition'   => $condition,
        ] );
        $condition['not_allowed'] = 'custom_content';
        $widget->add_control( 'not_allowed_content', [
            'label'       => __( 'Content', 'acf-frontend-form-element' ),
            'type'        => Controls_Manager::WYSIWYG,
            'label_block' => true,
            'render_type' => 'none',
            'condition'   => $condition,
        ] );
        unset( $condition['not_allowed'] );
        $who_can_see = [
            'logged_in'  => __( 'Only Logged In Users', 'acf-frontend-form-element' ),
            'logged_out' => __( 'Only Logged Out', 'acf-frontend-form-element' ),
            'all'        => __( 'All Users', 'acf-frontend-form-element' ),
        ];
        //get all user role choices
        $user_roles = acfef_get_user_roles();
        $widget->add_control( 'who_can_see', [
            'label'       => __( 'Who Can See This...', 'acf-frontend-form-element' ),
            'type'        => Controls_Manager::SELECT2,
            'label_block' => true,
            'default'     => 'logged_in',
            'options'     => $who_can_see,
            'condition'   => $condition,
        ] );
        $condition['who_can_see'] = 'logged_in';
        $widget->add_control( 'by_role', [
            'label'       => __( 'Select By Role', 'acf-frontend-form-element' ),
            'type'        => Controls_Manager::SELECT2,
            'label_block' => true,
            'multiple'    => true,
            'default'     => [ 'administrator' ],
            'options'     => $user_roles,
            'condition'   => $condition,
        ] );
        $widget->add_control( 'or_user_id', [
            'type'            => Controls_Manager::RAW_HTML,
            'raw'             => __( '<h3>OR</h3>', 'acf-frontend-form-element' ),
            'content_classes' => 'acf-fields-note',
            'condition'       => $condition,
        ] );
        
        if ( !class_exists( 'ElementorPro\\Modules\\QueryControl\\Module' ) ) {
            $widget->add_control( 'user_id', [
                'label'       => __( 'Select By User', 'acf-frontend-form-element' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => __( '18, 12, 11', 'acf-frontend-form-element' ),
                'default'     => get_current_user_id(),
                'description' => __( 'Enter the a comma-seperated list of user ids', 'acf-frontend-form-element' ),
                'condition'   => $condition,
            ] );
        } else {
            $widget->add_control( 'user_id', [
                'label'        => __( 'Select By User', 'acf-frontend-form-element' ),
                'label_block'  => true,
                'type'         => Query_Module::QUERY_CONTROL_ID,
                'autocomplete' => [
                'object'  => Query_Module::QUERY_OBJECT_USER,
                'display' => 'detailed',
            ],
                'multiple'     => true,
                'default'      => [ get_current_user_id() ],
                'condition'    => $condition,
            ] );
        }
        
        $condition['main_action'] = [ 'edit_post', 'edit_user' ];
        $widget->add_control( 'or_dynamic', [
            'type'            => Controls_Manager::RAW_HTML,
            'raw'             => __( '<h3>OR</h3>', 'acf-frontend-form-element' ),
            'content_classes' => 'acf-fields-note',
            'condition'       => $condition,
        ] );
        $condition['main_action'] = 'edit_post';
        $widget->add_control( 'dynamic', [
            'label'       => __( 'Dynamic Permissions', 'acf-frontend-form-element' ),
            'type'        => Controls_Manager::SELECT2,
            'label_block' => true,
            'description' => 'Use a dynamic acf user field that returns a user ID to filter the form for that user dynamically. You may also select the post\'s author',
            'options'     => acfef_get_user_id_fields(),
            'condition'   => $condition,
        ] );
        $condition['main_action'] = 'edit_user';
        $widget->add_control( 'dynamic_manager', [
            'label'       => __( 'Dynamic Permissions', 'acf-frontend-form-element' ),
            'type'        => Controls_Manager::SELECT2,
            'label_block' => true,
            'options'     => [
            'manager' => __( 'User Manager', 'acf-frontend-form-element' ),
        ],
            'condition'   => $condition,
        ] );
    }
    
    protected function register_permissions_controls()
    {
        $this->start_controls_section( 'permissions_section', [
            'label' => __( 'Permissions', 'acf-frontend-form-element' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );
        $this->permissions_controls( $this );
        $this->add_control( 'wp_uploader', [
            'label'        => __( 'WP uploader', 'acf-frontend-form-element' ),
            'type'         => Controls_Manager::SWITCHER,
            'description'  => 'Whether to use the Wp uploader for file fields or just a basic input',
            'label_on'     => __( 'Yes', 'acf-frontend-form-element' ),
            'label_off'    => __( 'No', 'acf-frontend-form-element' ),
            'default'      => 'true',
            'return_value' => 'true',
        ] );
        $this->add_control( 'media_privacy_note', [
            'label'           => __( '<h3>Media Privacy</h3>', 'acf-frontend-form-element' ),
            'type'            => Controls_Manager::RAW_HTML,
            'raw'             => __( '<p>Click <a target="_blank" href="' . admin_url( '?page=acfef-settings&tab=uploads-privacy' ) . '">here</a> </p> to limit the files displayed in the media library to the user who uploaded them', 'acf-frontend-form-element' ),
            'content_classes' => 'media-privacy-note',
        ] );
        $this->end_controls_section();
    }
    
    protected function register_display_controls()
    {
        $this->start_controls_section( 'display_section', [
            'label' => __( 'Display Options', 'acf-frontend-form-element' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'show_in_modal', [
            'label'        => __( 'Show in Modal', 'acf-frontend-form-element' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'acf-frontend-form-element' ),
            'label_off'    => __( 'No', 'acf-frontend-form-element' ),
            'return_value' => 'true',
        ] );
        $this->add_control( 'modal_button_text', [
            'label'       => __( 'Modal Button Text', 'acf-frontend-form-element' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => $this->form_defaults['form_title'],
            'placeholder' => $this->form_defaults['form_title'],
            'condition'   => [
            'show_in_modal' => 'true',
        ],
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $this->add_control( 'modal_button_icon', [
            'label'     => __( 'Modal Button Icon', 'acf-frontend-form-element' ),
            'type'      => Controls_Manager::ICONS,
            'condition' => [
            'show_in_modal' => 'true',
        ],
        ] );
        $this->add_control( 'hide_field_labels', [
            'label'        => __( 'Hide Field Labels', 'acf-frontend-form-element' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __( 'Hide', 'acf-frontend-form-element' ),
            'label_off'    => __( 'Show', 'acf-frontend-form-element' ),
            'return_value' => 'true',
            'separator'    => 'before',
            'selectors'    => [
            '{{WRAPPER}} .acf-label' => 'display: none',
        ],
        ] );
        $this->add_control( 'field_label_position', [
            'label'     => __( 'Label Position', 'elementor-pro' ),
            'type'      => Controls_Manager::SELECT,
            'options'   => [
            'top'  => __( 'Above', 'elementor-pro' ),
            'left' => __( 'Inline', 'elementor-pro' ),
        ],
            'default'   => 'top',
            'condition' => [
            'hide_field_labels!' => 'true',
        ],
        ] );
        $this->add_control( 'hide_mark_required', [
            'label'        => __( 'Hide Required Mark', 'elementor-pro' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __( 'Hide', 'elementor-pro' ),
            'label_off'    => __( 'Show', 'elementor-pro' ),
            'return_value' => 'true',
            'condition'    => [
            'hide_field_labels!' => 'true',
        ],
            'selectors'    => [
            '{{WRAPPER}} .acf-required' => 'display: none',
        ],
        ] );
        $this->add_control( 'field_instruction_position', [
            'label'     => __( 'Instruction Position', 'elementor-pro' ),
            'type'      => Controls_Manager::SELECT,
            'options'   => [
            'label' => __( 'Above Field', 'elementor-pro' ),
            'field' => __( 'Below Field', 'elementor-pro' ),
        ],
            'default'   => 'label',
            'separator' => 'before',
        ] );
        $this->add_control( 'field_seperator', [
            'label'        => __( 'Field Seperator', 'elementor-pro' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __( 'Hide', 'elementor-pro' ),
            'label_off'    => __( 'Show', 'elementor-pro' ),
            'default'      => 'true',
            'return_value' => 'true',
            'separator'    => 'before',
            'selectors'    => [
            '{{WRAPPER}} .acf-fields>.acf-field'                        => 'border-top: none',
            '{{WRAPPER}} .acf-field[data-width]+.acf-field[data-width]' => 'border-left: none',
        ],
        ] );
        $this->end_controls_section();
    }
    
    public function register_limit_controls()
    {
        $this->start_controls_section( 'limit_submit_section', [
            'label' => __( 'Limit Submissions', 'acf-frontend-form-element' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'limit_submit_promo', [
            'type'            => Controls_Manager::RAW_HTML,
            'raw'             => __( '<p><a target="_blank" href="https://www.frontendform.com/"><b>Go pro</b></a> to unlock limit submissions.</p>', 'acf-frontend-form-element' ),
            'content_classes' => 'acf-fields-note',
        ] );
        do_action( 'acfef/limit_submit_settings', $this );
        $this->end_controls_section();
    }
    
    public function register_style_tab_controls()
    {
        $this->start_controls_section( 'style_promo_section', [
            'label' => __( 'Styles', 'acf-frontend-form-elements' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'styles_promo', [
            'type'            => Controls_Manager::RAW_HTML,
            'raw'             => __( '<p><a target="_blank" href="https://www.frontendform.com/"><b>Go Pro</b></a> to unlock styles.</p>', 'acf-frontend-form-element' ),
            'content_classes' => 'acf-fields-note',
        ] );
        $this->end_controls_section();
    }
    
    public function get_field_type_groups()
    {
        $fields = [];
        $fields['acf'] = [
            'label'   => __( 'ACF Field', 'acf-frontend-form-element' ),
            'options' => [
            'ACF_fields'       => __( 'ACF Fields', 'acf-frontend-form-element' ),
            'ACF_field_groups' => __( 'ACF Field Groups', 'acf-frontend-form-element' ),
        ],
        ];
        $fields['post'] = [
            'label'   => __( 'Post', 'acf-frontend-form-element' ),
            'options' => [
            'title'          => __( 'Post Title', 'acf-frontend-form-element' ),
            'content'        => __( 'Post Content', 'acf-frontend-form-element' ),
            'featured_image' => __( 'Featured Image', 'acf-frontend-form-element' ),
            'excerpt'        => __( 'Post Excerpt', 'acf-frontend-form-element' ),
            'categories'     => __( 'Categories', 'acf-frontend-form-element' ),
            'tags'           => __( 'Tags', 'acf-frontend-form-element' ),
            'taxonomy'       => __( 'Custom Taxonomy', 'acf-frontend-form-element' ),
        ],
        ];
        $fields['user'] = [
            'label'   => __( 'User', 'acf-frontend-form-element' ),
            'options' => [
            'username'         => __( 'Username', 'acf-frontend-form-element' ),
            'password'         => __( 'Password', 'acf-frontend-form-element' ),
            'confirm_password' => __( 'Confirm Password', 'acf-frontend-form-element' ),
            'email'            => __( 'Email', 'acf-frontend-form-element' ),
            'first_name'       => __( 'First Name', 'acf-frontend-form-element' ),
            'last_name'        => __( 'Last Name', 'acf-frontend-form-element' ),
            'nickname'         => __( 'Nickname', 'acf-frontend-form-element' ),
            'display_name'     => __( 'Display Name', 'acf-frontend-form-element' ),
            'bio'              => __( 'Biography', 'acf-frontend-form-element' ),
            'role'             => __( 'Role', 'acf-frontend-form-element' ),
        ],
        ];
        $fields['term'] = [
            'label'   => __( 'Term', 'acf-frontend-form-element' ),
            'options' => [
            'term_name' => __( 'Term Name', 'acf-frontend-form-element' ),
        ],
        ];
        $fields['layout'] = [
            'label'   => __( 'Layout', 'acf-frontend-form-element' ),
            'options' => [
            'message' => __( 'Message', 'acf-frontend-form-element' ),
        ],
        ];
        return $fields;
    }
    
    public function get_field_type_options()
    {
        $groups = $this->get_field_type_groups();
        $fields = [
            'acf'    => $groups['acf'],
            'layout' => $groups['layout'],
        ];
        switch ( $this->form_defaults['main_action'] ) {
            case 'new_post':
            case 'edit_post':
                $fields['post'] = $groups['post'];
                break;
            case 'edit_user':
            case 'new_user':
                $fields['user'] = $groups['user'];
                break;
            case 'edit_options':
                $fields['site'] = $groups['options'];
                break;
            case 'edit_term':
                $fields['term'] = $groups['term'];
                break;
            case 'new_comment':
                $fields['comment'] = $groups['comment'];
                break;
            case 'new_product':
            case 'edit_product':
                $fields = array_merge( $fields, [
                    'product'   => $groups['product'],
                    'inventory' => $groups['product_inventory'],
                ] );
                break;
            default:
                $fields = array_merge( $fields, [
                    'post' => $groups['post'],
                    'user' => $groups['user'],
                    'term' => $groups['term'],
                ] );
        }
        return $fields;
    }
    
    public function main_action_control( $repeater = false )
    {
        $controls = $this;
        $continue_action = [];
        $controls_settings = [
            'label'   => __( 'Main Action', 'acf-frontend-form-element' ),
            'type'    => Controls_Manager::SELECT,
            'default' => 'edit_post',
        ];
        
        if ( $repeater ) {
            $controls = $repeater;
            $controls_settings['condition'] = [
                'field_type'         => 'step',
                'overwrite_settings' => 'true',
            ];
        }
        
        
        if ( $this->form_defaults['main_action'] == 'all' ) {
            $main_action_options = array(
                'edit_post' => __( 'Edit Post', 'acf-frontend-form-element' ),
                'new_post'  => __( 'New Post', 'acf-frontend-form-element' ),
                'edit_user' => __( 'Edit User', 'acf-frontend-form-element' ),
                'new_user'  => __( 'New User', 'acf-frontend-form-element' ),
                'edit_term' => __( 'Edit Term', 'acf-frontend-form-element' ),
            );
            $main_action_options = apply_filters( 'acfef/main_actions', $main_action_options );
            $controls_settings['options'] = $main_action_options;
            $controls->add_control( 'main_action', $controls_settings );
        } else {
            $controls->add_control( 'main_action', [
                'type'    => Controls_Manager::HIDDEN,
                'default' => $this->form_defaults['main_action'],
            ] );
        }
    
    }
    
    public function show_widget( $wg_id, $settings, $form_args )
    {
        if ( empty($wg_id) ) {
            return true;
        }
        global  $post ;
        $active_user = wp_get_current_user();
        $display = false;
        $user_id = explode( 'user_', $form_args['post_id'] );
        if ( isset( $user_id[1] ) && $user_id[1] == $active_user->ID ) {
            return true;
        }
        if ( 'all' == $settings['who_can_see'] ) {
            return true;
        }
        if ( 'logged_out' == $settings['who_can_see'] ) {
            return !is_user_logged_in();
        }
        if ( 'logged_in' == $settings['who_can_see'] ) {
            
            if ( !is_user_logged_in() ) {
                $display = false;
            } else {
                $by_role = $specific_user = $dynamic = false;
                if ( is_array( $settings['by_role'] ) ) {
                    
                    if ( count( array_intersect( $settings['by_role'], (array) $active_user->roles ) ) == 0 ) {
                        $by_role = false;
                    } else {
                        $by_role = true;
                    }
                
                }
                $user_ids = $settings['user_id'];
                if ( is_string( $user_ids ) ) {
                    $user_ids = explode( ',', $user_ids );
                }
                if ( is_array( $user_ids ) ) {
                    
                    if ( in_array( $active_user->ID, $user_ids ) ) {
                        $specific_user = true;
                    } else {
                        $specific_user = false;
                    }
                
                }
                
                if ( isset( $settings['dynamic'] ) ) {
                    $author_id = false;
                    
                    if ( '[author]' == $settings['dynamic'] ) {
                        $author_id = get_post_field( 'post_author', $form_args['post_id'] );
                    } else {
                        $author_id = get_post_meta( $form_args['post_id'], $settings['dynamic'], true );
                    }
                    
                    
                    if ( $author_id == $active_user->ID ) {
                        $dynamic = true;
                    } else {
                        $dynamic = false;
                    }
                
                }
                
                
                if ( isset( $settings['dynamic_manager'] ) && isset( $user_id[1] ) ) {
                    $manager_id = false;
                    
                    if ( 'manager' == $settings['dynamic_manager'] ) {
                        $manager_id = get_user_meta( $user_id[1], 'acfef_manager', true );
                    } else {
                        $manager_id = get_user_meta( $user_id[1], $settings['dynamic_manager'], true );
                    }
                    
                    
                    if ( $manager_id == $active_user->ID ) {
                        $dynamic = true;
                    } else {
                        $dynamic = false;
                    }
                
                }
                
                
                if ( $by_role || $specific_user || $dynamic ) {
                    $display = true;
                } else {
                    $display = false;
                }
            
            }
        
        }
        return $display;
    }
    
    public function get_form_fields( $settings, $wg_id, $form_args = array() )
    {
        $preview_mode = \Elementor\Plugin::$instance->preview->is_preview_mode();
        $edit_mode = \Elementor\Plugin::$instance->editor->is_edit_mode();
        $groups = $this->get_field_type_groups();
        $group_names = array_keys( $groups );
        $current_step = 0;
        $form = [];
        if ( !isset( $settings['multi'] ) ) {
            $settings['multi'] = 'false';
        }
        
        if ( $settings['multi'] == 'true' ) {
            $current_step++;
            $form['steps'][$current_step] = $settings['first_step'][0];
            $form['steps'][$current_step]['fields'] = [];
        }
        
        foreach ( $settings['fields_selection'] as $key => $form_field ) {
            
            if ( $settings['multi'] == 'true' ) {
                $fields = $form['steps'][$current_step]['fields'];
            } else {
                $fields = $form;
            }
            
            $local_field = $acf_field_groups = $acf_fields = [];
            switch ( $form_field['field_type'] ) {
                case 'ACF_field_groups':
                    if ( $form_field['field_groups_select'] ) {
                        $acf_field_groups = acfef_get_acf_field_choices( $form_field['field_groups_select'] );
                    }
                    break;
                case 'ACF_fields':
                    $acf_fields = $form_field['fields_select'];
                    if ( $acf_fields ) {
                        $fields = array_merge( $fields, $acf_fields );
                    }
                    break;
                case 'step':
                    
                    if ( $settings['multi'] !== 'true' ) {
                        
                        if ( $current_step == 0 && \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
                            echo  '<div class="acf-notice -error acf-error-message -dismiss"><p>' . __( 'Note: You must turn on "Multi Step" for your steps to work.', 'acf-frontend-form-element' ) . '</p></div>' ;
                            $current_step++;
                        }
                    
                    } else {
                        $current_step++;
                        $form['steps'][$current_step] = $form_field;
                        $fields = [];
                    }
                    
                    break;
                case 'message':
                    $local_field = array(
                        'key'       => $wg_id . '_' . $form_field['field_type'] . $form_field['_id'],
                        'type'      => 'message',
                        'wrapper'   => [
                        'class' => 'elementor-repeater-item-' . $form_field['_id'],
                    ],
                        'required'  => 0,
                        'message'   => $form_field['field_message'],
                        'new_lines' => 'wpautop',
                        'esc_html'  => 0,
                    );
                    break;
                case 'recaptcha':
                    $local_field = array(
                        'key'          => $wg_id . '_' . $form_field['field_type'] . $form_field['_id'],
                        'type'         => 'acfef_recaptcha',
                        'wrapper'      => [
                        'class' => 'elementor-repeater-item-' . $form_field['_id'],
                    ],
                        'required'     => 0,
                        'version'      => $form_field['recaptcha_version'],
                        'v2_theme'     => $form_field['recaptcha_theme'],
                        'v2_size'      => $form_field['recaptcha_size'],
                        'site_key'     => $form_field['recaptcha_site_key'],
                        'secret_key'   => $form_field['recaptcha_secret_key'],
                        'disabled'     => 0,
                        'readonly'     => 0,
                        'v3_hide_logo' => $form_field['recaptcha_hide_logo'],
                    );
                    break;
                default:
                    $default_value = $form_field['field_default_value'];
                    
                    if ( strpos( $default_value, '[$' ) !== 'false' ) {
                        $data_default = acfef_get_field_names( $default_value );
                        $default_value = acfef_get_code_value( $default_value, false, true );
                    }
                    
                    if ( !empty($form_field['default_featured_image']['id']) ) {
                        $default_value = $form_field['default_featured_image']['id'];
                    }
                    $local_field = array(
                        'label'         => '',
                        'wrapper'       => [
                        'class' => 'elementor-repeater-item-' . $form_field['_id'],
                    ],
                        'instructions'  => $form_field['field_instruction'],
                        'required'      => $form_field['field_required'],
                        'placeholder'   => $form_field['field_placeholder'],
                        'default_value' => $default_value,
                        'disabled'      => $form_field['field_disabled'],
                        'readonly'      => $form_field['field_readonly'],
                    );
                    
                    if ( isset( $data_default ) ) {
                        $local_field['wrapper']['data-default'] = $data_default;
                        $local_field['wrapper']['data-dynamic_value'] = $default_value;
                    }
                    
                    if ( $form_field['field_hidden'] ) {
                        $local_field['wrapper']['class'] = 'acf-hidden';
                    }
                    break;
            }
            $module = acfef_Module::instance();
            
            if ( isset( $acf_field_groups ) && $acf_field_groups ) {
                $fields_exclude = $form_field['fields_select_exclude'];
                if ( $fields_exclude ) {
                    $acf_field_groups = array_diff( $acf_field_groups, $fields_exclude );
                }
                $fields = array_merge( $fields, $acf_field_groups );
            }
            
            if ( isset( $local_field ) ) {
                foreach ( $groups as $name => $group ) {
                    
                    if ( in_array( $form_field['field_type'], array_keys( $group['options'] ) ) ) {
                        $action_name = explode( '_', $name )[0];
                        $main_action = $module->get_main_actions( $action_name );
                        break;
                    }
                
                }
            }
            
            if ( isset( $main_action ) ) {
                $post_id = ( isset( $form_args['post_id'] ) ? $form_args['post_id'] : 0 );
                $local_field = $main_action->get_fields_display( $form_field, $local_field, $post_id );
                
                if ( isset( $form_field['field_label_on'] ) ) {
                    $field_label = ucwords( str_replace( '_', ' ', $form_field['field_type'] ) );
                    $local_field['label'] = ( $form_field['field_label'] ? $form_field['field_label'] : $field_label );
                }
                
                
                if ( isset( $local_field['type'] ) ) {
                    
                    if ( $local_field['type'] == 'password' ) {
                        $local_field['password_strength'] = $form_field['password_strength'];
                        $password_strength = true;
                    }
                    
                    
                    if ( $form_field['field_type'] == 'taxonomy' ) {
                        $taxonomy = ( isset( $form_field['field_taxonomy'] ) ? $form_field['field_taxonomy'] : 'category' );
                        $local_field['name'] = $wg_id . '_' . $taxonomy;
                        $local_field['key'] = $wg_id . '_' . $taxonomy;
                    } else {
                        $local_field['name'] = $wg_id . '_' . $form_field['field_type'];
                        $local_field['key'] = $wg_id . '_' . $form_field['field_type'];
                    }
                
                }
            
            }
            
            if ( isset( $local_field['label'] ) ) {
                if ( !$form_field['field_label_on'] ) {
                    unset( $local_field['label'] );
                }
            }
            
            if ( isset( $local_field['key'] ) ) {
                $field_key = '';
                
                if ( $edit_mode || !acf_get_field( 'acfef_' . $local_field['key'] ) || $local_field['type'] == 'message' ) {
                    acf_add_local_field( $local_field );
                    $field_key = $local_field['key'];
                } else {
                    $field_key = 'acfef_' . $local_field['key'];
                }
                
                $fields[] = $field_key;
            }
            
            
            if ( $settings['multi'] == 'true' ) {
                $form['steps'][$current_step]['fields'] = $fields;
            } else {
                $form = $fields;
            }
            
            if ( isset( $password_strength ) ) {
                $form['password_strength'] = true;
            }
        }
        return $form;
    }
    
    public function get_payment_options( $settings, $wg_id )
    {
        
        if ( get_option( 'acfef_payments_active' ) && (get_option( 'acfef_stripe_active' ) || get_option( 'acfef_paypal_active' )) ) {
            do_action( 'acfef/credit_card_scripts', $settings['payment_processor'] );
            do_action( 'acfef/credit_card_form', $settings, $wg_id );
        }
    
    }
    
    static function get_post_id( $settings, $form_args, $wg_id )
    {
        global  $post ;
        $active_user = wp_get_current_user();
        $module = ACFEF_Module::instance();
        /* 		if( 'new_comment' == $settings[ 'main_action' ] ){
        			$form_args[ 'post_id' ] = 'new_comment';
        			if( $settings[ 'comment_parent_post' ] == 'current_post' ){
        				$comment_parent_post = $post->ID;
        			}else{
        				$comment_parent_post = $settings[ 'select_parent_post' ];
        			}
        			$form_args[ 'html_after_fields' ] .= '<input type="hidden" value="' . $comment_parent_post . '" name="acfef_parent_post"/><input type="hidden" value="0" name="acfef_parent_comment"/>';
        		} */
        
        if ( 'new_post' == $settings['main_action'] || 'new_product' == $settings['main_action'] ) {
            $post_edit = false;
            $post_type = 'post';
            $post_status = 'draft';
            $default_title = __( 'New Post', 'acf-frontend-form-element' );
            
            if ( 'new_post' == $settings['main_action'] ) {
                if ( isset( $_GET['post_id'] ) ) {
                    $post_edit = acfef_can_edit_post(
                        $_GET['post_id'],
                        $settings,
                        $form_args,
                        $wg_id
                    );
                }
                $post_type = ( isset( $settings['new_post_type'] ) ? $settings['new_post_type'] : 'post' );
                $post_status = ( isset( $settings['new_post_status'] ) ? $settings['new_post_status'] : 'publish' );
                $tax_input = [];
            }
            
            
            if ( 'new_product' == $settings['main_action'] && class_exists( 'woocommerce' ) ) {
                if ( isset( $_GET['product_id'] ) ) {
                    $post_edit = acfef_can_edit_post(
                        $_GET['product_id'],
                        $settings,
                        $form_args,
                        $wg_id
                    );
                }
                $post_type = 'product';
                $post_status = ( isset( $settings['new_product_status'] ) ? $settings['new_product_status'] : 'publish' );
                $default_title = __( 'New Product', 'acf-frontend-form-element' );
                $tax_input = [
                    'product_type' => 'simple',
                ];
            }
            
            
            if ( $post_edit ) {
                $form_args['post_id'] = $post_edit;
            } else {
                $form_args['post_id'] = 'new_post';
                $form_args['new_post'] = array(
                    'post_title'  => $default_title,
                    'post_type'   => $post_type,
                    'post_status' => $post_status,
                    'tax_input'   => $tax_input,
                );
            }
        
        }
        
        if ( 'edit_post' == $settings['main_action'] ) {
            
            if ( !isset( $settings['post_to_edit'] ) || $settings['post_to_edit'] == 'current_post' ) {
                $form_args['post_id'] = $post->ID;
            } elseif ( $settings['post_to_edit'] == 'select_post' ) {
                $form_args['post_id'] = $settings['post_select'];
            } elseif ( $settings['post_to_edit'] == 'url_query' && isset( $_GET[$settings['url_query_post']] ) ) {
                $form_args['post_id'] = $_GET[$settings['url_query_post']];
            }
        
        }
        
        if ( 'new_user' == $settings['main_action'] ) {
            $can_edit = false;
            if ( isset( $_GET['user_id'] ) ) {
                $can_edit = acfef_can_edit_user(
                    $_GET['user_id'],
                    $settings,
                    $form_args,
                    $wg_id
                );
            }
            
            if ( $can_edit ) {
                $form_args['post_id'] = 'user_' . $can_edit;
            } else {
                $form_args['post_id'] = 'user_0';
            }
        
        }
        
        if ( 'edit_user' == $settings['main_action'] ) {
            
            if ( !isset( $settings['user_to_edit'] ) || $settings['user_to_edit'] == 'current_user' ) {
                $form_args['post_id'] = 'user_' . $active_user->ID;
            } elseif ( $settings['user_to_edit'] == 'select_user' ) {
                $form_args['post_id'] = 'user_' . $settings['user_select'];
            } elseif ( $settings['user_to_edit'] == 'url_query' && isset( $_GET[$settings['url_query_user']] ) ) {
                $form_args['post_id'] = 'user_' . $_GET[$settings['url_query_user']];
            }
        
        }
        
        if ( 'edit_term' == $settings['main_action'] ) {
            $term_name = get_queried_object()->name;
            
            if ( $settings['term_to_edit'] == 'select_term' ) {
                $form_args['post_id'] = 'term_' . $settings['term_select'];
                
                if ( $settings['term_select'] ) {
                    $term = get_term( $settings['term_select'] );
                    $term_name = $term->name;
                }
            
            } else {
                $form_args['post_id'] = 'term_' . get_queried_object()->term_id;
            }
        
        }
        
        return $form_args;
    }
    
    /**
     * Render acf ele form widget output on the frontend.
     *
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
        $wg_id = $this->get_id();
        global  $post ;
        $current_post_id = Plugin::get_current_post_id();
        $settings = $this->get_settings_for_display();
        $defaults = $post_id = $new_post = $show_title = $show_content = $show_form = $display = $message = $fields = $field_groups = $fields_exclude = false;
        $wp_uploader = 'wp';
        $delete_button = $hidden_submit = $disabled_submit = '';
        $current_user_id = get_current_user_id();
        
        if ( isset( $settings['pay_for_submission'] ) && $settings['pay_for_submission'] == 'true' ) {
            $user_submissions = get_user_meta( $current_user_id, 'acfef_payed_submissions', true );
            $user_submitted = get_user_meta( $current_user_id, 'acfef_payed_submitted', true );
            if ( !$user_submitted ) {
                $user_submitted = 0;
            }
            
            if ( $user_submitted >= $user_submissions ) {
                $hidden_submit = ' acf-hidden';
                $disabled_submit = ' disabled ';
            }
        
        }
        
        $submit_button = '<div class="acfef-submit-buttons">';
        if ( $settings['submit_button_desc'] ) {
            $submit_button .= '<p class="description"><span class="btn-dsc">' . $settings['submit_button_desc'] . '</span></p>';
        }
        $submit_button .= '<input' . $disabled_submit . ' type="submit" class="acfef-submit-button acf-button button button-primary' . $hidden_submit . '" value="%s" /><span class="acf-spinner"></span></div>';
        
        if ( isset( $settings['save_progress_button'] ) && $settings['save_progress_button'] && in_array( $settings['new_post_status'], [ 'publish', 'pending' ] ) ) {
            $submit_button .= '<br><div class="acfef-draft-buttons">';
            if ( $settings['saved_draft_desc'] ) {
                $submit_button .= '<p class="description"><span class="btn-dsc">' . $settings['saved_draft_desc'] . '</span></p>';
            }
            $submit_button .= '<input formnovalidate type="submit" class="acfef-draft-button acf-button button button-secondary" value="' . $settings['saved_draft_text'] . '" name="acfef_save_draft" /></div>';
        }
        
        $module = ACFEF_Module::instance();
        $redirect_url = '';
        $redirect_query = [
            'updated' => $wg_id . '_' . $current_post_id,
        ];
        if ( $settings['url_parameters'] ) {
            foreach ( $settings['url_parameters'] as $param ) {
                $redirect_query[$param['param_key']] = $param['param_value'];
            }
        }
        switch ( $settings['redirect'] ) {
            case 'post_url':
                $redirect_url = add_query_arg( $redirect_query, '%post_url%' );
                break;
            case 'custom_url':
                $redirect_url = add_query_arg( $redirect_query, $settings['custom_url']['url'] );
                break;
            case 'current':
                $current_uri = home_url( add_query_arg( NULL, NULL ) );
                $redirect_url = add_query_arg( $redirect_query, $current_uri );
                break;
            case 'referer_url':
                $referer_uri = home_url( add_query_arg( NULL, NULL ) );
                if ( wp_get_referer() ) {
                    $referer_uri = wp_get_referer();
                }
                $redirect_url = add_query_arg( $redirect_query, $referer_uri );
                break;
        }
        if ( \Elementor\Plugin::$instance->editor->is_edit_mode() && $settings['preview_redirect'] ) {
            echo  'Redirect to: ' . $redirect_url ;
        }
        if ( !$settings['wp_uploader'] ) {
            $wp_uploader = 'basic';
        }
        $hidden_fields = [
            'element_id'  => $wg_id,
            'screen_id'   => $current_post_id,
            'main_action' => $settings['main_action'],
        ];
        $title_structure = $featured_image = $new_terms = false;
        $post_status = 'publish';
        
        if ( strpos( $settings['main_action'], '_post' ) !== false ) {
            if ( $settings['new_post_status'] ) {
                $post_status = $settings['new_post_status'];
            }
            
            if ( $settings['main_action'] == 'new_post' && $settings['new_post_terms'] ) {
                if ( $settings['new_post_terms'] == 'select_terms' ) {
                    $new_terms = $settings['new_terms_select'];
                }
                if ( $settings['new_post_terms'] == 'current_term' ) {
                    $new_terms = get_queried_object()->term_id;
                }
            }
        
        }
        
        $form_id = 'acf-form-' . $wg_id . get_the_ID();
        if ( $settings['form_id'] ) {
            $form_id = sanitize_title( $settings['form_id'] );
        }
        $form_args = array(
            'post_id'               => get_the_ID(),
            'id'                    => $form_id,
            'post_title'            => $show_title,
            'form_attributes'       => array(
            'class'        => '',
            'data-widget'  => $wg_id,
            'autocomplete' => 'disableacf',
        ),
            'post_content'          => $show_content,
            'field_groups'          => [ 'none' ],
            'submit_value'          => $settings['submit_button_text'],
            'html_submit_button'    => $submit_button,
            'return'                => $redirect_url,
            'updated_message'       => '',
            'uploader'              => $wp_uploader,
            'hidden_fields'         => $hidden_fields,
            'instruction_placement' => $settings['field_instruction_position'],
            'new_post_terms'        => $new_terms,
            'html_submit_spinner'   => '',
            'post_status'           => $post_status,
            'update_message'        => $settings['update_message'],
            'label_placement'       => 'top',
            'field_el'              => 'div',
            'kses'                  => true,
            'html_after_fields'     => '',
        );
        
        if ( isset( $settings['no_reload'] ) && $settings['no_reload'] == 'true' ) {
            $form_args['form_attributes']['class'] .= ' acf-form-ajax';
            $form_args['ajax_submit'] = true;
        }
        
        
        if ( isset( $settings['pay_for_submission'] ) && $settings['pay_for_submission'] == 'true' ) {
            $form_args['form_attributes']['class'] .= ' pay-to-post';
            $form_args['hidden_fields']['acfef_pay_to_submit'] = 1;
        }
        
        $form_args = $this->get_post_id( $settings, $form_args, $wg_id );
        
        if ( 'edit_post' == $settings['main_action'] && $settings['show_delete_button'] ) {
            $confirm_message = $settings['confirm_delete_message'];
            $delete_button_icon = $settings['delete_button_icon']['value'];
            $delete_button_text = $settings['delete_button_text'];
        }
        
        
        if ( !empty($delete_button_text) ) {
            $delete_button = ' 
			<form class="delete-form" action="" method="POST" >

			<input type="hidden" name="_acf_element_id" value="' . $wg_id . '">
			<input type="hidden" name="_acf_screen_id" value="' . $current_post_id . '">
			<input type="hidden" name="delete_post" value="' . $form_args['post_id'] . '">
			<input type="hidden" name="redirect_url" value="' . $redirect_url . '">

			<div class="acfef-delete-button-container">
			<button onclick="return confirm(\'' . $confirm_message . '\')" type="submit" class="button acfef-delete-button">';
            if ( $delete_button_icon ) {
                $delete_button .= '<i class="' . $delete_button_icon . '"></i> ';
            }
            $delete_button .= $delete_button_text . '</button>
				</div>
			</form>';
        }
        
        $form_fields = [];
        if ( $settings['fields_selection'] ) {
            $form_fields = $this->get_form_fields( $settings, $wg_id, $form_args );
        }
        
        if ( $form_fields ) {
            $form_args['fields'] = $form_fields;
        } else {
            $form_args['fields'] = [ 'none' ];
        }
        
        if ( isset( $settings['display_name_default'] ) ) {
            $form_args['display_name'] = $settings['display_name_default'];
        }
        
        if ( isset( $settings['user_manager'] ) && $settings['user_manager'] != 'none' ) {
            
            if ( $settings['user_manager'] == 'current_user' ) {
                $user_manager = get_current_user_id();
            } else {
                $user_manager = $settings['manager_select'];
            }
            
            $form_args['user_manager'] = $user_manager;
        }
        
        $fields = $form_args['fields'];
        $fields = apply_filters( 'acfef/chosen_fields', $fields, $settings );
        if ( isset( $fields['password_strength'] ) ) {
            wp_enqueue_script(
                'acfef-password-strength',
                ACFEF_URL . 'includes/assets/js/password-strength.js',
                array( 'password-strength-meter' ),
                '5.5.28',
                true
            );
        }
        if ( !$settings['hide_field_labels'] ) {
            $form_args['label_placement'] = $settings['field_label_position'];
        }
        $form_args = apply_filters( 'acfef/form_args', $form_args, $settings );
        $message = apply_filters(
            'acfef/form_message',
            $message,
            $settings,
            $wg_id
        );
        $display = $this->show_widget( $wg_id, $settings, $form_args );
        
        if ( $message ) {
            $display = false;
            if ( $message !== 'NOTHING' ) {
                echo  $message ;
            }
        }
        
        $display = apply_filters( 'acfef/form_display', $display );
        
        if ( $display ) {
            
            if ( $settings['show_in_modal'] !== 'true' ) {
                
                if ( isset( $fields['steps'] ) ) {
                    do_action(
                        'acfef/multi_form_render',
                        $settings,
                        $form_args,
                        $this
                    );
                } else {
                    if ( $settings['form_title'] ) {
                        echo  '<h2 class="acfef-form-title">' . $settings['form_title'] . '</h2>' ;
                    }
                    acfef_render_form( $form_args );
                    echo  $delete_button ;
                    if ( $settings['main_action'] == 'new_post' && $settings['saved_drafts'] ) {
                        echo  $this->saved_drafts( $wg_id, $settings ) ;
                    }
                }
            
            } else {
                $show_modal = 'hide';
                if ( isset( $_GET['modal'] ) && isset( $_GET['form_id'] ) && $wg_id == $_GET['form_id'] ) {
                    $show_modal = 'show';
                }
                ?>
				<button class="acfef-edit-button edit-button" onClick="openModal('<?php 
                echo  $wg_id . get_the_ID() ;
                ?>')" ><?php 
                
                if ( $settings['modal_button_icon']['value'] ) {
                    \Elementor\Icons_Manager::render_icon( $settings['modal_button_icon'], [
                        'aria-hidden' => 'true',
                    ] );
                    echo  ' ' ;
                }
                
                echo  $settings['modal_button_text'] ;
                ?>
				</button>
				
				<!-- The Modal -->
					<div id="modal_<?php 
                echo  $wg_id . get_the_ID() ;
                ?>" class="modal edit-modal <?php 
                echo  $show_modal ;
                ?>">

					  <!-- Modal content -->
					  <div class="modal-content"> 
						  <div class="modal-inner"> 
							<span onClick="closeModal('<?php 
                echo  $wg_id . get_the_ID() ;
                ?>')" class="acf-icon -cancel close"></span>
								<div class="form-container">
									
								<?php 
                
                if ( isset( $fields['steps'] ) ) {
                    do_action(
                        'acfef/multi_form_render',
                        $settings,
                        $form_args,
                        $this
                    );
                } else {
                    if ( $settings['form_title'] ) {
                        echo  '<h2 class="acfef-form-title">' . $settings['form_title'] . '</h2>' ;
                    }
                    acfef_render_form( $form_args );
                    echo  $delete_button ;
                    if ( $settings['main_action'] == 'new_post' && $settings['saved_drafts'] ) {
                        echo  $this->saved_drafts( $wg_id, $settings ) ;
                    }
                }
                
                ?>
								</div>
						  </div>
					  </div>
					</div>
			<?php 
            }
        
        } else {
            switch ( $settings['not_allowed'] ) {
                case 'show_message':
                    echo  '<div class="acf-notice -error acf-error-message"><p>' . $settings['not_allowed_message'] . '</p></div>' ;
                    break;
                case 'custom_content':
                    echo  '<div class="not_allowed_message">' . $settings['not_allowed_content'] . '</div>' ;
                    break;
            }
        }
    
    }
    
    public function saved_drafts( $wg_id, $settings )
    {
        global  $wp ;
        $current_url = home_url( $wp->request );
        $query_args = $_GET;
        $full_link = add_query_arg( $query_args, $current_url );
        $new_link = remove_query_arg( [ 'post_id', 'form_id', 'updated' ], $full_link );
        $submits = '<br>';
        $drafts_args = array(
            'posts_per_page' => -1,
            'post_status'    => 'draft',
            'post_type'      => 'any',
            'author'         => get_current_user_id(),
            'meta_query'     => array( array(
            'value'   => $wg_id,
            'compare' => '==',
            'key'     => 'acfef_form_source',
        ) ),
        );
        $drafts_select_start = '<div class"drafts"><p class="drafts-heading">' . $settings['saved_drafts_label'] . '</p><select id="acfef-form-drafts" ><option selected value="' . $new_link . '">' . $settings['saved_drafts_new'] . '</option>';
        $drafts_select_end = '</select></div>';
        $form_submits = get_posts( $drafts_args );
        
        if ( $form_submits ) {
            $submits .= $drafts_select_start;
            foreach ( $form_submits as $submit ) {
                $post_time = get_the_time( 'F j, Y, h:i:sa', $submit->ID );
                $selected = '';
                if ( isset( $_GET['post_id'] ) && isset( $_GET['form_id'] ) && $submit->ID == $_GET['post_id'] && $wg_id == $_GET['form_id'] ) {
                    $selected = 'selected';
                }
                $query_args['post_id'] = $submit->ID;
                $query_args['form_id'] = $wg_id;
                if ( $settings['show_in_modal'] ) {
                    $query_args['modal'] = $wg_id;
                }
                $draft_link = add_query_arg( $query_args, $current_url );
                $new_link = remove_query_arg( 'updated', $draft_link );
                $submits .= '<option ' . $selected . ' value="' . $new_link . '" class="form_submit">' . $submit->post_title . ' (' . $post_time . ')' . '</option>';
            }
            $submits .= $drafts_select_end;
        } elseif ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
            $submits .= $drafts_select_start;
            for ( $x = 1 ;  $x < 4 ;  $x++ ) {
                $submits .= '<option class="form_submit">Draft ' . $x . '(' . date( 'F j, Y, h:i:sa' ) . ')</option>';
            }
            $submits .= $drafts_select_end;
        }
        
        return $submits;
    }
    
    public function get_style_depends()
    {
        acf_enqueue_scripts();
        $scripts = [ 'acfef-card' ];
        return $scripts;
    }
    
    public function get_script_depends()
    {
        $scripts = [
            'acfef-frontend',
            'acfef-ajax',
            'acfef-card',
            'acfef-credit-card'
        ];
        return $scripts;
    }
    
    public function __construct( $data = array(), $args = null )
    {
        parent::__construct( $data, $args );
        wp_register_style(
            'acfef-frontend',
            ACFEF_URL . 'includes/assets/css/frontend.min.css',
            array(),
            '5.6.13'
        );
        wp_register_script(
            'acfef-frontend',
            ACFEF_URL . 'includes/assets/js/frontend.js',
            array( 'jquery' ),
            '5.6.4',
            true
        );
        wp_enqueue_style( 'acfef-frontend' );
        
        if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
            echo  '<style>.hide-if-no-js{display:none}</style>' ;
            wp_enqueue_style(
                'acfef-card',
                ACFEF_URL . 'includes/assets/css/card.css',
                array(),
                '5.5.27'
            );
        }
        
        $this->form_defaults = $this->get_form_defaults();
    }

}