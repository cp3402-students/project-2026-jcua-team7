<?php
/**
 * Tennis Blast Theme Customizer
 *
 * @package _s
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function tennisblast_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	// Tennis Blast Settings section.
	$wp_customize->add_section(
		'tennisblast_settings',
		array(
			'title'    => esc_html__( 'Tennis Blast Settings', 'tennisblast' ),
			'priority' => 30,
		)
	);

	// Court booking URL.
	$wp_customize->add_setting(
		'tennisblast_booking_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'tennisblast_booking_url',
		array(
			'label'       => esc_html__( 'Court Booking URL', 'tennisblast' ),
			'description' => esc_html__( 'URL for the "Book a Court" button in the header. Leave blank to hide the button.', 'tennisblast' ),
			'section'     => 'tennisblast_settings',
			'type'        => 'url',
		)
	);

	// Phone number.
	$wp_customize->add_setting(
		'tennisblast_phone',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'tennisblast_phone',
		array(
			'label'   => esc_html__( 'Phone Number', 'tennisblast' ),
			'section' => 'tennisblast_settings',
			'type'    => 'text',
		)
	);

	// Email address.
	$wp_customize->add_setting(
		'tennisblast_email',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_email',
		)
	);
	$wp_customize->add_control(
		'tennisblast_email',
		array(
			'label'   => esc_html__( 'Email Address', 'tennisblast' ),
			'section' => 'tennisblast_settings',
			'type'    => 'email',
		)
	);

	// Facebook URL.
	$wp_customize->add_setting(
		'tennisblast_facebook_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'tennisblast_facebook_url',
		array(
			'label'       => esc_html__( 'Facebook URL', 'tennisblast' ),
			'description' => esc_html__( 'Leave blank to hide the Facebook link.', 'tennisblast' ),
			'section'     => 'tennisblast_settings',
			'type'        => 'url',
		)
	);

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'tennisblast_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'tennisblast_customize_partial_blogdescription',
			)
		);
	}
}
add_action( 'customize_register', 'tennisblast_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function tennisblast_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function tennisblast_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function tennisblast_customize_preview_js() {
	wp_enqueue_script( 'tennisblast-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), _S_VERSION, true );
}
add_action( 'customize_preview_init', 'tennisblast_customize_preview_js' );
