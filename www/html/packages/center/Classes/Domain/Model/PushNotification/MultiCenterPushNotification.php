<?php

namespace DigitalZombies\Center\Domain\Model\PushNotification;

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2018- Fabian Gehrlicher <f.gehrlicher@plan-net.com>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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

/**
 * Class MultiCenterPushNotification
 * @package DigitalZombies\Center\Domain\Model\PushNotification
 */
class MultiCenterPushNotification extends PushNotification
{
    const TYPE = 2;

    /**
     * Used by fluid
     * @var string
     */
    protected $namespace = self::class;

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }
}
