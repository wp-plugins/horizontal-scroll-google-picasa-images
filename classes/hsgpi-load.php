<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
class hsgpi_loadgallery
{
	public static function hsgpi_widget($arr)
	{
		if ( ! is_array( $arr ) )
		{
			return '';
		}
		
		$imageli = "";
		$hsgpi = "";
		$id = isset($arr['id']) ? $arr['id'] : '0';
		$data = array();
		$data = hsgpi_dbquery::hsgpi_select($id);
		if( count($data) > 0 )
		{
			$form_gallery = array(
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
			$hsgpi_width = $form_gallery["hsgpi_thumbwidth"]; 	// Value reassiged below foor loop
			$hsgpi_height = $form_gallery["hsgpi_thumbwidth"]; 	// Value reassiged below foor loop
			$hsgpi_controls = $form_gallery["hsgpi_controls"];
			$hsgpi_autointerval = $form_gallery["hsgpi_autointerval"];
			$hsgpi_intervaltime = $form_gallery["hsgpi_intervaltime"];
			$hsgpi_animation = $form_gallery["hsgpi_animation"];
			$hsgpi_width1 = $hsgpi_width + 4;  	// Value reassiged below foor loop
			$hsgpi_height1 = $hsgpi_height + 4; // Value reassiged below foor loop
			
			$hsgpi_googleusername = $form_gallery["hsgpi_googleusername"];
			$hsgpi_googlealbumid = $form_gallery["hsgpi_googlealbumid"];
			$hsgpi_googleimgtype = $form_gallery["hsgpi_googleimgtype"];
			$hsgpi_thumbwidth = $form_gallery["hsgpi_thumbwidth"];
			$hsgpi_fullwidth = $form_gallery["hsgpi_fullwidth"];
			$hsgpi_googleimgcount = $form_gallery["hsgpi_googleimgcount"];
			$hsgpi_fancybox = $form_gallery["hsgpi_fancybox"];
			
			if(!is_numeric($hsgpi_googleimgcount))
			{
				$hsgpi_googleimgcount = 20;
			}
			
			$image = array();
			$album = new hsgpi_googlealbum();
			$album->setUserId($hsgpi_googleusername);
			$album->setAlbumId($hsgpi_googlealbumid);
			$album->setMaxImg($hsgpi_googleimgcount);
			
			if($hsgpi_googleimgtype == "cropped")
			{
				$thumbSize = "s" . $hsgpi_thumbwidth . "-c";
				$bigSize = "s" . $hsgpi_fullwidth . "-c";
			}
			else
			{
				$thumbSize = "w". $hsgpi_thumbwidth;
				$bigSize = "w". $hsgpi_fullwidth;
			}
			
			
			$loadalbum = $album->getAlbum($thumbSize, $bigSize);

			if (count($loadalbum) > 0)
			{
				if($loadalbum && ($loadalbum['images']['total'] > 0))
				{
					$i = 0;
					foreach($loadalbum['images']['media'] as $image)
					{					
						if($i == 0)
						{
							$size = getimagesize($image['thumbnails'][$thumbSize]);
							if($size > 0)
							{
								$hsgpi_width = $size[0];
								$hsgpi_height = $size[1];
								$hsgpi_width1 = $hsgpi_width + 6;
								$hsgpi_height1 = $hsgpi_height + 6;
							}
						}
						
						$imageli = $imageli . '<li>';
						if($hsgpi_fancybox == "YES")
						{
							$imageli = $imageli . '<a id="hsgpi" href="'. $image['thumbnails'][$bigSize] .'" target="_target" title="'. $image['summary'] .'">';
						}
						$imageli = $imageli . '<img alt="'. $image['summary'] .'" src="'. $image['thumbnails'][$thumbSize] .'" />';
						if($hsgpi_fancybox == "YES")
						{
							$imageli = $imageli . '</a>';
						}
						$imageli = $imageli . '</li>';
						$i = $i + 1;
					}
					
					if($imageli <> "")
					{
						$hsgpi = $hsgpi . "<style type='text/css' media='screen'>
						#hsgpi_id { height: 1%; margin: 30px 0 0; overflow:hidden; position: relative; padding: 0 50px 10px;   }
						#hsgpi_id .viewport { height: ".$hsgpi_height1."px; overflow: hidden; position: relative; }
						#hsgpi_id .buttons { background: #C01313; border-radius: 35px; display: block; position: absolute;
						top: 40%; left: 0; width: 35px; height: 35px; color: #fff; font-weight: bold; text-align: center; line-height: 35px; text-decoration: none;
						font-size: 22px; }
						#hsgpi_id .next { right: 0; left: auto;top: 40%; }
						#hsgpi_id .buttons:hover{ color: #C01313;background: #fff; }
						#hsgpi_id .disable { visibility: hidden; }
						#hsgpi_id .overview { list-style: none; position: absolute; padding: 0; margin: 0; width: ".$hsgpi_width1."px; left: 0 top: 0; }
						#hsgpi_id .overview li{ float: left; margin: 0 20px 0 0; padding: 1px; height: ".$hsgpi_height."px; border: 1px solid #dcdcdc; width: ".$hsgpi_width."px;}
						</style>";
					
						$hsgpi = $hsgpi . '<div id="hsgpi_id">';
							$hsgpi = $hsgpi . '<a class="buttons prev" href="#">&#60;</a>';
							$hsgpi = $hsgpi . '<div class="viewport">';
								$hsgpi = $hsgpi . '<ul class="overview">';
									$hsgpi = $hsgpi . $imageli;
								$hsgpi = $hsgpi . '</ul>';
							$hsgpi = $hsgpi . '</div>';
							$hsgpi = $hsgpi . '<a class="buttons next" href="#">&#62;</a>';
						$hsgpi = $hsgpi . '</div>';
						
						$hsgpi = $hsgpi . '<script type="text/javascript">';
						$hsgpi = $hsgpi . 'jQuery(document).ready(function(){';
							$hsgpi = $hsgpi . "jQuery('#hsgpi_id').tinycarousel({ buttons: ".$hsgpi_controls.", interval: ".$hsgpi_autointerval.", intervalTime: ".$hsgpi_intervaltime.", animationTime: ".$hsgpi_animation." });";
						$hsgpi = $hsgpi . '});';
						$hsgpi = $hsgpi . '</script>';
						
						if($hsgpi_fancybox == "YES")
						{
							$hsgpi = $hsgpi.'<script type="text/javascript"> ';
							$hsgpi = $hsgpi.' jQuery(document).ready(function() { ';
								$hsgpi = $hsgpi.' jQuery("a#hsgpi").fancybox({ ';
								$hsgpi = $hsgpi." 'titlePosition': 'inside' ";
								$hsgpi = $hsgpi." });";
							$hsgpi = $hsgpi." }); ";
							$hsgpi = $hsgpi."</script> ";
						}
					}
				}
			}
			else
			{
				$hsgpi = $hsgpi."<br>Problem showing album.<br>";
				$hsgpi = $hsgpi."1. Please recheck your google user id : ". $hsgpi_googleusername . "<br>";
				$hsgpi = $hsgpi."2. Please recheck your album id : " . $hsgpi_googlealbumid. "<br>";
				$hsgpi = $hsgpi."3. Please confirm whether this google plus album is public album (visible to everyone).<br>";
				$hsgpi = $hsgpi."4. ". HSGPI_OFFICIAL . "<br>";	
			}
		}
		else
		{
			$hsgpi = __('Please check your short code. Gallery does not exists for this Id.', HSGPI_TDOMAIN);
		}		
		return $hsgpi;
	}
}

function hsgpi_shortcode( $atts ) 
{
	if ( ! is_array( $atts ) )
	{
		return '';
	}
	//[hsgpi id="1"]
	$id = isset($atts['id']) ? $atts['id'] : '0';
	
	$arr = array();
	$arr["id"] 	= $id;
	return hsgpi_loadgallery::hsgpi_widget($arr);
}

function gmwfb( $id = "" )
{
	$arr = array();
	$arr["id"] 	= $id;
	echo hsgpi_loadgallery::hsgpi_widget($arr);
}
?>