<?php
class hsgpi_intermediate
{
	public static function hsgpi_admin()
	{
		global $wpdb;
		$current_page = isset($_GET['ac']) ? $_GET['ac'] : '';
		switch($current_page)
		{
			case 'add':
				require_once(HSGPI_DIR.'page'.DIRECTORY_SEPARATOR.'hsgpi-add.php');
				break;
			case 'edit':
				require_once(HSGPI_DIR.'page'.DIRECTORY_SEPARATOR.'hsgpi-edit.php');
				break;
			default:
				require_once(HSGPI_DIR.'page'.DIRECTORY_SEPARATOR.'hsgpi-show.php');
				break;
		}
	}
}
?>