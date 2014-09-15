<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<div class="wrap">
<?php
$hsgpi_errors = array();
$hsgpi_success = '';
$hsgpi_error_found = FALSE;

// Preset the form fields
$form = array(
	'hsgpi_id' => '',
	'hsgpi_title' => '',
	'hsgpi_thumbwidth' => '',
	'hsgpi_fullwidth' => '',
	'hsgpi_controls' => '',
	'hsgpi_autointerval' => '',
	'hsgpi_intervaltime' => '',
	'hsgpi_animation' => '',
	'hsgpi_random' => '',
	'hsgpi_arrowcolor' => '',
	'hsgpi_googleusername' => '',
	'hsgpi_googlealbumid' => '',
	'hsgpi_googleimgtype' => '',
	'hsgpi_googleimgcount' => '',
	'hsgpi_fancybox' => '',
	'hsgpi_extra2' => '',
	'hsgpi_extra3' => ''
);

// Form submitted, check the data
if (isset($_POST['hsgpi_form_submit']) && $_POST['hsgpi_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('hsgpi_form_add');
	
	$form['hsgpi_googleusername'] = isset($_POST['hsgpi_googleusername']) ? $_POST['hsgpi_googleusername'] : '';
	if ($form['hsgpi_googleusername'] == '')
	{
		$hsgpi_errors[] = __('Enter google plus username.', HSGPI_TDOMAIN);
		$hsgpi_error_found = TRUE;
	}
	
	$form['hsgpi_googlealbumid'] = isset($_POST['hsgpi_googlealbumid']) ? $_POST['hsgpi_googlealbumid'] : '';
	if ($form['hsgpi_googlealbumid'] == '')
	{
		$hsgpi_errors[] = __('Enter google plus album id.', HSGPI_TDOMAIN);
		$hsgpi_error_found = TRUE;
	}
	
	$form['hsgpi_title'] = isset($_POST['hsgpi_title']) ? $_POST['hsgpi_title'] : '';
	if ($form['hsgpi_title'] == '')
	{
		$hsgpi_errors[] = __('Enter title for your gallery.', HSGPI_TDOMAIN);
		$hsgpi_error_found = TRUE;
	}
	
	$form['hsgpi_intervaltime'] = isset($_POST['hsgpi_intervaltime']) ? $_POST['hsgpi_intervaltime'] : '';
	if ($form['hsgpi_intervaltime'] == '')
	{
		$hsgpi_errors[] = __('Enter auto interval time in millisecond. (Ex: 1500)', HSGPI_TDOMAIN);
		$hsgpi_error_found = TRUE;
	}
	
	$form['hsgpi_animation'] = isset($_POST['hsgpi_animation']) ? $_POST['hsgpi_animation'] : '';
	if ($form['hsgpi_animation'] == '')
	{
		$hsgpi_errors[] = __('Enter animation duration in millisecond. (Ex: 1000)', HSGPI_TDOMAIN);
		$hsgpi_error_found = TRUE;
	}
	
	$form['hsgpi_thumbwidth'] = isset($_POST['hsgpi_thumbwidth']) ? $_POST['hsgpi_thumbwidth'] : '';
	$form['hsgpi_fullwidth'] = isset($_POST['hsgpi_fullwidth']) ? $_POST['hsgpi_fullwidth'] : '';
	$form['hsgpi_controls'] = isset($_POST['hsgpi_controls']) ? $_POST['hsgpi_controls'] : '';
	$form['hsgpi_autointerval'] = isset($_POST['hsgpi_autointerval']) ? $_POST['hsgpi_autointerval'] : '';
	$form['hsgpi_random'] = isset($_POST['hsgpi_random']) ? $_POST['hsgpi_random'] : '';
	$form['hsgpi_arrowcolor'] = isset($_POST['hsgpi_arrowcolor']) ? $_POST['hsgpi_arrowcolor'] : '';
	$form['hsgpi_googleusername'] = isset($_POST['hsgpi_googleusername']) ? $_POST['hsgpi_googleusername'] : '';
	$form['hsgpi_googlealbumid'] = isset($_POST['hsgpi_googlealbumid']) ? $_POST['hsgpi_googlealbumid'] : '';
	$form['hsgpi_googleimgtype'] = isset($_POST['hsgpi_googleimgtype']) ? $_POST['hsgpi_googleimgtype'] : '';
	$form['hsgpi_fancybox'] = isset($_POST['hsgpi_fancybox']) ? $_POST['hsgpi_fancybox'] : '';
	$form['hsgpi_extra2'] = isset($_POST['hsgpi_extra2']) ? $_POST['hsgpi_extra2'] : '';
	$form['hsgpi_extra3'] = isset($_POST['hsgpi_extra3']) ? $_POST['hsgpi_extra3'] : '';
	
	$form['hsgpi_googleimgcount'] = isset($_POST['hsgpi_googleimgcount']) ? $_POST['hsgpi_googleimgcount'] : '';
	if ($form['hsgpi_googleimgcount'] == '')
	{
		$hsgpi_errors[] = __('Number of photos, below 20 is recommended count.', HSGPI_TDOMAIN);
		$hsgpi_error_found = TRUE;
	}

	//	No errors found, we can add this Group to the table
	if ($hsgpi_error_found == FALSE)
	{
		$action = hsgpi_dbquery::hsgpi_act($form, "ins");
		if($action == "sus")
		{
			$hsgpi_success = __('New details was successfully added.', HSGPI_TDOMAIN);
		}
		elseif($action == "err")
		{
			$hsgpi_success = __('Oops unexpected error occurred.', HSGPI_TDOMAIN);
			$hsgpi_error_found = TRUE;
		}

		// Preset the form fields
		$form = array(
			'hsgpi_id' => '',
			'hsgpi_title' => '',
			'hsgpi_thumbwidth' => '',
			'hsgpi_fullwidth' => '',
			'hsgpi_controls' => '',
			'hsgpi_autointerval' => '',
			'hsgpi_intervaltime' => '',
			'hsgpi_animation' => '',
			'hsgpi_random' => '',
			'hsgpi_arrowcolor' => '',
			'hsgpi_googleusername' => '',
			'hsgpi_googlealbumid' => '',
			'hsgpi_googleimgtype' => '',
			'hsgpi_googleimgcount' => '',
			'hsgpi_fancybox' => '',
			'hsgpi_extra2' => '',
			'hsgpi_extra3' => ''
		);
	}
}

if ($hsgpi_error_found == TRUE && isset($hsgpi_errors[0]) == TRUE)
{
	?>
	<div class="error fade">
		<p><strong><?php echo $hsgpi_errors[0]; ?></strong></p>
	</div>
	<?php
}
if ($hsgpi_error_found == FALSE && strlen($hsgpi_success) > 0)
{
	?>
	<div class="updated fade">
		<p><strong><?php echo $hsgpi_success; ?> <a href="<?php echo HSGPI_ADMINURL; ?>"><?php _e('Click here', HSGPI_TDOMAIN); ?></a> 
		<?php _e('to view the details', HSGPI_TDOMAIN); ?></strong></p>
	</div>
	<?php
}
?>
<script language="JavaScript" src="<?php echo HSGPI_URL; ?>page/hsgpi-setting.js"></script>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php _e(HSGPI_PLUGIN_DISPLAY, HSGPI_TDOMAIN); ?></h2>
	<form name="hsgpi_form" method="post" action="#" onsubmit="return _hsgpi_submit()"  >
      <h3><?php _e('Add details', HSGPI_TDOMAIN); ?></h3>
      
		<label for="tag-a"><?php _e('Google+ User ID', HSGPI_TDOMAIN); ?></label>
		<input name="hsgpi_googleusername" type="text" id="hsgpi_googleusername" value="" size="30" maxlength="150" />
		<p><?php _e('Enter your google plus user name.', HSGPI_TDOMAIN); ?></p>
		
		<label for="tag-a"><?php _e('Google+ Album ID', HSGPI_TDOMAIN); ?></label>
		<input name="hsgpi_googlealbumid" type="text" id="hsgpi_googlealbumid" value="" size="30" maxlength="150" />
		<p><?php _e('Enter google plus album id. Click link for help making albums public. ', HSGPI_TDOMAIN); ?></p>
		
		<label for="tag-a"><?php _e('Gallery title', HSGPI_TDOMAIN); ?></label>
		<input name="hsgpi_title" type="text" id="hsgpi_title" value="" size="50" maxlength="255" />
		<p><?php _e('Enter title for your gallery.', HSGPI_TDOMAIN); ?></p>
		
		<label for="tag-a"><?php _e('Image type', HSGPI_TDOMAIN); ?></label>
		<select name="hsgpi_googleimgtype" id="hsgpi_googleimgtype">
			<option value='cropped' selected="selected">Cropped</option>
			<option value='uncropped'>Uncropped</option>
		</select>
		<p><?php _e('Select your image type for gallery.', HSGPI_TDOMAIN); ?></p>
		
		<label for="tag-a"><?php _e('Number of photos', HSGPI_TDOMAIN); ?></label>
		<input name="hsgpi_googleimgcount" type="text" id="hsgpi_googleimgcount" value="15" maxlength="3" />
		<p><?php _e('Number of photos, below 20 is recommended count.', HSGPI_TDOMAIN); ?></p>
		
		<label for="tag-a"><?php _e('Fancybox', HSGPI_TDOMAIN); ?></label>
		<select name="hsgpi_fancybox" id="hsgpi_fancybox">
			<option value='YES'>YES</option>
			<option value='NO' selected="selected">NO</option>
		</select>
		<p><?php _e('Fancybox is a tool that offers a nice and elegant way to add zooming functionality for images.', HSGPI_TDOMAIN); ?></p>	
		
		<label for="tag-a"><?php _e('Thumbnail width', HSGPI_TDOMAIN); ?></label>
		<select name="hsgpi_thumbwidth" id="hsgpi_thumbwidth">
			<option value='94'>94 px</option>
			<option value='110'>110 px</option>
			<option value='128'>128 px</option>
			<option value='200' selected="selected">200 px</option>
			<option value='220'>220 px</option>
			<option value='288'>288 px</option>
			<option value='320'>320 px</option>
			<option value='400'>400 px</option>
			<option value='512'>512 px</option>
		</select>
		<p><?php _e('Select gallery thumbnail image width.', HSGPI_TDOMAIN); ?></p>			
		
		<label for="tag-a"><?php _e('Fullimage width', HSGPI_TDOMAIN); ?></label>
		<select name="hsgpi_fullwidth" id="hsgpi_fullwidth">
			<option value='320'>320 px</option>
			<option value='400'>400 px</option>
			<option value='512'>512 px</option>
			<option value='576'>576 px</option>
			<option value='640' selected="selected">640 px</option>
			<option value='720'>720 px</option>
			<option value='800'>800 px</option>
			<option value='912'>912 px</option>
		</select>
		<p><?php _e('Select gallery fullimage image width.', HSGPI_TDOMAIN); ?></p>
		
		<label for="tag-a"><?php _e('Controls', HSGPI_TDOMAIN); ?></label>
		<select name="hsgpi_controls" id="hsgpi_controls">
			<option value='true'>YES</option>
			<option value='false'>NO</option>
		</select>
		<p><?php _e('Want to use the Left, Right arrow button in your gallery?', HSGPI_TDOMAIN); ?></p>
		
		<label for="tag-a"><?php _e('Auto interval', HSGPI_TDOMAIN); ?></label>
		<select name="hsgpi_autointerval" id="hsgpi_autointerval">
			<option value='true'>True</option>
			<option value='false'>False</option>
		</select>
		<p><?php _e('Want to add auto interval to move one image from another?', HSGPI_TDOMAIN); ?></p>
		
		<label for="tag-a"><?php _e('Interval time', HSGPI_TDOMAIN); ?></label>
		<input name="hsgpi_intervaltime" type="text" id="hsgpi_intervaltime" value="1500" maxlength="4"  />
		<p><?php _e('Enter auto interval time in millisecond. (Ex: 1500)', HSGPI_TDOMAIN); ?></p>
		
		<label for="tag-a"><?php _e('Animation', HSGPI_TDOMAIN); ?></label>
		<input name="hsgpi_animation" type="text" id="hsgpi_animation" value="1000" maxlength="4" />
		<p><?php _e('Enter animation duration in millisecond. (Ex: 1000)', HSGPI_TDOMAIN); ?></p>
				
      <input name="id" id="id" type="hidden" value="">
      <input type="hidden" name="hsgpi_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button" value="<?php _e('Submit', HSGPI_TDOMAIN); ?>" type="submit" />
        <input name="publish" lang="publish" class="button" onclick="_hsgpi_redirect()" value="<?php _e('Cancel', HSGPI_TDOMAIN); ?>" type="button" />
        <input name="Help" lang="publish" class="button" onclick="_hsgpi_help()" value="<?php _e('Help', HSGPI_TDOMAIN); ?>" type="button" />
      </p>
	  <?php wp_nonce_field('hsgpi_form_add'); ?>
    </form>
</div>
<p class="description"><?php echo HSGPI_OFFICIAL; ?></p>
</div>