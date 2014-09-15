<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
class hsgpi_googlealbum 
{
	protected $userId = false;
	protected $albumId = false;
	protected $imageSchema = 'http://a9.com/-/spec/opensearchrss/1.0/';
	protected $photoSchema = 'http://schemas.google.com/photos/2007';
	protected $photoMediaSchema = 'http://search.yahoo.com/mrss/';
	
	public function __construct() 
	{
	
	}
	
	public function setUserId($userId = false) 
	{
		if(($userId !== false) && is_string($userId)) 
		{
			$this->userId = $userId;
		}
	}
	
	public function setAlbumId($albumId = false) 
	{
		if(($albumId !== false) && is_string($albumId)) 
		{
			$this->albumId = $albumId;
		}
	}
	
	public function setMaxImg($setMaxImg = 20) 
	{
		if(is_numeric($setMaxImg))
		{
			$this->setMaxImg = $setMaxImg;
		}
		else
		{
			$this->setMaxImg = 20;
		}
	}
	
	private function validateIdentifiers() 
	{
		if(($this->userId === false) || !preg_match('/^([a-z0-9]+)$/', $this->userId)) 
		{
			return false;
		}
	
		if(($this->albumId === false) || !preg_match('/^([0-9]+)$/', $this->albumId)) 
		{
			return false;
		}
		return true;
	}
	
	public function getAlbum($thumbSize, $bigSize) 
	{
		$album = array();
		if(!$this->validateIdentifiers()) 
		{
			$errorMsg = 'Please provide a valid User and Album ID';
			return $album;
		}
	
		// build album url
		$feedUrl = sprintf('http://picasaweb.google.com/data/feed/api/user/%s/albumid/%s?kind=photo&access=public&max-results=%s', 
						$this->userId, $this->albumId, $this->setMaxImg);
		
		//echo $feedUrl;
		
		// read feed data into SimpleXML object
		$sxml = @simplexml_load_file($feedUrl);
		if($sxml===FALSE) 
		{
			return $album;
		}
		else
		{
			
		}
		
		// get image counts
		$imageCount = $sxml->children($this->imageSchema);
		
		$album = array(
			'title'     => (string) $sxml->title,
			'thumbnail' => (string) $sxml->icon,
			'images'    => array(
			'total' 	=> (string) $imageCount->totalResults,
			'media' 	=> array()
			)
		);
		
		foreach($sxml->entry as $entry) 
		{
			$photoData  = $entry->children($this->photoSchema);
			$photoMedia = $entry->children($this->photoMediaSchema);
			$thumbnail  = $photoMedia->group->thumbnail[1]->attributes()->{'url'};
			$thumbnails = $this->getMediaUrls($thumbnail, $thumbSize, $bigSize);
			
			$album['images']['media'][] = array(
				'title'        => (string) $entry->title,
				'summary'      => (string) $entry->summary,
				'description'  => (string) $entry->description,
				'commentCount' => (string) $photoData->commentCount,
				'width'        => (string) $photoData->width,
				'height'       => (string) $photoData->height,
				'size'         => (string) $photoData->size,
				'published'    => (string) $photoData->timestamp,
				'thumbnails'   => $thumbnails
				);
		}
		
		return $album;
	}
	
	private function getMediaUrls($url = false, $thumbSize = 'w200', $bigSize = 'w640') 
	{
		$thumbnails = array('origin' => (string) $url);
		
		//$mediaSizes = array('s200-c','s400-c','w200','w400');		
		$mediaSizes = array($thumbSize,$bigSize);
		
		$subject = $url;
		$pattern = '/^(.*)(\/s144\/)(.*)/';
		preg_match($pattern, $subject, $matches);
		
		if(isset($matches) && (count($matches) === 4)) 
		{
			foreach($mediaSizes as $media) 
			{
				$thumbnails[$media] = $matches[1] . '/' . $media . '/' . $matches[3];
			}
		}
		return $thumbnails;
	}
}
?>