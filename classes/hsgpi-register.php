<?php
class hsgpi_registerhook
{
	public static function hsgpi_activation()
	{
		global $wpdb, $hsgpi_db_version;
		$prefix = $wpdb->prefix;
		
		// Plugin tables
		$array_tables_to_plugin = array('hsgpi_gallery');
		$errors = array();
		
		// loading the sql file, load it and separate the queries
		$sql_file = HSGPI_DIR.'sql'.DS.'hsgpi-tbl.sql';
		$prefix = $wpdb->prefix;
        $handle = fopen($sql_file, 'r');
        $query = fread($handle, filesize($sql_file));
        fclose($handle);
        $query=str_replace('CREATE TABLE IF NOT EXISTS `','CREATE TABLE IF NOT EXISTS `'.$prefix, $query);
        $queries=explode('-- SQLQUERY ---', $query);

        // Run the queries one by one
        $has_errors = false;
        foreach($queries as $qry)
		{
			$wpdb->query($qry);
        }

		// List the tables that haven't been created
        $missingtables=array();
        foreach($array_tables_to_plugin as $table_name)
		{
			if(strtoupper($wpdb->get_var("SHOW TABLES like  '". $prefix.$table_name . "'")) != strtoupper($prefix.$table_name))  
			{
                $missingtables[] = $prefix.$table_name;
            }
        }
	
		// Add error in to array variable
        if($missingtables) 
		{
			$errors[] = __('These tables could not be created on installation ' . implode(', ',$missingtables), HSGPI_TDOMAIN);
            $has_errors=true;
        }
		
		// If error call wp_die()
        if($has_errors) 
		{
			wp_die( __( $errors[0] , HSGPI_TDOMAIN ) );
			return false;
		}
		else
		{
			hsgpi_dbquery::hsgpi_default();
		}
        return true;
	}
	
	public static function hsgpi_deactivation()
	{
		// do not generate any output here
	}
	
	public static function hsgpi_adminmenu()
	{
		if (is_admin()) 
		{
			add_options_page( __('Horizontal scroll picasa images', HSGPI_TDOMAIN), 
				__('Horizontal scroll picasa images', HSGPI_TDOMAIN), 'manage_options', HSGPI_PLUGIN_NAME, array( 'hsgpi_intermediate', 'hsgpi_admin' ) );
		}		
	}
}

function hsgpi_add_javascript_files() 
{
	if (!is_admin())
	{
		wp_enqueue_script('jquery');
		wp_enqueue_script( 'jquery.tinycarousel', HSGPI_URL.'inc/jquery.tinycarousel.js');
		wp_enqueue_style( 'jquery.fancybox', HSGPI_URL.'inc/jquery.fancybox-1.3.4.css');
		wp_enqueue_script('jquery.fancybox', HSGPI_URL.'inc/jquery.fancybox-1.3.4.js');
	}
}
?>