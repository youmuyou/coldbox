<?php
/**
 * Coldbox functions and definitions
 *
 * @since 1.0.0
 * @package Coldbox
 */

if ( ! function_exists( 'cd_scripts' ) ) {

	/**
	 * Enqueue theme styles and scripts
	 *
	 * @since 1.0.0
	 **/
	function cd_scripts() {

		$css_min = cd_use_minified_css();
		$js_min  = cd_use_minified_js();

		wp_enqueue_style( 'FontAwesome', get_theme_file_uri( 'fonts/fontawesome/css/font-awesome.min.css' ) );
		wp_enqueue_style( 'GoogleFonts', '//fonts.googleapis.com/css?family=Lato:300,400,700' );
		wp_enqueue_script( 'comment-reply' );

		wp_enqueue_style( 'cd-style', get_theme_file_uri( 'assets/css/cd-style' . $css_min . '.css' ), array(), CD_VER );
		wp_enqueue_script( 'cd-script', get_theme_file_uri( 'assets/js/cd-scripts' . $js_min . '.js' ), array( 'jquery' ), CD_VER, true );
		wp_add_inline_script( 'cd-script', "jQuery(function($){ $('.entry img').parent('a').css({'box-shadow':'none'});});" );

		// Load Masonry for making responsive sidebar.
		wp_enqueue_script( 'imagesloaded', 'imagesloaded', array( 'jQuery' ), '', true );
		wp_enqueue_script( 'masonry', 'masonry', array( 'imagesloaded' ), '', true );
		$masonry_resp_sidebar = 'jQuery(window).on("load resize",function(){window.matchMedia("(max-width: 980px) and (min-width: 641px)").matches||jQuery("body").hasClass("bottom-sidebar-s1")?jQuery("#sidebar-s1 .sidebar-inner").imagesLoaded(function(){jQuery("#sidebar-s1 .sidebar-inner").masonry({itemSelector:".widget",percentPosition:!0,isAnimated:!0}),jQuery(".widget").css({position:"absolute"})}):jQuery(".widget").css({position:"",top:"",left:""})});';
		wp_add_inline_script( 'masonry', $masonry_resp_sidebar, 'after' );
	}
} // End if().
add_action( 'wp_enqueue_scripts', 'cd_scripts' );

if ( ! function_exists( 'cd_load_hljs' ) ) {

	/**
	 * Load the highlight.js
	 *
	 * @since 1.0.0
	 */
	function cd_load_hljs() {

		if ( cd_use_normal_hljs() || cd_use_web_hljs() ) {

			if ( cd_use_normal_hljs() && ! cd_use_web_hljs() ) {
				if ( cd_use_minified_js() ) {
					wp_enqueue_script( 'scripts-hljs', get_theme_file_uri( 'assets/js/cd-scripts+hljs.min.js' ), array( 'jquery' ), '9.12.0', true );
					wp_dequeue_script( 'cd-script' );
				} else {
					wp_enqueue_script( 'hljs', get_theme_file_uri( 'assets/js/highlight.js' ), array(), '9.12.0' );
				}
			} elseif ( cd_use_web_hljs() && ! cd_use_normal_hljs() ) {
				if ( cd_use_minified_js() ) {
					wp_enqueue_script( 'scripts-hljs-web', get_theme_file_uri( 'assets/js/cd-scripts+hljs_web.min.js' ), array( 'jquery' ), '9.12.0', true );
					wp_dequeue_script( 'cd-script' );
				} else {
					wp_enqueue_script( 'hljs', get_theme_file_uri( 'assets/js/highlight-web.js' ), array(), '9.12.0' );
				}
			} elseif ( cd_use_web_hljs() && cd_use_normal_hljs() ) {
				if ( cd_use_minified_js() ) {
					wp_enqueue_script( 'scripts-hljs-web', get_theme_file_uri( 'assets/js/cd-scripts+hljs_web.min.js' ), array( 'jquery' ), '9.12.0', true );
					wp_dequeue_script( 'cd-script' );
				} else {
					wp_enqueue_script( 'hljs', get_theme_file_uri( 'assets/js/highlight-web.js' ), array(), '9.12.0' );
				}
			}

			// Use hljs with only pre tag.
			wp_add_inline_script( 'hljs', 'jQuery(document).ready(function(a){a("pre").each(function(b,c){hljs.highlightBlock(c)})});' );
			wp_add_inline_script( 'scripts-hljs', 'jQuery(document).ready(function(a){a("pre").each(function(b,c){hljs.highlightBlock(c)})});' );
			wp_add_inline_script( 'scripts-hljs-web', 'jQuery(document).ready(function(a){a("pre").each(function(b,c){hljs.highlightBlock(c)})});' );
			// Load scripts to stop lending shadows on link tags.
			wp_add_inline_script( 'scripts-hljs', "jQuery(function($) { $('.entry img').parent('a').css({'box-shadow':'none'}); });" );
			wp_add_inline_script( 'scripts-hljs-web', "jQuery(function($) { $('.entry img').parent('a').css({'box-shadow':'none'}); });" );
		}
	}
} // End if().
add_action( 'wp_enqueue_scripts', 'cd_load_hljs' );


