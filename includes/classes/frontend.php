<?php
/**
 * ZPDF_Viewer_Frontend
 * @version 0.1.0
 */
class ZPDF_Viewer_Frontend {

	/**
	 * Holds an instance of the object
	 *
	 * @var ZPDF_Viewer_Frontend
	 */
	protected static $instance = null;

	/**
	 * THe shortcode tag.
	 *
	 * @var string
	 */
	protected $tag = ZPDFV_SHORTCODE_TAG;

	/**
	 * Returns the ZPDF_Viewer_Frontend object
	 *
	 * @return ZPDF_Viewer_Frontend
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Constructor
	 * @since 0.1.0
	 */
	protected function __construct() {
		$this->hooks();
	}

	/**
	 * Initiate our hooks
	 * @since 0.1.0
	 */
	public function hooks() {
		add_shortcode( $this->tag, array( $this, 'output' ) );

		if ( isset( $_REQUEST['file'], $_SERVER['REQUEST_URI'] ) ) {
			add_action( 'template_redirect', array( $this, 'maybe_load_viewer' ), 9999 );
		}
	}

	/**
	 * Handles the pdf viewer shortcode output.
	 *
	 * ZPDF_Viewer_Frontend::get_instance()->output( 'url' => 'siteurl/pdf.pdf' )
	 *
	 * @since  0.1.0
	 *
	 * @param  array   $atts Array of shortcode/pdfviewer attribues.
	 *
	 * @return string        The pdfviewer iframe or blank if it failed to find a pdf source.
	 */
	public function output( $atts = array() ) {
		static $index = 1;
		$output = '';

		$atts = shortcode_atts( array(
			'url'    => '',
			'id'     => 0,
			'height' => floatval( zpdfv_get_option( 'height', 56.25 ) ),
		), $atts, $this->tag );

		// No PDF URL or Attachment ID, then we will just bail.
		if ( empty( $atts['url'] ) && empty( $atts['id'] ) ) {
			return $output;
		}

		$atts['index'] = $index;

		if ( $atts['id'] ) {
			$atts['url'] = wp_get_attachment_url( absint( $atts['id'] ), 'full' );
		}

		// If we couldn't find a PDF URL, then we bail.
		if ( empty( $atts['url'] ) ) {
			return $output;
		}

		$css = '
		#zpdf-'. $index .' {
			position: relative;
			padding-bottom: '. floatval( $atts['height'] ) .'%;
			padding-top: 32px; /* height of the toolbar */
			height: 0;
		}
		#zpdf-'. $index .' iframe {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
		}
		';

		$css = apply_filters( 'zaopdf_iframe_css', $css, $atts );

		$output .= '<style type="text/css">'. $css .'</style>';

		$src = apply_filters( 'zaopdf_iframe_src', add_query_arg( 'file', urlencode( esc_url_raw( $atts['url'] ) ), self::zpdf_url() ), $atts );

		$iframe = '<div id="zpdf-'. $index .'"><iframe class="noscrolling zpdf-iframe" width="100%" height="100%" scrolling="no" frameborder="0" name="pdfv" src="'. esc_url( $src ) . '"></iframe></div>';

		$output .= apply_filters( 'zaopdf_iframe_markup', $iframe, $atts );

		$index++;

		return $output;
	}

	/**
	 * Load the PDF viewer if the viewer URL has been entered and there is a file query var.
	 *
	 * @since  0.1.0
	 *
	 * @return void
	 */
	public function maybe_load_viewer() {
		$parts = explode( '?', network_site_url( $_SERVER['REQUEST_URI'] ) );

		// If we have a file & the request uri matches our pdf url...
		if ( ! empty( $_REQUEST['file'] ) && 0 === strpos( $parts[0], self::zpdf_url() ) ) {
			// Then load our viewer.
			$this->load_viewer();
		}
	}

	/**
	 * Load the PDF viewer and ensure it is not sent as a 404 request.
	 *
	 * @since  0.1.0
	 *
	 * @return void
	 */
	public function load_viewer() {
		global $wp_query;

		if ( $wp_query->is_404 ) {
			// set status of 404 to false
			$wp_query->is_404 = false;
			$wp_query->is_single = true;
		}

 		// change the header to 200 OK
		status_header( '200', 'OK' );

		// Check if the theme wants load custom stylesheet or JS.
		add_action( 'zaopdf_head', array( $this, 'maybe_load_theme_assets' ) );

		include_once ZPDFV_DIR . 'templates/viewer.php';
		exit;
	}

	/**
	 * If the theme has a style.css or viewer-custom.js file in its /zao-pdf-viewer/ directory, let's load them.
	 *
	 * @since  0.1.0
	 *
	 * @return void
	 */
	public function maybe_load_theme_assets() {
		$dir = get_stylesheet_directory() . '/zao-pdf-viewer/';
		$uri = get_stylesheet_directory_uri() . '/zao-pdf-viewer/';

		if ( file_exists( $dir . 'style.css' ) ) {
			echo '<link rel="stylesheet" href="'. $uri . 'style.css">';
		}

		if ( file_exists( $dir . 'viewer-custom.js' ) ) {
			echo '<script src="'. $uri . 'viewer-custom.js"></script>';
		}
	}

	/**
	 * The URL to the viewer.
	 *
	 * @since  0.1.0
	 *
	 * @return string  The viewer URL.
	 */
	public static function zpdf_url() {
		return site_url( 'pdfjs-view' );
	}

	/**
	 * Public getter method for retrieving protected/private variables
	 * @since  0.1.0
	 * @param  string  $field Field to retrieve
	 * @return mixed          Field value or exception is thrown
	 */
	public function __get( $field ) {
		return $this->{$field};
	}
}
