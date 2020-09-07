<?php
namespace DigitalZombies\Center\Mapper;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use DigitalZombies\Center\Domain\Model\Center\Center;
use DigitalZombies\Center\Domain\Model\RecordBase;
use DigitalZombies\Center\Configuration\ScopeConfiguration;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper;

/**
 * A mapper to map database tables configured in $TCA on domain objects.
 */
class RecordBaseDataMapper extends DataMapper
{
    /**
     * Maps the given rows on objects
     *
     * @param string $className The name of the class
     * @param array $rows An array of arrays with field_name => value pairs
     * @param string $tableName Direct specified tableName
	 * @param Center $center A center record
     * @return array An array of objects of the given class
     */
    public function map($className, array $rows, $tableName = '', $center = null)
    {
        $objects = [];

        if(!$center) {
			$center = ScopeConfiguration::getScope();
		}

        foreach ($rows as $row) {
            $translation = null;
            if($GLOBALS['TSFE']->sys_language_uid > 0
				&& $row['sys_language_uid'] == 0) {
				if(!$tableName) {
					$tableName = RecordBase::TABLE_NAME;
				}

				if($tableName) {
					$translation = $GLOBALS['TSFE']->sys_page->getRecordOverlay($tableName,
						$row,
						$GLOBALS['TSFE']->sys_language_content,
						$GLOBALS['TSFE']->sys_language_contentOL
					);
				}

				//Skip records if they are not translated
				if(!$translation) {
					continue;
				} else {
					$row = $translation;
				}
			}
        	$recordBaseObject = $this->mapSingleRow($this->getTargetType($className, $row), $row);
        	if($recordBaseObject instanceof RecordBase) {
			}
            $objects[] = $recordBaseObject;

        }
		unset($center);
        return $objects;
    }


}
