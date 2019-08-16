<?php 

//Remove unused scripts loaded by Elementor
function wpse_elementor_frontend_scripts() {
    //you can change yourself for which pages the conditional logic below accounts
	if(is_front_page()) {
		// Dequeue and deregister swiper
		wp_dequeue_script( 'swiper' );
		wp_deregister_script( 'swiper' );

		// Dequeue and deregister elementor-dialog
		wp_dequeue_script( 'elementor-dialog' );
		wp_deregister_script( 'elementor-dialog' );

		// Dequeue and deregister elementor-frontend
		wp_dequeue_script( 'elementor-frontend' );
		wp_deregister_script( 'elementor-frontend' );

		// Re-register elementor-frontend without the elementor-dialog/swiper dependency.
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		wp_register_script(
				'elementor-frontend',
				ELEMENTOR_ASSETS_URL . 'js/frontend' . $suffix . '.js',
				[
					'elementor-frontend-modules',
					'elementor-waypoints'
				],
				ELEMENTOR_VERSION,
				true
			);
	}
}
add_action( 'wp_enqueue_scripts', 'wpse_elementor_frontend_scripts' );

//Remove style.css -- Gutenberg
function wps_deregister_styles() {
	if ( ! is_admin()) {
    	wp_dequeue_style( 'wp-block-library' );
	}
}
add_action( 'wp_print_styles', 'wps_deregister_styles', 100 );

//Remove WP-embed
function deregister_wpembed(){
	if ( ! is_admin()) {
		wp_deregister_script( 'wp-embed' );
	}
}
add_action( 'wp_footer', 'deregister_wpembed' );

////Remove JQuery migrate
function remove_jquery_migrate( $scripts ) {
 	if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
 		$script = $scripts->registered['jquery'];

 		if ( $script->deps ) { // Check whether the script has any dependencies
 		$script->deps = array_diff( $script->deps, array( 'jquery-migrate' ) );
 		}
 	}
}
add_action( 'wp_default_scripts', 'remove_jquery_migrate' );

?>