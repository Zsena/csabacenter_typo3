<?php
return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_centerlevelposition',
        'label' => 'center_level',
        'label_alt' => 'object_position',
        'label_alt_force' => '1',
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
        'searchFields' => '',
        'iconfile' => 'EXT:center/Resources/Public/Icons/ext_icon.png'
    ],

    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, shop, service, center, center_level, object_position',
    ],
    'types' => [
        '1' => ['showitem' => "hidden, center_level, object_position"],
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
                'foreign_table' => 'tx_center_domain_model_center_centerlevelposition',
                'foreign_table_where' => 'AND tx_center_domain_model_center_centerlevelposition.pid=###CURRENT_PID### AND tx_center_domain_model_center_centerlevelposition.sys_language_uid IN (-1,0)',
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
		'center_level' => [
			'exclude' => 1,
			'displayCond' => 'FIELD:center:>:0',
			'onChange' => 'reload',
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_centerlevelposition.center_level',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => [
					['', 0],
				],
				'eval' => 'trim, required',
				'foreign_table' => 'tx_center_domain_model_center_centerlevel',
				'foreign_table_where' => 'AND tx_center_domain_model_center_centerlevel.center=###REC_FIELD_center###',
			],
		],
		'object_position' => [
			'exclude' => 1,
			'displayCond' => 'FIELD:center_level:>:0',
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_centerlevelposition.object_position',
			'config' => [
				'type' => 'input',
				'size' => 4,
				'eval' => 'required',
				'wizards' => [
					'centerPlan' => [
						'type' => 'popup',
						'icon' => 'actions-add',
						'title' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_centerlevelposition.object_position_popup',
						'params' => [
							'centerLevelField' => 'center_level',
						],
						'module' => [
							'name' => 'wizard_centerplan',
						],
						'JSopenParams' => 'height=600,width=1080,status=0,menubar=0,scrollbars=1',
					]
				]
			],

		],
		'service' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_centerlevelposition.service',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'shop' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_centerlevelposition.shop',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'center' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_centerlevelposition.center',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
    ],
];
