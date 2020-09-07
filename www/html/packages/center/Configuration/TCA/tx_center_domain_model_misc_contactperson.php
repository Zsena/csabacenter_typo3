<?php
return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_contactperson',
        'label' => 'last_name',
		'label_alt' => 'first_name',
		'label_alt_force' => 1,
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
		'security' => [
			'ignoreWebMountRestriction' => 1,
			'ignoreRootLevelRestriction' => 1,
		],
        'searchFields' => 'first_name, last_name, address, email',
        'iconfile' => 'EXT:center/Resources/Public/Icons/contact.svg'
    ],

    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, salutation, first_name, last_name, global, company_name, title, function, phone, email, address, website, responsibilities',
    ],
    'palettes' => [
        'accessPalette' => ['showitem' => 'starttime, endtime'],
        'contactPalette' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, salutation, first_name, last_name, global, company_name, title, function, phone, email, address, website, responsibilities']
    ],
    'types' => [
        '1' => ['showitem' => "
        sys_language_uid, l10n_parent, l10n_diffsource, hidden, salutation, first_name, last_name, global, company_name, title, function, phone, email, address, website, responsibilities,
         --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, hidden, starttime, endtime
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
                'foreign_table' => 'tx_center_domain_model_misc_contactperson',
                'foreign_table_where' => 'AND tx_center_domain_model_misc_contactperson.pid=###CURRENT_PID### AND tx_center_domain_model_misc_contactperson.sys_language_uid IN (-1,0)',
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
		'first_name' => [
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_contactperson.first_name',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'max' => 255,
				'eval' => 'required, trim'
			],
		],
		'last_name' => [
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_contactperson.last_name',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'max' => 255,
				'eval' => 'required, trim'
			],
		],
		'global' => [
			'exclude' => 1,
			'onChange' => 'reload',
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_contactperson.global',
			'config' => [
				'type' => 'check',
				'items' => [
					'1' => [
						'0' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_contactperson.set_to_global'
					]
				],
			],
		],
		'company_name' => [
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_contactperson.company_name',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'max' => 255,
				'eval' => 'trim'
			],
		],
		'title' => [
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_contactperson.title',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'max' => 255,
				'eval' => 'trim'
			],
		],
		'function' => [
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_contactperson.function',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'max' => 255,
				'eval' => 'trim'
			],
		],
		'phone' => [
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_contactperson.phone',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'max' => 255,
				'eval' => 'trim'
			],
		],
		'email' => [
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_contactperson.email',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'max' => 255,
				'eval' => 'email'
			],
		],
		'address' => [
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_contactperson.address',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'max' => 255,
				'eval' => 'trim'
			],
		],
		'website' => [
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_contactperson.website',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'max' => 255,
				'eval' => 'trim'
			],
		],
		'responsibilities' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_contactperson.responsibilities',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectCheckBox',
				'items' => [
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_contactperson.responsibilities.shop',
						\DigitalZombies\Center\Domain\Model\Misc\Contactperson::SHOP],
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_contactperson.responsibilities.gastro',
						\DigitalZombies\Center\Domain\Model\Misc\Contactperson::GASTRO],
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_contactperson.responsibilities.jobs',
						\DigitalZombies\Center\Domain\Model\Misc\Contactperson::JOBS],
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_contactperson.responsibilities.center',
						\DigitalZombies\Center\Domain\Model\Misc\Contactperson::CENTER],
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_contactperson.responsibilities.press',
						\DigitalZombies\Center\Domain\Model\Misc\Contactperson::PRESS],
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_contactperson.responsibilities.news',
						\DigitalZombies\Center\Domain\Model\Misc\Contactperson::NEWS],
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_contactperson.responsibilities.blog',
						\DigitalZombies\Center\Domain\Model\Misc\Contactperson::BLOG],
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_contactperson.responsibilities.service',
						\DigitalZombies\Center\Domain\Model\Misc\Contactperson::SERVICE],
				],
				'maxitems' => 100,
			],
		],
		'salutation' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_contactperson.salutation',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => [
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_contactperson.salutation.1', 1],
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_contactperson.salutation.2', 2],
				],
				'minitems' => 1
			],
		],
    ],
];
