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
/** The name of the database for WordPress */


define('WP_ENV', 'local');
define('WP_DEBUG', true);

define('DB_NAME', 'rea_stage-sedona');
define('DB_USER', 'rea_arizona');
define('DB_PASSWORD', 'arizona');
define('DB_HOST', '184.172.169.32:3306');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '?1-T#%Z&,4/x_RCx|UM4|QZMwV9|&Nc&T6saUN.@K -U+U#+]M@g++wCT@9~^Xgh');
define('SECURE_AUTH_KEY',  '6I|mb:ROrh.U q?fYJ{Nk^C>[]QSd 2Md?ei3-py0m&oUF}GO+?y`sA1w-5<uv38');
define('LOGGED_IN_KEY',    '#gc.OL+E(ftU5`@(Z8bjk-:BG%^]@+%.%E+0rIKMTaiWWzvKmJe-Cz(|,Y`rP|7l');
define('NONCE_KEY',        'xBjR@c$Qt/ie=D^%:$*@?+J/n7:?g_.[idB1DWzbH>=u5`ET!{8-.&+O$dvq?se*');
define('AUTH_SALT',        ']D[LenG =.S-6>;i]zfp@ubE:7Tve0!b0/v??K,zMHN*O,4+:KN&Eeq4VJ@;S~wH');
define('SECURE_AUTH_SALT', '/%~~d{Uq7CNX5|s)?Py)>t=41.N4TK-UkRV`]c0$9VC2h&On,4K{hp{7Zk8u.M$w');
define('LOGGED_IN_SALT',   'W$MH`b7/.s?L7JtB;bs3P{i_sSkL:<Xj5Hg!<`IS.^xWv!8q=eO=3+4%eunP&3$Y');
define('NONCE_SALT',       ')#uU8-kr^4,HDWCU1}hJDHEdWW-8U-Wy.iOX9UEz*Q%|hLP%#+|vSIwi simqd:N');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/* That's all, stop editing! Happy blogging. */

/** HACKS BE WARE SETS THE DB LOCATION TO WHAT SERVER YOU ARE ON (so local testing will work) */
define('WP_HOME',    'http://' . $_SERVER['HTTP_HOST'] . '/stage/sedona'); // no trailing slash
define('WP_SITEURL', 'http://' . $_SERVER['SERVER_NAME'] . '/stage/sedona');  // no trailing slash
/** HACKS BE WARE */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
