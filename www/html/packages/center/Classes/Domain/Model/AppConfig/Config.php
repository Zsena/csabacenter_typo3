<?php
namespace DigitalZombies\Center\Domain\Model\AppConfig;

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
 * Config
 */
class Config extends AbstractEntity
{
	/**
	 * center
	 *
	 * @var \DigitalZombies\Center\Domain\Model\Center\Center
	 */
	protected $center = '';

	/**
	 * TabBar items
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DigitalZombies\Center\Domain\Model\AppConfig\TabBarItem>
	 */
	protected $tabBarItems = null;

	/**
	 * Alert messages
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DigitalZombies\Center\Domain\Model\AppConfig\AlertMessage>
	 */
	protected $alertMessages = null;

	/**
	 * Native Pages
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DigitalZombies\Center\Domain\Model\AppConfig\NativePage>
	 */
	protected $nativePages = null;

	/**
	 * Extra navigation items
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DigitalZombies\Center\Domain\Model\AppConfig\ExtraNavigationItem>
	 */
	protected $extraNavigationItems = null;

	/**
	 * Service Navigation items
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DigitalZombies\Center\Domain\Model\AppConfig\TabBarItem>
	 */
	protected $metaNavigationItems = null;

    /**
     * stageImage
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @lazy
     */
    protected $stageImage = null;

    /**
     * logo
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @lazy
     */
    protected $logo = null;

	/**
	 * Is this the default configuration?
	 *
	 * @var bool
	 */
	protected $isDefault = false;


	/**
	 * Title for the native pages section
	 *
	 * @var string
	 */
	protected $nativePagesTitle = '';

	public function __construct()
	{
		$this->tabBarItems = new ObjectStorage();
		$this->alertMessages = new ObjectStorage();
		$this->nativePages = new ObjectStorage();
		$this->extraNavigationItems = new ObjectStorage();
		$this->metaNavigationItems = new ObjectStorage();
	}

	/**
	 * @return \DigitalZombies\Center\Domain\Model\Center\Center
	 */
	public function getCenter(): \DigitalZombies\Center\Domain\Model\Center\Center
	{
		return $this->center;
	}

	/**
	 * @param \DigitalZombies\Center\Domain\Model\Center\Center $center
	 */
	public function setCenter(\DigitalZombies\Center\Domain\Model\Center\Center $center)
	{
		$this->center = $center;
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	public function getTabBarItems()
	{
		return $this->tabBarItems;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $tabBarItems
	 */
	public function setTabBarItems(ObjectStorage $tabBarItems)
	{
		$this->tabBarItems = $tabBarItems;
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	public function getAlertMessages()
	{
		return $this->alertMessages;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $alertMessages
	 */
	public function setAlertMessages(ObjectStorage $alertMessages)
	{
		$this->alertMessages = $alertMessages;
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	public function getNativePages()
	{
		return $this->nativePages;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $nativePages
	 */
	public function setNativePages(ObjectStorage $nativePages)
	{
		$this->nativePages = $nativePages;
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	public function getExtraNavigationItems()
	{
		return $this->extraNavigationItems;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $extraNavigationItems
	 */
	public function setExtraNavigationItems(ObjectStorage $extraNavigationItems)
	{
		$this->extraNavigationItems = $extraNavigationItems;
	}

	/**
	 * @return int
	 */
	public function getSysLanguageUid(): int
	{
		return $this->_languageUid;
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	public function getMetaNavigationItems()
	{
		return $this->metaNavigationItems;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $metaNavigationItems
	 */
	public function setMetaNavigationItems(ObjectStorage $metaNavigationItems)
	{
		$this->metaNavigationItems = $metaNavigationItems;
	}

	/**
	 * @return bool
	 */
	public function isDefault(): bool
	{
		return $this->isDefault;
	}

	/**
	 * @param bool $isDefault
	 */
	public function setIsDefault(bool $isDefault)
	{
		$this->isDefault = $isDefault;
	}

	/**
	 * @return string
	 */
	public function getNativePagesTitle(): string
	{
		return $this->nativePagesTitle;
	}

	/**
	 * @param string $nativePagesTitle
	 */
	public function setNativePagesTitle(string $nativePagesTitle)
	{
		$this->nativePagesTitle = $nativePagesTitle;
	}

    /**
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    public function getStageImage()
    {
        return $this->stageImage;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $stageImage
     */
    public function setStageImage($stageImage)
    {
        $this->stageImage = $stageImage;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }
}
