<footer class="site-footer py-8 bg-gray-100 dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <?php
        $socials_json = get_option( 'company_socials' );
        $socials = json_decode( $socials_json, true );
        if ( is_array( $socials ) && ! empty( $socials ) ) : ?>
            <div class="mt-6 flex justify-center gap-8">
                <?php foreach ( $socials as $social ) : ?>
                    <a href="<?php echo esc_url( $social['url'] ); ?>" class="text-gray-600 hover:text-blue-600 text-2xl transition-colors duration-200" target="_blank" rel="noopener noreferrer">
                        <i class="fab fa-<?php echo esc_attr( $social['icon'] ); ?>"></i>
                        <span class="sr-only"><?php echo esc_html( $social['name'] ); ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>