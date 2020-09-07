<?php
return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_openinghours_yearlyschedule',
        'label' => 'year',
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
        'iconfile' => 'EXT:center/Resources/Public/Icons/ext_icon.png'
    ],

    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, year, special_closing_days, holiday, parent, parent_table',
    ],
    'types' => [
        '1' => ['showitem' => "year, special_closing_days, holidays,"],
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
                'foreign_table' => 'tx_center_domain_model_openinghours_yearlyschedule',
                'foreign_table_where' => 'AND tx_center_domain_model_openinghours_yearlyschedule.pid=###CURRENT_PID### AND tx_center_domain_model_openinghours_yearlyschedule.sys_language_uid IN (-1,0)',
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
		'year' => [
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_openinghours_yearlyschedule.year',
			'onChange' => 'reload',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => \DigitalZombies\Center\Utility\TCAFieldHelper::generateYears(5),
                'default' => 0
			],
		],
        'holidays' => [
            'exclude' => 1,
            'displayCond' => 'FIELD:year:>:0',
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_openinghours_yearlyschedule.holidays',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectCheckBox',
                'foreign_table' => 'tx_center_domain_model_openinghours_holiday',
                'foreign_table_where' => 'AND FROM_UNIXTIME(tx_center_domain_model_openinghours_holiday.closing_day, \'%Y\') = ###REC_FIELD_year### 
				AND (
						(###SITEROOT### = 985 AND ###REC_FIELD_parent_table### = \'tx_center_domain_model_center_center\' AND country = 
							(SELECT country FROM tx_center_domain_model_center_center WHERE 
							deleted = 0 AND hidden = 0 AND 
							tx_center_domain_model_center_center.uid = ###REC_FIELD_parent###)
						)
						OR
						(###SITEROOT### != 985 AND country = 
							(SELECT DISTINCT country FROM tx_center_domain_model_center_center WHERE
							deleted = 0 AND hidden = 0 AND 
							tx_center_domain_model_center_center.page_id = ###SITEROOT###)
						)
				) AND tx_center_domain_model_openinghours_holiday.sys_language_uid IN (-1,0)',
                'MM' => 'tx_center_domain_model_openinghurs_shedule_holiday_mm',
                'maxitems' => 30
            ]
        ],
		'special_closing_days' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_openinghours_yearlyschedule.special_closing_days',
			'config' => [
				'type' => 'inline',
				'foreign_table' => 'tx_center_domain_model_openinghours_specialclosingday',
				'foreign_field' => 'schedule',
				'maxitems' => 30,
				'appearance' => [
					'collapseAll' => true,
					'showSynchronizationLink' => true,
					'showRemovedLocalizationRecords' => true,
					'showPossibleLocalizationRecords' => true,
					'showAllLocalizationLink' => true

				],
				'enabledControls' => [
					'localize' => true
				],
				'behaviour' => [
					'localizeChildrenAtParentLocalization' => true
				]
			]
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
