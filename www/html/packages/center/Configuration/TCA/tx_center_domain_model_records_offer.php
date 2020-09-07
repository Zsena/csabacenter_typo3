<?php
$offerConfig = \DigitalZombies\Center\Utility\TCAFieldHelper::getBasicFieldDefinition(
	\DigitalZombies\Center\Domain\Model\Records\Offer::TYPE,'EXT:center/Resources/Public/Icons/offer.svg',false, false);


$offerConfig['columns']['title']['label'] = 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_offer.offerTitle';
$offerConfig['columns']['title']['config']['eval'] = 'trim, required';
$offerConfig['columns']['starttime']['label'] = 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_offer.offerStart';
$offerConfig['columns']['endtime']['label'] = 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_offer.offerEnd';

$offerConfig['columns']['offer_content_link_to_all_offers'] = [
	'exclude' => 1,
	'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_offer.offer_content_link_to_all_offers',
	'config' => [
		'type' => 'input',
		'renderType' => 'inputLink',
		'fieldControl' => [
			'linkPopup' => [
				'options' => [
					'blindLinkOptions' => 'folder, event, news, job, offer, service, email'
				]
			]
		],
	],
];

$offerConfig['columns']['detail_date'] = [
	'exclude' => 1,
	'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_event.detailDate',
	'config' => [
		'type' => 'input',
		'size' => 30,
		'eval' => 'required',
	],
];

$offerConfig['columns']['detail_date'] = [
	'exclude' => 1,
	'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_event.detailDate',
	'config' => [
		'type' => 'input',
		'size' => 30,
		'eval' => 'required',
	],
];
/*
 * BEGIN TCAHelper
 * Add extra fields with help of the TCAField Helper.
 */

$contactPerson = \DigitalZombies\Center\Utility\TCAFieldHelper::getContactPersonRelation();
$offerConfig['columns'] = array_merge($offerConfig['columns'], $contactPerson);

$seoFields = \DigitalZombies\Center\Utility\TCAFieldHelper::getSEOFields();
$offerConfig['columns'] = array_merge($offerConfig['columns'], $seoFields);

$ogFields = \DigitalZombies\Center\Utility\TCAFieldHelper::getOGFields();
$offerConfig['columns'] = array_merge($offerConfig['columns'], $ogFields);

$teaserFields = \DigitalZombies\Center\Utility\TCAFieldHelper::getTeaserFields(2,
	\DigitalZombies\Center\Utility\TCAFieldHelper::TEASER_TYPE_PROP,
	true,
	true,
	true,
	true,
	true,
	false,
    100,
    true,
    false);

$offerConfig['columns'] = array_merge($offerConfig['columns'], $teaserFields);

$offerConfig['columns']['teaser_date'] = [
	'exclude' => 1,
	'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_offer.teaserDateTitle',
    'pnpu_description' => [
        'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_offer.teaserDate',
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

/*
 * The config array has the name of the field content_<field_name>. (Each field has the prefix "content_")
 * There are always one possible settings:
 * required => it decides if the field should be required or optional. (if it is not defined, the default is false)
 */

$config = [
	'stagemedia' => [],
	'image' => [],
	'abstract' => [
	],
	'text' => ['required' => true],
	'gallery' => ['tablenames' => 'tx_center_domain_model_records_offer']
];
$contentFields = \DigitalZombies\Center\Utility\TCAFieldHelper::getContentFields($config);
$offerConfig['columns'] = array_merge($offerConfig['columns'], $contentFields);

$palettes = \DigitalZombies\Center\Utility\TCAFieldHelper::getPalettes();

foreach ($palettes as $paletteName => $paletteConf) {
	$offerConfig['palettes'][$paletteName] = $paletteConf;
}

//Type setting for the shop page type only (everything hidden from the page and each needed fields are "white-listed")
$offerConfig['types'][1] = [
	'showitem' => '
           --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,title,alternative_title,reference_type, shop, center, chain_store, centers,
 --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden, starttime, endtime, hide_in_app'
		. \DigitalZombies\Center\Utility\TCAFieldHelper::getContentTab('content_stagemedia, detail_date, content_abstract, content_text, content_image, content_downloadfile, offer_content_link_to_all_offers, content_gallery')
		. \DigitalZombies\Center\Utility\TCAFieldHelper::getContactTab()
		. \DigitalZombies\Center\Utility\TCAFieldHelper::getSEOTab()
		. \DigitalZombies\Center\Utility\TCAFieldHelper::getSocialMediaTab()
		. \DigitalZombies\Center\Utility\TCAFieldHelper::getTeaserTab('teaser_date')
];


/*
 * END TCAHelper
 */

return $offerConfig;
