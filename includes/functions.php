<?php
/**
 * Wrapper function around cmb2_get_option
 * @since  0.1.0
 * @param  string  $key Options array key
 * @return mixed        Option value
 */
function zpdfv_get_option( $key = '' ) {
	global $zpdfv_admin;
	return cmb2_get_option( $zpdfv_admin->key, $key );
}
