<?php
namespace DigitalZombies\Center\ViewHelpers;


use DigitalZombies\Center\Utility\SvgReader;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Resource\Exception\ResourceDoesNotExistException;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\Exception;
use \TYPO3\CMS\Fluid\ViewHelpers\ImageViewHelper;

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
class SvgViewHelper extends ImageViewHelper
{

	const MODE_INLINE = 1;
	const MODE_SPRITE = 2;

	protected $mode = self::MODE_INLINE;

	/**
     * Initialize arguments.
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
		$this->registerArgument('path', 'string', 'The folder where the file placed');
		$this->registerArgument('name', 'string', 'The filename of a file in the folder, defined by path');
		$this->registerArgument('mode', 'string', 'inline/sprite - it defines the rendering mode of the svg icon');
		$this->registerArgument('aria-hidden', 'string', 'aria hidden attribute');
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
        if ((is_null($this->arguments['src']) && is_null($this->arguments['name']) && is_null($this->arguments['path']) && is_null($this->arguments['image'])) || (!is_null($this->arguments['src']) && !is_null($this->arguments['image']))) {
            throw new Exception('You must either specify a string src or a File object or a "name" with a "path"', 1382284106);
        }
		$svgData = '';

        try {
        	if(!is_null($this->arguments['mode'])) {
        		if($this->arguments['mode'] === "sprite") {
        			$this->mode = self::MODE_SPRITE;
				}
			}

			/** @var CacheManager $cacheManager */
			$cacheManager = GeneralUtility::makeInstance(CacheManager::class);

			$svgIconCache = $cacheManager->getCache('center_svgIcons');

			$cacheIdentifier = hash('md5', sprintf('%s|%s|%s|%s|%s|%s|%s|%s', $this->arguments['name'],
				$this->arguments['path'],
				$this->arguments['mode'],
				$this->arguments['src'],
				$this->arguments['class'],
				$this->arguments['aria-hidden'],
				$this->arguments['treatIdAsReference'],
				$this->arguments['image']));

			$svgData = $svgIconCache->get($cacheIdentifier);

			if(!$svgData) {
				if($this->mode === self::MODE_SPRITE) {
					$svgData = $this->renderSVGSpriteReference();
				} else {
					$svgData = $this->renderInlineSVG();
				}

				$svgIconCache->set($cacheIdentifier, $svgData);
			}

		} catch (ResourceDoesNotExistException $e) {
            // thrown if file does not exist
        }

        return $svgData;
    }

	/**
	 * Returns an inline svg
	 *
	 * @return string
	 */
    protected function renderInlineSVG() {
    	$svgData = '';
		if(!is_null($this->arguments['name']) || !is_null($this->arguments['path'])) {

			if(is_null($this->arguments['name']) || is_null($this->arguments['path'])) {
				throw new Exception('You must specify both name and path if one is defined', 1382284106);
			}

			$path= rtrim($this->arguments['path'], '/') . '/';
			$name = strpos($this->arguments['name'], '.svg') !== false ? $this->arguments['name'] : ($this->arguments['name'] . '.svg');

			$filePath = GeneralUtility::getFileAbsFileName($path . $name);

			$svgData = SvgReader::readSVGFile($filePath);

		} else {
			$image = $this->imageService->getImage($this->arguments['src'], $this->arguments['image'], $this->arguments['treatIdAsReference']);

			if ($image) {
				$svgData = SvgReader::readSVGFromFAL($image);
			}
		}

		if(!is_null($this->arguments['class'])) {
			if(strpos($svgData, '<svg class="') === false) {
				$svgData = preg_replace(
					'/<svg/',
					'<svg class="' . htmlspecialchars($this->arguments['class']) . '"',
					$svgData
				);
			}
		}

		if(!is_null($this->arguments['aria-hidden'])) {
			if(strpos($svgData, 'aria-hidden="') === false) {
				$svgData = preg_replace(
					'/<svg/',
					'<svg aria-hidden="' . htmlspecialchars($this->arguments['aria-hidden']) . '"',
					$svgData
				);
			}
		}

		$svgData = SvgReader::cleanSVGCode($svgData);

		return $svgData;
	}

	/**
	 * Returns an svg reference with xlink:href
	 *
	 * @return string
	 */
	protected function renderSVGSpriteReference() {
		if(is_null($this->arguments['name']) || is_null($this->arguments['path'])) {
			throw new Exception('You must specify both name and path if one is defined', 1382284106);
		}
		$svgData = '';

    	$class = !is_null($this->arguments['class']) ?
			(' class="'. htmlspecialchars($this->arguments['class']) . '"'): '';
    	$ariaHidden = !is_null($this->arguments['aria-hidden']) ?
			(' aria-hidden="'. htmlspecialchars($this->arguments['aria-hidden']) . '"'): '';

    	//The id inside the sprite
    	$name = $this->arguments['name'];

    	//The filepath of the sprite
    	$path = $this->arguments['path'];

		$filePath = GeneralUtility::getFileAbsFileName($path);

		if(file_exists($filePath)) {
			$relativePath = PathUtility::getAbsoluteWebPath($filePath);
			$svgData = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"' . $class . $ariaHidden . '>';
			$svgData .= '<use xlink:href="' . $relativePath . '#' . $name . '"/>';
			$svgData .= '</svg>';
		}

		return $svgData;
	}
}
