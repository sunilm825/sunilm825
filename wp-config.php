<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'test-wp' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'rSVq[~_)HZx ,CT$Nc,|Yh,xl*D}?J3Y|ywW6?&}$ORU_#7d @=8QsfS|r<f_exV' );
define( 'SECURE_AUTH_KEY',  '#-OkXPs(P194-X]G:d[;3^V;cJA//pzK9Zr%<Cr6<SVaRL7c!XO )|fib<3?F1CE' );
define( 'LOGGED_IN_KEY',    ' &*bDik]Ta7WWkFvPsk&pwgdF_&vtc}+zK1ly@t^xB#&2*AAB&.[%T?jhIx@4,Ex' );
define( 'NONCE_KEY',        'FN(P(&b6/-U?,lN0RWpqKA5hRr%QmFT#m;B4U9XHm4#~NqsYGF|2quPpary+F@ir' );
define( 'AUTH_SALT',        ']>INT.u};+i-+5&E2yA21E]$Z0WpEZ_a^HiUgg24OfUs(t,QJ^ZX+713Q4}(s [/' );
define( 'SECURE_AUTH_SALT', '3kP.Hdv/%GJc>mZ/k8WK}PK~|:]+J%j-{b{ebI8|.zEjS$hWGR=ep!h wI{eI`{h' );
define( 'LOGGED_IN_SALT',   '>:h~bDDc N)x0$Uhy`o%Swo*+{e8RT!LEtD!r)e8[$}~=X=TM`,WCPU+]S*F9wg@' );
define( 'NONCE_SALT',       'cE(E(@XtLw&wZt;DH=k4Gz~GasuJ??AyU%0I(L$)+%M9,9VXlUC0ApxGKDb2Qn6(' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'tstwp_';

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
