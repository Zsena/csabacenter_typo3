<?php
namespace DigitalZombies\Center\Domain\Model\Misc;

use TYPO3\CMS\Extbase\Domain\Model\FileReference;
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
 * Tag
 */
class Tag extends AbstractEntity
{
	/**
	 * name
	 *
	 * @var string
	 */
	protected $title = '';

	/**
	 * center
	 *
	 * @var \DigitalZombies\Center\Domain\Model\Misc\Tag
	 */
	protected $parent = null;

	/**
	 * name
	 *
	 * @var string
	 */
	protected $type = '';

	/**
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	protected $serviceCategoryIcon = null;

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
	 * @return \DigitalZombies\Center\Domain\Model\Misc\Tag
	 */
	public function getParent()
	{
		return $this->parent;
	}

	/**
	 * @param \DigitalZombies\Center\Domain\Model\Misc\Tag $parent
	 */
	public function setParent(Tag $parent)
	{
		$this->parent = $parent;
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	public function getServiceCategoryIcon()
	{
		return $this->serviceCategoryIcon;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $serviceCategoryIcon
	 */
	public function setServiceCategoryIcon(FileReference $serviceCategoryIcon)
	{
		$this->serviceCategoryIcon = $serviceCategoryIcon;
	}

	/**
	 * @return string
	 */
	public function getType(): string
	{
		return $this->type;
	}

	/**
	 * @param string $type
	 */
	public function setType(string $type)
	{
		$this->type = $type;
	}
}
