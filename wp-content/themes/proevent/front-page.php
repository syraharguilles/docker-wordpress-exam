<?php get_header(); ?>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
	<h1 class="text-4xl font-bold mb-12 text-center text-gray-900">Upcoming Events</h1>

	<?php if ( have_posts() ) : ?>
		<div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
			<?php while ( have_posts() ) : the_post(); ?>
				<article <?php post_class( 'bg-white border-gray-200 p-10 rounded-xl shadow-sm p-6 hover:shadow-md transition' ); ?>>
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="mb-5">
							<?php the_post_thumbnail( 'medium', [ 'class' => 'w-full h-auto rounded-md' ] ); ?>
						</div>
					<?php endif; ?>
					
					<h2 class="text-2xl font-semibold text-gray-800 mb-3"><?php the_title(); ?></h2>
					
					<?php
						$date_raw  = get_post_meta( get_the_ID(), '_event_date', true );
						$time_raw  = get_post_meta( get_the_ID(), '_event_time', true );
						$location  = get_post_meta( get_the_ID(), '_event_location', true );

						$formatted_date = $date_raw ? date( 'F j, Y', strtotime( $date_raw ) ) : '';
						$formatted_time = $time_raw ? date( 'g:i A', strtotime( $time_raw ) ) : '';
					?>

					<ul class="text-sm text-gray-600 space-y-1 mb-6">
						<?php if ( $formatted_date ) : ?><li><strong>Date:</strong> <?php echo esc_html( $formatted_date ); ?></li><?php endif; ?>
						<?php if ( $formatted_time ) : ?><li><strong>Time:</strong> <?php echo esc_html( $formatted_time ); ?></li><?php endif; ?>
						<?php if ( $location ) : ?><li><strong>Location:</strong> <?php echo esc_html( $location ); ?></li><?php endif; ?>
					</ul>

					<a href="<?php the_permalink(); ?>" class="inline-block px-5 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md transition">
						View Details →
					</a>
				</article>
			<?php endwhile; ?>
		</div>
	<?php else : ?>
		<p class="text-center text-gray-500 mt-16">No upcoming events found.</p>
	<?php endif; ?>
</main>

<?php get_footer(); ?>
