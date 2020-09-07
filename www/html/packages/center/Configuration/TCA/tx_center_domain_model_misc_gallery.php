<?php
return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_gallery',
        'label' => 'title_intern',
        'label_alt' => 'center',
		'label_alt_force' => 1,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => 1,

        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
        'origUid' => 't3_origuid',
        'enablecolumns' => [
			'disabled' => 'hidden',
			'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
		'security' => [
			'ignoreWebMountRestriction' => 1,
			'ignoreRootLevelRestriction' => 1,
		],
        'searchFields' => 'title_intern, name',
        'iconfile' => 'EXT:center/Resources/Public/Icons/ext_icon.png'
    ],

    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, center, name, images, items',
    ],
    'types' => [
        '1' => ['showitem' => "name, title_intern, center, images,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden, starttime, endtime
        "],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages'
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_center_domain_model_misc_gallery',
                'foreign_table_where' => 'AND tx_center_domain_model_misc_gallery.pid=###CURRENT_PID### AND tx_center_domain_model_misc_gallery.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
        'hidden' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
                    ]
                ],
            ],
        ],
        'starttime' => [
            'exclude' => 1,
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
            ],
        ],
        'endtime' => [
            'exclude' => 1,
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_gallery.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
            ],
        ],
		'center' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_gallery.center',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'tx_center_domain_model_center_center',
				'foreign_table_where' => 'tx_center_domain_model_center_center.page_id > 0 AND (tx_center_domain_model_center_center.page_id = ###SITEROOT### 
							OR (\'\' = ###SITEROOT### AND (0 = \'###PAGE_TSCONFIG_IDLIST###\' OR tx_center_domain_model_center_center.page_id IN (###PAGE_TSCONFIG_IDLIST###))))',
				'minitems' => 1
			],
		],
		'name' => [
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_gallery.name',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'max' => 255,
				'eval' => 'trim'
			],
		],
		'images' => [
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_gallery.images',
			'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('images', [
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
					'maxitems' => 100
				],
				\DigitalZombies\Center\Utility\TCAFieldHelper::allowedImageExtensions
			)
		],
		'items' => [
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_gallery.items',
			'config' => [
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => '*',
				'MM' => 'tx_center_domain_model_misc_gallery_record_mm',
				'MM_oppositeUsage' => [],
				'size' => 10,
				'fieldWizard' => [
					'recordsOverview' => [
						'disabled' => true,
					],
				],
			],
		],
		'title_intern' => [
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_gallery.title_intern',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'max' => 255,
				'eval' => 'required, trim'
			],
		],
    ],
];
