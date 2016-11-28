<?php

class McKernanin_Theme {

	function __construct() {

		add_filter( 'upload_mimes', 		array( $this, 'mime_types' ) );
		add_filter( 'body_class',   		array( $this, 'add_slug_to_body_class' ) );

		add_action( 'send_headers', 		array( $this, 'custom_headers' ) );
		add_action( 'wp_enqueue_scripts', 	array( $this, 'typekit' ) );
		add_action( 'admin_init', 			array( $this, 'editor_styles' ) );
		add_action( 'wp_print_styles', 		array( $this, 'scripts_styles' ), 100 );

		$this->roots_support();
		$this->content_types();
	}

	/**
	 * Add custom allowed media upload file types.
	 */

	public function mime_types( $mimes ) {
		$mimes['svg'] = 'image/svg+xml';

		return $mimes;
	}

	/**
	 * Add page slug as a body class.
	 */

	public function add_slug_to_body_class( $classes ) {
		global $post;
		if ( isset( $post ) ) {
			$classes[] = $post->post_type . '-' . $post->post_name;
		}
		return $classes;
	}

	/**
	 * Add custom headers.
	 */
	public function custom_headers() {
		header( 'Access-Control-Allow-Origin: *' );
	}

	/**
	 * Add theme support for Soil functions. Helps clean up WordPress markup.
	 */

	public function roots_support() {
		add_theme_support( 'soil-clean-up' );
		add_theme_support( 'soil-disable-asset-versioning' );
		add_theme_support( 'soil-disable-trackbacks' );
		// add_theme_support( 'soil-google-analytics', 'UA-XXXXXXXX-Y' );
		add_theme_support( 'soil-jquery-cdn' );
		// add_theme_support( 'soil-js-to-footer' );
		add_theme_support( 'soil-nav-walker' );
		add_theme_support( 'soil-nice-search' );
		add_theme_support( 'soil-relative-urls' );
	}

	/**
	 * Add typekit support if needed. Replace $kit_id with one from the kit you create.
	 */
	public function typekit() {
		$kit_id = 'wai6zgw';
		wp_enqueue_script( 'theme_typekit', 'https://use.typekit.net/' . $kit_id . '.js' );
		wp_add_inline_script( 'theme_typekit', 'try{Typekit.load({ async: true });}catch(e){}' );
	}

	public function scripts_styles() {
		wp_deregister_style( 'stag-custom-style' );
		wp_enqueue_script( 'mckernanin-js', get_stylesheet_directory_uri() . '/assets/js/custom.min.js' );
	}

	public function editor_styles() {
		add_editor_style( get_stylesheet_directory_uri() . '/editor-styles.css' );
	}

	public function content_types() {
		include_once( 'inc/class-fields.php' );
		$instagram_photos = new CPT( 'instagram_photo' );
	}
}

new McKernanin_Theme();
