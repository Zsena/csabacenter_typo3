<?php
$serviceConfig = \DigitalZombies\Center\Utility\TCAFieldHelper::getBasicFieldDefinition(
	\DigitalZombies\Center\Domain\Model\Records\Service::TYPE, 'EXT:center/Resources/Public/Icons/service.svg', false, false);

$serviceConfig['columns']['title'] = [
	'exclude' => 1,
	'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_service.title',
	'config' => [
		'type' => 'input',
		'eval' => 'required, trim',
	]
];

$serviceConfig['columns']['service_247'] = [
	'exclude' => 1,
    'l10n_mode' => 'exclude',
	'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_service.service247',
	'config' => [
		'type' => 'check',
		'default' => '0'
	]
];
$serviceConfig['columns']['own_openings'] = [
	'exclude' => 1,
	'onChange' => 'reload',
	'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_service.ownOpenings',
	'config' => [
		'type' => 'check',
		'default' => '0'
	]
];

$serviceConfig['columns']['global_service'] = [
	'exclude' => 1,
	'onChange' => 'reload',
	'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_service.globalservice',
	'config' => [
		'type' => 'select',
		'renderType' => 'selectSingle',
		'items' => [
			['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_service.please_select', 0],
		],
		'disableNoMatchingValueElement' => true,
		'foreign_table' => 'tx_center_domain_model_records_globalservice',
		'minitems' => 0,
		'maxitems' => 1,
	],
];
$serviceConfig['columns']['content_showglobalservicedata'] = [
	'displayCond' => 'FIELD:global_service:>:0',
	'exclude' => 1,
	'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_service.content_showglobalservicedata',
	'config' => [
		'type' => 'check',
		'default' => '0'
	]
];

$serviceConfig['columns']['positions'] = [
	'exclude' => 1,
	'displayCond' => 'FIELD:center:>:0',
	'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_service.level',
	'config' => [
		'type' => 'inline',
		'foreign_table' => 'tx_center_domain_model_center_centerlevelposition',
		'foreign_table_where' => ' AND tx_center_domain_model_center_centerlevelposition.sys_language_uid IN (-1, 0)',
		'foreign_field' => 'service',
	]
];
$serviceConfig['columns']['service_link'] = [
	'exclude' => 1,
	'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_service.contact.link',
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
$serviceConfig['columns']['service_link_text'] = [
    'exclude' => 1,
    'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_service.contact.linktext',
    'config' => [
        'type' => 'input',
        'size' => 30,
        'max' => 255,
        'eval' => 'trim'
    ],
];
$serviceConfig['columns']['weekly_schedule'] = [
	'exclude' => 1,
	'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.weekly_schedule',
	'displayCond' => 'FIELD:own_openings:REQ:true',
	'config' => [
		'type' => 'inline',
		'foreign_table' => 'tx_center_domain_model_openinghours_dailyhours',
		'foreign_field' => 'parent',
		'foreign_table_field' => 'parent_table',
		'maxitems' => 7,
		'appearance' => [
			'collapseAll' => true
		]
	]
];
$serviceConfig['columns']['yearly_schedule'] = [
	'exclude' => 1,
	'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:pages.yearly_schedule',
	'displayCond' => 'FIELD:own_openings:REQ:true',
	'config' => [
		'type' => 'inline',
		'foreign_table' => 'tx_center_domain_model_openinghours_yearlyschedule',
		'foreign_field' => 'parent',
		'foreign_table_field' => 'parent_table',
		'maxitems' => 5,
		'appearance' => [
			'collapseAll' => true
		]
	]
];
$serviceConfig['columns']['service_icon'] = [
        'exclude' => 1,
        'l10n_mode' => 'exclude',
		'displayCond' => [
			'OR' => [
				'FIELD:global_service:=:0',
				'FIELD:global_service:=:',
			],
		],
        'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_service.icon',
        'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('service_icon', [
                // Use the imageoverlayPalette instead of the basicoverlayPalette
                'overrideChildTca' => [
                    'types' => [
                        '0' => [
                            'showitem' => '
									--palette--;;imageoverlayPalette,
									--palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                            'showitem' => '
									--palette--;;imageoverlayPalette,
									--palette--;;filePalette'
                        ]
                    ]
                ],
				'appearance' => [
					'fileUploadAllowed' => false
				],
                'minitems' => 1,
                'maxitems' => 1
            ]
        ,'svg')
];