if ( ! function_exists( 'cd_loads' ) ) {

	/**
	 * Load the language domain and editor style
	 *
	 * @since 1.0.0
	 **/
	function cd_loads() {
		load_theme_textdomain( 'coldbox', get_theme_file_path( 'languages' ) );
		add_editor_style( 'parts/editor-style.min.css' );
	}
}
add_action( 'after_setup_theme', 'cd_loads' );


if ( ! function_exists( 'cd_czr' ) ) {

	/**
	 * Load the theme customizer
	 *
	 * @since 1.0.0
	 **/
	function cd_czr() {
		require_once get_theme_file_path( 'czr/customizer.php' );
	}
}
add_action( 'after_setup_theme', 'cd_czr' );


if ( ! function_exists( 'cd_supports' ) ) {

	/**
	 * Load the supported functions provided by WordPress
	 *
	 * @since 1.0.0
	 **/
	function cd_supports() {

		// Title tag.
		add_theme_support( 'title-tag' );

		// Support thumbnail.
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 500, 250, true );
		add_image_size( 'cd-small', 150, 150, true );
		add_image_size( 'cd-medium', 500, 250, true );
		add_image_size( 'cd-standard', 500, 500, true );

		// Support RSS link.
		add_theme_support( 'automatic-feed-links' );

		// Support direct widgets editing shortcut on customizer.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Support all post format.
		add_theme_support( 'post-formats', array( 'audio', 'aside', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );

		// Support HTML5.
		add_theme_support( 'html5', array( 'comment-form', 'comment-list', 'gallery', 'caption' ) );

		// Support custom header.
		add_theme_support(
			'custom-header', array(
				'width'       => 980,
				'height'      => 100,
				'flex-height' => true,
				'flex-width'  => true,
			)
		);

		// Support custom logo.
		add_theme_support(
			'custom-logo', array(
				'height'      => 80,
				'width'       => 270,
				'flex-height' => true,
			)
		);

		// Support custom background color and image.
		$custom_background_defaults = array(
			'default-color' => '#f8f8f8',
			'default-image' => '',
		);
		add_theme_support( 'custom-background', $custom_background_defaults );

		// Register nav menu.
		register_nav_menus(
			array(
				'header-menu' => __( 'Header Menu', 'coldbox' ),
				'footer-menu' => __( 'Footer Menu', 'coldbox' ),
			)
		);
	}
} // End if().
add_action( 'after_setup_theme', 'cd_supports' );

if ( ! function_exists( 'cd_pingback_header' ) ) {

	/**
	 * Adds a pingback url when necessary.
	 *
	 * @since 1.2.0
	 */
	function cd_pingback_header() {

		if ( is_singular() && pings_open() ) {
			printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
		}

	}
	add_action( 'wp_head', 'cd_pingback_header' );
}

