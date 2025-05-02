<?php
/**
 * Plugin Name: Event Grid Block
 * Description: Gutenberg block that displays a grid of events.
 * Version: 1.0
 * Author: Syrah Arguilles
 * Text Domain: proevent
 */

defined( 'ABSPATH' ) || exit;

$plugin_dir = plugin_dir_path( __FILE__ );

// Load the render callback function
require_once $plugin_dir . 'php/render.php';

// Register the block and attach the render callback
add_action( 'init', function() use ( $plugin_dir ) {
	register_block_type( $plugin_dir, [
		'render_callback' => 'proevent_render_event_grid_block'
	]);
});

// Frontend JS loader for dynamic API (optional)
add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_script(
		'event-grid-api-frontend',
		plugins_url( 'assets/event-grid.js', __FILE__ ),
		[],
		filemtime( plugin_dir_path( __FILE__ ) . 'assets/event-grid.js' ),
		true
	);
});
