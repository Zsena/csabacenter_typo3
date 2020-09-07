<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DigitalZombies.' . $_EXTKEY,
	'GetEventInCalender',
	[
		'Ical' => 'show',

	],
	// non-cacheable actions
	[]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DigitalZombies.' . $_EXTKEY,
	'CenterPlan',
	[
		'Center' => 'showPlan, renderPlanJSON',

	],
	// non-cacheable actions
	[]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DigitalZombies.' . $_EXTKEY,
	'Countdown',
	[
		'Center' => 'showOpening',

	],
	// non-cacheable actions
	[]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DigitalZombies.' . $_EXTKEY,
	'Gallery',
	[
		'Gallery' => 'show, renderGalleryDataAsJson, showPhotoswipeTemplateAction',

	],
	// non-cacheable actions
	[]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DigitalZombies.' . $_EXTKEY,
	'Contactperson',
	[
		'Contactperson' => 'show',

	],
	// non-cacheable actions
	[]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DigitalZombies.' . $_EXTKEY,
	'TeaserWall',
	[
		'RecordBase' => 'list, ajaxList, listShopsFromPageSettings, ajaxListShopsFromSettings, listServicesFromPageSettings',

	],
	// non-cacheable actions
	[]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DigitalZombies.' . $_EXTKEY,
    'TeaserWallInterests',
    [
        'RecordBase' => 'listInterest',

    ],
    // non-cacheable actions
    []
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DigitalZombies.' . $_EXTKEY,
    'Preview',
    [
        'Preview' => 'list, show'
    ],
    [
        'Preview' => 'list, show'
    ]
);


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DigitalZombies.' . $_EXTKEY,
	'TeaserWallJob',
	[
		'RecordBase' => 'list, ajaxList',

	],
	// non-cacheable actions
	[]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DigitalZombies.' . $_EXTKEY,
	'TeaserWallEvent',
	[
		'RecordBase' => 'list, ajaxList',

	],
	// non-cacheable actions
	[]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DigitalZombies.' . $_EXTKEY,
	'TeaserWallNews',
	[
		'RecordBase' => 'list, ajaxList',

	],
	// non-cacheable actions
	[]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DigitalZombies.' . $_EXTKEY,
	'TeaserWallOffer',
	[
		'RecordBase' => 'list, ajaxList',

	],
	// non-cacheable actions
	[]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DigitalZombies.' . $_EXTKEY,
	'TeaserWallService',
	[
		'RecordBase' => 'listServices',

	],
	// non-cacheable actions
	[]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DigitalZombies.' . $_EXTKEY,
	'TeaserWallShop',
	[
		'RecordBase' => 'listShops, ajaxList',

	],
	// non-cacheable actions
	[]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DigitalZombies.' . $_EXTKEY,
	'TeaserWallGastro',
	[
		'RecordBase' => 'listShops, ajaxList',

	],
	// non-cacheable actions
	[]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DigitalZombies.' . $_EXTKEY,
	'ContentMenu',
	[
		'RecordBase' => 'listContentMenu',

	],
	// non-cacheable actions
	[]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DigitalZombies.' . $_EXTKEY,
	'TeaserWallBlog',
	[
		'RecordBase' => 'list, ajaxList'

	],
	// non-cacheable actions
	[]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DigitalZombies.' . $_EXTKEY,
	'TeaserWallBookmarks',
	[
		'RecordBase' => 'listBookmarks'

	],
	// non-cacheable actions
	[]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DigitalZombies.' . $_EXTKEY,
	'Job',
	[
		'Job' => 'show',

	],
	// non-cacheable actions
	[]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DigitalZombies.' . $_EXTKEY,
    'Service',
    [
        'Service' => 'show',

    ],
    // non-cacheable actions
    []
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DigitalZombies.' . $_EXTKEY,
	'Event',
	[
		'Event' => 'show',

	],
	// non-cacheable actions
	[]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DigitalZombies.' . $_EXTKEY,
	'Offer',
	[
		'Offer' => 'show',

	],
	// non-cacheable actions
	[]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DigitalZombies.' . $_EXTKEY,
    'Coupon',
    [
        'Coupon' => 'show',

    ],
    // non-cacheable actions
    []
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DigitalZombies.' . $_EXTKEY,
    'ConfirmCoupon',
    [
        'Coupon' => 'confirm',

    ],
    // non-cacheable actions
    []
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DigitalZombies.' . $_EXTKEY,
    'RedeemCoupon',
    [
        'Coupon' => 'redeem',

    ],
    // non-cacheable actions
    []
);


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DigitalZombies.' . $_EXTKEY,
	'News',
	[
		'News' => 'show',

	],
	// non-cacheable actions
	[]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DigitalZombies.' . $_EXTKEY,
	'ShopFilter',
	[
		'Shop' => 'showFilter'
	],
	// non-cacheable actions
	[]
);


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DigitalZombies.' . $_EXTKEY,
	'HomeTeaserNEP',
	[
		'RecordBase' => 'listHomeTeasers'
	],
	// non-cacheable actions
	[]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DigitalZombies.' . $_EXTKEY,
	'HomeTeaserJobs',
	[
		'RecordBase' => 'listHomeTeasers'

	],
	// non-cacheable actions
	[]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DigitalZombies.' . $_EXTKEY,
	'HomeTeaserOffer',
	[
		'RecordBase' => 'listHomeTeasers'

	],
	// non-cacheable actions
	[]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DigitalZombies.' . $_EXTKEY,
	'HomeTeaserShopGastro',
	[
		'RecordBase' => 'listHomeShopGastroTeasers'
	],
	// non-cacheable actions
	[]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DigitalZombies.' . $_EXTKEY,
	'HomeTeaserService',
	[
		'RecordBase' => 'listHomeServiceTeasers'
	],
	// non-cacheable actions
	[]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DigitalZombies.' . $_EXTKEY,
	'HomeTeaserServiceCategory',
	[
		'Service' => 'listHomeServiceCategoryTeasers'
	],
	// non-cacheable actions
	[]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DigitalZombies.' . $_EXTKEY,
	'HomeTeaserAdTeaser',
	[
		'RecordBase' => 'listHomeAdTeasers'
	],
	// non-cacheable actions
	[]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DigitalZombies.' . $_EXTKEY,
    'Openings',
    [
        'Center' => 'showOpeningAboutCenter',

    ],
    // non-cacheable actions
    []
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DigitalZombies.' . $_EXTKEY,
	'ServiceSearch',
	[
		'RecordBase' => 'ajaxListServicesFromSettings',

	],
	// non-cacheable actions
	[]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DigitalZombies.' . $_EXTKEY,
	'ShopSearch',
	[
		'RecordBase' => 'ajaxListShopsFromSettings',

	],
	// non-cacheable actions
	[]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DigitalZombies.' . $_EXTKEY,
	'ShopListAjax',
	[
		'Shop' => 'ajaxListAll',

	],
	// non-cacheable actions
	[]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DigitalZombies.' . $_EXTKEY,
	'HomeTeaserProducts',
	[
		'Product' => 'listHomeTeasers'

	],
	// non-cacheable actions
	[]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DigitalZombies.' . $_EXTKEY,
	'Bookmarks',
	[
		'Bookmarks' => 'check, uncheck, loadBookmarks',
	],
	// non-cacheable actions
	[]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DigitalZombies.' . $_EXTKEY,
	'Faqs',
	[
		'Faqs' => 'show',
	],
	// non-cacheable actions
	[]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DigitalZombies.' . $_EXTKEY,
    'ReferenceTeaser',
    [
        'Reference' => 'teaser',
    ],
    // non-cacheable actions
    []
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DigitalZombies.' . $_EXTKEY,
    'Reference',
    [
        'Reference' => 'show',
    ],
    // non-cacheable actions
    []
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DigitalZombies.' . $_EXTKEY,
    'HomeTeaserDigitalMallShops',
    [
        'Product' => 'listDigitalMallShops',
	],
    // non-cacheable actions
    []
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'DigitalZombies.' . $_EXTKEY,
    'ShopTheLook',
    [
        'ShopTheLook' => 'show',
    ],
    // non-cacheable actions
    []
);

