<?php

namespace DigitalZombies\Center\Controller;

use DigitalZombies\Center\Domain\Repository\Misc\IcalRepository;

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
 * Class IcalController
 * @package DigitalZombies\Center\Controller
 */
class IcalController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
	/**
	 * @var \DigitalZombies\Center\Domain\Repository\Misc\IcalRepository
	 */
	protected $icalRepository;

	/**
	 * @param \DigitalZombies\Center\Domain\Repository\Misc\IcalRepository $repository
	 *
	 * @return void
	 */
	public function injectIcalRepository(IcalRepository $repository)
	{
		$this->icalRepository = $repository;
	}

	/**
	 * @return string
	 * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
	 */
	public function showAction()
	{
		$eventData = $this->icalRepository->getEventData($this->request->getArgument('eventUid'));
		$eventData['baseurl'] = $this->request->getBaseUri();
		$eventData['referer'] = substr(str_replace('_', '/',
									str_replace('.', '-',
												$this->request->getArgument('referer')
									)
								),1);

		$this->view->assign('event', $eventData);

		return $this->view->render();
	}
}
