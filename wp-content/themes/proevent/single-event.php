<?php get_header(); ?>

<main class="container mx-auto px-4 py-12 grid grid-cols-1 lg:grid-cols-4 gap-10">
	<aside class="lg:col-span-1">
		<h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Event Categories</h2>
		<ul class="space-y-2">
			<?php
				$categories = get_terms([
					'taxonomy'   => 'event-category',
					'hide_empty' => true,
				]);

				if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) :
					foreach ( $categories as $cat ) :
						printf(
							'<li><a href="%s" class="text-blue-600 hover:underline">%s</a></li>',
							esc_url( get_term_link( $cat ) ),
							esc_html( $cat->name )
						);
					endforeach;
				endif;
			?>
		</ul>
	</aside>

	<div class="lg:col-span-2">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<article <?php post_class( 'mb-16' ); ?>>
				<h1 class="text-4xl font-bold mb-6 text-gray-900 dark:text-white"><?php the_title(); ?></h1>

				<?php
					$date_raw  = get_post_meta( get_the_ID(), '_event_date', true );
					$time_raw  = get_post_meta( get_the_ID(), '_event_time', true );
					$location  = get_post_meta( get_the_ID(), '_event_location', true );
					$link      = get_post_meta( get_the_ID(), '_event_link', true );

					$formatted_date = $date_raw ? date( 'F j, Y', strtotime( $date_raw ) ) : '';
					$formatted_time = $time_raw ? date( 'g:i A', strtotime( $time_raw ) ) : '';
				?>

				<?php
					$terms = get_the_terms( get_the_ID(), 'event-category' );
					if ( $terms && ! is_wp_error( $terms ) ) {
						echo '<ul class="text-sm text-gray-600 mb-4"><li><strong>Category:</strong> ';
						echo esc_html( join( ', ', wp_list_pluck( $terms, 'name' ) ) );
						echo '</li></ul>';
					}
				?>

				<ul class="text-sm text-gray-700 space-y-1 mb-6">
					<?php if ( $formatted_date ) : ?><li><strong>Date:</strong> <?php echo esc_html( $formatted_date ); ?></li><?php endif; ?>
					<?php if ( $formatted_time ) : ?><li><strong>Time:</strong> <?php echo esc_html( $formatted_time ); ?></li><?php endif; ?>
					<?php if ( $location ) : ?><li><strong>Location:</strong> <?php echo esc_html( $location ); ?></li><?php endif; ?>
					<?php if ( $link ) : ?><li><strong>Register:</strong> <a href="<?php echo esc_url( $link ); ?>" class="text-blue-600 hover:underline">Click here</a></li><?php endif; ?>
				</ul>

				<div class="prose max-w-none mb-10 dark:prose-invert">
					<?php the_content(); ?>
				</div>
			</article>
		<?php endwhile; endif; ?>
	</div>

	<aside class="lg:col-span-1">
		<?php
			$terms = wp_get_post_terms( get_the_ID(), 'event-category', [ 'fields' => 'ids' ] );

			if ( $terms ) :
				$related = new WP_Query([
					'post_type'      => 'event',
					'posts_per_page' => 3,
					'post__not_in'   => [ get_the_ID() ],
					'tax_query'      => [
						[
							'taxonomy' => 'event-category',
							'field'    => 'term_id',
							'terms'    => $terms,
						]
					],
				]);

				if ( $related->have_posts() ) : ?>
					<h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Related Events</h2>
					<ul class="space-y-4">
						<?php while ( $related->have_posts() ) : $related->the_post(); ?>
							<li class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
								<a href="<?php the_permalink(); ?>" class="block text-blue-600 hover:underline font-semibold"><?php the_title(); ?></a>
							</li>
						<?php endwhile; wp_reset_postdata(); ?>
					</ul>
				<?php endif;
			endif;
		?>
	</aside>
</main>

<?php get_footer(); ?>
