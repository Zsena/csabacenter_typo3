<?php
return [
	'ctrl' => [
		'title' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_tag',
		'descriptionColumn' => 'description',
		'label' => 'title',
		'type' => 'type',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'delete' => 'deleted',
		'sortby' => 'sorting',
		'versioningWS' => true,
		'rootLevel' => -1,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'searchFields' => 'title,description',
		'enablecolumns' => [
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime'
		],
		'security' => [
			'ignoreRootLevelRestriction' => true,
		],
		'iconfile' => 'EXT:center/Resources/Public/Icons/ext_icon.png'
	],
	'interface' => [
		'showRecordFieldList' => 'title,description'
	],
	'types' => [
		'1' => [
			'showitem' => '
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                    title, type, parent,
                --div--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_tag.tabs.items,
                    items,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                    --palette--;;language,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden, starttime, endtime
            ',
		],
		\DigitalZombies\Center\Domain\Model\RecordBase::TYPE => [
			'showitem' => '
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                    title, type, parent, service_category_icon,
                --div--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_tag.tabs.items,
                    items,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                    --palette--;;language,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden, starttime, endtime
            ',
		],
		\DigitalZombies\Center\Domain\Model\Records\Service::TYPE => [
			'showitem' => '
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                    title, type, parent, service_category_icon,
                --div--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_tag.tabs.items,
                    items,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                    --palette--;;language,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden, starttime, endtime
            ',
		]

	],
	'palettes' => [
		'language' => ['showitem' => 'sys_language_uid, l10n_parent'],
	],
	'columns' => [
		't3ver_label' => [
			'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'max' => 30
			]
		],
		'sys_language_uid' => [
			'exclude' => true,
			'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.language',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => [
					['LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages', -1],
					['LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.default_value', 0]
				],
				'default' => 0,
				'fieldWizard' => [
					'selectIcons' => [
						'disabled' => false,
					],
				],
			]
		],
		'l10n_parent' => [
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => true,
			'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => [
					['', 0]
				],
				'foreign_table' => 'tx_center_domain_model_misc_tag',
				'foreign_table_where' => 'AND tx_center_domain_model_misc_tag.uid=###REC_FIELD_l10n_parent### AND tx_center_domain_model_misc_tag.sys_language_uid IN (-1,0)',
				'default' => 0
			]
		],
		'l10n_diffsource' => [
			'config' => [
				'type' => 'passthrough',
				'default' => ''
			]
		],
		'hidden' => [
			'exclude' => true,
			'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
			'config' => [
				'type' => 'check'
			]
		],
		'starttime' => [
			'exclude' => true,
			'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
			'config' => [
				'type' => 'input',
				'renderType' => 'inputDateTime',
                'eval' => 'datetime',
				'default' => 0,
				'behaviour' => [
					'allowLanguageSynchronization' => true,
				]
			]
		],
		'endtime' => [
			'exclude' => true,
			'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
			'config' => [
				'type' => 'input',
				'renderType' => 'inputDateTime',
				'default' => 0,
                'eval' => 'datetime',
				'range' => [
					'upper' => mktime(0, 0, 0, 1, 1, 2038),
				],
				'behaviour' => [
					'allowLanguageSynchronization' => true,
				]
			]
		],
		'title' => [
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_tag.title',
			'config' => [
				'type' => 'input',
				'width' => 200,
				'eval' => 'trim,required'
			]
		],
		'parent' => [
			'displayCond' => 'FIELD:type:REQ:true',
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_tag.parent',
			'config' => [
				'minitems' => 0,
				'maxitems' => 1,
				'type' => 'select',
				'renderType' => 'selectTree',
				'foreign_table' => 'tx_center_domain_model_misc_tag',
				'foreign_table_where' => ' AND tx_center_domain_model_misc_tag.type = \'###REC_FIELD_type###\' AND tx_center_domain_model_misc_tag.sys_language_uid IN (-1,0) ORDER BY tx_center_domain_model_misc_tag.sorting ASC',
				'treeConfig' => [
					'parentField' => 'parent',
					'appearance' => [
						'expandAll' => true,
						'showHeader' => true,
						'maxLevels' => 99,
					],
				],
				'default' => 0
			]
		],
		'items' => [
			'displayCond' => 'FIELD:type:REQ:true',
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_tag.items',
			'config' => [
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => '*',
				'MM' => 'tx_center_domain_model_misc_tag_record_mm',
				'MM_oppositeUsage' => [],
				'size' => 10,
				'fieldWizard' => [
					'recordsOverview' => [
						'disabled' => true,
					],
				],
			],
		],
		'type' => [
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_tag.type',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => [
					['', ''],
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:'
						. \DigitalZombies\Center\Domain\Model\RecordBase::TYPE,
						\DigitalZombies\Center\Domain\Model\RecordBase::TYPE],
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:'
						. \DigitalZombies\Center\Domain\Model\Shop\Shop::TYPE,
						\DigitalZombies\Center\Domain\Model\Shop\Shop::TYPE],
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:'
						. \DigitalZombies\Center\Domain\Model\Shop\Gastro::TYPE,
						\DigitalZombies\Center\Domain\Model\Shop\Gastro::TYPE],
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:'
						. \DigitalZombies\Center\Domain\Model\Records\Event::TYPE,
						\DigitalZombies\Center\Domain\Model\Records\Event::TYPE],
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:'
						. \DigitalZombies\Center\Domain\Model\Records\News::TYPE,
						\DigitalZombies\Center\Domain\Model\Records\News::TYPE],
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:'
						. \DigitalZombies\Center\Domain\Model\Records\Job::TYPE,
						\DigitalZombies\Center\Domain\Model\Records\Job::TYPE],
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:'
						. \DigitalZombies\Center\Domain\Model\Records\Offer::TYPE,
						\DigitalZombies\Center\Domain\Model\Records\Offer::TYPE],
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:'
						. \DigitalZombies\Center\Domain\Model\Records\Service::TYPE,
						\DigitalZombies\Center\Domain\Model\Records\Service::TYPE],
                    ['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:'
                        . \DigitalZombies\Center\Domain\Model\Records\Blog::TYPE,
                        \DigitalZombies\Center\Domain\Model\Records\Blog::TYPE],
                    ['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:'
                        . \DigitalZombies\Center\Domain\Model\Project\Reference::TYPE,
                        \DigitalZombies\Center\Domain\Model\Project\Reference::TYPE],
				],
				'minitems' => 1
			]
		],
		'service_category_icon' => [
			'exclude' => 1,
			'l10n_mode' => 'exclude',
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_tag.service_category_icon',
			'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('service_category_icon', [
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
					'minitems' => 0,
					'maxitems' => 1
				]
				,'svg')
		]
	],
];
