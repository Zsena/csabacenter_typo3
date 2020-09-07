<?php

defined('TYPO3_MODE') || die('Access denied.');

$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['dbname']   = '$DB_NAME';
$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['host']     = '$DB_HOST';
$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['password'] = '$DB_PW';
$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['user']     = '$DB_USER';
$GLOBALS['TYPO3_CONF_VARS']['BE']['installToolPassword']                = '$INSTALL_TOOL_PW';
