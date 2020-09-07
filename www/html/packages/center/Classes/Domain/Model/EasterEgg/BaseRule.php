<?php
namespace DigitalZombies\Center\Domain\Model\EasterEgg;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

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
 * BaseRule
 */
class BaseRule extends AbstractEntity
{
	/**
	 * name
	 *
	 * @var string
	 */
	protected $name = '';

	/**
	 * pages ids (comma separated)
	 *
	 * @var string
	 */
	protected $markupToReplace = '';


	/**
	 * The name of the image folder
	 *
	 * @var string
	 */
	protected $imageFolder = '';

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName(string $name)
	{
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getMarkupToReplace(): string
	{
		return $this->markupToReplace;
	}

	/**
	 * @param string $markupToReplace
	 */
	public function setMarkupToReplace(string $markupToReplace)
	{
		$this->markupToReplace = $markupToReplace;
	}

	/**
	 * @return string
	 */
	public function getImageFolder(): string
	{
		return $this->imageFolder;
	}

	/**
	 * @param string $imageFolder
	 */
	public function setImageFolder(string $imageFolder)
	{
		$this->imageFolder = $imageFolder;
	}
}