// Set the content width.
if ( ! isset( $content_width ) ) {
	$content_width = 680;
}

/*
 * ----------------------------------------------------------------------
 * Theme Functions
 * ----------------------------------------------------------------------
 */

if ( ! function_exists( 'cd_header_menu' ) ) {

	/**
	 * Call the header menu through a filter
	 *
	 * @since 1.1.6
	 */
	function cd_header_menu() {

		if ( has_nav_menu( 'header-menu' ) ) {

			$menu      = '<nav id="header-menu">';
				$menu .= wp_nav_menu(
					array(
						'theme_location' => 'header-menu',
						'container'      => '',
						'menu_class'     => '',
						'fallback_cb'    => 'wp_page_menu',
						'echo'           => false,
						'items_wrap'     => '<ul id="header-nav" class="menu-container">%3$s</ul><!--/#header-nav-->',
					)
				);
			$menu     .= '</nav>';
			echo wp_kses_post( apply_filters( 'cd_header_menu', $menu ) );
		}
	}
}

if ( ! function_exists( 'cd_footer_menu' ) ) {

		/**
		 * Call the footer menu through a filter
		 *
		 * @since 1.3.0
		 */
	function cd_footer_menu() {

		if ( has_nav_menu( 'footer-menu' ) ) {

			$menu      = '<nav id="footer-menu" class="footer-menu"><div class="container">';
				$menu .= wp_nav_menu(
					array(
						'theme_location' => 'footer-menu',
						'container'      => '',
						'menu_class'     => '',
						'fallback_cb'    => 'wp_page_menu',
						'echo'           => false,
						'items_wrap'     => '<ul id="footer-nav" class="menu-container">%3$s</ul><!--/#footer-nav-->',
					)
				);
			$menu     .= '</div></nav>';
			echo wp_kses_post( apply_filters( 'cd_footer_menu', $menu ) );
		}
	}
}

if ( ! function_exists( 'cd_standard_thumbnail' ) ) {

	/**
	 * Echo the middle size thumbnail.
	 *
	 * @since 1.1.6
	 */
	function cd_standard_thumbnail() {

		if ( has_post_thumbnail() ) {
			$thumbnail = get_the_post_thumbnail( get_the_ID(), 'cd-standard' );
		} else {
			$thumbnail = '<img src="' . esc_url( get_theme_file_uri( 'img/thumb-standard.png' ) ) . '" alt="noimage" height="250" width="500">';
		}
		echo wp_kses_post( apply_filters( 'cd_standard_thumbnail', $thumbnail ) );
	}
}

if ( ! function_exists( 'cd_middle_thumbnail' ) ) {

	/**
	 * Echo the standard size thumbnail.
	 *
	 * @since 1.1.6
	 */
	function cd_middle_thumbnail() {

		if ( has_post_thumbnail() ) {
			$thumbnail = get_the_post_thumbnail( get_the_ID(), 'cd-medium' );
		} else {
			$thumbnail = '<img src="' . esc_url( get_theme_file_uri( 'img/thumb-medium.png' ) ) . '" alt="noimage" height="250" width="500">';
		}
		$allowed_html = array(
			'amp-img'         => array(
				'src'    => array(),
				'layout' => array(),
				'alt'    => array(),
				'height' => array(),
				'width'  => array(),
				'class'  => array(),
			),
			'i-amphtml-sizer' => array(
				'style' => array(),
				'class' => array(),
			),
			'img'             => array(
				'alt'    => array(),
				'class'  => array(),
				'src'    => array(),
				'height' => array(),
				'width'  => array(),
			),
		);
		echo wp_kses( apply_filters( 'cd_middle_thumbnail', $thumbnail ), $allowed_html );
	}
}

