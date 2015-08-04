<?php
/**
 * Theme Customizer
 *
 * @package Chuchadon
 */

/**
 * Add the Customizer functionality.
 *
 * @since 1.0.0
 */
function chuchadon_customize_register( $wp_customize ) {

	/* === Theme panel === */

	/* Add the theme panel. */
	$wp_customize->add_panel(
		'theme',
		array(
			'title'      => esc_html__( 'Theme Settings', 'chuchadon' ),
			'priority'   => 10
		)
	);
	
	/* == Layout section == */
	
	/* Add the layout section. */
	$wp_customize->add_section(
		'chuchadon-layout',
		array(
			'title'    => esc_html__( 'Layouts', 'chuchadon' ),
			'priority' => 10,
			'panel'    => 'theme'
		)
	);

	/* Add the layout setting. */
	$wp_customize->add_setting(
		'theme_layout',
		array(
			'default'           => '1c',
			'sanitize_callback' => 'chuchadon_sanitize_layout'
		)
	);
	
	$layout_choices = array( 
		'1c'   => __( '1 Column', 'chuchadon' ),
		'2c-l' => __( '2 Columns: Content / Sidebar', 'chuchadon' ),
		'2c-r' => __( '2 Columns: Sidebar / Content', 'chuchadon' )
	);
	
	/* Add the layout control. */
	$wp_customize->add_control(
		'theme_layout',
		array(
			'label'    => esc_html__( 'Global Layout', 'chuchadon' ),
			'section'  => 'chuchadon-layout',
			'priority' => 10,
			'type'     => 'radio',
			'choices'  => $layout_choices
		)
	);
	
	/* == Front page section == */
	
	/* Add the front-page section. */
	$wp_customize->add_section(
		'front-page',
		array(
			'title'       => esc_html__( 'Front Page Settings', 'chuchadon' ),
			'description' => esc_html__( 'The first Callout is for top callout section and the second one is for bottom Callout section.', 'chuchadon' ),
			'priority'    => 20,
			'panel'       => 'theme'
		)
	);
	
	/* == Callout == */
	
	/* Add the callout title setting twice, top and bottom. */
	
	$k = 0;
	
	while ( $k < 2 ) {
		
		/* Text for placement in settings. */
		if ( 0 == $k ) {
			$placement = 'top';
		} else {
			$placement = 'bottom';
		}
		
		/* Text for placement in the Customizer. */
		if ( 0 == $k ) {
			$placement_text = _x( 'Top', 'position of callout text', 'chuchadon' );
		} else {
			$placement_text = _x( 'Bottom', 'position of callout text', 'chuchadon' );
		}
	
		$wp_customize->add_setting(
			'callout_title_' . $placement,
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field'
			)
		);
	
		/* Add the callout title control. */
		$wp_customize->add_control(
			'callout_title_' . $placement,
			array(
				'label'    => sprintf( esc_html__( '%s Callout title', 'chuchadon' ), $placement_text ),
				'section'  => 'front-page',
				'priority' => 20 + $k*100,
				'type'     => 'text'
			)
		);
	
		/* Add the callout text setting. */
		$wp_customize->add_setting(
			'callout_text_' . $placement,
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_textarea'
			)
		);
	
		/* Add the callout text control. */
		$wp_customize->add_control(
			'callout_text_' . $placement,
			array(
				'label'    => sprintf( esc_html__( '%s Callout text', 'chuchadon' ), $placement_text ),
				'section'  => 'front-page',
				'priority' => 30 + $k*100,
				'type'     => 'textarea'
			)
		);
	
		/* Add the callout link setting. */
		$wp_customize->add_setting(
			'callout_url_' . $placement,
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw'
			)
		);
 	
		/* Add the callout link control. */
		$wp_customize->add_control(
			'callout_url_' . $placement,
			array(
				'label'    => sprintf( esc_html__( '%s Callout URL', 'chuchadon' ), $placement_text ),
				'section'  => 'front-page',
				'priority' => 50 + $k*100,
				'type'     => 'url'
			)
		);
 	
		/* Add the callout url text setting. */
		$wp_customize->add_setting(
			'callout_url_text_' . $placement,
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field'
			)
		);
 	
		/* Add the callout url text control. */
		$wp_customize->add_control(
			'callout_url_text_' . $placement,
			array(
				'label'    => sprintf( esc_html__( '%s Callout URL text', 'chuchadon' ), $placement_text ),
				'section'  => 'front-page',
				'priority' => 60 + $k*100,
				'type'     => 'text'
			)
		);
	
		$k++; // Add +1 before loop ends.
	
	} // End while loop.
	
	/* Add order featured setting. */
	$wp_customize->add_setting(
		'order_featured',
		array(
			'default'           => '',
			'sanitize_callback' => 'chuchadon_sanitize_checkbox'
		)
	);
	
	/* Add order featured control. */
	$wp_customize->add_control(
		'order_featured',
		array(
			'label'       => esc_html__( 'Featured area after Sidebar', 'chuchadon' ),
			'description' => esc_html__( 'Check this if you want to move Featured area after Front Page Sidebar in the Front Page Template.', 'chuchadon' ),
			'section'     => 'front-page',
			'priority'    => 75,
			'type'        => 'checkbox'
		)
	);
	
	/* Add the featured setting where we can select do we use child pages, blog posts or portfolios in front page template. */
	$wp_customize->add_setting(
		'front_page_featured',
		array(
			'default'           => 'blog-posts',
			'sanitize_callback' => 'chuchadon_sanitize_featured'
		)
	);
	
	$front_page_featured_choices = array(
		'blog-posts'  => esc_html__( 'Blog Posts', 'chuchadon' ),
		'child-pages' => esc_html__( 'Child Pages', 'chuchadon' ),
		'nothing'     => esc_html__( 'Nothing', 'chuchadon' )
	);
	
	/* Add the featured control. */
	$wp_customize->add_control(
		'front_page_featured',
		array(
			'label'       => esc_html__( 'Featured Content', 'chuchadon' ),
			'description' => esc_html__( 'Select do you want to feature Blog Posts, Child Pages or nothing in Front Page.', 'chuchadon' ),
			'section'     => 'front-page',
			'priority'    => 80,
			'type'        => 'radio',
			'choices'     => $front_page_featured_choices
		)
	);
	
	/* Add the setting for Callout image. */
	$wp_customize->add_setting(
		'callout_image',
		array(
			'default' => '',
			'sanitize_callback' => 'esc_url_raw'
		) );
	
	/* Add the Callout image link control. */
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
		$wp_customize,
			'callout_image',
				array(
					'label'       => esc_html__( 'Callout Image', 'chuchadon' ),
					'description' => esc_html__( 'Add Callout Image which can be map or product image for example. Recommended width is 1920px.', 'chuchadon' ),
					'section'     => 'front-page',
					'priority'    => 170,
				)
		)
	);
	
	/* Add the callout image alt setting. */
	$wp_customize->add_setting(
		'callout_image_alt',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	
	/* Add the callout image alt control. */
	$wp_customize->add_control(
		'callout_image_alt',
		array(
			'label'    => esc_html__( 'Callout image alt text', 'chuchadon' ),
			'section'  => 'front-page',
			'priority' => 180,
			'type'     => 'text'
		)
	);
	
	/* Add the Callout image link setting. */
	$wp_customize->add_setting(
		'callout_image_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw'
		)
	);
 	
	/* Add the Callout image link control. */
	$wp_customize->add_control(
		'callout_image_url',
		array(
			'label'    => esc_html__( 'Callout image URL', 'chuchadon' ),
			'section'  => 'front-page',
			'priority' => 190,
			'type'     => 'url'
		)
	);
	
	/* == Background section == */
	
	/* Add the background section. */
	$wp_customize->add_section(
		'background',
		array(
			'title'    => esc_html__( 'Background Settings', 'chuchadon' ),
			'priority' => 30,
			'panel'    => 'theme'
		)
	);

	/* Add custom header background color setting. */
	$wp_customize->add_setting(
		'header_background_color',
		array(
			'default'           => apply_filters( 'chuchadon_default_bg_color', '#cc0000' ),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	/* Add custom header background color control. */
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,
		'header_background_color',
		array(
			'label'       => esc_html__( 'Header Background Color', 'chuchadon' ),
			'section'     => 'background',
			'priority'    => 40,
		)
	) );
	
	/* Add custom header background color opacity setting. */
	$wp_customize->add_setting(
		'header_background_color_opacity',
		array(
			'default'           => absint( apply_filters( 'chuchadon_default_bg_opacity', 75 ) ),
			'sanitize_callback' => 'absint',
		)
	);
	
	/* Add custom header background color opacity control. */
	$wp_customize->add_control(
		'header_background_color_opacity',
			array(
				'type'        => 'range',
				'priority'    => 50,
				'section'     => 'background',
				'label'       => esc_html__( 'Header Color Opacity.', 'chuchadon' ),
				'description' => esc_html__( 'Set Header Color opacity.', 'chuchadon' ),
				'input_attrs' =>
					array(
						'min'   => 0,
						'max'   => 100,
						'step'  => 1
					),
			)
		);
		
	/* Add the setting for Callout background image. */
		
	$wp_customize->add_setting(
		'callout_bg',
		array(
			'default' => '',
			'sanitize_callback' => 'esc_url_raw'
		) );
	
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
		$wp_customize,
			'callout_bg',
				array(
					'label'    => esc_html__( 'Callout background', 'chuchadon' ),
					'section'  => 'background',
					'priority' => 60,
			)
		)
	);
		
	/* Add Callout background color setting. */
	$wp_customize->add_setting(
		'callout_bg_color',
		array(
			'default'           => apply_filters( 'chuchadon_default_callout_bg_color', '#000000' ),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	/* Add Callout background color control. */
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,
		'callout_bg_color',
		array(
			'label'       => esc_html__( 'Callout Background Color', 'chuchadon' ),
			'section'     => 'background',
			'priority'    => 70,
		)
	) );
	
	/* Add Callout background color opacity setting. */
	$wp_customize->add_setting(
		'callout_bg_color_opacity',
		array(
			'default'           => absint( apply_filters( 'chuchadon_default_callout_bg_opacity', 75 ) ),
			'sanitize_callback' => 'absint',
		)
	);
	
	/* Add Callout color opacity control. */
	$wp_customize->add_control(
		'callout_bg_color_opacity',
			array(
				'type'        => 'range',
				'priority'    => 80,
				'section'     => 'background',
				'label'       => esc_html__( 'Callout Background Color Opacity.', 'chuchadon' ),
				'description' => esc_html__( 'Set Callout Background Color Opacity.', 'chuchadon' ),
				'input_attrs' =>
					array(
						'min'   => 0,
						'max'   => 100,
						'step'  => 1
					),
			)
		);
		
	/* Add the setting for subsidiary sidebar background image. */
	if ( is_active_sidebar( 'subsidiary' ) ) {
		
		$wp_customize->add_setting(
			'subsidiary_sidebar_bg',
			array(
				'default' => '',
				'sanitize_callback' => 'esc_url_raw'
			) );
	
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
			$wp_customize,
				'subsidiary_sidebar_bg',
					array(
						'label'    => esc_html__( 'Subsidiary sidebar background', 'chuchadon' ),
						'section'  => 'background',
						'priority' => 90,
				)
			)
		);
		
		/* Add subsidiary sidebar background color setting. */
		$wp_customize->add_setting(
			'subsidiary_sidebar_bg_color',
			array(
				'default'           => apply_filters( 'chuchadon_default_sidebar_bg_color', '#ffffff' ),
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		/* Add subsidiary sidebar background color control. */
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,
			'subsidiary_sidebar_bg_color',
			array(
				'label'       => esc_html__( 'Subsidiary Sidebar Background Color', 'chuchadon' ),
				'section'     => 'background',
				'priority'    => 100,
			)
		) );
	
		/* Add subsidiary sidebar background color opacity setting. */
		$wp_customize->add_setting(
			'subsidiary_sidebar_bg_color_opacity',
			array(
				'default'           => absint( apply_filters( 'chuchadon_default_subsidiary_sidebar_bg_opacity', 95 ) ),
				'sanitize_callback' => 'absint',
			)
		);
	
		/* Add subsidiary sidebar background color opacity control. */
		$wp_customize->add_control(
			'subsidiary_sidebar_bg_color_opacity',
				array(
					'type'        => 'range',
					'priority'    => 110,
					'section'     => 'background',
					'label'       => esc_html__( 'Subsidiary Sidebar Background Color Opacity.', 'chuchadon' ),
					'description' => esc_html__( 'Set Subsidiary Sidebar Background Color Opacity.', 'chuchadon' ),
					'input_attrs' =>
						array(
							'min'   => 0,
							'max'   => 100,
							'step'  => 1
						),
				)
			);
	
	}
	
	/* == Portfolio section == */
	
	if( post_type_exists( 'jetpack-portfolio' ) ) {
	
		/* Add the portfolio section. */
		$wp_customize->add_section(
			'portfolio',
			array(
				'title'    => esc_html__( 'Portfolio Settings', 'chuchadon' ),
				'priority' => 40,
				'panel'    => 'theme'
			)
		);
	
		/* Add the portfolio title setting. */
		$wp_customize->add_setting(
			'portfolio_title',
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field'
			)
		);
	
		/* Add the portfolio title control. */
		$wp_customize->add_control(
			'portfolio_title',
			array(
				'label'    => esc_html__( 'Portfolio Page Title', 'chuchadon' ),
				'section'  => 'portfolio',
				'priority' => 10,
				'type'     => 'text'
			)
		);
	
		/* Add the portfolio description setting. */
		$wp_customize->add_setting(
			'portfolio_description',
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_textarea'
			)
		);
	
		/* Add the portfolio description control. */
		$wp_customize->add_control(
			'portfolio_description',
			array(
				'label'    => esc_html__( 'Portfolio Page Description', 'chuchadon' ),
				'section'  => 'portfolio',
				'priority' => 20,
				'type'     => 'textarea'
			)
		);
	
	}
	
	/* == Footer section == */
	
	/* Add the footer section. */
	$wp_customize->add_section(
		'footer',
		array(
			'title'    => esc_html__( 'Footer Settings', 'chuchadon' ),
			'priority' => 50,
			'panel'    => 'theme'
		)
	);
	
	/* Add hide footer setting. */
	$wp_customize->add_setting(
		'hide_footer',
		array(
			'default'           => '',
			'sanitize_callback' => 'chuchadon_sanitize_checkbox'
		)
	);
	
	/* Add hide footer control. */
	$wp_customize->add_control(
		'hide_footer',
		array(
			'label'       => esc_html__( 'Hide Footer', 'chuchadon' ),
			'description' => esc_html__( 'Check this if you want to hide Footer content.', 'chuchadon' ),
			'section'     => 'footer',
			'priority'    => 10,
			'type'        => 'checkbox'
		)
	);
	
	/* Add the footer text setting. */
	$wp_customize->add_setting(
		'footer_text',
		array(
			'default'           => '',
			'sanitize_callback' => 'chuchadon_sanitize_textarea'
		)
	);
	
	/* Add the footer text control. */
	$wp_customize->add_control(
		'footer_text',
		array(
			'label'       => esc_html__( 'Footer text', 'chuchadon' ),
			'description' => esc_html__( 'Enter Footer text which replaces default text.', 'chuchadon' ),
			'section'     => 'footer',
			'priority'    => 20,
			'type'        => 'textarea'
		)
	);
	
}
add_action( 'customize_register', 'chuchadon_customize_register' );

