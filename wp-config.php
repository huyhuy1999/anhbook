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
define( 'WP_MEMORY_LIMIT', '512M' );

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'db_anhbook' );

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
define( 'AUTH_KEY',         'S.w:s1p0{`=f`cq/EXRpYAB  7C<.!?n(L~!^[<<Vm?+`2zR:P7}q^w-IRg7t^Cm' );
define( 'SECURE_AUTH_KEY',  '=cl{4PW)-n{Uw6 Y/r#FT}cBQc2oDl@^:9T@,h|zUO@YN)9TUlcZ2`QP;{TUKjJ/' );
define( 'LOGGED_IN_KEY',    'Vb..0PS-NSN}CrT(JJAAVcm*m!~AgN^cfL n:/Vsj5?zDwN.^&rD@JZ@UB^;R~nm' );
define( 'NONCE_KEY',        'cZ$@mTd7W{qXFMzknS&r0_}$Ff4je??Ai{Wxjj8r>|[xcO4NmRx!Q_y;pafo<N^9' );
define( 'AUTH_SALT',        'W2y8)n`1itBERXmW9R?7T.2){^j(1FU]E;HfEx],sSrT%t}[:&eHx&{A~4B{v*.S' );
define( 'SECURE_AUTH_SALT', 'X(]k.)J[uT8XZ)oevvS5dm,v.8}L SB0P@Bzt?]yUH.zk.SZ kA2mn)z=ILtpGLu' );
define( 'LOGGED_IN_SALT',   '9YGacTMr~R?*H9n/}JBoLDX1hR0_x:<0|U1pQj!rQCSt5{HU`vEgvnW@[3 y7mzj' );
define( 'NONCE_SALT',       'Z(mXNsQ;~n$Op*=8+VL%%-dLJC=/0aEr6]Vah+&*&P7`J+`O`Fy:4?5@:1x-Jclh' );

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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
