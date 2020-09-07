<?php
namespace DigitalZombies\Center\Domain\Model\Center;

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
 * AppStoreLink
 */
class AppStoreLink extends AbstractEntity
{
	/**
	 * url
	 *
	 * @var string
	 */
	protected $url = '';

	/**
	 * type
	 *
	 * @var integer
	 */
	protected $type = 0;

	/**
	 * @return string
	 */
	public function getUrl()
	{
		return $this->url;
	}

	/**
	 * @param string $url
	 */
	public function setUrl($url)
	{
		$this->url = $url;
	}

	/**
	 * @return int
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * @param int $type
	 */
	public function setType($type)
	{
		$this->type = $type;
	}

}
