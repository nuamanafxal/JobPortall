<?php

namespace ACFFrontend\Module;

use  Elementor\Core\Base\Module ;

if ( !defined( 'ABSPATH' ) ) {
    exit;
    // Exit if accessed directly
}

class ACFEFS_Module extends Module
{
    private  $components = array() ;
    public function get_name()
    {
        return 'acfef_settings';
    }
    
    public function acfef_plugin_page()
    {
        global  $acfef_settings ;
        $acfef_settings = add_menu_page(
            'ACF Frontend',
            'ACF Frontend',
            'manage_options',
            'acfef-settings',
            [ $this, 'acfef_admin_settings_page' ],
            'dashicons-feedback',
            '87.87778'
        );
        add_submenu_page(
            'acfef-settings',
            __( 'Settings', 'acf-frontend-form-element' ),
            __( 'Settings', 'acf-frontend-form-element' ),
            'manage_options',
            'acfef-settings',
            '',
            0
        );
    }
    
    function acfef_admin_settings_page()
    {
        global  $acfef_active_tab ;
        $acfef_active_tab = ( isset( $_GET['tab'] ) ? $_GET['tab'] : 'welcome' );
        ?>

		<h2 class="nav-tab-wrapper">
		<?php 
        do_action( 'acfef_settings_tabs' );
        ?>
		</h2>
		<?php 
        do_action( 'acfef_settings_content' );
    }
    
    public function add_tabs()
    {
        add_action( 'acfef_settings_tabs', [ $this, 'acfef_settings_tabs' ], 1 );
        add_action( 'acfef_settings_content', [ $this, 'acfef_settings_render_options_page' ] );
    }
    
    public function acfef_settings_tabs()
    {
        $tabs = [
            'welcome'         => 'Welcome',
            'local-avatar'    => 'Local Avatar',
            'uploads-privacy' => 'Uploads Privacy',
            'hide-admin'      => 'Hide WP Dashboard',
            'google'          => 'Google APIs',
        ];
        global  $acfef_active_tab ;
        foreach ( $tabs as $name => $label ) {
            ?>
			<a class="nav-tab <?php 
            echo  ( $acfef_active_tab == $name || '' ? 'nav-tab-active' : '' ) ;
            ?>" href="<?php 
            echo  admin_url( '?page=acfef-settings&tab=' . $name ) ;
            ?>"><?php 
            _e( $label, 'acf-frontend-form-element' );
            ?> </a>
		<?php 
        }
    }
    
