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
			'height' => absint( zpdfv_get_option( 'zpdfv_height', 432 ) ),
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

		$height = $atts['height'];
		$reversed = strrev( $height );
		$is_percentage = 0 === strpos( $reversed, '%' );
		if ( 0 !== strpos( $reversed, 'xp' ) && ! $is_percentage ) {
			$height .= 'px';
		}

		// A bit better than inline styling.
		$output .= '<style type="text/css">#zpdf-'. $count .', #zpdf-'. $count .' iframe { height: '. sanitize_text_field( $height ) .'; } </style>';

		$src = add_query_arg( 'file', urlencode( esc_url_raw( $url ) ), ZPDFV_URL . 'pdfjs/web/viewer.html' );

		$output .= '<div id="zpdf-'. $count .'"><iframe class="noscrolling zpdf-iframe" width="100%" height="100%" scrolling="no" frameborder="0" name="pdfv" src="'. esc_url( $src ) . '"></iframe></div>';

		$count++;

		return $output;
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