if ( ! function_exists( 'cd_middle_thumbnail_template' ) ) {

		/**
		 * Echo the middle size thumbnail for template.
		 *
		 * @since 1.2.3
		 */
	function cd_middle_thumbnail_template() {

		if ( has_post_thumbnail() ) {
			$thumbnail = get_the_post_thumbnail( get_the_ID(), 'cd-medium' );
		} elseif ( cd_index_placefolder_image() ) {
			$thumbnail = '<img src="' . esc_url( get_theme_file_uri( 'img/thumb-medium.png' ) ) . '" alt="noimage" height="250" width="500">';
		} else {
			return;
		}
		echo wp_kses_post( apply_filters( 'cd_middle_thumbnail_template', $thumbnail ) );
	}
}

if ( ! function_exists( 'cd_standard_thumbnail_template' ) ) {

		/**
		 * Echo the standard size thumbnail for template.
		 *
		 * @since 1.2.3
		 */
	function cd_standard_thumbnail_template() {

		if ( has_post_thumbnail() ) {
			$thumbnail = get_the_post_thumbnail( get_the_ID(), 'cd-standard' );
		} elseif ( cd_index_placefolder_image() ) {
			$thumbnail = '<img src="' . esc_url( get_theme_file_uri( 'img/thumb-standard.png' ) ) . '" alt="noimage" height="250" width="500">';
		} else {
			return;
		}
		echo wp_kses_post( apply_filters( 'cd_standard_thumbnail_template', $thumbnail ) );
	}
}

if ( ! function_exists( 'cd_comments_template' ) ) {

	/**
	 * Echo the comments template through action hook.
	 *
	 * @since 1.2.0
	 */
	function cd_comments_template() {
		$template = '';
		ob_start();
		comments_template( '/comments.php', true );
		$template = ob_get_clean();
		// @codingStandardsIgnoreStart
		echo apply_filters( 'cd_comments_template', $template ); // WPCS: XSS OK.
		// @codingStandardsIgnoreEnd
	}
}

if ( ! function_exists( 'cd_get_avatar' ) ) {

	/**
	 * Echo user avatar for the author box.
	 *
	 * @since 1.1.6
	 */
	function cd_get_avatar() {

		$avater       = get_avatar( get_the_author_meta( 'ID' ), 74 );
		$allowed_html = array(
			'amp-img'         => array(
				'src'    => array(),
				'layout' => array(),
				'alt'    => array(),
				'height' => array(),
				'width'  => array(),
				'class'  => array(),
			),
			'i-amphtml-sizer' => array(
				'style' => array(),
				'class' => array(),
			),
			'img'             => array(
				'alt'    => array(),
				'class'  => array(),
				'src'    => array(),
				'height' => array(),
				'width'  => array(),
			),
		);
		echo wp_kses( apply_filters( 'cd_get_avatar', $avater ), $allowed_html );
	}
}

if ( ! function_exists( 'cd_body_class' ) ) {

	/**
	 * Adds classses to the body tag.
	 *
	 * @param string $classes The classes add to the body class.
	 * @return The custom body classes.
	 * @since 1.0.0
	 **/
	function cd_body_class( $classes ) {

		if ( has_nav_menu( 'header-menu' ) ) {
			$classes[] = 'header-menu-enabled';
		}if ( has_nav_menu( 'footer-menu' ) ) {
			$classes[] = 'footer-menu-enabled';
		}
		if ( cd_header_sticky() ) {
			$classes[] = 'sticky-header';
		}
		if ( cd_sidebar_stg() === 'right' ) {
			$classes[] = 'right-sidebar-s1';
		} elseif ( cd_sidebar_stg() === 'left' ) {
			$classes[] = 'left-sidebar-s1';
		} elseif ( cd_sidebar_stg() === 'bottom' ) {
			$classes[] = 'bottom-sidebar-s1';
		} elseif ( cd_sidebar_stg() === 'hide' ) {
			$classes[] = 'hide-sidebar-s1';
		}
		if ( cd_header_direction() === 'column' ) {
			$classes[] = 'header-column';
		} elseif ( cd_header_direction() === 'row' ) {
			$classes[] = 'header-row';
		}
		return $classes;
	}
}
add_filter( 'body_class', 'cd_body_class' );


