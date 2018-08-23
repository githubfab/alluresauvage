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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'allusauv_main_db');

/** MySQL database username */
define('DB_USER', 'allusauv_main_user');

/** MySQL database password */
define('DB_PASSWORD', 'gi84ra47mu');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'nhIN-V+7g7<3G9OD(t#%!A/]sR-,fuhXHTg`X^O:Wr_F:.n3w3{FWr-& O/)#66[');
define('SECURE_AUTH_KEY',  '6y0fSR^S|7L/~dLu1H*E  @*Ph~{z)[h>3cdwM6VJ+S!DP]&qxh`yrzr(-L/z^M#');
define('LOGGED_IN_KEY',    'zAwo*%qE2b2#mU4Z QpqY!{k#7rYkO$JkGcq/rN^WP]_7$gr6Zb:>eR=n=#CycOG');
define('NONCE_KEY',        'irAlRo.8vbYRGuLduGw=_!0@_a3jc1V54>TkKA~Y1MIO~f,aPcn3`hD>yFCE4ukK');
define('AUTH_SALT',        '&TX*-:{; v1YkB6H%S67~b~}+XZ>pW;%{dOBA,[2dwJ.Z4W;TBptfju5N$8o_{/y');
define('SECURE_AUTH_SALT', 'Nr4w,W|tkZQA|xt3o%[^ATuO%M<6U36%(q=!ct##=arGoWC6fMpYj^u8jOz`3h_A');
define('LOGGED_IN_SALT',   'P63@L()P`EH]3Gf^cUA(T6O6xEN=SUs(Im}kKGh^pbuKR`3^9#K3N)go-oSL3jj2');
define('NONCE_SALT',       'yJ6H?,8Nhg(TS2dJ-]zgTI`--{`~%U`XbJs3b95H)TBft#hwK dw5#awwR_v9YcK');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'tyspc_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
