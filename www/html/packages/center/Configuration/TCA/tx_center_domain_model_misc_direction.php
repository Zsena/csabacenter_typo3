<?php
return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_direction',
        'label' => 'title',
		'label_alt' => 'page',
		'label_alt_force' => 1,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => 1,

		'sortby' => 'sorting',
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
        'searchFields' => 'name',
        'iconfile' => 'EXT:center/Resources/Public/Icons/ext_icon.png'
    ],

    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, center, page, title, lat, long, function, icon, button_text',
    ],
    'types' => [
        '1' => ['showitem' => "center, page, title, lat, long, function, icon, button_text,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden, starttime, endtime"],
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
                'foreign_table' => 'tx_center_domain_model_misc_direction',
                'foreign_table_where' => 'AND tx_center_domain_model_misc_direction.pid=###CURRENT_PID### AND tx_center_domain_model_misc_direction.sys_language_uid IN (-1,0)',
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
		'title' => [
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_direction.title',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'max' => 255,
				'eval' => 'required, trim'
			],
		],
		'center' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_direction.center',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'disableNoMatchingValueElement' => true,
				'foreign_table' => 'tx_center_domain_model_center_center',
				'foreign_table_where' => 'tx_center_domain_model_center_center.page_id > 0 AND (tx_center_domain_model_center_center.page_id = ###SITEROOT### 
								OR (\'\' = ###SITEROOT### AND (0 = \'###PAGE_TSCONFIG_IDLIST###\' OR tx_center_domain_model_center_center.page_id IN (###PAGE_TSCONFIG_IDLIST###))))',
				'minitems' => 1
			],
		],
		'page' => [
			'exclude' => 1,
			'l10_mode' => 'exclude',
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_direction.page',
			'config' => [
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'pages',
				'suggestOptions' => [
					'default' => [
						'searchWholePhrase' => 1
					],
					'pages' => [
						'searchCondition' => 'doktype = 1'
					],
				],
			]
		],
		'function' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_direction.function',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => [
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_direction.function.1', 'dirAccordionDriving'],
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_direction.function.2', 'dirAccordionWalking'],
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_direction.function.3', 'dirAccordionTransit'],
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_direction.function.4', 'dirAccordionTaxi'],
				],
				'minitems' => 1
			],
		],
		'icon' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_direction.icon',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => [
					['walking', 'walk'],
					['driving', 'car'],
					['transit', 'train'],
					['taxi', 'taxi'],
				],
			],
		],
		'lat' => [
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.lat',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'max' => 255,
				'eval' => 'trim'
			],
		],
		'long' => [
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.lng',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'max' => 255,
				'eval' => 'trim'
			],
		],
	]
];