/**
 * Enqueues front-end CSS for backgrounds.
 *
 * @since 1.0.0
 * @see   wp_add_inline_style()
 */
function chuchadon_color_backgrounds_css() {
	
	/* Get header colors. */
	$header_bg_color = get_theme_mod( 'header_background_color', apply_filters( 'chuchadon_default_bg_color', '#cc0000' ) );
	$header_bg_color_opacity = absint( get_theme_mod( 'header_background_color_opacity', absint( apply_filters( 'chuchadon_default_bg_opacity', 75 ) ) ) );
	$header_bg_color_opacity = $header_bg_color_opacity / 100;
	
	/* Get Callout colors. */
	$callout_bg_color = get_theme_mod( 'callout_bg_color', apply_filters( 'chuchadon_default_callout_bg_color', '#000000' ) );
	$callout_bg_color_opacity = absint( get_theme_mod( 'callout_bg_color_opacity', absint( apply_filters( 'chuchadon_default_callout_bg_opacity', 75 ) ) ) );
	$callout_bg_color_opacity = $callout_bg_color_opacity / 100;
	
	/* Get subsidiary sidebar colors. */
	$subsidiary_sidebar_bg_color = get_theme_mod( 'subsidiary_sidebar_bg_color', apply_filters( 'chuchadon_default_sidebar_bg_color', '#ffffff' ) );
	$subsidiary_sidebar_bg_color_opacity = absint( get_theme_mod( 'subsidiary_sidebar_bg_color_opacity', absint( apply_filters( 'chuchadon_default_subsidiary_sidebar_bg_opacity', 95 ) ) ) );
	$subsidiary_sidebar_bg_color_opacity = $subsidiary_sidebar_bg_color_opacity / 100;

	/* Convert hex color to rgba. */
	$header_bg_color_rgb = chuchadon_hex2rgb( $header_bg_color );
	$callout_bg_color_rgb = chuchadon_hex2rgb( $callout_bg_color );
	$subsidiary_sidebar_bg_color_rgb = chuchadon_hex2rgb( $subsidiary_sidebar_bg_color );
	
	/* Callout image. */
	$callout_bg = esc_url( get_theme_mod( 'callout_bg' ) );
	
	/* Subsidiary sidebar image. */
	$subsidiary_sidebar_bg = esc_url( get_theme_mod( 'subsidiary_sidebar_bg' ) );
	
	/* When to show callout image. */
	$min_width_callout = absint( apply_filters( 'chuchadon_callout_bg_show', 800 ) );
	
	/* When to show subsidiary sidebar image. */
	$min_width = absint( apply_filters( 'chuchadon_subsidiary_sidebar_bg_show', 1 ) );
	
	/* Background arguments for Callout. */
	$background_arguments_callout = esc_attr( apply_filters( 'chuchadon_callout_bg_arguments', 'no-repeat right top' ) );
	
	/* Background arguments for subsidiary. */
	$background_arguments = esc_attr( apply_filters( 'chuchadon_subsidiary_sidebar_bg_arguments', 'no-repeat 50% 50%' ) );
	
	/* Header bg styles. */	
	if ( '#cc0000' !== $header_bg_color || 75 !== $header_bg_color_opacity ) {
			
		$bg_color_css = "
			.site-header,
			.custom-header-image .site-header > .wrap::before {
				background-color: rgba( {$header_bg_color_rgb['red'] }, {$header_bg_color_rgb['green']}, {$header_bg_color_rgb['blue']}, {$header_bg_color_opacity});
			}";
				
	}
	
	/* Callout bg styles. */	
	if ( ! empty( $callout_bg ) || !empty( $callout_bg_color ) ) {

		$bg_color_css .= "
		@media screen and (min-width: {$min_width_callout}px) {
				
			.chuchadon-callout-top {
					background: url({$callout_bg}) {$background_arguments_callout}; background-size: 50%;
				}
					
		}
		
		.chuchadon-callout-top,
		.chuchadon-callout-top > .entry-inner::before {
			background-color: rgba( {$callout_bg_color_rgb['red'] }, {$callout_bg_color_rgb['green']}, {$callout_bg_color_rgb['blue']}, {$callout_bg_color_opacity});
		}";	
			
	}
	
	/* Subsidiary bg styles. */	
	if ( is_active_sidebar( 'subsidiary' ) && ! empty( $subsidiary_sidebar_bg ) ) {

		$bg_color_css .= "
		@media screen and (min-width: {$min_width}px) {
				
			.sidebar-subsidiary {
					background: url({$subsidiary_sidebar_bg}) {$background_arguments}; background-size: cover;
				}
					
		}
		
		.sidebar-subsidiary,
		.sidebar-subsidiary > .wrap::before {
			background-color: rgba( {$subsidiary_sidebar_bg_color_rgb['red'] }, {$subsidiary_sidebar_bg_color_rgb['green']}, {$subsidiary_sidebar_bg_color_rgb['blue']}, {$subsidiary_sidebar_bg_color_opacity});
		}";	
			
	}
		
	wp_add_inline_style( 'chuchadon-style', $bg_color_css );
}
add_action( 'wp_enqueue_scripts', 'chuchadon_color_backgrounds_css' );

