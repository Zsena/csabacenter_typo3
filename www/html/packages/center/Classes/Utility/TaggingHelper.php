<?php
namespace DigitalZombies\Center\Utility;

use DigitalZombies\Center\Domain\Model\RecordBase;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/***************************************************************
 *  Copyright notice
 *
 *    Based on:
 *
 *  (c) 2017 András Ottó <andras.otto@plan-net.com>
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


class TaggingHelper
{

	/**
	 * @param string $tableName name of the table
	 * @param array $options Additional configuration options
	 *              + fieldList: field configuration to be added to showitems
	 *              + typesList: list of types that shall visualize the categories field
	 *              + position: insert position of the categories field
	 * 				+ overrideLabel: boolean
	 *  			+ removeLanguageMode: boolean
	 * 				+ displayCond: string or array -> displayCond settings
	 * @param string $fieldName the name of the field (should added to the database table in ext_tables.sql)
	 * @param string $typeName if the type of the tag is not equal with the tablename
	 *
	 * @return void
	 */
	public static function enhanceWithTag($tableName, array $options = [], $fieldName = 'tags', $typeName = '') {

		//Use table name as a default value for types.
		if(!$typeName) {
			$typeName = RecordBase::TYPE;
		}

		self::registerColumn($tableName, $options, $fieldName, $typeName);
		self::addToAllTCAtypes($tableName, $fieldName, $options);

	}

	/**
	 * @param string $tableName name of the table
	 * @param array $options Additional configuration options
	 *              + fieldList: field configuration to be added to showitems
	 *              + typesList: list of types that shall visualize the categories field
	 *              + position: insert position of the categories field
	 * 				+ overrideLabel: boolean
	 * 				+ addTab: boolean
	 * 				+ removeLanguageMode: boolean
	 * @param string $fieldName the name of the field (should added to the database table in ext_tables.sql)
	 * @param string $typeName if the type of the tag is not equal with the tablename
	 *
	 * @return void
	 */
	protected static function registerColumn($tableName, array $options, $fieldName = 'tags', $typeName = '') {
		//Set the label of the BE field, default or a configured: tablename.fieldname
		if(isset($options['overrideLabel'])
			&& $options['overrideLabel']) {
			$label = 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:' . $typeName . '.' . $fieldName;
		} else {
			$label = 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.tags';
		}

		$maxItems = 50;
		if(isset($options['maxItems'])) {
			$maxItems = $options['maxItems'];
		}

		$columns = [
			$fieldName => [
				'label' => $label,
                'pnpu_description' => [
                    'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.tags.infoText',
                    'extensionName' => 'center',
                    'arguments' => [
                        '2',
                        '16:9'
                    ]
                ],
				'l10n_mode' => 'exclude',
				'config' => [
					'minitems' => 0,
					'maxitems' => $maxItems,
					'type' => 'select',
					'renderType' => 'selectTree',
					'foreign_table' => 'tx_center_domain_model_misc_tag',
					'foreign_table_where' => " AND tx_center_domain_model_misc_tag.type = '$typeName' AND tx_center_domain_model_misc_tag.sys_language_uid IN (-1,0) ORDER BY tx_center_domain_model_misc_tag.sorting ASC",
					'treeConfig' => [
						'parentField' => 'parent',
						'appearance' => [
							'expandAll' => true,
							'showHeader' => true,
							'maxLevels' => 99,
						],
					],
					'MM' => 'tx_center_domain_model_misc_tag_record_mm',
					'MM_opposite_field' => 'items',
					'MM_match_fields' => [
						'tablenames' => $tableName,
						'fieldname' => $fieldName,
					],
					'default' => 0
				]
			]
		];

		if(isset($options['displayCond'])) {
			$columns[$fieldName]['displayCond'] = $options['displayCond'];
		}

		if(isset($options['removeLanguageMode'])
			&& $options['removeLanguageMode']) {
			unset($columns[$fieldName]['l10n_mode']);
		}

		if (isset($GLOBALS['TCA'][$tableName]['columns'])) {

			// Add field to interface list per default
			if (!empty($GLOBALS['TCA'][$tableName]['interface']['showRecordFieldList'])
				&& !GeneralUtility::inList($GLOBALS['TCA'][$tableName]['interface']['showRecordFieldList'], $fieldName)
			) {
				$GLOBALS['TCA'][$tableName]['interface']['showRecordFieldList'] .= ',' . $fieldName;
			}

			// Adding fields to an existing table definition
			ExtensionManagementUtility::addTCAcolumns(
				$tableName,
				$columns
			);
		}
	}

	/**
	 * Add a new field into the TCA types -> showitem
	 *
	 * @param string $tableName Name of the table to be categorized
	 * @param string $fieldName Name of the field to be used to store categories
	 * @param array $options Additional configuration options
	 *              + fieldList: field configuration to be added to showitems
	 *              + typesList: list of types that shall visualize the categories field
	 *              + position: insert position of the categories field
	 *              + withoutTab: boolean  (default false)
	 */
	protected static function addToAllTCAtypes($tableName, $fieldName, array $options)
	{

		// Makes sure to add more TCA to an existing structure
		if (isset($GLOBALS['TCA'][$tableName]['columns'])) {
			if (empty($options['fieldList'])) {
				$fieldList = self::addTaggingTab($fieldName, $options);
			} else {
				$fieldList = $options['fieldList'];
			}

			$typesList = '';
			if (isset($options['typesList']) && $options['typesList'] !== '') {
				$typesList = $options['typesList'];
			}

			$position = '';
			if (!empty($options['position'])) {
				$position = $options['position'];
			}

			// Makes the new "categories" field to be visible in TSFE.
			ExtensionManagementUtility::addToAllTCAtypes($tableName, $fieldList, $typesList, $position);
		}
	}

	/**
	 * Creates the 'fieldList' string for $fieldName which includes a categories tab.
	 * But only one categories tab is added per table.
	 *
	 * @param string $fieldName
	 * @param array $options Additional configuration options
	 *              + withoutTab: boolean 	(default false)
	 * @return string
	 */
	protected static function addTaggingTab($fieldName, $options)
	{
		if(isset($options['withoutTab'])
			&& $options['withoutTab']) {
			return $fieldName;
		} else {
			return '--div--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.tabs.tags, ' . $fieldName;
		}
	}
}