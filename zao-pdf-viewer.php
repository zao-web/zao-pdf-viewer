<?php
/**
 * Plugin Name: Zao PDF Viewer
 * Plugin URI: http://zao.is
 * Description: PDF Viewer shortcode plugin. Uses Mozilla's pdf.js.
 * Version: 0.1.0
 * Author: Justin Sternberg
 * Author URI: http://zao.is
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or, at
 * your discretion, any later version, as published by the Free
 * Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

/**
 * Plugin Init
 *
 * This file registers the plugin.
 *
 * @package ZPDF_Viewer
 * @author  Justin Sternberg <jt@zao.is>
 * @license http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since   0.1.0
 */

define( 'ZPDFV_VERSION', '0.1.0' );
define( 'ZPDFV_OPT_KEY', 'zpdfv_options' );
define( 'ZPDFV_URL', plugins_url( '/', __FILE__ ) );
define( 'ZPDFV_SHORTCODE_TAG', 'pdfviewer' );
define( 'ZPDFV_DIR', trailingslashit( dirname( __FILE__ ) ) );

/**
 * PDF Viewer Functions
 */
require_once  __DIR__ .'/includes/functions.php';

/**
 * Autoloads ZPDF_Viewer_ class files when they are called.
 * @since  0.1.0
 * @param  string $class_name Name of the class being requested
 */
function zpdf_autoload_classes( $class_name ) {
	if ( 0 === strpos( $class_name, 'ZPDF_Viewer_' ) ) {
		$path = 'includes/classes';
		$filename = strtolower( str_replace( array( 'ZPDF_Viewer_', '_' ), array( '', '-' ), $class_name ) );

		include_once ZPDFV_DIR . "$path/{$filename}.php";
	}
}
spl_autoload_register( 'zpdf_autoload_classes' );

function zpdf_init_objects() {
	if ( is_admin() ) {
		/**
		 * Admin Settings Page
		 */
		ZPDF_Viewer_Admin::get_instance();
	} else {
		/**
		 * Frontend Object
		 */
		ZPDF_Viewer_Frontend::get_instance();
	}
}
add_action( 'plugins_loaded', 'zpdf_init_objects' );
