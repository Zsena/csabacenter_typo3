<?php

defined('TYPO3_MODE') || die('Access denied.');

$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['dbname']   = '$DB_NAME';
$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['host']     = '$DB_HOST';
$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['password'] = '$DB_PW';
$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['user']     = '$DB_USER';
$GLOBALS['TYPO3_CONF_VARS']['BE']['installToolPassword']                = '$INSTALL_TOOL_PW';

$GLOBALS['TYPO3_CONF_VARS']['GFX']['gdlib_png'] = false;
$GLOBALS['TYPO3_CONF_VARS']['GFX']['processor'] = 'ImageMagick';
$GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_allowTemporaryMasksAsPng'] = false;
$GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_colorspace'] = 'sRGB';
$GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_effects'] = true;
$GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_enabled'] = true;
$GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_path'] = '/usr/bin/';
$GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_path_lzw'] = '/usr/bin/';
$GLOBALS['TYPO3_CONF_VARS']['GFX']['jpg_quality'] = 85;
$GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_stripColorProfileCommand'] = '+profile \'*\' -interlace plane -strip';