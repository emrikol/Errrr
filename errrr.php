<?php
/**
 * Plugin Name: Errrr
 * Plugin URI: https://github.com/emrikol/errrr
 * Description: Remote error logging for WordPress sites.
 * Version: 1.0.0
 * Author: Derrick Tennant
 * Author URI: https://emrikol.com/
 * License: GPL3
 * GitHub Plugin URI: https://github.com/emrikol/errrr/
 */

function errrr_register_route() {
	register_rest_route( 'webhooks/v1', '/errrr', array(
		'methods' => array( 'GET', 'POST' ),
		'callback' => 'errrr_rest_api_callback',
	) );
}
add_action( 'rest_api_init', 'errrr_register_route' );

function errrr_rest_api_callback( WP_REST_Request $request ) {
	if ( '' === $request->get_body() ) {
		return;
	}
	$body = json_decode( $request->get_body() );

	$dirname = trailingslashit( plugin_dir_path( __FILE__ ) . 'logs' . DIRECTORY_SEPARATOR . sanitize_file_name( $body[0] ) );
	$logname = sanitize_file_name( $body[0] ) . '.log';

	// Make log dir
	if ( ! file_exists( $dirname ) ) {
		mkdir( $dirname, 0775, true );
	}

	if ( false !== $body[2]->type ) {
		$error_message = $body[1] . ' ' . errrr_human_error( $body[2]->type ) . ': ' . $body[2]->message . ' in ' . $body[2]->file . ' on line ' . $body[2]->line . PHP_EOL;
	} else {
		$error_message = $body[1] . ' ' . $body[2]->message . PHP_EOL;
	}

	file_put_contents( $dirname . $logname, $error_message, FILE_APPEND );
}

function errrr_human_error( $type ) {
	switch ( $type ) {
		case E_ERROR: // 1
			return 'E_ERROR';
		case E_WARNING: // 2
			return 'E_WARNING';
		case E_PARSE: // 4
			return 'E_PARSE';
		case E_NOTICE: // 8
			return 'E_NOTICE';
		case E_CORE_ERROR: // 16
			return 'E_CORE_ERROR';
		case E_CORE_WARNING: // 32
			return 'E_CORE_WARNING';
		case E_COMPILE_ERROR: // 64
			return 'E_COMPILE_ERROR';
		case E_COMPILE_WARNING: // 128
			return 'E_COMPILE_WARNING';
		case E_USER_ERROR: // 256
			return 'E_USER_ERROR';
		case E_USER_WARNING: // 512
			return 'E_USER_WARNING';
		case E_USER_NOTICE: // 1024
			return 'E_USER_NOTICE';
		case E_STRICT: // 2048
			return 'E_STRICT';
		case E_RECOVERABLE_ERROR: // 4096
			return 'E_RECOVERABLE_ERROR';
		case E_DEPRECATED: // 8192
			return 'E_DEPRECATED';
		case E_USER_DEPRECATED: // 16384
			return 'E_USER_DEPRECATED';
	}
	return 'UNKNOWN';
}
