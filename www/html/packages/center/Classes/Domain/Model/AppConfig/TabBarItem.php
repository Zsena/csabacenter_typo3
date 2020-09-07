<?php
namespace DigitalZombies\Center\Domain\Model\AppConfig;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 *
 * This file is part of the "center" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017 András Ottó <andras.otto@plan-net.com>, Plan.Net Pulse
 *
 */



/**
 * TabBarItem
 */
class TabBarItem extends AbstractEntity
{
	/**
	 * title
	 *
	 * @var string
	 */
	protected $title = '';

	/**
	 * icon
	 *
	 * @var \DigitalZombies\Center\Domain\Model\AppConfig\TabBarIcon
	 */
	protected $icon = null;

	/**
	 * Page Id (Which page should be linked through the button)
	 *
	 * @var int
	 */
	protected $pageId = 0;

	/**
	 * @return string
	 */
	public function getTitle(): string
	{
		return $this->title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle(string $title)
	{
		$this->title = $title;
	}

	/**
	 * @return TabBarIcon
	 */
	public function getIcon(): TabBarIcon
	{
		return $this->icon;
	}

	/**
	 * @param TabBarIcon $icon
	 */
	public function setIcon(TabBarIcon $icon)
	{
		$this->icon = $icon;
	}

	/**
	 * @return int
	 */
	public function getPageId(): int
	{
		return $this->pageId;
	}

	/**
	 * @param int $pageId
	 */
	public function setPageId(int $pageId)
	{
		$this->pageId = $pageId;
	}

	/**
	 * Returns the model as a specific array to a JSON API
	 *
	 * @return array
	 */
	public function toArray() {
		$output = [];
		/** @var ObjectManager $objectManager */
		$objectManager = GeneralUtility::makeInstance(ObjectManager::class);

		/** @var UriBuilder $uriBuilder */
		$uriBuilder = $objectManager->get(UriBuilder::class);

		$output['sortID'] = 0;
		$output['title'] = $this->getTitle();

		if($this->getPageId()) {
			$output['url'] = $uriBuilder->setTargetPageUid($this->getPageId())
				->setArguments(['L' => $this->_languageUid])
				->setCreateAbsoluteUri(true)
				->setLinkAccessRestrictedPages(true)
				->buildFrontendUri();
		}

		if($this->getIcon()) {
			if($this->getIcon()->getAndroidActiveIcon()) {
				$output['iconAndroidActive'] = $GLOBALS['TSFE']->config['config']['absRefPrefix']
					. $this->getIcon()->getAndroidActiveIcon()->getOriginalResource()->getPublicUrl();
			}
			if($this->getIcon()->getAndroidIcon()) {
				$output['iconAndroidInactive'] = $GLOBALS['TSFE']->config['config']['absRefPrefix']
					. $this->getIcon()->getAndroidIcon()->getOriginalResource()->getPublicUrl();
			}
			if($this->getIcon()->getIosActiveIcon()) {
				$output['iconIOSActive'] = $GLOBALS['TSFE']->config['config']['absRefPrefix']
					. $this->getIcon()->getIosActiveIcon()->getOriginalResource()->getPublicUrl();
			}
			if($this->getIcon()->getIosIcon()) {
				$output['iconIOSInactive'] = $GLOBALS['TSFE']->config['config']['absRefPrefix']
					. $this->getIcon()->getIosIcon()->getOriginalResource()->getPublicUrl();
			}
		}

		return $output;
	}
}
