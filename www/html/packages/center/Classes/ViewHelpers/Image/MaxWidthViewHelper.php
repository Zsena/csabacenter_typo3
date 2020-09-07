<?php
namespace DigitalZombies\Center\ViewHelpers\Image;

/**
 * Returns a height value.
 */
class MaxWidthViewHelper extends ImageSizeAbstractViewHelper
{
	/**
     * Initialize arguments.
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
    }

	/**
	 * Returns the height of an image taking maximum boundaries into account
	 *
	 * @throws \TYPO3\CMS\Fluid\Core\ViewHelper\Exception
	 * @return integer
	 */
    public function render()
    {
        $sizes = parent::render();

        return isset($sizes['width']) ? $sizes['width'] : 0;
    }
}
