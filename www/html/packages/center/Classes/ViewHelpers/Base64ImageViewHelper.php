<?php
namespace DigitalZombies\Center\ViewHelpers;


use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Imaging\ImageManipulation\CropVariantCollection;
use TYPO3\CMS\Core\Resource\Exception\ResourceDoesNotExistException;
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
class Base64ImageViewHelper extends ImageViewHelper
{
	/**
     * Initialize arguments.
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
    }

    /**
     * Resizes a given image (if required) and renders the respective img tag
     *
     * @see https://docs.typo3.org/typo3cms/TyposcriptReference/ContentObjects/Image/
     *
     * @throws \ImagickException
     * @throws \TYPO3\CMS\Core\Cache\Exception\NoSuchCacheException
     * @throws \TYPO3\CMS\Fluid\Core\ViewHelper\Exception
     * @return string Rendered tag
     */
    public function render()
    {
        if ((is_null($this->arguments['src']) && is_null($this->arguments['image'])) || (!is_null($this->arguments['src']) && !is_null($this->arguments['image']))) {
            throw new Exception('You must either specify a string src or a File object.', 1382284106);
        }
		$base64Image = '';
        try {
        	$cacheIdentifier = md5(sprintf("%s|%s|%s", $this->arguments['src'], $this->arguments['image'], $this->arguments['treatIdAsReference']));

			/** @var CacheManager $cacheManager */
			$cacheManager = $this->objectManager->get(CacheManager::class);

			$imageCache = $cacheManager->getCache('center_base64Image');

			$base64Image = $imageCache->get($cacheIdentifier);
			if(!$base64Image) {
				$image = $this->imageService->getImage($this->arguments['src'], $this->arguments['image'], $this->arguments['treatIdAsReference']);
				$cropString = $this->arguments['crop'];
				if ($cropString === null && $image->hasProperty('crop') && $image->getProperty('crop')) {
					$cropString = $image->getProperty('crop');
				}
				$cropVariantCollection = CropVariantCollection::create((string)$cropString);
				$cropVariant = $this->arguments['cropVariant'] ?: 'default';
				$cropArea = $cropVariantCollection->getCropArea($cropVariant);
				$processingInstructions = [
					'width' => $this->arguments['width'],
					'height' => $this->arguments['height'],
					'minWidth' => $this->arguments['minWidth'],
					'minHeight' => $this->arguments['minHeight'],
					'maxWidth' => $this->arguments['maxWidth'],
					'maxHeight' => $this->arguments['maxHeight'],
					'crop' => $cropArea->isEmpty() ? null : $cropArea->makeAbsoluteBasedOnFile($image),
					'uid' => $image->getUid()
				];
				$processedImage = $this->imageService->applyProcessingInstructions($image, $processingInstructions);

				if($processedImage)
				$imageUri = PATH_site . $processedImage->getStorage()->getConfiguration()['basePath'] . $processedImage->getIdentifier();

				if(file_exists($imageUri)) {
                    $newImage = new \Imagick($imageUri);
                    $width = 16;
                    $height = 16;

                    $processedHeight = intval($processedImage->getProperty('height'));
                    $processedWidth = intval($processedImage->getProperty('width'));
                    if ($processedWidth > 0 && $processedHeight > 0) {
                        $height = intval(ceil($width * $processedHeight / $processedWidth));
                    }

                    $newImage->scaleImage($width, $height);
                    $newImage->stripImage();
                    $newImage->blurImage(3, 1);
                    $newImage->setCompressionQuality(0);
                    $newImage->setResolution(72, 72);

                    $base64Image = 'data:image/' . $processedImage->getExtension() . ';base64,' . base64_encode($newImage->getImageBlob());

                    $imageCache->set($cacheIdentifier, $base64Image);
                }
			}

		} catch (ResourceDoesNotExistException $e) {
            // thrown if file does not exist
        } catch (\UnexpectedValueException $e) {
            // thrown if a file has been replaced with a folder
        } catch (\RuntimeException $e) {
            // RuntimeException thrown if a file is outside of a storage
        } catch (\InvalidArgumentException $e) {
            // thrown if file storage does not exist
        }

        return $base64Image;
    }
}
