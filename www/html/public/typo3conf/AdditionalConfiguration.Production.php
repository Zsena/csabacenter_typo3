<?php

defined('TYPO3_MODE') || die('Access denied.');

$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['dbname']   = '$DB_NAME';
$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['host']     = '$DB_HOST';
$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['password'] = '$DB_PW';
$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['user']     = '$DB_USER';
$GLOBALS['TYPO3_CONF_VARS']['BE']['installToolPassword']                = '$INSTALL_TOOL_PW';


$GLOBALS['TYPO3_CONF_VARS']['GFX'] = [
    'gdlib_png' => false,
    'processor' => 'ImageMagick',
    'processor_allowTemporaryMasksAsPng' => false,
    'processor_colorspace' => 'sRGB',
    'processor_effects' => true,
    'processor_enabled' => true,
    'processor_path' => '/usr/bin/',
    'processor_path_lzw' => '/usr/bin/',
    'jpg_quality' => 85,
    'processor_stripColorProfileCommand' => '+profile \'*\' -interlace plane -strip',
];