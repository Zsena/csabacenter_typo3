<?php
$newsConfig =  \DigitalZombies\Center\Utility\TCAFieldHelper::getBasicFieldDefinition(
	\DigitalZombies\Center\Domain\Model\Records\News::TYPE, 'EXT:center/Resources/Public/Icons/ext_icon.png', false,false);


$newsConfig['columns']['type'] = [
	'exclude' => 1,
	'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_news.type',
	'config' => [
		'type' => 'select',
		'renderType' => 'selectSingle',
		'items' => [
			['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_news.type.1', \DigitalZombies\Center\Domain\Model\Records\News::NEWS],
			['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_news.type.2', \DigitalZombies\Center\Domain\Model\Records\News::PRESS]
		],
	],
];

/*
 * BEGIN TCAHelper
 * Add extra fields with help of the TCAField Helper.
 */

$seoFields = \DigitalZombies\Center\Utility\TCAFieldHelper::getSEOFields();
$newsConfig['columns'] = array_merge($newsConfig['columns'], $seoFields);

$ogFields = \DigitalZombies\Center\Utility\TCAFieldHelper::getOGFields();
$newsConfig['columns'] = array_merge($newsConfig['columns'], $ogFields);

$teaserFields = \DigitalZombies\Center\Utility\TCAFieldHelper::getTeaserFields(2,
	\DigitalZombies\Center\Utility\TCAFieldHelper::TEASER_TYPE_PROP,
    true,
    true,
    true,
    true,
    true,
    100,
    true,
    true,
    false);
$newsConfig['columns'] = array_merge($newsConfig['columns'], $teaserFields);

$contactPerson = \DigitalZombies\Center\Utility\TCAFieldHelper::getContactPersonRelation();
$newsConfig['columns'] = array_merge($newsConfig['columns'], $contactPerson);

$newsConfig['columns']['contact']['config']['foreign_table_where'] = ' (FIND_IN_SET('
	. \DigitalZombies\Center\Domain\Model\Misc\Contactperson::NEWS .
	', tx_center_domain_model_misc_contactperson.responsibilities) > 0 OR'
	. ' FIND_IN_SET('
	. \DigitalZombies\Center\Domain\Model\Misc\Contactperson::PRESS .
	', tx_center_domain_model_misc_contactperson.responsibilities) > 0 )';

/*
 * The config array has the name of the field content_<field_name>. (Each field has the prefix "content_")
 * There are always one possible settings:
 * required => it decides if the field should be required or optional. (if it is not defined, the default is false)
 */

$config = [
	'stagemedia' => [],
	'abstract' => [
		'required' => true
	],
	'epilogue' => [],
	'prologue' => [],
	'googleplay' => [],
	'applestore' => [],
	'image' => [],
	'video' => [],
	'downloadfile' => [],
	'downloadfiletext' => [],
	'downloadlink' => [],
	'downloadlinktext' => [],
	'gallery' => ['tablenames' => 'tx_center_domain_model_records_news']
];
$contentFields = \DigitalZombies\Center\Utility\TCAFieldHelper::getContentFields($config);
$newsConfig['columns'] = array_merge($newsConfig['columns'], $contentFields);

$palettes = \DigitalZombies\Center\Utility\TCAFieldHelper::getPalettes();

foreach ($palettes as $paletteName => $paletteConf) {
	$newsConfig['palettes'][$paletteName] = $paletteConf;
}

//Type setting for the shop page type only (everything hidden from the page and each needed fields are "white-listed")
$newsConfig['types'][1] = [
	'showitem' => '
	 	--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general, type, title,alternative_title,  reference_type, shop, center, chain_store, centers,
	 	--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden, starttime, endtime, hide_in_app'
		. \DigitalZombies\Center\Utility\TCAFieldHelper::getContentTab('content_stagemedia, content_abstract, content_prologue, content_epilogue, content_googleplay, content_applestore, content_image, content_video, content_downloadfile, content_downloadfiletext, content_downloadlink, content_downloadlinktext, content_gallery')
		. \DigitalZombies\Center\Utility\TCAFieldHelper::getContactTab()
		. \DigitalZombies\Center\Utility\TCAFieldHelper::getSEOTab()
		. \DigitalZombies\Center\Utility\TCAFieldHelper::getSocialMediaTab()
		. \DigitalZombies\Center\Utility\TCAFieldHelper::getTeaserTab()
];


/*
 * END TCAHelper
 */

return $newsConfig;
