<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '>L~5N%7tXZ#KX8_ ^AkMlm>T/h>gFb;y+U];/vh1XbFOrs ?N}fb&07%5GP*(Yy1' );
define( 'SECURE_AUTH_KEY',  'q}R21P8sq2lc+C!k;Z+Y}[AI2ov9*kg/,_044)U6Il2YGNX<|fIiDt,`0U=T7H2{' );
define( 'LOGGED_IN_KEY',    'Y2]q@62r2%LS4(-<?otQtZ=Ap`n%?gVI)K|!~BlXd0Mc9HQMMsR/Ss=fRI_jLMg)' );
define( 'NONCE_KEY',        '!-h6mmHjhWrymWKPoJ*.h$,CNXUA P-2C;bc5f/{-jL1aydt.eP3S<o.@z*hMDVl' );
define( 'AUTH_SALT',        'j],L#.hmb&zP+<peq!FtJiqyVTLyHlZ/EW3kb&tx.#w+:A(jUPw_ziFDn_vbm#ge' );
define( 'SECURE_AUTH_SALT', '{<hz+$n[,!70]jJOD&OI8b`Zr.C2JHUbxUg^P?t{m2A=XWuYAaD*z(HV2)!4v5h$' );
define( 'LOGGED_IN_SALT',   'sobG67eR wh<<n]z9ODsMeFdA,Cqt0ozpA-`K{o`AHLw.Y9WF+3US>li?;).uEKZ' );
define( 'NONCE_SALT',       ';.YZ^o_x_Yj8ItiHCqj^WyqE2s4}]h@!o4),z_n11?D<B!85&gKxy[0jF|5](e`v' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true);
define( 'WP_DEBUG_DISPLAY', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
