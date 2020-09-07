<?php

namespace DigitalZombies\Center\Controller;

use DigitalZombies\Center\Domain\Model\Misc\Contactperson;
use DigitalZombies\Center\Domain\Model\Misc\Sender;
use DigitalZombies\Center\Domain\Model\Records\Job;
use DigitalZombies\Center\Domain\Repository\Misc\ContactpersonRepository;
use DigitalZombies\Center\Domain\Repository\RecordBaseRepository;
use DigitalZombies\Center\Service\Page\BodyTitleConfiguration;
use DigitalZombies\Center\Configuration\ScopeConfiguration;
use DigitalZombies\Center\Utility\DirectionHelper;

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
class JobController extends MetaTagBaseController
{

	/**
	 * @var \DigitalZombies\Center\Domain\Repository\Misc\ContactpersonRepository
	 */
	protected $contactpersonRepository;

	/**
	 * @var \DigitalZombies\Center\Domain\Repository\RecordBaseRepository
	 */
	protected $recordBaseRepository;

	/**
	 * @param \DigitalZombies\Center\Domain\Repository\Misc\ContactpersonRepository $repository
	 *
	 * @return void
	 */
	public function injectContactpersonRepository(ContactpersonRepository $repository)
	{
		$this->contactpersonRepository = $repository;
	}

	/**
	 * @param \DigitalZombies\Center\Domain\Repository\Records\RecordBaseRepository $repository
	 *
	 * @return void
	 */
	public function injectRecordBaseRepository(RecordBaseRepository $repository)
	{
		$this->recordBaseRepository = $repository;
	}

	/**
	 * Renders a detail page for Job
	 *
	 * @param Job $job
	 */
	public function showAction(Job $job = null)
	{
		if ($job) {
			$existJobInCenter = $this->recordBaseRepository->findRecordsByUid(
				ScopeConfiguration::getScope(),
				['tx_center_domain_model_records_job' => $job->getUid()],
				[$job->getUid() => 'tx_center_domain_model_records_job--' . $job->getUid()],
				false,
				'tx_center_domain_model_records_job'
			);

			if ($existJobInCenter || $job->isPreview()) {
				parent::addCacheTags($job);

				BodyTitleConfiguration::getInstance()->setTitle($job->getTitle());

				$this->setMetaTags($job);

				$this->view->assign('job', $job);

				if ($job->getSender()->getSenderType() === Sender::SENDER_CENTER) {
					$this->view->assign('directions', DirectionHelper::getDirections());
				}
			} else {
				$this->redirectToUri('404', 0, 404);
			}
		}
	}
}
