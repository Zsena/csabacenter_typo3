<?php
$contentTeaserConfig =  \DigitalZombies\Center\Utility\TCAFieldHelper::getBasicFieldDefinition(
	\DigitalZombies\Center\Domain\Model\Records\ContentTeaser::TYPE,
	'EXT:center/Resources/Public/Icons/ext_icon.png',
	false, false);


// We don't have a shop but only a center selection

unset($contentTeaserConfig['columns']['shop']);
unset($contentTeaserConfig['columns']['chain_store']);
unset($contentTeaserConfig['columns']['centers']);
unset($contentTeaserConfig['columns']['reference_type']);

$contentTeaserConfig['columns']['center'] = [
	'exclude' => 1,
	'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_shop_shop.center',
	'config' => [
		'type' => 'select',
		'renderType' => 'selectSingle',
		'disableNoMatchingValueElement' => true,
		'foreign_table' => 'tx_center_domain_model_center_center',
		'foreign_table_where' => 'tx_center_domain_model_center_center.page_id > 0 AND (tx_center_domain_model_center_center.page_id = ###SITEROOT### 
							OR (\'\' = ###SITEROOT### AND (0 = \'###PAGE_TSCONFIG_IDLIST###\' OR tx_center_domain_model_center_center.page_id IN (###PAGE_TSCONFIG_IDLIST###))))',
		'minitems' => 1
	],
];

$contentTeaserConfig['columns']['link'] = [
	'exclude' => 1,
	'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_contentteaser.link',
	'config' => [
		'type' => 'input',
		'renderType' => 'inputLink',
		'fieldControl' => [
			'linkPopup' => [
				'options' => [
					'blindLinkFields' => 'class, params, title',
					'blindLinkOptions' => 'folder'
				]
			]
		],
		'eval' => 'required',
		'size' => 30,
	],
];

$contentTeaserConfig['columns']['is_fallback_teaser'] = [
	'exclude' => 1,
	'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_contentteaser.is_fallback_teaser',
	'config' => [
		'type' => 'check',
		'items' => [
			'1' => [
				'0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			]
		],
	],
];

$contentTeaserConfig['columns']['label'] = [
    'exclude' => 1,
    'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_contentteaser.label',
    'config' => [
        'type' => 'input',
        'size' => 30,
        'max' => 255,
    ],
];

$contentTeaserConfig['columns']['title']['config']['eval'] = 'trim, required';
/*
 * BEGIN TCAHelper
 * Add extra fields with help of the TCAField Helper.
 */

$teaserFields = \DigitalZombies\Center\Utility\TCAFieldHelper::getTeaserFields(2,
    \DigitalZombies\Center\Utility\TCAFieldHelper::TEASER_TYPE_PROP,
    true,
    true,
    true,
    true,
    true,
    true,
    100,
    true,
    true);

$contentTeaserConfig['columns'] = array_merge($contentTeaserConfig['columns'], $teaserFields);

//Type setting for the shop page type only (everything hidden from the page and each needed fields are "white-listed")
$contentTeaserConfig['types'][1] = [
	'showitem' => '
	 	--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general, center, is_fallback_teaser,
	 	title, link, teaser_format, --linebreak--, teaser_abstract, label, --linebreak--, teaser_image, --linebreak--, teaser_image2, --linebreak--, teaser_image3, --linebreak--, teaser_video, --linebreak--, top_in_app,
		 --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden, starttime, endtime, hide_in_app'
];


/*
 * END TCAHelper
 */

return $contentTeaserConfig;
