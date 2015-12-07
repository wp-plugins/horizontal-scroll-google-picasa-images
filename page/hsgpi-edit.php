<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php if ( ! empty( $_POST ) && ! wp_verify_nonce( $_REQUEST['wp_create_nonce'], 'hsgpi-edit' ) )  { die('<p>Security check failed.</p>'); } ?>
<div class="wrap">
<?php
$did = isset($_GET['did']) ? $_GET['did'] : '0';
if(!is_numeric($did)) { die('<p>Are you sure you want to do this?</p>'); }

// First check if ID exist with requested ID
$result = '0';
$result = hsgpi_dbquery::hsgpi_count($did);

if ($result != '1')
{
	?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist.', 'horizontal-scroll-google-picasa-images'); ?></strong></p></div><?php
}
else
{
	$hsgpi_errors = array();
	$hsgpi_success = '';
	$hsgpi_error_found = FALSE;
	
	$data = array();
	$data = hsgpi_dbquery::hsgpi_select($did);
	
	// Preset the form fields
	$form = array(
		'hsgpi_id' => $data[0]['hsgpi_id'],
		'hsgpi_title' => $data[0]['hsgpi_title'],
		'hsgpi_thumbwidth' => $data[0]['hsgpi_thumbwidth'],
		'hsgpi_fullwidth' => $data[0]['hsgpi_fullwidth'],
		'hsgpi_controls' => $data[0]['hsgpi_controls'],
		'hsgpi_autointerval' => $data[0]['hsgpi_autointerval'],
		'hsgpi_intervaltime' => $data[0]['hsgpi_intervaltime'],
		'hsgpi_animation' => $data[0]['hsgpi_animation'],
		'hsgpi_random' => $data[0]['hsgpi_random'],
		'hsgpi_arrowcolor' => $data[0]['hsgpi_arrowcolor'],
		'hsgpi_googleusername' => $data[0]['hsgpi_googleusername'],
		'hsgpi_googlealbumid' => $data[0]['hsgpi_googlealbumid'],
		'hsgpi_googleimgtype' => $data[0]['hsgpi_googleimgtype'],
		'hsgpi_googleimgcount' => $data[0]['hsgpi_googleimgcount'],
		'hsgpi_fancybox' => $data[0]['hsgpi_fancybox'],
		'hsgpi_extra2' => $data[0]['hsgpi_extra2'],
		'hsgpi_extra3' => $data[0]['hsgpi_extra3']
	);
}
// Form submitted, check the data
if (isset($_POST['hsgpi_form_submit']) && $_POST['hsgpi_form_submit'] == 'yes')
{
	//	Just security thingy that wordpress offers us
	check_admin_referer('hsgpi_form_add');
	
	$form['hsgpi_googleusername'] = isset($_POST['hsgpi_googleusername']) ? $_POST['hsgpi_googleusername'] : '';
	if ($form['hsgpi_googleusername'] == '')
	{
		$hsgpi_errors[] = __('Enter google plus username.', 'horizontal-scroll-google-picasa-images');
		$hsgpi_error_found = TRUE;
	}
	
	$form['hsgpi_googlealbumid'] = isset($_POST['hsgpi_googlealbumid']) ? $_POST['hsgpi_googlealbumid'] : '';
	if ($form['hsgpi_googlealbumid'] == '')
	{
		$hsgpi_errors[] = __('Enter google plus album id.', 'horizontal-scroll-google-picasa-images');
		$hsgpi_error_found = TRUE;
	}
	
	$form['hsgpi_title'] = isset($_POST['hsgpi_title']) ? $_POST['hsgpi_title'] : '';
	if ($form['hsgpi_title'] == '')
	{
		$hsgpi_errors[] = __('Enter title for your gallery.', 'horizontal-scroll-google-picasa-images');
		$hsgpi_error_found = TRUE;
	}
	
	$form['hsgpi_intervaltime'] = isset($_POST['hsgpi_intervaltime']) ? $_POST['hsgpi_intervaltime'] : '';
	if ($form['hsgpi_intervaltime'] == '')
	{
		$hsgpi_errors[] = __('Enter auto interval time in millisecond. (Ex: 1500)', 'horizontal-scroll-google-picasa-images');
		$hsgpi_error_found = TRUE;
	}
	
	$form['hsgpi_animation'] = isset($_POST['hsgpi_animation']) ? $_POST['hsgpi_animation'] : '';
	if ($form['hsgpi_animation'] == '')
	{
		$hsgpi_errors[] = __('Enter animation duration in millisecond. (Ex: 1000)', 'horizontal-scroll-google-picasa-images');
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
		$hsgpi_errors[] = __('Number of photos, below 20 is recommended count.', 'horizontal-scroll-google-picasa-images');
		$hsgpi_error_found = TRUE;
	}
	
	//	No errors found, we can add this Group to the table
	if ($hsgpi_error_found == FALSE)
	{
		$action = hsgpi_dbquery::hsgpi_act($form, "ups");
		if($action == "sus")
		{
			$hsgpi_success = __('Details was successfully updated.', 'horizontal-scroll-google-picasa-images');
		}
		elseif($action == "err")
		{
			$hsgpi_success = __('Oops unexpected error occurred.', 'horizontal-scroll-google-picasa-images');
			$hsgpi_error_found = TRUE;
		}
	}
}