/*
 * ----------------------------------------------------------------------
 * Widgets
 * ----------------------------------------------------------------------
 */

if ( ! function_exists( 'cd_widgets_init' ) ) {

	/**
	 * Inits widgets area.
	 *
	 * @since 1.0.0
	 **/
	function cd_widgets_init() {
		register_sidebar(
			array(
				'name'          => __( 'Sidebar', 'coldbox' ),
				'id'            => 'sidebar-1',
				'description'   => __( 'Add widgets here', 'coldbox' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			)
		);
	}
}
add_action( 'widgets_init', 'cd_widgets_init' );


if ( ! function_exists( 'cd_cat_widget_count' ) ) {

	/**
	 * Make the counts surround with brackets on category widgets.
	 *
	 * @param string $output Return the count with brackets.
	 * @param string $args The widget arguments.
	 * @return string $output and $args with .count class.
	 * @since 1.0.0
	 */
	function cd_cat_widget_count( $output, $args ) {
		$replaced_text = preg_replace( '/<\/a> \(([0-9,]*)\)/', ' <span class="count">(${1})</span></a>', $output );
		if ( null !== $replaced_text ) {
			return $replaced_text;
		} else {
			return $output;
		}
	}
}
add_filter( 'wp_list_categories', 'cd_cat_widget_count', 10, 2 );


if ( ! function_exists( 'cd_archive_widget_count' ) ) {

	/**
	 * Make the counts surround with brankets on archive widgets.
	 *
	 * @param string $output return the count with brankets.
	 * @since 1.0.0
	 */
	function cd_archive_widget_count( $output ) {
		$output = str_replace( '</a>&nbsp;(', ' <span class="count">(', $output );
		$output = str_replace( ')', ')</span></a>', $output );
		return $output;
	}
}
add_filter( 'get_archives_link', 'cd_archive_widget_count', 10, 2 );


if ( ! function_exists( 'cd_remove_current_post_on_recent_widgets' ) ) {

	/**
	 * Remove the current post when showing a single article from the recent posts widgets.
	 *
	 * @param string $args return widget's argument without current post.
	 * @since 1.0.0
	 * @return array
	 */
	function cd_remove_current_post_on_recent_widgets( $args ) {
		if ( is_single() ) {
			$args['post_not_in'] = array( get_the_ID() );
		}
		return $args;
	}
}
add_filter( 'widget_posts_args', 'cd_remove_current_post_on_recent_widgets', 10, 3 );


/*
 * -------------------------------------------------------------------------
 *  Call the bottom parts for each page
 * -------------------------------------------------------------------------
 */
if ( ! function_exists( 'cd_single_middle_contents' ) ) {

	define( 'CD_H2_REG', '/<H2.*?>/i' );
	define( 'CD_H3_REG', '/<H3.*?>/i' );
	/**
	 * Get h2 tags from the content.
	 *
	 * @since 1.1.6
	 * @param string $the_content The post contents which are find from.
	 * @return string
	 */
	function cd_single_h2_in_content( $the_content ) {
		if ( preg_match( CD_H2_REG, $the_content, $h2_result ) ) { // Whether or not h2 tag is used.
			return $h2_result[0];
		}
	}
	/**
	 * Get h3 tags from the content.
	 *
	 * @since 1.1.6
	 * @param string $the_content The post contents which are find from.
	 * @return string
	 */
	function cd_single_h3_in_content( $the_content ) {
		if ( preg_match( CD_H3_REG, $the_content, $h3_result ) ) { // Whether or not h3 tag is used.
			return $h3_result[0];
		}
	}

	/**
	 * The action hook for adding custom content on the first h2 or h3 tag on each single article through filter.
	 *
	 * @since 1.1.6
	 * @param string $the_content The post contents which are hooked.
	 * @return string
	 */
	function cd_single_middle_contents( $the_content ) {
		if ( is_single() ) {
			$contents = '';
			ob_start();
			apply_filters( 'cd_single_middle_contents', $contents );
			$contents  = ob_get_clean();
			$h2_result = cd_single_h2_in_content( $the_content ); // Get h2 tag if any.
			$h3_result = cd_single_h3_in_content( $the_content ); // Get h3 tag if any.
			if ( ! is_null( $h2_result ) ) { // If h2 tag is present.
				$count       = 1;
				$the_content = preg_replace( CD_H2_REG, $contents . $h2_result, $the_content, 1 );
			} elseif ( ! is_null( $h3_result ) ) { // If no h2 tag, but h3 tag is found.
				$count       = 1;
				$the_content = preg_replace( CD_H3_REG, $contents . $h3_result, $the_content, 1 );
			}
		}
		return $the_content;
	}
	add_filter( 'the_content', 'cd_single_middle_contents' );
}

if ( ! function_exists( 'cd_single_bottom_contents' ) ) {

	/**
	 * Call the the buttom parts of the single articles through filter.
	 *
	 * @since 1.1.0
	 */
	function cd_single_bottom_contents() {
		if ( function_exists( 'cd_addon_sns_buttons' ) && function_exists( 'cd_use_snsb' ) ) {
			if ( cd_use_snsb() ) {
				cd_addon_sns_buttons_list( 'single-buttom' );
			}
		}
		if ( cd_is_post_related() ) {
			get_template_part( 'parts/related-posts' );
		}
		if ( cd_is_post_single_comment() ) {
			cd_comments_template();
		}
		if ( cd_is_post_nav() ) {
			get_template_part( 'parts/post-nav' );
		}
	}
}

if ( ! function_exists( 'cd_single_after_contents' ) ) {

	/**
	 * The action hook for adding some contents after the article contents through filter.
	 *
	 * @since 1.1.6
	 * @param string $contents The contents will be shown after the article contents.
	 * @return string
	 */
	function cd_single_after_contents( $contents = null ) {
		// You can add something here through the `cd_single_after_contents` filter.
		return $contents;
	}
}

if ( ! function_exists( 'cd_attachment_bottom_contents' ) ) {

	/**
	 * Call the the bottom parts of the attachment pages through filter.
	 *
	 * @since 1.1.2
	 */
	function cd_attachment_bottom_contents() {
		if ( cd_is_post_single_comment() ) {
			comments_template( '/comments.php', true );
		}
		if ( cd_is_post_nav() ) {
			get_template_part( 'parts/post-nav' );
		}
	}
}

if ( ! function_exists( 'cd_pages_bottom_contents' ) ) {

	/**
	 * Call the the bottom parts of the static pages through filter.
	 *
	 * @since 1.1.1
	 */
	function cd_pages_bottom_contents() {
		if ( cd_is_post_single_comment() ) {
			comments_template( '/comments.php', true );
		}
	}
}

if ( ! function_exists( 'cd_archive_top_contents' ) ) {
	/**
	 * Call the top parts of the archive pages through filter.
	 *
	 * @since 1.1.6
	 * @param string $contents The contents will be shown on top of the article contents.
	 * @return string
	 */
	function cd_archive_top_contents( $contents = null ) {
		// You can add something here through `cd_archive_top_contents` filter.
		return $contents;
	}
}

if ( ! function_exists( 'cd_archive_bottom_contents' ) ) {

	/**
	 * Call the the bottom parts of the archive pages through filter.
	 *
	 * @since 1.1.1
	 */
	function cd_archive_bottom_contents() {
		get_template_part( 'parts/page-nav' );
	}
}


/*
 * -------------------------------------------------------------------------
 *  Breadcrumbs
 * -------------------------------------------------------------------------
 */
if ( ! function_exists( 'cd_breadcrumb' ) ) {

	/**
	 * Returns suitable breadcrumb
	 *
	 * @since 1.0.0
	 **/
	function cd_breadcrumb() {
		echo '<a href="' . esc_url( home_url() ) . '">' . esc_html_e( 'Home', 'coldbox' ) . '</a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;';
		if ( is_attachment() ) {
			esc_html_e( 'Attachment', 'coldbox' );
		} elseif ( is_single() ) {
			the_category( ' &#47; ' );
		} elseif ( is_category() ) {
			global $wp_query;
			$current_cat = $wp_query->get_queried_object();
			$cat         = $wp_query->get_queried_object();

			if ( $cat->parent ) { // If the category has parent category.
				$parent = array();
				while ( $cat->parent ) {
					$cat      = get_category( $cat->parent );
					$cat_name = $cat->name;
					$cat_url  = get_category_link( $cat->cat_ID );
					$parent   = array_merge(
						$parent, array(
							$cat_name => $cat_url,
						)
					);
				}
				$parent_rev = array_reverse( $parent );
				foreach ( $parent_rev as $key => $value ) {
					echo '<a href="' . esc_url( $value ) . '">' . esc_html( $key ) . '</a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;';
				}
				echo '<span>' . esc_html( $current_cat->name ) . '</span>';
			} else {
				echo esc_html( $cat->name );
			}
		} elseif ( is_author() ) {
			the_author();
		} elseif ( is_page() ) {
			the_title();
		}
	}
} // End if().

/*
 * -------------------------------------------------------------------------
 *  Apparence
 * -------------------------------------------------------------------------
 */

/*
 * the_excerpt
 * --------------------------------------------------
 */
if ( ! function_exists( 'cd_excerpt_length' ) ) {
	/**
	 * The length of the excerpt which set on the customizer.
	 *
	 * @since 1.0.0
	 * @param int $length The length.
	 * @return int
	 */
	function cd_excerpt_length( $length ) {
		if ( is_admin() ) {
			return $length;
		}

		return cd_czr_excerpt_length( $length );
	}
}
add_filter( 'excerpt_length', 'cd_excerpt_length', 999 );

if ( ! function_exists( 'cd_excerpt_more' ) ) {

	/**
	 * The ending of the excerpt which set on the customizer.
	 *
	 * @since 1.0.0
	 * @param string $more The ending strings.
	 * @return string
	 */
	function cd_excerpt_more( $more ) {
		if ( is_admin() ) {
			return $more;
		}

		return cd_czr_excerpt_ending( $more );
	}
}
add_filter( 'excerpt_more', 'cd_excerpt_more' );


/*
 * Site Title
 * --------------------------------------------------
 */
if ( ! function_exists( 'cd_site_title' ) ) {

	/**
	 * Return the site name or logo if set.
	 *
	 * @since 1.0.0
	 **/
	function cd_site_title() {

		if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {

			echo '<a href="' . esc_url( home_url() ) . '" title="' , bloginfo( 'name' ) , '">';

			echo '<div class="site-logo">';

			$image = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );
			echo '<img src="' . esc_url( $image[0] ) . '" alt="' , bloginfo( 'name' ) , '" />';

			echo '</div>';

			echo '</a>';

		}

		if ( cd_is_site_title() && display_header_text() ) {

			echo '<a href="' . esc_url( home_url() ) . '" title="' , bloginfo( 'name' ) , '">';

			echo '<h1 class="site-title">';

			echo esc_html( get_bloginfo( 'name' ) );

			echo '</h1>';

			echo '</a>';
		}
	}
}

