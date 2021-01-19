<?php
/**
 * Beaver Builder Editor Compatibility.
 *
 * @package CartFlows
 */

/**
 * Checkout Markup
 *
 * @since x.x.x
 */
class Cartflows_BB_Editor {

	/**
	 * Member Variable
	 *
	 * @var object instance
	 */
	private static $instance;

	/**
	 *  Initiator
	 */
	public static function get_instance() {

		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 *  Constructor
	 */
	public function __construct() {
		if ( class_exists( 'FLBuilderModel' ) ) {
			$this->bb_editor_compatibility();
		}
	}

	/**
	 * Beaver Builder editor compatibility.
	 */
	public function bb_editor_compatibility() {

		if ( FLBuilderModel::is_builder_active() ) {

			$current_post_id = get_the_id();

			$cf_frontend = Cartflows_Frontend::get_instance();

			/* Load woo templates from plugin. */
			add_filter( 'woocommerce_locate_template', array( $cf_frontend, 'override_woo_template' ), 20, 3 );

			do_action( 'cartflows_bb_editor_compatibility', $current_post_id );

			/* Thank you filters. */
			add_filter( 'cartflows_show_demo_order_details', '__return_true' );
		}
	}

}

/**
 *  Kicking this off by calling 'get_instance()' method
 */
Cartflows_BB_Editor::get_instance();
