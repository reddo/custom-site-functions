<?php
/**
 * shortcode-ui-custom plugin init setup
 *
 * @package shortcode-ui
 */

/**
 * If Shortcake isn't active, then this demo plugin doesn't work either
 */
add_action( 'init', 'shortcode_ui_detection' );

/**
 * Register the shortcodes independently of their UI.
 * Shortcodes should always be registered, but shortcode UI should only
 * be registered when Shortcake is active.
 */
add_action( 'init', 'shortcode_ui_dev_register_shortcodes' );

/**
 * Register a UI for the Shortcode.
 * Pass the shortcode tag (string)
 * and an array or args.
 */
add_action( 'register_shortcode_ui', 'shortcode_ui_register_shortcodes' );