<?php

namespace DigitalZombies\Center\Controller;

use Esolut\Esolutdev\Utility\DebuggerUtility;
use DigitalZombies\Center\Domain\Model\Project\Reference;
use DigitalZombies\Center\Domain\Repository\Project\ReferenceRepository;
use DigitalZombies\Center\Service\Page\BodyTitleConfiguration;

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
 * Class ReferenceController
 * @package DigitalZombies\Center\Controller
 */
class ReferenceController extends MetaTagBaseController
{


	/**
	 * @var \DigitalZombies\Center\Domain\Repository\Project\ReferenceRepository
	 */
	protected $referenceRepository;


	/**
	 * @param \DigitalZombies\Center\Domain\Repository\Project\ReferenceRepository $repository
	 *
	 * @return void
	 */
	public function injectReferenceRepository(ReferenceRepository $repository)
	{
		$this->referenceRepository = $repository;
	}

    /**
     * @param Reference|null $reference
     */
	public function showAction(Reference $reference = null)
	{
		if ($reference) {

            $this->configurationManager->getContentObject()->stdWrap_addPageCacheTags('', [
                'addPageCacheTags' => 'tx_center_domain_model_project_reference_post_' . $reference->getUid()
            ]);

            BodyTitleConfiguration::getInstance()->setTitle($reference->getTitle());

            $this->setMetaTags($reference);

            $this->view->assign('reference', $reference);
		}
	}

    /**
     *
     */
    public function teaserAction()
    {
        $referenceUids = [];
        $sortedReferences = [];
        $tagUids = [];

        if(isset($this->settings['referencesTeaser']['references']) && $this->settings['referencesTeaser']['references']) {
            $selectedReferences = preg_split('/,/', $this->settings['referencesTeaser']['references']);
            foreach ($selectedReferences as $referenceId) {
                $referenceUids[] = (int)$referenceId;
                $sortedReferences[$referenceId] = 0;
            }
            $references = $this->referenceRepository->findByUids($referenceUids);
        }
        else if(isset($this->settings['referencesTeaser']['specTags']) && $this->settings['referencesTeaser']['specTags']) {
            $selectedTags = preg_split('/,/', $this->settings['referencesTeaser']['specTags']);
            foreach ($selectedTags as $tagId) {
                $tagUids[] = (int)$tagId;
            }
            $references = $this->referenceRepository->findByTags($tagUids);
        }
        else {
            $references = $this->referenceRepository->findAll();
        }


        if(count($sortedReferences) > 0) {
            /** @var Reference $reference */
            foreach ($references as $reference) {
                if (isset($sortedReferences[$reference->getUid()])) {
                    $sortedReferences[$reference->getUid()] = $reference;
                }
            }
        } else {
            $sortedReferences = $references;
        }

        $this->view->assign('references', $sortedReferences);
    }
}
