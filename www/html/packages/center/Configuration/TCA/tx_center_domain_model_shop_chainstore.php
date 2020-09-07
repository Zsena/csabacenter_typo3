<?php
return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_shop_chainstore',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => 1,

        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
        'enablecolumns' => [
			'disabled' => 'hidden',
			'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],

        'searchFields' => 'name, description',
        'iconfile' => 'EXT:center/Resources/Public/Icons/ext_icon.png'
    ],

    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, company, address, zip_city,  logo, description, meta_title, meta_description',
    ],
    'types' => [
        '1' => ['showitem' => "center, name, logo, description,
        	--div--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_shop_chainstore.tabs.seo, meta_title, meta_description, keywords,
        	--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden, starttime, endtime, 
        	--div--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_shop_chainstore.tabs.contact, website, phone, email, company, address, zip_city"
			]
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
                'foreign_table' => 'tx_center_domain_model_shop_chainstore',
                'foreign_table_where' => 'AND tx_center_domain_model_shop_chainstore.pid=###CURRENT_PID### AND tx_center_domain_model_shop_chainstore.sys_language_uid IN (-1,0)',
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
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
            ],
        ],
		'name' => [
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_shop_chainstore.name',
			'l10n_mode' => 'exclude',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'max' => 255,
				'eval' => 'trim, required'
			],
		],
        'company' => [
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.company',
            'l10n_mode' => 'exclude',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim'
            ],
        ],
        'address' => [
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_contactperson.address',
            'l10n_mode' => 'exclude',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim'
            ],
        ],
        'zip_city' => [
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_shop_chainstore.zipcity',
            'l10n_mode' => 'exclude',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim'
            ],
        ],
		'description' => [
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_shop_chainstore.description',
			'config' => [
				'type' => 'text',
				'cols' => 80,
				'rows' => 15,
				'softref' => 'typolink_tag,images,email[subst],url',
				'enableRichtext' => '1',
				'richtextConfiguration' => 'default'
			],
		],
		'logo' => [
			'exclude' => true,
			'l10n_mode' => 'exclude',
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_shop_chainstore.logo',
			'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('logo', [
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
			)
		],
		'meta_title' => [
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_shop_chainstore.meta_title',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'max' => 255,
				'eval' => 'trim'
			],
		],
		'meta_description' => [
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_shop_chainstore.meta_description',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'max' => 255,
				'eval' => 'trim'
			],
		],
        'keywords' => [
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_shop_chainstore.keywords',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim'
            ],
        ],
		'phone' => [
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_shop_chainstore.phone',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'max' => 255,
				'eval' => 'trim'
			],
		],
		'website' => [
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_shop_chainstore.website',
            'pnpu_description' => [
                'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_shop_chainstore.website.info',
                'extensionName' => 'center',
                'arguments' => [
                    '2',
                    '16:9'
                ]
            ],
			'config' => [
				'type' => 'input',
				'size' => 30,
				'max' => 255,
				'eval' => 'trim'
			],
		],
		'email' => [
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_shop_chainstore.email',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'max' => 255,
				'eval' => 'trim'
			],
		]
    ],
];
