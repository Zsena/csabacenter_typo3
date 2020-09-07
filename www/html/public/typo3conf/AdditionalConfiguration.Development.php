<?php

defined('TYPO3_MODE') || die('Access denied.');

$GLOBALS['TYPO3_CONF_VARS']['BE']['installToolPassword'] = '$argon2i$v=19$m=16384,t=16,p=2$YTJBMDZMbThMbkpSeHV5Rg$g4oMFIG3VCLO0a7RTxOFf0Z5KbgReD2uDEndRad6m5c';

$GLOBALS['TYPO3_CONF_VARS']['BE']['debug'] = true;

$GLOBALS['TYPO3_CONF_VARS']['FE']['debug'] = true;

$GLOBALS['TYPO3_CONF_VARS']['SYS']['devIPmask'] = '*';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['displayErrors'] = 1;
$GLOBALS['TYPO3_CONF_VARS']['SYS']['exceptionalErrors'] = 12290;
$GLOBALS['TYPO3_CONF_VARS']['SYS']['systemLogLevel'] = 0;

$GLOBALS['TYPO3_CONF_VARS']['GFX']['processor'] = 'GraphicsMagick';
$GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_allowTemporaryMasksAsPng'] = false;
$GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_colorspace'] = 'RGB';
$GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_effects'] = false;
$GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_enabled'] = true;
$GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_path'] = '/usr/bin/';
$GLOBALS['TYPO3_CONF_VARS']['GFX']['processor_path_lzw'] = '/usr/bin/';

$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['dbname']   = 'app';
$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['user']     = 'root';
$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['password'] = 'root';
$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['host']     = 'csabacenter_typo3_db_1';

$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport'] = 'smtp';
$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_sendmail_command'] = '';
$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_encrypt'] = '';
$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_password'] = '';
$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_server'] = 'csabacenter_typo3_mailhog_1:1025';
$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_username'] = '';
