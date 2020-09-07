<?php
namespace DigitalZombies\Center\Domain\Model\AppConfig;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

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
 * ExtraNavigationItem
 */
class ExtraNavigationItem extends AbstractEntity
{
	/**
	 * title
	 *
	 * @var string
	 */
	protected $title = '';

	/**
	 * link
	 *
	 * @var string
	 */
	protected $link = '';

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
	 * @return string
	 */
	public function getLink(): string
	{
		return $this->link;
	}

	/**
	 * @param string $link
	 */
	public function setLink(string $link)
	{
		$this->link = $link;
	}

	/**
	 * Returns the model as a specific array to a JSON API
	 *
	 * @return array
	 */
	public function toArray() {
		$output = [];

		$output['sortID'] = 0;
		$output['title'] = $this->getTitle();

		if($this->getLink()) {

			$output['url'] = $GLOBALS['TSFE']->cObj->getTypoLink_URL($this->getLink());
		}

		return $output;
	}
}
