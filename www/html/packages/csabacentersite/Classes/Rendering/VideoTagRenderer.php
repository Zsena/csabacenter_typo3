<?php
namespace DigitalZombies\Csabacentersite\Rendering;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Core\Resource\FileInterface;
use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Service\ImageService;

/**
 * Class VideoTagRenderer
 */
class VideoTagRenderer extends \TYPO3\CMS\Core\Resource\Rendering\VideoTagRenderer
{
    /**
     * Render for given File(Reference) HTML output
     *
     * @param FileInterface $file
     * @param int|string $width TYPO3 known format; examples: 220, 200m or 200c
     * @param int|string $height TYPO3 known format; examples: 220, 200m or 200c
     * @param array $options controls = TRUE/FALSE (default TRUE), autoplay = TRUE/FALSE (default FALSE), loop = TRUE/FALSE (default FALSE)
     * @param bool $usedPathsRelativeToCurrentScript See $file->getPublicUrl()
     * @return string
     */
    public function render(FileInterface $file, $width, $height, array $options = [], $usedPathsRelativeToCurrentScript = false)
    {

    	$videoTag = parent::render($file, $width, $height, $options, $usedPathsRelativeToCurrentScript);
    	$videoUrl = preg_replace('/\.mp4$/', '.jpg', $file->getPublicUrl($usedPathsRelativeToCurrentScript));

    	if($videoUrl
			&& file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $videoUrl)) {

    		/** @var  $objectManager */
    		$objectManager = GeneralUtility::makeInstance(ObjectManager::class);
    		/** @var ImageService $imageService */
    		$imageService = $objectManager->get(ImageService::class);
			$image = $imageService->getImage($videoUrl, null, false);
			$processingInstructions = [
				'width' => $width,
				'height' => $height
			];
			$processedImage = $imageService->applyProcessingInstructions($image, $processingInstructions);
			$imageUri = $imageService->getImageUri($processedImage, true);

			$videoTag = preg_replace('/><source/', sprintf(' poster="%s"><source', $imageUri), $videoTag, 1);
		}

    	return $videoTag;
    }
}
