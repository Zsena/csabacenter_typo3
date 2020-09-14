<?php
defined('TYPO3_MODE') || die();


call_user_func(
	function ($extKey, $table) {
		$shopDoktype = \DigitalZombies\Center\Domain\Model\Shop\Shop::DOKTYPE;
		$gastroDoktype = \DigitalZombies\Center\Domain\Model\Shop\Gastro::DOKTYPE;
		$blogDoktype = \DigitalZombies\Center\Domain\Model\Records\Blog::DOKTYPE;
		$shopListDokType = \DigitalZombies\Center\Domain\Model\Shop\Shop::LIST_DOKTYPE;
		$serviceListDokType = \DigitalZombies\Center\Domain\Model\Records\Service::LIST_DOKTYPE;
		// Add new page type as possible select item:
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
			$table,
			'doktype',
			[
				'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_shop_shop',
				$shopDoktype
			],
			'1',
			'after'
		);
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
			$table,
			'doktype',
			[
				'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_shop_gastro',
				$gastroDoktype
			],
			'1',
			'after'
		);
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
			$table,
			'doktype',
			[
				'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_blog',
				$blogDoktype
			],
			'1',
			'after'
		);
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
			$table,
			'doktype',
			[
				'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_shop_shoplist',
				$shopListDokType
			],
			'1',
			'after'
		);

		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
			$table,
			'doktype',
			[
				'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_shop_servicelist',
				$serviceListDokType
			],
			'1',
			'after'
		);
		// Add icon for new page type:
		\TYPO3\CMS\Core\Utility\ArrayUtility::mergeRecursiveWithOverrule(
			$GLOBALS['TCA']['pages'],
			[
				'ctrl' => [
					'typeicon_classes' => [
						$shopDoktype => 'apps-pagetree-shop',
						$serviceListDokType => 'records-service',
						$gastroDoktype => 'apps-pagetree-gastro',
						$blogDoktype => 'apps-pagetree-blog',
						$shopListDokType => 'apps-pagetree-default',
                        $serviceListDokType => 'apps-pagetree-default',
					],
				],
				'types' => [
					$shopDoktype => [
						'showitem' => $GLOBALS['TCA']['pages']['types']['1']['showitem']
					],
					$gastroDoktype => [
						'showitem' => $GLOBALS['TCA']['pages']['types']['1']['showitem']
					],
					$blogDoktype => [
						'showitem' => $GLOBALS['TCA']['pages']['types']['1']['showitem']
					],
					$shopListDokType => [
						'showitem' => $GLOBALS['TCA']['pages']['types']['1']['showitem']
					],
					$serviceListDokType => [
						'showitem' => $GLOBALS['TCA']['pages']['types']['1']['showitem']
					],
				]
			]
		);

	},
	'center',
	'pages'
);


