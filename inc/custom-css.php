<?php
/**
 * Twenty Twenty Custom CSS
 *
 * @package reinhart1010
 * @subpackage Skyborne
 * @since 1.1.0
 */

if ( ! function_exists( 'twentytwenty_generate_css' ) ) {

	/**
	 * Generate CSS.
	 *
	 * @param string $selector The CSS selector.
	 * @param string $style The CSS style.
	 * @param string $value The CSS value.
	 * @param string $prefix The CSS prefix.
	 * @param string $suffix The CSS suffix.
	 * @param bool   $echo Echo the styles.
	 */
	function twentytwenty_generate_css( $selector, $style, $value, $prefix = '', $suffix = '', $echo = true ) {

		$return = '';

		/*
		 * Bail early if we have no $selector elements or properties and $value.
		 */
		if ( ! $value || ! $selector ) {

			return;
		}

		$return = sprintf( '%s { %s: %s; }', $selector, $style, $prefix . $value . $suffix );

		if ( $echo ) {

			echo $return; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- We need to double check this, but for now, we want to pass PHPCS ;)

		}

		return $return;

	}
}

if ( ! function_exists( 'twentytwenty_generate_css_dm' ) ) {

	/**
	 * Generate CSS for dark mode.
	 *
	 * @param string $selector The CSS selector.
	 * @param string $style The CSS style.
	 * @param string $value The CSS value.
	 * @param string $prefix The CSS prefix.
	 * @param string $suffix The CSS suffix.
	 * @param bool   $echo Echo the styles.
	 */
	function twentytwenty_generate_css_dm( $selector, $style, $value, $prefix = '', $suffix = '', $echo = true ) {

		$return = '';

		/*
		 * Bail early if we have no $selector elements or properties and $value.
		 */
		if ( ! $value || ! $selector ) {

			return;
		}

		$return = sprintf( '.darkmode--activated %s { %s: %s; }', $selector, $style, $prefix . $value . $suffix );

		if ( $echo ) {

			echo $return; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- We need to double check this, but for now, we want to pass PHPCS ;)

		}

		return $return;

	}
}