/**
 * Sanitize the Global layout value.
 *
 * @since 1.0.0
 *
 * @param string $layout Layout type.
 * @return string Filtered layout type (1c|2c-l|2c-r).
 */
function chuchadon_sanitize_layout( $layout ) {

	if ( ! in_array( $layout, array( '1c', '2c-l', '2c-r' ) ) ) {
		$layout = '2c-l';
	}

	return $layout;
	
}

/**
 * Sanitize the Featured Content value.
 *
 * @since 1.0.0
 *
 * @param  string $featured content type.
 * @return string Filtered featured content type (child-pages|blog-posts|nothing).
 */
function chuchadon_sanitize_featured( $featured ) {

	if ( ! in_array( $featured, array( 'blog-posts', 'child-pages', 'nothing' ) ) ) {
		$featured = 'blog-posts';
	}

	return $featured;
	
}

/**
 * Sanitize the checkbox value.
 *
 * @since 1.0.0
 *
 * @param  string $input checkbox.
 * @return string (1 or null).
 */
function chuchadon_sanitize_checkbox( $input ) {

	if ( 1 == $input ) {
		return 1;
	} else {
		return '';
	}

}

/**
 * Sanitizes the footer content on the customize screen. Users with the 'unfiltered_html' cap can post 
 * anything. For other users, wp_filter_post_kses() is ran over the setting.
 *
 * @since 1.0.0
 */
