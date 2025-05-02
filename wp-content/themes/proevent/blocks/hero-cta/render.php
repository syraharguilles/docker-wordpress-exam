<?php
if ( ! function_exists( 'proevent_render_hero_cta_block' ) ) {
    function proevent_render_hero_cta_block( $attributes ) {
        error_log('proevent_render_hero_cta_block() was triggered with: ' . print_r($attributes, true));

        $imageUrl   = esc_url( $attributes['imageUrl'] ?? '' );
        $heading    = esc_html( $attributes['heading'] ?? 'Join Our Event' );
        $buttonText = esc_html( $attributes['buttonText'] ?? 'Learn More' );
        $buttonUrl  = esc_url( $attributes['buttonUrl'] ?? '#' );
    
        ob_start();
        ?>
        <section class="bg-cover bg-center text-white p-12" style="background-image: url('<?php echo $imageUrl; ?>');">
        <div class="container mx-auto text-center">
            <h2 class="text-4xl font-bold mb-4"><?php echo $heading; ?></h2>
            <a href="<?php echo $buttonUrl; ?>" class="inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded">
            <?php echo $buttonText; ?>
            </a>
            <img src="<?php echo $imageUrl; ?>" alt="<?php echo esc_attr( $heading ); ?>" class="hidden" aria-hidden="true" />
        </div>
        </section>
        <?php
        return ob_get_clean();
    }

    add_action( 'init', function() {
        register_block_type( __DIR__, [
            'render_callback' => 'proevent_render_hero_cta_block'
        ] );
    });
}