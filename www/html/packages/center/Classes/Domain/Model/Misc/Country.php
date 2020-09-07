<?php
namespace DigitalZombies\Center\Domain\Model\Misc;

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
 * Country
 */
class Country extends AbstractEntity
{
	/**
	 * name
	 *
	 * @var string
	 */
	protected $name = '';

	/**
	 * timezones
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DigitalZombies\Center\Domain\Model\Misc\Timezone>
	 */
	protected $timezones = null;

	/**
	 * Gallery constructor.
	 */
	public function __construct()
	{
		$this->timezones = new ObjectStorage();
	}

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
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	public function getTimezones()
	{
		return $this->timezones;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $timezones
	 */
	public function setTimezones(ObjectStorage $timezones)
	{
		$this->timezones = $timezones;
	}

}
