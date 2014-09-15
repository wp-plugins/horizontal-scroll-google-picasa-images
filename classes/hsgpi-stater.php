<?php
$hsgpi_plugin_name = 'horizontal-scroll-google-picasa-images';
$hsgpi_current_folder = dirname(dirname(__FILE__));
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);
if(!defined('HSGPI_TDOMAIN')) define('HSGPI_TDOMAIN', $hsgpi_plugin_name);
if(!defined('HSGPI_PLUGIN_NAME')) define('HSGPI_PLUGIN_NAME', $hsgpi_plugin_name);
if(!defined('HSGPI_PLUGIN_DISPLAY')) define('HSGPI_PLUGIN_DISPLAY', "Horizontal scroll google picasa images");
if(!defined('HSGPI_DIR')) define('HSGPI_DIR', $hsgpi_current_folder.DS);
if(!defined('HSGPI_URL')) define('HSGPI_URL',plugins_url().'/'.strtolower('horizontal-scroll-google-picasa-images').'/');

define('HSGPI_FILE',HSGPI_DIR.'horizontal-scroll-google-picasa-images.php');
if(!defined('HSGPI_FAV')) define('HSGPI_FAV', 'http://www.gopiplus.com/work/2014/09/10/horizontal-scroll-google-picasa-images-wordpress-plugin/');
define('HSGPI_OFFICIAL', 'Check official website for more information <a target="_blank" href="'.HSGPI_FAV.'">click here</a>');
if(!defined('HSGPI_ADMINURL')) define('HSGPI_ADMINURL', get_option('siteurl') . '/wp-admin/options-general.php?page=horizontal-scroll-google-picasa-images');

require_once(HSGPI_DIR.'classes'.DIRECTORY_SEPARATOR.'hsgpi-register.php');
require_once(HSGPI_DIR.'classes'.DIRECTORY_SEPARATOR.'hsgpi-intermediate.php');
require_once(HSGPI_DIR.'classes'.DIRECTORY_SEPARATOR.'hsgpi-load.php');
require_once(HSGPI_DIR.'classes'.DIRECTORY_SEPARATOR.'hsgpi-loadgoogle.php');
require_once(HSGPI_DIR.'classes'.DIRECTORY_SEPARATOR.'hsgpi-query.php');
?>