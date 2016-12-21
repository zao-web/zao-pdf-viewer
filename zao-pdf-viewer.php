<?php
/**
 * Plugin Name: Zao PDF Viewer
 * Plugin URI: http://zao.is
 * Description: PDF Viewer plugin.
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

/**
 * PDF Viewer Functions
 */
require_once  __DIR__ .'/includes/functions.php';

/**
 * Admin Settings Page
 */
require_once( 'includes/classes/admin.php' );
zpdfv_get_admin();