$tmp_columns = [

	'tx_center_center' => [
		'exclude' => 1,
		'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:pages.tx_center_center',
		'config' => [
			'type' => 'inline',
			'foreign_table' => 'tx_center_domain_model_center_center',
			'foreign_match_fields' => [
				'sys_language_uid' => '0',
			],
			'foreign_field' => 'page_id',
			'appearance' => [
				'useSortable' => false,
				'showPossibleLocalizationRecords' => false,
				'showRemovedLocalizationRecords' => false,
				'showSynchronizationLink' => false,
				'showAllLocalizationLink' => false,

				'enabledControls' => [
					'info' => false,
					'new' => false,
					'dragdrop' => false,
					'sort' => false,
					'hide' => false,
					'delete' => false,
					'localize' => false,
				]
			]
		],
	],
	'center' => [
		'exclude' => 1,
		'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_shop_shop.center',
		'config' => [
			'type' => 'select',
			'renderType' => 'selectSingle',
			'disableNoMatchingValueElement' => true,
			'foreign_table' => 'tx_center_domain_model_center_center',
			'foreign_table_where' => 'tx_center_domain_model_center_center.sys_language_uid IN (0, -1) AND tx_center_domain_model_center_center.page_id > 0 AND (tx_center_domain_model_center_center.page_id = ###SITEROOT###
							OR (\'\' = ###SITEROOT### AND (0 = \'###PAGE_TSCONFIG_IDLIST###\' OR tx_center_domain_model_center_center.page_id IN (###PAGE_TSCONFIG_IDLIST###))))',
			'minitems' => 1,
            'default' => 0
		],
	],
	'logo' => [
		'exclude' => true,
		'displayCond' => 'FIELD:chain_store:=:0',
		'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_shop_shop.logo',
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
	'shop_name' => [
		'exclude' => 1,
		'displayCond' => 'FIELD:chain_store:=:0',
		'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_shop_shop.shop_name',
		'config' => [
			'type' => 'input',
			'size' => 30,
			'eval' => 'required'
		],
	],
	'positions' => [
		'exclude' => 1,
		'displayCond' => 'FIELD:center:>:0',
		'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_shop_shop.position',
        'pnpu_description' => [
            'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_shop_shop.position.info',
            'extensionName' => 'center',
            'arguments' => [
                '2',
                '16:9'
            ]
        ],
		'config' => [
			'type' => 'inline',
			'foreign_table' => 'tx_center_domain_model_center_centerlevelposition',
			'foreign_table_where' => ' AND tx_center_domain_model_center_centerlevelposition.sys_language_uid IN (-1, 0)',
			'foreign_field' => 'shop',
		]
	],
	'chain_store' => [
		'exclude' => 1,
		'onChange' => 'reload',
		'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_shop_shop.chain_store',
		'config' => [
			'type' => 'select',
			'renderType' => 'selectSingle',
			'items' => [
				['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.please_select', 0],
			],
			'foreign_table' => 'tx_center_domain_model_shop_chainstore',
			'foreign_table_where' => ' AND tx_center_domain_model_shop_chainstore.sys_language_uid IN (-1, 0) ORDER BY tx_center_domain_model_shop_chainstore.name',
            'default' => 0
		]
	],
	'shop_list_type' => [
		'exclude' => 1,
		'onChange' => 'reload',
		'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_shop_shoplist.shop_list_type',
		'config' => [
			'type' => 'select',
			'renderType' => 'selectSingle',
			'items' => [
				['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_shop_shop',
					\DigitalZombies\Center\Domain\Model\Shop\Shop::TYPE],
				['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_shop_gastro',
					\DigitalZombies\Center\Domain\Model\Shop\Gastro::TYPE],
				['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:shop_and_gastro_list_type',
					\DigitalZombies\Center\Domain\Model\Shop\Shop::TYPE . '_' . \DigitalZombies\Center\Domain\Model\Shop\Gastro::TYPE],
			],
			'default' => \DigitalZombies\Center\Domain\Model\Shop\Shop::TYPE
		]
	],
	'weekly_schedule' => [
		'exclude' => 1,
		'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:pages.weekly_schedule',
		'config' => [
			'type' => 'inline',
			'foreign_table' => 'tx_center_domain_model_openinghours_dailyhours',
			'foreign_field' => 'parent',
			'foreign_table_field' => 'parent_table',
			'maxitems' => 7,
			'appearance' => [
				'collapseAll' => true
			]
		]
	],
	'service_tag' => [
		'exclude' => 1,
		'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:pages.service_tag',
		'config' => [
			'type' => 'select',
			'renderType' => 'selectSingle',
			'items' => [
				['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.please_select', 0],
			],
			'foreign_table' => 'tx_center_domain_model_misc_tag',
			'foreign_table_where' => "tx_center_domain_model_misc_tag.type IN ('" .\DigitalZombies\Center\Domain\Model\Records\Service::TYPE . "','"
				. \DigitalZombies\Center\Domain\Model\RecordBase::TYPE . "') ORDER BY tx_center_domain_model_misc_tag.type DESC, tx_center_domain_model_misc_tag.title",
			'minitems' => 1,
			'maxitems' => 1,
			'appearance' => [
				'collapseAll' => true
			],
            'default' => 0
		]
	],
	'yearly_schedule' => [
		'exclude' => 1,
		'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:pages.yearly_schedule',
		'config' => [
			'type' => 'inline',
			'foreign_table' => 'tx_center_domain_model_openinghours_yearlyschedule',
			'foreign_field' => 'parent',
			'foreign_table_field' => 'parent_table',
			'maxitems' => 5,
			'appearance' => [
				'collapseAll' => true
			]
		]
	],
	'publishing_date' => [
		'exclude' => 1,
		'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:pages.publishingDate',
		'config' => [
			'type' => 'input',
			'renderType' => 'inputDateTime',
			'eval' => 'datetime, required',
            'default' => 0
		]
	],
	'phone' => [
		'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:pages.phone',
		'config' => [
			'type' => 'input',
			'size' => 30,
			'max' => 255,
			'eval' => 'trim'
		],
	],
	'website' => [
		'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:pages.website',
		'config' => [
			'type' => 'input',
			'size' => 30,
			'max' => 255,
			'eval' => 'trim'
		],
	],
	'email' => [
		'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:pages.email',
		'config' => [
			'type' => 'input',
			'size' => 30,
			'max' => 255,
			'eval' => 'trim'
		],
	],
	'chain_store_contact' => [
		'exclude' => 1,
		'displayCond' => 'FIELD:chain_store:!=:0',
		'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:pages.chain_store_contact',
		'config' => [
			'type' => 'check',
			'items' => [
				'1' => [
					'0' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:pages.use_chain_store_contact'
				]
			],
            'default' => 0
		],
	],
	'chain_store_tags' => [
		'exclude' => 1,
		'onChange' => 'reload',
		'displayCond' => 'FIELD:chain_store:!=:0',
		'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:pages.chain_store_tags',
		'config' => [
			'type' => 'check',
			'items' => [
				'1' => [
					'0' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:pages.use_chain_store_tags'
				]
			],
            'default' => 0
		],
	],
	'chain_store_text' => [
		'exclude' => 1,
		'onChange' => 'reload',
		'displayCond' => 'FIELD:chain_store:!=:0',
		'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:pages.chain_store_text',
		'config' => [
			'type' => 'check',
			'items' => [
				'1' => [
					'0' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:pages.use_chain_store_text'
				]
			],
            'default' => 0
		],
	],
	'no_list' => [
		'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:pages.no_list',
		'config' => [
			'type' => 'check',
			'items' => [
				'1' => [
					'0' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:pages.no_list.enable'
				]
			],
            'default' => 0
		],
	],
	'teaser_image_blog' => [
		'exclude' => true,
		'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.teaser_image',
		'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('teaser_image', [
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
											'5 : 6' => [
												'title' => '5 : 6',
												'value' => 5 / 6
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
				'minitems' => 0,
				'maxitems' => 1
			],
			\DigitalZombies\Center\Utility\TCAFieldHelper::allowedImageExtensions
		)
	],
    'page_icon' => [
        'exclude' => 1,
        'l10n_mode' => 'exclude',
        'displayCond' => [
            'OR' => [
                'FIELD:global_service:=:0',
                'FIELD:global_service:=:',
            ],
        ],
        'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_page.icon',
        'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('page_icon', [
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
    ],
	'hide_in_app' => [
		'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.hide_in_app',
		'pnpu_description' => [
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.hide_in_app.description',
			'extensionName' => 'center',
		],
		'config' => [
			'type' => 'select',
			'renderType' => 'selectSingle',
			'items' => [
				['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.hide_in_app.show_always', 0],
				['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.hide_in_app.hide_in_app', \DigitalZombies\Center\Constants\HideInApp::HIDE_IN_APP],
				['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.hide_in_app.only_in_app', \DigitalZombies\Center\Constants\HideInApp::ONLY_IN_APP],
			],
            'default' => 0
		]
	],
    'print_pdf_link' => [
        'exclude' => 1,
        'displayCond' => 'FIELD:backend_layout:=:pagets__contentPage',
        'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:pages.print_pdf_link',
        'config' => [
            'type' => 'check',
            'items' => [
                '1' => [
                    '0' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:pages.print_pdf_link.description'
                ]
            ],
            'default' => 0
        ],
    ],
    'company' => [
        'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.company',
        'l10n_mode' => 'exclude',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'max' => 255,
            'eval' => 'trim'
        ],
    ],
    'address' => [
        'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_misc_contactperson.address',
        'l10n_mode' => 'exclude',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'max' => 255,
            'eval' => 'trim'
        ],
    ],
    'zip_city' => [
        'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_shop_chainstore.zipcity',
        'l10n_mode' => 'exclude',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'max' => 255,
            'eval' => 'trim'
        ],
    ],
    'app_key' => [
        'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:pages.app_key',
        'l10n_mode' => 'exclude',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'max' => 255,
            'eval' => 'trim'
        ],
    ]
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
	'pages',
	'--div--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:pages.center_tab, tx_center_center'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
	'pages',
	'visibility',
	'--linebreak--,hide_in_app,--linebreak--,app_key',
	'after:tx_providerece_hidesubmenu'
);

