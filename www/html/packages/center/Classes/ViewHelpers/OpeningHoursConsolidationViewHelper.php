<?php

namespace DigitalZombies\Center\ViewHelpers;

use DigitalZombies\Center\Domain\Model\OpeningHours\DailyHours;
use DigitalZombies\Center\Utility\OpeningHoursHelper;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Class OpeningHoursConsolidationViewHelper
 * @package DigitalZombies\Center\ViewHelpers
 *
 * Takes an array of DailyHours Models and consolidates it by
 * grouping those entries that follow each other while having
 * the same from and till values 
 */
class OpeningHoursConsolidationViewHelper extends AbstractViewHelper
{

	/**
     * The resulting array is written to a template variable named 'consolidatedOpeningHours'
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $openingHours
	 * @return void
	 */
	public function render($openingHours)
	{
		$consolidatedOpeningHours = OpeningHoursHelper::consolidateDailyHours($openingHours);

		$this->templateVariableContainer->add('consolidatedOpeningHours', $consolidatedOpeningHours);
	}
}