if ( ! function_exists( 'twentytwenty_get_customizer_css' ) ) {

	/**
	 * Get CSS Built from Customizer Options.
	 * Build CSS reflecting colors, fonts and other options set in the Customizer, and return them for output.
	 *
	 * @param string $type Whether to return CSS for the "front-end", "block-editor" or "classic-editor".
	 */
	function twentytwenty_get_customizer_css( $type = 'front-end' ) {

		// Get variables.
		$body              = sanitize_hex_color( twentytwenty_get_color_for_area( 'content', 'text' ) );
		$body_default      = '#000000';
		$secondary         = sanitize_hex_color( twentytwenty_get_color_for_area( 'content', 'secondary' ) );
		$secondary_default = '#6d6d6d';
		$borders           = sanitize_hex_color( twentytwenty_get_color_for_area( 'content', 'borders' ) );
		$borders_default   = '#dcd7ca';
		$accent            = sanitize_hex_color( twentytwenty_get_color_for_area( 'content', 'accent' ) );
		$accent_default    = '#0ea5e9';

		// Header.
		$header_footer_background         = sanitize_hex_color( twentytwenty_get_color_for_area( 'header-footer', 'background' ) );
		$header_footer_background_default = '#ffffff';

		// Cover.
		$cover         = sanitize_hex_color( get_theme_mod( 'cover_template_overlay_text_color' ) );
		$cover_default = '#ffffff';

		// Background.
		$background         = sanitize_hex_color_no_hash( get_theme_mod( 'background_color' ) );
		$background_default = 'f5efe0';

		/* And do the same thing for dark mode */
		// Get variables.
		$body_dm              = sanitize_hex_color( twentytwenty_get_color_for_area( 'content', 'text' ) );
		$body_default_dm      = '#ffffff';
		$secondary_dm         = sanitize_hex_color( twentytwenty_get_color_for_area( 'content', 'secondary' ) );
		$secondary_default_dm = '#aaaaaa';
		$borders_dm           = sanitize_hex_color( twentytwenty_get_color_for_area( 'content', 'borders' ) );
		$borders_default_dm   = '#333333';
		$accent_dm            = sanitize_hex_color( twentytwenty_get_color_for_area( 'content', 'accent' ) );
		$accent_default_dm    = '#84cc16';

		// Header.
		$header_footer_background_dm         = sanitize_hex_color( twentytwenty_get_color_for_area( 'header-footer', 'background' ) );
		$header_footer_background_default_dm = '#000000';

		// Cover.
		$cover_dm         = sanitize_hex_color( get_theme_mod( 'cover_template_overlay_text_color_dm' ) );
		$cover_default_dm = '#000000';

		// Background.
		$background_dm         = sanitize_hex_color_no_hash( get_theme_mod( 'background_color_dm' ) );
		$background_default_dm = '000000';

		ob_start();

		/**
		 * Note – Styles are applied in this order:
		 * 1. Element specific
		 * 2. Helper classes
		 *
		 * This enables all helper classes to overwrite base element styles,
		 * meaning that any color classes applied in the block editor will
		 * have a higher priority than the base element styles.
		*/

		// Front-End Styles.
		if ( 'front-end' === $type ) {

			// Auto-calculated colors.
			$elements_definitions = twentytwenty_get_elements_array();
			foreach ( $elements_definitions as $context => $props ) {
				foreach ( $props as $key => $definitions ) {
					foreach ( $definitions as $property => $elements ) {
						/*
						 * If we don't have an elements array or it is empty
						 * then skip this iteration early;
						 */
						if ( ! is_array( $elements ) || empty( $elements ) ) {
							continue;
						}
						$val = twentytwenty_get_color_for_area( $context, $key );
						if ( $val ) {
							twentytwenty_generate_css( implode( ',', $elements ), $property, $val );
						}
					}
				}
			}

			if ( $cover && $cover !== $cover_default ) {
				twentytwenty_generate_css( '.overlay-header .header-inner', 'color', $cover );
				twentytwenty_generate_css( '.cover-header .entry-header *', 'color', $cover );
			}

			if ( $cover_dm ) {
				twentytwenty_generate_css_dm( '.overlay-header .header-inner', 'color', $cover_dm );
				twentytwenty_generate_css_dm( '.cover-header .entry-header *', 'color', $cover_dm );
			}

			// Block Editor Styles.
		} elseif ( 'block-editor' === $type ) {

			// Colors.
			// Accent color.
			if ( $accent && $accent !== $accent_default ) {
				twentytwenty_generate_css( '.has-accent-color, .editor-styles-wrapper .editor-block-list__layout a, .editor-styles-wrapper .has-drop-cap:not(:focus)::first-letter, .editor-styles-wrapper .wp-block-button.is-style-outline .wp-block-button__link, .editor-styles-wrapper .wp-block-pullquote::before, .editor-styles-wrapper .wp-block-file .wp-block-file__textlink', 'color', $accent );
				twentytwenty_generate_css( '.editor-styles-wrapper .wp-block-quote', 'border-color', $accent, '' );
				twentytwenty_generate_css( '.has-accent-background-color, .editor-styles-wrapper .wp-block-button__link, .editor-styles-wrapper .wp-block-file__button', 'background-color', $accent );
			}

			if ( $accent_dm ) {
				twentytwenty_generate_css_dm( '.has-accent-color, .editor-styles-wrapper .editor-block-list__layout a, .editor-styles-wrapper .has-drop-cap:not(:focus)::first-letter, .editor-styles-wrapper .wp-block-button.is-style-outline .wp-block-button__link, .editor-styles-wrapper .wp-block-pullquote::before, .editor-styles-wrapper .wp-block-file .wp-block-file__textlink', 'color', $accent_dm );
				twentytwenty_generate_css_dm( '.editor-styles-wrapper .wp-block-quote', 'border-color', $accent_dm, '' );
				twentytwenty_generate_css_dm( '.has-accent-background-color, .editor-styles-wrapper .wp-block-button__link, .editor-styles-wrapper .wp-block-file__button', 'background-color', $accent_dm );
			}

			// Background color.
			if ( $background && $background !== $background_default ) {
				twentytwenty_generate_css( '.editor-styles-wrapper', 'background-color', '#' . $background );
				twentytwenty_generate_css( '.has-background.has-primary-background-color:not(.has-text-color),.has-background.has-primary-background-color *:not(.has-text-color),.has-background.has-accent-background-color:not(.has-text-color),.has-background.has-accent-background-color *:not(.has-text-color)', 'color', '#' . $background );
			}

			if ( $background_dm ) {
				twentytwenty_generate_css_dm( '.editor-styles-wrapper', 'background-color', '#' . $background_dm );
				twentytwenty_generate_css_dm( '.has-background.has-primary-background-color:not(.has-text-color),.has-background.has-primary-background-color *:not(.has-text-color),.has-background.has-accent-background-color:not(.has-text-color),.has-background.has-accent-background-color *:not(.has-text-color)', 'color', '#' . $background_dm );
			}

			// Borders color.
			if ( $borders && $borders !== $borders_default ) {
				twentytwenty_generate_css( '.editor-styles-wrapper .wp-block-code, .editor-styles-wrapper pre, .editor-styles-wrapper .wp-block-preformatted pre, .editor-styles-wrapper .wp-block-verse pre, .editor-styles-wrapper fieldset, .editor-styles-wrapper .wp-block-table, .editor-styles-wrapper .wp-block-table *, .editor-styles-wrapper .wp-block-table.is-style-stripes, .editor-styles-wrapper .wp-block-latest-posts.is-grid li', 'border-color', $borders );
				twentytwenty_generate_css( '.editor-styles-wrapper .wp-block-table caption, .editor-styles-wrapper .wp-block-table.is-style-stripes tbody tr:nth-child(odd)', 'background-color', $borders );
			}

			if ( $borders_dm ) {
				twentytwenty_generate_css_dm( '.editor-styles-wrapper .wp-block-code, .editor-styles-wrapper pre, .editor-styles-wrapper .wp-block-preformatted pre, .editor-styles-wrapper .wp-block-verse pre, .editor-styles-wrapper fieldset, .editor-styles-wrapper .wp-block-table, .editor-styles-wrapper .wp-block-table *, .editor-styles-wrapper .wp-block-table.is-style-stripes, .editor-styles-wrapper .wp-block-latest-posts.is-grid li', 'border-color', $borders_dm );
				twentytwenty_generate_css_dm( '.editor-styles-wrapper .wp-block-table caption, .editor-styles-wrapper .wp-block-table.is-style-stripes tbody tr:nth-child(odd)', 'background-color', $borders_dm );
			}

			// Text color.
			if ( $body && $body !== $body_default ) {
				twentytwenty_generate_css( 'body .editor-styles-wrapper, .editor-post-title__block .editor-post-title__input, .editor-post-title__block .editor-post-title__input:focus', 'color', $body );
			}

			if ( $body_dm ) {
				twentytwenty_generate_css_dm( 'body .editor-styles-wrapper, .editor-post-title__block .editor-post-title__input, .editor-post-title__block .editor-post-title__input:focus', 'color', $body_dm );
			}

			// Secondary color.
			if ( $secondary && $secondary !== $secondary_default ) {
				twentytwenty_generate_css( '.editor-styles-wrapper figcaption, .editor-styles-wrapper cite, .editor-styles-wrapper .wp-block-quote__citation, .editor-styles-wrapper .wp-block-quote cite, .editor-styles-wrapper .wp-block-quote footer, .editor-styles-wrapper .wp-block-pullquote__citation, .editor-styles-wrapper .wp-block-pullquote cite, .editor-styles-wrapper .wp-block-pullquote footer, .editor-styles-wrapper ul.wp-block-archives li, .editor-styles-wrapper ul.wp-block-categories li, .editor-styles-wrapper ul.wp-block-latest-posts li, .editor-styles-wrapper ul.wp-block-categories__list li, .editor-styles-wrapper .wp-block-latest-comments time, .editor-styles-wrapper .wp-block-latest-posts time', 'color', $secondary );
			}

			if ( $secondary_dm ) {
				twentytwenty_generate_css_dm( '.editor-styles-wrapper figcaption, .editor-styles-wrapper cite, .editor-styles-wrapper .wp-block-quote__citation, .editor-styles-wrapper .wp-block-quote cite, .editor-styles-wrapper .wp-block-quote footer, .editor-styles-wrapper .wp-block-pullquote__citation, .editor-styles-wrapper .wp-block-pullquote cite, .editor-styles-wrapper .wp-block-pullquote footer, .editor-styles-wrapper ul.wp-block-archives li, .editor-styles-wrapper ul.wp-block-categories li, .editor-styles-wrapper ul.wp-block-latest-posts li, .editor-styles-wrapper ul.wp-block-categories__list li, .editor-styles-wrapper .wp-block-latest-comments time, .editor-styles-wrapper .wp-block-latest-posts time', 'color', $secondary_dm );
			}

			// Header Footer Background Color.
			if ( $header_footer_background && $header_footer_background !== $header_footer_background_default ) {
				twentytwenty_generate_css( '.editor-styles-wrapper .wp-block-pullquote::before', 'background-color', $header_footer_background );
			}

			if ( $header_footer_background_dm ) {
				twentytwenty_generate_css_dm( '.editor-styles-wrapper .wp-block-pullquote::before', 'background-color', $header_footer_background_dm );
			}
		} elseif ( 'classic-editor' === $type ) {

			// Colors.
			// Accent color.
			if ( $accent && $accent !== $accent_default ) {
				twentytwenty_generate_css( 'body#tinymce.wp-editor.content a, body#tinymce.wp-editor.content a:focus, body#tinymce.wp-editor.content a:hover', 'color', $accent );
				twentytwenty_generate_css( 'body#tinymce.wp-editor.content blockquote, body#tinymce.wp-editor.content .wp-block-quote', 'border-color', $accent, '', ' !important' );
				twentytwenty_generate_css( 'body#tinymce.wp-editor.content button, body#tinymce.wp-editor.content .faux-button, body#tinymce.wp-editor.content .wp-block-button__link, body#tinymce.wp-editor.content .wp-block-file__button, body#tinymce.wp-editor.content input[type=\'button\'], body#tinymce.wp-editor.content input[type=\'reset\'], body#tinymce.wp-editor.content input[type=\'submit\']', 'background-color', $accent );
			}

			if ( $accent_dm ) {
				twentytwenty_generate_css_dm( 'body#tinymce.wp-editor.content a, body#tinymce.wp-editor.content a:focus, body#tinymce.wp-editor.content a:hover', 'color', $accent_dm );
				twentytwenty_generate_css_dm( 'body#tinymce.wp-editor.content blockquote, body#tinymce.wp-editor.content .wp-block-quote', 'border-color', $accent_dm, '', ' !important' );
				twentytwenty_generate_css_dm( 'body#tinymce.wp-editor.content button, body#tinymce.wp-editor.content .faux-button, body#tinymce.wp-editor.content .wp-block-button__link, body#tinymce.wp-editor.content .wp-block-file__button, body#tinymce.wp-editor.content input[type=\'button\'], body#tinymce.wp-editor.content input[type=\'reset\'], body#tinymce.wp-editor.content input[type=\'submit\']', 'background-color', $accent_dm );
			}

			// Background color.
			if ( $background && $background !== $background_default ) {
				twentytwenty_generate_css( 'body#tinymce.wp-editor.content', 'background-color', '#' . $background );
			}

			if ( $background_dm ) {
				twentytwenty_generate_css_dm( 'body#tinymce.wp-editor.content', 'background-color', '#' . $background_dm );
			}

			// Text color.
			if ( $body && $body !== $body_default ) {
				twentytwenty_generate_css( 'body#tinymce.wp-editor.content', 'color', $body );
			}

			if ( $body_dm ) {
				twentytwenty_generate_css_dm( 'body#tinymce.wp-editor.content', 'color', $body );
			}

			// Secondary color.
			if ( $secondary && $secondary !== $secondary_default ) {
				twentytwenty_generate_css( 'body#tinymce.wp-editor.content hr:not(.is-style-dots), body#tinymce.wp-editor.content cite, body#tinymce.wp-editor.content figcaption, body#tinymce.wp-editor.content .wp-caption-text, body#tinymce.wp-editor.content .wp-caption-dd, body#tinymce.wp-editor.content .gallery-caption', 'color', $secondary );
			}

			if ( $secondary_dm ) {
				twentytwenty_generate_css_dm( 'body#tinymce.wp-editor.content hr:not(.is-style-dots), body#tinymce.wp-editor.content cite, body#tinymce.wp-editor.content figcaption, body#tinymce.wp-editor.content .wp-caption-text, body#tinymce.wp-editor.content .wp-caption-dd, body#tinymce.wp-editor.content .gallery-caption', 'color', $secondary_dm );
			}

			// Borders color.
			if ( $borders && $borders !== $borders_default ) {
				twentytwenty_generate_css( 'body#tinymce.wp-editor.content pre, body#tinymce.wp-editor.content hr, body#tinymce.wp-editor.content fieldset,body#tinymce.wp-editor.content input, body#tinymce.wp-editor.content textarea', 'border-color', $borders );
			}

			if ( $borders_dm ) {
				twentytwenty_generate_css_dm( 'body#tinymce.wp-editor.content pre, body#tinymce.wp-editor.content hr, body#tinymce.wp-editor.content fieldset,body#tinymce.wp-editor.content input, body#tinymce.wp-editor.content textarea', 'border-color', $borders_dm );
			}
		}

		// Return the results.
		return ob_get_clean();

	}
}
