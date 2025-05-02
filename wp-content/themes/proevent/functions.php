<?php
/**
 * ProEvent Theme - Functional Scope Overview
 */

require_once get_template_directory() . '/inc/api.php';

add_action( 'wp_enqueue_scripts', function() {
	wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css' );
});

// =============================
// THEME SETUP
// =============================
add_action( 'after_setup_theme', function() {
	add_theme_support( 'html-loader' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
});

add_action( 'after_setup_theme', function() {
	register_nav_menus([
		'primary' => 'Primary Menu',
	]);
});

// =============================
// REGISTER CPT: event + TAXONOMY: event-category
// =============================
add_action( 'init', function() {
	register_post_type( 'event', [
		'label' => 'Events',
		'public' => true,
		'has_archive' => true,
		'show_in_rest' => true,
		'supports' => [ 'title', 'editor', 'thumbnail' ],
		'rewrite' => [ 'slug' => 'events' ],
	] );

	register_taxonomy( 'event-category', 'event', [
		'label' => 'Event Categories',
		'public' => true,
		'show_in_rest' => true,
		'hierarchical' => true,
		'rewrite' => [ 'slug' => 'event-category' ],
	] );
});

// =============================
// CUSTOM META FIELDS (ACF-style)
// =============================
add_action( 'add_meta_boxes', function() {
	add_meta_box( 'event_details', 'Event Details', function( $post ) {
		$date = get_post_meta( $post->ID, '_event_date', true );
		$time = get_post_meta( $post->ID, '_event_time', true );
		$location = get_post_meta( $post->ID, '_event_location', true );
		$link = get_post_meta( $post->ID, '_event_link', true );
		?>
		<p><label>Date:<br><input type="date" name="_event_date" value="<?php echo esc_attr( $date ); ?>" /></label></p>
		<p><label>Time:<br><input type="time" name="_event_time" value="<?php echo esc_attr( $time ); ?>" /></label></p>
		<p><label>Location:<br><input type="text" name="_event_location" value="<?php echo esc_attr( $location ); ?>" /></label></p>
		<p><label>Registration Link:<br><input type="url" name="_event_link" value="<?php echo esc_attr( $link ); ?>" /></label></p>
		<?php
	}, 'event', 'normal', 'default' );
});

add_action( 'save_post_event', function( $post_id ) {
	foreach ( [ 'date', 'time', 'location', 'link' ] as $field ) {
		$key = "_event_{$field}";
		if ( isset( $_POST[ $key ] ) ) {
			update_post_meta( $post_id, $key, sanitize_text_field( $_POST[ $key ] ) );
		}
	}
});

// =============================
// CUSTOM SETTINGS PAGE
// =============================
add_action( 'admin_menu', function() {
	add_options_page( 'Company Settings', 'Company Settings', 'manage_options', 'company-settings', function() {
		?>
		<div class="wrap">
			<h1>Company Settings</h1>
			<form method="post" action="options.php">
				<?php
				settings_fields( 'company_settings' );
				do_settings_sections( 'company-settings' );
				submit_button();
				?>
			</form>
		</div>
		<?php
	});
});

add_action( 'admin_init', function() {
	register_setting( 'company_settings', 'company_logo' );
	register_setting( 'company_settings', 'company_color' );
	register_setting( 'company_settings', 'company_socials' );

	add_settings_section( 'general', 'General Settings', null, 'company-settings' );

	add_settings_field( 'company_logo', 'Logo URL', function() {
		printf( '<input type="text" name="company_logo" value="%s" class="regular-text" />', esc_attr( get_option( 'company_logo' ) ) );
	}, 'company-settings', 'general' );

	add_settings_field( 'company_color', 'Brand Color', function() {
		printf( '<input type="text" name="company_color" value="%s" class="regular-text" />', esc_attr( get_option( 'company_color' ) ) );
	}, 'company-settings', 'general' );

	add_settings_field( 'company_socials', 'Social Links (JSON)', function() {
		printf( '<textarea name="company_socials" class="large-text">%s</textarea>', esc_textarea( get_option( 'company_socials' ) ) );
	}, 'company-settings', 'general' );
});

// =============================
// HOMEPAGE TEMPLATE (EVENT LIST)
// =============================
add_action( 'pre_get_posts', function( $query ) {
	if ( $query->is_main_query() && $query->is_home() && ! is_admin() ) {
		$query->set( 'post_type', 'event' );
		$query->set( 'posts_per_page', 6 );
		$query->set( 'orderby', 'meta_value' );
		$query->set( 'meta_key', '_event_date' );
		$query->set( 'order', 'ASC' );
	}
});

// =============================
// SINGLE EVENT VIEW + RELATED EVENTS
// =============================
add_filter( 'template_include', function( $template ) {
	if ( is_singular( 'event' ) ) {
		$new_template = locate_template( 'single-event.php' );
		if ( $new_template ) {
			return $new_template;
		}
	}
	return $template;
});

register_taxonomy('event-category', 'event', [
    'label' => 'Event Categories',
    'public' => true,
    'show_in_rest' => true,
    'hierarchical' => true,
]);

require_once get_template_directory() . '/blocks/hero-cta/render.php';

add_action( 'init', function() {
	register_block_type( __DIR__ . '/blocks/hero-cta' );
});

// Debugging
add_action( 'init', function() {
	$all = WP_Block_Type_Registry::get_instance()->get_all_registered();
	$custom = array_filter( array_keys( $all ), fn( $key ) => ! str_starts_with( $key, 'core/' ) );
	error_log( '✅ Custom blocks: ' . print_r( $custom, true ) );
});

if ( ! is_admin() ) {
    add_action( 'wp_enqueue_scripts', 'enqueue_theme_assets' );
}

function enqueue_theme_assets() {
    wp_enqueue_style(
        'theme-style',
        get_template_directory_uri() . '/dist/css/bundle.css',
        [],
        filemtime( get_template_directory() . '/dist/css/bundle.css' )
    );

    wp_enqueue_script(
        'theme-script',
        get_template_directory_uri() . '/dist/js/bundle.js',
        [],
        filemtime( get_template_directory() . '/dist/js/bundle.js' ),
        true
    );
}