$serviceConfig['columns']['center'] = [
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

$serviceConfig['columns']['elevator'] = [
    'exclude' => 1,
    'l10n_mode' => 'exclude',
    'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_service.elevator',
    'config' => [
        'type' => 'check',
        'default' => '0'
    ]
];

unset($serviceConfig['columns']['shop']);
unset($serviceConfig['columns']['chain_store']);
unset($serviceConfig['columns']['centers']);
unset($serviceConfig['columns']['reference_type']);

/*
 * BEGIN TCAHelper
 * Add extra fields with help of the TCAField Helper.
 */

$contactPerson = \DigitalZombies\Center\Utility\TCAFieldHelper::getContactPersonRelation(
	\DigitalZombies\Center\Domain\Model\Misc\Contactperson::SERVICE);
$serviceConfig['columns'] = array_merge($serviceConfig['columns'], $contactPerson);

$seoFields = \DigitalZombies\Center\Utility\TCAFieldHelper::getSEOFields();
$serviceConfig['columns'] = array_merge($serviceConfig['columns'], $seoFields);

$ogFields = \DigitalZombies\Center\Utility\TCAFieldHelper::getOGFields();
$serviceConfig['columns'] = array_merge($serviceConfig['columns'], $ogFields);

$teaserFields = \DigitalZombies\Center\Utility\TCAFieldHelper::getTeaserFields(1,
	\DigitalZombies\Center\Utility\TCAFieldHelper::TEASER_TYPE_PROP,
	false,
	false,
	false,
	false,
	true,
	false,
	100,
	false,
    false);
$serviceConfig['columns'] = array_merge($serviceConfig['columns'], $teaserFields);

/*
 * The config array has the name of the field content_<field_name>. (Each field has the prefix "content_")
 * There are always one possible settings:
 * required => it decides if the field should be required or optional. (if it is not defined, the default is false)
 */

$config = [
	'image' => [],
	'video' => [],
	'abstract' => [],
	'text' => [],
	'googleplay' => [],
	'applestore' => [],
    'elevator' => [],
    'downloadfile' => [],
    'downloadfiletext' => [],
    'downloadlink' => [],
    'downloadlinktext' => [],
	'gallery' => ['tablenames' => 'tx_center_domain_model_records_service']
];
$contentFields = \DigitalZombies\Center\Utility\TCAFieldHelper::getContentFields($config);
$serviceConfig['columns'] = array_merge($serviceConfig['columns'], $contentFields);

$palettes = \DigitalZombies\Center\Utility\TCAFieldHelper::getPalettes();

foreach ($palettes as $paletteName => $paletteConf) {
	$serviceConfig['palettes'][$paletteName] = $paletteConf;
}

$serviceConfig['palettes']['serviceOpeningPalette'] = ['showitem' => 'service_247,--linebreak--, own_openings,--linebreak--, weekly_schedule, --linebreak--, yearly_schedule'];
$serviceConfig['palettes']['servicePalette'] = ['showitem' => 'service_title, ,--linebreak--, center,--linebreak--, positions, --linebreak--, global_service, content_showglobalservicedata, elevator'];
//Type setting for the service page type only (everything hidden from the page and each needed fields are "white-listed")
$serviceConfig['types'][1] = [
	'showitem' => '
 +          --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general, title,alternative_title,--palette--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_service.serviceDetails;servicePalette,--palette--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_service.serviceOpening;serviceOpeningPalette,
 --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden, starttime, endtime, hide_in_app'

		. \DigitalZombies\Center\Utility\TCAFieldHelper::getContentTab( 'service_icon, content_abstract, content_text, content_googleplay, content_applestore, content_downloadfile, content_downloadfiletext, content_downloadlink, content_downloadlinktext, contact, content_image, content_video, service_link, service_link_text, content_gallery')
		. \DigitalZombies\Center\Utility\TCAFieldHelper::getContactTab()
		. \DigitalZombies\Center\Utility\TCAFieldHelper::getSEOTab()
		. \DigitalZombies\Center\Utility\TCAFieldHelper::getSocialMediaTab()
		. \DigitalZombies\Center\Utility\TCAFieldHelper::getTeaserTab()
];

/*
 * END TCAHelper
 */

return $serviceConfig;
