<?php

namespace DigitalZombies\Center\ViewHelpers;

use DigitalZombies\Center\Utility\OpeningHoursHelper;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Class OpeningHoursTimeFormatViewHelper
 * @package DigitalZombies\Center\ViewHelpers
 *
 * Takes from and to time values and displays them depending on the current language
 */
class OpeningHoursTimeFormatViewHelper extends AbstractViewHelper
{

	/**
	 * @param integer $from
     * @param integer $till
	 * @return null
	 */
	public function render($from, $till)
	{
		return OpeningHoursHelper::formatTime($from, $till);
	}
}
