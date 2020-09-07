<?php
return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center',
        'label' => 'short_name',
        'label_alt' => 'title, center_name',
        'label_alt_force' => '1',
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
			'ignoreWebMountRestriction' => true,
			'ignoreRootLevelRestriction' => true,
		],
        'searchFields' => 'title, center_name,short_name, objectid',
        'iconfile' => 'EXT:center/Resources/Public/Icons/center.svg'
    ],

    'interface' => [
        'showRecordFieldList' => "sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, objectid
        center_name, short_name, region, page_id, 
        levels, wayfinder_activated, wayfinder_url, facebook_pixel, ga_center, ga_ece_account, gtm_ece_account, use_gtm_ece_account, company, address,  phone, email, lng, lat, map_zoom, title_postfix,
        apps_store_links, social_channels, payment, payment_online_shop, shipping, logo, logo_alt, logo_email, logo_products, gallery, country, timezone",
    ],
	'palettes' => [
		'mapPalette' => ['showitem' => 'override_coordinates, --linebreak--, lng, lat, --linebreak--, map_zoom'],
		'contactPalette' => ['showitem' => 'company,--linebreak--, address, --linebreak--, phone, email'],
        'appStorePalette' => ['showitem' => 'app_store_links'],
		'showFooterPaletteRegister' => ['showitem' => 'show_footer_registration'],
		'timezonePalette' => ['showitem' => 'region, country, timezone'],
        'wayfinderPalette' => ['showitem' => 'wayfinder_activated, wayfinder_url'],
	],
    'types' => [
        '1' => ['showitem' => "title, objectid, center_name, short_name, page_id, logo, logo_alt, logo_email, logo_products, login_activated, login_activated_changed, disable_login_in_web, show_social_login, hide_all_openings,  interest_list,
         --palette--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.palettes.timezonePalette;timezonePalette,
         
        --palette--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.palettes.contactPalette;contactPalette,
        --palette--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.palettes.mapPalette;mapPalette,
		--palette--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.palettes.appStorePalette;appStorePalette,
        apps_store_links, push_server_android_topic, push_server_android_authorization_key, push_server_ios_topic, push_server_ios_authorization_key, coupon_no_login, gallery, 
        --palette--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.palettes.showFooterRegistration;showFooterPaletteRegister,
   		--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,hidden, starttime, endtime,
        --div--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.tabs.opening, weekly_schedule, yearly_schedule,
        --div--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.tabs.seo, title_postfix, social_channels, facebook_pixel, ga_center, ga_ece_account, gtm_ece_account, use_gtm_ece_account,
		--div--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.tabs.center_plan, levels,
		--palette--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.palettes.wayfinderPalette;wayfinderPalette,
		--div--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.tabs.darksite, show_darksite, darksite_title, darksite_text, hide_openings,
		--div--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.tabs.dataProtection, subsidiary, contactperson_dp,
        --div--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.tabs.payment_shipping, payment, payment_online_shop, shipping
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
            'default' => 0
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
                'foreign_table' => 'tx_center_domain_model_center_center',
                'foreign_table_where' => 'AND tx_center_domain_model_center_center.pid=###CURRENT_PID### AND tx_center_domain_model_center_center.sys_language_uid IN (-1,0)',
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
			'exclude' => 1,
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.title',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim, required'
			],
		],

		'objectid' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.objectid',
			'config' => [
				'type' => 'input',
				'size' => 10,
				'eval' => 'trim'
			],
		],

	    'center_name' => [
	        'exclude' => 1,
	        'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.center_name',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
				'eval' => 'trim, required'
			],
	    ],

		'short_name' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.short_name',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim, required'
			],
		],

		'region' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.region',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => [
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.region.1', '1'],
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.region.2', '2'],
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.region.3', '3'],
				],
                'default' => 1
			],
		],

		'facebook_pixel' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.facebook_pixel',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],

	    'ga_center' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.ga_center',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],

		'ga_ece_account' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.ga_ece_account',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'gtm_ece_account' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.gtm_ece_account',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'use_gtm_ece_account' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.use_gtm_ece_account',
			'config' => [
				'type' => 'check',
			],
		],
		'page_id' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.page_id',
			'config' => [
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'pages',
				'size' => '1',
				'maxitems' => '1',
				'minitems' => '1',
                'default' => 0
			],
		],
		'levels' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.levels',
			'config' => [
				'type' => 'inline',
				'foreign_table' => 'tx_center_domain_model_center_centerlevel',
				'foreign_table_where' => ' AND tx_center_domain_model_center_centerlevel.sys_language_uid IN (-1, 0)',
				'foreign_field' => 'center',
				'foreign_sortby' => 'sorting',
				'appearance' => [
					'collapseAll' => true,
					'expandSingle' => true
				],
				'overrideChildTca' => [
					'columns' => [
						'type' => [
							'config' => [
								'default' => 1
							]
						]
					]
				]
			]
		],
        'wayfinder_activated' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.wayfinder_activated',
            'config' => [
                'type' => 'check',
            ],
        ],
        'wayfinder_url' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.wayfinder_url',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'company' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.company',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim, required'
            ],
        ],
		'address' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.address',
			'config' => [
				'type' => 'text',
				'enableRichtext' => true,
				'richtextConfiguration' => 'default',
				'eval' => 'required, trim'
			],
		],
		'phone' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.phone',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'required, trim'
			],
		],
		'email' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.email',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'required, email, trim'
			],
		],
		'lat' => [
			'exclude' => 1,
			'displayCond' => 'FIELD:override_coordinates:>:0',
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.lat',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'required, trim'
			],
		],
		'lng' => [
			'exclude' => 1,
			'displayCond' => 'FIELD:override_coordinates:>:0',
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.lng',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'required, trim'
			],
		],
		'override_coordinates' => [
			'exclude' => 1,
			'onChange' => 'reload',
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.override_coordinates',
			'config' => [
				'onChange' => 'reload',
				'type' => 'check',
                'default' => 0
			],
		],
		'map_zoom' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.map_zoom',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'int',
				'default' => 18,
				'range' => array(
					'lower' => 1,
					'upper' => 20
				),
			],
		],
		'title_postfix' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.title_postfix',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'required'
			],
		],
		'app_store_links' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.app_store_links',
			'config' => [
				'type' => 'inline',
				'foreign_table' => 'tx_center_domain_model_center_appstorelink',
				'foreign_table_where' => ' AND tx_center_domain_model_center_appstorelink.sys_language_uid IN (-1, 0)',
				'foreign_field' => 'center',
				'overrideChildTca' => [
					'columns' => [
						'type' => [
							'config' => [
								'default' => 1
							]
						]
					]
				],
				'appearance' => [
					'collapseAll' => true
				],
				'maxitems' => '5'
			]
		],
		'social_channels' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.social_channels',
			'config' => [
				'type' => 'inline',
				'foreign_table' => 'tx_center_domain_model_center_socialchannel',
				'foreign_table_where' => ' AND tx_center_domain_model_center_socialchannel.sys_language_uid IN (-1, 0)',
				'foreign_field' => 'center',
				'overrideChildTca' => [
					'columns' => [
						'type' => [
							'config' => [
								'default' => "facebook"
							]
						]
					]
				],
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
                ],
				'maxitems' => '5'
			]
		],
        'payment' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.payment',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_center_domain_model_center_payment',
                'foreign_table_where' => ' AND tx_center_domain_model_center_payment.sys_language_uid IN (-1, 0)',
                'foreign_field' => 'center',
                'foreign_sortby' => 'sorting',
                'overrideChildTca' => [
                    'columns' => [
                        'type' => [
                            'config' => [
                                'default' => 1
                            ]
                        ]
                    ]
                ],
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
                ],
                //'maxitems' => '5'
            ]
        ],
        'payment_online_shop' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.payment_online_shop',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_center_domain_model_center_paymentonlineshop',
                'foreign_table_where' => ' AND tx_center_domain_model_center_paymentonlineshop.sys_language_uid IN (-1, 0)',
                'foreign_field' => 'center',
                'foreign_sortby' => 'sorting',
                'overrideChildTca' => [
                    'columns' => [
                        'type' => [
                            'config' => [
                                'default' => 1
                            ]
                        ]
                    ]
                ],
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
                ],
                //'maxitems' => '5'
            ]
        ],

        'shipping' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.shipping',
			'config' => [
				'type' => 'inline',
				'foreign_table' => 'tx_center_domain_model_center_shipping',
				'foreign_table_where' => ' AND tx_center_domain_model_center_shipping.sys_language_uid IN (-1, 0)',
				'foreign_field' => 'center',
                'foreign_sortby' => 'sorting',
                'overrideChildTca' => [
                    'columns' => [
                        'type' => [
                            'config' => [
                                'default' => 1
                            ]
                        ]
                    ]
                ],
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
                ],
				//'maxitems' => '5'
			]
		],
		'logo' => [
			'exclude' => true,
			'l10n_mode' => 'exclude',
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.logo',
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
        'logo_email' => [
            'exclude' => true,
            'l10n_mode' => 'exclude',
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.logo_email',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('logo_email', [
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
            )
        ],
        'logo_alt' => [
            'exclude' => true,
			'l10n_mode' => 'exclude',
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.logo_alt',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('logo_alt', [
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
            )
        ],
        'logo_products' => [
            'exclude' => true,
            'l10n_mode' => 'exclude',
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.logo_products',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('logo_products', [
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
            )
        ],
		'gallery' => [
			'exclude' => 1,
			'displayCond' => 'FIELD:uid:>:0',
			'label' => "LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.gallery",
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => [
					['', 0]
				],
				'foreign_table' => 'tx_center_domain_model_misc_gallery',
				'foreign_table_where' => " AND tx_center_domain_model_misc_gallery.sys_language_uid IN (-1, 0) order by tx_center_domain_model_misc_gallery.title_intern ASC",
				'MM' => 'tx_center_domain_model_misc_gallery_record_mm',
				'MM_opposite_field' => 'items',
				'MM_match_fields' => [
					'tablenames' => 'tx_center_domain_model_center_center',
					'fieldname' => 'gallery',
				],
				'minitems' => 0,
				'maxitems' => 1
			]
		],
		'country' => [
			'exclude' => 1,
			'onChange' => 'reload',
			'label' => "LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.country",
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'tx_center_domain_model_misc_country',
				'foreign_table_where' => "AND tx_center_domain_model_misc_country.sys_language_uid IN (-1, 0)",
				'minitems' => 1,
                'default' => 0
			]
		],
		'timezone' => [
			'exclude' => 1,
			'displayCond' => 'FIELD:country:>:0',
			'label' => "LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.timezone",
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'tx_center_domain_model_misc_timezone',
				'foreign_table_where' => "AND tx_center_domain_model_misc_timezone.uid IN (SELECT uid_foreign FROM tx_center_domain_model_misc_country_tz_mm WHERE tx_center_domain_model_misc_country_tz_mm.uid_local = ###REC_FIELD_country###)",
				'minitems' => 1,
                'default' => 0
			]
		],
		'show_footer_registration' => [
			'exclude' => 1,
			'label' => "LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.showFooterRegistration",
			'config' => [
				'type' => 'check',
				'default' => 1
			]
		],
		'weekly_schedule' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.weekly_schedule',
			'config' => [
				'type' => 'inline',
				'foreign_table' => 'tx_center_domain_model_openinghours_dailyhours',
				'foreign_field' => 'parent',
				'foreign_table_field' => 'parent_table',
				'foreign_sortby' => 'sorting',
				'maxitems' => 7,
				'appearance' => [
					'collapseAll' => true
				]
			]
		],
		'yearly_schedule' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.yearly_schedule',
			'config' => [
				'type' => 'inline',
				'foreign_table' => 'tx_center_domain_model_openinghours_yearlyschedule',
				'foreign_field' => 'parent',
				'foreign_table_field' => 'parent_table',
				'maxitems' => 5,
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
        'show_darksite' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.show_darksite',
            'config' => [
                'type' => 'check',
                'default' => 0
            ],
        ],
        'darksite_title' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.darksite_title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'push_server_android_topic' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.push_server_android_topic',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'push_server_android_authorization_key' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.push_server_android_authorization_key',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'push_server_ios_topic' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.push_server_ios_topic',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'push_server_ios_authorization_key' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.push_server_ios_authorization_key',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'darksite_text' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.darksite_text',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'richtextConfiguration' => 'default',
                'eval' => 'trim'
            ],
        ],
        'hide_openings' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.hide_openings',
            'config' => [
                'type' => 'check',
                'default' => 0
            ],
        ],
        'hide_all_openings' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.hide_all_openings',
            'config' => [
                'type' => 'check',
                'default' => 0
            ],
        ],
		'login_activated' => [
			'exclude' => 1,
			'l10n_mode' => 'exclude',
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.login_activated',
			'config' => [
				'type' => 'check',
                'default' => 0
			],
		],
		'coupon_no_login' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_coupon.noLogin',
			'config' => [
				'type' => 'check',
				'items' => [
					'1' => [
						'0' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_coupon.noLoginDescription'
					]
				],
                'default' => 0
			]
		],
		'login_activated_changed' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.login_activated_changed',
			'l10n_mode' => 'exclude',
			'config' => [
				'type' => 'input',
				'renderType' => 'inputDateTime',
				'eval' => 'datetime',
				'readOnly' => 1
			],
		],
		'disable_login_in_web' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:providerece/Resources/Private/Language/locallang_db.xlf:pages.tx_providerece_disablelogininweb',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => [
					['', 0],
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:pages.tx_providerece_disablelogininweb.onlyLogin', 1],
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:pages.tx_providerece_disablelogininweb.onlyProducts', 2],
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:pages.tx_providerece_disablelogininweb.loginAndProducts', 3]
				]
			]
		],
        'show_social_login' => [
            'exclude' => 1,
            'label' => "LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.show_social_login",
            'config' => [
                'type' => 'check',
                'default' => 1
            ]
        ],
		'interest_list' => [
			'exclude' => 1,
			'l10n_mode' => 'exclude',
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.interest_list',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => [
					['', 0],
				],
				'foreign_table' => 'tx_center_domain_model_interest_interestlist',
				'foreign_table_where' => 'tx_center_domain_model_interest_interestlist.sys_language_uid IN (-1,0)',
                'default' => 0
			],
		],
        'subsidiary' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.palettes.landesgesellschaftPalette',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                        ['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.please_select', 0],
                ],
                'foreign_table' => 'tx_center_domain_model_misc_subsidiary',
                'minitems' => 1,
                'default' => 0
            ],
        ],
        'contactperson_dp' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.palettes.datenschutzbeauftragterPalette',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.please_select', 0],
                ],
                'foreign_table' => 'tx_center_domain_model_misc_contactpersondp',
                'minitems' => 1,
                'default' => 0
            ],
        ],
        'items' => [
            'config' => [
                'type' => 'passthrough'
            ]
        ]
    ],
];
