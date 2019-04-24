<?php
/**
 * Plugin Name: Ultimate Auction Dashboard
 **/

add_action( 'wp_dashboard_setup', 'remove_dashboard_widgets' );

function UAD_admin_script( $hook ) {

	if ( 'index.php' !== $hook ) {
		return;
	}
	wp_register_script( 'UAD-dashboard', plugin_dir_url( __FILE__ ) . '/dashboard-app/dist/js/app.js' );
	wp_localize_script( 'UAD-dashboard', 'uad_dashboard',
		[
			'auctions' => AUD_get_auctions(),
			'bids'     => AUD_get_auctions_bids()

		]
	);
	wp_enqueue_script( 'UAD-dashboard', plugin_dir_url( __FILE__ ) . '/dashboard-app/dist/js/app.js', [], '', true );
	wp_enqueue_style( 'UAD-dashboard', plugin_dir_url( __FILE__ ) . '/dashboard-app/dist/css/app.css' );
	wp_enqueue_style( 'material-icons', 	'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material Icons' );


}

add_action( 'admin_enqueue_scripts', 'UAD_admin_script' );

function AUD_get_auctions_bids() {
	global $wpdb;
	$results = $wpdb->get_results( 'select name, email, max(bid) as bid, auction_id from wp_wdm_bidders group by auction_id, email' );

	return $results;
}

function AUD_get_auctions() {
	$posts = get_posts( [
		'post_type'      => 'ultimate-auction',
		'posts_per_page' => -1
	] );
	$auctions = [];
	foreach ( $posts as $post ){
		$auctions[$post->ID] = $post;
	}
	return $auctions;
}


function remove_dashboard_widgets() {

	//Completely remove various dashboard widgets (remember they can also be HIDDEN from admin)
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );      //Quick Press widget
	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );      //Recent Drafts
	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );      //WordPress.com Blog
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );      //Other WordPress News
	remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );    //Incoming Links
	remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );    //Plugins

}


function UAD_print_dashboard() {
	echo 'Holla';
}

add_action( 'load-index.php', 'show_welcome_panel' );

function show_welcome_panel() {
	$user_id = get_current_user_id();

	if ( 1 != get_user_meta( $user_id, 'show_welcome_panel', true ) ) {
		update_user_meta( $user_id, 'show_welcome_panel', 1 );
	}
}
