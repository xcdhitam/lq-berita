<<<<<<< HEAD
<?php
/**
 * Customizer Library
 *
 * @package        Customizer_Library
 * @license        GPL-2.0+
 * @version        1.3.0
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
/* Continue if the Customizer_Library isn't already in use. */
if ( ! class_exists( 'berita_customizer_library' ) ) :

	// Helper functions to output the customizer controls.
	require plugin_dir_path( __FILE__ ) . '/berita-interface.php';

	// Helper functions for customizer sanitization.
	require plugin_dir_path( __FILE__ ) . '/berita-sanitization.php';

	// Helper functions to build the inline CSS.
	require plugin_dir_path( __FILE__ ) . '/berita-customizer-library-content.php';

	
	/**
	 * Class wrapper with useful methods for interacting with the theme customizer.
	 */
	class berita_customizer_library {

		/**
		 * The one instance of Customizer_Library.
		 *
		 * @since 1.0
		 *
		 */
		private static $instance;

		/**
		 * The array for storing $options.
		 *
		 * @since 1.0
		 *
		 */

		public $options = array();

		/**
		 * Instantiate or return the one Customizer_Library instance.
		 *
		 * @since  1.0
		 *
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Add Options.
		 *
		 * @since  1.0.0.
		 * 
		 * 
		 */
		public function add_options( $options = array() ) {
			$this->options = array_merge( $options, $this->options );
		}

		/**
		 * Get Options.
		 *
		 * @since  1.0.0.
		 * @return string
		 */
		public function get_options() {
			return $this->options;
		}

	}

endif;

=======
<?php
/**
 * Customizer Library
 *
 * @package        Customizer_Library
 * @license        GPL-2.0+
 * @version        1.3.0
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
/* Continue if the Customizer_Library isn't already in use. */
if ( ! class_exists( 'berita_customizer_library' ) ) :

	// Helper functions to output the customizer controls.
	require plugin_dir_path( __FILE__ ) . '/berita-interface.php';

	// Helper functions for customizer sanitization.
	require plugin_dir_path( __FILE__ ) . '/berita-sanitization.php';

	// Helper functions to build the inline CSS.
	require plugin_dir_path( __FILE__ ) . '/berita-customizer-library-content.php';

	/* Category dropdown controls. */
	require trailingslashit( dirname( __FILE__ ) ) . '/berita-customizer-library-categories.php';

	
	/**
	 * Class wrapper with useful methods for interacting with the theme customizer.
	 */
	class berita_customizer_library {

		/**
		 * The one instance of Customizer_Library.
		 *
		 * @since 1.0
		 *
		 */
		private static $instance;

		/**
		 * The array for storing $options.
		 *
		 * @since 1.0
		 *
		 */

		public $options = array();

		/**
		 * Instantiate or return the one Customizer_Library instance.
		 *
		 * @since  1.0
		 *
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Add Options.
		 *
		 * @since  1.0.0.
		 * 
		 * 
		 */
		public function add_options( $options = array() ) {
			$this->options = array_merge( $options, $this->options );
		}

		/**
		 * Get Options.
		 *
		 * @since  1.0.0.
		 * @return string
		 */
		public function get_options() {
			return $this->options;
		}

	}

endif;

>>>>>>> b9cdf76 (initial commit)
