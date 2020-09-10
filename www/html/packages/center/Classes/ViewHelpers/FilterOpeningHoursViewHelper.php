<?php

namespace DigitalZombies\Center\ViewHelpers;
use TYPO3\CMS\Extbase\Persistence\Generic\LazyObjectStorage;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

class FilterOpeningHoursViewHelper extends AbstractViewHelper
{
    /**
     * Initialize arguments.
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('openingHours', 'array', 'Opening hours array');
    }
	/**
	 * Filter an array
	 * @param array opening hours
	 * @return array
	 */
	public function render()
	{
	    $openingHours = $this->arguments['openingHours'];
		return array_filter($openingHours,
			function($day) {
				return ($day['dailyHours'] -> getClosed()) != 1;
			}
		);
	}
}