if ($hsgpi_error_found == TRUE && isset($hsgpi_errors[0]) == TRUE)
{
	?><div class="error fade"><p><strong><?php echo $hsgpi_errors[0]; ?></strong></p></div><?php
}
if ($hsgpi_error_found == FALSE && strlen($hsgpi_success) > 0)
{
	?>
	<div class="updated fade">
		<p><strong><?php echo $hsgpi_success; ?> 
		<a href="<?php echo HSGPI_ADMINURL; ?>"><?php _e('Click here', 'horizontal-scroll-google-picasa-images'); ?></a> 
		<?php _e('to view the details', 'horizontal-scroll-google-picasa-images'); ?></strong></p>
	</div>
	<?php
}
?>
<script language="JavaScript" src="<?php echo HSGPI_URL; ?>page/hsgpi-setting.js"></script>
<div class="form-wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
	<h2><?php _e(HSGPI_PLUGIN_DISPLAY, 'horizontal-scroll-google-picasa-images'); ?></h2>
	<form name="hsgpi_form" method="post" action="#" onsubmit="return _hsgpi_submit()"  >
      <h3><?php _e('Edit details', 'horizontal-scroll-google-picasa-images'); ?></h3>
      
	  	<label for="tag-a"><?php _e('Google+ User ID', 'horizontal-scroll-google-picasa-images'); ?></label>
		<input name="hsgpi_googleusername" type="text" id="hsgpi_googleusername" value="<?php echo $form['hsgpi_googleusername']; ?>" size="30" maxlength="150" />
		<p><?php _e('Enter your google plus user name.', 'horizontal-scroll-google-picasa-images'); ?></p>
		
		<label for="tag-a"><?php _e('Google+ Album ID', 'horizontal-scroll-google-picasa-images'); ?></label>
		<input name="hsgpi_googlealbumid" type="text" id="hsgpi_googlealbumid" value="<?php echo $form['hsgpi_googlealbumid']; ?>" size="30" maxlength="150" />
		<p><?php _e('Enter google plus album id. Click link for help making albums public. ', 'horizontal-scroll-google-picasa-images'); ?></p>
		
		<label for="tag-a"><?php _e('Gallery title', 'horizontal-scroll-google-picasa-images'); ?></label>
		<input name="hsgpi_title" type="text" id="hsgpi_title" value="<?php echo $form['hsgpi_title']; ?>" size="50" maxlength="255" />
		<p><?php _e('Enter title for your gallery.', 'horizontal-scroll-google-picasa-images'); ?></p>
		
		<label for="tag-a"><?php _e('Image type', 'horizontal-scroll-google-picasa-images'); ?></label>
		<select name="hsgpi_googleimgtype" id="hsgpi_googleimgtype">
			<option value='cropped' <?php if($form['hsgpi_googleimgtype'] == 'cropped') { echo "selected='selected'" ; } ?>>Cropped</option>
			<option value='uncropped' <?php if($form['hsgpi_googleimgtype'] == 'uncropped') { echo "selected='selected'" ; } ?>>Uncropped</option>
		</select>
		<p><?php _e('Select your image type for gallery.', 'horizontal-scroll-google-picasa-images'); ?></p>
		
		<label for="tag-a"><?php _e('Number of photos', 'horizontal-scroll-google-picasa-images'); ?></label>
		<input name="hsgpi_googleimgcount" type="text" id="hsgpi_googleimgcount" value="<?php echo $form['hsgpi_googleimgcount']; ?>" maxlength="3" />
		<p><?php _e('Number of photos, below 20 is recommended count.', 'horizontal-scroll-google-picasa-images'); ?></p>
		
		<label for="tag-a"><?php _e('Fancybox', 'horizontal-scroll-google-picasa-images'); ?></label>
		<select name="hsgpi_fancybox" id="hsgpi_fancybox">
			<option value='YES' <?php if($form['hsgpi_fancybox'] == 'YES') { echo "selected='selected'" ; } ?>>YES</option>
			<option value='NO' <?php if($form['hsgpi_fancybox'] == 'NO') { echo "selected='selected'" ; } ?>>NO</option>
		</select>
		<p><?php _e('Fancybox is a tool that offers a nice and elegant way to add zooming functionality for images.', 'horizontal-scroll-google-picasa-images'); ?></p>
		
		<label for="tag-a"><?php _e('Thumbnail width', 'horizontal-scroll-google-picasa-images'); ?></label>
		<select name="hsgpi_thumbwidth" id="hsgpi_thumbwidth">
			<option value='94' <?php if($form['hsgpi_thumbwidth'] == '94') { echo "selected='selected'" ; } ?>>94 px</option>
			<option value='110' <?php if($form['hsgpi_thumbwidth'] == '110') { echo "selected='selected'" ; } ?>>110 px</option>
			<option value='128' <?php if($form['hsgpi_thumbwidth'] == '128') { echo "selected='selected'" ; } ?>>128 px</option>
			<option value='200' <?php if($form['hsgpi_thumbwidth'] == '200') { echo "selected='selected'" ; } ?>>200 px</option>
			<option value='220' <?php if($form['hsgpi_thumbwidth'] == '220') { echo "selected='selected'" ; } ?>>220 px</option>
			<option value='288' <?php if($form['hsgpi_thumbwidth'] == '288') { echo "selected='selected'" ; } ?>>288 px</option>
			<option value='320' <?php if($form['hsgpi_thumbwidth'] == '320') { echo "selected='selected'" ; } ?>>320 px</option>
			<option value='400' <?php if($form['hsgpi_thumbwidth'] == '400') { echo "selected='selected'" ; } ?>>400 px</option>
			<option value='512' <?php if($form['hsgpi_thumbwidth'] == '512') { echo "selected='selected'" ; } ?>>512 px</option>
		</select>
		<p><?php _e('Select gallery thumbnail image width.', 'horizontal-scroll-google-picasa-images'); ?></p>			
		
		<label for="tag-a"><?php _e('Fullimage width', 'horizontal-scroll-google-picasa-images'); ?></label>
		<select name="hsgpi_fullwidth" id="hsgpi_fullwidth">
			<option value='320' <?php if($form['hsgpi_fullwidth'] == '320') { echo "selected='selected'" ; } ?>>320 px</option>
			<option value='400' <?php if($form['hsgpi_fullwidth'] == '400') { echo "selected='selected'" ; } ?>>400 px</option>
			<option value='512' <?php if($form['hsgpi_fullwidth'] == '512') { echo "selected='selected'" ; } ?>>512 px</option>
			<option value='576' <?php if($form['hsgpi_fullwidth'] == '576') { echo "selected='selected'" ; } ?>>576 px</option>
			<option value='640' <?php if($form['hsgpi_fullwidth'] == '640') { echo "selected='selected'" ; } ?>>640 px</option>
			<option value='720' <?php if($form['hsgpi_fullwidth'] == '720') { echo "selected='selected'" ; } ?>>720 px</option>
			<option value='800' <?php if($form['hsgpi_fullwidth'] == '800') { echo "selected='selected'" ; } ?>>800 px</option>
			<option value='912' <?php if($form['hsgpi_fullwidth'] == '912') { echo "selected='selected'" ; } ?>>912 px</option>
		</select>
		<p><?php _e('Select gallery fullimage image width.', 'horizontal-scroll-google-picasa-images'); ?></p>
		
		<label for="tag-a"><?php _e('Controls', 'horizontal-scroll-google-picasa-images'); ?></label>
		<select name="hsgpi_controls" id="hsgpi_controls">
			<option value='true' <?php if($form['hsgpi_controls'] == 'true') { echo "selected='selected'" ; } ?>>YES</option>
			<option value='false' <?php if($form['hsgpi_controls'] == 'false') { echo "selected='selected'" ; } ?>>NO</option>
		</select>
		<p><?php _e('Want to use the Left, Right arrow button in your gallery?', 'horizontal-scroll-google-picasa-images'); ?></p>
		
		<label for="tag-a"><?php _e('Auto interval', 'horizontal-scroll-google-picasa-images'); ?></label>
		<select name="hsgpi_autointerval" id="hsgpi_autointerval">
			<option value='true' <?php if($form['hsgpi_autointerval'] == 'true') { echo "selected='selected'" ; } ?>>True</option>
			<option value='false' <?php if($form['hsgpi_autointerval'] == 'false') { echo "selected='selected'" ; } ?>>False</option>
		</select>
		<p><?php _e('Want to add auto interval to move one image from another?', 'horizontal-scroll-google-picasa-images'); ?></p>
		
		<label for="tag-a"><?php _e('Interval time', 'horizontal-scroll-google-picasa-images'); ?></label>
		<input name="hsgpi_intervaltime" type="text" id="hsgpi_intervaltime" value="<?php echo $form['hsgpi_intervaltime']; ?>" maxlength="4"  />
		<p><?php _e('Enter auto interval time in millisecond. (Ex: 1500)', 'horizontal-scroll-google-picasa-images'); ?></p>
		
		<label for="tag-a"><?php _e('Animation', 'horizontal-scroll-google-picasa-images'); ?></label>
		<input name="hsgpi_animation" type="text" id="hsgpi_animation" value="<?php echo $form['hsgpi_animation']; ?>" maxlength="4" />
		<p><?php _e('Enter animation duration in millisecond. (Ex: 1000)', 'horizontal-scroll-google-picasa-images'); ?></p>	  
		
      <input name="hsgpi_id" id="hsgpi_id" type="hidden" value="<?php echo $form['hsgpi_id']; ?>">
      <input type="hidden" name="hsgpi_form_submit" value="yes"/>
      <p class="submit">
        <input name="publish" lang="publish" class="button" value="<?php _e('Submit', 'horizontal-scroll-google-picasa-images'); ?>" type="submit" />
        <input name="publish" lang="publish" class="button" onclick="_hsgpi_redirect()" value="<?php _e('Cancel', 'horizontal-scroll-google-picasa-images'); ?>" type="button" />
        <input name="Help" lang="publish" class="button" onclick="_hsgpi_help()" value="<?php _e('Help', 'horizontal-scroll-google-picasa-images'); ?>" type="button" />
      </p>
	  <?php wp_nonce_field('hsgpi_form_add'); ?>
	  <input type="hidden" name="wp_create_nonce" id="wp_create_nonce" value="<?php echo wp_create_nonce( 'hsgpi-edit' ); ?>"/>
    </form>
</div>
<p class="description"><?php echo HSGPI_OFFICIAL; ?></p>
</div>