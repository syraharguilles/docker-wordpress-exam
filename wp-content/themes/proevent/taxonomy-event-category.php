<?php get_header(); ?>

<main class="container mx-auto px-4 py-8">
    <!-- Category Title -->
    <header class="mb-6">
        <h1 class="text-3xl font-bold"><?php single_term_title(); ?></h1>
    </header>

    <?php if ( have_posts() ) : ?>
        <!-- Events Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php while ( have_posts() ) : the_post(); ?>
                <!-- Event Card -->
                <article <?php post_class("bg-white rounded-lg shadow-md p-6 flex flex-col"); ?>>
                    <h2 class="text-2xl font-semibold mb-3">
                        <a href="<?php the_permalink(); ?>" class="hover:underline">
                            <?php the_title(); ?>
                        </a>
                    </h2>
                    <div class="mb-4">
                        <?php the_excerpt(); ?>
                    </div>
                    <a href="<?php the_permalink(); ?>" class="mt-auto inline-block text-blue-600 font-medium hover:text-blue-800">
                        <?php _e( 'View Details', 'textdomain' ); ?>
                    </a>
                </article>
            <?php endwhile; ?>
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            <?php 
            the_posts_pagination( array(
                'mid_size'           => 2,
                'prev_text'          => __( '« Previous', 'textdomain' ),
                'next_text'          => __( 'Next »', 'textdomain' ),
                'screen_reader_text' => __( 'Events navigation', 'textdomain' ),
            ) ); 
            ?>
        </div>
    <?php else : ?>
        <!-- No Events Found Message -->
        <p><?php esc_html_e( 'No events found in this category.', 'textdomain' ); ?></p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
