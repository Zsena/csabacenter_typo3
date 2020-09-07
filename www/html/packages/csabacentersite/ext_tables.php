<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('csabacentersite', 'Configuration/TypoScript', 'Provider Extensions');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile('csabacentersite', 'Configuration/PageTS/pageTS.t3s', 'Provider');

// We need more then 20 subgroups for BE usergroups
$TCA['be_groups']['columns']['subgroup']['config']['maxitems'] = 999;