/*
 * BEGIN TCAHelper
 * Add extra fields with help of the TCAField Helper.
 */

$seoFields = \DigitalZombies\Center\Utility\TCAFieldHelper::getSEOFields();
$tmp_columns = array_merge($tmp_columns, $seoFields);

$ogFields = \DigitalZombies\Center\Utility\TCAFieldHelper::getOGFields();
$tmp_columns = array_merge($tmp_columns, $ogFields);

$teaserFields = \DigitalZombies\Center\Utility\TCAFieldHelper::getTeaserFields(3,
	\DigitalZombies\Center\Utility\TCAFieldHelper::TEASER_TYPE_PROP,
	true,
	true,
	true,
	false,
	true,
	false);

$tmp_columns = array_merge($tmp_columns, $teaserFields);

/*
 * The config array has the name of the field content_<field_name>. (Each field has the prefix "content_")
 * There are always one possible settings:
 * required => it decides if the field should be required or optional. (if it is not defined, the default is false)
 */

$config = [
	'headline' => [
		'needed' => true,
		'required' => false
	],
	'text' => [
		'needed' => true,
		'required' => false
	],
	'gallery' => ['tablenames' => 'pages']
];
$contentFields = \DigitalZombies\Center\Utility\TCAFieldHelper::getContentFields($config);
$tmp_columns = array_merge($tmp_columns, $contentFields);

