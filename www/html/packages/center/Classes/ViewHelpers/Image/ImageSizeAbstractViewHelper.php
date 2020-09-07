<?php
namespace DigitalZombies\Center\ViewHelpers\Image;

use TYPO3\CMS\Fluid\Core\ViewHelper\Exception;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Returns a modifier based on the width an height of an image.
 */
abstract class ImageSizeAbstractViewHelper extends AbstractViewHelper
{
	/**
     * Initialize arguments.
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('maxWidth', 'int', 'The maxWidth to resize the image');
        $this->registerArgument('maxHeight', 'int', 'The maxHeight to resize the image');
        $this->registerArgument('imageWidth', 'int', 'The width of an image');
        $this->registerArgument('imageHeight', 'int', 'The height of an image');
    }

	/**
	 * Prepares an array with width and height values
	 *
	 * @throws \TYPO3\CMS\Fluid\Core\ViewHelper\Exception
	 * @return array
	 */
    public function render()
    {
        if (is_null($this->arguments['maxWidth']) || is_null($this->arguments['maxHeight']) ) {
            throw new Exception('You must specify the maxWidth, maxHeight,imageWidth, imageHeight and the height attributes.', 1385555101);
        }

        $maxWidth = (int)$this->arguments['maxWidth'];
		$maxHeight = (int)$this->arguments['maxHeight'];

        $imageWidth = (int)$this->arguments['imageWidth'];
        $imageHeight = (int)$this->arguments['imageHeight'];

        if($maxHeight <= 0 || $maxWidth <= 0 || $imageWidth <= 0 || $imageHeight <= 0 ) {
			throw new Exception('Only integer values bigger then 0 are allowed', 1385555102);
		}

		$imageRatio = (float)($imageWidth / $imageHeight);

        //Image height and width are smaller then the limits
        if($maxWidth >= $imageWidth && $maxHeight >= $imageHeight) {
        	$width = $imageWidth;
			$height = $imageHeight;
			//Image width is bigger then the max, but height is ok
		} else if ($maxWidth < $imageWidth && $maxHeight >= $imageHeight) {
			$width = $maxWidth;
			$height = $width / $imageRatio;
			//Image height is bigger then the max, but width is ok
		} else if ($maxWidth >= $imageWidth && $maxHeight < $imageHeight) {
        	$height = $maxHeight;
        	$width = $imageRatio * $height;
        	//Image height and width are bigger then the max
		} else {
        	//First adjust width
			$width = $maxWidth;
			$height =  $width / $imageRatio;

			//Then check height
			if($height > $maxHeight) {
				$height = $maxHeight;
				$width = $imageRatio * $height;
			}
		}

        return ['width' => $width, 'height' => $height];
    }
}
