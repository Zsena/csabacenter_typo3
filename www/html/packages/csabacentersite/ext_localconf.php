<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

$GLOBALS['TYPO3_CONF_VARS']['FE']['contentRenderingTemplates'][] = 'csabacentersite/Configuration/TypoScript/';

// Register Hook
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = \DigitalZombies\Csabacentersite\Hooks\DataHandler::class;
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_content.php']['extLinkATagParamsHandler'] = \DigitalZombies\Csabacentersite\Hooks\ExternalUrlLinkHandler::class;
$GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['default'] = 'EXT:csabacentersite/Configuration/PageTS/Custom.yaml';