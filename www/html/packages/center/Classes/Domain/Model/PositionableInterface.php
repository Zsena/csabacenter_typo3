<?php
namespace DigitalZombies\Center\Domain\Model;

use DigitalZombies\Center\Domain\Model\Center\Center;

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
 * PositionableInterface
 */
interface PositionableInterface
{
	/**
	 * @return Center
	 */
	public function getCenter();

	/**
	 * @param Center $center
	 * @return void
	 */
	public function setCenter(Center $center);

	/**
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference|null
	 */
	public function getThumbnail();

	/**
	 * @return string
	 */
	public function getName(): string;

	public function getDescription();
	public function getCategory();
}
