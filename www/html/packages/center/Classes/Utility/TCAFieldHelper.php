<?php
namespace DigitalZombies\Center\Utility;

/***************************************************************
 *  Copyright notice
 *
 *    Based on:
 *
 *  (c) 2017 András Ottó <andras.otto@plan-net.com>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use DigitalZombies\Center\Constants\HideInApp;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;


class TCAFieldHelper
{

	const RATIO_35_10 = 1;
	const RATIO_16_9 = 2;
	const RATIO_5_6 = 3;

	const TEASER_TYPE_PROP = 1;
	const TEASER_TYPE_COVER = 2;

	/**
	 * @var string
	 */
	const allowedImageExtensions = 'gif,jpg,jpeg,png,svg';

	/**
	 * @var string
	 */
	const allowedVideoExtensions = 'mp4';

	/**
	 * @var string
	 */
	const allowedExternalVideoExtensions = 'youtube';

	/**
	 * @var string
	 */
	const allowedFileDownloads = 'zip,ppt,pdf';

	/**
	 *
	 */
	const JPEG_ONLY = 'jpeg,jpg';


	/**
	 * Returns the OpenGraph tags as a tca configuration.
	 * The field names are fix:
	 * og_title
	 * og_description
	 * og_image
	 *
	 * @param bool $titleRequired
	 * @param bool $descriptionRequired
	 * @param bool $imageRequired
	 * @param int $imageMaxItems
	 *
	 * @return array
	 */
	public static function getOGFields($titleRequired = false,
									   $descriptionRequired = false,
									   $imageRequired = false,
									   $imageMaxItems = 100)
	{
		$ogFields = [

			'og_title' => [
				'exclude' => 1,
				'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.og_title',
				'config' => [
					'type' => 'input',
					'size' => 30,
					'eval' => 'trim' . ($titleRequired ? ', required' : '')
				],
			],
			'og_description' => [
				'exclude' => 1,
				'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.og_description',
				'config' => [
					'type' => 'input',
					'size' => 30,
					'eval' => 'trim' . ($descriptionRequired ? ', required' : '')
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
				'config' => ExtensionManagementUtility::getFileFieldTCAConfig('og_image', [
					// Use the imageoverlayPalette instead of the basicoverlayPalette
					'overrideChildTca' => [
						'types' => [
							'0' => [
								'showitem' => '
									--palette--;;filePalette'
							],
							File::FILETYPE_IMAGE => [
								'showitem' => '
									--palette--;;filePalette'
							]
						]
					],
					'appearance' => [
						'fileUploadAllowed' => false
					],
					'minitems' => ($imageRequired ? 1 : 0),
					'maxitem' => $imageMaxItems
				],
					self::JPEG_ONLY
				)
			],
		];

		return $ogFields;
	}

	/**
	 * Returns the OpenGraph tags as a tca configuration.
	 * config:
	 *            headline =>
	 *                required => true/false
	 *            text =>
	 *                required => true/false
	 *
	 *
	 * Always a fieldName with one keys inside: required.
	 * If required not set it is like it would have the value "false"
	 *
	 * Field names as input:
	 * headline, text
	 *
	 * The field names are fix:
	 * content_headline
	 * content_text
	 *
	 * @param array $config
	 *
	 * @return array
	 */
	public static function getContentFields($config)
	{

		$contentFields = [];

		if (self::isFieldNeeded($config, 'headline')) {
			$contentFields['content_headline'] = [
				'exclude' => 1,
				'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.content_headline',
				'config' => [
					'type' => 'input',
					'size' => 30,
					'max' => 255,
					'eval' => 'trim' . (self::isFieldRequired($config, 'headline') ? ',required' : '')
				],
			];
		}

		if (self::isFieldNeeded($config, 'text')) {
			$contentFields['content_text'] = [
				'exclude' => 1,
				'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.content_text',
				'config' => [
					'type' => 'text',
					'cols' => 80,
					'rows' => 15,
					'softref' => 'typolink_tag,images,email[subst],url',
					'enableRichtext' => '1',
					'richtextConfiguration' => 'custom',
					'eval' => '' . (self::isFieldRequired($config, 'text') ? ',required' : '')
				],
			];
		}

		if (self::isFieldNeeded($config, 'prologue')) {
			$contentFields['content_prologue'] = [
				'exclude' => 1,
				'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.content_prologue',
				'config' => [
					'type' => 'text',
					'cols' => 80,
					'rows' => 15,
					'softref' => 'typolink_tag,images,email[subst],url',
					'enableRichtext' => '1',
					'richtextConfiguration' => 'custom',
					'eval' => '' . (self::isFieldRequired($config, 'prologue') ? ',required' : '')
				],
			];
		}

		if (self::isFieldNeeded($config, 'epilogue')) {
			$contentFields['content_epilogue'] = [
				'exclude' => 1,
				'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.content_epilogue',
				'config' => [
					'type' => 'text',
					'cols' => 80,
					'rows' => 15,
					'softref' => 'typolink_tag,images,email[subst],url',
					'enableRichtext' => '1',
					'richtextConfiguration' => 'full',
					'eval' => '' . (self::isFieldRequired($config, 'epilogue') ? ',required' : '')
				],
			];
		}

		if (self::isFieldNeeded($config, 'abstract')) {
			$contentFields['content_abstract'] = [
				'exclude' => 1,
				'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.content_abstract',
				'config' => [
					'type' => 'input',
					'size' => 30,
					'max' => 255,
					'eval' => 'trim' . (self::isFieldRequired($config, 'abstract') ? ',required' : '')
				],
			];
		}

		if (self::isFieldNeeded($config, 'googleplay')) {
			$contentFields['content_googleplay'] = [
				'exclude' => 1,
				'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.content_googleplay',
				'config' => [
					'type' => 'input',
					'size' => 30,
					'max' => 255,
					'eval' => 'trim' . (self::isFieldRequired($config, 'googleplay') ? ',required' : '')
				],
			];
		}

		if (self::isFieldNeeded($config, 'applestore')) {
			$contentFields['content_applestore'] = [
				'exclude' => 1,
				'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.content_applestore',
				'config' => [
					'type' => 'input',
					'size' => 30,
					'max' => 255,
					'eval' => 'trim' . (self::isFieldRequired($config, 'applestore') ? ',required' : '')
				],
			];
		}

		if (self::isFieldNeeded($config, 'downloadfile')) {
			$maxItems = self::getConfigValue($config, 'downloadfile', 'maxitems');
			$contentFields['content_downloadfile'] = [
				'exclude' => 1,
				'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.content_downloadfile',
				'config' => ExtensionManagementUtility::getFileFieldTCAConfig('content_downloadfile', [
					'minitems' => (self::isFieldRequired($config, 'downloadfile') ? 1 : 0),
					'maxitem' => $maxItems ? $maxItems : '1',
					'appearance' => [
						'fileUploadAllowed' => false
					],
				],
					self::allowedFileDownloads
				)
			];
		}

		if (self::isFieldNeeded($config, 'downloadfiletext')) {
			$contentFields['content_downloadfiletext'] = [
				'exclude' => 1,
				'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.content_downloadfiletext',
				'config' => [
					'type' => 'input',
					'size' => 30,
					'max' => 40,
					'eval' => 'trim' . (self::isFieldRequired($config, 'downloadfiletext') ? ',required' : '')
				],
			];
		}

		if (self::isFieldNeeded($config, 'downloadlink')) {
			$contentFields['content_downloadlink'] = [
				'exclude' => 1,
				'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.content_downloadlink',
				'config' => [
					'type' => 'input',
					'renderType' => 'inputLink',
					'fieldControl' => [
						'linkPopup' => [
							'options' => [
								'blindLinkFields' => 'class, params, title',
								'blindLinkOptions' => 'mail, page, spec, file, folder'
							]
						]
					],
					'size' => 30,
					'eval' => 'trim' . (self::isFieldRequired($config, 'downloadlink') ? ',required' : '')
				],
			];
		}

		if (self::isFieldNeeded($config, 'downloadlinktext')) {
			$contentFields['content_downloadlinktext'] = [
				'exclude' => 1,
				'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.content_downloadlinktext',
				'config' => [
					'type' => 'input',
					'size' => 30,
					'max' => 40,
					'eval' => 'trim' . (self::isFieldRequired($config, 'downloadlinktext') ? ',required' : '')
				],
			];
		}

		if (self::isFieldNeeded($config, 'stagemedia')) {
			$maxItems = self::getConfigValue($config, 'stagemedia', 'maxitems');

			$contentFields['content_stagemedia'] = [
				'exclude' => 1,
				'l10n_mode' => 'exclude',
				'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.content_stagemedia',
				'config' => ExtensionManagementUtility::getFileFieldTCAConfig('content_stagemedia', [
					// Use the imageoverlayPalette instead of the basicoverlayPalette
					'overrideChildTca' => [
						'types' => [
							'0' => [
								'showitem' => '
									--palette--;;imageoverlayPalette,
									--palette--;;filePalette'
							],
							File::FILETYPE_IMAGE => [
								'showitem' => '
									--palette--;;imageoverlayPalette,
									--palette--;;filePalette'
							],
							File::FILETYPE_VIDEO => [
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
												'3.5 : 1' => [
													'title' => '3.5 : 1',
													'value' => 35 / 10
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
					'minitems' => (self::isFieldRequired($config, 'stagemedia') ? 1 : 0),
					'maxitem' => $maxItems ? $maxItems : '1'
				],
					self::allowedImageExtensions . ',' . self::allowedVideoExtensions . ',' . self::allowedExternalVideoExtensions
				)
			];
		}

		if (self::isFieldNeeded($config, 'image')) {
			$maxItems = self::getConfigValue($config, 'downloadfile', 'maxitems');
			$contentFields['content_image'] = [
				'exclude' => 1,
				'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.content_image',
				'config' => ExtensionManagementUtility::getFileFieldTCAConfig('content_image', [
					// Use the imageoverlayPalette instead of the basicoverlayPalette
					'overrideChildTca' => [
						'types' => [
							'0' => [
								'showitem' => '
									--palette--;;imageoverlayPalette,
									--palette--;;filePalette'
							],
							File::FILETYPE_IMAGE => [
								'showitem' => '
									--palette--;;imageoverlayPalette,
									--palette--;;filePalette'
							]
						]
					],
					'appearance' => [
						'fileUploadAllowed' => false
					],
					'minitems' => (self::isFieldRequired($config, 'image') ? 1 : 0),
					'maxitem' => $maxItems ? $maxItems : '1',
				],
					self::allowedImageExtensions
				)
			];
		}

		if (self::isFieldNeeded($config, 'video')) {
			$maxItems = self::getConfigValue($config, 'video', 'maxitems');
			$contentFields['content_video'] = [
				'exclude' => 1,
				'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.content_video',
				'config' => ExtensionManagementUtility::getFileFieldTCAConfig('content_video', [
					// Use the imageoverlayPalette instead of the basicoverlayPalette
					'overrideChildTca' => [
						'types' => [
							File::FILETYPE_VIDEO => [
								'showitem' => '
								--palette--;LLL:EXT:lang/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.videoOverlayPalette;videoOverlayPalette,
								--palette--;;filePalette'
							],
						]
					],
					'appearance' => [
						'fileUploadAllowed' => false
					],
					'minitems' => (self::isFieldRequired($config, 'video') ? 1 : 0),
					'maxitem' => $maxItems ? $maxItems : '3',
				],
					self::allowedVideoExtensions . ',' . self::allowedExternalVideoExtensions
				)
			];
		}

		if (self::isFieldNeeded($config, 'gallery')) {
			$tableNames = self::getConfigValue($config, 'gallery', 'tablenames');
			if ($tableNames) {
				$contentFields['content_gallery'] = [
					'exclude' => 1,
					'l10n_mode' => 'exclude',
					'label' => "LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.gallery",
					'config' => [
						'type' => 'select',
						'renderType' => 'selectMultipleSideBySide',
						'foreign_table' => 'tx_center_domain_model_misc_gallery',
						'enableMultiSelectFilterTextfield' => true,
						'foreign_table_where' => " AND tx_center_domain_model_misc_gallery.sys_language_uid IN (-1, 0) AND (tx_center_domain_model_misc_gallery.endtime = 0 OR tx_center_domain_model_misc_gallery.endtime > UNIX_TIMESTAMP())",
						'MM' => 'tx_center_domain_model_misc_gallery_record_mm',
						'MM_opposite_field' => 'items',
						'MM_match_fields' => [
							'tablenames' => $tableNames,
							'fieldname' => 'content_gallery',
						],
						'minitems' => (self::isFieldRequired($config, 'gallery') ? 1 : 0),
						'maxitems' => '1'
					]
				];
			}

		}

		return $contentFields;
	}

	/**
	 * Returns the teaser fields to a record.
	 * The fields are:
	 * teaser_format
	 * teaser_abstract
	 * teaser_image
	 * teaser_image2
	 *
	 * @param integer $teaserFormatOptions
	 * @param integer $teaserType
	 * @param bool $teaserFormatNeeded
	 * @param bool $teaserFormatRequired
	 * @param bool $teaserAbstractNeeded
	 * @param bool $teaserAbstractRequired
	 * @param bool $teaserImageRequired
	 * @param bool $teaserImageNeeded
	 * @param int $teaserImageMaxItems
	 * @param bool $teaserVideoEnabled
	 * @return array
	 */
	public static function getTeaserFields($teaserFormatOptions = 3,
										   $teaserType = self::TEASER_TYPE_PROP,
										   $teaserFormatNeeded = true,
										   $teaserFormatRequired = true,
										   $teaserAbstractNeeded = true,
										   $teaserAbstractRequired = true,
										   $teaserImageNeeded = true,
										   $teaserImageRequired = true,
										   $teaserImageMaxItems = 100,
										   $teaserVideoEnabled = true,
                                           $topTeaserInApp = false)
	{

		$overrideChildTca = [
			'types' => [
				'0' => [
					'showitem' => '
									--palette--;;imageoverlayPalette,
									--palette--;;filePalette'
				],
				File::FILETYPE_IMAGE => [
					'showitem' => '
									--palette--;;imageoverlayPalette,
									--palette--;;filePalette'
				]
			]
		];

		if($teaserType) {
			$overrideChildTca['columns' ]['crop'] = [
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
				],
			];
		}


		$teaserFields = [

			'teaser_format' => [
				'exclude' => 1,
				'l10n_mode' => 'exclude',
				'onChange' => 'reload',
				'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.teaser_format',
				'pnpu_description' => [
					'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.teaser.format.InfoText',
					'extensionName' => 'center',
					'arguments' => [
						'2',
						'16:9'
					]
				],
				'config' => [
					'type' => 'select',
					'renderType' => 'selectSingle',
					'default' => '1',
					'items' => [
						['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.teaser_format.1', '1'],
						['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.teaser_format.2', '2'],
						['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.teaser_format.3', '3'],
					],
					'minitems' => ($teaserFormatRequired ? 1 : 0)
				],
			],
			'teaser_abstract' => [
				'exclude' => 1,
				'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.teaser_abstract',
				'config' => [
					'type' => 'input',
					'size' => 30,
					'max' => 255,
					'eval' => 'trim' . ($teaserAbstractRequired ? ', required' : '')
				],
			],
			'teaser_image' => [
				'exclude' => true,
				'l10n_mode' => 'exclude',
				'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.teaser_image',
                'displayCond' => 'FIELD:teaser_format:!=:4',
				'pnpu_description' => [
					'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.teaser_image1.InfoText',
					'extensionName' => 'center',
					'arguments' => [
						'2',
						'16:9'
					]
				],
				'config' => ExtensionManagementUtility::getFileFieldTCAConfig('teaser_image', [
					// Use the imageoverlayPalette instead of the basicoverlayPalette
					'overrideChildTca' => self::changeRatio($overrideChildTca, 1, $teaserType),
					'appearance' => [
						'fileUploadAllowed' => false
					],
					'minitems' => ($teaserImageRequired ? 1 : 0),
					'maxitem' => $teaserImageMaxItems
				],
					self::JPEG_ONLY
				)
			],
			'teaser_image2' => [
				'exclude' => true,
				'l10n_mode' => 'exclude',
				'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.teaser_image2',
				'pnpu_description' => [
					'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.teaser_image2.InfoText',
					'extensionName' => 'center',
					'arguments' => [
						'2',
						'16:9'
					]
				],
				'displayCond' => 'FIELD:teaser_format:=:2',
				'config' => ExtensionManagementUtility::getFileFieldTCAConfig('teaser_image2', [
					// Use the imageoverlayPalette instead of the basicoverlayPalette
					'overrideChildTca' => self::changeRatio($overrideChildTca, 2, $teaserType),
					'appearance' => [
						'fileUploadAllowed' => false
					],
					'minitems' => ($teaserImageRequired ? 1 : 0),
					'maxitem' => $teaserImageMaxItems
				],
					self::JPEG_ONLY
				)
			],
			'teaser_image3' => [
				'exclude' => true,
				'l10n_mode' => 'exclude',
				'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.teaser_image3',
				'pnpu_description' => [
					'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.teaser_image3.InfoText',
					'extensionName' => 'center',
					'arguments' => [
						'2',
						'16:9'
					]
				],
				'displayCond' => 'FIELD:teaser_format:=:3',
				'config' => ExtensionManagementUtility::getFileFieldTCAConfig('teaser_image3', [
					// Use the imageoverlayPalette instead of the basicoverlayPalette
					'overrideChildTca' => self::changeRatio($overrideChildTca, 3, $teaserType),
					'appearance' => [
						'fileUploadAllowed' => false
					],
					'minitems' => ($teaserImageRequired ? 1 : 0),
					'maxitem' => $teaserImageMaxItems
				],
					self::JPEG_ONLY
				)
			],
            'teaser_video' => [
                'exclude' => true,
                'l10n_mode' => 'exclude',
                'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.content_video',
                'displayCond' => 'FIELD:teaser_format:=:1',
                'config' => ExtensionManagementUtility::getFileFieldTCAConfig('teaser_video', [
                    // Use the imageoverlayPalette instead of the basicoverlayPalette
                    'overrideChildTca' => [
                        'types' => [
                            File::FILETYPE_VIDEO => [
                                'showitem' => '
								--palette--;LLL:EXT:lang/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.videoOverlayPalette;videoOverlayPalette,
								--palette--;;filePalette'
                            ],
                        ]
                    ],
                    'appearance' => [
                        'fileUploadAllowed' => false
                    ],
                    'minitems' => 0,
                    'maxitem' => 1,
                ],
                    self::allowedVideoExtensions
                )
            ],
            'top_in_app' => [
                'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.top_in_app',
                'pnpu_description' => [
                    'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.top_in_app.description',
                    'extensionName' => 'center',
                ],
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectSingle',
                    'items' => [
                        ['', 0],
                        ['1', 1],
                        ['2', 2],
                        ['3', 3],
                    ],
                ]
            ],
			//Only used for teaser rendering but not in the BE
			'teaser_category' => [
				'config' => [
					'type' => 'passthrough'
				],
			],
			'teaser_time' => [
				'config' => [
					'type' => 'passthrough'
				],
			],
			'teaser_date' => [
				'config' => [
					'type' => 'passthrough'
				],
			],
		];

		if (!$teaserFormatNeeded) {
			unset($teaserFields['teaser_format']);
		}

		if ($teaserFormatOptions < 3) {
			unset($teaserFields['teaser_format']['config']['items'][2]);
			unset($teaserFields['teaser_image3']);
			if ($teaserFormatOptions < 2) {
				unset($teaserFields['teaser_format']['config']['items'][1]);
				unset($teaserFields['teaser_image2']);
			}
		}

		if (!$teaserImageNeeded) {
			unset($teaserFields['teaser_image']);
			unset($teaserFields['teaser_image2']);
			unset($teaserFields['teaser_image3']);
			unset($teaserFields['teaser_video']);
		}

		if (!$teaserAbstractNeeded) {
			unset($teaserFields['teaser_abstract']);
		}
		if (!$teaserVideoEnabled) {
			unset($teaserFields['teaser_video']);
		}
		if(!$topTeaserInApp) {
            unset($teaserFields['top_in_app']);
        }

		return $teaserFields;
	}

	/**
	 *
	 *
	 * @param array $overrideChildTca
	 * @param int $column currentColumn
	 * @param int $type
	 * @return mixed
	 */
	protected static function changeRatio($overrideChildTca, $column = 1, $type = self::TEASER_TYPE_COVER) {


		if($type === self::TEASER_TYPE_PROP) {
			switch ($column) {
				case 2:
					$ratio = self::RATIO_35_10;
					break;
				default:
					$ratio = self::RATIO_16_9;
					break;
			}
		} else {
			switch ($column) {
				case 3:
					$ratio = self::RATIO_35_10;
					break;
				case 2:
					$ratio = self::RATIO_16_9;
					break;
				default:
					$ratio = self::RATIO_5_6;
					break;
			}
		}
		switch ($ratio) {
			case self::RATIO_16_9:
				$overrideChildTca['columns' ]['crop'] = [
					'config' => [
						'cropVariants' => [
							'default' => [
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
				];
				break;
			case self::RATIO_35_10:
				$overrideChildTca['columns' ]['crop'] = [
					'config' => [
						'cropVariants' => [
							'default' => [
								'title' => 'Default',
								'allowedAspectRatios' => [
									'3.5 : 1' => [
										'title' => '3.5 : 1',
										'value' => 35 / 10
									]
								],
							],
						],
					],
				];
				break;
			case self::RATIO_5_6:
				$overrideChildTca['columns' ]['crop'] = [
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
				];
				break;
		}

		return $overrideChildTca;
	}

	/**
	 * Returns the SEO fields as a tca configuration.
	 * The field names are fix:
	 * seo_title
	 * seo_description
	 *
	 * @param bool $titleRequired
	 * @param bool $descriptionRequired
	 *
	 * @return array
	 */
	public static function getSEOFields($titleRequired = false,
										$descriptionRequired = false)
	{
		$seoFields = [

			'seo_title' => [
				'exclude' => 1,
				'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.seo_title',
				'config' => [
					'type' => 'input',
					'size' => 30,
					'max' => 255,
					'eval' => 'trim' . ($titleRequired ? ', required' : '')
				],
			],
			'seo_description' => [
				'exclude' => 1,
				'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.seo_description',
				'config' => [
					'type' => 'input',
					'size' => 30,
					'max' => 255,
					'eval' => 'trim' . ($descriptionRequired ? ', required' : '')
				],
			]
		];

		return $seoFields;
	}

	/**
	 * @param int $responsibility
	 * @param string $overrideLabel
	 * @param boolean $required
	 *
	 * @return array
	 */
	public static function getContactPersonRelation($responsibility = 0, $overrideLabel = '', $required = false) {
		$fields['contact'] = [
			'exclude' => 1,
			'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.contact',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => [
					['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center.please_select', 0],
				],
				'foreign_table' => 'tx_center_domain_model_misc_contactperson',
                'default' => 0,
				'minitems' => $required ? 1 : 0,
				'maxitems' => 1,
			],
		];

		if($overrideLabel) {
			$fields['contact']['label'] = $overrideLabel;
		}

		if($responsibility) {
			$fields['contact']['config']['foreign_table_where'] = ' FIND_IN_SET(' . $responsibility . ', tx_center_domain_model_misc_contactperson.responsibilities) > 0';
		}

		return $fields;
	}

	/**
	 * @param bool $ogRequired
	 * @param bool $seoRequired
	 * @param bool $teaserRequired
	 * @return array
	 */
	public static function getPalettes($ogRequired = true, $seoRequired = true, $teaserRequired = true)
	{
		$palettes = [];

		if ($teaserRequired) {
			$palettes['teaserPalette'] = ['showitem' => 'teaser_format, --linebreak--, teaser_abstract, --linebreak--, teaser_image, --linebreak--, teaser_image2, --linebreak--, teaser_image3, --linebreak--, teaser_video,--linebreak--, top_in_app'];
		}
		if ($ogRequired) {
			$palettes['ogPalette'] = ['showitem' => 'og_title, og_description, --linebreak--, og_image'];
		}
		if ($seoRequired) {
			$palettes['seoPalette'] = ['showitem' => 'seo_title, --linebreak--, seo_description'];
		}

		return $palettes;

	}

	/**
	 * Returns the basic ctrl, types, columns array to a table and type
	 * The fields supported:
	 * hidden, title, l10n_parent, l10n_diffsource, t3ver_label, starttime, endtime
	 *
	 * @param string $tableName the name of the table in the database
	 * @param string $iconFile (Filename with EXT: path)
	 * @param boolean $onlyOneCenterAllowed - center or center_shops
	 * @param boolean $accessTimeRequired - endtime and starttime are required fields or not default: true
	 * @return array
	 */
	public static function getBasicFieldDefinition($tableName, $iconFile = 'EXT:center/Resources/Public/Icons/ext_icon.png', $onlyOneCenterAllowed = false, $accessTimeRequired = true)
	{
		return [
			'ctrl' => [
				'title' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:' . $tableName,
				'label' => 'title',
				'tstamp' => 'tstamp',
				'crdate' => 'crdate',
				'cruser_id' => 'cruser_id',
				'dividers2tabs' => 1,
				'languageField' => 'sys_language_uid',
				'transOrigPointerField' => 'l10n_parent',
				'transOrigDiffSourceField' => 'l10n_diffsource',
				'delete' => 'deleted',
                'origUid' => 't3_origuid',
				'enablecolumns' => [
					'disabled' => 'hidden',
					'starttime' => 'starttime',
					'endtime' => 'endtime',
				],
				'security' => [
					'ignoreWebMountRestriction' => 1,
					'ignoreRootLevelRestriction' => 1,
				],
				'searchFields' => 'title',
				'iconfile' => $iconFile
			],

			'interface' => [
				'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title',
			],
			'types' => [
				'1' => ['showitem' => ""],
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
						'foreign_table' => "$tableName",
						'foreign_table_where' => "AND $tableName.pid=###CURRENT_PID### AND $tableName.sys_language_uid IN (-1,0)",
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
					],
				],
				'starttime' => [
					'exclude' => 1,
					'l10n_mode' => 'exclude',
					'l10n_display' => 'defaultAsReadonly',
					'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.starttime',
					'config' => [
						'type' => 'input',
						'renderType' => 'inputDateTime',
						'eval' => 'datetime' . ($accessTimeRequired ? ', required' : ''),
                        'default' => 0
					],
				],
				'endtime' => [
					'exclude' => 1,
					'l10n_mode' => 'exclude',
					'l10n_display' => 'defaultAsReadonly',
					'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.endtime',
					'pnpu_description' => [
						'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_event.endtime',
						'extensionName' => 'center',
						'arguments' => [
							'2',
							'16:9'
						]
					],
					'config' => [
						'type' => 'input',
						'renderType' => 'inputDateTime',
						'eval' => 'datetime' . ($accessTimeRequired ? ', required' : ''),
                        'default' => 0
					],
				],
				'title' => [
					'label' => "LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:$tableName.title",
					'config' => [
						'type' => 'input',
						'size' => 30,
						'max' => 255,
						'eval' => 'trim',
					],
				],
                'alternative_title' => [
                    'label' => "LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.alternative_title",
                    'config' => [
                        'type' => 'input',
                        'size' => 30,
                        'max' => 255,
                        'eval' => 'trim',
                    ],
                ],
                'reference_type' => [
                    'label' => "LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.reference_type",
                    'l10n_mode' => 'exclude',
                    'onChange' => 'reload',
                    'config' => [
                        'type' => 'select',
                        'renderType' => 'selectSingle',
                        'items' => [
                            ['Single', 0],
                            ['Multiple', 1],
                        ]
                    ],
                ],
				'shop' => [
					'exclude' => 1,
					'l10n_mode' => 'exclude',
                    'displayCond' => 'FIELD:reference_type:!=:1',
					'label' => "LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_shop_shop",
                    'config' => [
                        'type' => 'select',
                        'renderType' => 'selectSingle',
                        'items' => [
                            ['None', 0]
                        ],
                        'foreign_table' => 'pages',
                        'foreign_table_where' => 'AND pages.center != 0 AND pages.center IN (SELECT tx_center_domain_model_center_center.uid FROM tx_center_domain_model_center_center WHERE tx_center_domain_model_center_center.page_id = ###SITEROOT### AND tx_center_domain_model_center_center.sys_language_uid IN (-1, 0)) AND doktype IN (' . \DigitalZombies\Center\Domain\Model\Shop\Shop::DOKTYPE . ',' . \DigitalZombies\Center\Domain\Model\Shop\Gastro::DOKTYPE . ') ORDER BY pages.title',
                        'maxitems' => 1,
                        'default' => 0
                    ]
				],
                'chain_store' => [
                    'exclude' => 1,
                    'l10n_mode' => 'exclude',
                    'displayCond' => 'FIELD:reference_type:=:1',
                    'label' => "LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_shop_chainstore",
                    'config' => [
                        'type' => 'select',
                        'renderType' => 'selectMultipleSideBySide',
                        'foreign_table' => 'tx_center_domain_model_shop_chainstore',
                        'enableMultiSelectFilterTextfield' => true,
                        'foreign_table_where' => 'AND tx_center_domain_model_shop_chainstore.sys_language_uid IN (-1,0) ORDER BY tx_center_domain_model_shop_chainstore.name',
                        'maxitems' => 1
                    ]
                ],
                'centers' => [
                    'exclude' => 1,
                    'displayCond' => 'FIELD:reference_type:=:1',
                    'l10n_mode' => 'exclude',
                    'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center',
                    'config' => [
                        'type' => 'select',
                        'renderType' => 'selectMultipleSideBySide',
                        'foreign_table' => 'tx_center_domain_model_center_center',
                        'foreign_table_where' => 'tx_center_domain_model_center_center.sys_language_uid IN (-1, 0) ORDER BY tx_center_domain_model_center_center.short_name ASC',
                        'MM' => 'tx_center_domain_model_records_center_mm',
                        'MM_match_fields' => [
                            'tablenames' => $tableName
                        ],
                        'MM_opposite_field' => 'items',
                        'minitems' => 1
                    ],
                ],
                'center' => [
                    'exclude' => 1,
                    'displayCond' => 'FIELD:reference_type:!=:1',
                    'l10n_mode' => 'exclude',
                    'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_center_center',
                    'config' => [
                        'type' => 'select',
                        'renderType' => 'selectSingle',
                        'foreign_table' => 'tx_center_domain_model_center_center',
                        'foreign_table_where' => 'tx_center_domain_model_center_center.page_id = ###SITEROOT### AND tx_center_domain_model_center_center.sys_language_uid IN (-1,0)',
                    ],
                ],
                't3_origuid' => [
                    'config' => [
                        'type' => 'passthrough',
                    ],
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
							['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.hide_in_app.show_always', HideInApp::NO_RESTRICTION],
							['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.hide_in_app.hide_in_app', HideInApp::HIDE_IN_APP],
							['LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.hide_in_app.only_in_app', HideInApp::ONLY_IN_APP],
						],
					]
				]
			]
		];
	}

	/**
	 * Returns the seo tab definition
	 * @param string $fields - comma separated list, just like normal TCA setting
	 * @return string
	 */
	public static function getSEOTab($fields = "")
	{
		return ',--div--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.tabs.seo,--palette--;;seoPalette' . ($fields ? ',' . $fields :'');
	}

	/**
	 * Returns the social media tab definition
	 * @param string $fields - comma separated list, just like normal TCA setting
	 * @return string
	 */
	public static function getSocialMediaTab($fields = "")
	{
		return ',--div--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.tabs.og,--palette--;;ogPalette' . ($fields ? ',' . $fields :'');
	}

	/**
	 * Returns the teaser tab definition
	 * @param string $fields - comma separated list, just like normal TCA setting
	 * @return string
	 */
	public static function getTeaserTab($fields = "")
	{
		return ',--div--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.tabs.teaser,--palette--;;teaserPalette,' . $fields;
	}


	/**
	 * Returns the content tab definition
	 *
	 * @param string $fields - comma separated list, just like normal TCA setting
	 * @return string
	 */
	public static function getContentTab($fields = "")
	{
		return ',--div--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.tabs.content,' . $fields;
	}

	/**
	 * Returns the contact tab definition
	 *
	 * @return string
	 */
	public static function getContactTab()
	{
		return ',--div--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:general.tabs.contact, contact';
	}

	/**
	 * Generates an array of years
	 *
	 * @param integer $interval
	 * @return array
	 */
	public static function generateYears($interval)
	{
		$from = date('Y');
		$years[] = [$from - 1, $from - 1];
		for ($year = $from; $year <= $from + $interval; $year++) {
			$years[] = [$year, $year];
		}
		return $years;
	}

	/**
	 * @param array $config
	 * @param string $fieldName
	 * @return bool
	 */
	protected static function isFieldNeeded($config, $fieldName)
	{
		return isset($config[$fieldName]);
	}

	/**
	 * @param array $config
	 * @param string $fieldName
	 * @return bool
	 */
	protected static function isFieldRequired($config, $fieldName)
	{
		return isset($config[$fieldName]) && isset($config[$fieldName]['required']) && $config[$fieldName]['required'];
	}

	/**
	 * @param array $config
	 * @param string $fieldName
	 * @param string $value
	 * @return mixed|null
	 */
	protected static function getConfigValue($config, $fieldName, $value)
	{
		return (isset($config[$fieldName]) && isset($config[$fieldName][$value]) ? $config[$fieldName][$value] : null);
	}
}