function chuchadon_sanitize_textarea( $setting, $object ) {
	
	/* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
	if ( 'footer_text' == $object->id && !current_user_can( 'unfiltered_html' ) ) {
		$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
	}
	/* Return the sanitized setting. */
	return $setting;
	
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function chuchadon_customize_register_pm( $wp_customize ) {
	
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	
}
add_action( 'customize_register', 'chuchadon_customize_register_pm' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function chuchadon_customize_preview_js() {
	wp_enqueue_script( 'chuchadon-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), CHUCHADON_VERSION, true );
}
add_action( 'customize_preview_init', 'chuchadon_customize_preview_js' );

/**
* Callout text and link in front page template.
*
* @since  1.0.0
*/
function chuchadon_callout_output( $placement ) {
	
	/* Set default placement of the callout. */
	if( empty( $placement ) ) {
		$placement = 'top';
	}
	
	/* Start output. */
	$output = '';

	/* Output callout link and text on page templates. */
	if ( get_theme_mod( 'callout_title_' . $placement ) || get_theme_mod( 'callout_url_' . $placement ) || get_theme_mod( 'callout_url_text_' . $placement ) || get_theme_mod( 'callout_text_' . $placement ) ) {
		
		/* Start output. */
		$output .= '<div class="chuchadon-callout chuchadon-callout-' . $placement . ' clear"><div class="entry-inner">';
		
		/* Callout title. */
		if( get_theme_mod( 'callout_title_' . $placement ) ) {
			$output .= '<div class="entry-header"><h2 class="chuchadon-callout-title entry-title">' . esc_attr( get_theme_mod( 'callout_title_' . $placement ) ) . '</h2></div>';
		}
		
		/* Callout text. */
		if( get_theme_mod( 'callout_text_' . $placement ) ) {
			$output .= '<div class="chuchadon-callout-text">' . apply_filters( 'chuchadon_the_content', esc_html( get_theme_mod( 'callout_text_' . $placement ) ) ) . '</div>';
		}
		
		/* Callout link. */
		if( get_theme_mod( 'callout_url_' . $placement ) && get_theme_mod( 'callout_url_text_' . $placement ) ) {
			$output .= '<div class="chuchadon-callout-link"><a class="chuchadon-button chuchadon-callout-link-anchor" href="' . esc_url( get_theme_mod( 'callout_url_' . $placement ) ) . '">' . esc_html( get_theme_mod( 'callout_url_text_' . $placement ) ) . '</a></div>';
		}
		
		/* End output. */
		$output .= '</div></div>';
		
	}
	
	return $output;
	
}

/**
* Echo Callout in front page template.
*
* @since  1.0.0
*/
function chuchadon_echo_callout( $placement ) {
	
	/* Set default placement of the callout. */
	if( empty( $placement ) ) {
		$placement = 'top';
	}

	$echo_output = chuchadon_callout_output( $placement );

	if( !empty( $echo_output ) ) {
		echo $echo_output;
	}

}
