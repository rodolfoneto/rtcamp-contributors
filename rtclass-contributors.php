<?php
/**
 * Plugin Name:     RtClass Contributors
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          Rodolfo Neto
 * Author URI:      rodolfoneto@gmail.com
 * Text Domain:     rtclass-contributors
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Rtclass_Contributors
 */

use RtClass\Admin\RtClass_Admin_Metabox;
use RtClass\Admin\RtClass_Admin_Save_Contributor;
use RtClass\RTClass_Metabox;

// Your code starts here.
include_once dirname(__FILE__) . '/vendor/autoload.php';

new RtClass_Admin_Metabox( true );
new RtClass_Admin_Save_Contributor( true );
new RtClass_Metabox( true );

function rtclass_theme_styles() {
    wp_enqueue_style( 'rtclass-theme-style', plugins_url('rtclass-contributors') . '/public/style.css' );
	wp_enqueue_style( 'rtclass-theme-style' );
	wp_register_style( 'rtclass-theme-style', plugins_url('rtclass-contributors') . '/public/style.css' );
}
add_action( 'wp_enqueue_scripts', 'rtclass_theme_styles' );
