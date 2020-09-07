<?php

namespace DigitalZombies\Center\Utility;

use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use DigitalZombies\Center\Domain\Repository\FalRepository;
use \TYPO3\CMS\Core\Resource\FileReference;

/***************************************************************
 *  Copyright notice
 *
 *    Based on:
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
class FalLoader
{
    /**
     * grabs falimage
     * @param int $backgroundImageUid
     * @return \TYPO3\CMS\Core\Resource\FileReference
     */
    public static function getImage($backgroundImageUid)
    {
        /** @var \TYPO3\CMS\Core\Resource\ResourceFactory $resourceFactory */
        $resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
        $backgroundImage = array();
        if (!empty($backgroundImageUid) && is_int($backgroundImageUid)) {
            /** @var \TYPO3\CMS\Core\Resource\FileReference $fileReference */
            $fileReference = $resourceFactory->getFileReferenceObject($backgroundImageUid);
            /** @var \TYPO3\CMS\Core\Resource\FileReference $backgroundImage */
            $backgroundImage = $fileReference->getProperties();
        }
        return $backgroundImage;
    }

    // take pid and search for og:image return FileReference
    /**
     * grabs fileReference for og image from page ect.
     * @param int $pid
     * @param string $tableName
     * @param string $fieldName
     * @return mixed
     */
    public static function getImageReference($pid, $tableName, $fieldName)
    {
        /** @var \TYPO3\CMS\Core\Resource\ResourceFactory $resourceFactory */
        $resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
        $Image = FalRepository::resolveImage($pid, $tableName, $fieldName);
        /** @var \TYPO3\CMS\Core\Resource\FileReference $fileReference */
        if($Image){
            $fileReference = $resourceFactory->getFileReferenceObject($Image['uid']);
        }else{
            return false;
        }
        return $fileReference;
    }
}


?>