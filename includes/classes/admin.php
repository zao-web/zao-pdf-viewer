<?php
/**
* CMB2 Theme Options
* @version 0.1.0
*/
class Pdfv_Admin {

	/**
	 * Option key, and option page slug
	 * @var string
	 */
	private $key = 'zpdfv_options';

	/**
	 * Options page metabox id
	 * @var string
	 */
	private $metabox_id = 'zpdfv_option_metabox';

	/**
	 * Options Page title
	 * @var string
	 */
	protected $title = '';

	/**
	 * Options Page hook
	 * @var string
	 */
	protected $options_page = '';

	/**
	 * Constructor
	 * @since 0.1.0
	 */
	public function __construct() {
		// Set our title
		$this->title = __( 'PDF Viewer', 'pdfv' );
	}

	/**
	 * Initiate our hooks
	 * @since 0.1.0
	 */
	public function hooks() {
		add_action( 'admin_init', array( $this, 'register_setting' ) );
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );
		add_action( 'cmb2_init', array( $this, 'add_options_page_metabox' ) );

		add_action( 'cmb2_render_text_number', array( $this, 'render_text_number' ), 10, 5 );
		add_filter( 'cmb2_sanitize_text_number', array( $this, 'sanitize_text_number' ), 10, 2 );
	}

	public function is_admin() {
		if ( isset( $_GET['page'] ) && $this->key === $_GET['page'] ) {
			return true;
		}
		return false;
	}

	/**
	* Register our setting to WP
	* @since  0.1.0
	*/
	public function register_setting() {
		register_setting( $this->key, $this->key );
	}

	/**
	* Add menu options page
	* @since 0.1.0
	*/
	public function add_options_page() {
		$this->options_page = add_menu_page( $this->title, $this->title, 'manage_options', $this->key, array( $this, 'admin_page_display' ) );

		// Include CMB CSS in the head to avoid FOUT
		if ( $this->is_admin() ) {
			add_action( "admin_print_styles-{$this->options_page}", array( 'CMB2_hookup', 'enqueue_cmb_css' ) );
		}
	}

	/**
	* Admin page markup. Mostly handled by CMB2
	* @since  0.1.0
	*/
	public function admin_page_display() {
		?>
		<div class="wrap cmb2_options_page <?php echo $this->key; ?>">
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
			<?php cmb2_metabox_form( $this->metabox_id, $this->key ); ?>
		</div>
		<?php
	}

	/**
	 * Add the options metabox to the array of metaboxes
	 * @since  0.1.0
	 */
	public function add_options_page_metabox() {
		$cmb = new_cmb2_box( array(
			'id'      => $this->metabox_id,
			'hookup'  => false,
			'show_on' => array(
				// These are important, don't remove
				'key'   => 'options-page',
				'value' => array( $this->key, )
			),
		) );

		$cmb->add_field( array(
			'name'    => __( 'PDF Viewer Default Height', 'pdfv' ),
			'desc'    => "",
			'id'      => 'zpdfv_height',
			'type'    => 'text_number',
			'default' => 1200
		) );

	}

	public function render_text_number( $field, $escaped_value, $object_id, $object_type, $field_type_object ) {
		echo $field_type_object->input( array( 'class' => 'cmb2-text-small', 'type' => 'number' ) );
	}

	// sanitize the field
	public function sanitize_text_number( $null, $new ) {
		$new = preg_replace( "/[^0-9]/", "", $new );

		return $new;
	}

	/**
	 * Public getter method for retrieving protected/private variables
	 * @since  0.1.0
	 * @param  string  $field Field to retrieve
	 * @return mixed          Field value or exception is thrown
	 */
	public function __get( $field ) {
		// Allowed fields to retrieve
		if ( in_array( $field, array( 'key', 'metabox_id', 'title', 'options_page' ), true ) ) {
			return $this->{$field};
		}
		throw new Exception( 'Invalid property: ' . $field );
	}
}

/**
 * Helper function to get/return the zpdfv_Admin object
 * @since  0.1.0
 * @return zpdfv_Admin object
 */
function zpdfv_get_admin() {
	static $zpdfv_admin = null;

	if ( null === $zpdfv_admin ) {
		$zpdfv_admin = new Pdfv_Admin();
		$zpdfv_admin->hooks();
	}

	return $zpdfv_admin;
}
