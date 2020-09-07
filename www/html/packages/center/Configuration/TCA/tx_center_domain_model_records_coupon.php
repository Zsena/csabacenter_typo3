<?php
$couponConfig = \DigitalZombies\Center\Utility\TCAFieldHelper::getBasicFieldDefinition(
    \DigitalZombies\Center\Domain\Model\Records\Coupon::TYPE,'EXT:center/Resources/Public/Icons/coupon.svg',false, false);


$couponConfig['columns']['title']['label'] = 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_coupon.couponTitle';
$couponConfig['columns']['title']['config']['eval'] = 'trim, required';
$couponConfig['columns']['starttime']['label'] = 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_coupon.couponStart';
$couponConfig['columns']['endtime']['label'] = 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_coupon.couponEnd';

$couponConfig['columns']['detail_date'] = [
    'exclude' => 1,
    'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_event.detailDate',
    'config' => [
        'type' => 'input',
        'size' => 30,
        'eval' => 'required',
    ],
];

$couponConfig['columns']['detail_date'] = [
    'exclude' => 1,
    'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_event.detailDate',
    'config' => [
        'type' => 'input',
        'size' => 30,
        'eval' => 'required',
    ],
];

/*
 * BEGIN TCAHelper
 * Add extra fields with help of the TCAField Helper.
 */

$contactPerson = \DigitalZombies\Center\Utility\TCAFieldHelper::getContactPersonRelation();
$couponConfig['columns'] = array_merge($couponConfig['columns'], $contactPerson);

$seoFields = \DigitalZombies\Center\Utility\TCAFieldHelper::getSEOFields();
$couponConfig['columns'] = array_merge($couponConfig['columns'], $seoFields);

$ogFields = \DigitalZombies\Center\Utility\TCAFieldHelper::getOGFields();
$couponConfig['columns'] = array_merge($couponConfig['columns'], $ogFields);

$teaserFields = \DigitalZombies\Center\Utility\TCAFieldHelper::getTeaserFields(2,
    \DigitalZombies\Center\Utility\TCAFieldHelper::TEASER_TYPE_PROP,
    true,
    true,
    true,
    true,
    true,
    false,
    100,
    true,
    false);

$couponConfig['columns'] = array_merge($couponConfig['columns'], $teaserFields);

$couponConfig['columns']['teaser_date'] = [
    'exclude' => 1,
    'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_coupon.teaserDateTitle',
    'pnpu_description' => [
        'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_coupon.teaserDate',
        'extensionName' => 'center',
        'arguments' => [
            '2',
            '16:9'
        ]
    ],
    'config' => [
        'type' => 'input',
        'size' => 30,
        'eval' => 'required',
    ],
];

$couponConfig['columns']['coupon_view'] = [
    'exclude' => 1,
    'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_coupon.view',
    'config' => [
        'type' => 'check',
        'items' => [
            '1' => [
                '0' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_coupon.viewDescription'
            ]
        ],
    ]
];

$couponConfig['columns']['coupons_redeemed'] = [
    'exclude' => 1,
    'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_coupon.alreadyRedeemed',
    'pnpu_description' => [
        'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_coupon.alreadyRedeemedDescription',
        'extensionName' => 'center',
        'arguments' => [
            '2',
            '16:9'
        ]
    ],
    'config' => [
        'type' => 'input',
        'size' => 30,
        'max' => 30,
        'readOnly' => true
    ]
];

$couponConfig['columns']['fixed_amount'] = [
    'exclude' => 1,
    'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_coupon.limitedTo',
    'pnpu_description' => [
        'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_coupon.limitedToDescription',
        'extensionName' => 'center',
        'arguments' => [
            '2',
            '16:9'
        ]
    ],
    'config' => [
        'type' => 'input',
        'size' => 30,
        'max' => 30,
    ]
];

$couponConfig['columns']['valid_coupon_message'] = [
    'exclude' => 1,
    'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_coupon.validMessage',
    'config' => [
        'type' => 'text',
        'cols' => 80,
        'rows' => 15,
        'softref' => 'typolink_tag,images,email[subst],url',
        'enableRichtext' => '1',
        'richtextConfiguration' => 'default'
    ],
];

$couponConfig['columns']['image_redeem'] = [
    'exclude' => true,
    'l10n_mode' => 'exclude',
    'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_coupon.imageRedeem',
    'pnpu_description' => [
        'label' => 'LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_coupon.imageRedeemDescription',
        'extensionName' => 'center',
        'arguments' => [
            '2',
            '16:9'
        ]
    ],
    'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('imageRedeem', [
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
                'fileUploadAllowed' => true
            ],
            'minitems' => 0,
            'maxitems' => 1
        ]
    )
];

/*
 * The config array has the name of the field content_<field_name>. (Each field has the prefix "content_")
 * There are always one possible settings:
 * required => it decides if the field should be required or optional. (if it is not defined, the default is false)
 */

$config = [
    'stagemedia' => [],
    'image' => [],
    'abstract' => [
    ],
    'text' => ['required' => true],
    'gallery' => ['tablenames' => 'tx_center_domain_model_records_coupons']
];
$contentFields = \DigitalZombies\Center\Utility\TCAFieldHelper::getContentFields($config);
$couponConfig['columns'] = array_merge($couponConfig['columns'], $contentFields);

$palettes = \DigitalZombies\Center\Utility\TCAFieldHelper::getPalettes();

foreach ($palettes as $paletteName => $paletteConf) {
    $couponConfig['palettes'][$paletteName] = $paletteConf;
}

$couponConfig['palettes']['couponPalette'] = ['showitem' => 'title, --linebreak--, alternative_title, --linebreak--, coupon_view, --linebreak--, fixed_amount, --linebreak--, coupons_redeemed'];


//Type setting for the shop page type only (everything hidden from the page and each needed fields are "white-listed")
$couponConfig['types'][1] = [
    'showitem' => '
 +          --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,--palette--;LLL:EXT:center/Resources/Private/Language/locallang_db.xlf:tx_center_domain_model_records_couponDetails;couponPalette, reference_type, shop, center, chain_store, centers,
 --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden, starttime, endtime, hide_in_app'
        . \DigitalZombies\Center\Utility\TCAFieldHelper::getContentTab('content_stagemedia, detail_date, content_abstract, content_text, content_image,image_redeem,  content_downloadfile, content_gallery')
        . \DigitalZombies\Center\Utility\TCAFieldHelper::getContactTab()
        . \DigitalZombies\Center\Utility\TCAFieldHelper::getSEOTab()
        . \DigitalZombies\Center\Utility\TCAFieldHelper::getSocialMediaTab()
        . \DigitalZombies\Center\Utility\TCAFieldHelper::getTeaserTab('teaser_date')
];


/*
 * END TCAHelper
 */

return $couponConfig;
