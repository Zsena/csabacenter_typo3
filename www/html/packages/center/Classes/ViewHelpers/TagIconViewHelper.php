<?php
namespace DigitalZombies\Center\ViewHelpers;

use DigitalZombies\Center\Utility\SvgReader;
use TYPO3\CMS\Core\Resource\Exception\ResourceDoesNotExistException;
use TYPO3\CMS\Fluid\Core\ViewHelper\Exception;

/**
 * Resizes a given image (if required) and renders the respective img tag
 *
 * = Examples =
 *
 * <code title="Default">
 * <f:image src="EXT:myext/Resources/Public/typo3_logo.png" alt="alt text" />
 * </code>
 * <output>
 * <img alt="alt text" src="typo3conf/ext/myext/Resources/Public/typo3_logo.png" width="396" height="375" />
 * or (in BE mode):
 * <img alt="alt text" src="../typo3conf/ext/viewhelpertest/Resources/Public/typo3_logo.png" width="396" height="375" />
 * </output>
 *
 * <code title="Image Object">
 * <f:image image="{imageObject}" />
 * </code>
 * <output>
 * <img alt="alt set in image record" src="fileadmin/_processed_/323223424.png" width="396" height="375" />
 * </output>
 *
 * <code title="Inline notation">
 * {f:image(src: 'EXT:viewhelpertest/Resources/Public/typo3_logo.png', alt: 'alt text', minWidth: 30, maxWidth: 40)}
 * </code>
 * <output>
 * <img alt="alt text" src="../typo3temp/assets/images/f13d79a526.png" width="40" height="38" />
 * (depending on your TYPO3s encryption key)
 * </output>
 *
 * <code title="Other resource type (e.g. PDF)">
 * <f:image src="fileadmin/user_upload/example.pdf" alt="foo" />
 * </code>
 * <output>
 * If your graphics processing library is set up correctly then it will output a thumbnail of the first page of your PDF document.
 * <img src="fileadmin/_processed_/1/2/csm_example_aabbcc112233.gif" width="200" height="284" alt="foo">
 * </output>
 *
 * <code title="Non-existent image">
 * <f:image src="NonExistingImage.png" alt="foo" />
 * </code>
 * <output>
 * Could not get image resource for "NonExistingImage.png".
 * </output>
 */
class TagIconViewHelper extends SvgViewHelper
{
	/**
     * Initialize arguments.
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
		$this->registerTagAttribute('imageId', 'integer', 'Specifies the Tag object for the icon rendering', true);
    }

    /**
     * Resizes a given image (if required) and renders the respective img tag
     *
     * @see https://docs.typo3.org/typo3cms/TyposcriptReference/ContentObjects/Image/
     *
     * @throws \TYPO3\CMS\Fluid\Core\ViewHelper\Exception
     * @return string Rendered tag
     */
    public function render()
    {
        if (is_null($this->arguments['imageId'])) {
            throw new Exception('You must specify an Image object.', 1382284106);
        }
		$svgData = '';

        try {

            if($this->arguments['imageId']) {

				$image = $this->imageService->getImage($this->arguments['imageId'],$this->arguments['image'], 1);

				$svgData = SvgReader::readSVGFromFAL($image);
				$svgData = SvgReader::cleanSVGCode($svgData);
			}

        } catch (ResourceDoesNotExistException $e) {
            // thrown if file does not exist
        }

        return $svgData;
    }
}
