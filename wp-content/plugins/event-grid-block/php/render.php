<?php

if ( ! function_exists( 'proevent_render_event_grid_block' ) ) {
	function proevent_render_event_grid_block( $attributes ) {
		error_log('proevent_render_event_grid_block() was triggered with: ' . print_r($attributes, true));

		$limit    = isset( $attributes['limit'] ) ? absint( $attributes['limit'] ) : 6;
		$category = isset( $attributes['category'] ) ? sanitize_text_field( $attributes['category'] ) : '';
		$order    = isset( $attributes['order'] ) ? sanitize_key( $attributes['order'] ) : 'ASC';
		$orderby  = isset( $attributes['orderby'] ) ? sanitize_key( $attributes['orderby'] ) : 'meta_value';

		$wrapper_attributes = get_block_wrapper_attributes( [
			'data-limit'    => $limit,
			'data-category' => $category,
			'data-order'    => $order,
			'data-orderby'  => $orderby,
		] );

		ob_start();
		?>

		<div <?php echo $wrapper_attributes; ?>>
			<p class="loading-message">Loading events...</p>
		</div>

		<?php
		return ob_get_clean();
	}
}
