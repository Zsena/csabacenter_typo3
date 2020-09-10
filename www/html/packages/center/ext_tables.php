<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

call_user_func(
    function ($extKey) {

        //Modules
        if (TYPO3_MODE === 'BE') {

            /**
             * Registers a Backend Module
             */
            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
                'DigitalZombies.' . $extKey,
                'web',
                'center',
                '',
                [
                    'Center' => 'list, clearCache',
                ],
                [
                    'access' => 'user,group',
                    'icon' => 'EXT:' . $extKey . '/Resources/Public/Icons/cache-modul-icon.png',
                    'labels' => 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_module_center.xlf',
                ]
            );

            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
                'DigitalZombies.' . $extKey,
                'web',
                'pushNotification',
                '',
                [
                    'PushNotification' => 'list,publish,delete,dequeue',
                    'Center' => 'backendPushConfigurationList,update',
                ],
                [
                    'access' => 'user,group',
                    'icon' => 'EXT:' . $extKey . '/Resources/Public/Icons/push-modul-icon.png',
                    'labels' => 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_module_pushnotification.xlf',
                ]
            );
        }

        //Plugins

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'Job',
            'Job Detail Plugin'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'Service',
            'Service Detail Plugin'
        );


        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'Event',
            'Event Detail Plugin'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'Offer',
            'Offer Detail Plugin'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'Coupon',
            'Coupon Detail Plugin'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'ConfirmCoupon',
            'Coupon Detail Plugin Step 2'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'RedeemCoupon',
            'Coupon Detail Plugin Step 3'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'News',
            'News/Press Detail Plugin'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'Gallery',
            'Gallery Plugin'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'Contactperson',
            'Contactperson Plugin'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'Openings',
            'Openings About Center Plugin'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'ShopFilter',
            'Shop Filter Plugin'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'CenterPlan',
            'Center Plan Plugin'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'TeaserWall',
            'TeaserWall Plugin'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'TeaserWallJob',
            'TeaserWall Job Plugin'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'TeaserWallEvent',
            'TeaserWall Event Plugin'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'TeaserWallService',
            'TeaserWall Service Plugin'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'TeaserWallNews',
            'TeaserWall News Plugin'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'TeaserWallInterests',
            'Interests Slider Plugin'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'Preview',
            'Preview Plugin'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'TeaserWallOffer',
            'TeaserWall Offer Plugin'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'TeaserWallShop',
            'TeaserWall Shop Plugin'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'TeaserWallGastro',
            'TeaserWall Gastro Plugin'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'TeaserWallBlog',
            'TeaserWall Blog Plugin'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'ContentMenu',
            'Content Menu Plugin'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'GetEventInCalender',
            'Ical File download'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'Bookmarks',
            'Bookmarks'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'TeaserWallBookmarks',
            'TeaserWall Bookmarks Plugin'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'Faqs',
            'FAQs Plugin'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'ReferenceTeaser',
            'Reference Teaser'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'Reference',
            'Reference Detail'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'ShopTheLook',
            'Shop The Look Plugin'
        );

        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$extKey . '_teaserwall'] = 'pi_flexform';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$extKey . '_teaserwalljob'] = 'pi_flexform';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$extKey . '_teaserwallevent'] = 'pi_flexform';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$extKey . '_teaserwallservice'] = 'pi_flexform';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$extKey . '_teaserwalloffer'] = 'pi_flexform';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$extKey . '_teaserwallnews'] = 'pi_flexform';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$extKey . '_teaserwallinterests'] = 'pi_flexform';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$extKey . '_teaserwallshop'] = 'pi_flexform';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$extKey . '_teaserwallgastro'] = 'pi_flexform';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$extKey . '_teaserwallblog'] = 'pi_flexform';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$extKey . '_teaserwallbookmarks'] = 'pi_flexform';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$extKey . '_faqs'] = 'pi_flexform';

        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$extKey . '_gallery'] = 'pi_flexform';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$extKey . '_contactperson'] = 'pi_flexform';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$extKey . '_shopfilter'] = 'pi_flexform';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$extKey . '_openings'] = 'pi_flexform';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$extKey . '_contentmenu'] = 'pi_flexform';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$extKey . '_referenceteaser'] = 'pi_flexform';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$extKey . '_referencedetail'] = 'pi_flexform';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$extKey . '_shopthelook'] = 'pi_flexform';

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($extKey . '_teaserwall',
            'FILE:EXT:' . $extKey . '/Configuration/FlexForms/flexform_teaserwall.xml');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($extKey . '_teaserwalljob',
            'FILE:EXT:' . $extKey . '/Configuration/FlexForms/flexform_teaserwalljob.xml');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($extKey . '_teaserwallevent',
            'FILE:EXT:' . $extKey . '/Configuration/FlexForms/flexform_teaserwallevent.xml');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($extKey . '_teaserwallservice',
            'FILE:EXT:' . $extKey . '/Configuration/FlexForms/flexform_teaserwallservice.xml');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($extKey . '_teaserwalloffer',
            'FILE:EXT:' . $extKey . '/Configuration/FlexForms/flexform_teaserwalloffer.xml');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($extKey . '_teaserwallnews',
            'FILE:EXT:' . $extKey . '/Configuration/FlexForms/flexform_teaserwallnews.xml');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($extKey . '_teaserwallinterests',
            'FILE:EXT:' . $extKey . '/Configuration/FlexForms/flexform_teaserwallinterests.xml');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($extKey . '_teaserwallshop',
            'FILE:EXT:' . $extKey . '/Configuration/FlexForms/flexform_teaserwallshop.xml');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($extKey . '_teaserwallgastro',
            'FILE:EXT:' . $extKey . '/Configuration/FlexForms/flexform_teaserwallgastro.xml');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($extKey . '_teaserwallblog',
            'FILE:EXT:' . $extKey . '/Configuration/FlexForms/flexform_teaserwallblog.xml');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($extKey . '_teaserwallbookmarks',
            'FILE:EXT:' . $extKey . '/Configuration/FlexForms/flexform_teaserwallbookmarks.xml');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($extKey . '_faqs',
            'FILE:EXT:' . $extKey . '/Configuration/FlexForms/flexform_faqs.xml');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($extKey . '_openings',
            'FILE:EXT:' . $extKey . '/Configuration/FlexForms/flexform_openings.xml');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($extKey . '_contentmenu',
            'FILE:EXT:' . $extKey . '/Configuration/FlexForms/flexform_contentmenu.xml');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($extKey . '_referenceteaser',
            'FILE:EXT:' . $extKey . '/Configuration/FlexForms/flexform_referenceteaser.xml');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($extKey . '_shopthelook',
            'FILE:EXT:' . $extKey . '/Configuration/FlexForms/flexform_shopthelook.xml');

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'HomeTeaserNEP',
            'Home Teaser News, Events, Press'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'HomeTeaserJobs',
            'Home Teaser Jobs'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'HomeTeaserOffer',
            'Home Teaser Offer'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'HomeTeaserShopGastro',
            'Home Teaser ShopGastro'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'HomeTeaserService',
            'Home Teaser Service'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'HomeTeaserServiceCategory',
            'Home Teaser Service Category'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'HomeTeaserAdTeaser',
            'Home Teaser AdTeaser'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'HomeTeaserProducts',
            'Home Teaser Products'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'HomeTeaserDigitalMallShops',
            'Home Teaser Digital Mall Shops'
        );

        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$extKey . '_hometeasernep'] = 'pi_flexform';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$extKey . '_hometeaserjobs'] = 'pi_flexform';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$extKey . '_hometeaseroffer'] = 'pi_flexform';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$extKey . '_hometeasershopgastro'] = 'pi_flexform';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$extKey . '_hometeaserservice'] = 'pi_flexform';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$extKey . '_hometeaserservicecategory'] = 'pi_flexform';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$extKey . '_hometeaseradteaser'] = 'pi_flexform';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$extKey . '_hometeaserproducts'] = 'pi_flexform';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$extKey . '_hometeaserproducts'] = 'pi_flexform';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$extKey . '_hometeaserdigitalmallshops'] = 'pi_flexform';

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($extKey . '_hometeasernep',
            'FILE:EXT:' . $extKey . '/Configuration/FlexForms/flexform_hometeaser_news-press-event.xml');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($extKey . '_hometeaserjobs',
            'FILE:EXT:' . $extKey . '/Configuration/FlexForms/flexform_hometeaser_jobs.xml');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($extKey . '_hometeaseroffer',
            'FILE:EXT:' . $extKey . '/Configuration/FlexForms/flexform_hometeaser_offer.xml');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($extKey . '_hometeasershopgastro',
            'FILE:EXT:' . $extKey . '/Configuration/FlexForms/flexform_hometeaser_shopgastro.xml');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($extKey . '_hometeaserservice',
            'FILE:EXT:' . $extKey . '/Configuration/FlexForms/flexform_hometeaser_service.xml');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($extKey . '_hometeaserservicecategory',
            'FILE:EXT:' . $extKey . '/Configuration/FlexForms/flexform_hometeaser_servicecategory.xml');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($extKey . '_hometeaseradteaser',
            'FILE:EXT:' . $extKey . '/Configuration/FlexForms/flexform_hometeaser_adteaser.xml');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($extKey . '_hometeaserproducts',
            'FILE:EXT:' . $extKey . '/Configuration/FlexForms/flexform_hometeaser_products.xml');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($extKey . '_hometeaserdigitalmallshops',
            'FILE:EXT:' . $extKey . '/Configuration/FlexForms/flexform_hometeaser_digitalmallshops.xml');


        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($extKey . '_gallery',
            'FILE:EXT:' . $extKey . '/Configuration/FlexForms/flexform_gallery.xml');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($extKey . '_contactperson',
            'FILE:EXT:' . $extKey . '/Configuration/FlexForms/flexform_contactperson.xml');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($extKey . '_shopfilter',
            'FILE:EXT:' . $extKey . '/Configuration/FlexForms/flexform_shopfilter.xml');

        //Icons

        $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);

        // Provide shop icon for page tree, list view, ... :
        $iconRegistry
            ->registerIcon(
                'apps-pagetree-shop',
                TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
                [
                    'source' => 'EXT:' . $extKey . '/Resources/Public/Icons/shop.png',
                ]
            );

        // Provide gastro icon for page tree, list view, ... :
        $iconRegistry
            ->registerIcon(
                'apps-pagetree-gastro',
                TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
                [
                    'source' => 'EXT:' . $extKey . '/Resources/Public/Icons/ice-cream-shop.png',
                ]
            );

        // Provide blog icon for page tree, list view, ... :
        $iconRegistry
            ->registerIcon(
                'apps-pagetree-blog',
                TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
                [
                    'source' => 'EXT:' . $extKey . '/Resources/Public/Icons/blog.svg',
                ]
            );

        $iconRegistry
            ->registerIcon(
                'records-event',
                TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
                [
                    'source' => 'EXT:' . $extKey . '/Resources/Public/Icons/event.svg',
                ]
            );

        $iconRegistry
            ->registerIcon(
                'records-jobs',
                TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
                [
                    'source' => 'EXT:' . $extKey . '/Resources/Public/Icons/job.svg',
                ]
            );

        $iconRegistry
            ->registerIcon(
                'records-offer',
                TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
                [
                    'source' => 'EXT:' . $extKey . '/Resources/Public/Icons/offer.svg',
                ]
            );
        $iconRegistry
            ->registerIcon(
                'records-coupon',
                TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
                [
                    'source' => 'EXT:' . $extKey . '/Resources/Public/Icons/coupon.svg',
                ]
            );

        $iconRegistry
            ->registerIcon(
                'records-service',
                TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
                [
                    'source' => 'EXT:' . $extKey . '/Resources/Public/Icons/service.svg',
                ]
            );

        $iconRegistry
            ->registerIcon(
                'records-blog',
                TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
                [
                    'source' => 'EXT:' . $extKey . '/Resources/Public/Icons/blog.svg',
                ]
            );

        $iconRegistry
            ->registerIcon(
                'records-reference',
                TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
                [
                    'source' => 'EXT:' . $extKey . '/Resources/Public/Icons/research.svg',
                ]
            );

        $iconRegistry
            ->registerIcon(
                'records-default',
                TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
                [
                    'source' => 'EXT:' . $extKey . '/Resources/Public/Icons/ext_icon.png',
                ]
            );
        //PageTypes

        $shopDoktype = \DigitalZombies\Center\Domain\Model\Shop\Shop::DOKTYPE;
        $gastroDoktype = \DigitalZombies\Center\Domain\Model\Shop\Gastro::DOKTYPE;
        $blogDoktype = \DigitalZombies\Center\Domain\Model\Records\Blog::DOKTYPE;
        $serviceListDokType = \DigitalZombies\Center\Domain\Model\Records\Service::LIST_DOKTYPE;

        // Add new page types:
        $GLOBALS['PAGES_TYPES'][$shopDoktype] = [
            'type' => 'web',
            'allowedTables' => '*',
        ];
        // Add new page types:
        $GLOBALS['PAGES_TYPES'][$serviceListDokType] = [
            'type' => 'web',
            'allowedTables' => '*',
        ];
        $GLOBALS['PAGES_TYPES'][$gastroDoktype] = $GLOBALS['PAGES_TYPES'][$shopDoktype];
        $GLOBALS['PAGES_TYPES'][$blogDoktype] = $GLOBALS['PAGES_TYPES'][$shopDoktype];

        // Allow backend users to drag and drop the new page type:
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig(
            'options.pageTree.doktypesToShowInNewPageDragArea := addToList(' . $shopDoktype . ',' . $gastroDoktype . ',' . $blogDoktype . ',' . $serviceListDokType . ')'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($extKey, 'Configuration/TypoScript',
            'Center management');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile('center',
            'Configuration/TSConfig/page.t3s', 'Centermanager extension');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig("<INCLUDE_TYPOSCRIPT: source=\"FILE:EXT:center/Configuration/TSConfig/linkHandler.t3s\">");

        $GLOBALS['PAGES_TYPES']['default']['allowedTables'] .= ",tx_center_domain_model_center_appstorelink, tx_center_domain_model_center_centerlevel, 
			tx_center_domain_model_center_centerlevelposition, tx_center_domain_model_center_socialchannel, tx_center_domain_model_center_payment, 
			tx_center_domain_model_center_shipping, tx_center_domain_model_openinghours_dailyhours, tx_center_domain_model_openinghours_specialclosingday, 
			tx_center_domain_model_openinghours_yearlyschedule, tx_center_domain_model_center_paymentonlineshop";
    },
    $_EXTKEY
);
