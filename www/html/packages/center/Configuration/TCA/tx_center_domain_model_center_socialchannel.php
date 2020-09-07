<?php
return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_socialchannel',
        'label' => 'type',
        'label_alt' => 'url',
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
        'searchFields' => 'url',
        'iconfile' => 'EXT:center/Resources/Public/Icons/ext_icon.png'
    ],

    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, center, type, url',
    ],
    'types' => [
        '1' => ['showitem' => "center, type, url"],
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
                'foreign_table' => 'tx_center_domain_model_center_socialchannel',
                'foreign_table_where' => 'AND tx_center_domain_model_center_socialchannel.pid=###CURRENT_PID### AND tx_center_domain_model_center_socialchannel.sys_language_uid IN (-1,0)',
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
		'center' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_socialchannel.center',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => [
					['', 0],
				],
				'foreign_table' => 'tx_center_domain_model_center_center',
			],
		],
		'url' => [
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_socialchannel.url',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'max' => 255,
				'eval' => 'required, trim'
			],
		],
		'type' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_socialchannel.type',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => [
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_socialchannel.type.twitter', 'twitter'],
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_socialchannel.type.youtube', 'youtube'],
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_socialchannel.type.googleplus', 'googleplus'],
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_socialchannel.type.instagram', 'instagram'],
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_socialchannel.type.yelp', 'yelp'],
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_socialchannel.type.foursquare', 'foursquare'],
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_socialchannel.type.facebook', 'facebook'],
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_socialchannel.type.pinterest', 'pinterest'],
				],
			],
		],
    ],
];
