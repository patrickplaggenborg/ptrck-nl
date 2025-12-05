<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', getenv('WORDPRESS_DB_NAME') ?: 'ptrck_nl');

/** MySQL database username */
define('DB_USER', getenv('WORDPRESS_DB_USER') ?: 'ptrck_nl');

/** MySQL database password */
define('DB_PASSWORD', getenv('WORDPRESS_DB_PASSWORD') ?: '');

/** MySQL hostname */
define('DB_HOST', getenv('WORDPRESS_DB_HOST') ?: 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', getenv('WORDPRESS_DB_CHARSET') ?: 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', getenv('WORDPRESS_DB_COLLATE') ?: '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */

define('FS_METHOD', getenv('WORDPRESS_FS_METHOD') ?: 'direct');
define('AUTH_KEY',         getenv('WORDPRESS_AUTH_KEY') ?: '');
define('SECURE_AUTH_KEY',  getenv('WORDPRESS_SECURE_AUTH_KEY') ?: '');
define('LOGGED_IN_KEY',    getenv('WORDPRESS_LOGGED_IN_KEY') ?: '');
define('NONCE_KEY',        getenv('WORDPRESS_NONCE_KEY') ?: '');
define('AUTH_SALT',        getenv('WORDPRESS_AUTH_SALT') ?: '');
define('SECURE_AUTH_SALT', getenv('WORDPRESS_SECURE_AUTH_SALT') ?: '');
define('LOGGED_IN_SALT',   getenv('WORDPRESS_LOGGED_IN_SALT') ?: '');
define('NONCE_SALT',       getenv('WORDPRESS_NONCE_SALT') ?: '');
define('WP_TEMP_DIR',      getenv('WORDPRESS_TEMP_DIR') ?: '/var/www/html/wp-content/uploads');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = getenv('WORDPRESS_TABLE_PREFIX') ?: 'wp2_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', getenv('WORDPRESS_LANG') ?: '');

/**
 * WordPress URL Configuration
 * Force HTTPS for all URLs
 */
if (!defined('WP_HOME')) {
	define('WP_HOME', getenv('WORDPRESS_HOME') ?: 'https://ptrck.nl');
}
if (!defined('WP_SITEURL')) {
	define('WP_SITEURL', getenv('WORDPRESS_SITEURL') ?: 'https://ptrck.nl');
}
// Force SSL for admin
define('FORCE_SSL_ADMIN', true);
// Detect if we're behind a proxy/load balancer
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
	$_SERVER['HTTPS'] = 'on';
}

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', filter_var(getenv('WORDPRESS_DEBUG'), FILTER_VALIDATE_BOOLEAN) ?: false);

/**
 * WordPress Debug Logging
 * 
 * WP_DEBUG_LOG - Log errors to wp-content/debug.log (default: true for logging)
 * WP_DEBUG_DISPLAY - Display errors on screen (default: true to show in browser)
 * SAVEQUERIES - Save database queries for analysis (default: false)
 */
define('WP_DEBUG_LOG', filter_var(getenv('WORDPRESS_DEBUG_LOG'), FILTER_VALIDATE_BOOLEAN) ?: true);
define('WP_DEBUG_DISPLAY', filter_var(getenv('WORDPRESS_DEBUG_DISPLAY'), FILTER_VALIDATE_BOOLEAN) ?: false);
@ini_set('display_errors', 0);
@ini_set('display_startup_errors', 0);

/**
 * Save database queries for analysis (optional, can impact performance)
 */
define('SAVEQUERIES', filter_var(getenv('WORDPRESS_SAVEQUERIES'), FILTER_VALIDATE_BOOLEAN) ?: false);

/**
 * Configure PHP error logging to stderr (captured by Coolify/Docker logs)
 * This ensures errors appear in Coolify service logs
 */
@ini_set('log_errors', 1);
@ini_set('error_log', 'php://stderr');

/**
 * Custom error handler to log WordPress errors to stderr (Coolify logs)
 * This runs before WordPress loads, so we can catch early errors too
 */
if (WP_DEBUG || WP_DEBUG_LOG) {
	set_error_handler(function($errno, $errstr, $errfile, $errline) {
		// Log to stderr (Coolify logs)
		$error_types = array(
			E_ERROR => 'ERROR',
			E_WARNING => 'WARNING',
			E_PARSE => 'PARSE',
			E_NOTICE => 'NOTICE',
			E_CORE_ERROR => 'CORE_ERROR',
			E_CORE_WARNING => 'CORE_WARNING',
			E_COMPILE_ERROR => 'COMPILE_ERROR',
			E_COMPILE_WARNING => 'COMPILE_WARNING',
			E_USER_ERROR => 'USER_ERROR',
			E_USER_WARNING => 'USER_WARNING',
			E_USER_NOTICE => 'USER_NOTICE',
			E_STRICT => 'STRICT',
			E_RECOVERABLE_ERROR => 'RECOVERABLE_ERROR',
			E_DEPRECATED => 'DEPRECATED',
			E_USER_DEPRECATED => 'USER_DEPRECATED'
		);
		$error_type = isset($error_types[$errno]) ? $error_types[$errno] : 'UNKNOWN';
		$message = sprintf('[WordPress %s] %s in %s on line %d', $error_type, $errstr, $errfile, $errline);
		error_log($message);
		// Continue with default error handling
		return false;
	}, E_ALL);
}

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
