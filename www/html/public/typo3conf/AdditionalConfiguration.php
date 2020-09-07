<?php

defined('TYPO3_MODE') || die('Access denied.');

$GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename'] =
    '[' . \TYPO3\CMS\Core\Utility\GeneralUtility::getApplicationContext()->__toString() . '] ' .
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename'];

if (\TYPO3\CMS\Core\Utility\GeneralUtility::getApplicationContext()->isDevelopment()) {
    include_once (__DIR__ . '/AdditionalConfiguration.Development.php');
}

if (\TYPO3\CMS\Core\Utility\GeneralUtility::getApplicationContext()->isProduction()) {
    include_once (__DIR__ . '/AdditionalConfiguration.Production.php');
}
