<?php
namespace DigitalZombies\Center\Hooks;

/***************************************************************
 *  Copyright notice
 *
 * 	Based on:
 *
 *  (c) 2017 András Ottó <andras.otto@plan-net.com>
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

use DigitalZombies\Center\Domain\Model\EasterEgg\EasterEgg;
use DigitalZombies\Center\Domain\Repository\EasterEgg\EasterEggRepository;
use DigitalZombies\Center\Configuration\ScopeConfiguration;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

class EasterEggRenderer implements SingletonInterface {

	/**
	 * Renders the EasterEgg in markup
	 *
	 * @param array $params Parameter
	 * @param TypoScriptFrontendController $parent Parent object
	 *
	 * @return void
	 */
	public function contentPostProcAll(array $params, TypoScriptFrontendController &$parent) {
		if(ScopeConfiguration::hasCenter()) {
			/** @var ObjectManager $objectManager */
			$objectManager = GeneralUtility::makeInstance(ObjectManager::class);
			/** @var EasterEggRepository $easterEggRepository */
			$easterEggRepository = GeneralUtility::makeInstance(EasterEggRepository::class, $objectManager);
			/** @var PersistenceManager $persistanceManager */
			$persistanceManager = GeneralUtility::makeInstance(PersistenceManager::class);
			$easterEggRepository->injectPersistenceManager($persistanceManager);


			$easterEggs = $easterEggRepository->findByCenter(ScopeConfiguration::getScope()->getUid());

			/** @var EasterEgg $easterEgg */
			foreach ($easterEggs as $easterEgg) {
				$pages = explode(',', $easterEgg->getPages());
				$wordToHide = $easterEgg->getWordToHide();
				$index = 0;
				$characterToHide = '';
				foreach ($pages as $page) {
					if($page == $GLOBALS['TSFE']->id) {
						$characterToHide =  mb_substr($wordToHide, $index, 1);
					}
					$index++;
					if(strlen($wordToHide) <= $index) {
						break;
					}
				}

				if($characterToHide
					&& $easterEgg->getBaseRule()) {
					//Prepare the image to hide
					$markup = $easterEgg->getBaseRule()->getMarkupToReplace();
					$imageUrl = $easterEgg->getBaseRule()->getImageFolder() . strtolower($characterToHide) . '.png';

					$markup = preg_replace('/###IMAGE_URL###/', $imageUrl, $markup);
					$markup = preg_replace('/###CHARACTER###/', strtoupper($characterToHide), $markup);
					$markersInCode = [];

					preg_match_all('/###EE###/', $parent->content, $markersInCode);
					if(count($markersInCode[0]) > 0) {
						$parent->content = preg_replace('/###EE###/', $markup, $parent->content, 1);
					} else {
						$paragraphs = [];
						$contentBlocks = [];
						preg_match_all('/<section class="tme( content-container)?">.*?<\/section>/is', $parent->content, $contentBlocks);

						if(count($contentBlocks[0]) > 0) {
							foreach ($contentBlocks[0] as $contentBlock) {
								$currentParagraphs = [];
								preg_match_all('/<p( class="bodytext")?>.*?<\/p>.*?/is', $contentBlock, $currentParagraphs);
								if(count($currentParagraphs[0]) > 0) {
									$paragraphs = array_merge($paragraphs, $currentParagraphs[0]);
								}
							}
						}

                        preg_match_all('/<div class="sto-teaser__text">(.*?)<\/div>/is', $parent->content, $contentBlocks);
                        if(count($contentBlocks[1]) > 0) {
                            foreach ($contentBlocks[1] as $contentBlock) {
                                array_push($paragraphs, $contentBlock);
                            }
                        }

						$paragraphCounts = count($paragraphs);
						if($paragraphCounts > 0) {
							$tryCount = 0;
							$selectedSpot = null;
							while($tryCount < 10 && $selectedSpot === null) {
								$selectedParagraphIndex = random_int(0, $paragraphCounts -1);
								$selectedParagraph = $paragraphs[$selectedParagraphIndex];
								$possibleSpots = [];

								$plainText = strip_tags($selectedParagraph,'<p>');
								preg_match_all('/[A-Za-z0-9] [A-Za-z0-9]/', $plainText, $possibleSpots);
								$spotCount = count($possibleSpots[0]);
								if($spotCount > 0) {
									$selectedSpotIndex = random_int(0, $spotCount);
									$selectedSpot = $possibleSpots[0][$selectedSpotIndex];
								}
								$tryCount++;
							}

							if($selectedSpot) {
								$modifiedSpot = preg_replace('/ /', ' ' . $markup . ' ', $selectedSpot);
								$modifiedParagraph = preg_replace('/' . $selectedSpot . '/', $modifiedSpot, $selectedParagraph, 1);

								$parent->content = str_replace($selectedParagraph, $modifiedParagraph, $parent->content);
							}
						}

					}
				}
			}

		}
		$parent->content = preg_replace('/###EE###/', '', $parent->content);
	}
}