<?php

namespace DigitalZombies\Center\ViewHelpers;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

class FilterOpeningHoursViewHelper extends AbstractViewHelper
{

	/**
	 * Filter an array
	 * @param array opening hours
	 * @return array
	 */
	public function render($openingHours)
	{
		return array_filter($openingHours,
			function($day) {
				return ($day['dailyHours'] -> getClosed()) != 1;
			}
		);
	}
}
