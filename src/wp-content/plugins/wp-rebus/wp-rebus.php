<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://wojciechmocek.nstrefa.pl/
 * @since             1.0.0
 * @package           Wp_Rebus
 *
 * @wordpress-plugin
 * Plugin Name:       Rebus checker
 * Plugin URI:        about:blank
 * Description:       This plugin creates input password and checks if typed password is correct.
 *  Just write [hasło="password to guess"] and it will be transformed into input field and button.
 *  Password-answer comparison is case INsensitive.
 * Version:           1.0.0
 * Author:            Wojciech Mocek
 * Author URI:        http://wojciechmocek.nstrefa.pl/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-rebus
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


add_filter( 'the_content', 'filter_the_content_for_the_rebus_password' );

/**
 * 
 * @param string $content
 * @return string
 */
function filter_the_content_for_the_rebus_password( $content ) {
 
    // Check if we're inside the main loop in a single post page.
    if ( is_single() && in_the_loop() && is_main_query() ) {
        $pattern = '/\[hasło=("|\'|&#8221;)(.*)("|\'|&#8221;)\]/m';
        
        return preg_replace_callback($pattern, function($matches){
            if(isset($matches[2])){
                return create_rebus_checker($matches[2]);
            }
            
        }, $content);
       


    }
 
    return $content;
}

/**
 * 
 * @param string $rebusPassword
 * @return string html partial
 * @uses file _input_single.phtml
 */
function create_rebus_checker($rebusPassword){
    return str_replace(
        '{encodedAnswer}',
        encodeThePassword($rebusPassword),
        file_get_contents(__DIR__.'/_input_single.phtml')
    );
}


add_action('wp_enqueue_scripts', function(){
    if ( is_single() && is_main_query() ) {
        wp_enqueue_script('rebus_single', plugin_dir_url( __FILE__ ).'rebus_single.js', array(), false, true);
    }
    
});

/**
 * 
 * @param string $string
 * @return string
 */
function encodeThePassword($string){
    return base64_encode(rawurlencode($string));
}