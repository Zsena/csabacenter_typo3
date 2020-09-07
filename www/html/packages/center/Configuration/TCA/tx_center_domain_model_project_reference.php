<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_project_reference',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => true,

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
            'ignoreWebMountRestriction' => true,
            'ignoreRootLevelRestriction' => true,
        ],
        'searchFields' => 'title, teaser_title, teaser_abstract, mission_copy',
        'iconfile' => 'EXT:center/Resources/Public/Icons/research.svg'
    ],

    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, slides, teaser_title, teaser_image, teaser_abstract, teaser_customer, mission_logo, mission_copy, mission_text, implementation_copy, tables, hero_image, images, download_buttons',
    ],
    'types' => [
        '1' => [
            'showitem' => "title, 
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden, starttime, endtime,
            --div--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_project_reference.tab.slides, slides,
            --div--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_project_reference.tab.mission, mission_logo, mission_copy, mission_text,
            --div--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_project_reference.tab.implementation,
            implementation_copy, tables, hero_image, images, download_buttons,
            --div--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_project_reference.tab.related, related_references,
            --div--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.tabs.seo,seo_title,seo_description,
            --div--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.tabs.og,og_title, og_description, --linebreak--, og_image,
            --div--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.tabs.teaser, teaser_title, teaser_image, teaser_abstract, teaser_customer"
        ],
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
                'foreign_table' => 'tx_center_domain_model_project_reference',
                'foreign_table_where' => 'AND tx_center_domain_model_project_reference.pid=###CURRENT_PID### AND tx_center_domain_model_project_reference.sys_language_uid IN (-1,0)',
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
        'title' => [
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_project_reference.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'required, trim'
            ],
        ],
        'slides' => [
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_project_reference.slides',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_center_domain_model_project_slide',
                'foreign_table_where' => ' AND tx_center_domain_model_project_slide.sys_language_uid IN (-1, 0)',
                'foreign_field' => 'parent',
                'minitems' => 1
            ]
        ],
        'download_buttons' => [
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_project_reference.download_buttons',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_center_domain_model_project_downloadbutton',
                'foreign_table_where' => ' AND tx_center_domain_model_project_downloadbutton.sys_language_uid IN (-1, 0)',
                'foreign_field' => 'parent',
            ]
        ],
        'tables' => [
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_project_reference.tables',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_center_domain_model_project_table',
                'foreign_table_where' => ' AND tx_center_domain_model_project_table.sys_language_uid IN (-1, 0)',
                'foreign_field' => 'parent',
                'minitems' => 0,
                'maxitems' => 3
            ]
        ],
        'images' => [
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_project_reference.images',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('images', [
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
                    ],
                    'columns' => [
                        'crop' => [
                            'config' => [
                                'cropVariants' => [
                                    'default' => [
                                        'title' => 'Default',
                                        'allowedAspectRatios' => [
                                            '1 : 1' => [
                                                'title' => '1 : 1',
                                                'value' => 1 / 1
                                            ]
                                        ],
                                    ],
                                ],
                            ],
                        ]
                    ]
                ],
                'appearance' => [
                    'fileUploadAllowed' => false
                ],
                'maxitems' => 5
            ],
                \DigitalZombies\Center\Utility\TCAFieldHelper::allowedImageExtensions
            )
        ],
        'hero_image' => [
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_project_reference.hero_image',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('hero_image', [
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
                    ],
                    'columns' => [
                        'crop' => [
                            'config' => [
                                'cropVariants' => [
                                    'default' => [
                                        'title' => 'Default',
                                        'allowedAspectRatios' => [
                                            '2 : 1' => [
                                                'title' => '2 : 1',
                                                'value' => 2 / 1
                                            ]
                                        ],
                                    ],
                                ],
                            ],
                        ]
                    ]
                ],
                'appearance' => [
                    'fileUploadAllowed' => false
                ],
                'maxitems' => 1
            ],
                \DigitalZombies\Center\Utility\TCAFieldHelper::allowedImageExtensions
            )
        ],
        'teaser_image' => [
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_project_reference.teaser_image',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('teaser_image', [
                'overrideChildTca' => [
                    'columns' => [
                        'crop' => [
                            'config' => [
                                'cropVariants' => [
                                    'default' => [
                                        'title' => 'Default',
                                        'allowedAspectRatios' => [
                                            '16:9' => [
                                                'title' => '16:9',
                                                'value' => 16 / 9
                                            ]
                                        ],
                                    ],
                                ],
                            ]
                        ]
                    ],
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
            ],
                \DigitalZombies\Center\Utility\TCAFieldHelper::allowedImageExtensions
            )
        ],
        'teaser_title' => [
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_project_reference.teaser_title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'required, trim'
            ],
        ],
        'teaser_abstract' => [
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_project_reference.teaser_abstract',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'required, trim'
            ],
        ],
        'teaser_customer' => [
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_project_reference.teaser_customer',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim'
            ],
        ],
        'mission_logo' => [
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_project_reference.mission_logo',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('mission_logo', [
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
            ],
                \DigitalZombies\Center\Utility\TCAFieldHelper::allowedImageExtensions
            )
        ],
        'mission_copy' => [
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_project_reference.mission_copy',
            'config' => [
                'type' => 'text',
                'size' => 30,
                'rows' => 3,
                'eval' => 'trim',
                'enableRichtext' => true,
                'richtextConfiguration' => 'default',
            ],
        ],
        'mission_text' => [
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_project_reference.mission_text',
            'config' => [
                'type' => 'text',
                'columns' => 50,
                'rows' => 6,
                'eval' => 'trim',
            ],
        ],
        'implementation_copy' => [
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_project_reference.implementation_copy',
            'config' => [
                'type' => 'text',
                'columns' => 30,
                'rows' => 3,
                'eval' => 'required,trim',
                'enableRichtext' => true,
                'richtextConfiguration' => 'default',
            ],
        ],
        'seo_title' => [
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_project_reference.seo_title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim'
            ],
        ],
        'seo_description' => [
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_project_reference.seo_description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim'
            ],
        ],
        'related_references' => [
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_project_reference.related_references',
            'config' => [
                'minitems' => 0,
                'maxitems' => 3,
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_center_domain_model_project_reference',
                'foreign_table_where' => 'AND tx_center_domain_model_project_reference.sys_language_uid IN (-1,0) AND tx_center_domain_model_project_reference.uid != ###THIS_UID### ORDER BY tx_center_domain_model_project_reference.title',
                'MM' => 'tx_center_domain_model_project_reference_reference_mm',
            ],
        ],
        'og_title' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.og_title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'og_description' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.og_description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'og_image' => [
            'exclude' => true,
            'l10n_mode' => 'exclude',
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.og_image',
            'pnpu_description' => [
                'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.teaser_image.description',
                'extensionName' => 'center',
                'arguments' => [
                    '2',
                    '16:9'
                ]
            ],
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('og_image', [
                // Use the imageoverlayPalette instead of the basicoverlayPalette
                'overrideChildTca' => [
                    'types' => [
                        '0' => [
                            'showitem' => '
									--palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                            'showitem' => '
									--palette--;;filePalette'
                        ]
                    ]
                ],
                'appearance' => [
                    'fileUploadAllowed' => false
                ],
                'minitems' => 0,
                'maxitem' => 1
            ],
                \DigitalZombies\Center\Utility\TCAFieldHelper::JPEG_ONLY
            )
        ],
    ],
];
