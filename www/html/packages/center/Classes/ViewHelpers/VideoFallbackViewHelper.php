<?php
namespace DigitalZombies\Center\ViewHelpers;

use TYPO3\CMS\Extbase\Service\ImageService;
use TYPO3\CMS\Core\Resource\FileInterface;
use TYPO3\CMS\Core\Resource\FileReference;

/**
 * Return a string (json) that represents a picture element.
 * The json contains an (optional) list of sources and the img tag
 * It has the format {"sources": [], "img": {"src": "...", "alt": "...."}}
 *
 * The viewhelper is mainly designed to provide the fallback data-picture
 * attribute of the video teaser (see lazy-load.js)
 */
class VideoFallbackViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper
{
  public function initializeArguments()
	{
		$this->registerArgument('image', 'object', 'image', true);
	}

  /**
   * @return string
   */
	public function render()
	{
		if(!$this->arguments['image']) {
			return;
		}

		$imageService = $this->objectManager->get(ImageService::class);
		$image = $imageService->getImage('', $this->arguments['image'], false);
		$imageUri = $imageService->getImageUri($image);
		$str = '
		{
			"sources": [],
			"img": {"src":"'.$imageUri.'", "alt": "alt string"}
		}';

		return $str;
	}
}

?>