foreach ($tmp_columns as $key => $fieldInfo) {
	if(isset($fieldInfo['l10n_mode'])) {
		unset($tmp_columns[$key]['l10n_mode']);
	}
}
/*
 * END TCAHelper
 */

$palettes = \DigitalZombies\Center\Utility\TCAFieldHelper::getPalettes();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages', $tmp_columns);


$palettes['teaserBlogPalette'] = ['showitem' => 'teaser_format, --linebreak--, teaser_abstract, --linebreak--, teaser_image_blog, --linebreak--, teaser_image2, --linebreak--, teaser_image3, --linebreak--, teaser_video'];
$palettes['teaserContentPalette'] = ['showitem' => 'teaser_format, --linebreak--, teaser_abstract, --linebreak--, teaser_image, --linebreak--, teaser_image2, --linebreak--, teaser_image3, --linebreak--, teaser_video, --linebreak--, page_icon'];
$palettes['searchPalette'] = ['showitem' => 'no_search;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.no_search_formlabel'];

foreach ($palettes as $paletteName => $paletteConf) {
	$GLOBALS['TCA']['pages']['palettes'][$paletteName] = $paletteConf;
}



//Type setting for the shop page type only (everything hidden from the page and each needed fields are "white-listed")
$GLOBALS['TCA']['pages']['types'][\DigitalZombies\Center\Domain\Model\Shop\Shop::DOKTYPE] = [
	'showitem' => '
	 	--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general, doktype, title, path_segment, nav_title, chain_store, shop_name, logo, center, positions,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, hidden,starttime, endtime,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.behaviour,--palette--;;searchPalette, no_list'
		. \DigitalZombies\Center\Utility\TCAFieldHelper::getContentTab('content_headline, chain_store_text, content_text, content_gallery')
		. ',--div--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:pages.tabs.contact, chain_store_contact, phone, website, email, company, address, zip_city'
		. ',--div--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:pages.tabs.opening, weekly_schedule, yearly_schedule'
        . ',--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.language;language,'
		. \DigitalZombies\Center\Utility\TCAFieldHelper::getSEOTab("keywords")
		. \DigitalZombies\Center\Utility\TCAFieldHelper::getSocialMediaTab()
		. ',--div--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.tabs.tags, chain_store_tags'
];

