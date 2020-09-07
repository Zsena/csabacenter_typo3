<?php
namespace DigitalZombies\Center\Domain\Model\Misc;

use DigitalZombies\Center\Domain\Model\Center\Center;
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
 * Contactperson
 */
class Contactperson extends AbstractEntity
{

	const SHOP = 1;
	const GASTRO = 2;
	const JOBS = 3;
	const CENTER = 4;
	const PRESS = 5;
	const NEWS = 6;
	const BLOG = 7;
	const SERVICE = 8;


	/**
	 * firstName
	 *
	 * @var string
	 */
	protected $firstName = '';

	/**
	 * lastName
	 *
	 * @var string
	 */
	protected $lastName = '';

	/**
	 * title
	 *
	 * @var string
	 */
	protected $title = '';

	/**
	 * function
	 *
	 * @var string
	 */
	protected $function = '';

	/**
	 * phone
	 *
	 * @var string
	 */
	protected $phone = '';

	/**
	 * email
	 *
	 * @var string
	 */
	protected $email = '';

	/**
	 * address
	 *
	 * @var string
	 */
	protected $address = '';

	/**
	 * website
	 *
	 * @var string
	 */
	protected $website = '';

	/**
	 * global
	 *
	 * @var integer
	 */
	protected $global = 0;

	/**
	 * companyName
	 *
	 * @var string
	 */
	protected $companyName = '';

	/**
	 * center
	 *
	 * @var \DigitalZombies\Center\Domain\Model\Center\Center
	 */
	protected $center = null;

	/**
	 * images
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
	 */
	protected $images = null;

	/**
	 * Salutation
	 *
	 * @var integer
	 */
	protected $salutation = '';

	/**
	 * Contactperson constructor.
	 */
	public function __construct()
	{
		$this->images = new ObjectStorage();
	}

	/**
	 * @return string
	 */
	public function getFirstName(): string
	{
		return $this->firstName;
	}

	/**
	 * @param string $firstName
	 */
	public function setFirstName(string $firstName)
	{
		$this->firstName = $firstName;
	}

	/**
	 * @return string
	 */
	public function getLastName(): string
	{
		return $this->lastName;
	}

	/**
	 * @param string $lastName
	 */
	public function setLastName(string $lastName)
	{
		$this->lastName = $lastName;
	}

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
	public function getFunction(): string
	{
		return $this->function;
	}

	/**
	 * @param string $function
	 */
	public function setFunction(string $function)
	{
		$this->function = $function;
	}

	/**
	 * @return string
	 */
	public function getPhone(): string
	{
		return $this->phone;
	}

	/**
	 * @param string $phone
	 */
	public function setPhone(string $phone)
	{
		$this->phone = $phone;
	}

	/**
	 * @return string
	 */
	public function getEmail(): string
	{
		return $this->email;
	}

	/**
	 * @param string $email
	 */
	public function setEmail(string $email)
	{
		$this->email = $email;
	}

	/**
	 * @return string
	 */
	public function getAddress(): string
	{
		return $this->address;
	}

	/**
	 * @param string $address
	 */
	public function setAddress(string $address)
	{
		$this->address = $address;
	}

	/**
	 * @return string
	 */
	public function getWebsite(): string
	{
		return $this->website;
	}

	/**
	 * @param string $website
	 */
	public function setWebsite(string $website)
	{
		$this->website = $website;
	}

	/**
	 * @return int
	 */
	public function getGlobal(): int
	{
		return $this->global;
	}

	/**
	 * @param int $global
	 */
	public function setGlobal(int $global)
	{
		$this->global = $global;
	}

	/**
	 * @return string
	 */
	public function getCompanyName(): string
	{
		return $this->companyName;
	}

	/**
	 * @param string $companyName
	 */
	public function setCompanyName(string $companyName)
	{
		$this->companyName = $companyName;
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
	public function setCenter(Center $center)
	{
		$this->center = $center;
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	public function getImages()
	{
		return $this->images;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $images
	 */
	public function setImages(ObjectStorage $images)
	{
		$this->images = $images;
	}

	/**
	 * @return int
	 */
	public function getSalutation(): int
	{
		return $this->salutation;
	}

	/**
	 * @param int $salutation
	 */
	public function setSalutation(int $salutation)
	{
		$this->salutation = $salutation;
	}
}