// David Miltz 01.09.2017: add field l18n_cfg to $rootlinefields so that we can use the function PageUtility::hideNoneTranslated in BreadCrumbViewHelper.
$rootlinefields = &$GLOBALS["TYPO3_CONF_VARS"]["FE"]["addRootLineFields"];
if($rootlinefields != '');
{
    $rootlinefields .= ' , ';
}

$rootlinefields .= 'l18n_cfg';


if (TYPO3_MODE === 'BE') {
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = 'DigitalZombies\Center\Command\ClearDatabaseCommandController';
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = 'DigitalZombies\Center\Command\DeleteGalleryCommandController';
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = 'DigitalZombies\Center\Command\SendEmailOpeningsCommandController';
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = 'DigitalZombies\Center\Command\RecordBaseCommandController';
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = 'DigitalZombies\Center\Command\ClearBookmarksCommandController';
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = 'DigitalZombies\Center\Command\PushNotificationCommandController';
}
$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc'][] = \DigitalZombies\Center\Hooks\DataHandler::class . '->clearCachePostProc';
$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmap_postProcess'][] = \DigitalZombies\Center\Hooks\DataHandler::class;
$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = \DigitalZombies\Center\Hooks\DataHandler::class;
$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][] = \DigitalZombies\Center\Hooks\MetaTagRenderer::class . '->contentPostProc';
$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][] = \DigitalZombies\Center\Hooks\AnalyticsRenderer::class . '->contentPostProc';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-all'][] = \DigitalZombies\Center\Hooks\BodyTitleRenderer::class . '->contentPostProcAll';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-all'][] = \DigitalZombies\Center\Hooks\BookmarksHandler::class . '->contentPostProcAll';
$GLOBALS ['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmapClass'][] = \DigitalZombies\Center\Hooks\DataHandler::class;
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-all'][] = \DigitalZombies\Center\Hooks\EasterEggRenderer::class . '->contentPostProcAll';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_befunc.php']['viewOnClickClass'][] = \DigitalZombies\Center\Hooks\PreviewHandler::class;