//Type setting for the blog page type only (everything hidden from the page and each needed fields are "white-listed")
$GLOBALS['TCA']['pages']['types'][\DigitalZombies\Center\Domain\Model\Records\Blog::DOKTYPE] = [
	'showitem' => '
	 	--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general, doktype, title, path_segment, nav_title, starttime, center,
		--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, hidden, nav_hide, endtime, hide_in_app,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.behaviour,--palette--;;searchPalette'
        . ',--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.language;language,'
        . ',--div--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.tabs.teaser,--palette--;;teaserBlogPalette'
		. \DigitalZombies\Center\Utility\TCAFieldHelper::getSEOTab("keywords")
		. \DigitalZombies\Center\Utility\TCAFieldHelper::getSocialMediaTab()
];

//Gastro type is a copy of the shop
$GLOBALS['TCA']['pages']['types'][\DigitalZombies\Center\Domain\Model\Shop\Gastro::DOKTYPE] =
	$GLOBALS['TCA']['pages']['types'][\DigitalZombies\Center\Domain\Model\Shop\Shop::DOKTYPE];


//Shop List type settings
$GLOBALS['TCA']['pages']['types'][\DigitalZombies\Center\Domain\Model\Shop\Shop::LIST_DOKTYPE] = [
	'showitem' => '
	 	--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general, doktype, title, path_segment, nav_title, company, address, zip_city, shop_list_type,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, hidden,starttime, endtime,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.language;language,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.behaviour,--palette--;;searchPalette'
		. \DigitalZombies\Center\Utility\TCAFieldHelper::getSEOTab()
		. \DigitalZombies\Center\Utility\TCAFieldHelper::getSocialMediaTab()
];
//Service List type settings
$GLOBALS['TCA']['pages']['types'][\DigitalZombies\Center\Domain\Model\Records\Service::LIST_DOKTYPE] = [
	'showitem' => '
	 	--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general, doktype, title, path_segment, nav_title, service_tag,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, hidden,starttime, endtime, hide_in_app,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.language;language,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.behaviour,--palette--;;searchPalette'
		. \DigitalZombies\Center\Utility\TCAFieldHelper::getSEOTab()
		. \DigitalZombies\Center\Utility\TCAFieldHelper::getSocialMediaTab()
];

$GLOBALS['TCA']['pages']['types'][\TYPO3\CMS\Frontend\Page\PageRepository::DOKTYPE_DEFAULT] = [
	'showitem' => '
	                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.standard;standard,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.title;title,
                --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.metadata,
                    --palette--;;ogPalette,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.abstract;abstract,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.metatags;metatags,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.editorial;editorial,
                --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.appearance,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.layout;layout,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.replace;replace,
                --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.behaviour, print_pdf_link,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.caching;caching,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.miscellaneous;miscellaneous,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.module;module,
                --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.resources,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.config;config,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.language;language,
                --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.access,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.visibility;visibility,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.access;access,
			   	--div--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:pages.center_tab, tx_center_center,
                --div--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.tabs.teaser,center,--palette--;;teaserContentPalette
            '
];

