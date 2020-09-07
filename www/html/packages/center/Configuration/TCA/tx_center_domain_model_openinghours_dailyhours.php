<?php
return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_openinghours_dailyhours',
        'label' => 'day_of_week',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => 1,
		'hideTable' => true,
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
        'iconfile' => 'EXT:center/Resources/Public/Icons/ext_icon.png',
        'sortby' => 'sorting'
    ],

    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, from, till, closed, from_ext, till_ext',
    ],
	'palettes' => [
		'timesPalette' => ['showitem' => 'closed, --linebreak--, from, till, --linebreak--, from_ext, till_ext'],
	],
    'types' => [
        '1' => ['showitem' => "day_of_week,
         --palette--;;timesPalette,"],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'default' => 0
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
                'foreign_table' => 'tx_center_domain_model_openinghours_dailyhours',
                'foreign_table_where' => 'AND tx_center_domain_model_openinghours_dailyhours.pid=###CURRENT_PID### AND tx_center_domain_model_openinghours_dailyhours.sys_language_uid IN (-1,0)',
                'default' => 0
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
                'default' => 0
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
                'default' => 0
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
                'default' => 0
            ],
        ],
		'day_of_week' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_openinghours_dailyhours.day_of_week',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => [
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_openinghours_dailyhours.day_of_week.1', '1'],
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_openinghours_dailyhours.day_of_week.2', '2'],
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_openinghours_dailyhours.day_of_week.3', '3'],
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_openinghours_dailyhours.day_of_week.4', '4'],
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_openinghours_dailyhours.day_of_week.5', '5'],
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_openinghours_dailyhours.day_of_week.6', '6'],
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_openinghours_dailyhours.day_of_week.7', '7']
				],
                'default' => 1
			],
		],
		'from' => [
			'exclude' => 1,
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_openinghours_dailyhours.from',
			'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'time',
                'default' => 0
			],
		],
		'till' => [
			'exclude' => 1,
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_openinghours_dailyhours.till',
			'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'time',
                'default' => 0
			],
		],
		'from_ext' => [
			'exclude' => 1,
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_openinghours_dailyhours.from',
			'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'time',
                'default' => 0
			],
		],
		'till_ext' => [
			'exclude' => 1,
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_openinghours_dailyhours.till',
			'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'time',
                'default' => 0
			],
		],
		'closed' => [
			'exclude' => 1,
			'label' => '',
			'config' => [
				'type' => 'check',
				'items' => [
					'1' => [
						'0' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_openinghours_dailyhours.closed'
					]
				],
                'default' => 0
			],
		],
		'parent' => [
			'config' => [
				'type' => 'passthrough',
			],
		],
		'parent_table' => [
			'config' => [
				'type' => 'passthrough',
			],
		],
    ],
];
