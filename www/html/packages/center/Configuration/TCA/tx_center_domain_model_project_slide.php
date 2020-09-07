<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_project_slide',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => true,
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
            'ignoreWebMountRestriction' => true,
            'ignoreRootLevelRestriction' => true,
        ],
        'searchFields' => 'title, subtitle',
        'iconfile' => 'EXT:center/Resources/Public/Icons/ext_icon.png'
    ],

    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, subtitle, invert_color, media, media_poster',
    ],
    'types' => [
        '1' => [
            'showitem' => "title, subtitle, invert_color, media, media_poster,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden, starttime, endtime"
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
                'foreign_table' => 'tx_center_domain_model_project_slide',
                'foreign_table_where' => 'AND tx_center_domain_model_project_slide.pid=###CURRENT_PID### AND tx_center_domain_model_project_slide.sys_language_uid IN (-1,0)',
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
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_project_slide.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'required, trim'
            ],
        ],
        'subtitle' => [
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_project_slide.subtitle',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'required, trim'
            ],
        ],
        'invert_color' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_project_slide.invert_color',
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
        'media' => [
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_project_slide.media',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('media', [
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
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                            'showitem' => '
								--palette--;LLL:EXT:lang/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.videoOverlayPalette;videoOverlayPalette,
								--palette--;;filePalette'
                        ],
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
                                    'mobile' => [
                                        'title' => 'Default',
                                        'allowedAspectRatios' => [
                                            '16 : 9' => [
                                                'title' => '16 : 9',
                                                'value' => 16 / 9
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
                'minitems' => 1,
                'maxitems' => 1
            ],
                \DigitalZombies\Center\Utility\TCAFieldHelper::allowedImageExtensions .
                ',' . \DigitalZombies\Center\Utility\TCAFieldHelper::allowedVideoExtensions .
                ',' . \DigitalZombies\Center\Utility\TCAFieldHelper::allowedExternalVideoExtensions
            )
        ],
        'media_poster' => [
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_project_slide.media_poster',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('media_poster', [
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
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                            'showitem' => '
								--palette--;LLL:EXT:lang/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.videoOverlayPalette;videoOverlayPalette,
								--palette--;;filePalette'
                        ],
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

    ],
];
