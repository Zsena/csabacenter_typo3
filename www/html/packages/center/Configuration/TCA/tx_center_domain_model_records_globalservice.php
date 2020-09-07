<?php
$serviceConfig = \DigitalZombies\Center\Utility\TCAFieldHelper::getBasicFieldDefinition(
	\DigitalZombies\Center\Domain\Model\Records\GlobalService::TYPE, 'EXT:center/Resources/Public/Icons/service.svg', false, false);
$serviceConfig['ctrl']['label_alt'] = 'internal_title';
$serviceConfig['ctrl']['label_alt_force'] = true;

$serviceConfig['columns']['title']['config']['eval'] = 'required, trim';

$serviceConfig['columns']['service_link'] = [
	'exclude' => 1,
	'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_globalservice.contact.link',
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
    'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_globalservice.contact.linktext',
    'config' => [
        'type' => 'input',
        'size' => 30,
        'max' => 255,
        'eval' => 'trim'
    ],
];
$serviceConfig['columns']['internal_title'] = [
	'exclude' => 1,
	'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_appconfig_alertmessage.internal_title',
	'config' => [
		'type' => 'input',
		'size' => 30,
		'max' => 255,
		'eval' => 'trim'
	],
];
$serviceConfig['columns']['service_icon'] = [
        'exclude' => 1,
        'l10n_mode' => 'exclude',
        'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_globalservice.icon',
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

unset($serviceConfig['columns']['shop']);
unset($serviceConfig['columns']['chain_store']);
unset($serviceConfig['columns']['centers']);
unset($serviceConfig['columns']['reference_type']);
unset($serviceConfig['columns']['center']);

/*
 * BEGIN TCAHelper
 * Add extra fields with help of the TCAField Helper.
 */

$teaserFields = \DigitalZombies\Center\Utility\TCAFieldHelper::getTeaserFields(1,
	\DigitalZombies\Center\Utility\TCAFieldHelper::TEASER_TYPE_PROP,
	false,
	false,
	false,
	false,
	false,
	false,
	100,
	false,
    false);
$serviceConfig['columns'] = array_merge($serviceConfig['columns'], $teaserFields);

/*
 * The config array has the name of the field content_<field_name>. (Each field has the prefix "content_")
 * There are always one possible settings:
 * required => it decides if the field should bex required or optional. (if it is not defined, the default is false)
 */

$config = [
	'image' => [],
	'video' => [],
	'abstract' => [],
	'text' => [],
    'downloadfile' => [],
    'downloadfiletext' => [],
    'downloadlink' => [],
    'downloadlinktext' => [],
	'origUid' => 't3_origuid',
	'gallery' => ['tablenames' => 'tx_center_domain_model_records_globalservice']
];
$contentFields = \DigitalZombies\Center\Utility\TCAFieldHelper::getContentFields($config);
$serviceConfig['columns'] = array_merge($serviceConfig['columns'], $contentFields);

$palettes = \DigitalZombies\Center\Utility\TCAFieldHelper::getPalettes();

foreach ($palettes as $paletteName => $paletteConf) {
	$serviceConfig['palettes'][$paletteName] = $paletteConf;
}

$serviceConfig['palettes']['servicePalette'] = ['showitem' => 'service_title,'];
//Type setting for the service page type only (everything hidden from the page and each needed fields are "white-listed")
$serviceConfig['types'][1] = [
	'showitem' => '
 +          --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general, title, internal_title,--palette--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_globalservice.serviceDetails;servicePalette,
 --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden, starttime, endtime, hide_in_app'

		. \DigitalZombies\Center\Utility\TCAFieldHelper::getContentTab( 'service_icon, content_abstract, content_text, content_downloadfile, content_downloadfiletext, content_downloadlink, content_downloadlinktext, contact, content_image, content_video, service_link, service_link_text, content_gallery')
];

/*
 * END TCAHelper
 */

return $serviceConfig;
