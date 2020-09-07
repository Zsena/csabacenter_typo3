<?php
$eventConfig = \DigitalZombies\Center\Utility\TCAFieldHelper::getBasicFieldDefinition(
	\DigitalZombies\Center\Domain\Model\Records\Event::TYPE, 'EXT:center/Resources/Public/Icons/event.svg', false, false);


$eventConfig['columns']['title']['label'] = 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_event.eventTitle';
$eventConfig['columns']['title']['config']['eval'] = 'trim, required';

$eventConfig['columns']['location'] = [
	'exclude' => 1,
	'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_event.location',
	'config' => [
		'type' => 'input',
		'size' => 30,
		'max' => 255,
	],
];

$eventConfig['columns']['detail_date'] = [
	'exclude' => 1,
	'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_event.detailDate',
	'config' => [
		'type' => 'input',
		'size' => 30,
		'eval' => 'required',
	],
];

$eventConfig['columns']['detail_time'] = [
	'exclude' => 1,
	'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_event.detailTime',
	'config' => [
		'type' => 'input',
		'size' => 30,
	],
];

$eventConfig['columns']['event_showical'] = [
	'exclude' => 1,
	'onChange' => 'reload',
	'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_event.ical',
	'config' => [
		'type' => 'check',
		'items' => [
			'1' => [
				'0' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_event.ical'
			]
		],
	],
];

$eventConfig['columns']['event_starttime'] = [
	'exclude' => 1,
	'displayCond' => 'FIELD:event_showical:>:0',
	'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_event.eventStarttime',
	'config' => [
		'type' => 'input',
		'renderType' => 'inputDateTime',
		'eval' => 'datetime',
	],
];

$eventConfig['columns']['event_endtime'] = [
	'exclude' => 1,
	'displayCond' => 'FIELD:event_showical:>:0',
	'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_event.eventEndtime',
	'config' => [
		'type' => 'input',
		'renderType' => 'inputDateTime',
		'eval' => 'datetime',
	],
];

/*
 * BEGIN TCAHelper
 * Add extra fields with help of the TCAField Helper.
 */

$seoFields = \DigitalZombies\Center\Utility\TCAFieldHelper::getSEOFields();
$eventConfig['columns'] = array_merge($eventConfig['columns'], $seoFields);

$ogFields = \DigitalZombies\Center\Utility\TCAFieldHelper::getOGFields();
$eventConfig['columns'] = array_merge($eventConfig['columns'], $ogFields);

$contactPerson = \DigitalZombies\Center\Utility\TCAFieldHelper::getContactPersonRelation();
$eventConfig['columns'] = array_merge($eventConfig['columns'], $contactPerson);

$teaserFields = \DigitalZombies\Center\Utility\TCAFieldHelper::getTeaserFields(3,
	\DigitalZombies\Center\Utility\TCAFieldHelper::TEASER_TYPE_COVER,
	true,
	false,
	true,
	true,
	true,
	false,
	100,
	true,
	false
);
$eventConfig['columns'] = array_merge($eventConfig['columns'], $teaserFields);

$eventConfig['columns']['teaser_date'] = [
	'exclude' => 1,
	'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_event.teaserDateTitle',
	'pnpu_description' => [
		'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_event.teaserDate',
		'extensionName' => 'center',
		'arguments' => [
			'2',
			'16:9'
		]
	],
	'config' => [
		'type' => 'input',
		'size' => 30,
		'eval' => 'required',
	],
];

$eventConfig['columns']['teaser_time'] = [
	'exclude' => 1,
	'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_event.teaserTime',
	'config' => [
		'type' => 'input',
		'size' => 30,
	],
];

/*
 * The config array has the name of the field content_<field_name>. (Each field has the prefix "content_")
 * There are always one possible settings:
 * required => it decides if the field should be required or optional. (if it is not defined, the default is false)
 */

$config = [
	'stagemedia' => ['required' => true],
	'image' => [],
	'video' => [],
	'abstract' => [
		'required' => true
	],
	'prologue' => [],
	'epilogue' => ['required' => true],
	'downloadfile' => [],
	'downloadfiletext' => [],
	'downloadlink' => [],
	'downloadlinktext' => [],
	'gallery' => ['tablenames' => 'tx_center_domain_model_records_event']
];
$contentFields = \DigitalZombies\Center\Utility\TCAFieldHelper::getContentFields($config);
$eventConfig['columns'] = array_merge($eventConfig['columns'], $contentFields);

$palettes = \DigitalZombies\Center\Utility\TCAFieldHelper::getPalettes();

foreach ($palettes as $paletteName => $paletteConf) {
	$eventConfig['palettes'][$paletteName] = $paletteConf;
}

$eventConfig['palettes']['eventPalette'] = ['showitem' => 'title, --linebreak--, alternative_title, --linebreak--,location'];

//Type setting for the shop page type only (everything hidden from the page and each needed fields are "white-listed")
$eventConfig['types'][1] = [
	'showitem' => '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,--palette--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_eventDetails;eventPalette, reference_type, shop, center, chain_store, centers,
 				--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden, starttime, endtime, hide_in_app'
		. \DigitalZombies\Center\Utility\TCAFieldHelper::getContentTab('content_stagemedia, detail_date, detail_time, event_showical, event_starttime,event_endtime, content_abstract, content_prologue,content_epilogue, content_image, content_video, content_downloadfile, content_downloadfiletext, content_downloadlink, content_downloadlinktext, content_gallery')
		. \DigitalZombies\Center\Utility\TCAFieldHelper::getContactTab()
		. \DigitalZombies\Center\Utility\TCAFieldHelper::getSEOTab()
		. \DigitalZombies\Center\Utility\TCAFieldHelper::getSocialMediaTab()
		. \DigitalZombies\Center\Utility\TCAFieldHelper::getTeaserTab('teaser_date, teaser_time')
];


/*
 * END TCAHelper
 */

return $eventConfig;
