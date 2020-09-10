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
     * Initialize arguments.
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('till', 'string', 'Till time');
        $this->registerArgument('from', 'string', 'From time');
    }
	/**
	 * @return null
	 */
	public function render()
	{
	    $from = $this->arguments['from'];
	    $till = $this->arguments['till'];
		return OpeningHoursHelper::formatTime($from, $till);
	}
}
