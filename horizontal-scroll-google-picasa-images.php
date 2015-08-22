<?php
/*
Plugin Name: Horizontal scroll google picasa images
Plugin URI: http://www.gopiplus.com/work/2014/09/10/horizontal-scroll-google-picasa-images-wordpress-plugin/
Description: This plugin is created to retrieve images from particular google plus album (Picasa album), and display the images using Tiny Carousel light weight jquery script. It will scroll your Google Plus images in a horizontal scroll style. 
Version: 1.3
Author: Gopi Ramasamy
Donate link: http://www.gopiplus.com/work/2014/09/10/horizontal-scroll-google-picasa-images-wordpress-plugin/
Author URI: http://www.gopiplus.com/work/2014/09/10/horizontal-scroll-google-picasa-images-wordpress-plugin/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

/*  
Copyright 2015 Horizontal scroll google picasa images (www.gopiplus.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'hsgpi-stater.php');

add_action('admin_menu', array( 'hsgpi_registerhook', 'hsgpi_adminmenu' ));
register_activation_hook(HSGPI_FILE, array( 'hsgpi_registerhook', 'hsgpi_activation' ));
register_deactivation_hook(HSGPI_FILE, array( 'hsgpi_registerhook', 'hsgpi_deactivation' ));

add_shortcode( 'hsgpi', 'hsgpi_shortcode' );
add_action('wp_enqueue_scripts', 'hsgpi_add_javascript_files');

function hsgpi_textdomain() 
{
	  load_plugin_textdomain( 'horizontal-scroll-google-picasa-images' , false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action('plugins_loaded', 'hsgpi_textdomain');
?>