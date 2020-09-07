<?php
namespace DigitalZombies\Center\Domain\Model;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
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
 * TeaserInterface
 */
interface TeaserInterface
{
	/**
	 * @return int
	 */
	public function getTeaserFormat(): int;

	/**
	 * @param int $teaserFormat
	 * @return void
	 */
	public function setTeaserFormat(int $teaserFormat);

	/**
	 * @return string
	 */
	public function getTeaserAbstract(): string;

	/**
	 * @param string $teaserAbstract
	 * @return void
	 */
	public function setTeaserAbstract(string $teaserAbstract);

	/**
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	public function getTeaserImage();

	/**
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $logo
	 * @return void
	 */
	public function setTeaserImage(FileReference $logo);

	/**
	 * @return string
	 */
	public function getTitle(): string;

	/**
	 * @param string $title
	 */
	public function setTitle(string $title);

	/**
	 * @return string
	 */
	public function getDescription(): string;

	/**
	 * @param string $description
	 */
	public function setDescription(string $description);

	/**
	 * @return string
	 */
	public function getOgTitle(): string;

	/**
	 * @param string $ogTitle
	 */
	public function setOgTitle(string $ogTitle);

	/**
	 * @return string
	 */
	public function getOgDescription(): string;

	/**
	 * @param string $ogDescription
	 */
	public function setOgDescription(string $ogDescription);

	/**
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	public function getOgImage();
	/**
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $ogImage
	 */
	public function setOgImage(FileReference $ogImage);
}
