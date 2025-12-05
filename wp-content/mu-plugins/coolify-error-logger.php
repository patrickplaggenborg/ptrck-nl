<?php
/**
 * Plugin Name: Coolify Error Logger
 * Description: Redirects WordPress errors to stderr (Coolify service logs) for better visibility
 * Version: 1.0
 * Author: Auto-generated
 */

// Ensure errors are logged to stderr (captured by Coolify)
if (defined('WP_DEBUG') && WP_DEBUG) {
	
	// Hook into WordPress error logging
	add_filter('wp_php_error_args', function($args, $error) {
		// Log to stderr (Coolify logs)
		$message = sprintf(
			'[WordPress Error] %s in %s on line %d',
			$error['message'],
			$error['file'],
			$error['line']
		);
		error_log($message);
		return $args;
	}, 10, 2);
	
	// Log fatal errors
	register_shutdown_function(function() {
		$error = error_get_last();
		if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
			$message = sprintf(
				'[WordPress FATAL ERROR] %s in %s on line %d',
				$error['message'],
				$error['file'],
				$error['line']
			);
			error_log($message);
		}
	});
	
	// Log database errors
	add_action('wp_db_error', function($error) {
		error_log('[WordPress DB ERROR] ' . $error);
	});
	
	// Log any error_log() calls from WordPress
	// WordPress uses error_log() for wp_debug_log(), which will now go to stderr
}
