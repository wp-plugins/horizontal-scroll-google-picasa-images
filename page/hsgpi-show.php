<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php if ( ! empty( $_POST ) && ! wp_verify_nonce( $_REQUEST['wp_create_nonce'], 'hsgpi-show' ) )  { die('<p>Security check failed.</p>'); } ?>
<?php
// Form submitted, check the data
if (isset($_POST['frm_hsgpi_display']) && $_POST['frm_hsgpi_display'] == 'yes')
{
	$did = isset($_GET['did']) ? $_GET['did'] : '0';
	if(!is_numeric($did)) { die('<p>Are you sure you want to do this?</p>'); }
	
	$hsgpi_success = '';
	$hsgpi_success_msg = FALSE;
	
	// First check if ID exist with requested ID
	$result = hsgpi_dbquery::hsgpi_count($did);
	
	if ($result != '1')
	{
		?><div class="error fade"><p><strong><?php _e('Oops, selected details doesnt exist.', 'horizontal-scroll-google-picasa-images'); ?></strong></p></div><?php
	}
	else
	{
		// Form submitted, check the action
		if (isset($_GET['ac']) && $_GET['ac'] == 'del' && isset($_GET['did']) && $_GET['did'] != '')
		{
			//	Just security thingy that wordpress offers us
			check_admin_referer('hsgpi_form_show');
			
			//	Delete selected record from the table
			hsgpi_dbquery::hsgpi_delete($did);
			
			//	Set success message
			$hsgpi_success_msg = TRUE;
			$hsgpi_success = __('Selected record was successfully deleted.', 'horizontal-scroll-google-picasa-images');
		}
	}
	
	if ($hsgpi_success_msg == TRUE)
	{
		?><div class="updated fade"><p><strong><?php echo $hsgpi_success; ?></strong></p></div><?php
	}
}
?>
<div class="wrap">
  <div id="icon-edit" class="icon32 icon32-posts-post"></div>
    <h2><?php _e(HSGPI_PLUGIN_DISPLAY, 'horizontal-scroll-google-picasa-images'); ?>
	<a class="add-new-h2" href="<?php echo HSGPI_ADMINURL; ?>&ac=add"><?php _e('Add New', 'horizontal-scroll-google-picasa-images'); ?></a></h2>
    <div class="tool-box">
	<?php
		$myData = array();
		$myData = hsgpi_dbquery::hsgpi_select(0);
		?>
		<script language="JavaScript" src="<?php echo HSGPI_URL; ?>page/hsgpi-setting.js"></script>
		<form name="frm_hsgpi_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th class="check-column" scope="col" style="padding: 8px 2px;"><input type="checkbox" name="hsgpi_group_item[]" /></th>
			<th scope="col"><?php _e('Title', 'horizontal-scroll-google-picasa-images'); ?></th>
			<th scope="col"><?php _e('Short Code', 'horizontal-scroll-google-picasa-images'); ?></th>
			<th scope="col"><?php _e('Username', 'horizontal-scroll-google-picasa-images'); ?></th>
			<th scope="col"><?php _e('Album Id', 'horizontal-scroll-google-picasa-images'); ?></th>
			<th scope="col"><?php _e('Image Type', 'horizontal-scroll-google-picasa-images'); ?></th>
			<th scope="col"><?php _e('Width', 'horizontal-scroll-google-picasa-images'); ?></th>
            <th scope="col"><?php _e('Height', 'horizontal-scroll-google-picasa-images'); ?></th>
          </tr>
        </thead>
		<tfoot>
          <tr>
            <th class="check-column" scope="col" style="padding: 8px 2px;"><input type="checkbox" name="hsgpi_group_item[]" /></th>
			<th scope="col"><?php _e('Title', 'horizontal-scroll-google-picasa-images'); ?></th>
			<th scope="col"><?php _e('Short Code', 'horizontal-scroll-google-picasa-images'); ?></th>
			<th scope="col"><?php _e('Username', 'horizontal-scroll-google-picasa-images'); ?></th>
			<th scope="col"><?php _e('Album Id', 'horizontal-scroll-google-picasa-images'); ?></th>
			<th scope="col"><?php _e('Image Type', 'horizontal-scroll-google-picasa-images'); ?></th>
			<th scope="col"><?php _e('Thumbnail', 'horizontal-scroll-google-picasa-images'); ?></th>
            <th scope="col"><?php _e('Fullimage', 'horizontal-scroll-google-picasa-images'); ?></th>
          </tr>
        </tfoot>
		<tbody>
			<?php 
			$i = 0;
			if(count($myData) > 0 )
			{
				foreach ($myData as $data)
				{
					?>
					<tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
						<td align="left"><input type="checkbox" value="<?php echo $data['hsgpi_id']; ?>" name="hsgpi_group_item[]"></td>
						<td><?php echo esc_html(stripslashes($data['hsgpi_title'])); ?>
						<div class="row-actions">
						<span class="edit">
						<a title="Edit" href="<?php echo HSGPI_ADMINURL; ?>&ac=edit&amp;did=<?php echo $data['hsgpi_id']; ?>"><?php _e('Edit', 'horizontal-scroll-google-picasa-images'); ?></a> | </span>
						<span class="trash">
						<a onClick="javascript:_hsgpi_delete('<?php echo $data['hsgpi_id']; ?>')" href="javascript:void(0);"><?php _e('Delete', 'horizontal-scroll-google-picasa-images'); ?></a></span> 
						</div>
						</td>
						<td>[hsgpi id="<?php echo $data['hsgpi_id']; ?>"]</td>
						<td><?php echo $data['hsgpi_googleusername']; ?></td>
						<td><?php echo $data['hsgpi_googlealbumid']; ?></td>
						<td><?php echo $data['hsgpi_googleimgtype']; ?></td>
						<td><?php echo $data['hsgpi_thumbwidth']; ?></td>
						<td><?php echo $data['hsgpi_fullwidth']; ?></td>
					</tr>
					<?php 
					$i = $i+1; 
				} 	
			}
			else
			{
				?><tr><td colspan="8" align="center"><?php _e('No records available.', 'horizontal-scroll-google-picasa-images'); ?></td></tr><?php 
			}
			?>
		</tbody>
        </table>
		<?php wp_nonce_field('hsgpi_form_show'); ?>
		<input type="hidden" name="frm_hsgpi_display" value="yes"/>
	  	<input type="hidden" name="wp_create_nonce" id="wp_create_nonce" value="<?php echo wp_create_nonce( 'hsgpi-show' ); ?>"/>
      </form>	
	  <div class="tablenav">
	  <h2>
	  <a class="button add-new-h2" href="<?php echo HSGPI_ADMINURL; ?>&amp;ac=add"><?php _e('Add New', 'horizontal-scroll-google-picasa-images'); ?></a>
	  <a class="button add-new-h2" target="_blank" href="<?php echo HSGPI_FAV; ?>"><?php _e('Help', 'horizontal-scroll-google-picasa-images'); ?></a>
	  </h2>
	  </div>
	  <div style="height:5px"></div>
	<p class="description"><?php echo HSGPI_OFFICIAL; ?></p>
	</div>
</div>