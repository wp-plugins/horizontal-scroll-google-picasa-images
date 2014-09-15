<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
class hsgpi_dbquery
{
	public static function hsgpi_count($id = 0)
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		$result = 0;
		if($id > 0)
		{
			$sSql = $wpdb->prepare("SELECT COUNT(*) AS `count` FROM `".$prefix."hsgpi_gallery` WHERE `hsgpi_id` = %d", array($id));
		}
		else
		{
			$sSql = "SELECT COUNT(*) AS `count` FROM `".$prefix."hsgpi_gallery`";
		}
		$result = $wpdb->get_var($sSql);
		return $result;
	}
	
	public static function hsgpi_select($id = 0)
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		$arrRes = array();
		if($id > 0)
		{
			$sSql = $wpdb->prepare("SELECT * FROM `".$prefix."hsgpi_gallery` where hsgpi_id = %d", array($id));
		}
		else
		{
			$sSql = "SELECT * FROM `".$prefix."hsgpi_gallery` order by hsgpi_id desc";
		}
		//echo $sSql;
		$arrRes = $wpdb->get_results($sSql, ARRAY_A);
		return $arrRes;
	}
	
	public static function hsgpi_delete($id = 0)
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		$sSql = $wpdb->prepare("DELETE FROM `".$prefix."hsgpi_gallery` WHERE `hsgpi_id` = %d LIMIT 1", $id);
		$wpdb->query($sSql);
		return true;
	}
	
	public static function hsgpi_act($data = array(), $action = "ins")
	{
		global $wpdb;
		$prefix = $wpdb->prefix;
		if($action == "ins")
		{
			$sql = $wpdb->prepare("INSERT INTO `".$prefix."hsgpi_gallery` 
			(`hsgpi_title`, `hsgpi_thumbwidth`, `hsgpi_fullwidth`, `hsgpi_controls`, `hsgpi_autointerval`, `hsgpi_intervaltime`, `hsgpi_animation`, 
			`hsgpi_random`, `hsgpi_arrowcolor`, `hsgpi_googleusername`, `hsgpi_googlealbumid`, `hsgpi_googleimgtype`, `hsgpi_googleimgcount`, `hsgpi_fancybox`)
			VALUES(%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", 
			array($data["hsgpi_title"], $data["hsgpi_thumbwidth"], $data["hsgpi_fullwidth"], $data["hsgpi_controls"], $data["hsgpi_autointerval"], 
			$data["hsgpi_intervaltime"], $data["hsgpi_animation"], $data["hsgpi_random"], $data["hsgpi_arrowcolor"], $data["hsgpi_googleusername"], 
			$data["hsgpi_googlealbumid"], $data["hsgpi_googleimgtype"], $data["hsgpi_googleimgcount"], $data["hsgpi_fancybox"]));
			$wpdb->query($sql);
			//echo $sql;
			return "sus";
		}
		elseif($action == "ups")
		{
			$sql = $wpdb->prepare("UPDATE `".$prefix."hsgpi_gallery` SET `hsgpi_title` = %s, `hsgpi_thumbwidth` = %s, 
			`hsgpi_fullwidth` = %s, `hsgpi_controls` = %s, `hsgpi_autointerval` = %s, `hsgpi_intervaltime` = %s, `hsgpi_animation` = %s, 
			`hsgpi_random` = %s, `hsgpi_arrowcolor` = %s, `hsgpi_googleusername` = %s, 
			`hsgpi_googlealbumid` = %s, `hsgpi_googleimgtype` = %s, `hsgpi_googleimgcount` = %s, `hsgpi_fancybox` = %s WHERE hsgpi_id = %d LIMIT 1", 
			array($data["hsgpi_title"], $data["hsgpi_thumbwidth"], $data["hsgpi_fullwidth"], $data["hsgpi_controls"], $data["hsgpi_autointerval"], 
			$data["hsgpi_intervaltime"], $data["hsgpi_animation"], $data["hsgpi_random"], $data["hsgpi_arrowcolor"], $data["hsgpi_googleusername"], 
			$data["hsgpi_googlealbumid"], $data["hsgpi_googleimgtype"], $data["hsgpi_googleimgcount"], $data["hsgpi_fancybox"], $data["hsgpi_id"]));
			$wpdb->query($sql);
			//echo $sql;
			return "sus";
		}
		else
		{
			return "err";
		}
		
	}
	
	public static function hsgpi_default()
	{
		$result = hsgpi_dbquery::hsgpi_count(0);
		if ($result == 0)
		{
			$form = array();
			$form['hsgpi_title'] = 'Sample Album 1';
			$form['hsgpi_thumbwidth'] = '200';
			$form['hsgpi_fullwidth'] = '640';
			$form['hsgpi_controls'] = 'true';
			$form['hsgpi_autointerval'] = 'true';
			$form['hsgpi_intervaltime'] = '3500';
			$form['hsgpi_animation'] = '1000';
			$form['hsgpi_random'] = 'YES';
			$form['hsgpi_arrowcolor'] = '#C01313';
			$form['hsgpi_googleusername'] = '103021440284242065651';
			$form['hsgpi_googlealbumid'] = '6056223604731131297';
			$form['hsgpi_googleimgtype'] = 'uncropped';
			$form['hsgpi_googleimgcount'] = '15';
			$form['hsgpi_fancybox'] = 'YES';
			hsgpi_dbquery::hsgpi_act($form, "ins");
		}
		return true;
	}
}
?>