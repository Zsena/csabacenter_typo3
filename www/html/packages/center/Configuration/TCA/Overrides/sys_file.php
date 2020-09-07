<?php
/**
 * Created by PhpStorm.
 * User: ottoan
 * Date: 26.06.17
 * Time: 10:59
 */

$additionalColumns = [
	'tx_center_svg_processed' => [
		'config' => [
			'type' => 'passthrough',
		],
	],
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
	'sys_file',
	$additionalColumns
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
	'sys_file',
	'tx_center_svg_processed'
);