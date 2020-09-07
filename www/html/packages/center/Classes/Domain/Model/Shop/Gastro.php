<?php
namespace DigitalZombies\Center\Domain\Model\Shop;
use DigitalZombies\Center\Domain\Model\Misc\Tag;
use DigitalZombies\Center\Domain\Model\PositionableInterface;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 *
 * This file is part of the "center" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017 David Miltz <d.miltz@plan-net.com>, Plan.Net Pulse
 *
 */


/**
 * Gastro
 *
 * Gastro is a class to map properties from pages with doktype = 134.
 * !!!!This is a page !!!!
 * The record stored in the pages table.
 *
 */
class Gastro extends Shop implements PositionableInterface
{
	/**
	 * Dok type for the page
	 */
	const DOKTYPE = 134;

	/**
	 * Gastro is a Shop, it needs the Shop partial
	 *
	 * @var string
	 */
	protected $partialName = 'Shop';

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<DigitalZombies\Center\Domain\Model\Misc\Tag>
	 */
	protected $gastroTags = null;

    /**
     * @var string
     */
    protected $company = '';

    /**
     * @var string
     */
    protected $address = '';

    /**
     * @var string
     */
    protected $zipCity = '';
	
	/**
	 * Type for tags
	 */
	const TYPE = 134;

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	public function getGastroTags()
	{
		return $this->gastroTags;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $gastroTags
	 */
	public function setGastroTags(ObjectStorage $gastroTags)
	{
		$this->gastroTags = $gastroTags;
	}

	/**
	 * @return string
	 */
	public function getCategory()
	{
		return "gastro";
	}

	/**
	 * Return the tagIds of the shop
	 *
	 * @return array
	 */
	public function getTagIds() {
		if(count($this->tagIds) === 0) {
			$tags = $this->getGastroTags();
			if($this->getChainStoreTags()
				&& $this->getChainStore()) {
				$tags = $this->getChainStore()->getGastroTags();
			}
            if($tags) {
                /** @var Tag $tag */
                foreach ($tags as $tag) {
                    $this->tagIds[] = $tag->getUid();
                }
            }

			//General Tags
			$tags = $this->getTags();
			if($this->getChainStoreTags()
				&& $this->getChainStore()) {
				$tags = $this->getChainStore()->getTags();
			}
			/** @var Tag $tag */
			if($tags) {
                foreach ($tags as $tag) {
                    $this->tagIds[] = $tag->getUid();
                }
            }
		}

		return $this->tagIds;
	}

    /**
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param string $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $adress
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getZipCity()
    {
        return $this->zipCity;
    }

    /**
     * @param string $zipCity
     */
    public function setZipCity($zipCity)
    {
        $this->zipCity = $zipCity;
    }
}
