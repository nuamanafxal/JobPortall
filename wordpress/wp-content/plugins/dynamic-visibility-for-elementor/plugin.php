<?php
namespace DynamicContentForElementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Main Plugin Class
 *
 * Register new elementor widget.
 *
 * @since 1.0.0
 */
class Plugin_DVE {

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {
		$this->add_actions();
	}

	/**
	 * Add Actions
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function add_actions() {
                add_action('elementor/init', array($this, 'dve_elementor_init'));
	}
        
        /**
        * Init elementor finction
        *
        * @since 0.0.1
        *
        * @access public
        */
       public function dve_elementor_init() {
           
            // Se è attivo DCE il plugin si disabilita
            //$proModule = WP_PLUGIN_DIR.'/dynamic-content-for-elementor/dynamic-content-for-elementor.php';
            //var_dump($proModule); die();
            $plugin = 'dynamic-content-for-elementor/dynamic-content-for-elementor.php';
            $plugins = get_site_option( 'active_sitewide_plugins');
            $is_plugin_active = in_array( $plugin, (array) get_option( 'active_plugins', array() ) ) || (is_multisite() && isset($plugins[$plugin]));
            //var_dump($is_plugin_active);
            if (!$is_plugin_active)  {
                
                define('DVE__FILE__', __FILE__);
                define('DVE_URL', plugins_url('/', __FILE__));
                define('DVE_PATH', plugin_dir_path(__FILE__));
                define('DVE_PLUGIN_BASE', plugin_basename( DVE__FILE__ ) );
                if (!defined('DCE_TEXTDOMAIN')) {
                    define('DCE_TEXTDOMAIN', 'dynamic-content-for-elementor');
                }
                if (!defined('DCE__FILE__')) {
                    define('DCE__FILE__', DVE__FILE__);
                }
                
                if (!class_exists('DynamicContentForElementor\DCE_Helper')) {
                    $this->dce_file_include( 'class/DCE_Helper.php' );
                }

                add_action('elementor/frontend/after_register_styles', function() {
                    wp_register_style(
                        'dce-style', plugins_url('/assets/css/style.css', DVE__FILE__), [], DVE_VERSION
                    );
                    // Enqueue DCE Elementor Style
                    wp_enqueue_style('dce-style');
                });
                
                // DCE Custom Icons - in Elementor Editor
                add_action('elementor/preview/enqueue_styles', function(){
                    wp_register_style(
                        'dce-preview', plugins_url('/assets/css/dce-preview.css', DVE__FILE__), [], DVE_VERSION
                    );
                    // Enqueue DCE Elementor Style
                    wp_enqueue_style('dce-preview');
                });
                add_action('elementor/editor/after_enqueue_scripts', array($this, 'dce_editor'));

                if (!class_exists('DynamicContentForElementor\Extensions\DCE_Extension_Prototype')) {
                    $this->dce_file_include( 'extensions/DCE_Extension_Prototype.php' ); // obbligatorio in quanto esteso dagli altri
                }
                if (!class_exists('DynamicContentForElementor\Extensions\DCE_Extension_Visibility')) {
                    $this->dce_file_include( 'extensions/DCE_Extension_Visibility.php' );
                }
                $advancedVisibility = new Extensions\DCE_Extension_Visibility();
            }

       }
       
       
       /**
        * Enqueue admin styles
        *
        * @since 0.7.0
        *
        * @access public
        */
       public function dce_editor() {
           // Register styles
           wp_register_style(
                   'dce-style-icons', plugins_url('/assets/css/dce-icon.css', DCE__FILE__), [], DVE_VERSION
           );
           // Enqueue styles Icons
           wp_enqueue_style('dce-style-icons');

           // Register styles
           wp_register_style(
                   'dce-style-editor', plugins_url('/assets/css/dce-editor.css', DCE__FILE__), [], DVE_VERSION
           );
           // Enqueue styles Icons
           wp_enqueue_style('dce-style-editor');

           wp_register_script(
                   'dce-script-editor-visibility', plugins_url('/assets/js/dce-editor-visibility.js', DCE__FILE__), [], DVE_VERSION
           );
           wp_enqueue_script('dce-script-editor-visibility');
       }
       
       public function dce_file_include( $file ) {
            $path = DVE_PATH . $file;
            //echo $path;
            if ( file_exists( $path ) ) {
                include_once( $path );
            }
        }

}

new Plugin_DVE();