$GLOBALS['TCA']['pages']['types'][\TYPO3\CMS\Frontend\Page\PageRepository::DOKTYPE_LINK] = [
    'showitem' => '
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                    doktype,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.title;title,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.external;external,
                --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.metadata,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.abstract;abstract,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.editorial;editorial,
                --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.appearance,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.layout;layout,
                --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.behaviour,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.links;links,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.miscellaneous;miscellaneous,
                --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.resources,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.media;media,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.config;config,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.language;language,
                --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.access,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.visibility;visibility,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.access;access,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
                    categories,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
                --div--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.tabs.teaser,center,--palette--;;teaserContentPalette
            '
];

$GLOBALS['TCA']['pages']['types'][\TYPO3\CMS\Frontend\Page\PageRepository::DOKTYPE_SHORTCUT] = [
	'showitem' => '
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                    doktype,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.title;title,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.shortcut;shortcut,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.shortcutpage;shortcutpage,
                --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.metadata,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.abstract;abstract,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.editorial;editorial,
                --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.appearance,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.layout;layout,
                --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.behaviour,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.miscellaneous;miscellaneous,
                --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.resources,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.config;config,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.language;language,
                --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.access,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.visibility;visibility,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.access;access,
                --div--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.tabs.teaser,center,--palette--;;teaserContentPalette
            '
];

\DigitalZombies\Center\Utility\TaggingHelper::enhanceWithTag(
	'pages',
	[
		'overrideLabel' => true,
		'removeLanguageMode' => true,
		'withoutTab' => true,
		'typesList' => \DigitalZombies\Center\Domain\Model\Shop\Shop::DOKTYPE
	],
	'shop_tags',
	\DigitalZombies\Center\Domain\Model\Shop\Shop::TYPE
);

\DigitalZombies\Center\Utility\TaggingHelper::enhanceWithTag(
	'pages',
	[
		'overrideLabel' => true,
		'removeLanguageMode' => true,
		'withoutTab' => true,
		'typesList' => \DigitalZombies\Center\Domain\Model\Shop\Gastro::DOKTYPE
	],
	'gastro_tags',
	\DigitalZombies\Center\Domain\Model\Shop\Gastro::TYPE
);

\DigitalZombies\Center\Utility\TaggingHelper::enhanceWithTag(
	'pages',
	[
		'overrideLabel' => true,
		'removeLanguageMode' => true,
		'typesList' => \DigitalZombies\Center\Domain\Model\Records\Blog::DOKTYPE
	],
	'blog_tags',
	\DigitalZombies\Center\Domain\Model\Records\Blog::TYPE
);

\DigitalZombies\Center\Utility\TaggingHelper::enhanceWithTag(
	'pages',
	[
		'overrideLabel' => true,
		'removeLanguageMode' => true,
		'typesList' => \DigitalZombies\Center\Domain\Model\Shop\Shop::LIST_DOKTYPE
	],
	'shop_tags',
	\DigitalZombies\Center\Domain\Model\Shop\Shop::TYPE
);

\DigitalZombies\Center\Utility\TaggingHelper::enhanceWithTag(
	'pages',
	[
		'overrideLabel' => true,
		'removeLanguageMode' => true,
		'withoutTab' => true,
		'typesList' => \DigitalZombies\Center\Domain\Model\Shop\Shop::LIST_DOKTYPE
	],
	'gastro_tags',
	\DigitalZombies\Center\Domain\Model\Shop\Gastro::TYPE
);

\DigitalZombies\Center\Utility\TaggingHelper::enhanceWithTag(
	'pages',
	[
		'removeLanguageMode' => true,
		'withoutTab' => true,
		'typesList' => \DigitalZombies\Center\Domain\Model\Records\Blog::DOKTYPE . ','
			. \DigitalZombies\Center\Domain\Model\Shop\Shop::LIST_DOKTYPE  . ','
			. \DigitalZombies\Center\Domain\Model\Shop\Gastro::DOKTYPE  . ','
			. \DigitalZombies\Center\Domain\Model\Shop\Shop::DOKTYPE
	]
);

//We have rools only for the rootpages so we need to reload the backend form if this value is changed
$GLOBALS['TCA']['pages']['columns']['is_siteroot']['onChange'] = 'reload';
$GLOBALS['TCA']['pages']['columns']['backend_layout']['onChange'] = 'reload';