if ( ! function_exists( 'cd_header_image' ) ) {
	if ( has_header_image() ) {

		/**
		 * Appear the header background image as CSS background image.
		 *
		 * @since 1.0.0
		 */
		function cd_header_image() {
			$style = "#header { background-image: url('" . get_header_image() . "'); }";
			echo '<style>' . wp_kses_data( $style ) . '</style>';
		}
		add_action( 'wp_head', 'cd_header_image' );
	}
}


if ( ! function_exists( 'cd_prev_post_thumbnail' ) ) {
	/**
	 * Echo next / previous post thumbnail URL
	 *
	 * @since 1.1.6
	 */
	function cd_prev_post_thumbnail() {

		$prev_post = get_previous_post();
		$next_post = get_next_post();

		if ( ! empty( $prev_post ) && is_single() && cd_is_post_nav() ) {
			$prevthumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( get_previous_post()->ID ), array( 600, 600 ), false, '' );

			if ( $prevthumbnail ) {
				wp_add_inline_style( 'cd-style', '.prev .post-thumbnail{background-image:url("' . $prevthumbnail[0] . '")}' );
			}
		}
		if ( ! empty( $next_post ) && is_single() && cd_is_post_nav() ) {
			$nextthumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( get_next_post()->ID ), array( 600, 600 ), false, '' );

			if ( $nextthumbnail ) {
				wp_add_inline_style( 'cd-style', '.next .post-thumbnail{background-image:url("' . $nextthumbnail[0] . '")}' );
			}
		}

	}
}
add_action( 'wp_enqueue_scripts', 'cd_prev_post_thumbnail' );

