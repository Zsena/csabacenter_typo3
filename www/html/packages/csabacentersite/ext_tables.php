<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('csabacentersite', 'Configuration/TypoScript', 'Provider Extensions');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile('csabacentersite', 'Configuration/PageTS/pageTS.t3s', 'Provider');

// We need more then 20 subgroups for BE usergroups
$TCA['be_groups']['columns']['subgroup']['config']['maxitems'] = 999;


// -- VLOG/BLOG TEASER CONTENT ELEMENT  --
$GLOBALS['TCA']['tx_mask_media_items']['columns']['tx_mask_media']['config']
['overrideChildTca']['columns']['crop']['config']['cropVariants']['largeImage'] = [
    'title' => 'Large image ratio',
    'allowedAspectRatios' => [
        'largeImage' => [
            'title' => '2 : 3',
            'value' => 2 / 3,
        ],
    ]
];
$GLOBALS['TCA']['tx_mask_media_items']['columns']['tx_mask_media']['config']
['overrideChildTca']['columns']['crop']['config']['cropVariants']['mediumImage'] = [
    'title' => 'Medium image ratio',
    'allowedAspectRatios' => [
        'mediumImage' => [
            'title' => '3 : 2',
            'value' => 3 / 2,
        ],
    ]
];
$GLOBALS['TCA']['tx_mask_media_items']['columns']['tx_mask_media']['config']
['overrideChildTca']['columns']['crop']['config']['cropVariants']['smallImage'] = [
    'title' => 'Small image ratio',
    'allowedAspectRatios' => [
        'smallImage' => [
            'title' => '1 : 3',
            'value' => 16 / 21,
        ],
    ]
];
$GLOBALS['TCA']['tx_mask_media_items']['columns']['tx_mask_media']['config']
['overrideChildTca']['columns']['crop']['config']['cropVariants']['fullWidthImage'] = [
    'title' => 'Full width image ratio',
    'allowedAspectRatios' => [
        'fullWidthImage' => [
            'title' => '11 : 7',
            'value' => 11 / 7,
        ],
    ]
];

$GLOBALS['TCA']['tt_content']['types']['mask_info_box']['columnsOverrides']['tx_mask_image']['config']
['overrideChildTca']['columns']['crop']['config']['cropVariants']['desktop'] = [
    'title' => 'Desktop',
    'allowedAspectRatios' => [
        'desktop' => [
            'title' => 'Desktop',
            'value' => 3 / 2,
        ],
    ]
];
