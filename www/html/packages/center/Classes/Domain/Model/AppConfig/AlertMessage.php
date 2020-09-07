<?php
namespace DigitalZombies\Center\Domain\Model\AppConfig;

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
 * AlertMessage
 */
class AlertMessage extends AbstractEntity
{
	/**
	 * title
	 *
	 * @var string
	 */
	protected $title = '';

	/**
	 * bodyText
	 *
	 * @var string
	 */
	protected $bodyText = '';

	/**
	 * internalTitle
	 *
	 * @var string
	 */
	protected $internalTitle = '';

	/**
	 * alert ID
	 *
	 * @var int
	 */
	protected $alertId = '';

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
	public function getBodyText(): string
	{
		return $this->bodyText;
	}

	/**
	 * @param string $bodyText
	 */
	public function setBodyText(string $bodyText)
	{
		$this->bodyText = $bodyText;
	}

	/**
	 * @return int
	 */
	public function getAlertId(): int
	{
		return $this->alertId;
	}

	/**
	 * @param int $alertId
	 */
	public function setAlertId(int $alertId)
	{
		$this->alertId = $alertId;
	}


	/**
	 * @return string
	 */
	public function getInternalTitle(): string
	{
		return $this->internalTitle;
	}

	/**
	 * @param string $internalTitle
	 */
	public function setInternalTitle(string $internalTitle)
	{
		$this->internalTitle = $internalTitle;
	}

	/**
	 * Returns the model as a specific array to a JSON API
	 *
	 * @return array
	 */
	public function toArray() {
		$output = [];

		$output['alertId'] = $this->getAlertId();
		$output['title'] = $this->getTitle();
		$output['message'] = $this->getBodyText();

		return $output;
	}

}
