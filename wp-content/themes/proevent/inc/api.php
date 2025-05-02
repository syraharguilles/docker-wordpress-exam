<?php
/**
 * Register a custom REST API endpoint for upcoming events
 */

add_action( 'rest_api_init', function () {
	register_rest_route( 'proevent/v1', '/next', [
		'methods'             => 'GET',
		'callback'            => 'proevent_get_upcoming_events',
		'permission_callback' => '__return_true',
	] );
} );

function proevent_get_upcoming_events( $request ) {
	$today = date( 'Y-m-d' );
	$category = sanitize_text_field( $request->get_param( 'category' ) );

	$args = [
		'post_type'      => 'event',
		'posts_per_page' => 5,
		'meta_key'       => '_event_date',
		'orderby'        => 'meta_value',
		'order'          => 'ASC',
		'meta_query'     => [
			[
				'key'     => '_event_date',
				'value'   => $today,
				'compare' => '>=',
				'type'    => 'DATE',
			],
		],
	];

	// Add taxonomy filter if a category slug is provided
	if ( $category ) {
		$args['tax_query'] = [
			[
				'taxonomy' => 'event-category',
				'field'    => 'slug',
				'terms'    => $category,
			],
		];
	}

	$query = new WP_Query( $args );

	$results = [];

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$results[] = [
				'id'       => get_the_ID(),
				'title'    => get_the_title(),
				'link'     => get_permalink(),
				'date'     => get_post_meta( get_the_ID(), '_event_date', true ),
				'time'     => get_post_meta( get_the_ID(), '_event_time', true ),
				'location' => get_post_meta( get_the_ID(), '_event_location', true ),
			];
		}
		wp_reset_postdata();
	}

	return rest_ensure_response( $results );
}