$options = [
	'frontend' => \TYPO3\CMS\Core\Cache\Frontend\VariableFrontend::class,
	'backend' => \TYPO3\CMS\Core\Cache\Backend\Typo3DatabaseBackend::class,
	'groups' => ['pages']
];
foreach ($options as $option => $value) {
	// Set cache configuration for base64 images.
	if(!isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['center_base64Image'][$option])) {
		$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['center_base64Image'][$option] = $value;
	}
	if(!isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['center_changequeueitem'][$option])) {
		$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['center_changequeueitem'][$option] = $value;
	}

	// Set cache configuration for base64 images.
	if(!isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['center_svgIcons'][$option])) {
		$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['center_svgIcons'][$option] = $value;
	}
}


/** @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher $signalSlotDispatcher */
$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
$signalSlotDispatcher->connect(
	\TYPO3\CMS\Extbase\Persistence\Generic\Backend::class,
	'beforeGettingObjectData',
	\DigitalZombies\Center\Service\ExtbaseForceLanguage::class,
	'forceLanguageForQueries'
);

$GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']['excludedParameters'][] = 'location';

$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['product_teasers'] = 'EXT:center/Classes/Eid/ProductTeasers.php';
$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['shop_the_look'] = 'EXT:center/Classes/Eid/ShopTheLook.php';
