<?php
if ( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) {
	@error_reporting( E_ALL );
	@ini_set( 'log_errors', true );
	@ini_set( 'log_errors_max_len', '0' );

	define( 'WP_DEBUG_LOG', true );
	define( 'WP_DEBUG_DISPLAY', true );
	define( 'CONCATENATE_SCRIPTS', false );
	define( 'SAVEQUERIES', true );

	function errrr_log( $error ) {
		error_log( $error );
		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_URL, ERRRR_REMOTE );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( array( $_SERVER['HTTP_HOST'], date( '[d-M-Y G:i:s \U\T\C]',  time() ), $error ) ) );
		curl_setopt( $ch, CURLOPT_POST, 1 );

		$headers = array();
		$headers[] = 'Content-Type: application/json';
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );

		$result = curl_exec( $ch );
		curl_close( $ch );
	}

	function errrr_remote_logs() {
		if ( ! defined( 'ERRRR_REMOTE' ) ) {
			return;
		}
		$error = error_get_last();

		if ( null !== $error ) {
			$ch = curl_init();

			curl_setopt( $ch, CURLOPT_URL, ERRRR_REMOTE );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( array( $_SERVER['HTTP_HOST'], date( '[d-M-Y G:i:s \U\T\C]',  time() ), $error ) ) );
			curl_setopt( $ch, CURLOPT_POST, 1 );

			$headers = array();
			$headers[] = 'Content-Type: application/json';
			curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );

			$result = curl_exec( $ch );
			curl_close( $ch );
		}
	}
	register_shutdown_function( 'errrr_remote_logs' );

	function errrr_custom_handler( $errno, $errstr, $errfile, $errline, $errcontext ) {
		if ( ! defined( 'ERRRR_REMOTE' ) ) {
			return;
		}
		$error = array();
		$error['type'] = $errno;
		$error['message'] = $errstr;
		$error['file'] = $errstr;
		$error['line'] = $line;
		//$error = error_get_last();

		if ( null !== $error ) {
			$ch = curl_init();

			curl_setopt( $ch, CURLOPT_URL, ERRRR_REMOTE );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( array( $_SERVER['HTTP_HOST'], date( '[d-M-Y G:i:s \U\T\C]',  time() ), $error ) ) );
			curl_setopt( $ch, CURLOPT_POST, 1 );

			$headers = array();
			$headers[] = 'Content-Type: application/json';
			curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );

			$result = curl_exec( $ch );
			curl_close( $ch );
			return false;
		}
		set_error_handler( 'errrr_custom_handler' );
	}

}