if ( ! function_exists( 'cd_modify_archive_title' ) ) {
	/**
	 * Modify `the_archive_title()` function to output.
	 *
	 * @param string $title The archive title name.
	 * @return string
	 **/
	function cd_modify_archive_title( $title ) {
		if ( is_category() ) {
			$title = '<h1><span class="title-description">' . esc_html__( 'Category:', 'coldbox' ) . '&#32;</span>' . single_cat_title( '', false ) . '</h1>';
		} elseif ( is_tag() ) {
			$title = '<h1><span class="title-description">' . esc_html__( 'Tag:', 'coldbox' ) . '&#32;</span>' . single_tag_title( '', false ) . '</h1>';
		} elseif ( is_day() ) {
			$title = '<h1><span class="title-description">' . esc_html__( 'Daily Archive:', 'coldbox' ) . '&#32;</span>' . get_the_date( get_option( 'date_format' ) ) . '</h1>';
		} elseif ( is_month() ) {
			$title = '<h1><span class="title-description">' . esc_html__( 'Monthly Archive:', 'coldbox' ) . '&#32;</span>' . get_the_date( _x( 'F, Y', 'Date Format', 'coldbox' ) ) . '</h1>';
		} elseif ( is_year() ) {
			$title = '<h1><span class="title-description">' . esc_html__( 'Yearly Archive:', 'coldbox' ) . '&#32;</span>' . get_the_date( 'Y' ) . '</h1>';
		} elseif ( is_author() ) {
			$title = '<h1><span class="title-description">' . esc_html__( 'Author:', 'coldbox' ) . '&#32;</span>' . get_the_author_meta( 'display_name' ) . '</h1>';
		}
		return $title;
	}
}
add_filter( 'get_the_archive_title', 'cd_modify_archive_title' );

/*
 * -------------------------------------------------------------------------
 *  Theme definitions
 * -------------------------------------------------------------------------
 */
define( 'CD_VER', '1.4.0' );

/*
 * -------------------------------------------------------------------------
 *  Addon cooperation
 * -------------------------------------------------------------------------
 */

// Load TGM plugin activation file.
require_once get_template_directory() . '/parts/tgm/load-tgm.php';

if ( ! function_exists( 'cd_is_active_addon' ) ) {
	/**
	 * Whether or not addon plugin is active.
	 *
	 * @since 1.2.0
	 */
	function cd_is_active_addon() {
		$is_active = false;
		return apply_filters( 'cd_is_active_addon', $is_active );
	}
	add_action( 'plugins_loaded', 'cd_is_active_addon', 1 );
}

if ( ! function_exists( 'cd_is_amp' ) ) {

	/**
	 * Whether or not AMP page.
	 *
	 * @since 1.2.0
	 */
	function cd_is_amp() {
		$is_amp = false;
		return apply_filters( 'cd_is_amp', $is_amp );
	}
	add_action( 'wp', 'cd_is_amp', 1 );
}
