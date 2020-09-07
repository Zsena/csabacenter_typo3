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
 * TabBarItem
 */
class TabBarIcon extends AbstractEntity
{
	/**
	 * iconName
	 *
	 * @var string
	 */
	protected $iconName = '';

	/**
	 * androidIcon
	 *
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 * @lazy
	 */
	protected $androidIcon = null;

	/**
	 * androidActiveIcon
	 *
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 * @lazy
	 */
	protected $androidActiveIcon = null;

	/**
	 * iosIcon
	 *
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 * @lazy
	 */
	protected $iosIcon = null;

	/**
	 * iosActiveIcon
	 *
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 * @lazy
	 */
	protected $iosActiveIcon = null;

	/**
	 * @return string
	 */
	public function getIconName(): string
	{
		return $this->iconName;
	}

	/**
	 * @param string $iconName
	 */
	public function setIconName(string $iconName)
	{
		$this->iconName = $iconName;
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	public function getAndroidIcon()
	{
		return $this->androidIcon;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $androidIcon
	 */
	public function setAndroidIcon($androidIcon)
	{
		$this->androidIcon = $androidIcon;
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	public function getAndroidActiveIcon()
	{
		return $this->androidActiveIcon;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $androidActiveIcon
	 */
	public function setAndroidActiveIcon($androidActiveIcon)
	{
		$this->androidActiveIcon = $androidActiveIcon;
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	public function getIosIcon()
	{
		return $this->iosIcon;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $iosIcon
	 */
	public function setIosIcon($iosIcon)
	{
		$this->iosIcon = $iosIcon;
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	public function getIosActiveIcon()
	{
		return $this->iosActiveIcon;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $iosActiveIcon
	 */
	public function setIosActiveIcon($iosActiveIcon)
	{
		$this->iosActiveIcon = $iosActiveIcon;
	}

}