    public function acfef_settings_render_options_page()
    {
        acf_enqueue_scripts();
        global  $acfef_active_tab ;
        
        if ( '' || 'welcome' == $acfef_active_tab ) {
            ?>
		<style>p.acfef-text{font-size:20px}</style>
		<h3><?php 
            _e( 'Hello and welcome', 'acf-frontend-form-element' );
            ?></h3>
		<p class="acfef-text"><?php 
            _e( 'If this is your first time using ACF Frontend, we recommend you watch Paul Charlton from WPTuts beautifully explain how to use it.', 'acf-frontend-form-element' );
            ?></p>
		<iframe width="560" height="315" src="https://www.youtube.com/embed/iHx7krTqRN0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe><br><p class="acfef-text"><?php 
            _e( 'Here is a video where our lead developer and head of support, explains the basic usage of ACF Frontend.', 'acf-frontend-form-element' );
            ?></p>
		<iframe width="560" height="315" src="https://www.youtube.com/embed/lMkZzOVVra8" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe><br>
		<p class="acfef-text"><?php 
            _e( 'If you have any questions at all please feel welcome to email shabti at', 'acf-frontend-form-element' );
            ?> <a href="mailto:shabti@frontendform.com">shabti@frontendform.com</a> <?php 
            _e( 'or on whatsapp', 'acf-frontend-form-element' );
            ?> <a href="https://api.whatsapp.com/send?phone=972584526441">+972-58-452-6441</a></p>
		<?php 
        }
        
        
        if ( 'local-avatar' == $acfef_active_tab ) {
            $this->local_avatar = get_option( 'local_avatar' );
            ?>

			<div class="wrap">
				<?php 
            settings_errors();
            ?>
				<form method="post" action="options.php">
					<?php 
            settings_fields( 'local_avatar_settings' );
            do_settings_sections( 'local-avatar-settings-admin' );
            submit_button();
            ?>
				</form>
			</div>
		<?php 
        }
        
        
        if ( 'uploads-privacy' == $acfef_active_tab ) {
            $this->uploads_privacy = get_option( 'filter_media_author' );
            ?>

			<div class="wrap">
				<?php 
            settings_errors();
            ?>
				<form method="post" action="options.php">
					<?php 
            settings_fields( 'uploads_privacy_settings' );
            do_settings_sections( 'uploads-privacy-settings-admin' );
            submit_button();
            ?>
				</form>
			</div>
		<?php 
        }
        
        
        if ( 'hide-admin' == $acfef_active_tab ) {
            $hide_admin_fields = apply_filters( 'acfef/hide_admin_fields', [] );
            acf_form( [
                'post_id'            => 'acfef_options',
                'html_before_fields' => '<input type="hidden" name="admin_page" value="hide_admin"/>',
                'fields'             => $hide_admin_fields,
                'submit_value'       => __( 'Save Settings', 'acf-frontend-form-element' ),
                'updated_message'    => __( 'Settings Saved', 'acf-frontend-form-element' ),
            ] );
        }
        
        
        if ( 'google' == $acfef_active_tab ) {
            $google_fields = apply_filters( 'acfef/google_fields', [] );
            acf_form( [
                'post_id'            => 'acfef_options',
                'html_before_fields' => '<input type="hidden" name="admin_page" value="google"/>',
                'fields'             => $google_fields,
                'submit_value'       => __( 'Save Settings', 'acf-frontend-form-element' ),
                'updated_message'    => __( 'Settings Saved', 'acf-frontend-form-element' ),
            ] );
        }
    
    }
    
    public function acfef_cpts_and_fields()
    {
        
        if ( !get_option( 'acfef_hide_wp_dashboard' ) ) {
            add_option( 'acfef_hide_wp_dashboard', true );
            add_option( 'acfef_hide_by', array_map( 'strval', [
                0 => 'user',
            ] ) );
        }
        
        require_once __DIR__ . '/admin-pages/custom-fields.php';
        if ( get_option( 'acfef_payments_active' ) ) {
            require_once __DIR__ . '/admin-pages/custom-post-types.php';
        }
    }
    
    public function acfef_settings_sections()
    {
        require_once __DIR__ . '/admin-pages/local-avatar/settings.php';
        new ACFEF_Local_Avatar_Settings( $this );
        require_once __DIR__ . '/admin-pages/uploads-privacy/settings.php';
        new ACFEF_Uploads_Privacy_Settings( $this );
        require_once __DIR__ . '/admin-pages/hide-admin/settings.php';
        new ACFEF_Hide_Admin_Settings( $this );
        require_once __DIR__ . '/admin-pages/google/settings.php';
        new ACFEF_Google_API_Settings( $this );
    }
    
    public function acfef_form_head()
    {
        
        if ( is_admin() ) {
            $current_screen = get_current_screen();
            if ( isset( $current_screen->id ) && $current_screen->id === 'toplevel_page_acfef-settings' ) {
                acf_form_head();
            }
        }
    
    }
    
    public function acfef_validate_save_post()
    {
        if ( isset( $_POST['_acf_post_id'] ) && $_POST['_acf_post_id'] == 'acfef_options' ) {
            
            if ( isset( $_POST['admin_page'] ) ) {
                $page_slug = $_POST['admin_page'];
                $payment_fields = apply_filters( 'acfef/' . $page_slug . '_fields', [] );
            }
        
        }
    }
    
    public function __construct()
    {
        $this->acfef_settings_sections();
        add_action( 'init', [ $this, 'acfef_cpts_and_fields' ] );
        add_action( 'admin_menu', [ $this, 'acfef_plugin_page' ] );
        add_action( 'current_screen', [ $this, 'acfef_form_head' ] );
        add_action( 'acf/validate_save_post', [ $this, 'acfef_validate_save_post' ] );
        $this->add_tabs();
    }

}