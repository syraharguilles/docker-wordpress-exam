<?php get_header(); ?>

<main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<article <?php post_class('mb-12'); ?>>
			<header class="mb-8 pb-6">
				<h1 class="text-4xl font-bold tracking-tight text-gray-900"><?php the_title(); ?></h1>
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="mt-6">
						<?php the_post_thumbnail( 'large', ['class' => 'rounded-lg shadow-sm'] ); ?>
					</div>
				<?php endif; ?>
			</header>

			<div class="prose prose-lg max-w-none text-gray-800 dark:prose-invert">
				<?php the_content(); ?>
			</div>
		</article>
	<?php endwhile; endif; ?>
</main>

<?php get_footer(); ?>
