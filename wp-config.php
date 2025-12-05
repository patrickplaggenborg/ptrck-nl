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
define('DB_NAME', 'ptrck_nl');

/** MySQL database username */
define('DB_USER', 'ptrck_nl');

/** MySQL database password */
define('DB_PASSWORD', 'i9RtjT%Qd8L^wa');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */

define('FS_METHOD','direct');
define('AUTH_KEY',         'c1buXeC9cfWAr4TOnd0IadkEukEZOXnHKxk0AWUieNSliIdD96ZCsF43ESTvxPOZ');
define('SECURE_AUTH_KEY',  'qXA5V4S79HcLGEoCaKyI6vXGXU0MmRx5UXynZUoxnrCEi9b6YUyYcCVZXSCPK9g9');
define('LOGGED_IN_KEY',    'ypcXzYVLO91ngbksyVKNajp61OECAkcg2up5W3ZRxp7AC4btnEW5rEHNe44WNzaV');
define('NONCE_KEY',        'KDIrLcbWkWYvYg54iYhjbgkjf12Fc5KPXvDlQ2tytY531AfcfaPnw4yd1Kp3KOUV');
define('AUTH_SALT',        'cT6rjxKMj0ERTy2vUCKshONdWCjWjDrwDmR4WXl5wG87UJqV7jORt1WGXW8JKCEN');
define('SECURE_AUTH_SALT', 'IdSGugElVRvB4nC6fGRJuvOp8ho43J5wIvBKfXc67FWFYMyzcyQzam07umlUT332');
define('LOGGED_IN_SALT',   'UXS1E611BXZlui1lRN5cb8PeGGcgCLgAiFXeTaEfswsBq9ZOWwuy1A7xFAnJ3Q31');
define('NONCE_SALT',       'w7iTdvW6wtv2PXqfrMfdVJB19LOVCsrO8KhjWhU3AAf2VzWAmXMuQ7WU6kFZmTje');
define('WP_TEMP_DIR',      '/home/ptrck/domains/ptrck.nl/public_html/wp-content/uploads');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp2_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
