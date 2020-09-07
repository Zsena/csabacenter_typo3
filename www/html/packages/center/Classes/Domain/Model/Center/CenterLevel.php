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
 * CenterLevel
 */
class CenterLevel extends AbstractEntity
{

	/**
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	protected $image = null;

	/**
	 * @var string
	 */
	protected $title = '';

	/**
	 * @var \DigitalZombies\Center\Domain\Model\Center\Center
	 */
	protected $center = null;

	/**
	 * @var string
	 */
	protected $shortName = '';

	/**
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	public function getImage()
	{
		return $this->image;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
	 */
	public function setImage($image)
	{
		$this->image = $image;
	}

	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	}

	/**
	 * @return Center
	 */
	public function getCenter()
	{
		return $this->center;
	}

	/**
	 * @param Center $center
	 */
	public function setCenter($center)
	{
		$this->center = $center;
	}

	/**
	 * @return string
	 */
	public function getShortName(): string
	{
		return $this->shortName;
	}

	/**
	 * @param string $shortName
	 */
	public function setShortName(string $shortName)
	{
		$this->shortName = $shortName;
	}

	/**
	 * @return string
	 */
	public function getLabel() {

		if($this->getShortName()) {
			return $this->getTitle() . ' (' . $this->getShortName() . ')';
		} else {
			return $this->getTitle();
		}
	}
}
