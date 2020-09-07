<?php

namespace DigitalZombies\Center\ViewHelpers;

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Class BeUserAccessViewHelper
 * @package DigitalZombies\Center\ViewHelpers
 */
class BeUserAccessViewHelper extends AbstractViewHelper
{

	/**
	 * This viewhelper checks if a user may are allowed to see informations about pages.
	 * The check based on the isInWebMount core function
	 *
	 * @param string $uid a page uid
	 *
	 * @throws \TYPO3\CMS\Fluid\Core\ViewHelper\Exception
	 * @return string the watch id
	 */
	public function render($uid)
	{
		$backendUser = $GLOBALS['BE_USER'];
		$pageID = $backendUser->isInWebMount($uid, $backendUser->getPagePermsClause(1));
		return isset($pageID);
	}
}
