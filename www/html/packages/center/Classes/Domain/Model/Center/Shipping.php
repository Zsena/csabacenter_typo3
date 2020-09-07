<?php
namespace DigitalZombies\Center\Domain\Model\Center;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use \TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy;

/**
 * Shipping
 */
class Shipping extends AbstractEntity
{
	/**
	 * text
	 *
	 * @var string
	 */
	protected $text = '';

	/**
	 * link
	 *
	 * @var string
	 */
	protected $link = '';

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $icon = null;

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    public function getIcon()
    {
        if ($this->icon instanceof LazyLoadingProxy) {
            $this->icon->_loadRealInstance();
        }

        return $this->icon;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $icon
     */
    public function setIcon(FileReference $icon)
    {
        $this->icon = $icon;
    }


}
