<?php

// Includes
require_once 'inc/helper-functions.php';
require_once 'inc/edd-checkout-fields.php';

function cc_mime_types( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';

	return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );

/**
 * TypeKit Fonts.
 *
 * @since Theme 1.0
 */
function theme_typekit() {
	wp_enqueue_script( 'theme_typekit', '//use.typekit.net/wai6zgw.js' );
}
add_action( 'wp_enqueue_scripts', 'theme_typekit' );
add_action( 'admin_enqueue_scripts', 'theme_typekit' );

function theme_typekit_inline() {
	if ( wp_script_is( 'theme_typekit', 'done' ) ) {
		?>
	  <script type="text/javascript">try{Typekit.load();}catch(e){}</script>
<?php
	}
}
add_action( 'wp_head', 'theme_typekit_inline' );
add_action( 'admin_head', 'theme_typekit_inline' );

function mckernanin_assets() {
	wp_deregister_style( 'stag-custom-style' );
	wp_enqueue_script( 'mckernanin-js', get_stylesheet_directory_uri() . '/assets/js/custom.min.js' );
}
add_action( 'wp_print_styles', 'mckernanin_assets', 100 );

function mck_add_editor_styles() {
	add_editor_style( get_stylesheet_directory_uri() .'/editor-styles.css' );
}
add_action( 'admin_init', 'mck_add_editor_styles' );
