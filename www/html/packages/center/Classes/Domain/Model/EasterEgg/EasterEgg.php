<?php
namespace DigitalZombies\Center\Domain\Model\EasterEgg;

use DigitalZombies\Center\Domain\Model\Center\Center;
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
 * EasterEgg
 */
class EasterEgg extends AbstractEntity
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
	protected $pages = '';


	/**
	 * @var \DigitalZombies\Center\Domain\Model\Center\Center
	 */
	protected $center = null;

	/**
	 * the word to hide in the text
	 *
	 * @var string
	 */
	protected $wordToHide = '';

	/**
	 * The base rule for the easter agg action
	 *
	 * @var \DigitalZombies\Center\Domain\Model\EasterEgg\BaseRule
	 */
	protected $baseRule = null;

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
	public function getPages(): string
	{
		return $this->pages;
	}

	/**
	 * @param string $pages
	 */
	public function setPages(string $pages)
	{
		$this->pages = $pages;
	}

	/**
	 * @return \DigitalZombies\Center\Domain\Model\Center\Center
	 */
	public function getCenter()
	{
		return $this->center;
	}

	/**
	 * @param \DigitalZombies\Center\Domain\Model\Center\Center $center
	 */
	public function setCenter($center)
	{
		$this->center = $center;
	}


	/**
	 * @return string
	 */
	public function getWordToHide(): string
	{
		return $this->wordToHide;
	}

	/**
	 * @param string $wordToHide
	 */
	public function setWordToHide(string $wordToHide)
	{
		$this->wordToHide = $wordToHide;
	}

	/**
	 * @return BaseRule
	 */
	public function getBaseRule()
	{
		return $this->baseRule;
	}

	/**
	 * @param BaseRule $baseRule
	 */
	public function setBaseRule($baseRule)
	{
		$this->baseRule = $baseRule;
	}
}
