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
	protected $tag = 'pdfviewer';

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
		static $count = 1;
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

		$url = $atts['url'];

		if ( $atts['id'] ) {
			$url = wp_get_attachment_url( absint( $atts['id'] ), 'full' );
		}

		// If we couldn't find a PDF URL, then we bail.
		if ( empty( $url ) ) {
			return $output;
		}

		$output .= '
		<style type="text/css">
			#zpdf-'. $count .' {
				position: relative;
				padding-bottom: '. floatval( $atts['height'] ) .'%;
				padding-top: 32px; /* height of the toolbar */
				height: 0;
			}
			#zpdf-'. $count .' iframe {
				position: absolute;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
			}
		</style>
		';

		$src = add_query_arg( 'file', urlencode( esc_url_raw( $url ) ), self::zpdf_url() );

		$output .= '<div id="zpdf-'. $count .'"><iframe class="noscrolling zpdf-iframe" width="100%" height="100%" scrolling="no" frameborder="0" name="pdfv" src="'. esc_url( $src ) . '"></iframe></div>';

		$count++;

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
		$parts = explode( '?', site_url( $_SERVER['REQUEST_URI'] ) );

		if ( 0 === strpos( $parts[0], self::zpdf_url() ) && ! empty( $_REQUEST['file'] ) ) {

			add_action( 'zaopdf_head', array( $this, 'maybe_load_theme_stylesheet' ) );

			include_once ZPDFV_DIR . 'templates/viewer.php';
			exit;
		}
	}

	/**
	 * If the theme has a /zao-pdf-viewer/style.css file, then load it.
	 *
	 * @since  0.1.0
	 *
	 * @return void
	 */
	public function maybe_load_theme_stylesheet() {
		$file = get_stylesheet_directory() . '/zao-pdf-viewer/style.css';
		if ( file_exists( get_stylesheet_directory() . '/zao-pdf-viewer/style.css' ) ) {
			echo '<link rel="stylesheet" href="'. get_stylesheet_directory_uri() . '/zao-pdf-viewer/style.css">';
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
		return ZPDFV_URL . 'pdfjs/web/view';
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
