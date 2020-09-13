<?php

namespace DigitalZombies\Center\Controller;

use DigitalZombies\Center\Controller\Base\RecordBaseBaseController;
use DigitalZombies\Center\Domain\Model\Misc\MetaTagEntity;
use DigitalZombies\Center\Domain\Model\RecordBase;
use DigitalZombies\Center\Service\Page\MetaTagConfiguration;
use TYPO3\CMS\Extbase\Mvc\Web\Response;
use DigitalZombies\Center\Utility\FalLoader;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2017
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Class JobController
 * @package DigitalZombies\Center\Controller
 */
class MetaTagBaseController extends RecordBaseBaseController
{

    /**
     * @var Response
     */
    protected $response;

    /**
     * @param MetaTagEntity $recordBase
     */
    protected function setMetaTags(MetaTagEntity $recordBase)
    {

        //Social Media Title, fallback to title if not set.
        $socialMediaTitle = $recordBase->getOgTitle() ?
            $recordBase->getOgTitle() : $recordBase->getTitle();

        //Social Media Description, fallback to description if not set.
        $socialMediaDescription = $recordBase->getOgDescription() ?
            $recordBase->getOgDescription() : $recordBase->getDescription();

        $socialMediaImageUrl = "";

        //Social medai image
        $image = $recordBase->getOgImage();

        if ($image
            && $image->getOriginalResource()
        ) {
            $socialMediaImageUrl = $image->getOriginalResource()->getPublicUrl();
        }else{
            $imagePage = FalLoader::getImageReference( $GLOBALS['TSFE']->page['uid'], "pages", "og_image");
            if($imagePage && $imagePage->getPublicUrl()){
                $socialMediaImageUrl=$imagePage->getPublicUrl();
            }
        }

        //OpenGraph settings
        $this->addOGMetaTag('description', $socialMediaDescription);
        $this->addOGMetaTag('title', $socialMediaTitle);
        if($socialMediaImageUrl){
            $this->addOGMetaTag('image', $socialMediaImageUrl);
        }

        //Twitter Card Settings
        $this->addTwitterMetaTag('card', 'summary_large_image');
        $this->addTwitterMetaTag('description', $socialMediaDescription);
        $this->addTwitterMetaTag('title', $socialMediaDescription);
        $this->addTwitterMetaTag('image', $socialMediaImageUrl);

        //Meta Description
        if ($recordBase->getSeoDescription()) {
            $this->addMetaTag('description', $recordBase->getSeoDescription());
        } else {
            // Fallback to detailpage description if no seo description is available
            $this->addMetaTag('description', $recordBase->getDescription());
        }
        if ($recordBase->getSeoTitle()) {
            $this->addMetaTag('title', $recordBase->getSeoTitle());
        } else {

            $this->addMetaTag('title', $recordBase->getTitle());
        }
    }

    /**
     * Adds an og: metatag to the markup
     * @param string $tagName
     * @param string $value
     */
    private function addOGMetaTag($tagName, $value)
    {
        if ($value !== "") {
            MetaTagConfiguration::getInstance()->setMetaTag('og:' . htmlspecialchars($tagName),
                '<meta property="og:' . htmlspecialchars($tagName) . '" content="' . htmlspecialchars($value) . '"/>');
        }
    }

    /**
     * Adds an twitter: metatag to the markup
     * @param string $tagName
     * @param string $value ^
     */
    private function addTwitterMetaTag($tagName, $value)
    {
        if ($value !== "") {
            MetaTagConfiguration::getInstance()->setMetaTag('twitter:' . htmlspecialchars($tagName),
                '<meta property="twitter:' . htmlspecialchars($tagName) . '" content="' . htmlspecialchars($value) . '"/>');
        }
    }

    /**
     * Adds a metatag to the markup
     * @param string $tagName
     * @param string $value
     */
    private function addMetaTag($tagName, $value)
    {
        if ($value !== "") {
            MetaTagConfiguration::getInstance()->setMetaTag(htmlspecialchars($tagName),
                '<meta name="' . htmlspecialchars($tagName) . '" content="' . htmlspecialchars($value) . '"/>');
        }
    }

    public function addCacheTags(RecordBase $recordBaseObject) {
		$this->configurationManager->getContentObject()->stdWrap_addPageCacheTags('', [
			'addPageCacheTags' => $recordBaseObject::TYPE . '_post_' . $recordBaseObject->getUid()
		]);
	}
}