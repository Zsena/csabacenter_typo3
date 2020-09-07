<?php

namespace DigitalZombies\Center\UserFunc;

use DigitalZombies\Center\Configuration\ScopeConfiguration;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2017 David Miltz <D.Miltz@plan-net.com>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
class CenterTitle
{
    /**
     * Returns field tta or centername from center record for title tag
     *
     * @return string
     */
    public static function setTitle()
    {
		$result = '';
        if (ScopeConfiguration::getScope()) {
            $result = (ScopeConfiguration::getScope()->getTitlePostfix()) ? $result = ScopeConfiguration::getScope()->getTitlePostfix()
				: ScopeConfiguration::getScope()->getCenterName();
        }
        return " | " . $result;
    }
}
