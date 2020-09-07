<?php

namespace DigitalZombies\Center\Controller;

use DigitalZombies\Center\Domain\Model\Center\CenterLevelPosition;
use DigitalZombies\Center\Domain\Model\Misc\Contactperson;
use DigitalZombies\Center\Domain\Model\Misc\Sender;
use DigitalZombies\Center\Domain\Model\Misc\Tag;
use DigitalZombies\Center\Domain\Model\Records\Service;
use DigitalZombies\Center\Domain\Repository\Misc\ContactpersonRepository;
use DigitalZombies\Center\Domain\Repository\Misc\TagRepository;
use DigitalZombies\Center\Domain\Repository\RecordBaseRepository;
use DigitalZombies\Center\Domain\Repository\Records\ServiceRepository;
use DigitalZombies\Center\Service\Page\BodyTitleConfiguration;
use DigitalZombies\Center\Configuration\ScopeConfiguration;
use DigitalZombies\Center\Utility\DirectionHelper;
use DigitalZombies\Center\Utility\Page\PageUtility;
use TYPO3\CMS\Frontend\Page\PageRepository;

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
 * Class ServiceController
 * @package DigitalZombies\Center\Controller
 */
class ServiceController extends MetaTagBaseController
{

	/**
	 * @var \DigitalZombies\Center\Domain\Repository\Misc\ContactpersonRepository
	 */
	protected $contactpersonRepository;

	/**
	 * @var PageRepository
	 */
	protected $pageRepository;

	/**
	 * @var \DigitalZombies\Center\Domain\Repository\Misc\TagRepository
	 */
	protected $tagRepository;

	/**
	 * @var \DigitalZombies\Center\Domain\Repository\RecordBaseRepository
	 */
	protected $recordBaseRepository;


	protected $serviceRepository;

	/**
	 * @param \DigitalZombies\Center\Domain\Repository\Records\ServiceRepository $repository
	 *
	 * @return void
	 */
	public function injectServiceRepository(ServiceRepository $repository)
	{
		$this->serviceRepository = $repository;
	}

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
	 * @param PageRepository $repository
	 *
	 * @return void
	 */
	public function injectPageRepository(PageRepository $repository)
	{
		$this->pageRepository = $repository;
	}

	/**
	 * @param TagRepository $repository
	 *
	 * @return void
	 */
	public function injectTagRepository(TagRepository $repository)
	{
		$this->tagRepository = $repository;
	}

	/**
	 * @param \DigitalZombies\Center\Domain\Repository\RecordBaseRepository $repository
	 *
	 * @return void
	 */
	public function injectRecordBaseRepository(RecordBaseRepository $repository)
	{
		$this->recordBaseRepository = $repository;
	}

	/**
	 * Renders a detail page for Service
	 *
	 * @param Service $service
	 */
	public function showAction(Service $service = null)
	{
		if ($service) {
			$existServiceInCenter = $this->recordBaseRepository->findRecordsByUid(
				ScopeConfiguration::getScope(),
				['tx_center_domain_model_records_service' => $service->getUid()],
				[$service->getUid() => 'tx_center_domain_model_records_service--' . $service->getUid()],
				false,
				'tx_center_domain_model_records_service'
			);

			if ($existServiceInCenter) {
				parent::addCacheTags($service);

				BodyTitleConfiguration::getInstance()->setTitle($service->getName());

				$this->setMetaTags($service);

				$this->view->assign('service', $service);

				if ($service->getSender()->getSenderType() === Sender::SENDER_SHOP) {
					$this->view->assign('directions', DirectionHelper::getDirections());
				}
			} else {
				$this->redirectToUri('404', 0, 404);
			}
		}
	}

	/**
	 * Renders a home teaser plugin with service categories
	 * (These are tags with the service type)
	 *
	 */
	public function listHomeServiceCategoryTeasersAction()
	{

		$teasers = [];

		if (isset($this->settings['hometeaser']['serviceCategoryPages'])) {

			$pageUids = explode(',', $this->settings['hometeaser']['serviceCategoryPages']);

			foreach ($pageUids as $pageUid) {
				$page = $this->pageRepository->getPage($pageUid);
				$page = $this->pageRepository->getPageOverlay($page, $GLOBALS['TSFE']->sys_language_uid);

				if (isset($page['service_tag'])) {
					$tag = $this->tagRepository->findByUid($page['service_tag']);
					$teasers[] = [
						'page' => $page,
						'tag' => $tag
					];
				}
			}
		}

		$this->view->assign('teasers', $teasers);
	}

