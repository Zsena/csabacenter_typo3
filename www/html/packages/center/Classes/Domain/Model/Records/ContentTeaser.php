<?php
namespace DigitalZombies\Center\Domain\Model\Records;
use DigitalZombies\Center\Domain\Model\Center\Center;
use DigitalZombies\Center\Domain\Model\RecordBase;
use TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy;


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
 * ContentTeaser
 */
class ContentTeaser extends RecordBase
{
	const TYPE = 'tx_center_domain_model_records_contentteaser';


	/**
	 * Table name in the database
	 */
	const TABLE_NAME = self::TYPE;

	/**
	 * @var string
	 */
	protected $partialName = 'ContentTeaser';

	/**
	 * @var \DigitalZombies\Center\Domain\Model\Center\Center
	 * @lazy
	 */
	protected $center = null;

	/**
	 * @var string
	 */
	protected $link = '';

    /**
     * @var string
     */
    protected $label = '';

	/**
	 * @var bool
	 */
	protected $isFallbackTeaser = false;

	/**
	 * @return \DigitalZombies\Center\Domain\Model\Center\Center
	 */
	public function getCenter()
	{
		if ($this->center instanceof LazyLoadingProxy) {
			$this->center->_loadRealInstance();
		}
		return $this->center;
	}

	/**
	 * @param Center $center
	 */
	public function setCenter(Center $center)
	{
		$this->center = $center;
	}

	/**
	 * @return string
	 */
	public function getLink(): string
	{
		return $this->link;
	}

	/**
	 * @param string $link
	 */
	public function setLink(string $link)
	{
		$this->link = $link;
	}

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label)
    {
        $this->label = $label;
    }

	/**
	 * @return bool
	 */
	public function isFallbackTeaser(): bool
	{
		return $this->isFallbackTeaser;
	}

	/**
	 * @param bool $isFallbackTeaser
	 */
	public function setIsFallbackTeaser(bool $isFallbackTeaser)
	{
		$this->isFallbackTeaser = $isFallbackTeaser;
	}
}
