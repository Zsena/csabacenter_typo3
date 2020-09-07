<?php

namespace DigitalZombies\Center\ViewHelpers;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

class MinutesToHoursViewHelper extends AbstractViewHelper
{

	/**
	 * Given a number of minutes, format it as hh:mm
	 *
	 * @param int $minutes an amount of minutes
	 *
	 * @return string hh:mm
	 */
	public function render($minutes)
	{
		// if ($minutes % 60 == 0) {
		// 	return round($minutes / 60);
		// } else {
			return round($minutes / 60) . ":" . sprintf("%'.02d", $minutes % 60);
		// }
	}
}