	/**
	 * Ticket ENXT-1226:
	 * Két új ednpoint kellene: get-services és get-service-categories.
	 * Ezekhez elég sokat kell mókolni, de a legjobb ha rákeresel arra, hogy
	 * getOffers a kódban (screenshot) és az alapján csinálsz egy új getServices megoldást.
	 * A szám amit a RealURLLConfiguration.php-ben meg a typoscript-et tartalmazó
	 * fájlban kel lhasználni lehet a következö:
	 * 1.0.0 => 79876510014
	 * 1.1.0 => 79876511014
	 * 1.0.0-át nem fontos csinálni, de ha úgy egyszerübb, csinálj olyat is nyugodtan. Ha minden jó,
	 * amit írtál ne felejts el All Cache-t törölni a backendben. (piros villámmal a jobb felsö sarokban.)
	 * Ha jó, akkor utána el kell tudnod érni a /epi/1.1.0/cos/get-services url alatt bármelyik centernél.
	 * a get-services-categories kissé bonyolultabb. itt a getShopCategories-ra keresve tudsz mindenképpen
	 * elökészületeket tenni, de a végsö megoldáshoz azért beszélni kéne.
	 */


	/**
	 * Get tags to the shop categories and send a json response
	 *
	 * @return string
	 */
	public function getServiceCategoriesAction(){
		$response['categories'] = [];
		$sorting = 'sorting';
		$field = '*';
		$where = 'AND hidden = 0 AND deleted = 0 AND nav_hide = 0 AND doktype IN (' . Service::LIST_DOKTYPE . ')';

		$level1Pages = $this->pageRepository->getMenu(ScopeConfiguration::getScope()->getPageId());

		foreach ($level1Pages as $parentPage) {
			$pages = $this->pageRepository->getMenu($parentPage['uid'], $field, $sorting, $where);
			$pages = PageUtility::hideNoneTranslated($this->pageRepository->getPagesOverlay($pages, $GLOBALS['TSFE']->sys_language_uid));
			foreach ($pages as $page) {
				if(isset($page['service_tag'])) {
					$category = [
						'uid' => $page['uid'],
						'title' => $page['title'],
						'tags' => ['uid' => $page['service_tag']]
					];
					$response['categories'][] = $category;
				}
			}
		}

		return json_encode($response);
	}

	/**
	 * services
	 *
	 * @return string json
	 */
	public function getServicesAction()
	{
		$response = ['status' => 'unknown'];
		if (ScopeConfiguration::hasCenter()) {
			$uid = ScopeConfiguration::getCenterUid();
			$repository = $this->serviceRepository;
			$serviceRecords = $repository->listAllForCenter($uid);
			$detailLink = '';
			/** @var Service $service */
			foreach ($serviceRecords as $service) {
				if (isset($this->settings['detailPages']['service'])) {
					$detailLink = $this->uriBuilder
						->reset()
						->setTargetPageUid($this->settings['detailPages']['service'])
						->setArguments(['tx_center_service' => [
							'controller' => 'Service',
							'action' => 'show',
							'service' => $service->getUid(),
						]])
						->setCreateAbsoluteUri(true)
						->buildFrontendUri();
				}
				$this->view->assign('service', $service);
				$content = $this->view->render();
				$serviceArray = [
					'uid' => $service->getUid(),
					'name' => $service->getTitle(),
					'datailLink' => $detailLink,
					'description' => trim($content),
					'logo' => $this->processImageAndGetUrl($service->getServiceIcon())
				];
                if (ScopeConfiguration::hasCenter()
                    && ScopeConfiguration::getScope()->isWayfinderActivated()) {
                    // for 3D maps
                    $wayFinderUrl = ScopeConfiguration::getScope()->getWayfinderUrl();
                    $parameters = "&id=" . $service->getUid();
                    $serviceArray['centerPlanLink'] = \UrlCheckUtilityHelper::check( $wayFinderUrl, $parameters );
                    $serviceArray['centerPlanLinkType'] = 2;
                    $serviceArray['positions'] = [];
                } else {
                    /** @var CenterLevelPosition $position */
                    foreach ($service->getPositions() as $position) {
                        if (!$serviceArray['centerPlanLink'] && isset( $this->settings['detailPages']['centerPlan'] )) {
                            $serviceArray['centerPlanLinkType'] = 1;
                            $serviceArray['centerPlanLink'] = $this->uriBuilder
                                ->reset()
                                ->setTargetPageUid( $this->settings['detailPages']['centerPlan'] )
                                ->setArguments( ['location' => $position->getPathID()] )
                                ->setCreateAbsoluteUri( true )
                                ->buildFrontendUri();
                        }
                        $serviceArray['positions'][] = [
                            'id' => $position->getPathID(),
                            'name' => ($position->getCenterLevel() ? $position->getCenterLevel()->getTitle() : ''),
                            'shortName' => ($position->getCenterLevel() ? $position->getCenterLevel()->getShortName() : ''),
                        ];
                    }
                }
                /** @var Tag $tag */
				foreach ($service->getTagIds() as $tag) {
					$serviceArray['tags'][] = [
						'uid' => $tag
					];
				}

				$response['services'][] = $serviceArray;
			}
		}
		return json_encode($response);
	}


}
